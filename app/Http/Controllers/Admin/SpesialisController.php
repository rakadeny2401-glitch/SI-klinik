<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Spesialis;
use App\Models\Dokter;

class SpesialisController extends Controller
{
    // =========================
    // LIST SPESIALIS + PAGINATION
    // =========================
    public function index(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect('/');
        }

        $page = $request->get('page', 1);
        $perPage = 5;

        $all = Spesialis::orderBy('nama_spesialis', 'asc')->get();

        $total = $all->count();
        $totalPage = max(1, ceil($total / $perPage));

        $rows = $all->slice(($page - 1) * $perPage, $perPage);

        return view('admin.spesialis.index', compact(
            'rows', 'page', 'perPage', 'totalPage'
        ));
    }

    // =========================
    // VIEW CREATE
    // =========================
    public function create()
    {
        if (session('role') !== 'admin') {
            return redirect('/');
        }

        return view('admin.spesialis.create');
    }

    // =========================
    // STORE SPESIALIS
    // =========================
    public function store(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect('/');
        }

        $request->validate([
            'nama_spesialis' => 'required'
        ]);

        $exists = Spesialis::whereRaw('LOWER(nama_spesialis)=?', [strtolower($request->nama_spesialis)])
            ->first();

        if ($exists) {
            return back()->with('error', 'Spesialis sudah ada');
        }

        Spesialis::create([
            'nama_spesialis' => $request->nama_spesialis
        ]);

        return redirect('/admin/spesialis?status=added');
    }

    // =========================
    // DETAIL SPESIALIS
    // =========================
    public function show($id, Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect('/');
        }

        $sp = Spesialis::findOrFail($id);

        $page = $request->get('page', 1);
        $perPage = 5;

        $all = Dokter::where('id_spesialis', $id)
            ->orderBy('nama_dokter', 'asc')
            ->get();

        $total = $all->count();
        $totalPage = max(1, ceil($total / $perPage));

        $rows = $all->slice(($page - 1) * $perPage, $perPage);

        return view('admin.spesialis.detail', compact(
            'sp', 'rows', 'page', 'totalPage', 'id'
        ));
    }

    // =========================
    // DELETE SPESIALIS
    // =========================
    public function destroy(Request $request)
    {
        if (session('role') !== 'admin') {
            return redirect('/');
        }

        $id = $request->id_spesialis;

        $hasDokter = Dokter::where('id_spesialis', $id)->exists();

        if ($hasDokter) {
            return redirect('/admin/spesialis?status=blocked');
        }

        $sp = Spesialis::find($id);

        if ($sp) {
            $sp->delete();
            return redirect('/admin/spesialis?status=deleted');
        }

        return back();
    }
}