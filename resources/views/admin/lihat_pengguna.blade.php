{{-- resources/views/admin/lihat_pengguna.blade.php --}}

@php
    $page_title = 'Daftar Pengguna';

    $page_style = [
        'lihat_pengguna.css'
    ];
@endphp

@include('layout.header')

<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-white border rounded-2xl shadow-sm p-6">
        <h2 class="text-3xl font-bold text-gray-800">
            Daftar Pengguna
        </h2>
    </div>

    {{-- Filter --}}
    <div class="bg-white border rounded-2xl shadow-sm p-6">

        <form method="GET" action="{{ url('admin/pengguna') }}" class="flex flex-wrap gap-4 items-center">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Filter Role
                </label>

                <select
                    name="role"
                    class="border rounded-lg px-4 py-2"
                >
                    <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>
                        Semua
                    </option>

                    <option value="pasien" {{ $filter == 'pasien' ? 'selected' : '' }}>
                        Pasien
                    </option>

                    <option value="dokter" {{ $filter == 'dokter' ? 'selected' : '' }}>
                        Dokter
                    </option>

                    <option value="admin" {{ $filter == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Cari
                </label>

                <input
                    type="text"
                    name="q"
                    value="{{ $q }}"
                    placeholder="Cari pengguna..."
                    class="border rounded-lg px-4 py-2 w-64"
                >
            </div>

            <div class="pt-6">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition"
                >
                    Terapkan
                </button>
            </div>

        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-6 py-4 font-semibold text-gray-700">
                            Role
                        </th>

                        <th class="text-left px-6 py-4 font-semibold text-gray-700">
                            Nama
                        </th>

                        <th class="text-left px-6 py-4 font-semibold text-gray-700">
                            No Identitas
                        </th>

                        <th class="text-left px-6 py-4 font-semibold text-gray-700">
                            No HP
                        </th>

                        <th class="text-left px-6 py-4 font-semibold text-gray-700">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($rows as $r)

                        <tr class="border-t hover:bg-gray-50 transition">

                            <td class="px-6 py-4">
                                <span class="capitalize">
                                    {{ $r->role }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                {{ $r->nama }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $r->identifier }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $r->no_hp ?? '-' }}
                            </td>

                            <td class="px-6 py-4">

                                <a
                                    href="{{ url('admin/pengguna/detail/' . $r->role . '/' . $r->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition"
                                >
                                    Lihat
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500">
                                Tidak ada pengguna ditemukan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@include('layout.footer')