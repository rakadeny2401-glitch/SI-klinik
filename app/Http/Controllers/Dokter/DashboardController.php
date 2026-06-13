<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (session('role') !== 'dokter') {
            return redirect('/');
        }

        $id_dokter = session('data.id_dokter');

        $chart1 = DB::table('daftar')
            ->select('id_daftar', DB::raw('COUNT(*) as total'))
            ->where('id_dokter', $id_dokter)
            ->groupBy('id_daftar')
            ->orderBy('id_daftar', 'asc')
            ->get();

        $label = [];
        $data = [];

        foreach ($chart1 as $row) {
            $label[] = 'Daftar ' . $row->id_daftar;
            $data[] = $row->total;
        }

        $chart2 = DB::table('daftar')
            ->select(DB::raw('DATE(waktu_daftar) as tanggal'), DB::raw('COUNT(*) as jumlah'))
            ->where('id_dokter', $id_dokter)
            ->groupBy(DB::raw('DATE(waktu_daftar)'))
            ->orderBy(DB::raw('DATE(waktu_daftar)'))
            ->get();

        $label2 = [];
        $data2 = [];

        foreach ($chart2 as $row) {
            $label2[] = $row->tanggal;
            $data2[] = (int) $row->jumlah;
        }

        return view('dokter.dashboard', compact('label', 'data', 'label2', 'data2'));
    }
}