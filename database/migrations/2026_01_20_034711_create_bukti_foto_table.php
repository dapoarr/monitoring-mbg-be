<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_foto', function (Blueprint $table) {
            $table->id();
            // Terhubung ke laporan_mutu. Hapus laporan = hapus foto.
            $table->foreignId('laporan_mutu_id')->constrained('laporan_mutu')->onDelete('cascade');
            $table->string('path_foto'); 
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_foto');
    }
};