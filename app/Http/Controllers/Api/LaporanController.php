<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanMutu;
use Illuminate\Support\Facades\Validator;
use App\Models\BuktiFoto; 
use Illuminate\Support\Facades\Storage;


class LaporanController extends Controller
{
    // === API POST /lapor (Wajib Login/Token) ===
    public function store(Request $request)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'judul_laporan' => 'required|string',
            'deskripsi'     => 'required|string',
            'kategori_id'   => 'required|numeric', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 2. Simpan ke Database
        $laporan = LaporanMutu::create([
            'judul_laporan'       => $request->judul_laporan,
            'deskripsi'           => $request->deskripsi,
            'pelapor_id'          => $request->user()->id, 
            'kategori_masalah_id' => $request->kategori_id,
            'status'              => 'pending',
        ]);

        // 3. Respon JSON Sukses
        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim oleh ' . $request->user()->nama, 
            'data'    => $laporan
        ], 201);
    }

    // === API GET /rekap (UPDATED) ===
    public function rekap()
    {
        // Tambahkan 'foto' di dalam array with()
        // Ini memanfaatkan relasi hasMany yang sudah kita buat di Model LaporanMutu
        $data = LaporanMutu::with(['pelapor', 'kategori', 'foto'])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Rekap Laporan',
            'data'    => $data
        ], 200);
    }

    // === API PATCH /lapor/{id}/status ===
    public function updateStatus(Request $request, $id)
    {
        // 1. Cari Laporan berdasarkan ID
        $laporan = LaporanMutu::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        // 2. Validasi
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,diproses,selesai'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 3. Proses Update
        $laporan->status = $request->status;
        $laporan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah menjadi ' . $request->status,
            'data'    => $laporan
        ], 200);
    }

    // === API POST /lapor/{id}/upload (BARU) ===
    public function uploadBukti(Request $request, $id)
    {
        // 1. Cek apakah Laporannya ada?
        $laporan = LaporanMutu::find($id);
        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        // 2. Validasi File (Wajib Gambar, Maks 2MB)
        $validator = Validator::make($request->all(), [
            'foto'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 3. Proses Simpan File ke Storage
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Buat nama unik (biar gak bentrok)
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan ke folder "storage/app/public/bukti"
            $path = $file->storeAs('public/bukti', $filename);

            // 4. Simpan Path ke Database
            $bukti = BuktiFoto::create([
                'laporan_mutu_id' => $id,
                'path_foto'       => 'bukti/' . $filename, 
                'keterangan'      => $request->keterangan ?? 'Bukti Tambahan'
            ]);

            // Buat URL lengkap agar Frontend enak manggilnya
            $url_lengkap = url('storage/bukti/' . $filename);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil diupload!',
                'data'    => [
                    'file_info' => $bukti,
                    'url'       => $url_lengkap
                ]
            ], 201);
        }

        return response()->json(['message' => 'Gagal upload file'], 500);
    }
}