@extends('layout.app')

@section('content')
<div class="w-full p-8 font-sans">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Pengguna</h1>
        <p class="text-sm text-gray-500 mt-1">Pilih jenis pengguna yang ingin ditambahkan</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl">
        <!-- Tambah Pasien -->
        <a href="{{ url('admin/pengguna/pasien') }}" class="flex items-center gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow hover:shadow-lg transition">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                <!-- Ikon User -->
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-sm">Tambah Pasien</h4>
                <p class="text-xs text-gray-400 mt-0.5">Buat akun pasien baru</p>
            </div>
        </a>

        <!-- Tambah Admin -->
        <a href="{{ url('admin/pengguna/admin') }}" class="flex items-center gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow hover:shadow-lg transition">
            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center shrink-0">
                <!-- Ikon Shield/Admin -->
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l7 4v6c0 5-3.5 9.5-7 10-3.5-.5-7-5-7-10V6l7-4z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-sm">Tambah Admin</h4>
                <p class="text-xs text-gray-400 mt-0.5">Buat akun admin baru</p>
            </div>
        </a>

        <!-- Tambah Dokter -->
        <a href="{{ url('admin/pengguna/dokter') }}" class="flex items-center gap-4 bg-white p-6 rounded-2xl border border-gray-100 shadow hover:shadow-lg transition">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                <!-- Ikon Stetoskop/Dokter -->
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8a6 6 0 1112 0v5a3 3 0 01-6 0V8m0 9v3m-6-3v3m12-3v3"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-sm">Tambah Dokter</h4>
                <p class="text-xs text-gray-400 mt-0.5">Buat akun dokter baru</p>
            </div>
        </a>
    </div>
</div>
@endsection

@php
    $page_title = 'Tambah Pengguna';
    $page_style = ['tambah_pengguna.css'];
    $force_active_menu = 'dashboard';
@endphp
