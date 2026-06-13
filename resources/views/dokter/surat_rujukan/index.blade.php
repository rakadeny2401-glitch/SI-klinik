@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    
    <div class="max-w-3xl w-full bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.015)]">
        
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 tracking-wide mb-8">
            Input Surat Rekomendasi Rujukan
        </h2>

        <form method="POST" action="/dokter/surat-rujukan" class="space-y-6 m-0">
            @csrf

            {{-- Data ID Hidden / Kebutuhan Query Backend --}}
            <input type="hidden" name="id_daftar" value="{{ $id_daftar }}">
            <input type="hidden" name="id_pasien" value="{{ $id_pasien }}">
            <input type="hidden" name="id_proses" value="{{ $id_proses }}">

            {{-- Kotak Area Input Ber-Legend (Sesuai Struktur Visual Foto) --}}
            <div class="relative bg-[#f4f7fa] border border-gray-200/60 rounded-xl p-5 pt-7 text-left">
                
                <span class="absolute -top-3 left-4 bg-white px-3 py-0.5 text-xs font-bold text-[#004085] rounded-full border border-gray-100 shadow-sm">
                    Rekomendasi Dokter
                </span>
                
                <label for="rekomendasi" class="block text-xs font-bold text-gray-600 mb-2">
                    Isi Rekomendasi:
                </label>
                
                <textarea
                    id="rekomendasi"
                    name="rekomendasi"
                    rows="5"
                    class="w-full p-3 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085] focus:ring-1 focus:ring-[#004085] transition-all resize-y placeholder-gray-400/80"
                    placeholder="Tulis alasan rujukan serta nama rumah sakit tujuan di sini..."
                    required
                ></textarea>
            </div>

            {{-- Tombol Kirim Form (Simpan Surat Rujukan) --}}
            <div class="text-left">
                <button type="submit" 
                        class="px-5 py-2.5 bg-[#004085] hover:bg-[#002752] text-white text-xs font-bold rounded-lg border-none cursor-pointer tracking-wide shadow-sm transition uppercase">
                    Simpan Surat Rujukan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection