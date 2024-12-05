<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
class Country extends Model
{
    protected $table = 'countries';

    // فیلدهایی که می‌توانند به‌طور انبوه پر شوند
    protected $fillable = ['id','name'];
    // Many-to-many relationship with Equipment
    public function equipments()
    {
        return $this->belongsToMany(Equipment::class);
    }
}
