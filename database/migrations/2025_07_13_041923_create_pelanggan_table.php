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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // Pastikan merujuk 'user_id'
            $table->string('nama_pelanggan', 255); // Panjang 255 untuk nama
            $table->string('jenis_kelamin', 20)->nullable(); // Panjang 20 untuk jenis kelamin
            $table->string('no_telp', 20)->nullable(); // Panjang 20 untuk nomor telepon
            $table->date('tanggal_bergabung')->nullable();
            $table->enum('paket_layanan', ['biasa', 'premium'])->default('biasa');            
            $table->integer('berat_badan')->nullable(); // Diubah menjadi integer
            $table->integer('tinggi_badan')->nullable(); // Diubah menjadi integer
            $table->string('status', 20)->default('aktif'); // Panjang 20 untuk status (misal: "aktif", "nonaktif", "pending")
            $table->timestamps();

            // $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            // Opsional: Pastikan satu user_id hanya bisa menjadi satu pelanggan
            // $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
