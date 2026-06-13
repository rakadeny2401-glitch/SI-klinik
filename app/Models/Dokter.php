<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';
    protected $primaryKey = 'id_dokter';
    public $timestamps = false;

    protected $fillable = [
        'nama_dokter',
        'no_hp_dokter',
        'alamat_dokter',
        'tgl_lahir_dokter',
        'waktu_kerja',
        'waktu_pulang',
        'passworddok',
        'id_spesialis',
        'id_akses',
        'no_identitas'
    ];
}