<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    // نام جدول مربوط به این مدل
    protected $table = 'equipments';

    // فیلدهایی که می‌توانند به‌طور انبوه پر شوند
    //protected $fillable = ['equipment_id','acf','country','medical-specialties','brand','type','link','date','status','id'];
    protected $fillable = ['id','status','date','type','equipment_name','device_model','brand_id',
                            'medical_specialties_id','country_id','supplier_company_id',
                            'supplier_status_is','history_working','query_price','query_date',
                            'purchase_price','purchase_date','certificate_date','salesman_agent',
                            'salesman_phone','description'
                        ];
    public $incrementing = false;  // این ویژگی را false قرار می‌دهیم تا از افزایش خودکار شناسه جلوگیری شود.
    public $timestamps = true;   
    
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'equipment_brand', 'equipment_id', 'brand_id');

    }

     // رابطه many-to-many با کشور
     public function countries()
     {
         return $this->belongsToMany(Country::class, 'equipment_country', 'equipment_id', 'country_id');
     }
 
     // رابطه many-to-many با تخصص پزشکی
     public function medicalSpecialties()
     {
         return $this->belongsToMany(MedicalSpecialty::class, 'equipment_specialty', 'equipment_id', 'specialty_id');
     }
}