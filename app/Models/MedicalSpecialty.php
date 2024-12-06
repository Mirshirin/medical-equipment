<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
class MedicalSpecialty extends Model
{
    protected $table = 'medical_specialties';

    // فیلدهایی که می‌توانند به‌طور انبوه پر شوند
    protected $fillable = ['id','name','parent_id'];
    
    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_medical_specialty', 'medical_specialty_id', 'equipment_id');
    }
     public function parent()
    {
        return $this->belongsTo(MedicalSpecialty::class, 'parent_id');
    }

    // رابطه برای دریافت زیرمجموعه‌ها
    public function children()
    {
        return $this->hasMany(MedicalSpecialty::class, 'parent_id');
    }
}
