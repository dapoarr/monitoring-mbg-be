<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilKepsek extends Model
{
    use HasFactory;

    protected $table = 'profil_kepsek';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nip',
        'jabatan',
    ];

    // Relasi: Profil milik 1 Akun Pengguna
    public function akun()
    {
        return $this->belongsTo(AkunPengguna::class, 'user_id');
    }
}