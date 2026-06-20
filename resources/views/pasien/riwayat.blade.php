@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    
    <div class="w-full mx-auto bg-white rounded-2xl border border-gray-100 p-6 shadow-[0_4px_20px_rgba(0,0,0,0.012)]">
        
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 tracking-wide mb-6 text-left border-l-4 border-[#004085] pl-3">
            Riwayat Kunjungan & Pendaftaran
        </h2>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium rounded-xl flex items-center shadow-sm">
                <span class="mr-2">✨</span> {{ session('success') }}
            </div>
        @endif

        <div class="w-full overflow-x-auto rounded-xl border border-gray-200/70 shadow-sm">
            <table class="w-full border-collapse text-left text-sm m-0 min-w-[1000px]">
                <thead>
                    <tr class="bg-[#004085] text-white font-semibold">
                        <th class="p-4 text-xs uppercase tracking-wider font-bold">Nama Pasien</th>
                        <th class="p-4 text-xs uppercase tracking-wider font-bold">Umur</th>
                        <th class="p-4 text-xs uppercase tracking-wider font-bold max-w-[200px]">Keluhan</th>
                        <th class="p-4 text-xs uppercase tracking-wider font-bold">Spesialis</th>
                        <th class="p-4 text-xs uppercase tracking-wider font-bold">Dokter</th>
                        <th class="p-4 text-xs uppercase tracking-wider font-bold text-center">No Antrian</th>
                        <th class="p-4 text-xs uppercase tracking-wider font-bold">Tanggal Pemeriksaan</th>
                        <th class="p-4 text-xs uppercase tracking-wider font-bold text-center">Hasil</th>
                        <th class="p-4 text-xs uppercase tracking-wider font-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($riwayat as $r)
                    <tr class="hover:bg-gray-50/70 transition-colors duration-150">
                        <td class="p-4 font-bold text-gray-800">{{ $r->nama_pasien }}</td>
                        
                        <td class="p-4 text-gray-600 whitespace-nowrap">{{ $r->umur }} tahun</td>
                        
                        <td class="p-4 text-gray-600 max-w-[200px] break-words">{{ $r->keluhan ?? '-' }}</td>
                        
                        <td class="p-4 text-gray-600 whitespace-nowrap">{{ $r->spesialis }}</td>
                        
                        <td class="p-4 text-gray-700 font-medium whitespace-nowrap">{{ $r->nama_dokter }}</td>
                        
                        {{-- No Antrian --}}
                        <td class="p-4 text-center font-bold text-[#004085] text-base whitespace-nowrap">
                            @if($r->status === 'pengecekan')
                                -
                            @else
                                {{ $r->no_antrian }}
                            @endif
                        </td>
                        
                        {{-- Tanggal Pemeriksaan --}}
                        <td class="p-4 text-gray-500 whitespace-nowrap">
                            @if($r->status === 'pengecekan')
                                -
                            @else
                                {{ $r->tgl_pemeriksaan }}
                            @endif
                        </td>
                        
                        <td class="p-4 text-center whitespace-nowrap">
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-1.5">
                                @if($r->ada_sakit)
                                    <a href="{{ route('pasien.riwayat.sakit', $r->id_daftar) }}" 
                                       class="px-3 py-1 bg-[#004085] hover:bg-[#002752] text-white text-[11px] font-bold rounded-md transition shadow-sm no-underline inline-block">
                                        Surat Sakit
                                    </a>
                                @endif
                                
                                @if($r->ada_rujukan)
                                    <a href="{{ route('pasien.riwayat.rujukan', $r->id_daftar) }}" 
                                       class="px-3 py-1 bg-[#004085] hover:bg-[#002752] text-white text-[11px] font-bold rounded-md transition shadow-sm no-underline inline-block">
                                        Surat Rujukan
                                    </a>
                                @endif

                                @if(!$r->ada_sakit && !$r->ada_rujukan)
                                    <span class="text-xs text-gray-400 italic">Belum ada surat</span>
                                @endif
                            </div>
                        </td>
                        
                        {{-- Status --}}
                        <td class="p-4 text-center whitespace-nowrap">
                            @if($r->status === 'selesai')
                                <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-md text-[11px] font-bold uppercase tracking-wide">
                                    Selesai
                                </span>
                            @elseif($r->status === 'dikonfirmasi')
                                <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 rounded-md text-[11px] font-bold uppercase tracking-wide">
                                    Dikonfirmasi
                                </span>
                            @elseif($r->status === 'pemeriksaan')
                                <span class="px-2.5 py-0.5 bg-purple-50 text-purple-700 border border-purple-100 rounded-md text-[11px] font-bold uppercase tracking-wide">
                                    Pemeriksaan
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-100 rounded-md text-[11px] font-bold uppercase tracking-wide animate-pulse">
                                    Menunggu
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="p-10 text-center text-sm font-medium text-gray-400 italic bg-gray-50/30">
                            Belum ada riwayat pendaftaran berobat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Navigasi Pagination Links (Pusat Tengah) --}}
        <div class="mt-6 flex justify-center w-full overflow-x-auto">
            <div class="py-1 px-2 bg-gray-50 rounded-xl border border-gray-100 inline-block shadow-sm">
                {{ $riwayat->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
