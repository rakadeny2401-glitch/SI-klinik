@extends('layout.app')

@section('content')

<div class="w-full p-8 font-sans flex justify-center">
    <div class="w-full max-w-3xl">

        <div class="mb-4">
            {{-- Tombol kembali di atas form edit --}}
            <a href="{{ url('admin/pengguna/lihat/'.$role.'/'.$id) }}"
            class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                ← Kembali
            </a>

        </div>

        <div class="bg-white shadow-xl rounded-2xl border p-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Edit Pengguna ({{ ucfirst($role) }})
            </h2>

            <form action="{{ url('admin/pengguna/update') }}"
                  method="POST"
                  onsubmit="return validateForm()"
                  class="space-y-6">

                @csrf

                <input type="hidden" name="role" value="{{ $role }}">
                <input type="hidden" name="id" value="{{ $id }}">

                @if($role === 'pasien')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            NIK
                        </label>
                        <input
                            type="text"
                            name="nik"
                            maxlength="16"
                            value="{{ $details['nik'] ?? '' }}"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Nama Pasien
                        </label>
                        <input
                            type="text"
                            name="nama_pasien"
                            value="{{ $details['nama_pasien'] ?? '' }}"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Alamat
                        </label>
                        <textarea
                            name="alamat_pasien"
                            rows="3"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required
                        >{{ $details['alamat_pasien'] ?? '' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Umur
                        </label>
                        <input
                            type="text"
                            name="umur"
                            value="{{ $details['umur'] ?? '' }}"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Kelamin
                        </label>

                        <div class="flex gap-6 mt-2">
                            <label class="flex items-center gap-2">
                                <input
                                    type="radio"
                                    name="jenis_kelamin"
                                    value="L"
                                    {{ ($details['jenis_kelamin'] ?? '') == 'L' ? 'checked' : '' }}
                                >
                                Laki-laki
                            </label>

                            <label class="flex items-center gap-2">
                                <input
                                    type="radio"
                                    name="jenis_kelamin"
                                    value="P"
                                    {{ ($details['jenis_kelamin'] ?? '') == 'P' ? 'checked' : '' }}
                                >
                                Perempuan
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            No HP
                        </label>
                        <input
                            type="text"
                            name="no_hp"
                            value="{{ $details['no_hp'] ?? '' }}"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            PIN Baru (Opsional)
                        </label>

                        <div class="relative">
                            <input
                                id="password-pasien"
                                type="password"
                                name="password"
                                maxlength="6"
                                class="mt-2 w-full border rounded-lg px-4 py-2 text-sm pr-10 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            >

                            <button type="button"
                                    onclick="togglePassword('password-pasien','eyeOpenPasien','eyeClosedPasien')"
                                    class="absolute inset-y-0 right-3 flex items-center text-gray-500">

                                <svg id="eyeOpenPasien" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>

                                <svg id="eyeClosedPasien" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                                </svg>

                            </button>
                        </div>

                        <small id="note-pasien" class="text-red-500 hidden">
                            PIN harus 6 digit angka
                        </small>
                    </div>

                @elseif($role === 'admin')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Nama Admin
                        </label>

                        <input
                            type="text"
                            name="nama_admin"
                            value="{{ $details->nama_admin ?? '' }}"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Waktu Jaga
                        </label>

                        <input
                            type="time"
                            name="waktu_jaga"
                            value="{{ $details->waktu_jaga ?? '' }}"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        >
                                        <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            PIN Baru (Opsional)
                        </label>

                        <div class="relative">
                            <input
                                id="password-admin"
                                type="password"
                                name="passwordadmin"
                                maxlength="6"
                                class="mt-2 w-full border rounded-lg px-4 py-2 text-sm pr-10 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            >

                            <button type="button"
                                    onclick="togglePassword('password-admin','eyeOpenAdmin','eyeClosedAdmin')"
                                    class="absolute inset-y-0 right-3 flex items-center text-gray-500">

                                <svg id="eyeOpenAdmin" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>

                                <svg id="eyeClosedAdmin" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                                </svg>

                            </button>
                        </div>

                        <small id="note-admin" class="text-red-500 hidden">
                            PIN harus 6 digit angka
                        </small>
                    </div>

                @elseif($role === 'dokter')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Nama Dokter
                        </label>

                        <input
                            type="text"
                            name="nama_dokter"
                            value="{{ $details->nama_dokter ?? '' }}"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            No HP Dokter
                        </label>

                        <input
                            type="text"
                            name="no_hp_dokter"
                            value="{{ $details['no_hp_dokter'] ?? '' }}"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Alamat Dokter
                        </label>

                        <textarea
                            name="alamat_dokter"
                            rows="3"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        >{{ $details['alamat_dokter'] ?? '' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Tanggal Lahir
                        </label>

                        <input
                            type="date"
                            name="tgl_lahir_dokter"
                            value="{{ $details['tgl_lahir_dokter'] ?? '' }}"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Waktu Kerja
                        </label>

                        <input
                            type="time"
                            name="waktu_kerja"
                            value="{{ $details['waktu_kerja'] ?? '' }}"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            Spesialis
                        </label>

                        <select
                            name="id_spesialis"
                            class="mt-2 w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required
                        >
                            <option value="">-- Pilih Spesialis --</option>

                            @foreach($spesialis as $sp)
                                <option
                                    value="{{ $sp->id_spesialis }}"
                                    {{ ($details['id_spesialis'] ?? '') == $sp->id_spesialis ? 'selected' : '' }}
                                >
                                    {{ $sp->nama_spesialis }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">
                            PIN Baru (Opsional)
                        </label>

                        <div class="relative">
                            <input
                                id="password-dokter"
                                type="password"
                                name="passworddok"
                                maxlength="6"
                                class="mt-2 w-full border rounded-lg px-4 py-2 text-sm pr-10 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            >

                            <button type="button"
                                    onclick="togglePassword('password-dokter','eyeOpenDok','eyeClosedDok')"
                                    class="absolute inset-y-0 right-3 flex items-center text-gray-500">

                                <svg id="eyeOpenDok" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>

                                <svg id="eyeClosedDok" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                                </svg>

                            </button>
                        </div>

                        <small id="note-dokter" class="text-red-500 hidden">
                            PIN harus 6 digit angka
                        </small>
                    </div>

                @endif

                <div class="flex gap-3 pt-4">
                    <button
                        type="submit"
                        class="flex-1 bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition"
                    >
                        Simpan Perubahan
                    </button>

                    <a href="{{ url('admin/pengguna') }}"
                    class="flex-1 text-center bg-gray-200 text-gray-700 py-2.5 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@php
    $page_title = 'Edit Pengguna';
    $page_style = ['edit_pengguna.css'];
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

<script src="{{ asset('js/edit-pengguna.js') }}"></script>