<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'id_pasien';
    public $timestamps = false;

    protected $fillable = [
        'nik',
        'nama_pasien',
        'alamat_pasien',
        'jenis_kelamin',
        'umur',
        'no_hp',
        'password',
        'id_akses',
        'no_identitas'
    ];
}