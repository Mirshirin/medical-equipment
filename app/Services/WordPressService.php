<?php
namespace App\Services;

use App\Models\Brand;
use App\Models\Country;
use App\Models\Expertise;
use App\Models\MedicalSpecialty;
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

    // تابع برای دریافت داده‌ها از API وردپرس (بدون صفحه‌بندی)
    private function getDataFromApi($type)
    {
        $response = Http::get("http://equipment.ir/wp-json/wp/v2/{$type}");

        if ($response->failed()) {
            throw new \Exception("Failed to fetch {$type} data from WordPress API");
        }
       
        return $response->json();
    }

  //  متد برای ذخیره داده‌ها در
//    public function saveData($allData)
//     {
//         //ذخیره برندها
//         foreach ($allData as $brandData) {
//             if (isset($brandData['id']) && isset($brandData['name'])) {
//                 Brand::updateOrCreate(
//                     ['id' => $brandData['id']], // اگر شناسه مشابه وجود داشته باشد، آن را بروزرسانی می‌کند
//                     ['name' => $brandData['name']]
//                 );
//             }
//         }

        
//       //dd($allData);
   
//         // ذخیره کشورها
//         foreach ($allData as $country) {
//             // اطمینان از اینکه مقدار 'id' و 'name' موجود هستند
//             if (isset($country['id']) && isset($country['name'])) {
//                 Country::updateOrCreate(
//                     ['id' => $country['id']],  // اگر کشور با این شناسه موجود است، بروزرسانی می‌شود
//                     ['name' => $country['name']]   // ذخیره نام کشور
//                 );
//             }
//         }
        
   

//         // // ذخیره تخصص‌ها (در صورت نیاز)
//         // foreach ($data['expertises'] as $expertise) {
//         //     Expertise::updateOrCreate(
//         //         ['name' => $expertise['name']],
//         //         ['name' => $expertise['name']]
//         //     );
//         // }

//         return response()->json(['message' => 'All data saved successfully']);
//     } 
    

    // متد برای دریافت تجهیزات
    public function getEquipments($brandIds, $countryIds, $expertiseIds)
    {
        $response = Http::get('http://equipment.ir/wp-json/wp/v2/equipment', [
            'brand' => implode(',', $brandIds),  // ارسال شناسه‌های برندها
            'country' => implode(',', $countryIds),  // ارسال شناسه‌های کشورها
            'specialty' => implode(',', $expertiseIds),  // ارسال شناسه‌های تخصص‌ها
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch equipment data from WordPress API');
        }

        return $response->json();  // بازگشت داده‌های تجهیزات
    }
}
