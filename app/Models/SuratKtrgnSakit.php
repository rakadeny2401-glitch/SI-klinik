<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKtrgnSakit extends Model
{
    protected $table = 'surat_ktrgnsakit';
    protected $primaryKey = 'id_surat';
    public $timestamps = false;

    protected $fillable = [
        'id_daftar',
        'id_pasien',
        'id_dokter',
        'keterangan',
        'jml_istirahat',
        'tgl_mulai',
        'tgl_selesai',
        'id_proses'
    ];
}