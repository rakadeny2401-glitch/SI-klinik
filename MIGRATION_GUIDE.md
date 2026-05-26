# Puskesmas Laravel Migration

Project ini adalah hasil migrasi dari project PHP asli ke Laravel framework dengan minimal perubahan pada kode asli.

## Struktur Folder

```
puskesmas-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # File controller dari project lama
│   │   └── Middleware/
│   ├── Helpers/
│   │   └── koneksi.php          # Database connection helper (backward compatible)
│   └── Providers/
│       └── LegacyCodeProvider.php # Service provider untuk legacy code
├── database/
│   ├── puskesmas.sql             # Database schema asli
│   └── migrations/
├── public/
│   ├── css/                       # Semua CSS files dari style/css
│   ├── js/                        # Semua JS files dari style/js
│   └── index.php                  # Laravel entry point
├── resources/
│   └── views/                     # Semua PHP view files dari view/
├── routes/
│   └── web.php                    # Routing configuration
├── .env                           # Environment configuration
└── README.md                      # This file
```

## Konfigurasi Database

File `.env` sudah dikonfigurasi dengan database settings dari project lama:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=puskesmas
DB_USERNAME=root
DB_PASSWORD=123
```

Database schema tersimpan di `database/puskesmas.sql`. Import file ini ke MySQL Anda:

```bash
mysql -u root -p123 < database/puskesmas.sql
```

## Cara Menjalankan Project

1. **Install dependencies** (jika belum):
   ```bash
   composer install
   ```

2. **Setup environment** (sudah otomatis):
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Jalankan development server**:
   ```bash
   php artisan serve
   ```

   Server akan berjalan di `http://localhost:8000`

4. **Alternative: Gunakan Laragon**:
   Project dapat langsung diakses di `http://puskesmas-laravel.test` atau sesuai konfigurasi Laragon Anda.

## Struktur File yang Dimigrasikan

### Controller Files
Semua file dari folder `controller/` dipindahkan ke `app/Http/Controllers/` tanpa perubahan pada kode.

### View Files
Semua file dari folder `view/` dipindahkan ke `resources/views/` dengan struktur folder yang sama.

### Static Assets
- CSS files: `style/css/` → `public/css/`
- JS files: `style/js/` → `public/js/`

### Database Connection
Database connection sudah diintegrasikan dengan Laravel melalui `app/Providers/LegacyCodeProvider.php`.

## Fitur Backward Compatibility

Kode lama dapat langsung berfungsi dengan:

1. **Global `$koneksi` variable**: Tersedia otomatis melalui Service Provider
2. **Database Helper**: File `app/Helpers/koneksi.php` menyediakan fallback connection
3. **Session Management**: Dikonfigurasi di `.env` menggunakan database

## Catatan Penting

1. **Semua kode asli tetap tidak diubah** - hanya dikopikan ke struktur Laravel
2. **File controller lama dapat langsung digunakan** - mereka sudah di folder yang benar
3. **Perubahan minimal pada struktur** - hanya penyesuaian path dan konfigurasi
4. **Session dan database sudah dikonfigurasi** - tidak perlu setup tambahan

## Troubleshooting

### Koneksi database gagal
- Pastikan MySQL sudah berjalan
- Verifikasi konfigurasi di file `.env`
- Pastikan database `puskesmas` sudah dibuat dan punya data dari `puskesmas.sql`

### Session tidak berfungsi
- Pastikan table `sessions` sudah dibuat di database
- Jalankan: `php artisan migrate`

### Static files (CSS/JS) tidak loaded
- Pastikan Anda menggunakan `{{ asset('css/filename.css') }}` di view
- Atau cek folder `public/css/` dan `public/js/` sudah ada filenya

## Next Steps (Optional)

Untuk modernisasi lebih lanjut:
1. Refactor controller ke Laravel controller class
2. Buat service layer untuk business logic
3. Gunakan Eloquent ORM untuk database queries
4. Implement API endpoints
5. Add authentication middleware Laravel

---

Generated: 2026-05-26
Project: Puskesmas Laravel Migration
