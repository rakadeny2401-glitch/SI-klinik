<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Spesialis;
use App\Models\Daftar;
use App\Models\ProsesPasien;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function create()
    {
        if (session('role') !== 'admin') return redirect('/');

        $spesialis = Spesialis::orderBy('nama_spesialis')->get();
        $pasien = Pasien::orderBy('nama_pasien')->get();
        $pasienMap = Pasien::all()->keyBy('nik');
        $dokter = Dokter::all();
        $nama_admin = session('data.nama_admin') ?? '-';

        return view('admin.pendaftaran.index', compact('spesialis', 'pasien', 'pasienMap', 'dokter','nama_admin'));
    }

    public function store(Request $request)
    {
        if (session('role') !== 'admin') return redirect('/');

        $request->validate([
            'nik_pasien'   => 'required',
            'id_spesialis' => 'required',
            'waktu_daftar' => 'required',
            'keluhan'      => 'required'
        ]);

        $nik_pasien   = $request->nik_pasien;
        $id_spesialis = $request->id_spesialis;
        $keluhan      = $request->keluhan;
        $id_admin     = session('data.id_admin');
        $waktu_daftar = $request->waktu_daftar;

        if (!preg_match('/^\d{2}:\d{2}$/', $waktu_daftar)) {
            return back()->with('error', 'Format waktu tidak valid');
        }

        $timePart = $waktu_daftar;
        $fullTime = date('Y-m-d') . ' ' . $timePart . ':00';

        $dokters = Dokter::where('id_spesialis', $id_spesialis)->get();
        $selectedDoctor = null;

        foreach ($dokters as $d) {
    // Pastikan data tidak kosong
    if (empty($d->waktu_kerja) || empty($d->waktu_pulang)) {
        continue;
    }

    // Ubah jam ke format detik/timestamp agar mudah dibandingkan
    $startTime = strtotime($d->waktu_kerja);
    $endTime   = strtotime($d->waktu_pulang);
    $inputTime = strtotime($timePart); // $timePart dari input admin (format HH:mm)

    // Logika: Jika waktu input berada di antara jam kerja
    // Gunakan <= untuk endTime agar pas jam pulang masih dihitung masuk
    if ($inputTime >= $startTime && $inputTime <= $endTime) {
        $selectedDoctor = $d;
        break;
    }
}

        if (!$selectedDoctor) {
            return back()->with('error', 'Tidak ada dokter jaga di jam tersebut');
        }

        $pasien = Pasien::where('nik', $nik_pasien)->first();
        if (!$pasien) {
            return back()->with('error', 'Pasien tidak ditemukan');
        }

        $id_pasien = $pasien->id_pasien;
        $aktif = Daftar::where('id_pasien', $id_pasien)
            ->where('status_pendaftaran', '!=', 'selesai')
            ->exists();

        if ($aktif) {
            return back()->with('error', 'Pasien masih memiliki pendaftaran aktif');
        }

        // Tambahkan ini sebelum DB::beginTransaction() di PendaftaranController
if (empty($selectedDoctor->id_dokter)) {
    throw new \Exception('Gagal mendeteksi ID Dokter. Periksa jadwal dokter.');
}
        DB::beginTransaction();

        try {
            $daftar = Daftar::create([
                'id_pasien'          => $id_pasien,
                'id_spesialis'       => $id_spesialis,
                'id_dokter'          => $selectedDoctor->id_dokter,
                'id_admin'           => $id_admin,
                'nama_pasien'        => $pasien->nama_pasien,
                'alamat_pasien'      => $pasien->alamat_pasien,
                'jenis_kelamin'      => $pasien->jenis_kelamin,
                'umur'               => $pasien->umur,
                'nik'                => $pasien->nik,
                'keluhan'            => $keluhan,
                'waktu_daftar'       => $fullTime,
                'status_pendaftaran' => 'dikonfirmasi'
            ]);

            $sp = Spesialis::find($id_spesialis);
            if (!$sp) throw new \Exception('Spesialis tidak ditemukan');

            $kode = strtoupper(substr($sp->nama_spesialis, 0, 1));

            $lastProses = ProsesPasien::join('daftar','daftar.id_daftar','=','proses_pasien.id_daftar')
                ->where('proses_pasien.id_spesialis', $id_spesialis)
                ->whereIn('daftar.status_pendaftaran',['dikonfirmasi','pemeriksaan'])
                ->orderBy('proses_pasien.tgl_pemeriksaan','desc')
                ->first();

            if ($lastProses) {
                if (strtotime($lastProses->tgl_pemeriksaan) >= strtotime($fullTime)) {
                    $tgl_pemeriksaan = date('Y-m-d H:i:s', strtotime("+30 minutes", strtotime($lastProses->tgl_pemeriksaan)));
                } else {
                    $tgl_pemeriksaan = $fullTime;
                }
                $urutan = ProsesPasien::where('proses_pasien.id_spesialis', $id_spesialis)
                    ->join('daftar','daftar.id_daftar','=','proses_pasien.id_daftar')
                    ->whereIn('daftar.status_pendaftaran',['dikonfirmasi','pemeriksaan'])
                    ->count() + 1;
            } else {
                $tgl_pemeriksaan = $fullTime;
                $urutan = 1;
            }

            $noAntrian = $kode . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

            ProsesPasien::create([
                'id_daftar'      => $daftar->id_daftar,
                'id_pasien'      => $id_pasien,
                'id_dokter'      => $selectedDoctor->id_dokter,
                'id_admin'       => $id_admin,
                'id_spesialis'   => $id_spesialis,
                'tgl_pemeriksaan'=> $tgl_pemeriksaan,
                'no_antrian'     => $noAntrian
            ]);

            DB::commit();
            return redirect('/admin/pendaftaran')->with('success', 'Pendaftaran berhasil');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Error Pendaftaran: '.$e->getMessage().' | Line: '.$e->getLine());
            return back()->with('error', 'Terjadi kesalahan sistem: '.$e->getMessage());
        }
    }

