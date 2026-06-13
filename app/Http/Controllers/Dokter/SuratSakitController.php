<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SuratSakitController extends Controller
{
    public function create(Request $request)
    {
        if (session('role') !== 'dokter') {
            return redirect('/');
        }

        $id_daftar = $request->id_daftar;
        $id_pasien = $request->id_pasien;

        $proses = DB::table('proses_pasien')
            ->where('id_daftar', $id_daftar)
            ->orderByDesc('id_proses')
            ->first();

        return view(
            'dokter.surat_sakit.index',
            [
                'id_daftar' => $id_daftar,
                'id_pasien' => $id_pasien,
                'id_proses' => $proses->id_proses ?? null
            ]
        );
    }

    public function store(Request $request)
{
    // Tambahkan validasi dasar agar input data aman
    $request->validate([
        'id_daftar'     => 'required',
        'id_pasien'     => 'required',
        'keterangan'    => 'required|string',
        'jml_istirahat' => 'required|integer',
        'tgl_mulai'     => 'required|date',
        'tgl_selesai'   => 'required|date'
    ]);

    DB::table('surat_ktrgnsakit')->insert([
        'id_daftar' => $request->id_daftar,
        'id_pasien' => $request->id_pasien,
        'id_dokter' => session('data.id_dokter'),
        'id_proses' => $request->id_proses,
        'keterangan' => $request->keterangan,
        'jml_istirahat' => $request->jml_istirahat,
        'tgl_mulai' => $request->tgl_mulai,
        'tgl_selesai' => $request->tgl_selesai
    ]);

    DB::table('daftar')
        ->where('id_daftar', $request->id_daftar)
        ->update([
            'status_pendaftaran' => 'selesai'
        ]);

    // FIX: Redirect kembali ke menu pertanyaan surat dengan membawa session flash success
    return redirect('/dokter/pertanyaan-surat?id_daftar=' . $request->id_daftar . '&id_pasien=' . $request->id_pasien)
        ->with('success', 'Surat keterangan sakit berhasil dibuat!');
}
}