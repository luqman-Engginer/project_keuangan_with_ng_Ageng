# 💰 Project Pencatatan Keuangan

Aplikasi web **Pencatatan Keuangan** (Fullstack Laravel + MySQL + Blade + Tailwind CSS) untuk tugas sekolah.

Source code lengkap aplikasi berada di dalam direktori: **`keuangan_baru/`**

---

## ⚡ Cara Cepat Menjalankan Aplikasi

1. Buka terminal dan masuk ke folder `keuangan_baru`:
   ```bash
   cd keuangan_baru
   ```

2. Pastikan MySQL sudah menyala (misalnya melalui Laragon atau XAMPP), lalu jalankan migrasi & seeder:
   ```bash
   php artisan migrate:fresh --seed
   ```

3. Jalankan server Laravel:
   ```bash
   php artisan serve
   ```

4. Buka browser: [http://localhost:8000](http://localhost:8000)

---

## 👥 Akun Demo untuk Pengujian

Semua akun demo menggunakan password: `password`

- **Admin**: `admin@example.com`
- **User 1**: `budi@example.com`
- **User 2**: `siti@example.com`

---

## 🧪 Menjalankan Automated Tests

Seluruh checklist spesifikasi diuji secara otomatis menggunakan 32 test case:
```bash
cd keuangan_baru
php artisan test
```

Dokumentasi lengkap dan rincian fitur dapat dibaca di [keuangan_baru/README.md](keuangan_baru/README.md).

