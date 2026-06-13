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

        $data = DB::table('daftar')
            ->select('id_daftar', 'nama_pasien', 'umur', 'keluhan')
            ->where('id_dokter', $id_dokter)
            ->where('status_pendaftaran', 'dikonfirmasi')
            ->orderByDesc('waktu_daftar')
            ->get();

        return view('dokter.daftar.index', compact('data'));
    }
}