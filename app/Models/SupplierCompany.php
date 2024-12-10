<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierCompany extends Model
{
    protected $table = 'supplier_companies';

    // فیلدهایی که می‌توانند به‌طور انبوه پر شوند
    protected $fillable = ['id','name'];
    public function equipments()
    {

        return $this->belongsToMany(Equipment::class, 'equipment_supplier_company', 'supplier_id', 'equipment_id');
    }
}
