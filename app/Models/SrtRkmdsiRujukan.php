<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SrtRkmdsiRujukan extends Model
{
    protected $table = 'srt_rkrmdsi_rujukan';
    protected $primaryKey = 'id_rujukan';
    public $timestamps = false;

    protected $fillable = [
        'id_daftar',
        'id_pasien',
        'id_dokter',
        'rekomendasi',
        'id_proses'
    ];
}