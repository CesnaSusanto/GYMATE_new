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
        Schema::create('personal_trainer', function (Blueprint $table) {
            $table->id('id_personal_trainer');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // Pastikan merujuk 'user_id'
            $table->string('nama_personal_trainer', 255); // Panjang 255 untuk nama
            $table->string('jenis_kelamin', 20)->nullable(); // Panjang 20 untuk jenis kelamin (misal: "Laki-laki")
            $table->string('no_telp', 20)->nullable(); // Panjang 20 untuk nomor telepon (cukup untuk format internasional)
            $table->timestamps();

            // $table->unique('user_id'); // Tetap dipertahankan untuk relasi 1:1 user-to-trainer
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_trainer');
    }
};
