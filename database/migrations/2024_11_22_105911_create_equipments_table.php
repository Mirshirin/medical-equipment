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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();  // auto-incrementing ID
            $table->string('status');
            $table->date('date');  // or $table->datetime('date') if you need time as well
            $table->string('type');
            
            $table->string('equipment_name')->nullable();  // Nullable if it's not always provided
            $table->string('device_model')->nullable();  // Nullable if it's not always provided
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('medical_specialties_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('supplier_company_id')->nullable();
            $table->string('supplier_status_is')->nullable();
            $table->text('history_working')->nullable();
            $table->decimal('query_price', 10, 2)->nullable();
            $table->date('query_date')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('certificate_date')->nullable();
            $table->string('salesman_agent')->nullable();
            $table->string('salesman_phone')->nullable();
            $table->text('description')->nullable();
           // $table->string('link', 2048)->nullable(); 
            $table->timestamps();  // automatically adds created_at and updated_at timestamps
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
