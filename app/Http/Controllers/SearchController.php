<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\SupplierCompany;
use App\Models\Country;
use App\Models\MedicalSpecialty; 
use App\Exports\EquipmentExport;
use Maatwebsite\Excel\Facades\Excel;
class SearchController extends Controller
{
    
    public function search(Request $request)
    {      
       // dd('sdfghjkljhgfd');
        $query = Equipment::query(); // Equipment is the model representing the 'equipments' table

        if ($request->filled('equipment_name')) {
           $query->where('equipment_name', $request->input('equipment_name'));
        }
    
        if ($request->filled('device_model')) {
           $query->where('device_model', 'like', '%' . $request->input('device_model') . '%'); // Assuming you want a partial match
        }
        if ($request->filled('brand_id')  && $request->input('brand_id') != 'All')  {
            $query->where('brand_id', $request->input('brand_id'));
        }
        if ($request->filled('medical_specialties_id') && $request->input('medical_specialties_id') != 'All')  {
           $query->where('medical_specialties_id', $request->input('medical_specialties_id'));
        }
        if ($request->filled('country_id') && $request->input('country_id') != 'All')  {
          $query->where('country_id', $request->input('country_id'));
        }
      
        if ($request->filled('supplier_company_id') && $request->input('supplier_company_id') != 'All') {
            $query->where('supplier_company_id', $request->input('supplier_company_id'));
        }


        // لیست مقادیر معتبر برای supplier_status_is
        $validStatuses = ['تولید کننده', 'وارد کننده', 'توزیع کننده', 'فروشنده', 'All'];
        
        // بررسی اینکه آیا user مقداری برای 'supplier_status_is' ارسال کرده است و آیا این مقدار معتبر است
        if ($request->filled('supplier_status_is') && in_array($request->input('supplier_status_is'), $validStatuses) && $request->input('supplier_status_is') != 'All') {
            $status = $request->input('supplier_status_is');
            $query->where('supplier_status_is', $status);
        }
    
        if ($request->filled('certificate_date') ) {
            $query->where('certificate_date' ,'<=', $request->input('certificate_date'));
        }
        $results = $query->paginate(10)->appends($request->except('page')); // preserve filters
        
        $brands = Brand::orderBy('name', 'asc')->get();
        $countries = Country::orderBy('name', 'asc')->get();
        $medicalSpecialties = MedicalSpecialty::orderBy('name', 'asc')->get();
        $supplierCompanies =SupplierCompany::orderBy('name', 'asc')->get();
        //dd(  $results);
        return view('search_form', [
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
        //dd('ddddddddd');
        $query = Equipment::query(); // Equipment is the model representing the 'equipments' table

        if ($request->filled('equipment_name')) {
           $query->where('equipment_name', $request->input('equipment_name'));
        }
    
        if ($request->filled('device_model')) {
           $query->where('device_model', 'like', '%' . $request->input('device_model') . '%'); // Assuming you want a partial match
        }
        if ($request->filled('brand_id')  && $request->input('brand_id') != 'All')  {
            $query->where('brand_id', $request->input('brand_id'));
        }
        if ($request->filled('medical_specialties_id') && $request->input('medical_specialties_id') != 'All')  {
           $query->where('medical_specialties_id', $request->input('medical_specialties_id'));
        }
        if ($request->filled('country_id') && $request->input('country_id') != 'All')  {
          $query->where('country_id', $request->input('country_id'));
        }
        // لیست مقادیر معتبر برای supplier_status_is
        $validStatuses = ['تولید کننده', 'وارد کننده', 'توزیع کننده', 'فروشنده', 'All'];
            
        // بررسی اینکه آیا user مقداری برای 'supplier_status_is' ارسال کرده است و آیا این مقدار معتبر است
        if ($request->filled('supplier_status_is') && in_array($request->input('supplier_status_is'), $validStatuses) && $request->input('supplier_status_is') != 'All') {
            $status = $request->input('supplier_status_is');
            $query->where('supplier_status_is', $status);
        }

        if ($request->filled('certificate_date') ) {
            $query->where('certificate_date','<=',  $request->input('certificate_date'));
        }
        $results = $query->get();     
        //dd($results );
        return Excel::download(new EquipmentExport($results), 'equipments.xlsx');
    }
}
