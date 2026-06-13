<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    protected $table = 'hak_akses';
    protected $primaryKey = 'id_akses';
    public $timestamps = false;

    protected $fillable = [
        'nama_akses'
    ];
}
