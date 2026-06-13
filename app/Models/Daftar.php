<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daftar extends Model
{
    protected $table = 'daftar';
    protected $primaryKey = 'id_daftar';
    public $timestamps = false;

    protected $fillable = [
        'id_pasien',
        'id_spesialis',
        'id_dokter',
        'id_admin',
        'nama_pasien',
        'alamat_pasien',
        'jenis_kelamin',
        'umur',
        'nik',
        'keluhan',
        'waktu_daftar',
        'status_pendaftaran'
    ];
}