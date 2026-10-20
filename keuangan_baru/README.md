# 💰 Aplikasi Pencatatan Keuangan

Aplikasi web pencatatan keuangan sederhana, aman, dan mudah dipahami, dirancang untuk tugas sekolah dengan stack **Laravel 11 / 12 / 13 + MySQL + Blade + Tailwind CSS**.

---

## 🌟 Fitur Utama

### 1. Autentikasi & Akun
- **Pendaftaran Akun (Register)**: Akun baru otomatis memiliki role `user` dan status `aktif`. Password di-hash menggunakan algoritma Bcrypt.
- **Login & Logout**: Autentikasi berbasis session, dilindungi proteksi CSRF dan rate limiting.
- **Cek Status Akun**: Akun dengan status `nonaktif` tidak dapat login dan otomatis dikeluarkan jika dinonaktifkan di tengah sesi.
- **Profil Pengguna**: Lihat dan perbarui nama, email (validasi unik), serta ganti password baru.

### 2. Fitur Pengguna (User)
- **Ringkasan Keuangan (Dashboard)**:
  - 3 kartu ringkasan: Total Pemasukan, Total Pengeluaran, dan Saldo Saat Ini.
  - Tabel transaksi terbaru.
  - Seluruh angka diformat ke mata uang Rupiah (`Rp 1.500.000`).
- **Isi Saldo (Top-Up)**: Fitur isi saldo langsung tercatat otomatis sebagai pemasukan dengan kategori bawaan *Isi Saldo*.
- **Pencatatan Keuangan (CRUD)**:
  - Tambah catatan pemasukan atau pengeluaran (jumlah, tanggal, keterangan, kategori).
  - Edit catatan keuangan yang sudah ada.
  - Hapus catatan keuangan dengan konfirmasi.
  - Riwayat catatan dengan filter berdasarkan Jenis (*Semua / Pemasukan / Pengeluaran*) dan Kategori.
- **Validasi Saldo & Kepemilikan Data**:
  - Saldo dihitung langsung dari database (`Total Pemasukan − Total Pengeluaran`).
  - Sistem menolak transaksi pengeluaran atau edit/hapus pemasukan yang membuat saldo menjadi negatif.
  - Setiap pengguna hanya dapat membaca, mengedit, atau menghapus datanya sendiri. Akses manipulasi ID melalui URL langsung ditolak (`403 Forbidden`).
- **Kategori Fleksibel**:
  - Menggunakan kategori bawaan (misal: *Gaji, Uang Saku, Makan, Transportasi, Belanja, Tagihan, dll.*).
  - Pengguna dapat membuat kategori khusus sendiri (hanya terlihat dan dapat dihapus oleh pemiliknya).
  - Kategori yang masih terikat transaksi dilindungi dari penghapusan tidak disengaja.

### 3. Fitur Administrator (Admin)
- **Kelola Pengguna**:
  - Melihat daftar seluruh pengguna terdaftar lengkap dengan status, role, dan tanggal bergabung.
  - Fitur pencarian pengguna berdasarkan nama atau email.
  - Menonaktifkan atau mengaktifkan kembali akun pengguna (toggle status).
  - Menghapus akun pengguna beserta seluruh catatan keuangannya (*cascade delete*).
  - Admin dilindungi dari menonaktifkan atau menghapus akunnya sendiri.
- **Proteksi Hak Akses**:
  - Seluruh route admin diproteksi oleh middleware `admin`. Pengguna biasa yang mencoba membuka URL admin akan menerima respons `403 Akses Ditolak`.

---

## 🛠️ Tech Stack & Persyaratan Sistem

- **PHP**: >= 8.2 (direkomendasikan PHP 8.3 / 8.4 / 8.5)
- **Database**: MySQL / MariaDB (misal via Laragon atau XAMPP)
- **Web Framework**: Laravel (Blade Template Engine)
- **Styling**: Tailwind CSS
- **Composer**: Dependency Manager PHP
- **Node.js & NPM**: Untuk build asset frontend

---

## 🚀 Panduan Instalasi & Menjalankan Aplikasi

### 1. Masuk ke Direktori Project
```bash
cd keuangan_baru
```

### 2. Install Dependensi PHP & JavaScript
```bash
composer install
npm install
npm run build
```

### 3. Konfigurasi File Lingkungan (.env)
Salin contoh file `.env.example` menjadi `.env` jika belum ada:
```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi koneksi database MySQL di file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pencatatan_keuangan
DB_USERNAME=root
DB_PASSWORD=
```
> **Catatan**: Pastikan database `pencatatan_keuangan` sudah dibuat di MySQL (atau buat database baru melalui phpMyAdmin/HeidiSQL).

