<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentBrandTable extends Migration
{
    public function up()
    {
        Schema::create('equipment_brand', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id'); // شناسه تجهیزات
            $table->unsignedBigInteger('brand_id'); // شناسه برند
            $table->timestamps(); // برای ذخیره تاریخ‌های ایجاد و به‌روزرسانی

            // تعریف روابط (فرض کنید که id های مربوطه در جداول 'equipments' و 'brands' هستند)
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_brand');
    }
}