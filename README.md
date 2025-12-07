# 📌 Sistem Perpustakaan – Framework SMT 3

---

## 👤 Developer

| Detail | Informasi |
|--------|-----------|
| **Nama** | Ivan Surya Buwana |
| **NIM** | G211240083 |
| **Mata Kuliah** | Framework Semester 3 |

---

## 📖 Deskripsi

Project ini adalah aplikasi website sederhana berbasis **Laravel**, dibuat sebagai tugas mata kuliah **Framework Semester 3**.  
Aplikasi ini menyediakan fitur pengelolaan data:
- 👥 **Anggota Perpustakaan** – CRUD data anggota (mahasiswa/member)
- 📚 **Daftar Buku** – CRUD katalog buku dengan kategori
- 📋 **Peminjaman Buku** – Pencatatan peminjaman dan pengembalian

**Fitur Khusus:**
- 🔐 Sistem Login berbasis **Username & Password** (hashed)
- 👤 Mode **Guest** – Pengunjung tanpa login dapat melihat data (read-only, tanpa akses CRUD)
- 🛡️ Middleware **auth** dan **guest** untuk proteksi route
- 📊 Pagination untuk menampilkan data dalam halaman

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Versi | Keterangan |
|-----------|-------|-----------|
| **Laravel** | 12.33.0 | Framework Web PHP |
| **PHP** | 8.5.0 | Server-side scripting |
| **MySQL / MariaDB** | - | Database |
| **Composer** | Latest | Package Manager PHP |
| **Bootstrap** | 5.3.2 | CSS Framework (Frontend) |

---

## ⚙️ Cara Instalasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/VanSec0x1337/IvanSuryaBuwana_G211240083_FrameworkSMT3.git
cd IvanSuryaBuwana_G211240083_FrameworkSMT3
```

### 2️⃣ Install Dependencies
```bash
composer install
```

### 3️⃣ Setup Environment File
```bash
cp .env.example .env
```

Kemudian edit `.env` dan sesuaikan dengan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpus
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Generate Application Key
```bash
php artisan key:generate
```

### 5️⃣ Jalankan Migrasi Database
```bash
php artisan migrate
```

### 6️⃣ Seed Data (Opsional)
```bash
php artisan db:seed
```

### 7️⃣ Jalankan Application
```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://127.0.0.1:8000**

---

## 📂 Struktur Folder

```
perpus/
├── app/
│   ├── Http/
│   │   └── Controllers/        # Controller untuk handle logika
│   │       ├── LoginController.php
│   │       ├── BukuController.php
│   │       ├── AnggotaController.php
│   │       └── PinjamController.php
│   └── Models/                 # Model Eloquent
│       ├── User_m.php
│       ├── Buku_m.php
│       ├── mst_anggota.php
│       └── Pinjam_m.php
├── resources/
│   └── views/                  # Blade templates
│       ├── login.blade.php
│       ├── ftik.blade.php      # Dashboard
│       ├── buku/
│       ├── anggota/
│       └── pinjam/
├── routes/
│   └── web.php                 # Route definitions
├── config/
│   ├── auth.php                # Auth configuration
│   ├── database.php
│   └── ...
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
└── storage/                    # File storage
```

---

## 🔑 Fitur Utama

### 1. **Autentikasi**
- Login dengan Username & Password
- Password dienkripsi menggunakan bcrypt
- Middleware `auth` melindungi route yang memerlukan login
- Middleware `guest` untuk halaman login (mencegah akses jika sudah login)

### 2. **Manajemen Anggota**
- ✅ Tambah anggota baru (CRUD)
- ✅ Edit data anggota
- ✅ Hapus anggota
- ✅ Lihat daftar anggota dengan pagination

### 3. **Manajemen Buku**
- ✅ Tambah buku baru (CRUD)
- ✅ Edit data buku
- ✅ Hapus buku
- ✅ Kategori buku
- ✅ Lihat daftar buku dengan pagination

### 4. **Peminjaman Buku**
- ✅ Catat peminjaman baru
- ✅ Edit peminjaman (ubah tanggal kembali)
- ✅ Hapus data peminjaman
- ✅ Tandai buku telah dikembalikan
- ✅ Lihat riwayat peminjaman

### 5. **Mode Guest (Baru)**
- 🔓 Pengunjung dapat masuk tanpa login
- 📖 Dapat melihat semua data (Anggota, Buku, Peminjaman)
- 🚫 Tidak dapat melakukan CRUD (tambah, edit, hapus)
- 🏠 Akses terbatas hanya untuk browsing/read-only
- ❌ Tombol CRUD tersembunyi untuk mode guest

---

## 🚀 Cara Menggunakan

### Login sebagai Admin
1. Buka http://127.0.0.1:8000/login
2. Masukkan **Username** dan **Password** (sesuai data di database) (username: admin | pw :admin123)
3. Klik tombol **Login**
4. Redirect ke dashboard `/perpus`
5. Akses semua fitur CRUD penuh

### Login sebagai Guest
1. Buka http://127.0.0.1:8000/login
2. Klik tombol **"Lanjutkan sebagai Guest"**
3. Anda akan masuk ke dashboard dalam mode read-only
4. Dapat melihat data Anggota, Buku, dan Peminjaman
5. Tombol CRUD akan tersembunyi
6. Klik **"Keluar Guest"** untuk kembali ke halaman login

---

## 📊 Route Mapping

| Route | Middleware | Keterangan |
|-------|-----------|-----------|
| `/login` | guest | Halaman login |
| `/` | auth | Dashboard utama (redirect ke `/perpus`) |
| `/perpus` | public | Dashboard (bisa diakses guest & admin) |
| `/buku` | public | Daftar buku (read-only untuk guest) |
| `/anggota` | public | Daftar anggota (read-only untuk guest) |
| `/pinjam` | public | Daftar peminjaman (read-only untuk guest) |
| `/buku/add`, `/buku/edit/*`, `/buku/delete/*` | auth | Manajemen buku (hanya admin) |
| `/anggota/add`, `/anggota/edit/*`, `/anggota/delete/*` | auth | Manajemen anggota (hanya admin) |
| `/pinjam/add`, `/pinjam/edit/*`, `/pinjam/delete/*` | auth | Manajemen peminjaman (hanya admin) |
| `/logout` | auth | Logout |

---

## 🔐 Keamanan

✅ **Password Hashing** – Menggunakan bcrypt untuk keamanan password  
✅ **CSRF Protection** – Token CSRF di semua form POST  
✅ **Route Protection** – Middleware `auth` & `guest` melindungi akses  
✅ **Session Management** – Session divalidasi di setiap request  
✅ **Read-only Mode** – Guest tidak dapat mengakses route CRUD  

---

## 📝 Catatan Pengembangan

- **Database**: Pastikan MariaDB/MySQL running sebelum menjalankan aplikasi
- **Seeder**: Gunakan `php artisan db:seed` untuk mengisi data dummy (jika tersedia)
- **Migration**: Jalankan `php artisan migrate` untuk membuat tabel database
- **Clear Cache**: Jika ada perubahan config, jalankan `php artisan config:clear`

---

## 🐛 Troubleshooting

### Error: "No application encryption key has been generated"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000]: General error"
Pastikan database sudah dibuat dan `.env` sudah dikonfigurasi dengan benar:
```bash
php artisan migrate
```

### Error: "Class not found"
```bash
composer dump-autoload
```

### Session tidak tersimpan
Pastikan folder `storage/` memiliki permission write:
```bash
chmod -R 775 storage
```

---

## 📄 Lisensi

Project ini dibuat untuk keperluan akademik.

---
