<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipment_device', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id'); // شناسه تجهیزات
            $table->unsignedBigInteger('device_id'); // شناسه equipment_name
            $table->timestamps(); // برای ذخیره تاریخ‌های ایجاد و به‌روزرسانی

            // تعریف روابط (فرض کنید که id های مربوطه در جداول 'equipments' و 'devices' هستند)
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_device');
    }
};
