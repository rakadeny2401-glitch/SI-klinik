@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    
    <div class="max-w-3xl w-full bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.015)]">
        
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 tracking-wide mb-8">
            Input Surat Keterangan Sakit
        </h2>

        <form method="POST" action="/dokter/surat-sakit" class="space-y-6 m-0">
            @csrf

            {{-- Hidden Input untuk Data Transaksi Backend --}}
            <input type="hidden" name="id_daftar" value="{{ $id_daftar }}">
            <input type="hidden" name="id_pasien" value="{{ $id_pasien }}">
            <input type="hidden" name="id_proses" value="{{ $id_proses }}">

            {{-- Kotak Area Input Ber-Legend (Background Abu-Biru Lembut) --}}
            <div class="relative bg-[#f4f7fa] border border-gray-200/60 rounded-xl p-5 pt-8 space-y-4 text-left">
                
                <span class="absolute -top-3 left-4 bg-white px-3 py-0.5 text-xs font-bold text-[#004085] rounded-full border border-gray-100 shadow-sm">
                    Keterangan Dokter
                </span>

                {{-- Input Keterangan --}}
                <div class="space-y-1.5">
                    <label for="keterangan" class="block text-xs font-bold text-gray-600">
                        Keterangan:
                    </label>
                    <textarea 
                        id="keterangan" 
                        name="keterangan" 
                        rows="4" 
                        class="w-full p-3 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085] focus:ring-1 focus:ring-[#004085] transition-all resize-y placeholder-gray-400/80" 
                        placeholder="Contoh: Diperlukan istirahat dirumah selama 2 hari" 
                        required></textarea>
                </div>

                {{-- Input Jumlah Hari --}}
                <div class="space-y-1.5">
                    <label for="jml_istirahat" class="block text-xs font-bold text-gray-600">
                        Jumlah Hari Istirahat:
                    </label>
                    <input 
                        type="number" 
                        id="jml_istirahat" 
                        name="jml_istirahat" 
                        class="w-full p-2.5 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085] focus:ring-1 focus:ring-[#004085] transition-all placeholder-gray-400/80" 
                        placeholder="Contoh: 2" 
                        required>
                </div>

                {{-- Input Tanggal Mulai --}}
                <div class="space-y-1.5">
                    <label for="tgl_mulai" class="block text-xs font-bold text-gray-600">
                        Tanggal Mulai:
                    </label>
                    <input 
                        type="date" 
                        id="tgl_mulai" 
                        name="tgl_mulai" 
                        class="w-full p-2.5 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085] focus:ring-1 focus:ring-[#004085] transition-all" 
                        required>
                </div>

                {{-- Input Tanggal Selesai --}}
                <div class="space-y-1.5">
                    <label for="tgl_selesai" class="block text-xs font-bold text-gray-600">
                        Tanggal Selesai:
                    </label>
                    <input 
                        type="date" 
                        id="tgl_selesai" 
                        name="tgl_selesai" 
                        class="w-full p-2.5 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085] focus:ring-1 focus:ring-[#004085] transition-all" 
                        required>
                </div>
            </div>

            {{-- Tombol Kirim Form (Simpan Surat Sakit) --}}
            <div class="text-left">
                <button type="submit" 
                        class="px-5 py-2.5 bg-[#004085] hover:bg-[#002752] text-white text-xs font-bold rounded-lg border-none cursor-pointer tracking-wide shadow-sm transition uppercase">
                    Simpan Surat Sakit
                </button>
            </div>

        </form>
    </div>
</div>
@endsection