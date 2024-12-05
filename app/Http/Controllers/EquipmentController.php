<?php

namespace App\Http\Controllers;

use App\Exports\EquipmentExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use App\Models\Equipment;
//use Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\ClientBuilder;

class EquipmentController extends Controller
{
    public function export()
    {
        $this->fetchEquipmentData();
        return Excel::download(new EquipmentExport, 'equipments.xlsx');
    }
    public function fetchEquipmentData()
    {
        
        $url = "http://equipment.ir/wp-json/wp/v2/equipment";
    
        // ارسال درخواست GET به API
        $response = Http::get($url);

        // چک کردن وضعیت پاسخ
        if ($response->successful()) {
            $data = $response->json(); // تبدیل پاسخ JSON به آرایه
           //dd($data);
            // ذخیره اطلاعات در مدل (اگر داده‌ها موجود باشند)
            foreach ($data as $item) {
                $newId = Equipment::max('equipment_id') + 1;
                $equipment = Equipment::updateOrCreate(
                    [  'equipment_id' => $newId], 
                    [
                        'id' => $item['id'], 
                        'date' => $item['date'],
                        'link' => $item['link'],                 
                        'type' => $item['type'],
                        'status' => $item['status'],

                        // سایر فیلدها بر اساس ساختار داده‌های شما
                    ]
                );
                // Associate the medical specialties
                 $equipment->medicalSpecialties()->sync($item['medical-specialties']);
                 // Associate brands with the equipment
                $equipment->brands()->sync($item['brand_ids']); // Assuming $item['brand_ids'] is an array of brand IDs

                // Associate countries with the equipment
                $equipment->countries()->sync($item['country_ids']);
            }

             // انتقال داده‌ها به Elasticsearch
             $this->indexDataInElasticsearch();
        } else {
            // مدیریت خطا در صورت عدم موفقیت
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }
    }
    public function indexDataInElasticsearch()
    {
        $client = ClientBuilder::create()
                ->setHosts([env('ELASTICSEARCH_HOST')]) // مانند: 'localhost:9200'
                ->build();
        // اتصال به Elasticsearch
        $client = ClientBuilder::create()->build();

        // تمام رکوردهای جدول equipments را از دیتابیس لاراول می‌خوانیم
        $equipments = Equipment::all();

        // اضافه کردن داده‌ها به Elasticsearch
        foreach ($equipments as $equipment) {
            $params = [
                'index' => 'equipments',
                'id' => $equipment->equipment_id,
                'body' => [
                    'id' => $equipment->id,
                    'status' => $equipment->status,
                    'date' => $equipment->date,
                    'link' => $equipment->link,
                    'type' => $equipment->type,
                    'brand' => $equipment->brand,
                    'medical-specialties' => $equipment->medical_specialties,
                    'country' => $equipment->country,
                    'acf' => $equipment->acf,
                    // سایر فیلدها
                ]
            ];

            // ایندکس کردن داده‌ها در Elasticsearch
            $client->index($params);
        }
    }
}