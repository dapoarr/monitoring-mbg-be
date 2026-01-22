# 📡 Dokumentasi API - Monitoring MBG Sekolah

Backend ini dibuat menggunakan **Laravel**. Berikut adalah panduan untuk menghubungkan Frontend (Angular/Flutter) ke API.

## 🌍 Konfigurasi Utama
Frontend harus menggunakan Base URL ini untuk semua request:

- **Base URL (Local):** `http://localhost:8000/api`
- **Base URL (Online/Hosting):** `http://backend-sekolah-mbg.infinityfreeapp.com/api`

---

## 🔄 Alur Autentikasi (PENTING)
Sistem ini menggunakan **Bearer Token**. Frontend harus mengikuti alur ini:

1.  **Login Dulu:** User melakukan request ke endpoint `/login`.
2.  **Simpan Token:** Jika sukses, API akan membalas dengan `token`. Frontend **wajib menyimpan** token ini (di *LocalStorage* untuk Angular atau *SharedPreferences* untuk Flutter).
3.  **Pakai Token:** Setiap kali Frontend mengakses halaman tertutup (seperti Dashboard), token harus dikirim di **Header**.

**Format Header:**
```json
Authorization: Bearer <token_yang_disimpan>
Accept: application/json

wait masi ada lagi