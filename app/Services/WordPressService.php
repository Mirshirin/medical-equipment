<?php

namespace App\Services;


use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Device;
use GuzzleHttp\Client;
use App\Models\Country;

use App\Models\Equipment;
use Morilog\Jalali\Jalalian;

use App\Models\SupplierCompany;
use GuzzleHttp\Promise\Promise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WordPressService
{ 
    // متد برای دریافت برندها، کشورها و تخصص‌ها
     public function getDataFromWordPress()
    {
        try { 
                // اجرای query برای گرفتن ترم‌های مربوط به taxonomy 'equipment'
                    $devicess = DB::connection('wordpress')->table('terms')
                    ->whereIn('term_id', function ($query) {
                        $query->select('term_id')
                            ->from('term_taxonomy')
                            ->where('taxonomy', 'equipment');
                    })
                    ->get();
                   // dd(   $devicess);
                // ذخیره داده‌ها در پایگاه داده Laravel
                foreach ($devicess  as $equipment) {
                    Device::create([
                        'id' => $equipment->term_id,
                        'name' => $equipment->name
                    ]);
                }
            // $supplierCompanies  = $this->getPagedDataFromApi('supplier-company');
            // foreach ($supplierCompanies  as $supplierCompany) {
            //     // اطمینان از اینکه مقدار 'id' و 'name' موجود هستند
            //     if (isset($supplierCompany['id']) && isset($supplierCompany['name'])) {
            //         SupplierCompany::updateOrCreate(
            //             ['id' => $supplierCompany['id']],  // اگر کشور با این شناسه موجود است، بروزرسانی می‌شود
            //             ['name' => $supplierCompany['name']]   // ذخیره نام کشور
            //         );
            //     }
            // }       
            // $countries  = $this->getPagedDataFromApi('country');
            // foreach ($countries  as $country) {
            //     // اطمینان از اینکه مقدار 'id' و 'name' موجود هستند
            //     if (isset($country['id']) && isset($country['name'])) {
            //         Country::updateOrCreate(
            //             ['id' => $country['id']],  // اگر کشور با این شناسه موجود است، بروزرسانی می‌شود
            //             ['name' => $country['name']]   // ذخیره نام کشور
            //         );
            //     }
            // }          
            // $brands  = $this->getPagedDataFromApi('brand');
            // //ذخیره برندها
            // foreach ( $brands  as $brandData) {
            //     if (isset($brandData['id']) && isset($brandData['name'])) {
            //         Brand::updateOrCreate(
            //             ['id' => $brandData['id']], // اگر شناسه مشابه وجود داشته باشد، آن را بروزرسانی می‌کند
            //             ['name' => $brandData['name']]
            //         );
            //     }
            // }
            // // دخیره تخصص ها
            // $medicalSpecialties  = $this->getPagedDataFromApi('medical-specialties');
            // foreach ($medicalSpecialties  as $medicalSpecialty) {
            //     if (isset($medicalSpecialty['parent']) && $medicalSpecialty['parent'] == 0) {
            //         MedicalSpecialty::updateOrCreate(
            //             ['id' => $medicalSpecialty['id']],  
            //             [
            //                 'name' => $medicalSpecialty['name'],
            //                 'parent' => $medicalSpecialty['parent']
            //             ]
            //         );
            //     } else {
            //         // Handle case where 'parent' is not set or is null
            //         MedicalSpecialty::updateOrCreate(
            //             ['id' => $medicalSpecialty['id']],  
            //             ['name' => $medicalSpecialty['name']]
            //         );
            //     }
            // }
            // foreach ($medicalSpecialties as $medicalSpecialty) {
            //     if (isset($medicalSpecialty['id']) && isset($medicalSpecialty['name'])) {
            //         // پیدا کردن رکورد با parent_id
            //         $medicalSpecialtyRecord = MedicalSpecialty::where('id', $medicalSpecialty['id'])->first(); 
                    
            //         if ($medicalSpecialtyRecord) {
            //             // بروزرسانی parent_id با مقدار جدید
            //             $medicalSpecialtyRecord->update([
            //                 'parent' => $medicalSpecialty['parent'] // به روزرسانی parent_id
            //             ]);
            //         } else {
            //             // اگر رکورد پیدا نشد
            //             Log::error("Medical Specialty with ID {$medicalSpecialty['id']} not found.");
            //         }
            //     }
            // }
           
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
      
    public function getEquipments()
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
     
        return  $jwtToken  ;
    }
}
