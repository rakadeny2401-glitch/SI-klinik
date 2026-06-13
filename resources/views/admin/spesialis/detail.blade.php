@extends('layout.app')

@section('content')
<div class="w-full min-h-[80vh] flex items-center justify-center font-sans">

    <div class="w-full max-w-xl bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-[0_10px_30px_rgba(0,0,0,0.04)] text-center">
        
        <h2 class="text-xl font-bold text-[#004085] tracking-wide mb-6">
            Detail Spesialis
        </h2>

        <div class="text-left mb-6">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                Nama Spesialis
            </label>
            <div class="w-full p-3 bg-gray-50 text-gray-700 text-sm font-medium rounded-lg border border-gray-200">
                {{ $sp->nama_spesialis }}
            </div>
        </div>

        <h3 class="text-lg font-bold text-[#004085] tracking-wide mb-4">
            Daftar Dokter
        </h3>

        <div class="w-full border border-gray-200 rounded-xl overflow-hidden shadow-sm bg-white mb-4">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-[#004085]">
                        <th class="w-[15%] text-white font-semibold p-3.5 text-xs text-center border-b border-gray-200">No</th>
                        <th class="w-[50%] text-white font-semibold p-3.5 text-xs border-b border-gray-200">Nama Dokter</th>
                        <th class="w-[35%] text-white font-semibold p-3.5 text-xs text-center border-b border-gray-200">Jam Kerja</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @if(count($rows) == 0)
                    <tr>
                        <td colspan="3" class="p-4 text-center text-xs text-gray-400 bg-gray-50/50">
                            Belum ada dokter di spesialis ini.
                        </td>
                    </tr>
                    @else
                        @php $i = ($page - 1) * 5 + 1; @endphp
                        @foreach($rows as $r)
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="p-3.5 text-xs text-gray-500 text-center align-middle">{{ $i++ }}</td>
                            <td class="p-3.5 text-xs text-gray-700 font-medium align-middle">{{ $r->nama_dokter }}</td>
                            <td class="p-3.5 text-xs text-gray-600 text-center align-middle">
                                {{ substr($r->waktu_kerja, 0, 5) }} - {{ substr($r->waktu_pulang, 0, 5) }}
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        @if($totalPage > 1)
        <div class="flex justify-center items-center gap-1 mb-6">
            @for($p = 1; $p <= $totalPage; $p++)
                <a href="?id={{ $id }}&page={{ $p }}" 
                   class="inline-flex items-center justify-center min-w-[28px] h-7 px-2 text-xs font-semibold rounded-md no-underline transition-all duration-150
                          {{ $p == $page 
                             ? 'bg-[#004085] text-white shadow-sm' 
                             : 'bg-white text-gray-500 border border-gray-300 hover:bg-gray-50' }}">
                    {{ $p }}
                </a>
            @endfor
        </div>
        @endif

        <div class="mt-6">
            <a href="/admin/spesialis" class="block w-full text-center py-2.5 px-4 bg-[#e6f0fa] text-[#004085] border border-[#b2cbe5] rounded-xl text-xs font-semibold no-underline transition hover:bg-[#cce2f5] shadow-sm">
                Kembali
            </a>
        </div>

    </div>
</div>
@endsection