<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\HakAkses;
use App\Models\Spesialis;

class PenggunaController extends Controller
{
    // =========================
    // MENU UTAMA (DENGAN REPARASI UNION SINTAKS)
    // =========================
    public function index(Request $request)
    {
        if (session('role') !== 'admin') return redirect('/');

        $roleFilter = $request->input('role');
        $cari = $request->input('cari');

        // 1. Query dasar untuk Admin
        $adminQuery = \DB::table('admin')
            ->select(
                \DB::raw("'admin' as role"),
                'nama_admin as name',
                'no_identitas',
                \DB::raw("'-' as no_hp"),
                'id_admin as id'
            );

        // 2. Query dasar untuk Pasien
        $pasienQuery = \DB::table('pasien')
            ->select(
                \DB::raw("'pasien' as role"),
                'nama_pasien as name',
                'no_identitas',
                'no_hp',
                'id_pasien as id'
            );

        // 3. Query dasar untuk Dokter
        $dokterQuery = \DB::table('dokter')
            ->select(
                \DB::raw("'dokter' as role"),
                'nama_dokter as name',
                'no_identitas',
                'no_hp_dokter as no_hp',
                'id_dokter as id'
            );

        // 4. GABUNGKAN DENGAN METODE UNION LARAVEL
        $combinedQuery = $adminQuery->union($pasienQuery)->union($dokterQuery);

        // 5. BUNGKUS SEBAGAI MASTER QUERY & BERI ALIAS 'users'
        $masterQuery = \DB::table(\DB::raw("({$combinedQuery->toSql()}) as users"))
            ->mergeBindings($combinedQuery);

        // 6. Jalankan Kondisi Filter Role jika dipilih
        if ($roleFilter) {
            $masterQuery->where('role', $roleFilter);
        }

        // 7. Jalankan Kondisi Fitur Pencarian (Nama atau No Identitas)
        if ($cari) {
            $masterQuery->where(function ($q) use ($cari) {
                $q->where('name', 'like', "%{$cari}%")
                    ->orWhere('no_identitas', 'like', "%{$cari}%");
            });
        }

        // 8. Atur Sistem Paginasi Manual (5 data per halaman)
        $page = $request->input('page', 1);
        $perPage = 5;
        $totalData = $masterQuery->count();
        $totalPage = ceil($totalData / $perPage) ?: 1;

        // Ambil data spesifik halaman tersebut
        $rows = $masterQuery->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        // 9. Kirim variabel ke view
        return view('admin.pengguna.index', compact('rows', 'page', 'totalPage'));
    }

    // =========================
    // FUNGSI TAMPIL DETAIL PENGGUNA
    // =========================
    public function show($role, $id)
    {
        if (session('role') !== 'admin') return redirect('/');

        $user = null;

        if ($role === 'admin') {
            $user = \DB::table('admin')
                ->select('id_admin as id', 'nama_admin as name', 'no_identitas', \DB::raw("'-' as no_hp"), 'waktu_jaga', \DB::raw("'admin' as role"))
                ->where('id_admin', $id)->first();
        } 
        elseif ($role === 'pasien') {
            $user = \DB::table('pasien')
                ->select('id_pasien as id', 'nama_pasien as name', 'no_identitas', 'no_hp', 'alamat_pasien as alamat', \DB::raw("'pasien' as role"))
                ->where('id_pasien', $id)->first();
        } 
        elseif ($role === 'dokter') {
            $user = \DB::table('dokter')
                ->leftJoin('spesialis', 'dokter.id_spesialis', '=', 'spesialis.id_spesialis')
                ->select('id_dokter as id', 'nama_dokter as name', 'no_identitas', 'no_hp_dokter as no_hp', 'alamat_dokter as alamat', 'tgl_lahir_dokter', 'waktu_kerja', 'waktu_pulang', 'spesialis.nama_spesialis', \DB::raw("'dokter' as role"))
                ->where('id_dokter', $id)->first();
        }

        if (!$user) {
            return redirect('/admin/pengguna')->with('error', 'Pengguna tidak ditemukan');
        }

        return view('admin.pengguna.detail_pengguna', compact('user'));
    }

