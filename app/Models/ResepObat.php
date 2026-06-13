<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    protected $table = 'resep_obat';
    protected $primaryKey = 'id_resep';
    public $timestamps = false;

    protected $fillable = [
        'id_daftar',
        'id_pasien',
        'id_dokter',
        'jenis_obat',
        'id_proses'
    ];
}