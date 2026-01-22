# 📡 Dokumentasi API - Monitoring MBG Sekolah

Backend ini dibuat menggunakan **Laravel 10** dan sudah dideploy ke Vercel.
Dokumentasi ini ditujukan untuk tim Frontend (Angular/Flutter/React) agar bisa mengintegrasikan API dengan benar.

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

## 🚀 Daftar Endpoint

### 1. Login (Mendapatkan Token)
* **Method:** `POST`
* **URL:** `/login`
* **Body (Form-Data / JSON):**
    ```json
    {
        "email": "budi@sekolah.id",
        "password": "123456"
    }
    ```
* **Response Sukses (200 OK):**
    Frontend **harus menyimpan** `token` dan `role` ke LocalStorage/SharedPreferences.
    ```json
    {
        "message": "Login berhasil",
        "user": {
            "id": 1,
            "nama": "Pak Budi",
            "email": "budi@sekolah.id",
            "role": "guru"
        },
        "token": "13|LaravelSanctumTokenPanjangSekali..."
    }
    ```

### 2. Cek User Saat Ini (Profile)
Mengambil data user yang sedang login berdasarkan token.
* **Method:** `GET`
* **URL:** `/user`
* **Header:** Wajib `Authorization: Bearer <token>`

### 3. Logout (Hapus Token)
* **Method:** `POST`
* **URL:** `/logout`
* **Header:** Wajib `Authorization: Bearer <token>`
* **Keterangan:** Setelah ini token lama tidak akan bisa dipakai lagi.

---

## 📊 Endpoint Khusus Role (Dashboard)

Endpoint ini hanya bisa diakses jika role user sesuai.

### A. Dashboard Guru
* **Method:** `GET`
* **URL:** `/dashboard/guru`
* **Header:** Wajib `Authorization: Bearer <token>`
* **Akses:** Hanya user dengan role `guru`.

### B. Dashboard Kepala Sekolah
* **Method:** `GET`
* **URL:** `/dashboard/kepsek`
* **Header:** Wajib `Authorization: Bearer <token>`
* **Akses:** Hanya user dengan role `kepsek`.

### C. Dashboard Admin TU
* **Method:** `GET`
* **URL:** `/dashboard/admin`
* **Header:** Wajib `Authorization: Bearer <token>`
* **Akses:** Hanya user dengan role `admin`.

---

## 🐛 Troubleshooting (Jika Error)

1.  **Error 401 (Unauthenticated):**
    * Cek apakah token sudah dikirim di Header?
    * Apakah formatnya benar? (`Bearer spasi token`)
    * Apakah token sudah expired/logout? Coba login ulang.

2.  **Error 500 (Server Error):**
    * Biasanya terjadi jika header `Accept: application/json` lupa dikirim.
    * Atau ada masalah di backend (Hubungi Backend Dev).

3.  **Error CORS:**
    * Jika dites dari browser langsung (Localhost frontend ke Vercel backend), pastikan Backend sudah mengizinkan domain frontend.