<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    // نام جدول مربوط به این مدل
    protected $table = 'equipment';

    // فیلدهایی که می‌توانند به‌طور انبوه پر شوند
    protected $fillable = ['equipment_id','acf','country','medical-specialties','brand','type','link','date','status','id'];

    public function medicalSpecialties()
    {
        return $this->belongsToMany(MedicalSpecialty::class);
    }
    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    // Many-to-many relationship with Country
    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }
}