    // =========================
    // GENERATE NO IDENTITAS
    // =========================
    private function generateNoIdentitas()
    {
        do {
            $no = '';
            for ($i = 0; $i < 16; $i++) {
                $no .= random_int(0, 9);
            }

            $exists =
                Admin::where('no_identitas', $no)->exists() ||
                Dokter::where('no_identitas', $no)->exists() ||
                Pasien::where('no_identitas', $no)->exists();
        } while ($exists);

        return $no;
    }

    // =========================
    // GET ID AKSES
    // =========================
    private function getIdAkses($role)
    {
        $data = HakAkses::whereRaw('LOWER(nama_akses)=?', [strtolower($role)])->first();
        return $data ? $data->id_akses : null;
    }

    // =========================
    // VIEW CREATE
    // =========================
    public function createAdmin()
    {
        return view('admin.pengguna.create_admin');
    }

    public function createPasien()
    {
        return view('admin.pengguna.create_pasien');
    }

    public function createDokter()
    {
        $spesialis = Spesialis::all();
        return view('admin.pengguna.create_dokter', compact('spesialis'));
    }

    // =========================
    // STORE ADMIN
    // =========================
    public function storeAdmin(Request $request)
    {
        if (session('role') !== 'admin') return redirect('/');

        $request->validate([
            'nama_admin' => 'required',
            'waktu_jaga' => 'required',
            'passwordadmin' => 'required|digits:6'
        ]);

        $admin = new Admin();
        $admin->nama_admin = $request->nama_admin;
        $admin->waktu_jaga = $request->waktu_jaga;
        $admin->passwordadmin = preg_replace('/\D/', '', $request->passwordadmin);
        $admin->id_akses = $this->getIdAkses('admin');
        $admin->no_identitas = $this->generateNoIdentitas();
        $admin->save();

        return redirect('/admin/pengguna?status=added&role=admin');
    }

    // =========================
    // STORE PASIEN
    // =========================
    public function storePasien(Request $request)
    {
        if (session('role') !== 'admin') return redirect('/');

        $request->validate([
            'nik' => 'required|digits:16',
            'nama_pasien' => 'required',
            'alamat_pasien' => 'required',
            'umur' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required|numeric',
            'password' => 'required|digits:6'
        ]);

        if (Pasien::where('nik', $request->nik)->exists()) {
            return back()->with('error', 'NIK sudah terdaftar');
        }

        $pasien = new Pasien();
        $pasien->nik = $request->nik;
        $pasien->nama_pasien = $request->nama_pasien;
        $pasien->alamat_pasien = $request->alamat_pasien;
        $pasien->umur = $request->umur;
        $pasien->jenis_kelamin = $request->jenis_kelamin;
        $pasien->no_hp = $request->no_hp;
        $pasien->password = preg_replace('/\D/', '', $request->password);
        $pasien->id_akses = $this->getIdAkses('pasien');
        $pasien->no_identitas = $this->generateNoIdentitas();
        $pasien->save();

        return redirect('/admin/pengguna?status=added&role=pasien');
    }

    // =========================
    // STORE DOKTER
    // =========================
    public function storeDokter(Request $request)
    {
        if (session('role') !== 'admin') return redirect('/');

        $request->validate([
            'nama_dokter' => 'required',
            'no_hp_dokter' => 'required|numeric',
            'alamat_dokter' => 'required',
            'tgl_lahir_dokter' => 'required',
            'waktu_kerja' => 'required',
            'id_spesialis' => 'required',
            'passworddok' => 'required|digits:6'
        ]);

        $waktu_pulang = date('H:i:s', strtotime($request->waktu_kerja . ' +6 hours'));

        $dokter = new Dokter();
        $dokter->nama_dokter = $request->nama_dokter;
        $dokter->no_hp_dokter = $request->no_hp_dokter;
        $dokter->alamat_dokter = $request->alamat_dokter;
        $dokter->tgl_lahir_dokter = $request->tgl_lahir_dokter;
        $dokter->waktu_kerja = $request->waktu_kerja;
        $dokter->waktu_pulang = $waktu_pulang;
        $dokter->id_spesialis = $request->id_spesialis;
        $dokter->passworddok = preg_replace('/\D/', '', $request->passworddok);
        $dokter->id_akses = $this->getIdAkses('dokter');
        $dokter->no_identitas = $this->generateNoIdentitas();
        $dokter->save();

        return redirect('/admin/pengguna?status=added&role=dokter');
    }
}