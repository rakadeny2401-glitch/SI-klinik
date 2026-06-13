<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SuratRujukanController extends Controller
{
    // 1. METHOD INDEX (Untuk menampilkan Riwayat Periksa)
    public function index()
{
    if (session('role') !== 'dokter') {
        return redirect('/');
    }

    // Mengambil data riwayat dengan LEFT JOIN ke tabel surat rujukan dan surat sakit
    $riwayat = DB::table('daftar')
        ->join('dokter', 'daftar.id_dokter', '=', 'dokter.id_dokter')
        ->join('spesialis', 'daftar.id_spesialis', '=', 'spesialis.id_spesialis')
        // Left join resep obat (sesuaikan nama tabel/kolom resep jika ada di sistemmu, atau gunakan text manual)
        ->leftJoin('proses_pasien', 'daftar.id_daftar', '=', 'proses_pasien.id_daftar')
        // Left join dokumen surat-surat
        ->leftJoin('srt_rkrmdsi_rujukan', 'daftar.id_daftar', '=', 'srt_rkrmdsi_rujukan.id_daftar')
        ->leftJoin('surat_ktrgnsakit', 'daftar.id_daftar', '=', 'surat_ktrgnsakit.id_daftar')
        ->select(
            'daftar.id_daftar',
            'daftar.nama_pasien',
            'daftar.umur',
            'daftar.keluhan',
            'daftar.waktu_daftar',
            'daftar.status_pendaftaran as status',
            'dokter.nama_dokter',
            'spesialis.nama_spesialis as spesialis',
         
            DB::raw("IF(srt_rkrmdsi_rujukan.id_daftar IS NOT NULL, 1, 0) as ada_rujukan"),
            DB::raw("IF(surat_ktrgnsakit.id_daftar IS NOT NULL, 1, 0) as ada_sakit")
        )
        ->where('daftar.status_pendaftaran', 'selesai')
        ->orderByDesc('daftar.id_daftar')
        ->paginate(5);

    return view('dokter.riwayat.index', compact('riwayat'));
}

    // 2. METHOD CREATE (Menampilkan Form Input Rujukan)
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
            'dokter.surat_rujukan.index',
            [
                'id_daftar' => $id_daftar,
                'id_pasien' => $id_pasien,
                'id_proses' => $proses->id_proses ?? null
            ]
        );
    }

    // 3. METHOD STORE (Proses Simpan Surat Rujukan)
    public function store(Request $request)
    {
        // 1. Validasi data inputan
        $request->validate([
            'id_daftar'   => 'required',
            'id_pasien'   => 'required',
            'rekomendasi' => 'required|string',
        ]);

        // FIX: Ambil id_dokter dari session biar tidak memicu error "Undefined variable"
        $id_dokter = session('data.id_dokter');

        // 2. Proses simpan ke tabel surat rujukan Anda
        DB::table('srt_rkrmdsi_rujukan')->insert([
            'id_daftar'   => $request->id_daftar,
            'id_pasien'   => $request->id_pasien,
            'id_proses'   => $request->id_proses,
            'id_dokter'   => $id_dokter,
            'rekomendasi' => $request->rekomendasi,
        ]);

        // FIX: Menggunakan nama tabel 'daftar' sesuai dengan method index() Anda,
        // karena status pengecekan exist halaman pertanyaan diambil dari data tabel rujukan, 
        // query update ini dipertahankan namun diarahkan ke nama tabel yang benar.
        DB::table('daftar') 
            ->where('id_daftar', $request->id_daftar)
            ->update(['status_pendaftaran' => 'selesai']);

        // 4. Redirect ke PertanyaanSuratController dengan membawa parameter id dan flash session success toast
        return redirect('/dokter/pertanyaan-surat?id_daftar=' . $request->id_daftar . '&id_pasien=' . $request->id_pasien)
            ->with('success', 'Surat rujukan berhasil dibuat!');
    }

    // 4. METHOD SHOW (Untuk melihat detail surat rujukan dari halaman riwayat)
    public function show($id)
    {
        if (session('role') !== 'dokter') {
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
            return redirect('/dokter/riwayat')->with('error', 'Surat rujukan tidak ditemukan.');
        }

        return view('dokter.riwayat.rujukan', compact('data'));
    }

    // 5. METHOD SHOW SAKIT (Untuk melihat detail surat sakit dari halaman riwayat)
    public function showSakit($id)
    {
        if (session('role') !== 'dokter') {
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
            return redirect('/dokter/riwayat')->with('error', 'Surat keterangan sakit tidak ditemukan.');
        }

        return view('dokter.riwayat.sakit', compact('data'));
    }
}