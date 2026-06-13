<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spesialis; // ◄--- PENTING: Import model Spesialis
use App\Models\Pasien;    // ◄--- PENTING: Import model Pasien
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 2. Ambil semua data spesialis dari database
        $spesialis = Spesialis::all(); 
        
        // Ambil data pendukung lain jika dashboard-mu membutuhkannya
        $pasien = Pasien::all();
        $dokter = []; // Sesuaikan dengan logic data dokter di aplikasimu

        // 3. Kirim variabel ke dalam view admin.dashboard
        return view('admin.dashboard', compact('spesialis', 'pasien', 'dokter'));
    }
}