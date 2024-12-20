<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentDevice extends Model
{
    protected $table = 'equipment_device'; // اگر نام جدول متفاوت باشد
    // رابطه به مدل Device
    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    // رابطه به مدل Equipment
    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
