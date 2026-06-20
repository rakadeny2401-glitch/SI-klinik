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
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Dokter</h2>
            <form method="POST" action="/admin/pengguna/dokter" class="space-y-6">
                @csrf
                @if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm p-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama Dokter</label>
                    <input name="nama_dokter" placeholder="Contoh: dr. Andi Saputra" class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">No HP Dokter</label>
                    <input name="no_hp_dokter" placeholder="08xxxxxxxxxx" class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Alamat Dokter</label>
                    <textarea name="alamat_dokter" placeholder="Contoh: Bandung" class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir_dokter" class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Waktu Mulai Kerja</label>
                    <input type="time" name="waktu_kerja" class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Spesialis</label>
                    <select name="id_spesialis" class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        @foreach($spesialis as $sp)
                            <option value="{{ $sp->id_spesialis }}">{{ $sp->nama_spesialis }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password Dokter</label>
                    <div class="relative">
                        <input id="passworddok" name="passworddok" maxlength="6" type="password" class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 pr-10">
                        <button type="button" onclick="togglePassword('passworddok','eyeOpenDok','eyeClosedDok')" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                            <svg id="eyeOpenDok" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eyeClosedDok" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.362m3.362-2.042A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.507 2.658M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@php
    $page_title = 'Tambah Dokter';
    $page_style = ['form_pengguna.css'];
    $force_active_menu = 'dashboard';
@endphp

<script>
function togglePassword(inputId, eyeOpenId, eyeClosedId) {
    const input = document.getElementById(inputId);
    const eyeOpen = document.getElementById(eyeOpenId);
    const eyeClosed = document.getElementById(eyeClosedId);
    if (input.type === "password") {
        input.type = "text";
        eyeOpen.classList.add("hidden");
        eyeClosed.classList.remove("hidden");
    } else {
        input.type = "password";
        eyeOpen.classList.remove("hidden");
        eyeClosed.classList.add("hidden");
    }
}
</script>
