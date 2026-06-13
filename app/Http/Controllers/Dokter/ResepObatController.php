<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResepObatController extends Controller
{
    public function create(Request $request)
    {
        if (session('role') !== 'dokter') {
            return redirect('/');
        }

        $id_daftar = $request->id_daftar;
        $id_pasien = $request->id_pasien;
        $id_dokter = session('data.id_dokter');

        if (!$id_daftar || !$id_dokter) {
            return redirect('/dokter/daftar-pasien')
                ->with('error', 'Data tidak lengkap');
        }

        $pasien = DB::table('daftar')
            ->select(
                'id_pasien',
                'nama_pasien',
                'umur',
                'keluhan'
            )
            ->where('id_daftar', $id_daftar)
            ->where('id_dokter', $id_dokter)
            ->first();

        if (!$pasien) {
            return redirect('/dokter/daftar-pasien')
                ->with('error', 'Data pasien tidak ditemukan');
        }

        return view('dokter.resep.create', compact(
            'pasien',
            'id_daftar'
        ));
    }

    public function store(Request $request)
    {
        if (session('role') !== 'dokter') {
            return redirect('/');
        }

        $id_daftar = $request->id_daftar;
        $id_pasien = $request->id_pasien;
        $id_dokter = session('data.id_dokter');
        $jenis_obat = $request->jenis_obat;

        if (!$id_daftar || !$id_pasien || !$id_dokter) {
            return back()->with('error', 'Data tidak lengkap');
        }

        if (!$jenis_obat) {
            return back()->with('error', 'Jenis obat tidak boleh kosong');
        }

        $proses = DB::table('proses_pasien')
            ->where('id_daftar', $id_daftar)
            ->where('id_dokter', $id_dokter)
            ->orderByDesc('id_proses')
            ->first();

        DB::table('resep_obat')->insert([
            'id_daftar' => $id_daftar,
            'id_pasien' => $id_pasien,
            'id_dokter' => $id_dokter,
            'jenis_obat' => $jenis_obat,
            'id_proses' => $proses?->id_proses
        ]);

        return redirect(
            '/dokter/pertanyaan-surat?id_daftar=' .
            $id_daftar .
            '&id_pasien=' .
            $id_pasien
        );
    }
}