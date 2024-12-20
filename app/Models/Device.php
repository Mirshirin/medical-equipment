<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';

    // فیلدهایی که می‌توانند به‌طور انبوه پر شوند
    protected $fillable = ['id','name'];
    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_device', 'device_id', 'equipment_id');
    }
    // رابطه به جدول pivot equipment_device
    public function equipmentDevices()
    {
        return $this->hasMany(EquipmentDevice::class, 'device_id');
    }
}
