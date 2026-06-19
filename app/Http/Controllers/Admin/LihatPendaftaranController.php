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
            ->leftJoin('proses_pasien as pp', 'pp.id_daftar', '=', 'd.id_daftar')
            ->select(
                'd.id_daftar',
                'd.nama_pasien',
                'd.nik',
                'd.keluhan',
                'd.waktu_daftar',
                'd.status_pendaftaran',
                'd.id_pasien',
                'd.id_dokter',
                'd.id_spesialis',
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
        if (session('role') !== 'admin') return redirect('/');

        $id = $request->id_value;
        $id_admin = session('data.id_admin');

        $daftar = DB::table('daftar')->where('id_daftar', $id)->first();

        if (!$daftar || $daftar->status_pendaftaran !== 'pengecekan') {
            return redirect('/admin/pendaftaran/lihat');
        }

        DB::beginTransaction();

        try {

            DB::table('daftar')
                ->where('id_daftar', $id)
                ->update([
                    'status_pendaftaran' => 'dikonfirmasi',
                    'id_admin' => $id_admin
                ]);

            $sp = DB::table('spesialis')
                ->where('id_spesialis', $daftar->id_spesialis)
                ->first();

            $kode = strtoupper(substr($sp->nama_spesialis, 0, 1));

            $urutan = DB::table('proses_pasien')
                ->where('id_spesialis', $daftar->id_spesialis)
                ->count() + 1;

            $no_antrian = $kode . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

            $last = DB::table('proses_pasien')
                ->where('id_spesialis', $daftar->id_spesialis)
                ->orderByDesc('tgl_pemeriksaan')
                ->first();

            $tgl = $last
                ? date('Y-m-d H:i:s', strtotime($last->tgl_pemeriksaan . ' +30 minutes'))
                : $daftar->waktu_daftar;

            DB::table('proses_pasien')->insert([
                'id_daftar' => $daftar->id_daftar,
                'id_pasien' => $daftar->id_pasien,
                'id_dokter' => $daftar->id_dokter,
                'id_admin' => $id_admin,
                'id_spesialis' => $daftar->id_spesialis,
                'tgl_pemeriksaan' => $tgl,
                'no_antrian' => $no_antrian
            ]);

            DB::commit();

            return redirect('/admin/pendaftaran/lihat');

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect('/admin/pendaftaran/lihat')
                ->with('error', 'Gagal konfirmasi');
        }
    }
}