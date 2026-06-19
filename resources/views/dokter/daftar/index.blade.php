@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    
    <div class="mb-6 text-center md:text-left">
        <h2 class="text-2xl font-bold text-gray-800 tracking-wide">Daftar Pasien Antrean</h2>
    </div>

    @if(empty($data) || count($data) == 0)
        <div class="w-full max-w-xl mx-auto mt-12 p-8 bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.015)] text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-2.533-3.076l-1.459-.366A4.612 4.612 0 0114 10.334V6.25M9 21h6M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m1.286 1.286a3.5 3.5 0 11-7 0 3.5 3.5 0 017 0z"/>
            </svg>
            <p class="text-sm font-medium text-gray-400">Tidak ada pasien dalam antrean saat ini.</p>
        </div>
    @else
        <div class="w-full bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto w-full">
                <table class="w-full min-w-[700px] border-collapse text-left text-sm m-0">
                    
                    <thead>
                        <tr class="bg-[#004085] text-white font-bold">
                            <th class="p-3.5 pl-6 w-[30%] text-center md:text-left border-r border-[#003366]/30">Nama Pasien</th>
                            <th class="p-3.5 w-[12%] text-center border-r border-[#003366]/30">Umur</th>
                            <th class="p-3.5 w-[43%] border-r border-[#003366]/30">Keluhan</th>
                            <th class="p-3.5 w-[15%] text-center">Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($data as $r)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="p-4 pl-6 font-semibold text-gray-800 border-r border-gray-100">
                                {{ $r->nama_pasien }}
                            </td>
                            
                            <td class="p-4 text-center text-gray-600 border-r border-gray-100">
                                {{ $r->umur }} Tahun
                            </td>
                            
                            <td class="p-4 text-gray-600 line-clamp-2 md:line-clamp-none border-r border-gray-100">
                                {{ $r->keluhan ?? '-' }}
                            </td>
                            
                            <td class="p-4 text-center align-middle">
                                @if($loop->first || $r->status_pendaftaran === 'pemeriksaan')
                                    <form method="POST" action="{{ url('/dokter/periksa') }}" class="m-0 inline-block">
                                        @csrf
                                        <input type="hidden" name="id_daftar" value="{{ $r->id_daftar }}">
                                        <button type="submit" 
                                                class="px-5 py-1.5 bg-[#c82333] hover:bg-[#b21f2d] text-white text-xs font-bold rounded-lg border-none cursor-pointer tracking-wide shadow-sm transition">
                                            Periksa
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-500 font-semibold">Antrian {{ $loop->iteration }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
