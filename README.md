# 📡 Dokumentasi API - Monitoring MBG Sekolah

Backend ini dibuat menggunakan **Laravel 10** dan telah dideploy ke Vercel. Dokumentasi ini ditujukan untuk tim Frontend (Angular/Flutter/React) agar bisa mengintegrasikan API dengan benar.

---

## 🌍 Base URL (Server)

Gunakan URL ini sebagai awalan untuk **semua request**:

- **Production (Vercel):** `https://monitoring-mbg.vercel.app/api`
- **Local (Laptop Backend):** `http://localhost:8000/api`

> ⚠️ **Catatan:** Jangan lupa tambahkan `/api` di belakang domain!

---

## 🔐 Aturan Request (Header Wajib)

Setiap request ke endpoint (kecuali Login), Frontend **WAJIB** menyertakan Header berikut agar tidak ditolak server (Error 401/500):

| Key | Value | Keterangan |
| :--- | :--- | :--- |
| `Accept` | `application/json` | Supaya response error berupa JSON, bukan HTML. |
| `Authorization` | `Bearer <token_disini>` | Token didapat setelah Login sukses. |

---

## 🧪 Akun Tes (Untuk Development)

Gunakan akun ini untuk mengetes login dan fitur per role:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Guru** | `budi@sekolah.id` | `123456` |
| **Kepsek** | `kepsek@sekolah.id` | `123456` |
| **Admin** | `admin@sekolah.id` | `123456` |

---

## 🚀 Daftar Endpoint Produksi (Siap Pakai)

Tim Frontend sudah bisa mulai bekerja dengan menggunakan link produksi berikut:

| Nama Fitur | Method | URL Lengkap |
| :--- | :--- | :--- |
| **Cek Koneksi** | `GET` | `https://monitoring-mbg.vercel.app/api` |
| **Login** | `POST` | `https://monitoring-mbg.vercel.app/api/login` |
| **Register** | `POST` | `https://monitoring-mbg.vercel.app/api/register` |
| **Profil User** | `GET` | `https://monitoring-mbg.vercel.app/api/user` |
| **Clear Cache** | `GET` | `https://monitoring-mbg.vercel.app/api/clear-cache` |

---

## 📊 Detail Endpoint

### 1. Login (Mendapatkan Token)
* **Method:** `POST`
* **URL:** `/login`
* **Body (JSON):**
    ```json
    {
        "email": "budi@sekolah.id",
        "password": "123456"
    }
    ```
* **Response Sukses (200 OK):** Frontend **harus menyimpan** `token` dan `role` ke LocalStorage/SharedPreferences.

### 2. Cek User Saat Ini (Profile)
* **Method:** `GET`
* **URL:** `/user`
* **Header:** Wajib `Authorization: Bearer <token>`

### 3. Logout (Hapus Token)
* **Method:** `POST`
* **URL:** `/logout`
* **Keterangan:** Setelah ini token lama tidak akan bisa dipakai lagi.

---

## 🏗️ Endpoint Khusus Role (Dashboard)

Hanya bisa diakses jika role user sesuai.

- **Dashboard Guru:** `GET /dashboard/guru`
- **Dashboard Kepala Sekolah:** `GET /dashboard/kepsek`
- **Dashboard Admin TU:** `GET /dashboard/admin`

---

## 🐛 Troubleshooting (Jika Error)

1. **Error 401 (Unauthenticated):**
    * Cek apakah token sudah dikirim di Header?
    * Apakah formatnya benar? (`Bearer spasi token`)
    * Apakah token sudah expired/logout? Coba login ulang.

2. **Error 500 (Server Error):**
    * Biasanya terjadi jika header `Accept: application/json` lupa dikirim.
    * Atau ada masalah di backend (Hubungi Backend Dev).

3. **Error CORS:**
    * Pastikan Backend sudah mengizinkan domain frontend jika diakses langsung dari browser.