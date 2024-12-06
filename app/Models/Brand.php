<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
class Brand extends Model
{
    protected $table = 'brands';

    // فیلدهایی که می‌توانند به‌طور انبوه پر شوند
    protected $fillable = ['id','name'];

    // Many-to-many relationship with Equipment
    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_brand', 'brand_id', 'equipment_id');
    }
}
