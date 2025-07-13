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
        Schema::create('catatan', function (Blueprint $table) {
            $table->id('id_catatan');
            $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan')->onDelete('cascade');
            $table->date('tanggal_latihan');
            $table->string('kegiatan_latihan', 255); // Panjang 255 untuk kegiatan latihan
            $table->text('catatan_latihan')->nullable(); // Text sudah baik untuk panjang tak terbatas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan');
    }
};
