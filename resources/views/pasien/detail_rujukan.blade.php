@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    
    <div class="max-w-[850px] w-full mx-auto bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.012)]">
        
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 tracking-wide mb-8 text-left border-l-4 border-[#004085] pl-3">
            Surat Rekomendasi Rujukan Pasien
        </h2>

        {{-- KOTAK SURAT DENGAN LEGEND MELAYANG --}}
        <div class="relative border border-gray-200 rounded-xl p-5 pt-8 text-left bg-white shadow-sm">
            
            <span class="absolute -top-3 left-6 bg-white px-2 text-sm font-bold text-[#0b438c] tracking-wide">
                Rekomendasi Dokter
            </span>

            <div class="w-full overflow-x-auto">
                <table class="w-full border-collapse text-sm m-0">
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <th class="py-3.5 pr-4 text-left font-bold text-gray-500 uppercase tracking-wider w-[220px] whitespace-nowrap">Nama Pasien</th>
                            <td class="py-3.5 px-2 text-gray-800 font-semibold">: {{ $data->nama_pasien }}</td>
                        </tr>

                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <th class="py-3.5 pr-4 text-left font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Umur Pasien</th>
                            <td class="py-3.5 px-2 text-gray-700 font-medium">: {{ $data->umur }} tahun</td>
                        </tr>

                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <th class="py-3.5 pr-4 text-left font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Keluhan Awal</th>
                            <td class="py-3.5 px-2 text-gray-700">: {{ $data->keluhan ?? '-' }}</td>
                        </tr>

                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <th class="py-3.5 pr-4 text-left font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap vertical-align-top pt-3.5">Isi Rekomendasi</th>
                            <td class="py-3.5 px-2 text-gray-900 font-medium leading-relaxed italic">: "{{ $data->rekomendasi }}"</td>
                        </tr>

                        <tr class="hover:bg-gray-50/40 transition-colors">
                            <th class="py-3.5 pr-4 text-left font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Dokter Pemeriksa</th>
                            <td class="py-3.5 px-2 text-[#004085] font-bold">: {{ $data->nama_dokter }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tombol Aksi Kembali ke Riwayat --}}
        <div class="mt-6 text-left">
            <a href="{{ route('pasien.riwayat') }}" 
               class="inline-block px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white text-xs font-bold rounded-lg border-none tracking-wide shadow-sm transition-all duration-200 uppercase no-underline">
                Kembali ke Riwayat
            </a>
        </div>

    </div>
</div>
@endsection