// Tambahkan fungsi ini di PendaftaranController.php
public function confirm(Request $request)
{
    $request->validate(['id_daftar' => 'required']);

    DB::beginTransaction();
    try {
        // 1. Ambil data pendaftaran
        $daftar = Daftar::findOrFail($request->id_daftar);
        
        // 2. Update status
        $daftar->status_pendaftaran = 'dikonfirmasi';
        $daftar->save();

        // 3. Ambil data spesialis untuk kode antrean
        $sp = Spesialis::find($daftar->id_spesialis);
        $kode = strtoupper(substr($sp->nama_spesialis, 0, 1));

        // 4. Hitung urutan antrean (LOGIKA INI YANG MEMBUAT DATA PROSES PASIEN TERISI)
        $urutan = ProsesPasien::where('id_spesialis', $daftar->id_spesialis)
                    ->join('daftar', 'daftar.id_daftar', '=', 'proses_pasien.id_daftar')
                    ->whereIn('daftar.status_pendaftaran', ['dikonfirmasi', 'pemeriksaan'])
                    ->count() + 1;

        $noAntrian = $kode . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        // 5. Simpan ke tabel proses_pasien agar datanya tidak kosong
        ProsesPasien::create([
            'id_daftar'       => $daftar->id_daftar,
            'id_pasien'       => $daftar->id_pasien,
            'id_dokter'       => $daftar->id_dokter,
            'id_admin'        => session('data.id_admin'), // Pastikan admin login
            'id_spesialis'    => $daftar->id_spesialis,
            'tgl_pemeriksaan' => now(), 
            'no_antrian'      => $noAntrian
        ]);

        DB::commit();
        return back()->with('success', 'Konfirmasi berhasil, antrean dan data proses pasien telah dibuat.');
        
    } catch (\Throwable $e) {
        DB::rollBack();
        // Debug error jika gagal
        return back()->with('error', 'Gagal konfirmasi: ' . $e->getMessage());
    }
}
}