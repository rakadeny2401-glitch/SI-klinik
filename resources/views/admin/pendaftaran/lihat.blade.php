@extends('layout.app')

@section('content')
<div class="w-full font-sans">

    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">
        Daftar Pendaftaran
    </h2>

    <div class="flex justify-end mb-4">
        <form method="GET" action="" class="flex items gap-2">

            <select
                name="status"
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm">

                <option value="">Semua Status</option>

                <option value="pengecekan"
                    {{ request('status') == 'pengecekan' ? 'selected' : '' }}>
                    Pengecekan
                </option>

                <option value="dikonfirmasi"
                    {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>
                    Dikonfirmasi
                </option>

                <option value="selesai"
                    {{ request('status') == 'selesai' ? 'selected' : '' }}>
                    Selesai
                </option>

            </select>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari pasien, NIK, dokter..."
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm w-64">

            <button
                type="submit"
                class="px-4 py-2 bg-[#004085] text-white rounded-lg text-sm hover:opacity-90">
                Cari
            </button>

            @if(request('status') || request('search'))
                <a href="/admin/pendaftaran/lihat"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg text-sm hover:opacity-90">
                    Reset
                </a>
            @endif

        </form>
    </div>

    <div class="w-full bg-white rounded-xl border border-gray-200 shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
        
        <div class="w-full overflow-x-auto">
            <table class="w-full border-collapse text-left min-w-[1000px]">
                
                <thead>
                    <tr class="bg-[#004085]">
                        <th class="w-[40px] text-white font-semibold p-4 text-xs text-center border-b border-gray-200">No</th>
                        <th class="text-white font-semibold p-4 text-xs border-b border-gray-200">Nama Pasien</th>
                        <th class="text-white font-semibold p-4 text-xs border-b border-gray-200">NIK</th>
                        <th class="text-white font-semibold p-4 text-xs border-b border-gray-200">Spesialis</th>
                        <th class="text-white font-semibold p-4 text-xs border-b border-gray-200">Dokter</th>
                        <th class="text-white font-semibold p-4 text-xs text-center border-b border-gray-200">No Antrian</th>
                        <th class="text-white font-semibold p-4 text-xs border-b border-gray-200">Tanggal Pemeriksaan</th>
                        <th class="text-white font-semibold p-4 text-xs text-center border-b border-gray-200">Status</th>
                        <th class="text-white font-semibold p-4 text-xs border-b border-gray-200">Admin</th>
                        <th class="text-white font-semibold p-4 text-xs text-center border-b border-gray-200">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @if($rows->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center text-gray-400 p-8 text-sm bg-gray-50/50">
                                Tidak ada data pendaftaran ditemukan
                            </td>
                        </tr>
                    @else

                        @php $no = ($page - 1) * 5 + 1; @endphp

                        @foreach($rows as $r)
                            <tr class="hover:bg-gray-50/70 transition-colors duration-150">
                                <td class="p-4 text-xs text-gray-500 text-center align-middle">{{ $no++ }}</td>
                                <td class="p-4 text-xs text-gray-700 font-medium align-middle whitespace-normal max-w-[150px]">{{ $r->nama_pasien ?? '-' }}</td>
                                <td class="p-4 text-xs text-gray-600 font-mono align-middle">{{ $r->nik ?? '-' }}</td>
                                <td class="p-4 text-xs text-gray-700 align-middle">{{ $r->nama_spesialis ?? '-' }}</td>
                                <td class="p-4 text-xs text-gray-700 align-middle whitespace-normal max-w-[150px]">{{ $r->nama_dokter ?? '-' }}</td>
                                <td class="p-4 text-xs text-center font-bold text-gray-700 align-middle">{{ $r->no_antrian ?? '-' }}</td>
                                <td class="p-4 text-xs text-gray-600 align-middle">{{ $r->tgl_pemeriksaan ?? '-' }}</td>
                                
                                <td class="p-4 text-xs text-center align-middle">
                                    <span class="inline-block px-2.5 py-1 rounded-full font-medium 
                                        {{ ($r->status_pendaftaran ?? '') === 'pengecekan' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                                        {{ ($r->status_pendaftaran ?? '') === 'dikonfirmasi' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                                        {{ ($r->status_pendaftaran ?? '') === 'selesai' ? 'bg-green-50 text-green-700 border border-green-200' : '' }}
                                    ">
                                        {{ $r->status_pendaftaran ?? '-' }}
                                    </span>
                                </td>
                                
                                <td class="p-4 text-xs text-gray-600 align-middle">{{ $r->nama_admin ?? '-' }}</td>

                                <td class="p-4 text-center align-middle">
                                    @if(($r->status_pendaftaran ?? '') === 'pengecekan')
                                        <form method="POST" action="/admin/pendaftaran/confirm" class="inline m-0">
                                            @csrf
                                            <input type="hidden" name="id_daftar" value="{{ $r->id_daftar }}">
                                            <button type="submit" class="inline-flex items-center justify-center py-1.5 px-3 bg-[#dc3545] text-white border-none rounded text-xs font-semibold cursor-pointer transition hover:opacity-90 shadow-sm">
                                                Konfirmasi
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 font-bold">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center items-center gap-1.5 mt-6">
        @for($i = 1; $i <= $totalPage; $i++)
            <a href="?page={{ $i }}&status={{ request('status') }}&search={{ request('search') }}" 
            class="inline-flex items-center justify-center min-w-[32px] h-8 px-2.5 text-xs font-semibold rounded-lg no-underline transition-all duration-150
                    {{ $page == $i 
                        ? 'bg-[#004085] text-white shadow-sm' 
                        : 'bg-white text-gray-600 border border-gray-300 hover:bg-gray-50 hover:border-gray-400' }}">
                {{ $i }}
            </a>
        @endfor
        
        @if($page < $totalPage)
            <a href="?page={{ $page + 1 }}&status={{ request('status') }}&search={{ request('search') }}" 
            class="inline-flex items-center justify-center h-8 px-3 text-xs font-semibold bg-white text-gray-600 border border-gray-300 rounded-lg no-underline transition hover:bg-gray-50 hover:border-gray-400">
                Next »
            </a>
        @endif
    </div>

</div>
@endsection