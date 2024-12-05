<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elastic\Elasticsearch\ClientBuilder;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $client = ClientBuilder::create()
        ->setHosts([env('ELASTICSEARCH_HOST')]) // مانند: 'localhost:9200'
        ->build();
        // گرفتن پارامتر جستجو از درخواست
        $query = $request->input('query');  // فرض بر این است که پارامتر جستجو با نام "query" ارسال می‌شود

        if (!$query) {
            return response()->json(['error' => 'Query parameter is required'], 400);
        }

        // اتصال به Elasticsearch
        $client = ClientBuilder::create()->build();

        // تنظیمات جستجو
        $params = [
            'index' => 'equipments',  // نام ایندکس
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,  // کلمه جستجو
                        'fields' => ['status', 'type', 'brand', 'medical-specialties', 'country']  // فیلدهایی که باید جستجو شوند
                    ]
                ]
            ]
        ];

        // اجرای جستجو در Elasticsearch
        $results = $client->search($params);

        // بازگرداندن نتایج جستجو به صورت JSON
        return response()->json($results);
    }
}
