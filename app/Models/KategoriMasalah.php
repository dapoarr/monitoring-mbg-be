<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMasalah extends Model
{
    use HasFactory;

    // Arahkan ke tabel yang benar
    protected $table = 'kategori_masalah';

    // Kolom yang bisa diisi
    protected $fillable = [
        'nama_kategori', // Contoh: "Kebersihan", "Fasilitas"
        'deskripsi'
    ];

    // --- RELASI ---
    
    // Satu Kategori bisa punya banyak Laporan
    public function laporan()
    {
        return $this->hasMany(LaporanMutu::class, 'kategori_masalah_id');
    }
}