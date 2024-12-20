<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Device;
use App\Models\Country;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\SupplierCompany;
use App\Exports\EquipmentExport;
use App\Jobs\ExportEquipmentJob;
use App\Models\MedicalSpecialty; 
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class SearchController extends Controller
{
    protected $query;

    public function __construct()
    {
        // مقداردهی پرس‌وجو در سازنده
        $this->query = Equipment::query();
    }
    public function search(Request $request)
    {      
       

     
        if ($request->filled('equipment_name') && $request->input('equipment_name') != 'All') {
           $this->query->where('equipment_name', $request->input('equipment_name'));
        }
    
        if ($request->filled('device_model')) {
          $this->query->where('device_model', 'like', '%' . $request->input('device_model') . '%'); // Assuming you want a partial match
        }
        if ($request->filled('brand_id')  && $request->input('brand_id') != 'All')  {
           $this->query->where('brand_id', $request->input('brand_id'));
        }
        if ($request->filled('medical_specialties_id') && $request->input('medical_specialties_id') != 'All')  {
          $this->query->where('medical_specialties_id', $request->input('medical_specialties_id'));
        }
        if ($request->filled('country_id') && $request->input('country_id') != 'All')  {
         $this->query->where('country_id', $request->input('country_id'));
        }
      
        if ($request->filled('supplier_company_id') && $request->input('supplier_company_id') != 'All') {
           $this->query->where('supplier_company_id', $request->input('supplier_company_id'));
        }
        

        // لیست مقادیر معتبر برای supplier_status_is
        $validStatuses = ['تولید کننده', 'وارد کننده', 'توزیع کننده', 'فروشنده', 'All'];
        
        // بررسی اینکه آیا user مقداری برای 'supplier_status_is' ارسال کرده است و آیا این مقدار معتبر است
        if ($request->filled('supplier_status_is') && in_array($request->input('supplier_status_is'), $validStatuses) && $request->input('supplier_status_is') != 'All') {
            $status = $request->input('supplier_status_is');
           $this->query->where('supplier_status_is', $status);
        }
        // if ($request->filled('certificate_date') ) {
        //    $this->query->where('certificate_date' ,'<=', $request->input('certificate_date'));
        // }
        if ($request->filled('certificate_date') ) {

            $comparison = $request->input('comparison', 'less_than_or_equal'); // در صورت عدم ارسال، پیش‌فرض "کوچکتر یا مساوی" است

            if ($comparison == 'greater_than_or_equal') {
                $this->query->where('certificate_date', '>=', $request->input('certificate_date'));
            } elseif ($comparison == 'equal') {
                $this->query->where('certificate_date', '=', $request->input('certificate_date'));
            } elseif ($comparison == 'less_than_or_equal') {
                $this->query->where('certificate_date', '<=', $request->input('certificate_date'));
            }
        }
        if ($request->filled('query_date') ) {
            $this->query->where('query_date' ,'<=', $request->input('query_date'));
         }
         // لیست مقادیر معتبر برای supplier_status_is
        $validStatuses = ['ندارد', 'دارد', 'All'];
        
        // بررسی اینکه آیا user مقداری برای 'supplier_status_is' ارسال کرده است و آیا این مقدار معتبر است
        if ($request->filled('history_working') && in_array($request->input('history_working'), $validStatuses) && $request->input('history_working') != 'All') {
            $status = $request->input('history_working');
           $this->query->where('history_working', $status);
        }
        if ($request->filled('salesman_phone')) {
            $this->query->where('salesman_phone', 'like', '%' . $request->input('salesman_phone') . '%'); 
        }
        if ($request->filled('salesman_agent')) {
            $this->query->where('salesman_agent', 'like', '%' . $request->input('salesman_agent') . '%'); 
        }
        if ($request->filled('query_price')) {
            $this->query->where('query_price', 'like', '%' . $request->input('query_price') . '%'); 
        }
        if ($request->filled('purchase_price')) {
            $this->query->where('purchase_price', 'like', '%' . $request->input('purchase_price') . '%'); 
        }
        if ($request->filled('description')) {
            $this->query->where('description', 'like', '%' . $request->input('description') . '%'); 
        }
        $results =$this->query->paginate(10)->appends($request->except('page')); // preserve filters
        
        $brands = Brand::orderBy('name', 'asc')->get();
        $countries = Country::orderBy('name', 'asc')->get();
        $medicalSpecialties = MedicalSpecialty::orderBy('name', 'asc')->get();
        $supplierCompanies =SupplierCompany::orderBy('name', 'asc')->get();
        $devicenames = Device::orderBy('name', 'asc')->get();
        
        return view('search_form', [
            'devicenames' => $devicenames,
            'results' => $results,
            'brands' => $brands->pluck('name')->unique(), // نام برندها را می‌گیریم و تکراری‌ها را حذف می‌کنیم
            'countries' => $countries->pluck('name')->unique(),
            'medicalSpecialties' => $medicalSpecialties->pluck('name')->unique(),
            'brands' => $brands,
            'countries' => $countries,
            'medicalSpecialties' => $medicalSpecialties,
            'supplierCompanies'  => $supplierCompanies,          

        ]);
    }  
    public function export(Request $request)
    {   
            
        // بررسی اینکه آیا هیچ پارامتری برای جستجو وارد نشده است
        $filters = [
            'equipment_name',
            'device_model',
            'brand_id',
            'medical_specialties_id',
            'country_id',
            'supplier_company_id',
            'supplier_status_is',
            'certificate_date',
            'history_working',
            'query_price',
            'query_date',
            'purchase_price',
            'purchase_date',
            'salesman_agent',
            'salesman_phone',
            'description',
        ];

        // بررسی اینکه آیا هیچ فیلدی پر نشده است
        $isEmpty = true;
        foreach ($filters as $filter) {
            if ($request->filled($filter) && $request->input($filter) != 'All') {
                $isEmpty = false;
                break;
            }
        }
        
        // اگر هیچ فیلدی پر نشده باشد، یک پیام نمایش داده می‌شود
        if ($isEmpty) {  
            // session()->flash('error', 'لطفاً برای جستجو حداقل یک فیلد را انتخاب کنید و خروجی اکسل دریافت نمایید');
            // dd(session());  // بررسی محتویات session
            // return redirect()->back();
            return redirect()->back()->with('error', ' لطفاً برای جستجو حداقل یک فیلد را انتخاب کنید و خروجی اکسل دریافت نمایید');
        }
        if ($request->filled('equipment_name') && $request->input('equipment_name') != 'All') {
            $this->query ->where('equipment_name', $request->input('equipment_name'));
        }    
    
        if ($request->filled('device_model')) {
           $this->query ->where('device_model', 'like', '%' . $request->input('device_model') . '%'); // Assuming you want a partial match
        }

        if ($request->filled('brand_id')  && $request->input('brand_id') != 'All')  {
            $this->query ->where('brand_id', $request->input('brand_id'));
        }

        if ($request->filled('medical_specialties_id') && $request->input('medical_specialties_id') != 'All')  {
           $this->query ->where('medical_specialties_id', $request->input('medical_specialties_id'));
        }

        if ($request->filled('country_id') && $request->input('country_id') != 'All')  {
          $this->query ->where('country_id', $request->input('country_id'));
        }

        if ($request->filled('supplier_company_id') && $request->input('supplier_company_id') != 'All') {
            $this->query ->where('supplier_company_id', $request->input('supplier_company_id'));
        }
        
        $validStatuses = ['تولید کننده', 'وارد کننده', 'توزیع کننده', 'فروشنده', 'All'];            
        if ($request->filled('supplier_status_is') && in_array($request->input('supplier_status_is'), $validStatuses) && $request->input('supplier_status_is') != 'All') {
            $status = $request->input('supplier_status_is');
            $this->query ->where('supplier_status_is', $status);
        }

        // if ($request->filled('certificate_date') ) {
        //     $this->query ->where('certificate_date','<=',  $request->input('certificate_date'));
        // }
        if ($request->filled('certificate_date') ) {

            $comparison = $request->input('comparison', 'less_than_or_equal'); // در صورت عدم ارسال، پیش‌فرض "کوچکتر یا مساوی" است

            if ($comparison == 'greater_than_or_equal') {
                $this->query->where('certificate_date', '>=', $request->input('certificate_date'));
            } elseif ($comparison == 'equal') {
                $this->query->where('certificate_date', '=', $request->input('certificate_date'));
            } elseif ($comparison == 'less_than_or_equal') {
                $this->query->where('certificate_date', '<=', $request->input('certificate_date'));
            }
        }
        if ($request->filled('query_date') ) {
            $this->query->where('query_date' ,'<=', $request->input('query_date'));
         }
         // لیست مقادیر معتبر برای supplier_status_is
        $validStatuses = ['ندارد', 'دارد', 'All'];
        
        // بررسی اینکه آیا user مقداری برای 'supplier_status_is' ارسال کرده است و آیا این مقدار معتبر است
        if ($request->filled('history_working') && in_array($request->input('history_working'), $validStatuses) && $request->input('history_working') != 'All') {
            $status = $request->input('history_working');
           $this->query->where('history_working', $status);
        }
        if ($request->filled('salesman_phone')) {
            $this->query->where('salesman_phone', 'like', '%' . $request->input('salesman_phone') . '%'); 
        }
        if ($request->filled('salesman_agent')) {
            $this->query->where('salesman_agent', 'like', '%' . $request->input('salesman_agent') . '%'); 
        }
        if ($request->filled('query_price')) {
            $this->query->where('query_price', 'like', '%' . $request->input('query_price') . '%'); 
        }
        if ($request->filled('purchase_price')) {
            $this->query->where('purchase_price', 'like', '%' . $request->input('purchase_price') . '%'); 
        }
        if ($request->filled('description')) {
            $this->query->where('description', 'like', '%' . $request->input('description') . '%'); 
        }
       

       $results = $this->query->get();

       $recordCount = $results->count();

       // اگر تعداد رکوردها کمتر از 8000 باشد، فایل اکسل به طور مستقیم دانلود می‌شود
       if ($recordCount <= 8000) {
           return Excel::download(new EquipmentExport($results), 'equipments.xlsx');
       }
      // ExportEquipmentJob::dispatch($results);

       // اگر تعداد رکوردها بیشتر از 8000 باشد، فایل اکسل در مسیر خاصی ذخیره می‌شود
      $filePath = storage_path('app/exports/equipments_' . time() . '.xlsx');
   
       try {
        // ذخیره‌سازی فایل
            $path = Excel::store(new EquipmentExport($results), 'exports/equipments_' . time() . '.xlsx');
        
            // بررسی اینکه آیا فایل ذخیره شده است یا خیر
            if ($path) {
                // اگر فایل با موفقیت ذخیره شد، پیام موفقیت را به لاگ ارسال می‌کنیم
                Log::info('File has been stored successfully in ' . storage_path('app/' . $path));
            } else {
                // اگر ذخیره‌سازی فایل شکست خورد، پیام خطا را به لاگ ارسال می‌کنیم
                Log::error('Failed to store the file');
            }
         } catch (\Exception $e) {
        // در صورتی که خطا رخ دهد، پیام خطا را به لاگ ارسال می‌کنیم
        Log::error('Error: ' . $e->getMessage());
        }
       // به کاربر اطلاع دهید که فایل آماده است و از مسیر مشخص شده آن را دانلود کند
       return redirect()->back()->with('success', 'تعداد رکوردها بیشتر از 8000 است. فایل در مسیر ذخیره شده است. برای دانلود به این مسیر مراجعه کنید: ' . $filePath);
   }
}
