@extends('layout.app')

@section('content')
<div class="w-full p-8 font-sans">
    
    @php
        // Mengambil data role dan detail data user dari session yang aktif
        $role = session('role', 'unknown');
        $data = session('data', []);

        // Mencocokkan nama berdasarkan role seperti di layout utama
        $profile_name = match($role) {
            'admin' => $data['nama_admin'] ?? 'Administrator',
            'pasien' => $data['nama_pasien'] ?? 'Pasien',
            'dokter' => $data['nama_dokter'] ?? 'Dokter',
            default => 'Pengguna'
        };
    @endphp

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang di Puskesmas</h1>
        <h2 class="text-2xl font-bold text-[#004085] mt-1">{{ $profile_name }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl">
        <a href="/admin/tambah-pengguna" class="flex items-center gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:shadow-[0_4px_25px_rgba(0,0,0,0.06)] transition dynamic-card">
            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm6 .11c1.42-.45 2.5-1.74 2.5-3.31 0-2.03-1.65-3.69-3.69-3.69-.32 0-.62.05-.92.13C13.82 4.47 14.5 5.66 14.5 7c0 2.05-1.29 3.81-3.1 4.46 1.12.43 2.33.65 3.6.65zm-6 1.89c-2.7 0-8 1.35-8 4v2h16v-2c0-2.65-5.3-4-8-4zm6 .11c-.21 0-.42.02-.63.05 1.57 1.09 2.63 2.62 2.63 3.95v1.89h4v-1.89c0-2-3.81-4-6-4z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-sm">Tambah Pengguna</h4>
                <p class="text-xs text-gray-400 mt-0.5">Buat akun admin atau petugas baru</p>
            </div>
        </a>

        <a href="/admin/spesialis" class="flex items-center gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:shadow-[0_4px_25px_rgba(0,0,0,0.06)] transition dynamic-card">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-3.75-3.75m11.25-3.75a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-sm">Tambah Spesialis</h4>
                <p class="text-xs text-gray-400 mt-0.5">Kelola bidang spesialis dokter</p>
            </div>
        </a>
    </div>
</div>
@endsection

@php
    $page_title = 'Dashboard Admin';

    $page_style = [
        'dashboard_admin.css'
    ];

    $role = strtolower(session('role') ?? '');

    if ($role !== 'admin') {
        abort(403, 'Akses ditolak');
    }

    $nama = session('data')['nama_admin'] ?? 'Administrator';
@endphp

