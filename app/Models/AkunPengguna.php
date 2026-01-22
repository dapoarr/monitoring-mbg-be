<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // PENTING: Pakai ini
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // PENTING: Untuk API Token

class AkunPengguna extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Arahkan ke tabel yang benar
    protected $table = 'akun_pengguna';

    protected $fillable = [
        'nama',      // Sesuai kolom db
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}