### 4. Jalankan Migrasi & Seeder Database
Jalankan perintah berikut untuk membuat seluruh tabel dan mengisi data awal/demo:
```bash
php artisan migrate:fresh --seed
```

Perintah di atas akan mengeksekusi:
1. Pembuatan tabel `users`, `categories`, dan `transactions`.
2. Pembuatan 1 akun Administrator.
3. Pembuatan kategori bawaan (Gaji, Uang Saku, Bonus, Isi Saldo, Makan, Transportasi, Belanja, Pendidikan, Hiburan, Tagihan, Lainnya).
4. Pembuatan 2 akun pengguna contoh (Budi & Siti) beserta contoh riwayat transaksinya.

### 5. Jalankan Web Server
Jalankan server pengembangan Laravel:
```bash
php artisan serve
```
Akses aplikasi melalui browser di: [http://localhost:8000](http://localhost:8000)

---

## 👥 Akun Demo untuk Pengujian

Semua akun demo di bawah ini menggunakan password default: `password`

| Role | Nama | Email | Password | Keterangan |
| :--- | :--- | :--- | :--- | :--- |
| **Admin** | Admin Sistem | `admin@example.com` | `password` | Pengelola sistem & kelola user |
| **User** | Budi Santoso | `budi@example.com` | `password` | Sudah ada saldo & transaksi contoh |
| **User** | Siti Aminah | `siti@example.com` | `password` | Akun user kedua untuk uji isolasi data |

---

## 🧪 Menjalankan Pengujian Otomatis (Testing)

Project dilengkapi 32 pengujian otomatis (Pest / PHPUnit) yang mencakup seluruh poin checklist pengujian:
```bash
php artisan test
```

### Skenario yang Teruji:
- [x] Register akun baru dan langsung login.
- [x] Hash password di database (tidak ada plain text).
- [x] Login dengan email & password yang benar / salah.
- [x] Penolakan login untuk akun nonaktif dengan pesan informatif.
- [x] Logout dan penghancuran sesi.
- [x] Isolasi data: User A tidak bisa melihat, mengedit, atau menghapus transaksi User B.
- [x] Proteksi URL Admin: User biasa ditolak dengan status HTTP `403`.
- [x] Kalkulasi dashboard: Total pemasukan, pengeluaran, dan saldo konsisten.
- [x] Fitur isi saldo menambah saldo dan tercatat sebagai pemasukan.
- [x] Cegah transaksi pengeluaran yang membuat saldo bernilai negatif.
- [x] Edit dan hapus transaksi memperbarui saldo dan total dengan tepat.
- [x] Pencegahan penghapusan pemasukan jika membuat saldo menjadi negatif.
- [x] Isolasi kategori: Kategori buatan user tidak muncul di akun user lain.
- [x] Kategori bawaan tidak dapat dihapus pengguna biasa.
- [x] Kategori yang terikat transaksi tidak dapat dihapus.
- [x] Admin dapat mencari user, mengaktifkan/menonaktifkan, dan menghapus user.
- [x] Admin dicegah menghapus atau menonaktifkan akunnya sendiri.
- [x] Update profil (nama, email unik, dan password).

---

## 📁 Struktur Folder Utama

```
keuangan_baru/
├── app/
│   ├── Helpers/
│   │   └── helpers.php             # Helper formatting Rupiah
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Register, Login, Logout
│   │   │   ├── CategoryController.php      # CRUD Kategori User
│   │   │   ├── DashboardController.php     # Ringkasan Saldo & Riwayat
│   │   │   ├── ProfileController.php       # Edit Nama, Email, Password
│   │   │   ├── TransactionController.php   # CRUD Transaksi & Isi Saldo
│   │   │   └── Admin/
│   │   │       └── UserController.php      # Kelola User (Admin)
│   │   └── Middleware/
│   │       ├── EnsureUserIsActive.php      # Cek status akun aktif
│   │       └── EnsureUserIsAdmin.php       # Guard role admin
│   └── Models/
│       ├── Category.php            # Model kategori keuangan
│       ├── Transaction.php         # Model transaksi
│       └── User.php                # Model user + method saldo()
├── database/
│   ├── migrations/                 # Skema tabel database
│   └── seeders/                    # Seeder admin, user, & kategori
├── resources/
│   └── views/                      # Template Blade (UI Bahasa Indonesia)
└── tests/
    └── Feature/                    # Test suite otomatis (Pest)
```
