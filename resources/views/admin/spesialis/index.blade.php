@extends('layout.app')

{{-- Hapus push styles lama karena sekarang full pakai Tailwind --}}

@section('content')
<div class="w-full font-sans">
    
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Daftar Spesialis
    </h2>

    @if(request('status') == 'deleted')
        <div class="bg-green-50 text-green-700 p-3.5 rounded-lg mb-5 text-sm font-medium border border-green-200">
            Berhasil dihapus
        </div>
    @endif

    @if(request('status') == 'blocked')
        <div class="bg-red-50 text-red-700 p-3.5 rounded-lg mb-5 text-sm font-medium border border-red-200">
            Tidak bisa dihapus, masih ada dokter
        </div>
    @endif

    <div class="mb-5">
        <a href="/admin/spesialis/create" class="inline-flex items-center gap-1.5 py-2.5 px-4.5 bg-[#004085] text-white no-underline rounded-lg text-sm font-semibold transition duration-150 hover:bg-[#002752] shadow-sm">
            + Tambah Spesialis
        </a>
    </div>

    <div class="w-full bg-white rounded-xl border border-gray-200 shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
        
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-[#004085]">
                    <th class="w-[10%] text-white font-semibold p-4 text-sm border-b border-gray-200">No</th>
                    <th class="w-[65%] text-white font-semibold p-4 text-sm border-b border-gray-200">Nama Spesialis</th>
                    <th class="w-[25%] text-white font-semibold p-4 text-sm border-b border-gray-200">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @php $i = ($page - 1) * 5 + 1; @endphp

                @foreach($rows as $r)
                <tr class="hover:bg-gray-50/70 transition-colors duration-150">
                    <td class="p-4 text-sm text-gray-600 align-middle">{{ $i++ }}</td>
                    <td class="p-4 text-sm text-gray-700 font-medium align-middle">{{ $r->nama_spesialis }}</td>
                    <td class="p-4 align-middle">
                        <div class="flex items-center gap-2">
                            <a href="/admin/spesialis/{{ $r->id_spesialis }}" 
                               class="inline-flex items-center justify-center py-1.5 px-4 bg-[#17a2b8] text-white rounded text-xs font-medium no-underline transition hover:opacity-90 shadow-sm">
                                Detail
                            </a>

                            <form method="POST" action="/admin/spesialis/delete" class="inline m-0">
                                @csrf
                                <input type="hidden" name="id_spesialis" value="{{ $r->id_spesialis }}">
                                <button type="submit" 
                                        class="inline-flex items-center justify-center py-1.5 px-4 bg-[#dc3545] text-white border-none rounded text-xs font-medium cursor-pointer transition hover:opacity-90 shadow-sm"
                                        onclick="return confirm('Hapus data?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="flex justify-center items-center gap-1.5 mt-6">
        @for($p = 1; $p <= $totalPage; $p++)
            <a href="?page={{ $p }}" 
               class="inline-flex items-center justify-center min-w-[32px] h-8 px-2.5 text-xs font-semibold rounded-lg no-underline transition-all duration-150
                      {{ $p == $page 
                         ? 'bg-[#004085] text-white shadow-sm' 
                         : 'bg-white text-gray-600 border border-gray-300 hover:bg-gray-50 hover:border-gray-400' }}">
                {{ $p }}
            </a>
        @endfor
    </div>

</div>
@endsection