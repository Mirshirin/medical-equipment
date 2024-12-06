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
        Schema::create('equipment_country', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id'); // شناسه تجهیز
            $table->unsignedBigInteger('country_id'); // شناسه کشور
            $table->timestamps(); // تاریخ‌های ایجاد و به‌روزرسانی

            // تعریف روابط (فرض کنید که id های مربوطه در جداول 'equipments' و 'countries' هستند)
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_country');
    }
};
