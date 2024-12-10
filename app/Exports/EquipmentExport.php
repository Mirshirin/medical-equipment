<?php

namespace App\Exports;

use App\Models\Equipment;;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping; 
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class EquipmentExport implements FromCollection, WithHeadings, WithMapping
{
    protected $results;
    
    public function __construct($results)
    {
        $this->results= $results;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {  
        $equipment= $this->results;
        return  $equipment;
        
    }
    public function headings(): array
    {
        return [
            'شناسه',
            'وضعیت',
            'تاریخ انتشار',            
            'نوع',
            'نام وسیله',
            'مدل', 
            'برند',
            'تخصص',
            'کشور',
            'شرکت تامین کننده',
            'نوع تامین کننده',
            'سابقه همکاری',
            'قیمت استعلامی', 
            'تاریخ استعلام',
            'قیمت خرید',
            'تاریخ خرید',
            'تاریخ اعتبار نمایندگی ',
            'نماینده فروش',
            'تلفن همراه',
            'توضیحات ',


        ];
    }
    public function map($equipment): array
    {
  
        $gregorianDate = $equipment->certificate_date;
        $shamsiDate = 'N/A';
        //تبدیل به شمسی
        if ($gregorianDate) {
            $shamsiDate = Jalalian::fromCarbon(Carbon::parse($gregorianDate))->format('Y/m/d');
        }
    
        return [           
        
            $equipment->id ?? '',
            $equipment->status ?? '',
            $equipment->date ?? '',
            $equipment->type ?? '',
            $equipment->equipment_name ?? '',
            $equipment->device_model ?? '',
            implode(', ', $equipment->brands->pluck('name')->toArray()) ?? 'N/A',
            implode(', ', $equipment->countries->pluck('name')->toArray()) ?? 'N/A',
            implode(', ', $equipment->medicalSpecialties->pluck('name')->toArray()) ?? 'N/A',
            implode(', ', $equipment->supplierCompanies->pluck('name')->toArray()) ?? 'N/A',         
            $equipment->supplier_status_is ?? '',
            $equipment->history_working ?? '',
            $equipment->query_price ?? '',
            $equipment->query_date ?? '',
            $equipment->purchase_price ?? '',
            $equipment->purchase_date ?? '',
            $shamsiDate,
            $equipment->salesman_agent ?? '',
            $equipment->salesman_phone ?? '',
            $equipment->description ??'',
        ];
    }
}
