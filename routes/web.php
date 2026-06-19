<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SpesialisController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\LihatPendaftaranController;

use App\Http\Controllers\Dokter\DashboardController as DokterDashboardController;
use App\Http\Controllers\Dokter\DaftarPasienController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\ResepObatController;
use App\Http\Controllers\Dokter\PertanyaanSuratController;
use App\Http\Controllers\Dokter\SuratSakitController;
use App\Http\Controllers\Dokter\SuratRujukanController;

use App\Http\Controllers\Pasien\PasienController;


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'loginNoIdentitas']);

Route::get('/login-nama', [LoginController::class, 'loginNamaView']);
Route::post('/login-nama', [LoginController::class, 'loginNama']);

Route::get('/logout', [LoginController::class, 'logout']);


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index']);


    Route::get('/tambah-pengguna', function () {
        return view('admin.pengguna.tambah_pengguna');
    });


    /*
    |--------------------------------------------------------------------------
    | SPESIALIS
    |--------------------------------------------------------------------------
    */

    Route::get('/spesialis', [SpesialisController::class, 'index']);
    Route::get('/spesialis/create', [SpesialisController::class, 'create']);
    Route::post('/spesialis/store', [SpesialisController::class, 'store']);
    Route::get('/spesialis/{id}', [SpesialisController::class, 'show']);
    Route::post('/spesialis/delete', [SpesialisController::class, 'destroy']);


    /*
    |--------------------------------------------------------------------------
    | PENGGUNA
    |--------------------------------------------------------------------------
    */

    Route::get('/pengguna', [PenggunaController::class, 'index']);

    Route::get('/pengguna/admin', [PenggunaController::class, 'createAdmin']);
    Route::post('/pengguna/admin', [PenggunaController::class, 'storeAdmin']);

    Route::get('/pengguna/pasien', [PenggunaController::class, 'createPasien']);
    Route::post('/pengguna/pasien', [PenggunaController::class, 'storePasien']);

    Route::get('/pengguna/dokter', [PenggunaController::class, 'createDokter']);
    Route::post('/pengguna/dokter', [PenggunaController::class, 'storeDokter']);

    Route::get('/pengguna/lihat/{role}/{id}', [PenggunaController::class, 'show']);

    Route::delete('/pengguna/hapus/{role}/{id}', [PenggunaController::class, 'destroy']);
    // Edit & Update Pengguna
    Route::get('/pengguna/edit/{role}/{id}', [PenggunaController::class, 'edit']);
    Route::post('/pengguna/update', [PenggunaController::class, 'update']);



    /*
    |--------------------------------------------------------------------------
    | PENDAFTARAN
    |--------------------------------------------------------------------------
    */

    Route::get('/pendaftaran', [PendaftaranController::class, 'create']);
    Route::post('/pendaftaran', [PendaftaranController::class, 'store']);

    Route::post('/pendaftaran/confirm',
        [LihatPendaftaranController::class, 'confirm']);

    Route::get('/pendaftaran/lihat',
        [LihatPendaftaranController::class, 'index']);

});


/*
|--------------------------------------------------------------------------
| DOKTER
|--------------------------------------------------------------------------
*/

Route::prefix('dokter')->group(function () {

    Route::get('/dashboard',
        [DokterDashboardController::class, 'index']);

    Route::get('/daftar-pasien',
        [DaftarPasienController::class, 'index']);

    Route::post('/periksa',
        [PeriksaPasienController::class, 'store']);


    Route::get('/input-resep',
        [ResepObatController::class, 'create']);

    Route::post('/input-resep',
        [ResepObatController::class, 'store']);


    Route::get('/pertanyaan-surat',
        [PertanyaanSuratController::class, 'index']);


    Route::get('/surat-sakit',
        [SuratSakitController::class, 'create']);

    Route::post('/surat-sakit',
        [SuratSakitController::class, 'store']);


    Route::get('/riwayat',
        [SuratRujukanController::class, 'index']);

    Route::get('/riwayat/rujukan/{id}',
        [SuratRujukanController::class, 'show']);

    Route::get('/riwayat/sakit/{id}',
        [SuratRujukanController::class, 'showSakit']);


    Route::get('/surat-rujukan',
        [SuratRujukanController::class, 'create']);

    Route::post('/surat-rujukan',
        [SuratRujukanController::class, 'store']);

});


/*
|--------------------------------------------------------------------------
| PASIEN
|--------------------------------------------------------------------------
*/

Route::prefix('pasien')->group(function () {

    Route::get('/dashboard',
        [PasienController::class, 'dashboardPasien'])
        ->name('pasien.dashboard');


    Route::get('/pendaftaran',
        [PasienController::class, 'formPendaftaran'])
        ->name('pasien.pendaftaran');


    Route::post('/pendaftaran/simpan',
        [PasienController::class, 'simpanPendaftaran'])
        ->name('pasien.pendaftaran.simpan');


    Route::get('/riwayat',
        [PasienController::class, 'riwayatPendaftaran'])
        ->name('pasien.riwayat');


    Route::get('/riwayat/rujukan/{id}',
        [PasienController::class, 'detailRujukan'])
        ->name('pasien.riwayat.rujukan');


    Route::get('/riwayat/sakit/{id}',
        [PasienController::class, 'detailSakit'])
        ->name('pasien.riwayat.sakit');

});