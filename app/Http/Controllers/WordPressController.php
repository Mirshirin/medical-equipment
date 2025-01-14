<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Services\WordPressService;
use Illuminate\Support\Facades\DB;
use App\Jobs\FetchEquipmentDataJob;
use Illuminate\Support\Facades\Log;
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

            return response()->json(['message' => 'Brands, Countries, Specialties , supplier companies and devices have been successfully fetched and saved.']);
        } catch (\Exception $e) {
            // در صورت بروز خطا
            return response()->json(['error' => $e->getMessage()], 500);
        }    }

    // متد برای دریافت تجهیزات براساس برندها، کشورها و تخصص‌ها
    // public function getEquipments()
    // {
    //     // فرض کنید شناسه‌های برندها، کشورها و تخصص‌ها را از دیتابیس دریافت می‌کنید
    //    // $brandIds = \App\Models\Brand::pluck('id')->toArray();
    //     //$countryIds = \App\Models\Country::pluck('id')->toArray();
    //    // $expertiseIds =  \App\Models\MedicalSpecialty::pluck('id')->toArray();
       
    //     // دریافت تجهیزات از API
    //     //$this->wordpressService->getEquipments($brandIds, $countryIds, $expertiseIds);
    //     $this->wordpressService->getEquipments();
    //     // انتقال داده‌ها به Elasticsearch
    //     //          $this->indexDataInElasticsearch();
    //     return response()->json(['message' => 'equipments have been successfully fetched and saved.']);

    // }
    public function getEquipments()
    {
      // Equipment::query()->delete();
       // dd('stop');
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
            $jwtToken = $responseBody->token;  // دریافت توکن JWT
            // ارسال Job به Queue برای پردازش داده‌ها
            //dd( $jwtToken);
            FetchEquipmentDataJob::dispatch($jwtToken);
           
            return response()->json(['message' => 'Fetching equipment data has been queued.']);
        } else {
            return response()->json(['error' => 'Failed to retrieve JWT token'], 500);
        }
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
        //dd( $equipments);
            // دریافت تعداد کل تجهیزات برای صفحه‌بندی
            $total = $response->header('X-WP-Total');  // تعداد کل نتایج
            $totalPages = ceil($total / $perPage);  // محاسبه تعداد صفحات
           // Log::info("Shamsi Date: { $totalPages}");
            // ارسال داده‌ها به نمای Blade همراه با اطلاعات صفحه‌بندی
            return view('specialty.index', compact('equipments', 'totalPages', 'page'));
        } else {
            return response()->json(['error' => 'Unable to fetch equipment data'], 500);
        }
    }
  
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
