<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('login.login_nama');
    }

    /**
     * Handle login process
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'no_identitas' => 'required|string',
        ]);

        $no_identitas = $validated['no_identitas'];

        // Check admin
        $admin = DB::table('admin')
            ->where('no_identitas', $no_identitas)
            ->first();

        if ($admin) {
            Session::put('role', 'admin');
            Session::put('data', $admin);
            return redirect('/admin/dashboard');
        }

        // Check dokter
        $dokter = DB::table('dokter')
            ->where('no_identitas', $no_identitas)
            ->first();

        if ($dokter) {
            Session::put('role', 'dokter');
            Session::put('data', $dokter);
            return redirect('/dokter/dashboard');
        }

        // Check pasien
        $pasien = DB::table('pasien')
            ->where('no_identitas', $no_identitas)
            ->first();

        if ($pasien) {
            Session::put('role', 'pasien');
            Session::put('data', $pasien);
            return redirect('/pasien/dashboard');
        }

        return back()->with('error', 'Nomor identitas tidak ditemukan!');
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
