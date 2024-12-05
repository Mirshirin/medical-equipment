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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id(); // فیلد id (کلید اصلی)
            $table->string('id_number'); // نام تجهیزات
            $table->string('content'); // نام تجهیزات
            $table->string('status'); // نام تجهیزات
            $table->date('date'); // نام تجهیزات
            $table->timestamps(); // فیلدهای created_at و updated_at

            // اگر نیاز به روابط دارید، می‌توانید اینجا Foreign Key هم تعریف کنید:
            // $table->foreign('category_id')->references('id')->on('categories');
            // $table->foreign('supplier_id')->references('id')->on('suppliers');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
