<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Services\WordPressService;
use Illuminate\Support\Facades\Http;

class WordPressController extends Controller
{

    protected $wordpressService;

    public function __construct(WordPressService $wordpressService)
    {
        $this->wordpressService = $wordpressService;
    }

    // متد برای دریافت داده‌ها از API و ذخیره آن‌ها
    public function fetchAndSaveData()
    {
        try {
            // دریافت داده‌ها از API وردپرس
             $this->wordpressService->getDataFromWordPress();          

            return response()->json(['message' => 'Brands, Countries, and Specialties have been successfully fetched and saved.']);
        } catch (\Exception $e) {
            // در صورت بروز خطا
            return response()->json(['error' => $e->getMessage()], 500);
        }    }

    // متد برای دریافت تجهیزات براساس برندها، کشورها و تخصص‌ها
    public function getEquipments()
    {
        // فرض کنید شناسه‌های برندها، کشورها و تخصص‌ها را از دیتابیس دریافت می‌کنید
        $brandIds = [1, 2, 3];  // شناسه‌های برند
        $countryIds = [1, 2];  // شناسه‌های کشور
        $expertiseIds = [1, 3];  // شناسه‌های تخصص

        // دریافت تجهیزات از API
        $equipments = $this->wordpressService->getEquipments($brandIds, $countryIds, $expertiseIds);

        return response()->json($equipments);
    }
    public function getEquipment(Request $request, $page = 1)
    {
        $perPage = 10;  // تعداد نتایج در هر صفحه
        $page = $request->input('page', $page); // دریافت پارامتر page از URL
    
        // ساخت URL برای درخواست API با پارامتر صفحه‌بندی
        $url = "http://equipment.ir/wp-json/wp/v2/equipment?per_page={$perPage}&page={$page}";
    
        // ارسال درخواست GET به API
        $response = Http::get($url);
    
        // بررسی موفقیت‌آمیز بودن درخواست
        if ($response->successful()) {
            // دریافت داده‌ها
            $equipments = $response->json();
    dd( $equipments);
            // دریافت تعداد کل تجهیزات برای صفحه‌بندی
            $total = $response->header('X-WP-Total');  // تعداد کل نتایج
            $totalPages = ceil($total / $perPage);  // محاسبه تعداد صفحات
    
            // ارسال داده‌ها به نمای Blade همراه با اطلاعات صفحه‌بندی
            return view('specialty.index', compact('equipments', 'totalPages', 'page'));
        } else {
            return response()->json(['error' => 'Unable to fetch equipment data'], 500);
        }
    }
    // public function fetchEquipmentData()
    // {
    //     dd('tttttttttttttt');
    //     $url = "http://equipment.ir/wp-json/wp/v2/equipment";
    
    //     // ارسال درخواست GET به API
    //     $response = Http::get($url);
    
    //     // چک کردن وضعیت پاسخ
    //     if ($response->successful()) {
    //         $data = $response->json(); // تبدیل پاسخ JSON به آرایه
    
    //         // ذخیره اطلاعات در مدل (اگر داده‌ها موجود باشند)
    //         foreach ($data as $item) {
    //             $newId = Equipment::max('equipment_id') + 1;
    //             Equipment::updateOrCreate(
    //                 [  'equipment_id' => $newId], 
    //                 [
    //                     'id' => $item['id'], 
    //                     'date' => $item['date'],
    //                     'link' => $item['link'],                 
    //                     'type' => $item['type'],
    //                     'brand' => $item['brand'],
    //                     'medical-specialties' => $item['medical-specialties'],
    //                     'country' => $item['country'],
    //                     'acf' => $item['acf'],
    //                     'status' => $item['status'],

    //                     // سایر فیلدها بر اساس ساختار داده‌های شما
    //                 ]
    //             );
    //         }

    //          // انتقال داده‌ها به Elasticsearch
    //          $this->indexDataInElasticsearch();
    //     } else {
    //         // مدیریت خطا در صورت عدم موفقیت
    //         return response()->json(['error' => 'Failed to fetch data'], 500);
    //     }
    // }
    public function getSpecialty($termId)
    {
        // WordPress API endpoint for the specific term
        $url = "http://equipment.ir/wp-json/wp/v2/medical-specialties/{$termId}";

        // Create a new Guzzle client
        $client = new Client();

        // Make the GET request to the API
        $response = $client->get($url);

        // Parse the JSON response
        $data = json_decode($response->getBody()->getContents(), true);

        // Extract ACF fields
        $acfData = $data['acf']; // Contains the ACF fields, such as "تصویر تخصص"

        // Example: Get the image ID and fetch image data
        $imageId = $acfData['تصویر_تخصص'];
        
        // Optionally, you could fetch more data related to the image here...

        return view('specialty.show', compact('data', 'acfData'));
    }
}
