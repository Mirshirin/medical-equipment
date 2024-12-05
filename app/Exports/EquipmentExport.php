<?php

namespace App\Exports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquipmentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Equipment::all();
    }
    public function headings(): array
    {
        return [
            'شناسه',
            'وضعیت',
            'تاریخ انتشار',
            'لینک',
            'نوع',
            'برند',
            'ویژگی‌های پزشکی',
            'کشور',
            'اطلاعات ACF',
        ];
    }
}
