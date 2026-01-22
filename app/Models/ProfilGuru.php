<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilGuru extends Model
{
    use HasFactory;

    protected $table = 'profil_guru';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nip',
        'mata_pelajaran',
        'kelas_wali',
    ];

    // Relasi: Profil milik 1 Akun Pengguna
    public function akun()
    {
        return $this->belongsTo(AkunPengguna::class, 'user_id');
    }
}