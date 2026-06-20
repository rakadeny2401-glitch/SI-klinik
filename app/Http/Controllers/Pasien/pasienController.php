<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    // 1. Menampilkan Form Pendaftaran Pasien
    public function formPendaftaran()
    {
        if (session('role') !== 'pasien') {
            return redirect('/');
        }

        // Mengambil data untuk dropdown select
        $spesialis = DB::table('spesialis')->get();
        $dokter = DB::table('dokter')->get();
        
        return view('pasien.pendaftaran', compact('spesialis', 'dokter'));
    }

    // 2. Memproses Simpan Data Pendaftaran ke Tabel 'daftar'
    public function simpanPendaftaran(Request $request)
{
    if (!session()->has('role') || session('role') !== 'pasien') {
        return redirect('/');
    }

    $id_pasien     = session('data.id_pasien') ?? session('id_pasien'); 
    $nama_pasien   = session('data.nama_pasien') ?? session('username');
    $nik           = session('data.nik') ?? '-';
    $alamat_pasien = session('data.alamat_pasien') ?? '-';
    $jenis_kelamin = session('data.jenis_kelamin') ?? 'L';
    $umur          = session('data.umur') ?? 0;

    if ($request->tanggal_daftar && $request->waktu_daftar) {
        $fullTime = date('Y-m-d H:i:s', strtotime($request->tanggal_daftar . ' ' . $request->waktu_daftar));
    } elseif ($request->waktu_daftar) {
        $fullTime = date('Y-m-d H:i:s', strtotime($request->waktu_daftar));
    } else {
        $fullTime = now();
    }

    DB::table('daftar')->insert([
        'id_pasien'          => $id_pasien,
        'nama_pasien'        => $nama_pasien,
        'nik'                => $nik,
        'alamat_pasien'      => $alamat_pasien,
        'jenis_kelamin'      => $jenis_kelamin,
        'umur'               => $umur,
        'waktu_daftar'       => $fullTime,
        'id_spesialis'       => $request->id_spesialis,
        'id_dokter'          => $request->id_dokter,
        'keluhan'            => $request->keluhan,
        'status_pendaftaran' => 'pengecekan',
    ]);

    return redirect()->route('pasien.riwayat')->with('sukses', 'Pendaftaran berhasil disimpan!');
}


    // 3. Menampilkan Halaman Riwayat Berobat Pasien
    public function riwayatPendaftaran()
    {
        if (session('role') !== 'pasien') {
            return redirect('/');
        }

        $nama_log = session('data.nama_pasien') ?? session('username');

        $riwayat = DB::table('daftar')
            ->join('dokter', 'daftar.id_dokter', '=', 'dokter.id_dokter')
            ->join('spesialis', 'daftar.id_spesialis', '=', 'spesialis.id_spesialis')
            ->leftJoin('srt_rkrmdsi_rujukan', 'daftar.id_daftar', '=', 'srt_rkrmdsi_rujukan.id_daftar')
            ->leftJoin('surat_ktrgnsakit', 'daftar.id_daftar', '=', 'surat_ktrgnsakit.id_daftar')
            ->leftJoin('proses_pasien', 'daftar.id_daftar', '=', 'proses_pasien.id_daftar')
            ->select(
                'daftar.id_daftar',
                'daftar.nama_pasien',
                'daftar.umur',
                'daftar.keluhan',
                'daftar.waktu_daftar',
                'daftar.status_pendaftaran as status',
                'dokter.nama_dokter',
                'spesialis.nama_spesialis as spesialis',
                DB::raw("IF(daftar.status_pendaftaran = 'pengecekan', '-', proses_pasien.no_antrian) as no_antrian"),
                DB::raw("IF(daftar.status_pendaftaran = 'pengecekan', '-', DATE_FORMAT(proses_pasien.tgl_pemeriksaan, '%d %b %Y, %H:%i')) as tgl_pemeriksaan"),
                DB::raw("IF(srt_rkrmdsi_rujukan.id_daftar IS NOT NULL, 1, 0) as ada_rujukan"),
                DB::raw("IF(surat_ktrgnsakit.id_daftar IS NOT NULL, 1, 0) as ada_sakit")
            )
            ->where('daftar.nama_pasien', $nama_log)
            ->orderByDesc('daftar.id_daftar')
            ->paginate(5);

        return view('pasien.riwayat', compact('riwayat'));
    }

    // 4. Melihat Detail Surat Rujukan Pasien
    public function detailRujukan($id)
    {
        if (session('role') !== 'pasien') {
            return redirect('/');
        }

        $data = DB::table('srt_rkrmdsi_rujukan')
            ->join('daftar', 'srt_rkrmdsi_rujukan.id_daftar', '=', 'daftar.id_daftar')
            ->join('dokter', 'srt_rkrmdsi_rujukan.id_dokter', '=', 'dokter.id_dokter')
            ->select(
                'daftar.nama_pasien',
                'daftar.umur',
                'daftar.keluhan',
                'srt_rkrmdsi_rujukan.rekomendasi',
                'dokter.nama_dokter'
            )
            ->where('srt_rkrmdsi_rujukan.id_daftar', $id)
            ->first();

        if (!$data) {
            return redirect('/pasien/riwayat')->with('error', 'Surat rujukan tidak ditemukan.');
        }

        return view('pasien.detail_rujukan', compact('data'));
    }

    // 5. Melihat Detail Surat Sakit Pasien
    public function detailSakit($id)
    {
        if (session('role') !== 'pasien') {
            return redirect('/');
        }

        $data = DB::table('surat_ktrgnsakit')
            ->join('daftar', 'surat_ktrgnsakit.id_daftar', '=', 'daftar.id_daftar')
            ->join('dokter', 'surat_ktrgnsakit.id_dokter', '=', 'dokter.id_dokter')
            ->select(
                'daftar.nama_pasien',
                'daftar.umur',
                'daftar.keluhan',
                'surat_ktrgnsakit.keterangan',
                'surat_ktrgnsakit.jml_istirahat',
                'surat_ktrgnsakit.tgl_mulai',
                'surat_ktrgnsakit.tgl_selesai',
                'dokter.nama_dokter'
            )
            ->where('surat_ktrgnsakit.id_daftar', $id)
            ->first();

        if (!$data) {
            return redirect('/pasien/riwayat')->with('error', 'Surat keterangan sakit tidak ditemukan.');
        }

        return view('pasien.detail_sakit', compact('data'));
    }

    public function dashboardPasien()
{
    if (session('role') !== 'pasien') { return redirect('/'); }

    // Ambil info pendaftaran terakhir pasien untuk dipajang di dashboard (opsional)
    $nama_log = session('data.nama_pasien') ?? session('username');
    $pendaftaran_terakhir = DB::table('daftar')
        ->where('nama_pasien', $nama_log)
        ->orderByDesc('id_daftar')
        ->first();

    return view('pasien.dashboard', compact('pendaftaran_terakhir'));
}
}