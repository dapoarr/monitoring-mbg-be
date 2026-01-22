<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'aktivitas',  // misal: "Login", "Kirim Laporan"
        'detail',     // data JSON atau text tambahan
        'ip_address',
    ];

    // Relasi: Log milik 1 User (bisa null jika user dihapus)
    public function user()
    {
        return $this->belongsTo(AkunPengguna::class, 'user_id');
    }
}