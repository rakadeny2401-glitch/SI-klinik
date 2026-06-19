@extends('layout.app')

@section('content')

<div class="flex justify-center items-center px-5 py-10 bg-[#f4f6f9] min-h-[calc(100vh-100px)] box-border font-sans">
    
    <div class="bg-white w-full max-w-[500px] p-7.5 rounded-lg shadow-none">

        {{-- Notifikasi --}}
        @if(request('status') == 'deleted')
            <div class="bg-green-50 text-green-700 p-3.5 rounded-lg mb-5 text-sm font-medium border border-green-200">
                Pengguna berhasil dihapus
            </div>
        @endif

        @if(request('status') == 'error')
            <div class="bg-red-50 text-red-700 p-3.5 rounded-lg mb-5 text-sm font-medium border border-red-200">
                Pengguna tidak ditemukan
            </div>
        @endif
        
        <h2 class="text-center text-2xl font-bold text-[#004085] mt-0 mb-6.25">
            Detail Pengguna ({{ ucfirst($user->role) }})
        </h2>

        <div class="mb-3.75">
            <label class="block text-xs font-bold text-[#333333] mb-1.5">Nama</label>
            <input type="text" value="{{ $user->name }}" readonly class="w-full px-3.5 py-2.5 border border-[#e2e8f0] bg-[#f8fafc] text-[#4a5568] rounded-md text-sm">
        </div>

        <div class="mb-3.75">
            <label class="block text-xs font-bold text-[#333333] mb-1.5">No HP</label>
            <input type="text" value="{{ $user->no_hp }}" readonly class="w-full px-3.5 py-2.5 border border-[#e2e8f0] bg-[#f8fafc] text-[#4a5568] rounded-md text-sm">
        </div>

        @if(isset($user->alamat))
        <div class="mb-3.75">
            <label class="block text-xs font-bold text-[#333333] mb-1.5">Alamat {{ ucfirst($user->role) }}</label>
            <input type="text" value="{{ $user->alamat }}" readonly class="w-full px-3.5 py-2.5 border border-[#e2e8f0] bg-[#f8fafc] text-[#4a5568] rounded-md text-sm">
        </div>
        @endif

        @if($user->role === 'dokter' && isset($user->tgl_lahir_dokter))
        <div class="mb-3.75">
            <label class="block text-xs font-bold text-[#333333] mb-1.5">Tgl Lahir Dokter</label>
            <input type="text" value="{{ $user->tgl_lahir_dokter }}" readonly class="w-full px-3.5 py-2.5 border border-[#e2e8f0] bg-[#f8fafc] text-[#4a5568] rounded-md text-sm">
        </div>
        @endif

        @if($user->role === 'dokter' && isset($user->waktu_kerja))
        <div class="mb-3.75">
            <label class="block text-xs font-bold text-[#333333] mb-1.5">Waktu Kerja</label>
            <input type="text" value="{{ $user->waktu_kerja }}" readonly class="w-full px-3.5 py-2.5 border border-[#e2e8f0] bg-[#f8fafc] text-[#4a5568] rounded-md text-sm">
        </div>
        <div class="mb-3.75">
            <label class="block text-xs font-bold text-[#333333] mb-1.5">Waktu Pulang</label>
            <input type="text" value="{{ $user->waktu_pulang }}" readonly class="w-full px-3.5 py-2.5 border border-[#e2e8f0] bg-[#f8fafc] text-[#4a5568] rounded-md text-sm">
        </div>
        @elseif($user->role === 'admin' && isset($user->waktu_jaga))
        <div class="mb-3.75">
            <label class="block text-xs font-bold text-[#333333] mb-1.5">Waktu Jaga</label>
            <input type="text" value="{{ $user->waktu_jaga }}" readonly class="w-full px-3.5 py-2.5 border border-[#e2e8f0] bg-[#f8fafc] text-[#4a5568] rounded-md text-sm">
        </div>
        @endif

        <div class="mb-3.75">
            <label class="block text-xs font-bold text-[#333333] mb-1.5">No Identitas</label>
            <input type="text" value="{{ $user->no_identitas }}" readonly class="w-full px-3.5 py-2.5 border border-[#e2e8f0] bg-[#f8fafc] text-[#4a5568] rounded-md text-sm">
        </div>

        <div class="mb-3.75">
            <label class="block text-xs font-bold text-[#333333] mb-1.5">Peran</label>
            <input type="text" value="{{ $user->role }}" readonly class="w-full px-3.5 py-2.5 border border-[#e2e8f0] bg-[#f8fafc] text-[#4a5568] rounded-md text-sm">
        </div>

        @if($user->role === 'dokter' && isset($user->nama_spesialis))
        <div class="mb-3.75">
            <label class="block text-xs font-bold text-[#333333] mb-1.5">Spesialis</label>
            <input type="text" value="{{ $user->nama_spesialis }}" readonly class="w-full px-3.5 py-2.5 border border-[#e2e8f0] bg-[#f8fafc] text-[#4a5568] rounded-md text-sm">
        </div>
        @endif

        <div class="grid grid-cols-2 gap-3 mt-6.25 mb-3">
            <a href="/admin/pengguna/edit/{{ $user->role }}/{{ $user->id }}" 
               class="bg-[#004085] text-white p-[11px] rounded-md text-sm font-semibold text-center no-underline transition-colors duration-200 hover:bg-[#002752]">
                Edit
            </a>
            
            <form action="/admin/pengguna/hapus/{{ $user->role }}/{{ $user->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full bg-[#e3342f] text-white p-[11px] rounded-md text-sm font-semibold text-center cursor-pointer transition-colors duration-200 hover:bg-[#cc1f1a]">
                    Hapus
                </button>
            </form>
        </div>

        <a href="/admin/pengguna" 
           class="block w-full bg-[#e2e8f0] text-[#34155] border border-[#cbd5e1] p-[11px] rounded-md text-sm font-semibold text-center no-underline transition-all duration-200 hover:bg-[#cbd5e1] hover:text-[#1e293b]">
            Kembali
        </a>
    </div>
</div>

@endsection
