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
        Schema::create('medical_specialties', function (Blueprint $table) {
            $table->id(); // شناسه یکتا برای تخصص پزشکی
            $table->string('name'); // نام تخصص پزشکی
            $table->unsignedBigInteger('parent')->nullable(); // شناسه تخصص والد (اگر والد داشته باشد)
            $table->timestamps();        
            // ایجاد رابطه بین parent و child
            $table->foreign('parent')->references('id')->on('medical_specialties')->onDelete('cascade');
        });
        // Create pivot table for many-to-many relationship
        Schema::create('equipment_medical_specialty', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('medical_specialty_id');
            $table->timestamps();        
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            $table->foreign('medical_specialty_id')->references('id')->on('medical_specialties')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_specialties');
    }
};
