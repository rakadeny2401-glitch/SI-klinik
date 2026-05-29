<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $page_title ?? 'Puskesmas' }}</title>

    {{-- Global CSS --}}
    @php
        $global_styles = [
            'layout/layout.css',
            'layout/pagination.css'
        ];
    @endphp

    @foreach ($global_styles as $gcss)
        <link rel="stylesheet" href="{{ asset('style/css/' . $gcss) }}">
    @endforeach

    {{-- Page CSS --}}
    @if (!empty($page_style) && is_array($page_style))
        @foreach ($page_style as $css)
            <link rel="stylesheet" href="{{ asset('style/css/' . $css) }}">
        @endforeach
    @endif

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    @php
        $profile_role = strtolower(session('role') ?? 'unknown');
        $profile_data = session('data') ?? [];

        if ($profile_role === 'admin') {
            $profile_name = $profile_data['nama_admin'] ?? 'Administrator';
        } elseif ($profile_role === 'pasien') {
            $profile_name = $profile_data['nama_pasien'] ?? 'Pasien';
        } elseif ($profile_role === 'dokter') {
            $profile_name = $profile_data['nama_dokter'] ?? 'Dokter';
        } else {
            $profile_name = 'Pengguna';
        }

        $initial = strtoupper(substr(trim($profile_name), 0, 1));
    @endphp

    <div class="app-layout min-h-screen flex">

        {{-- Sidebar --}}
        @include('layout.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 ml-64">

            {{-- Topbar --}}
            <header class="bg-white shadow-sm border-b px-6 py-4 flex justify-between items-center">

                <div class="text-xl font-semibold text-gray-800">
                    Puskesmas Cisaranten Kulon
                </div>

                <div class="relative">

                    <button
                        id="profileBtn"
                        class="w-10 h-10 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center"
                    >
                        {{ $initial }}
                    </button>

                    <div
                        id="profileBadge"
                        class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border z-50"
                    >

                        <div class="p-4 border-b flex items-center gap-3">

                            <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg">
                                {{ $initial }}
                            </div>

                            <div>
                                <div class="font-semibold text-gray-800">
                                    {{ $profile_name }}
                                </div>

                                <div class="text-sm text-gray-500 capitalize">
                                    {{ $profile_role }}
                                </div>
                            </div>
                        </div>

                        <div class="p-3">
                            <a
                                href="{{ url('/logout') }}"
                                class="block w-full text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded-md transition"
                            >
                                Logout
                            </a>
                        </div>

                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main id="app-content" class="p-6">

                <script>
                    const profileBtn = document.getElementById('profileBtn');
                    const profileBadge = document.getElementById('profileBadge');

                    profileBtn.addEventListener('click', () => {
                        profileBadge.classList.toggle('hidden');
                    });

                    document.addEventListener('click', function(e) {
                        if (!profileBtn.contains(e.target) && !profileBadge.contains(e.target)) {
                            profileBadge.classList.add('hidden');
                        }
                    });
                </script>