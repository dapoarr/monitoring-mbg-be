<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMutu extends Model
{
    use HasFactory;

    protected $table = 'laporan_mutu';

    protected $fillable = [
        'pelapor_id',
        'kategori_masalah_id', // Pastikan nama kolom sama persis dgn DB
        'judul_laporan',
        'deskripsi',
        'status'
    ];

    // --- RELASI (Hubungan antar tabel) ---

    // 1. Laporan dimiliki oleh satu Pelapor (AkunPengguna)
    public function pelapor()
    {
        return $this->belongsTo(AkunPengguna::class, 'pelapor_id');
    }

    // 2. Laporan punya satu Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriMasalah::class, 'kategori_masalah_id');
    }
    
    // 3. Laporan punya banyak Bukti Foto (Opsional nanti)
    public function foto()
    {
        return $this->hasMany(BuktiFoto::class, 'laporan_mutu_id');
    }
}