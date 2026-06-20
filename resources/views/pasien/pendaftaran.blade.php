@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    <div class="max-w-[950px] w-full mx-auto bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.012)]">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 tracking-wide mb-8 text-left">
            Form Pendaftaran
        </h2>

        <form action="{{ route('pasien.pendaftaran.simpan') }}" method="POST" class="space-y-8 m-0">
            @csrf

            {{-- 1. Data Pasien --}}
            <div class="relative border border-gray-200 rounded-xl p-6 pt-8 space-y-4 text-left">
                <span class="absolute -top-3 left-6 bg-white px-2 text-sm font-bold text-[#0b438c] tracking-wide">Data Pasien</span>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">Nama Pasien</label>
                    <input type="text" value="{{ session('data.nama_pasien') ?? session('username') }}" readonly 
                           class="w-full p-2 bg-gray-50 text-gray-500 text-sm rounded-lg border border-gray-200 cursor-not-allowed outline-none">
                </div>
                </div>

            {{-- 2. Data Pendaftaran --}}
            <div class="relative border border-gray-200 rounded-xl p-6 pt-8 space-y-4 text-left">
                <span class="absolute -top-3 left-6 bg-white px-2 text-sm font-bold text-[#0b438c] tracking-wide">Data Pendaftaran</span>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">Waktu Pendaftaran</label>
                    <input type="datetime-local" name="waktu_daftar" id="waktu_daftar" required value="{{ date('Y-m-d\TH:i') }}" 
                           class="w-full p-2 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085]">
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">Spesialis</label>
                    <select name="id_spesialis" id="spesialis-select" required 
                            class="w-full p-2 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085]">
                        <option value="" disabled selected>-- Pilih Spesialis --</option>
                        @foreach($spesialis as $s)
                            <option value="{{ $s->id_spesialis }}">{{ $s->nama_spesialis }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1.5">
    <label class="text-sm font-semibold text-[#4b5563]">Dokter Terpilih</label>
    
    <select name="id_dokter" id="dokter-select" required 
            class="w-full p-3 border border-[#d1d5db] text-sm rounded-lg">
        <option value="" disabled selected>-- Pilih Dokter Tersedia --</option>
    </select>
    
    <small id="dokter_status" class="block mt-1.5 text-[13px]"></small>
</div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700">Keluhan</label>
                    <textarea name="keluhan" rows="4" required class="w-full p-2 bg-white text-gray-800 text-sm rounded-lg border border-gray-200 focus:outline-none focus:border-[#004085]"></textarea>
                </div>
            </div>

            <button type="submit" class="px-5 py-2.5 bg-[#004085] hover:bg-[#002752] text-white text-sm font-semibold rounded-lg">Simpan</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dokterData = @json($dokter);
        const spSelect = document.getElementById('spesialis-select');
        const waktuInput = document.getElementById('waktu_daftar');
        const dokterSelect = document.getElementById('dokter-select');
        const dokterStatus = document.getElementById('dokter_status');

        function checkDokter() {
            let jam = waktuInput.value;
            let idSpesialis = spSelect.value;

            // Reset dropdown
            dokterSelect.innerHTML = '<option value="" disabled selected>-- Pilih Dokter Tersedia --</option>';
            
            if (!jam || !idSpesialis) return;

            let timePart = jam.split('T')[1];

            // Filter semua dokter yang cocok
            let tersedia = dokterData.filter(d => {
                let start = (d.waktu_kerja || '').substring(0, 5);
                let end = (d.waktu_pulang || '').substring(0, 5);
                return String(d.id_spesialis) === String(idSpesialis) && 
                       timePart >= start && timePart <= end;
            });

            if (tersedia.length > 0) {
                // Masukkan dokter yang cocok ke dalam <select>
                tersedia.forEach(dokter => {
                    let option = document.createElement('option');
                    option.value = dokter.id_dokter;
                    option.textContent = dokter.nama_dokter;
                    dokterSelect.appendChild(option);
                });
                dokterStatus.innerText = tersedia.length + ' dokter ditemukan.';
                dokterStatus.style.color = 'green';
            } else {
                dokterStatus.innerText = 'Tidak ada dokter yang bertugas pada jam tersebut';
                dokterStatus.style.color = 'red';
            }
        }

        spSelect.addEventListener('change', checkDokter);
        waktuInput.addEventListener('change', checkDokter);
    });
</script>
@endsection