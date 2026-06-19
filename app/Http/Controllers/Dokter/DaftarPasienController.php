<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DaftarPasienController extends Controller
{
    public function index()
    {
        if (session('role') !== 'dokter') {
            return redirect('/');
        }

        $id_dokter = session('data.id_dokter');

        $data = DB::table('proses_pasien')
            ->join('daftar', 'daftar.id_daftar', '=', 'proses_pasien.id_daftar')
            ->select(
                'daftar.id_daftar',
                'daftar.nama_pasien',
                'daftar.umur',
                'daftar.keluhan',
                'daftar.status_pendaftaran',
                'proses_pasien.no_antrian'
            )
            ->where('proses_pasien.id_dokter', $id_dokter)
            ->whereIn('daftar.status_pendaftaran', ['dikonfirmasi','pemeriksaan'])
            ->orderBy('proses_pasien.no_antrian', 'asc')
            ->get();

        return view('dokter.daftar.index', compact('data'));
    }
}
