<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_mutu', function (Blueprint $table) {
            $table->id();
            // Pelapor (User)
            $table->foreignId('pelapor_id')->nullable()->constrained('akun_pengguna');
            
            // Kategori Masalah (Relasi ke tabel kategori)
            // Menggunakan nullable() agar jika kategori dihapus, laporan tidak error
            $table->foreignId('kategori_masalah_id')->nullable()->constrained('kategori_masalah')->onDelete('set null');
            
            $table->string('judul_laporan');
            $table->text('deskripsi');
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_mutu');
    }
};