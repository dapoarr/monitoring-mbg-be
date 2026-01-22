<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\AuthController;

// === PUBLIC ROUTES (Bisa diakses tanpa login) ===
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// === PROTECTED ROUTES (Harus Login / Punya Token) ===
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Laporan (Sekarang kita taruh di sini biar aman, nanti kita tes)
    Route::post('/lapor', [LaporanController::class, 'store']);
    Route::get('/rekap', [LaporanController::class, 'rekap']);
    Route::patch('/lapor/{id}/status', [LaporanController::class, 'updateStatus']);// Route Update Status (Butuh ID laporan)
    Route::post('/lapor/{id}/upload', [LaporanController::class, 'uploadBukti']);// Route Upload Foto (Butuh ID laporan)
});