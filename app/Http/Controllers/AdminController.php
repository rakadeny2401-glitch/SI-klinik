<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function lihatPengguna(Request $request)
    {
        $role = strtolower(session('role') ?? '');

        if ($role !== 'admin') {
            abort(403);
        }

        $filter = $request->role ?? 'all';
        $q = $request->q ?? '';

        $rows = collect([]);

        // ADMIN
        if ($filter === 'all' || $filter === 'admin') {

            $admin = DB::table('admin')
                ->select(
                    'id_admin as id',
                    'nama_admin as nama',
                    'no_identitas as identifier',
                    'waktu_jaga',
                    DB::raw("'admin' as role")
                );

            if ($q) {
                $admin->where('nama_admin', 'like', "%{$q}%");
            }

            $rows = $rows->merge($admin->get());
        }

        // DOKTER
        if ($filter === 'all' || $filter === 'dokter') {

            $dokter = DB::table('dokter')
                ->select(
                    'id_dokter as id',
                    'nama_dokter as nama',
                    'no_identitas as identifier',
                    'no_hp_dokter as no_hp',
                    DB::raw("'dokter' as role")
                );

            if ($q) {
                $dokter->where('nama_dokter', 'like', "%{$q}%");
            }

            $rows = $rows->merge($dokter->get());
        }

        // PASIEN
        if ($filter === 'all' || $filter === 'pasien') {

            $pasien = DB::table('pasien')
                ->select(
                    'id_pasien as id',
                    'nama_pasien as nama',
                    'no_identitas as identifier',
                    'no_hp',
                    DB::raw("'pasien' as role")
                );

            if ($q) {
                $pasien->where('nama_pasien', 'like', "%{$q}%");
            }

            $rows = $rows->merge($pasien->get());
        }

        return view('admin.lihat_pengguna', [
            'rows' => $rows,
            'filter' => $filter,
            'q' => $q
        ]);
    }

    public function tambahPengguna()
{
    if (session('role') !== 'admin') {
        abort(403);
    }

    return view('admin.tambah_pengguna');
}

    public function editPengguna($role, $id)
{
    if (session('role') !== 'admin') {
        abort(403);
    }

    if ($role === 'admin') {
        $details = DB::table('admin')
            ->where('id_admin', $id)
            ->first();
    } elseif ($role === 'dokter') {
        $details = DB::table('dokter')
            ->where('id_dokter', $id)
            ->first();
    } else {
        $details = DB::table('pasien')
            ->where('id_pasien', $id)
            ->first();
    }

    $spesialis = DB::table('spesialis')
        ->orderBy('nama_spesialis')
        ->get();

    return view('admin.edit_pengguna', compact(
        'details',
        'role',
        'id',
        'spesialis'
    ));
}

    public function detailPengguna($role, $id)
    {
        if (session('role') !== 'admin') {
            abort(403);
        }

        if ($role === 'admin') {
            $data = DB::table('admin')
                ->where('id_admin', $id)
                ->first();
        } elseif ($role === 'dokter') {
            $data = DB::table('dokter')
                ->where('id_dokter', $id)
                ->first();
        } else {
            $data = DB::table('pasien')
                ->where('id_pasien', $id)
                ->first();
        }

        return view('admin.detail_pengguna', [
            'details' => (array) $data,
            'role' => $role,
            'id' => $id
        ]);
    }

    public function lihatSpesialis()
{
    if (session('role') !== 'admin') {
        abort(403);
    }

    $spesialis = DB::table('spesialis')
        ->orderBy('nama_spesialis', 'asc')
        ->paginate(5);

    return view('admin.spesialis', compact('spesialis'));
}

public function detailSpesialis($id)
{
    if (session('role') !== 'admin') {
        abort(403);
    }

    $spesialis = DB::table('spesialis')
        ->where('id_spesialis', $id)
        ->first();

    if (!$spesialis) {
        abort(404, 'Spesialis tidak ditemukan');
    }

    $dokter = DB::table('dokter')
        ->where('id_spesialis', $id)
        ->orderBy('nama_dokter', 'asc')
        ->paginate(5);

    return view('admin.spesialis_detail', [
        'spesialis' => $spesialis,
        'dokter' => $dokter
    ]);

    }

    public function formPendaftaran()
{
    if (session('role') !== 'admin') {
        abort(403);
    }

    $spesialis = DB::table('spesialis')
        ->orderBy('nama_spesialis')
        ->get();

    $dokter = DB::table('dokter')
        ->select(
            'id_dokter',
            'nama_dokter',
            'id_spesialis',
            'waktu_kerja',
            'waktu_pulang'
        )
        ->get();

    $map = [];

    foreach ($dokter as $d) {

        $mulai = $d->waktu_kerja
            ? substr($d->waktu_kerja,0,5)
            : '';

        $pulang = $d->waktu_pulang
            ? substr($d->waktu_pulang,0,5)
            : '';

        $d->jam_kerja = "$mulai - $pulang";

        $map[$d->id_spesialis][] = $d;
    }

    return view('admin.pendaftaran_form', [
        'spesialis' => $spesialis,
        'dokterJson' => json_encode($map)
    ]);
}

public function lihatPendaftaran()
{
    if (session('role') !== 'admin') {
        abort(403);
    }

    $rows = DB::table('daftar as d')
        ->leftJoin('spesialis as s', 'd.id_spesialis', '=', 's.id_spesialis')
        ->leftJoin('dokter as doc', 'd.id_dokter', '=', 'doc.id_dokter')
        ->leftJoin('admin as a', 'd.id_admin', '=', 'a.id_admin')
        ->leftJoin('proses_pasien as pp', 'pp.id_daftar', '=', 'd.id_daftar')
        ->select(
            'd.*',
            's.nama_spesialis',
            'doc.nama_dokter',
            'a.nama_admin',
            'pp.no_antrian',
            'pp.tgl_pemeriksaan'
        )
        ->orderByDesc('d.waktu_daftar')
        ->paginate(5);

    return view('admin.lihat_pendaftaran', compact('rows'));
}

    }
