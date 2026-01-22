<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_kepsek', function (Blueprint $table) {
            $table->id();
            // Terhubung ke akun_pengguna
            $table->foreignId('user_id')->constrained('akun_pengguna')->onDelete('cascade'); 
            $table->string('nama_lengkap');
            
            // --- TAMBAHAN BARU ---
            $table->string('email')->nullable();    // Tambahkan ini
            $table->string('password')->nullable(); // Tambahkan ini
            // ---------------------

            $table->string('nip')->nullable();
            $table->string('jabatan')->default('Kepala Sekolah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_kepsek');
    }
};