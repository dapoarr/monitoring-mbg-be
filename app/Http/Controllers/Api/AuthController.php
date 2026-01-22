<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AkunPengguna; // Pakai model custom kita
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // === REGISTER (Daftar Akun Baru) ===
    public function register(Request $request)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'nama'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:akun_pengguna',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,guru,kepsek,user'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 2. Buat User Baru
        $user = AkunPengguna::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Password di-hash
            'role'     => $request->role,
        ]);

        // 3. Buat Token (Surat Izin Masuk)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register Berhasil!',
            'data'    => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer'
        ], 201);
    }

    // === LOGIN (Masuk) ===
    public function login(Request $request)
    {
        // 1. Cek User berdasarkan Email
        $user = AkunPengguna::where('email', $request->email)->first();

        // 2. Cek apakah User ada & Password benar
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah'
            ], 401);
        }

        // 3. Jika benar, beri Token baru
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil!',
            'data'    => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer'
        ], 200);
    }

    // === LOGOUT (Keluar) ===
    public function logout(Request $request)
    {
        // Hapus semua token user yang sedang login
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}