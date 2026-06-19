@extends('layout.app')

@section('content')
<div class="w-full p-8 font-sans flex justify-center">
    <div class="w-full max-w-lg">
        <div class="mb-4">
            <a href="/admin/tambah-pengguna" class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                ← Kembali
            </a>
        </div>
        <div class="bg-white shadow-xl rounded-2xl border p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Admin</h2>
            <form method="POST" action="/admin/pengguna/admin" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama Admin</label>
                    <input name="nama_admin" placeholder="Nama" class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Waktu Jaga</label>
                    <input name="waktu_jaga" type="time" class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password Admin</label>
                    <div class="relative">
                        <input id="passwordadmin" name="passwordadmin" maxlength="6" type="password" class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 pr-10">
                        <button type="button" onclick="togglePassword('passwordadmin','eyeOpenAdmin','eyeClosedAdmin')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                            <svg id="eyeOpenAdmin" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eyeClosedAdmin" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.362m3.362-2.042A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.507 2.658M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-semibold hover:bg-indigo-700 transition">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@php
    $page_title = 'Tambah Admin';
    $page_style = ['form_pengguna.css'];
    $force_active_menu = 'dashboard';
@endphp
