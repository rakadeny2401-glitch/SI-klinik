@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    
    <div class="w-full max-w-5xl mx-auto bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.012)]">
        
        <div class="mb-8 border-b border-gray-100 pb-6 text-center md:text-left">
            <h2 class="text-2xl font-bold text-gray-800 tracking-wide">
                Selamat Datang, <span class="text-[#004085]">{{ session('data.nama_pasien') ?? session('username') }}</span>! 👋
            </h2>
            <p class="text-sm text-gray-500 mt-2 max-w-2xl leading-relaxed">
                Silakan gunakan menu sidebar untuk melakukan pendaftaran berobat atau melihat riwayat pemeriksaan medis Anda secara berkala.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="flex flex-col justify-between bg-[#f4f7fa] border border-gray-200/60 p-6 rounded-xl text-left hover:shadow-md transition-all">
                <div>
                    <h4 class="text-base font-bold text-[#004085] tracking-wide mb-2">
                        Pendaftaran Baru
                    </h4>
                    <p class="text-sm text-gray-600 leading-relaxed mb-6">
                        Ingin melakukan pemeriksaan kesehatan atau kontrol medis hari ini? Isi data keluhan Anda sekarang.
                    </p>
                </div>
                <div>
                    <a href="{{ route('pasien.pendaftaran') }}" 
                       class="inline-block px-5 py-2.5 bg-[#004085] hover:bg-[#002752] text-white text-xs font-bold rounded-lg border-none cursor-pointer tracking-wider shadow-sm transition uppercase no-underline">
                        Isi Form Sekarang
                    </a>
                </div>
            </div>

            <div class="bg-[#f4f7fa] border border-gray-200/60 p-6 rounded-xl text-left hover:shadow-md transition-all">
    <h4 class="text-base font-bold text-[#004085] tracking-wide mb-4">
        Kunjungan Terakhir Anda
    </h4>
    
    @if($pendaftaran_terakhir)
        <div class="space-y-2.5 text-sm">
            <p class="text-gray-700">
                <span class="font-semibold text-gray-500">Tanggal Kontrol:</span> 
                <span class="text-gray-800 font-medium">{{ date('d M Y', strtotime($pendaftaran_terakhir->waktu_daftar)) }}</span>
            </p>
            <p class="text-gray-700 flex items-center gap-2">
                <span class="font-semibold text-gray-500">Status Pasien:</span> 
                
                {{-- Badge Status Dinamis Mengikuti Alur Pemeriksaan (Sudah Diperbaiki) --}}
                @if(trim(strtolower($pendaftaran_terakhir->status_pendaftaran)) == 'selesai' || trim(strtolower($pendaftaran_terakhir->status_pendaftaran)) == 'sudah diperiksa')
                    <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-md text-xs font-bold uppercase tracking-wide">
                        {{ $pendaftaran_terakhir->status_pendaftaran }}
                    </span>
                @else
                    <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-md text-xs font-bold uppercase tracking-wide animate-pulse">
                        {{ $pendaftaran_terakhir->status_pendaftaran }}
                    </span>
                @endif
            </p>
        </div>
    @else
        <div class="flex items-center justify-center py-6">
            <p class="text-sm font-medium text-gray-400 italic">
                Belum ada riwayat pendaftaran berobat sebelumnya.
            </p>
        </div>
    @endif
</div>
        </div>

    </div>
</div>
@endsection