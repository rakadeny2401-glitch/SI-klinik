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
            $start = substr($d->waktu_kerja, 0, 5);
            $end   = substr($d->waktu_pulang, 0, 5);
            if ($start && $end && $timePart >= $start && $timePart < $end) {
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
}
