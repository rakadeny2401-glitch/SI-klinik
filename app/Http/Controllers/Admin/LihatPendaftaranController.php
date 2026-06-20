<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LihatPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        if (session('role') !== 'admin') return redirect('/');

        $perPage = 5;
        $page = max(1, (int) $request->get('page', 1));

        $query = DB::table('daftar as d')
    ->leftJoin('spesialis as s', 'd.id_spesialis', '=', 's.id_spesialis')
    ->leftJoin('dokter as doc', 'd.id_dokter', '=', 'doc.id_dokter')
    ->leftJoin('admin as a', 'd.id_admin', '=', 'a.id_admin')
    ->leftJoin('proses_pasien as pp', 'd.id_daftar', '=', 'pp.id_daftar') // Pastikan ini benar
    ->select(
        'd.*', 
        's.nama_spesialis',
        'doc.nama_dokter',
        'a.nama_admin',
        'pp.no_antrian',
        'pp.tgl_pemeriksaan'
    );

        if ($request->filled('status')) {
            $query->where('d.status_pendaftaran', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('d.nama_pasien', 'like', "%{$search}%")
                ->orWhere('d.nik', 'like', "%{$search}%")
                ->orWhere('doc.nama_dokter', 'like', "%{$search}%")
                ->orWhere('s.nama_spesialis', 'like', "%{$search}%");
            });
        }

        $data = $query
            ->orderByDesc('d.id_daftar')
            ->get();

        $totalPage = (int) ceil($data->count() / $perPage);
        $rows = $data->slice(($page - 1) * $perPage, $perPage)->values();

        return view('admin.pendaftaran.lihat', compact(
            'rows',
            'page',
            'totalPage'
        ));
    }

    public function confirm(Request $request)
{
    // Cek apakah id_value diterima
    $id = $request->id_value;
    if (!$id) {
        dd("ID Pendaftaran tidak diterima oleh controller. Cek name input di form!");
    }

    $id_admin = session('data.id_admin');
    $daftar = DB::table('daftar')->where('id_daftar', $id)->first();

    if (!$daftar) {
        dd("Data pendaftaran dengan ID " . $id . " tidak ditemukan di database.");
    }

    DB::beginTransaction();
    try {
        // Update status
        DB::table('daftar')->where('id_daftar', $id)->update([
            'status_pendaftaran' => 'dikonfirmasi',
            'id_admin' => $id_admin
        ]);

        // Hitung antrean
        $sp = DB::table('spesialis')->where('id_spesialis', $daftar->id_spesialis)->first();
        $kode = strtoupper(substr($sp->nama_spesialis, 0, 1));
        
        $urutan = DB::table('proses_pasien')->where('id_spesialis', $daftar->id_spesialis)->count() + 1;
        $no_antrian = $kode . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        // Masukkan ke proses_pasien
       // Ganti bagian insert di LihatPendaftaranController.php menjadi:
DB::table('proses_pasien')->updateOrInsert(
    ['id_daftar' => $daftar->id_daftar], // Kondisi (pencarian)
    [
        'id_pasien'       => $daftar->id_pasien,
        'id_dokter'       => $daftar->id_dokter,
        'id_admin'        => $id_admin,
        'id_spesialis'    => $daftar->id_spesialis,
        'tgl_pemeriksaan' => now(),
        'no_antrian'      => $no_antrian
    ]
);

        DB::commit();
        return redirect('/admin/pendaftaran/lihat')->with('success', 'Berhasil dikonfirmasi!');

    } catch (\Throwable $e) {
        DB::rollBack();
        // INI AKAN MENUNJUKKAN ERRORNYA DI LAYAR
        dd("Error Database: " . $e->getMessage());
    }
}
}