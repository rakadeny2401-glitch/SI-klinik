@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    
    <div class="max-w-[950px] w-full mx-auto bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.012)]">
        
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 tracking-wide mb-8 text-left">
            Form Pendaftaran
        </h2>

        <form action="{{ route('pasien.pendaftaran.simpan') }}" method="POST" class="space-y-8 m-0">
            @csrf

            {{-- 1. KOTAK DATA PASIEN (EFEK LEGEND MELAYANG ATAS) --}}
            <div class="relative border border-gray-200 rounded-xl p-6 pt-8 space-y-4 text-left">
                
                <span class="absolute -top-3 left-6 bg-white px-2 text-sm font-bold text-[#0b438c] tracking-wide">
                    Data Pasien
                </span>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">Nama Pasien</label>
                    <input type="text" value="{{ session('data.nama_pasien') ?? session('username') }}" readonly 
                           class="w-full p-2 bg-gray-50 text-gray-500 text-sm rounded-lg border border-gray-200 cursor-not-allowed outline-none">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">NIK</label>
                    <input type="text" value="{{ session('data.nik') ?? '-' }}" readonly 
                           class="w-full p-2 bg-gray-50 text-gray-500 text-sm rounded-lg border border-gray-200 cursor-not-allowed outline-none">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">Alamat</label>
                    <textarea readonly rows="2" 
                              class="w-full p-2 bg-gray-50 text-gray-500 text-sm rounded-lg border border-gray-200 cursor-not-allowed outline-none resize-none">{{ session('data.alamat_pasien') ?? '-' }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700">Jenis Kelamin</label>
                        <input type="text" value="{{ (session('data.jenis_kelamin') == 'L') ? 'Laki-laki' : 'Perempuan' }}" readonly 
                               class="w-full p-2 bg-gray-50 text-gray-500 text-sm rounded-lg border border-gray-200 cursor-not-allowed outline-none">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700">Umur</label>
                        <input type="text" value="{{ session('data.umur') ?? '-' }}" readonly 
                               class="w-full p-2 bg-gray-50 text-gray-500 text-sm rounded-lg border border-gray-200 cursor-not-allowed outline-none">
                    </div>
                </div>
            </div>

            {{-- 2. KOTAK DATA PENDAFTARAN (EFEK LEGEND MELAYANG ATAS) --}}
            <div class="relative border border-gray-200 rounded-xl p-6 pt-8 space-y-4 text-left">
                
                <span class="absolute -top-3 left-6 bg-white px-2 text-sm font-bold text-[#0b438c] tracking-wide">
                    Data Pendaftaran
                </span>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">Waktu Pendaftaran</label>
                    <input type="datetime-local" name="waktu_daftar" required value="{{ date('Y-m-d\TH:i') }}" 
                           class="w-full p-2 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085] transition-all">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">Spesialis</label>
                    <select name="id_spesialis" id="spesialis-select" required 
                            class="w-full p-2 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085] transition-all cursor-pointer">
                        <option value="" disabled selected>-- Pilih Spesialis --</option>
                        @foreach($spesialis as $s)
                            <option value="{{ $s->id_spesialis }}">{{ $s->nama_spesialis }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">Dokter Terpilih</label>
                    <select name="id_dokter" id="dokter-select" required 
                            class="w-full p-2 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085] transition-all cursor-pointer">
                        <option value="" disabled selected>-- Pilih Dokter --</option>
                        @foreach($dokter as $d)
                            <option value="{{ $d->id_dokter }}" data-spesialis="{{ $d->id_spesialis }}">{{ $d->nama_dokter }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">Keluhan</label>
                    <textarea name="keluhan" rows="4" required 
                              class="w-full p-2 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085] transition-all resize-y"></textarea>
                </div>
            </div>

            {{-- Tombol Simpan Moderen Puskesmas --}}
            <div class="text-left">
                <button type="submit" 
                        class="px-5 py-2.5 bg-[#004085] hover:bg-[#002752] text-white text-sm font-semibold rounded-lg border-none cursor-pointer tracking-wide shadow-sm transition-all duration-200">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

{{-- JavaScript Filter Dinamis --}}
<script>
    document.getElementById('spesialis-select').addEventListener('change', function() {
        var idSpesialisTerpilih = this.value;
        var dokterSelect = document.getElementById('dokter-select');
        var opsiDokter = dokterSelect.querySelectorAll('option');

        dokterSelect.value = "";

        opsiDokter.forEach(function(opsi) {
            if (opsi.value === "") return;
            
            var idSpesialisDokter = opsi.getAttribute('data-spesialis');
            if (idSpesialisDokter === idSpesialisTerpilih) {
                opsi.style.display = "block";
            } else {
                opsi.style.display = "none";
            }
        });
    });
</script>
@endsection