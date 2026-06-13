<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsesPasien extends Model
{
    protected $table = 'proses_pasien';
    protected $primaryKey = 'id_proses';
    public $timestamps = false;

    protected $fillable = [
        'id_daftar',
        'id_pasien',
        'id_dokter',
        'id_admin',
        'id_spesialis',
        'no_antrian',
        'tgl_pemeriksaan'
    ];
}