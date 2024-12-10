<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('equipment_specialty', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id'); // شناسه تجهیز
            $table->unsignedBigInteger('specialty_id'); // شناسه تخصص پزشکی
            $table->timestamps(); // تاریخ‌های ایجاد و به‌روزرسانی

            // تعریف روابط (فرض کنید که id های مربوطه در جداول 'equipments' و 'medical_specialties' هستند)
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->foreign('specialty_id')->references('id')->on('medical_specialties')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_specialty');
    }
};
