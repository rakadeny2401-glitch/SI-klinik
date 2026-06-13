@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">

    <div class="max-w-3xl w-full bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.015)]">
        
        <div class="flex items-center gap-3 mb-6 border-l-4 border-[#004085] pl-3">
            <h2 class="text-xl font-bold text-[#004085] tracking-wide m-0">
                Input Resep Obat
            </h2>
        </div>

        {{-- Alert Notifikasi Error --}}
        @if(session('error'))
            <div class="mb-5 p-3.5 bg-red-50 border border-red-200 text-red-600 rounded-xl text-xs font-medium text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="/dokter/input-resep" method="POST" class="space-y-6 m-0">
            @csrf

            {{-- KARTU 1: Detail Data Pasien (Background Biru Lembut) --}}
            <div class="bg-[#f4f7fa] p-5 rounded-xl border border-blue-50/50">
                <h3 class="text-sm font-bold text-[#004085] tracking-wide mb-3">
                    Data Pasien
                </h3>
                <div class="space-y-1.5 text-sm text-gray-700">
                    <p><span class="font-bold text-gray-800">Nama:</span> {{ $pasien->nama_pasien }}</p>
                    <p><span class="font-bold text-gray-800">Umur:</span> {{ $pasien->umur }} tahun</p>
                    <p><span class="font-bold text-gray-800">Keluhan:</span> {{ $pasien->keluhan ?? '-' }}</p>
                </div>
            </div>

            {{-- KARTU 2: Input Area Resep Obat (Background Biru Lembut) --}}
            <div class="bg-[#f4f7fa] p-5 rounded-xl border border-blue-50/50">
                <h3 class="text-sm font-bold text-[#004085] tracking-wide mb-3">
                    Resep Obat
                </h3>
                <div class="text-left">
                    <label for="jenis_obat" class="block text-xs font-bold text-gray-600 mb-1.5">
                        Jenis Obat
                    </label>
                    <textarea
                        id="jenis_obat"
                        name="jenis_obat"
                        rows="5"
                        class="w-full p-3 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085] focus:ring-1 focus:ring-[#004085] transition-all resize-y placeholder-gray-400"
                        placeholder="Masukkan detail resep dan aturan pakai obat di sini..."
                        required
                    ></textarea>
                </div>
            </div>

            {{-- Hidden Input Data --}}
            <input type="hidden" name="id_daftar" value="{{ $id_daftar }}">
            <input type="hidden" name="id_pasien" value="{{ $pasien->id_pasien }}">

            {{-- Tombol Submit Aksi (Simpan Resep - Biru Puskesmas) --}}
            <div class="pt-2 text-left">
                <button type="submit" 
                        class="px-6 py-2.5 bg-[#004085] hover:bg-[#002752] text-white text-xs font-bold rounded-lg border-none cursor-pointer tracking-wider shadow-sm transition uppercase">
                    Simpan Resep
                </button>
            </div>

        </form>
    </div>

</div>
@endsection