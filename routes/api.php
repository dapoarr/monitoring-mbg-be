<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan; // <-- Agar Artisan terbaca
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rute Dasar untuk mengecek status API di Vercel
Route::get('/', function () {
    return response()->json([
        'status' => 'API is running',
        'project' => 'Sistem Monitoring MBG',
        'version' => '1.0.0'
    ]);
});

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

    // Laporan
    Route::post('/lapor', [LaporanController::class, 'store']);
    Route::get('/rekap', [LaporanController::class, 'rekap']);
    
    // Route Update Status (Butuh ID laporan)
    Route::patch('/lapor/{id}/status', [LaporanController::class, 'updateStatus']);
    
    // Route Upload Foto (Butuh ID laporan)
    Route::post('/lapor/{id}/upload', [LaporanController::class, 'uploadBukti']);
    
});

// Route untuk bersihkan cache (Sangat berguna di Vercel)
Route::get('/clear-cache', function() {
    Artisan::call('route:clear');
    Artisan::call('config:clear'); // Ditambahkan untuk pembersihan lebih maksimal
    return response()->json(["message" => "Route and Config cache cleared!"]);
});