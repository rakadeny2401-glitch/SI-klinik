@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 tracking-wide">Riwayat Pemeriksaan Dokter</h2>
    </div>

    <div class="w-full bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full min-w-[900px] border-collapse text-left text-sm m-0">
                
                <thead>
                    <tr class="bg-[#004085] text-white font-bold">
                        <th class="p-3.5 pl-6 border-r border-[#003366]/30">Nama Pasien</th>
                        <th class="p-3.5 text-center border-r border-[#003366]/30">Umur</th>
                        <th class="p-3.5 border-r border-[#003366]/30">Keluhan</th>
                        <th class="p-3.5 border-r border-[#003366]/30">Obat Diberikan</th>
                        <th class="p-3.5 border-r border-[#003366]/30">Rekomendasi</th>
                        <th class="p-3.5 text-center">Detail Surat</th>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($riwayat as $r)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        
                        <td class="p-4 pl-6 font-semibold text-gray-800 border-r border-gray-100">
                            {{ $r->nama_pasien }}
                        </td>
                        
                        <td class="p-4 text-center text-gray-600 border-r border-gray-100 whitespace-nowrap">
                            {{ $r->umur }} tahun
                        </td>
                        
                        <td class="p-4 text-gray-600 border-r border-gray-100 max-w-[200px] truncate" title="{{ $r->keluhan }}">
                            {{ $r->keluhan ?? '-' }}
                        </td>
                        
                        <td class="p-4 text-gray-600 border-r border-gray-100 max-w-[200px] truncate" title="{{ $r->resep_obat ?? '-' }}">
    {{ $r->resep_obat ?? 'Oralit' }}
</td>
                        
                        <td class="p-4 text-gray-600 font-medium border-r border-gray-100">
                            @if($r->ada_rujukan && $r->ada_sakit)
                                <span class="text-indigo-600">Surat Sakit & Rujukan RS</span>
                            @elseif($r->ada_rujukan)
                                <span class="text-blue-600">Surat Rujukan RS</span>
                            @elseif($r->ada_sakit)
                                <span class="text-emerald-600">Surat Sakit</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        
                        <td class="p-4 text-center align-middle whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Jika Pasien Memiliki Surat Sakit --}}
                                @if($r->ada_sakit)
                                    <a href="{{ url('/dokter/riwayat/sakit/'.$r->id_daftar) }}" 
                                       class="px-3 py-1.5 bg-[#004085] hover:bg-[#002752] text-white text-xs font-bold rounded shadow-sm no-underline transition">
                                        Surat Sakit
                                    </a>
                                @endif

                                {{-- Jika Pasien Memiliki Surat Rujukan --}}
                                @if($r->ada_rujukan)
                                    <a href="{{ url('/dokter/riwayat/rujukan/'.$r->id_daftar) }}" 
                                       class="px-3 py-1.5 bg-[#0a58ca] hover:bg-[#0b4dadd] text-white text-xs font-bold rounded shadow-sm no-underline transition">
                                        Surat Rujukan
                                    </a>
                                @endif

                                {{-- Jika Tidak Membuat Surat Apapun --}}
                                @if(!$r->ada_sakit && !$r->ada_rujukan)
                                    <span class="text-gray-400 font-bold">-</span>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-center gap-1">
        
        {{-- Tombol Previous --}}
        @if ($riwayat->onFirstPage())
            <span class="px-3 py-1.5 bg-gray-100 text-gray-400 border border-gray-200 rounded-lg text-xs font-bold cursor-not-allowed select-none">
                &laquo;
            </span>
        @else
            <a href="{{ $riwayat->previousPageUrl() }}" 
               class="px-3 py-1.5 bg-white text-[#004085] border border-gray-300 hover:bg-gray-50 rounded-lg text-xs font-bold no-underline transition shadow-sm">
                &laquo;
            </a>
        @endif

        {{-- Nomor Halaman --}}
        @foreach ($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
            @if ($page == $riwayat->currentPage())
                <span class="px-3 py-1.5 bg-[#004085] text-white border border-[#004085] rounded-lg text-xs font-bold shadow-sm">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}" 
                   class="px-3 py-1.5 bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 rounded-lg text-xs font-medium no-underline transition shadow-sm">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Tombol Next --}}
        @if ($riwayat->hasMorePages())
            <a href="{{ $riwayat->nextPageUrl() }}" 
               class="px-3 py-1.5 bg-white text-[#004085] border border-gray-300 hover:bg-gray-50 rounded-lg text-xs font-bold no-underline transition shadow-sm">
                Next &raquo;
            </a>
        @else
            <span class="px-3 py-1.5 bg-gray-100 text-gray-400 border border-gray-200 rounded-lg text-xs font-bold cursor-not-allowed select-none">
                Next &raquo;
            </span>
        @endif

    </div>
</div>
@endsection