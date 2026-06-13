<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spesialis extends Model
{
    protected $table = 'spesialis';
    protected $primaryKey = 'id_spesialis';
    public $timestamps = false;

    protected $fillable = [
        'nama_spesialis'
    ];
}