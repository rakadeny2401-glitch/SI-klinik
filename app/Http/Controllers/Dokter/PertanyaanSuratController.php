<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PertanyaanSuratController extends Controller
{
    public function index(Request $request)
    {
        if (session('role') !== 'dokter') {
            return redirect('/');
        }

        $id_daftar = $request->id_daftar;
        $id_pasien = $request->id_pasien;

        $rujukanSudahAda = DB::table('srt_rkrmdsi_rujukan')
            ->where('id_daftar', $id_daftar)
            ->exists();

        return view(
            'dokter.pertanyaan_surat.index',
            compact(
                'id_daftar',
                'id_pasien',
                'rujukanSudahAda'
            )
        );
    }
}