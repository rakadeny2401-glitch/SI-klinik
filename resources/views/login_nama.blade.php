@extends('layout.auth')

@section('content')
<div class="min-h-screen w-full flex items-center justify-center bg-[#f0f4f8] p-4 font-sans">
    
    <div class="w-full max-w-sm bg-white p-8 rounded-2xl border border-gray-100 shadow-[0_10px_35px_rgba(0,0,0,0.03)]">
        
        <h2 class="text-xl font-bold text-[#004085] text-center tracking-wide mb-6">
            Login
        </h2>

        @if(session('error'))
            <p class="text-xs text-red-600 bg-red-50 border border-red-200 rounded-lg p-3 text-center font-medium mb-4">
                {{ session('error') }}
            </p>
        @endif

        <form method="POST" action="/login-nama" class="space-y-4 m-0">
            @csrf

            <div class="text-left">
                <label class="block text-xs font-bold text-gray-700 mb-1.5">
                    Nama:
                </label>
                <input
                    type="text"
                    name="nama"
                    class="w-full p-2.5 bg-white text-gray-800 text-sm rounded-lg border border-gray-300 focus:outline-none focus:border-[#004085] focus:ring-1 focus:ring-[#004085] transition-all"
                    required>
            </div>

            <div class="text-left">
                <label class="block text-xs font-bold text-gray-700 mb-1.5">
                    PIN:
                </label>
                <input
                    type="password"
                    name="password"
                    class="w-full p-2.5 bg-white text-gray-800 text-sm rounded-lg border border-gray-300 focus:outline-none focus:border-[#004085] focus:ring-1 focus:ring-[#004085] transition-all"
                    required>
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full py-2.5 bg-[#004085] text-white border-none rounded-lg text-xs font-bold tracking-wider cursor-pointer transition hover:bg-[#002752] shadow-sm uppercase">
                    LOGIN
                </button>
            </div>

            <div>
                <button
                    type="button"
                    class="w-full py-2.5 bg-[#e6f0fa] text-[#004085] border border-[#b2cbe5] rounded-lg text-xs font-semibold cursor-pointer transition hover:bg-[#cce2f5]"
                    onclick="location.href='/'">
                    Kembali ke Login No Identitas
                </button>
            </div>

        </form>

    </div>
</div>
@endsection