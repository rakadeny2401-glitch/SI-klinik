@extends('layout.app')

@section('content')

<!-- Container Utama: Pakai w-full dan padding agar nge-stretch pas ke kanan -->
<div class="w-full p-6 font-sans">
    
    <!-- Judul Halaman -->
    <h2 class="text-3xl font-bold text-[#1f2937] mb-6">Daftar Pengguna</h2>

    <!-- Form Filter & Cari: Baris lurus, item sejajar vertikal -->
    <form method="GET" action="/admin/pengguna" class="flex items-center gap-3 mb-6 text-sm">
        <div class="flex items-center gap-2">
            <label for="role" class="text-gray-600 shrink-0">Filter role:</label>
            <select name="role" id="role" class="py-1.5 px-3 border border-[#ccc] rounded bg-white text-sm focus:outline-none min-w-[100px]">
                <option value="">Semua</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="pasien" {{ request('role') == 'pasien' ? 'selected' : '' }}>Pasien</option>
                <option value="dokter" {{ request('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <label for="cari" class="text-gray-600 shrink-0">Cari:</label>
            <input type="text" name="cari" id="cari" placeholder="Cari..." value="{{ request('cari') }}" class="py-1.5 px-3 border border-[#ccc] rounded text-sm focus:outline-none w-48 placeholder-gray-400">
        </div>

        <!-- Tombol Terapkan: Fix overlap, kasih padding pas -->
        <button type="submit" class="bg-[#004085] text-white py-1.5 px-4 rounded text-sm font-medium cursor-pointer transition hover:bg-[#002752] shrink-0">
            Terapkan
        </button>
    </form>

    <!-- Wrapper Tabel: Pakai w-full border tipis luar -->
    <div class="w-full overflow-x-auto border border-[#dee2e6] rounded-sm bg-white">
        <!-- Tabel Modern Full Width -->
        <table class="w-full border-collapse table-fixed">
            <thead>
                <tr class="bg-[#004085]">
                    <th class="w-[12%] text-white font-semibold py-3 px-4 border border-[#dee2e6] text-center text-sm">Role</th>
                    <th class="w-[28%] text-white font-semibold py-3 px-4 border border-[#dee2e6] text-center text-sm">Nama</th>
                    <th class="w-[25%] text-white font-semibold py-3 px-4 border border-[#dee2e6] text-center text-sm">No Identitas</th>
                    <th class="w-[23%] text-white font-semibold py-3 px-4 border border-[#dee2e6] text-center text-sm">No HP</th>
                    <th class="w-[12%] text-white font-semibold py-3 px-4 border border-[#dee2e6] text-center text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($rows->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-gray-400 py-6 border border-[#dee2e6] bg-white text-sm">
                        Tidak ada data pengguna ditemukan
                    </td>
                </tr>
                @else
                @foreach($rows as $user)
                <tr class="hover:bg-[#f8f9fa] transition-colors duration-150">
                    <td class="py-3 px-4 border border-[#dee2e6] text-center align-middle bg-white text-sm text-gray-700 whitespace-nowrap">{{ $user->role ?? '-' }}</td>
                    <td class="py-3 px-4 border border-[#dee2e6] text-center align-middle bg-white text-sm text-gray-700 truncate">{{ $user->name ?? $user->nama ?? '-' }}</td>
                    <td class="py-3 px-4 border border-[#dee2e6] text-center align-middle bg-white text-sm text-gray-700 whitespace-nowrap">{{ $user->no_identitas ?? $user->nik ?? '-' }}</td>
                    <td class="py-3 px-4 border border-[#dee2e6] text-center align-middle bg-white text-sm text-gray-700 whitespace-nowrap">{{ $user->no_hp ?? '-' }}</td>
                    <td class="py-3 px-4 border border-[#dee2e6] text-center align-middle bg-white">
                        <!-- Tombol Lihat: Dibuat inline-flex biar ga gepeng/ciut -->
                        <a href="/admin/pengguna/lihat/{{ $user->role }}/{{ $user->id }}" class="inline-flex items-center justify-center py-1 px-3 bg-[#e6f0fa] text-[#004085] border border-[#b2cbe5] rounded text-xs font-medium no-underline transition hover:bg-[#cce2f5]">
                            Lihat
                        </a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination Container: Di tengah, margin top pas -->
    <div class="flex gap-1.5 justify-center items-center mt-6">
        @for($i = 1; $i <= $totalPage; $i++)
            <a href="?page={{ $i }}&role={{ request('role') }}&cari={{ request('cari') }}"
               class="inline-flex items-center justify-center w-8 h-8 border rounded text-xs font-semibold no-underline transition-all duration-150 {{ $page == $i ? 'bg-[#004085] text-white border-[#004085]' : 'border-[#dee2e6] text-gray-600 bg-white hover:bg-gray-100' }}">
               {{ $i }}
            </a>
        @endfor

        @if($page < $totalPage)
            <a href="?page={{ $page + 1 }}&role={{ request('role') }}&cari={{ request('cari') }}"
               class="inline-flex items-center justify-center h-8 px-3 border border-[#dee2e6] rounded text-xs font-semibold no-underline text-gray-600 bg-white hover:bg-gray-100">
               Next »
            </a>
        @endif
    </div>
</div>

@endsection