# 🏥 Puskesmas Management System - Laravel Edition

Ini adalah hasil migrasi project Puskesmas PHP asli ke framework Laravel dengan

## 📋 Daftar Isi

- [Fitur](#fitur)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Menjalankan Project](#menjalankan-project)
- [Struktur Project](#struktur-project)
- [Database](#database)
- [Troubleshooting](#troubleshooting)

## ✨ Fitur

- 👥 Manajemen Pengguna (Admin, Dokter, Petugas)
- 🏥 Manajemen Pasien
- 📋 Manajemen Pendaftaran
- 🩺 Manajemen Pemeriksaan
- 📄 Pembuatan Surat (Rujukan, Keterangan Sakit)
- 💊 Manajemen Resep
- 🔐 Autentikasi Role-Based Access Control (RBAC)

## 💻 Persyaratan Sistem

- **PHP**: 8.3 atau lebih tinggi
- **MySQL**: 5.7 atau lebih tinggi
- **Composer**: Terbaru
- **Web Server**: Apache, Nginx, atau built-in PHP server

## 🚀 Instalasi

### 1. Project Sudah Ada

Project sudah tersedia di: `c:\laragon\www\puskesmas-laravel`

### 2. Install Dependencies

**Windows (PowerShell):**
```powershell
cd c:\laragon\www\puskesmas-laravel
.\setup.ps1
```

**Manual:**
```bash
composer install
php artisan key:generate
composer dump-autoload
```

### 3. Setup Database

Import database schema:

```bash
mysql -u root -p123 puskesmas < database/puskesmas.sql
```

### 4. Verifikasi Environment

File `.env` sudah pre-configured. Verifikasi konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=puskesmas
DB_USERNAME=root
DB_PASSWORD=123
```

## 🏃 Menjalankan Project

### Option 1: PHP Built-in Server

```bash
cd c:\laragon\www\puskesmas-laravel
php artisan serve
```

Akses di: `http://localhost:8000`

### Option 2: Menggunakan Laragon

1. Project sudah tersedia di Laragon
2. Akses di: `http://puskesmas-laravel.test`

## 📁 Struktur Project

```
puskesmas-laravel/
├── app/
│   ├── Http/Controllers/          # Controller dari project lama
│   ├── Helpers/                   # Helper functions
│   │   ├── LegacyHelpers.php      # Kompatibilitas helpers
│   │   └── koneksi.php            # Database connection
│   └── Providers/
│       └── LegacyCodeProvider.php  # Legacy code integration
├── database/
│   ├── puskesmas.sql              # Database schema original
│   └── migrations/
├── public/
│   ├── css/                       # CSS files
│   ├── js/                        # JS files
│   └── uploads/                   # Upload directory
├── resources/views/
│   ├── admin/                     # Admin views
│   ├── dokter/                    # Doctor views
│   ├── pasien/                    # Patient views
│   ├── login/                     # Login views
│   └── layout/                    # Shared layouts
├── routes/
│   └── web.php                    # Web routes
├── .env                           # Environment config
├── setup.sh / setup.ps1           # Setup scripts
└── MIGRATION_GUIDE.md             # Migration documentation
```

## 🗄️ Database

Database sudah berisi semua tabel sesuai schema `puskesmas.sql`.

Untuk login default, cek langsung di database table `pengguna`.

Backup database:
```bash
mysqldump -u root -p123 puskesmas > backup_puskesmas.sql
```

## 🔐 Login

Login page: `http://localhost:8000/login`

## 🐛 Troubleshooting

### Database Connection Error

```bash
# Pastikan MySQL running dan database ada
mysql -u root -p123 -e "SELECT 1"

# Jika belum, import database
mysql -u root -p123 puskesmas < database/puskesmas.sql
```

### CSS/JS Tidak Ter-load

Gunakan helper `asset()` di view:
```php
<link rel="stylesheet" href="<?php echo asset('css/filename.css'); ?>">
```

### Session Error

```bash
php artisan migrate
chmod -R 755 storage
```

### Permission Denied

```bash
chmod -R 755 storage bootstrap/cache
```

## 📚 Dokumentasi Lengkap

Lihat file `MIGRATION_GUIDE.md` untuk dokumentasi lebih detail tentang struktur project dan backward compatibility.

## ℹ️ Notes

- ✅ Semua kode asli tetap berfungsi tanpa perubahan
- ✅ Database connection tersedia di variable global `$koneksi`
- ✅ Helper functions tersedia untuk kompatibilitas
- ✅ Session management menggunakan Laravel dengan database driver

---

**Last Updated**: 2026-05-26  
**Laravel Version**: 13.x  
**PHP Version**: 8.3+

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
