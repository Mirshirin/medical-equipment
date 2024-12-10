<?php

namespace App\Http\Controllers;

use App\Exports\EquipmentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Equipment;
use Elastic\Elasticsearch\ClientBuilder;

class EquipmentController extends Controller
{
    // public function export(Request $request)
    // { 
         
    //     return Excel::download(new EquipmentExport, 'equipments.xlsx');
    // }
   
    // public function indexDataInElasticsearch()
    // {
    //     $client = ClientBuilder::create()->setHosts([env('ELASTICSEARCH_HOST')])->build();

    //     // Check if the index exists
    //     $indexExists = $client->indices()->exists(['index' => 'equipments']);

    //     if (!$indexExists) {
    //         // If the index does not exist, create it with settings and mappings
    //         $params = [
    //             'index' => 'equipments',
    //             'body' => [
    //                 'settings' => [
    //                     'number_of_shards' => 3,
    //                     'number_of_replicas' => 2
    //                 ],
    //                 'mappings' => [
    //                     'properties' => [
    //                         'id' => ['type' => 'integer'],
    //                         'status' => ['type' => 'keyword'],
    //                         'date' => ['type' => 'date'],
    //                         'type' => ['type' => 'text'],
    //                         'equipment_name' => ['type' => 'text'],
    //                         'device_model' => ['type' => 'text'],
    //                         'brand_id' => ['type' => 'integer'],
    //                         'medical_specialties_id' => ['type' => 'integer'],
    //                         'country_id' => ['type' => 'integer'],
    //                         'supplier_company_id' => ['type' => 'integer'],
    //                         'supplier_status_is' => ['type' => 'boolean'],
    //                         'history_working' => ['type' => 'text'],
    //                         'query_price' => ['type' => 'float'],
    //                         'query_date' => ['type' => 'date'],
    //                         'purchase_price' => ['type' => 'float'],
    //                         'purchase_date' => ['type' => 'date'],
    //                         'certificate_date' => ['type' => 'date'],
    //                         'salesman_agent' => ['type' => 'text'],
    //                         'salesman_phone' => ['type' => 'keyword'],
    //                         'description' => ['type' => 'text']
    //                     ]
    //                 ]
    //             ]
    //         ];

    //         // Create the index in Elasticsearch
    //         $client->indices()->create($params);
    //     }

    //     // Fetch all equipment records from the database
    //     $equipments = Equipment::all();

    //     // Prepare bulk index data
    //     $params = ['body' => []];

    //     foreach ($equipments as $equipment) {
    //         $params['body'][] = [
    //             'index' => [
    //                 '_index' => 'equipments',
    //                 '_id' => $equipment->id
    //             ]
    //         ];
    //         $params['body'][] = [
    //             'id' => $equipment->id,
    //             'status' => $equipment->status,
    //             'date' => $equipment->date,
    //             'type' => $equipment->type,
    //             'equipment_name' => $equipment->equipment_name,
    //             'device_model' => $equipment->device_model,
    //             'brand_id' => $equipment->brand_id,
    //             'medical_specialties_id' => $equipment->medical_specialties_id,
    //             'country_id' => $equipment->country_id,
    //             'supplier_company_id' => $equipment->supplier_company_id,
    //             'supplier_status_is' => $equipment->supplier_status_is,
    //             'history_working' => $equipment->history_working,
    //             'query_price' => $equipment->query_price,
    //             'query_date' => $equipment->query_date,
    //             'purchase_price' => $equipment->purchase_price,
    //             'purchase_date' => $equipment->purchase_date,
    //             'certificate_date' => $equipment->certificate_date,
    //             'salesman_agent' => $equipment->salesman_agent,
    //             'salesman_phone' => $equipment->salesman_phone,
    //             'description' => $equipment->description
    //         ];
    //     }

    //     // Perform bulk indexing if data exists
    //     if (!empty($params['body'])) {
    //         $client->bulk($params);
    //     }
    // }
    // public function testElasticSearchConnection()
    // {
    //     try {
    //         $client = ClientBuilder::create()
    //             ->setHosts([env('ELASTICSEARCH_HOST')])
    //             ->setRetries(2)  // Retry 2 times in case of failures
    //         //   ->setConnectionParams(['timeout' => 10]) // Set timeout to 10 seconds
    //             ->build();
    //         $response = $client->ping();
    //         return response()->json(['message' => 'Connected to Elasticsearch', 'status' => $response]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Could not connect to Elasticsearch', 'details' => $e->getMessage()]);
    //     }
    // }
}