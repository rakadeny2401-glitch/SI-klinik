<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page_title ?? 'Puskesmas' }}</title>

    {{-- GLOBAL CSS --}}
    @vite([
        'resources/css/app.css',
        
    ])

    {{-- PAGE CSS --}}
    @if(!empty($page_style))
        @foreach($page_style as $css)
            <link rel="stylesheet" href="/style/css/{{ $css }}">
        @endforeach
    @endif

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    {{-- Inline style pelengkap untuk menghidupkan animasi toggle dropdown profile --}}
    <style>
        .profile-badge { display: none; }
        .profile-badge.active { display: block; }
    </style>
</head>

<body class="bg-[#f8f9fa] m-0 p-0 min-h-screen flex flex-col font-sans antialiased">

    <header class="w-full h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0 sticky top-0 z-50">
        <div class="font-bold text-[#004085] text-lg tracking-wide">
            Puskesmas Cisaranten Kulon
        </div>

        @php
            $role = session('role', 'unknown');
            $data = session('data', []);

            $profile_name = match($role) {
                'admin' => $data['nama_admin'] ?? 'Administrator',
                'pasien' => $data['nama_pasien'] ?? 'Pasien',
                'dokter' => $data['nama_dokter'] ?? 'Dokter',
                default => 'Pengguna'
            };

            $initial = strtoupper(substr(trim($profile_name), 0, 1));
        @endphp

        <div class="relative">
            <button id="profileBtn" class="w-9 h-9 rounded-full bg-[#e6f0fa] text-[#004085] font-bold text-sm border border-[#b2cbe5] flex items-center justify-center cursor-pointer transition hover:bg-[#cce2f5] focus:outline-none">
                {{ $initial }}
            </button>

            <div id="profileBadge" class="profile-badge absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden">
                <div class="flex items-center gap-3 p-4 border-b border-gray-100 bg-gray-50">
                    <div class="w-10 h-10 rounded-full bg-[#004085] text-white font-bold flex items-center justify-center text-sm shrink-0">
                        {{ $initial }}
                    </div>
                    <div class="truncate">
                        <div class="font-bold text-gray-800 text-sm truncate">{{ $profile_name }}</div>
                        <div class="text-xs text-gray-400 capitalize">{{ $role }}</div>
                    </div>
                </div>
                <div class="p-2">
                    <a class="flex items-center w-full px-4 py-2 text-sm text-red-600 font-medium hover:bg-red-50 rounded-lg no-underline transition" href="/logout">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="flex flex-1 w-full min-h-0">
        
        {{-- SIDEBAR KIRI --}}
        @include('layout.sidebar')

        {{-- AREA KONTEN UTAMA KANAN --}}
        <main id="app-content" class="flex-1 overflow-y-auto bg-white p-6 md:p-8">
            <div class="w-full max-w-[1400px] mx-auto">
                @yield('content')
            </div>
        </main>

    </div>

    {{-- TOAST ALERTS --}}
    <div id="localhost-toast" class="fixed left-1/2 -translate-x-1/2 -top-32 z-[9999] transition-all duration-300">
        <div class="bg-[#004085] text-white py-2.5 px-4 rounded-lg shadow-lg text-sm font-medium">
            <span id="localhost-toast-msg"></span>
        </div>
    </div>

    <script>
        // Profile Badge Toggle
        document.getElementById('profileBtn').addEventListener('click', function(e) {
            e.stopPropagation();
            const badge = document.getElementById('profileBadge');
            badge.classList.toggle('active');
        });

        // Close profile badge when clicking outside
        document.addEventListener('click', function() {
            const badge = document.getElementById('profileBadge');
            if(badge) badge.classList.remove('active');
        });

        // Profile badge click shouldn't close itself
        document.getElementById('profileBadge').addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>

</body>
</html>