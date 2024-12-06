<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Brand;
use GuzzleHttp\Client;
use App\Models\Country;
use App\Models\Equipment;

use Morilog\Jalali\Jalalian;
use App\Models\MedicalSpecialty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WordPressService
{ 
    // متد برای دریافت برندها، کشورها و تخصص‌ها
     public function getDataFromWordPress()
    {
        try {    
            $countries  = $this->getPagedDataFromApi('country');
            foreach ($countries  as $country) {
                // اطمینان از اینکه مقدار 'id' و 'name' موجود هستند
                if (isset($country['id']) && isset($country['name'])) {
                    Country::updateOrCreate(
                        ['id' => $country['id']],  // اگر کشور با این شناسه موجود است، بروزرسانی می‌شود
                        ['name' => $country['name']]   // ذخیره نام کشور
                    );
                }
            }          
            $brands  = $this->getPagedDataFromApi('brand');
            //ذخیره برندها
            foreach ( $brands  as $brandData) {
                if (isset($brandData['id']) && isset($brandData['name'])) {
                    Brand::updateOrCreate(
                        ['id' => $brandData['id']], // اگر شناسه مشابه وجود داشته باشد، آن را بروزرسانی می‌کند
                        ['name' => $brandData['name']]
                    );
                }
            }
            // دخیره تخصص ها
            $medicalSpecialties  = $this->getPagedDataFromApi('medical-specialties');
            foreach ($medicalSpecialties  as $medicalSpecialty) {
                if (isset($medicalSpecialty['parent']) && $medicalSpecialty['parent'] == 0) {
                    MedicalSpecialty::updateOrCreate(
                        ['id' => $medicalSpecialty['id']],  
                        [
                            'name' => $medicalSpecialty['name'],
                            'parent' => $medicalSpecialty['parent']
                        ]
                    );
                } else {
                    // Handle case where 'parent' is not set or is null
                    MedicalSpecialty::updateOrCreate(
                        ['id' => $medicalSpecialty['id']],  
                        ['name' => $medicalSpecialty['name']]
                    );
                }
            }
            foreach ($medicalSpecialties as $medicalSpecialty) {
                if (isset($medicalSpecialty['id']) && isset($medicalSpecialty['name'])) {
                    // پیدا کردن رکورد با parent_id
                    $medicalSpecialtyRecord = MedicalSpecialty::where('id', $medicalSpecialty['id'])->first(); 
                    
                    if ($medicalSpecialtyRecord) {
                        // بروزرسانی parent_id با مقدار جدید
                        $medicalSpecialtyRecord->update([
                            'parent' => $medicalSpecialty['parent'] // به روزرسانی parent_id
                        ]);
                    } else {
                        // اگر رکورد پیدا نشد
                        Log::error("Medical Specialty with ID {$medicalSpecialty['id']} not found.");
                    }
                }
            }
           
            return response()->json(['message' => 'Data saved successfully']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // تابع برای دریافت داده‌ها از API وردپرس به صورت صفحه‌بندی
    private function getPagedDataFromApi($type)
    {
        $allData = [];
        $page = 1;
        $perPage = 100;

        do {
            $response = Http::get("http://equipment.ir/wp-json/wp/v2/{$type}", [
                'page' => $page,
                'per_page' => $perPage,
            ]);

            if ($response->failed()) {
                throw new \Exception("Failed to fetch {$type} data from WordPress API");
            }

            $data = $response->json();
            $allData = array_merge($allData, $data);
                
            // بررسی اینکه آیا صفحات بیشتری وجود دارند
            $totalPages = $response->header('X-WP-TotalPages');
            $page++;

        } while ($page <= $totalPages);
      
       
      
       return $allData;

    }
    // متد برای دریافت تجهیزات
    public function getEquipments($brandIds, $countryIds, $expertiseIds)
    {
       //Equipment::query()->delete();
    //dd('stop');
        $user = DB::connection('wordpress')->table('users')->where('user_login', 'ptrsrcir')->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $client = new Client();
        $response = $client->post('http://equipment.ir/wp-json/jwt-auth/v1/token', [
            'json' => [
                'username' => $user->user_login,
                'password' => 'PtRrRc#!$03#',
            ]
        ]);
    
        $responseBody = json_decode($response->getBody()->getContents());
    
        if (isset($responseBody->token)) {
            $jwtToken = $responseBody->token;  // توکن JWT دریافتی
        } else {
            return response()->json(['error' => 'Failed to retrieve JWT token'], 500);
        }           
        // نمایش داده‌های پاسخ
        $page = 1;  // شروع با صفحه اول
        $perPage = 20;  // تعداد داده‌ها در هر صفحه
        $allData = [];  // آرایه برای نگهداری تمامی داده‌ها
        
        do {
            // ارسال درخواست GET برای صفحه جاری
            $response = Http::get("http://equipment.ir/wp-json/wp/v2/equipment", [
                'page' => $page,
                'per_page' => $perPage,
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken,  // افزودن هدر توکن JWT
                ]
            ]);
        
            // بررسی موفقیت درخواست
            if ($response->failed()) {
                throw new \Exception("Failed to fetch equipment data from WordPress API");
            }
        
            // دریافت داده‌های صفحه جاری
            $data = $response->json();
        
            // ذخیره داده‌ها در آرایه
            $allData = array_merge($allData, $data);
        
            // لاگ گرفتن از شماره صفحه
            Log::info("Number Page: {$page}");
        
            // ذخیره داده‌ها در دیتابیس
            foreach ($data as $equipment) {  

              
                $shamsiDate = $equipment['acf']['تاریخ_اعتبار_نمایندگی'] ?? null;
                Log::info("shamsiDate: {$shamsiDate}");         
                // بررسی اگر تاریخ شمسی موجود باشد
                if ($shamsiDate) {
                    // تبدیل تاریخ به فرمت مناسب (با خط تیره)
                    $formattedDate = substr($shamsiDate, 0, 4) . '-' . substr($shamsiDate, 4, 2) . '-' . substr($shamsiDate, 6, 2);
                    Log::info("formattedDate: {$formattedDate}"); 
                    // بررسی اعتبار تاریخ شمسی
                    $isValidDate = Carbon::createFromFormat('Y-m-d', $formattedDate)->isValid();
                    Log::info("isValidDate : {$isValidDate }"); 
                    if (!$isValidDate) {
                        // تاریخ نامعتبر است، یک روز از تاریخ کم می‌کنیم
                        $certificateDate = Carbon::createFromFormat('Y-m-d', $formattedDate)->subDay()->toDateString();
                       // echo "Updated Certificate Date: " . $certificateDate;
                        Log::info("certificateDate : {$certificateDate }"); 
                    } else {
                        // تاریخ معتبر است
                        //echo "Valid Certificate Date: " . $formattedDate;
                        Log::info("formattedDate : {$formattedDate }"); 
                    }
                
                    // تبدیل تاریخ شمسی به میلادی
                    try {
                        $gregorianDate = Jalalian::fromFormat('Y-m-d', $formattedDate)->toCarbon()->format('Y-m-d');
                       // echo "Gregorian Date: " . $gregorianDate;
                    } catch (\Exception $e) {
                        Log::info("error : {$e->getMessage() }"); 

                       // echo "Error in date conversion: " . $e->getMessage();
                    }
                    
                } else {
                    // در صورتی که تاریخ موجود نباشد، مقدار null برای میلادی در نظر گرفته می‌شود
                    $gregorianDate = null;
                   // echo "No certificate date provided.";
                }
                $equipmentModel =  \App\Models\Equipment::updateOrCreate(  
                                      
                    ['id' => $equipment['id']],  // استفاده از شناسه برای جلوگیری از تکرار
                    [
                        'status' => $equipment['status'],
                        'date' => $equipment['date'],
                        'type' => $equipment['type'],
                        'equipment_name' => $equipment['acf']['equipment_name'] ?? null,
                        'device_model' => $equipment['acf']['مدل_وسیله'] ?? null,
                        //'brand_id' => $equipment['acf']['برند'][0] ?? null,
                       // 'medical_specialties_id' => $equipment['medical-specialties'][0] ?? null,
                       // 'country_id' => $equipment['acf']['کشور_سازنده'][0] ?? null,
                        'supplier_company_id' => $equipment['acf']['شرکت_تامین_کننده'] ?? null,
                        'supplier_status_is' => $equipment['acf']['نوع_تامین_کننده'] ?? null,
                        'history_working' => $equipment['acf']['سابقه_همکاری'] ?? null,
                        'query_price' => $equipment['acf']['قیمت_استعلامی'] ?? null,
                        'query_date' => $equipment['acf']['تاریخ_استعلام'] ?? null,
                        'purchase_price' => $equipment['acf']['قیمت_خرید'] ?? null,
                        'purchase_date' => $equipment['acf']['تاریخ_خرید'] ?? null,
                        'certificate_date' => $gregorianDate,
                        'salesman_agent' => $equipment['acf']['نام_نماینده'] ?? null,
                        'salesman_phone' => $equipment['acf']['تلفن_همراه'] ?? null,
                        'description' => $equipment['acf']['توضیحات'] ?? null,
                    ]
                );
                Log::info("Inserted Equipment ID: {$equipment['id']}"); 
                if (isset($equipment['acf']['برند'][0])) {
                    $equipmentModel->brands()->attach($equipment['acf']['برند'][0]);
                } else {
                    Log::info("No brand available for Equipment ID: {$equipment['id']}");
                }
                // بررسی کنید که آیا کشور سازنده وجود دارد و آرایه است
                if (isset($equipment['acf']['کشور_سازنده']) && is_array($equipment['acf']['کشور_سازنده']) && isset($equipment['acf']['کشور_سازنده'][0])) {
                    $countryId = $equipment['acf']['کشور_سازنده'][0];

                    if (\App\Models\Country::find($countryId)) {
                        // اگر کشور در جدول countries موجود باشد، آن را به جدول واسط equipment_country اضافه می‌کنیم
                        $equipmentModel->countries()->attach($countryId);
                    } else {
                        // در صورتی که کشور موجود نباشد، کشور جدید را ایجاد می‌کنیم
                        $countryName = 'نام کشور'; // باید نام واقعی کشور را از داده‌های مناسب بگیرید
                        \App\Models\Country::create([
                            'id' => $countryId,  // اگر id باید مشخص باشد، از آن استفاده کنید
                            'name' => $countryName // نام کشور را از داده‌های مرتبط وارد کنید
                        ]);
                        // پس از ایجاد کشور، آن را به جدول واسط اضافه می‌کنیم
                        $equipmentModel->countries()->attach($countryId);

                        Log::info("No country available for Equipment ID: {$equipment['id']}. Country with ID {$countryId} created.");
                    }
                } else {
                    Log::info("No valid country data for Equipment ID: {$equipment['id']}");
                }

                if (isset($equipment['medical-specialties'][0] )) {
                    // اضافه کردن تخصص به تجهیز در جدول واسط equipment_country
                    $equipmentModel->medicalSpecialties()->attach($equipment['medical-specialties'][0] );
                } else {
                    Log::info("No speciality available for Equipment ID: {$equipment['id']}");
                }            
            }
        //dd('stop');
            // بررسی تعداد صفحات موجود از هدر X-WP-TotalPages
            $totalPages = $response->header('X-WP-TotalPages');
            
            // افزایش شماره صفحه برای صفحه بعدی
            $page++;
        
            // لاگ گرفتن از تعداد صفحات برای بررسی
            Log::info("Total Pages: {$totalPages}, Current Page: {$page}");
        
        } while ($page <= $totalPages);  // ادامه دادن حلقه تا زمانی که صفحه بعدی وجود داشته باشد
               
        return true ;
    }
}
