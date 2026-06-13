@extends('layout.app')

@section('content')
<div class="w-full p-6 md:p-8 font-sans bg-gray-50/30 min-h-screen">
    
    <div class="max-w-[500px] w-full mx-auto bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.012)]">
        
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 tracking-wide mb-6 text-left border-l-4 border-[#004085] pl-3">
            Tambah Spesialis
        </h2>

        {{-- Notifikasi Error --}}
        @if(session('error'))
            <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 text-sm font-medium rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/admin/spesialis/store" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Spesialis</label>
                <input type="text" name="nama_spesialis" required 
                       class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#004085] focus:ring-1 focus:ring-[#004085] transition-all outline-none text-gray-700 placeholder:text-gray-300"
                       placeholder="Contoh: Spesialis Anak">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" 
                        class="px-6 py-2.5 bg-[#004085] hover:bg-[#002752] text-white text-sm font-bold rounded-lg shadow-sm transition-all duration-200">
                    Simpan Data
                </button>
                <a href="/admin/spesialis" 
                   class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-lg transition-all duration-200 no-underline">
                    Kembali
                </a>
            </div>
        </form>

    </div>
</div>
@endsection