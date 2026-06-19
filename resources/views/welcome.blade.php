
@extends('layout.auth')

@section('content')
<div class="min-h-screen w-screen flex items-center justify-center bg-[#f0f4f8] font-sans px-4">

    <div class="bg-white w-full max-w-[400px] p-8 rounded-2xl shadow-[0_4px_25px_rgba(0,0,0,0.05)] border border-[#e2e8f0]">
        
        <h2 class="text-2xl font-bold text-[#004085] text-center mb-6 tracking-wide">Login</h2>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 text-xs font-medium p-3 rounded-lg mb-4 border border-red-200 text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-5">
            @csrf

            <div class="flex flex-col gap-1.5">
                <label class="text-[11px] font-bold text-gray-700 tracking-tight">
                    No Identitas (16 digit):
                </label>
                <input
                    type="text"
                    name="no_identitas"
                    maxlength="16"
                    required
                    placeholder="Masukkan 16 digit angka..."
                    class="w-full py-2 px-3 border border-[#cbd5e1] rounded-lg text-sm bg-white outline-none focus:border-[#004085] focus:ring-1 focus:ring-[#004085] transition placeholder-gray-300 text-gray-800">
            </div>

            <button type="submit" class="w-full bg-[#004085] text-white py-2.5 px-4 rounded-lg text-xs font-bold tracking-wider hover:bg-[#002d5e] transition duration-150 shadow-sm cursor-pointer">
                LOGIN
            </button>

            <button
                type="button"
                class="w-full bg-[#e6f0fa] text-[#004085] border border-[#b2cbe5] py-2.5 px-4 rounded-lg text-xs font-semibold hover:bg-[#d6e7f7] transition duration-150 cursor-pointer"
                onclick="location.href='/login-nama'">
                Login dengan Cara Lain
            </button>

        </form>

    </div>
</div>
@endsection
