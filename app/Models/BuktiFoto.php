<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiFoto extends Model
{
    use HasFactory;

    protected $table = 'bukti_foto';

    protected $fillable = [
        'laporan_mutu_id',
        'path_foto',
        'keterangan',
    ];

    // --- TAMBAHAN MAGIC (Accessor) ---
    // Ini memerintahkan Laravel: "Setiap kali kirim JSON, lampirkan field 'url_lengkap'"
    protected $appends = ['url_lengkap'];

    // Ini rumus pembuatan link-nya
    public function getUrlLengkapAttribute()
    {
        return url('storage/' . $this->path_foto);
    }

    // Relasi
    public function laporan()
    {
        return $this->belongsTo(LaporanMutu::class, 'laporan_mutu_id');
    }
}