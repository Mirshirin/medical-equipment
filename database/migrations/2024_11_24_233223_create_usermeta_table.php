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
        Schema::create('usermeta', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign key to users table
            //$table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('user_id');
            // Meta key
            $table->string('meta_key')->index();

            // Meta value
            $table->text('meta_value');

            // Additional columns if needed (e.g., created_at, updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usermeta', function (Blueprint $table) {
            //
        });
    }
};
