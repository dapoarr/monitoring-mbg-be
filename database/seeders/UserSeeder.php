<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AkunPengguna; // Pastikan ini sesuai Model Anda (bisa User atau AkunPengguna)
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Akun Guru (Pak Budi)
        // Cek dulu biar gak duplikat
        if (!AkunPengguna::where('email', 'budi@sekolah.id')->exists()) {
            AkunPengguna::create([
                'nama'     => 'Pak Budi',
                'email'    => 'budi@sekolah.id',
                'password' => Hash::make('123456'), // Password di-hash
                'role'     => 'guru',
            ]);
        }

        // 2. Buat Akun Kepala Sekolah (Pak Hartono)
        if (!AkunPengguna::where('email', 'kepsek@sekolah.id')->exists()) {
            AkunPengguna::create([
                'nama'     => 'Pak Hartono',
                'email'    => 'kepsek@sekolah.id',
                'password' => Hash::make('123456'), // Password di-hash
                'role'     => 'kepsek', // Role khusus kepsek
            ]);
        }
        
        // 3. Buat Akun Admin (Opsional)
        if (!AkunPengguna::where('email', 'admin@sekolah.id')->exists()) {
            AkunPengguna::create([
                'nama'     => 'Admin TU',
                'email'    => 'admin@sekolah.id',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]);
        }
    }
}