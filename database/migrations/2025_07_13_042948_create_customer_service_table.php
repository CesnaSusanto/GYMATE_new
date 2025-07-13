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
        Schema::create('customer_service', function (Blueprint $table) {
            $table->id('id_cs');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // Pastikan merujuk 'user_id'
            $table->string('nama_cs', 255); // Panjang 255 untuk nama
            $table->timestamps();

            // $table->unique('user_id'); // Tetap dipertahankan untuk relasi 1:1 user-to-cs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_service');
    }
};
