<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Models\Country;
use App\Models\Equipment;
use Morilog\Jalali\Jalalian;
use App\Models\SupplierCompany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class FetchEquipmentDataJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 3600;
    protected $jwtToken;

    public function __construct($jwtToken)
    {
        $this->jwtToken = $jwtToken;
    }   
    public function handle()
    {
        
        try {
            Log::info("Start fetching and processing data from WordPress API.");

            $client = new Client();
            $page = 1;
            $perPage = 20;

            // درخواست برای اولین صفحه داده‌ها
            do {
                $response = Http::get("http://equipment.ir/wp-json/wp/v2/equipment", [
                    'page' => $page,
                    'per_page' => $perPage,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->jwtToken,
                    ]
                ]);

                if ($response->failed()) {
                    throw new \Exception("Failed to fetch data from WordPress API");
                }

                $data = $response->json();
                
                foreach ($data as $equipment) {

                    // پردازش داده‌ها
                    $this->processEquipment($equipment);
                }

                $page++;

            } while ($page <= $response->header('X-WP-TotalPages'));

            Log::info("Finished fetching and processing all data from WordPress API.The number of {$page}");

        } catch (\Exception $e) {
            Log::error("Error fetching and processing data: " . $e->getMessage());
        }
    }

    // متد برای پردازش هر تجهیز
    protected function processEquipment($equipment)
    {
        try {
            Log::info("Start processing Equipment ID: {$equipment['id']}");
            $shamsiDate = $equipment['acf']['تاریخ_اعتبار_نمایندگی'] ?? null;
            $gregorianDate = $this->convertShamsiToGregorian($shamsiDate);

            $equipmentModel = Equipment::updateOrCreate(
                ['id' => $equipment['id']],
                [
                    'status' => $equipment['status'],
                    'date' => $equipment['date'],
                    'type' => $equipment['type'],
                    'equipment_name' => $equipment['acf']['equipment_name'] ?? null,
                    'device_model' => $equipment['acf']['مدل_وسیله'] ?? null,
                    'brand_id' => $equipment['acf']['برند'][0] ?? null,
                    'medical_specialties_id' => $equipment['medical-specialties'][0] ?? null,
                    'country_id' => $equipment['acf']['کشور_سازنده'][0] ?? null,
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

            if (isset($equipment['acf']['equipment_name'])) {
                $equipmentModel->devices()->attach($equipment['acf']['equipment_name']);
            }

            if (isset($equipment['acf']['برند'][0])) {
                $equipmentModel->brands()->attach($equipment['acf']['برند'][0]);
            }

            if (isset($equipment['acf']['کشور_سازنده']) && is_array($equipment['acf']['کشور_سازنده']) && isset($equipment['acf']['کشور_سازنده'][0])) {
                $countryId = $equipment['acf']['کشور_سازنده'][0];
                $country = Country::find($countryId);

                if ($country) {
                    $equipmentModel->countries()->attach($countryId);
                } else {
                    $countryName = 'نام کشور'; // از اطلاعات مناسب برای نام کشور استفاده کنید
                    $newCountry = Country::create(['id' => $countryId, 'name' => $countryName]);
                    $equipmentModel->countries()->attach($newCountry->id);
                }
            }

            if (isset($equipment['medical-specialties'][0])) {
                $equipmentModel->medicalSpecialties()->attach($equipment['medical-specialties'][0]);
            }

            if (isset($equipment['acf']['شرکت_تامین_کننده'])) {
                $supplierId = $equipment['acf']['شرکت_تامین_کننده'];
                $supplierCompany = SupplierCompany::find($supplierId);

                if (!$supplierCompany) {
                    $supplierCompany = SupplierCompany::create([
                        'id' => $supplierId,
                        'name' => $equipment['acf']['supplier_names'][$supplierId] ?? 'نام نامشخص',
                    ]);
                }

                $equipmentModel->supplierCompanies()->attach($supplierCompany->id);
            }

            Log::info("Finished processing Equipment ID: {$equipment['id']}");

        } catch (\Exception $e) {
            Log::error("Error processing Equipment ID: {$equipment['id']}. Error: " . $e->getMessage());
        }
    }

    // متد تبدیل تاریخ شمسی به میلادی
    protected function convertShamsiToGregorian($shamsiDate)
    {
        if ($shamsiDate) {
            $formattedDate = substr($shamsiDate, 0, 4) . '-' . substr($shamsiDate, 4, 2) . '-' . substr($shamsiDate, 6, 2);
            try {
                return Jalalian::fromFormat('Y-m-d', $formattedDate)->toCarbon()->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

}
