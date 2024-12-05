<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
class MedicalSpecialty extends Model
{
    public function equipments()
    {
        return $this->belongsToMany(Equipment::class);
    }
}
