@php
    $page_title = 'Edit Pengguna';

    $page_style = [
        'edit_pengguna.css'
    ];
@endphp

@include('layout.header')

<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">

    <div class="mb-6">
        <h2 class="text-2xl font-bold">
            Edit Pengguna ({{ ucfirst($role) }})
        </h2>
    </div>

    <form
        action="{{ url('admin/pengguna/update') }}"
        method="POST"
        onsubmit="return validateForm()"
    >
        @csrf

        <input type="hidden" name="role" value="{{ $role }}">
        <input type="hidden" name="id" value="{{ $id }}">

        {{-- PASIEN --}}
        @if($role === 'pasien')

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    NIK
                </label>

                <input
                    type="text"
                    name="nik"
                    maxlength="16"
                    value="{{ $details['nik'] ?? '' }}"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama_pasien"
                    value="{{ $details['nama_pasien'] ?? '' }}"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Alamat
                </label>

                <textarea
                    name="alamat_pasien"
                    class="w-full border rounded p-2"
                    required
                >{{ $details['alamat_pasien'] ?? '' }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Umur
                </label>

                <input
                    type="text"
                    name="umur"
                    value="{{ $details['umur'] ?? '' }}"
                    class="w-full border rounded p-2"
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Jenis Kelamin
                </label>

                <label class="mr-4">
                    <input
                        type="radio"
                        name="jenis_kelamin"
                        value="L"
                        {{ ($details['jenis_kelamin'] ?? '') == 'L' ? 'checked' : '' }}
                    >
                    Laki-laki
                </label>

                <label>
                    <input
                        type="radio"
                        name="jenis_kelamin"
                        value="P"
                        {{ ($details['jenis_kelamin'] ?? '') == 'P' ? 'checked' : '' }}
                    >
                    Perempuan
                </label>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    No HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    value="{{ $details['no_hp'] ?? '' }}"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    PIN (Opsional)
                </label>

                <input
                    type="text"
                    id="password-pasien"
                    name="password"
                    maxlength="6"
                    class="w-full border rounded p-2"
                >

                <small
                    id="note-pasien"
                    class="text-red-500 hidden"
                >
                    PIN harus 6 digit angka
                </small>
            </div>

        {{-- ADMIN --}}
        @elseif($role === 'admin')

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama_admin"
                    value="{{ $details->nama_admin ?? '' }}"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Waktu Jaga
                </label>

                <input
                    type="time"
                    name="waktu_jaga"
                    value="{{ $details->nama_pasien ?? '' }}"
                    class="w-full border rounded p-2"
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    PIN (Opsional)
                </label>

                <input
                    type="text"
                    id="password-admin"
                    name="passwordadmin"
                    maxlength="6"
                    class="w-full border rounded p-2"
                >

                <small
                    id="note-admin"
                    class="text-red-500 hidden"
                >
                    PIN harus 6 digit angka
                </small>
            </div>

        {{-- DOKTER --}}
        @elseif($role === 'dokter')

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama_dokter"
                    value="{{ $details->nama_dokter ?? '' }}"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    No HP
                </label>

                <input
                    type="text"
                    name="no_hp_dokter"
                    value="{{ $details['no_hp_dokter'] ?? '' }}"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Alamat
                </label>

                <textarea
                    name="alamat_dokter"
                    class="w-full border rounded p-2"
                >{{ $details['alamat_dokter'] ?? '' }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Tanggal Lahir
                </label>

                <input
                    type="date"
                    name="tgl_lahir_dokter"
                    value="{{ $details['tgl_lahir_dokter'] ?? '' }}"
                    class="w-full border rounded p-2"
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Waktu Kerja
                </label>

                <input
                    type="time"
                    name="waktu_kerja"
                    value="{{ $details['waktu_kerja'] ?? '' }}"
                    class="w-full border rounded p-2"
                >
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Spesialis
                </label>

                <select
                    name="id_spesialis"
                    class="w-full border rounded p-2"
                    required
                >
                    <option value="">
                        -- Pilih Spesialis --
                    </option>

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

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    PIN (Opsional)
                </label>

                <input
                    type="text"
                    id="password-dokter"
                    name="passworddok"
                    maxlength="6"
                    class="w-full border rounded p-2"
                >

                <small
                    id="note-dokter"
                    class="text-red-500 hidden"
                >
                    PIN harus 6 digit angka
                </small>
            </div>

        @endif

        <div class="flex gap-3 mt-6">

            <button
                type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded"
            >
                Simpan
            </button>

            <a
                href="{{ url('admin/pengguna/detail/'.$role.'/'.$id) }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded"
            >
                Kembali
            </a>

        </div>

    </form>

</div>

<script src="{{ asset('js/edit-pengguna.js') }}"></script>

@include('layout.footer')