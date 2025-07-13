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
        Schema::create('kartu', function (Blueprint $table) {
            $table->id('id_kartu');
            $table->foreignId('id_personal_trainer')->constrained('personal_trainer', 'id_personal_trainer')->onDelete('cascade');
            $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan')->onDelete('cascade');
            $table->date('tanggal_latihan');
            $table->string('kegiatan_latihan', 255); // Panjang 255 untuk kegiatan latihan
            $table->text('catatan_latihan')->nullable(); // Text sudah baik untuk panjang tak terbatas
            $table->timestamps();
            // Opsional: Jika satu trainer hanya bisa memberikan satu "kartu" per pelanggan per tanggal
            // $table->unique(['id_personal_trainer', 'id_pelanggan', 'tanggal_latihan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu');
    }
};
