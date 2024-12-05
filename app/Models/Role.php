<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'wp_role_name'];

    // ارتباط با کاربران
    public function users()
    {
        return $this->hasMany(User::class);
    }
}