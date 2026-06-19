@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen flex items-start justify-center relative">

    {{-- TOAST BANNER BERHASIL --}}
    @if(session('success'))
        <div class="absolute top-4 left-1/2 -translate-x-1/2 bg-[#0b438c] text-white px-6 py-2.5 rounded-lg text-sm font-medium shadow-md tracking-wide z-[9999] transition-all animate-bounce">
            {{ session('success') }}
        </div>
    @endif

    {{-- TOAST BANNER ERROR --}}
    @if(session('error'))
        <div class="absolute top-4 left-1/2 -translate-x-1/2 bg-[#dc3545] text-white px-6 py-2.5 rounded-lg text-sm font-medium shadow-md tracking-wide z-[9999] transition-all animate-bounce">
            {{ session('error') }}
        </div>
    @endif

    <div class="w-full max-w-2xl bg-white rounded-2xl border border-gray-100 p-8 md:p-12 shadow-[0_4px_25px_rgba(0,0,0,0.015)] text-center mt-12">
        
        <h2 class="text-xl md:text-2xl font-bold text-[#004085] tracking-wide mb-8">
            Apakah perlu membuat surat tambahan?
        </h2>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full">

            {{-- TOMBOL SURAT RUJUKAN --}}
            @if(!$rujukanSudahAda)
                <form action="/dokter/surat-rujukan" method="GET" class="w-full sm:w-auto m-0">
                    <input type="hidden" name="id_daftar" value="{{ $id_daftar }}">
                    <input type="hidden" name="id_pasien" value="{{ $id_pasien }}">
                    <button type="submit" 
                            class="w-full sm:w-auto px-5 py-2.5 bg-[#004085] hover:bg-[#002752] text-white text-xs font-bold rounded-lg border-none cursor-pointer tracking-wide shadow-sm transition-all whitespace-nowrap">
                        Surat Rekomendasi Rujukan
                    </button>
                </form>
            @endif

            {{-- TOMBOL SURAT SAKIT --}}
            <form action="/dokter/surat-sakit" method="GET" class="w-full sm:w-auto m-0">
                <input type="hidden" name="id_daftar" value="{{ $id_daftar }}">
                <input type="hidden" name="id_pasien" value="{{ $id_pasien }}">
                <button type="submit" 
                        class="w-full sm:w-auto px-5 py-2.5 bg-[#198754] hover:bg-[#146c43] text-white text-xs font-bold rounded-lg border-none cursor-pointer tracking-wide shadow-sm transition-all whitespace-nowrap">
                    Surat Keterangan Sakit
                </button>
            </form>

            {{-- TOMBOL KELUAR --}}
            @if($rujukanSudahAda || $suratSakitSudahAda)
                <a href="{{ url('/dokter/daftar-pasien') }}" 
                   class="w-full sm:w-auto text-center px-5 py-2.5 bg-[#6c757d] hover:bg-[#5c636a] text-white text-xs font-bold rounded-lg border-none cursor-pointer tracking-wide shadow-sm transition-all no-underline inline-block whitespace-nowrap">
                    Keluar
                </a>
            @else
                <form method="POST" action="#" class="w-full sm:w-auto m-0">
                    @csrf
                    <button type="button" onclick="alert('Surat sakit wajib diinput sebelum keluar')" 
                            class="w-full sm:w-auto text-center px-5 py-2.5 bg-gray-400 text-white text-xs font-bold rounded-lg border-none cursor-not-allowed tracking-wide shadow-sm inline-block whitespace-nowrap">
                        Keluar
                    </button>
                </form>
            @endif

        </div>

    </div>
</div>
@endsection
