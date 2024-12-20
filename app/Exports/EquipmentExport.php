<?php

namespace App\Exports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;


class EquipmentExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        // // Instead of fetching all results at once, chunk the data
        return Equipment::query()
        ->whereIn('id', $this->results->pluck('id')->toArray());
        
    }

    /**
     * تعداد رکوردهایی که باید به‌صورت تدریجی پردازش شوند
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000; // می‌توانید این مقدار را مطابق نیاز خود تنظیم کنید
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
            implode(', ', $equipment->devices->pluck('name')->toArray()) ?? 'N/A',

            $equipment->device_model ?? '',
            implode(', ', $equipment->brands->pluck('name')->toArray()) ?? 'N/A',
            implode(', ', $equipment->medicalSpecialties->pluck('name')->toArray()) ?? 'N/A',
            implode(', ', $equipment->countries->pluck('name')->toArray()) ?? 'N/A',
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
