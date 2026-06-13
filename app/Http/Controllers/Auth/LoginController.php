<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Dokter;
use App\Models\Pasien;

class LoginController extends Controller
{
    // =========================
    // VIEW LOGIN NO IDENTITAS
    // =========================
    public function index()
    {
        return view('welcome');
    }

    // =========================
    // LOGIN NO IDENTITAS
    // =========================
    public function loginNoIdentitas(Request $request)
    {
        $no = $request->no_identitas;

        // ADMIN
        $admin = Admin::where('no_identitas', $no)->first();
        if ($admin) {
            session([
                'role' => 'admin',
                'data' => $admin
            ]);
            return redirect('/admin/dashboard');
        }

        // DOKTER
        $dokter = Dokter::where('no_identitas', $no)->first();
        if ($dokter) {
            session([
                'role' => 'dokter',
                'data' => $dokter
            ]);
            return redirect('/dokter/dashboard');
        }

        // PASIEN
        $pasien = Pasien::where('no_identitas', $no)->first();
        if ($pasien) {
            session([
                'role' => 'pasien',
                'data' => $pasien
            ]);
            return redirect('/pasien/dashboard');
        }

        return back()->with('error', 'Nomor identitas tidak ditemukan!');
    }

    // =========================
    // VIEW LOGIN NAMA
    // =========================
    public function loginNamaView()
    {
        return view('login_nama');
    }

    // =========================
    // LOGIN NAMA + PIN
    // =========================
    public function loginNama(Request $request)
    {
        $nama = $request->nama;
        $password = $request->password;

        // ADMIN
        $admin = Admin::where('nama_admin', $nama)
            ->where('passwordadmin', $password)
            ->first();

        if ($admin) {
            session([
                'role' => 'admin',
                'data' => $admin
            ]);
            return redirect('/admin/dashboard');
        }

        // DOKTER
        $dokter = Dokter::where('nama_dokter', $nama)
            ->where('passworddok', $password)
            ->first();

        if ($dokter) {
            session([
                'role' => 'dokter',
                'data' => $dokter
            ]);
            return redirect('/dokter/dashboard');
        }

        // PASIEN
        $pasien = Pasien::where('nama_pasien', $nama)
            ->where('password', $password)
            ->first();

        if ($pasien) {
            session([
                'role' => 'pasien',
                'data' => $pasien
            ]);
            return redirect('/pasien/dashboard');
        }

        return back()->with('error', 'Akun tidak ditemukan!');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}