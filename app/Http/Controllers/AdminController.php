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
}
