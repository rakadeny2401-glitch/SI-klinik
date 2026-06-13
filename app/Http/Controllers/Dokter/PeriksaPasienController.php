<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PeriksaPasienController extends Controller
{
    public function store(Request $request)
    {
        if (session('role') !== 'dokter') {
            return redirect('/');
        }

        $id_daftar = $request->id_daftar;
        $id_dokter = session('data.id_dokter');

        DB::table('daftar')
            ->where('id_daftar', $id_daftar)
            ->where('id_dokter', $id_dokter)
            ->update([
                'status_pendaftaran' => 'pemeriksaan'
            ]);

        return redirect('/dokter/input-resep?id_daftar=' . $id_daftar);
    }
}