@php
<<<<<<< HEAD
    $role = session('role');
@endphp

<aside class="w-64 min-h-screen bg-[#f8f9fa] border-r border-[#e5e7eb] py-4 font-sans shrink-0">
    <nav class="px-3">
        <ul class="space-y-1">
            
            {{-- MENU DASHBOARD DINAMIS SESUAI ROLE --}}
            <li>
                @if($role === 'admin')
                    <a href="/admin/dashboard" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('admin/dashboard') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                @elseif($role === 'dokter')
                    <a href="/dokter/dashboard" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('dokter/dashboard') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                @elseif($role === 'pasien')
                    <a href="/pasien/dashboard" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('pasien/dashboard') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                @else
                    <a href="/" class="flex items-center px-4 py-2.5 text-[14px] font-medium text-gray-600 hover:bg-gray-100 rounded-lg">Dashboard</a>
                @endif
            </li>

            {{-- MENU KHUSUS ADMIN --}}
            @if($role === 'admin')
                <li>
                    <a href="/admin/pengguna" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('admin/pengguna*') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Lihat Pengguna
                    </a>
                </li>

                <li>
                    <a href="/admin/spesialis" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('admin/spesialis*') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Spesialis
                    </a>
                </li>

                <li>
                    <a href="/admin/pendaftaran" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('admin/pendaftaran') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Pendaftaran
                    </a>
                </li>

                <li>
                    <a href="/admin/pendaftaran/lihat" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('admin/pendaftaran/lihat*') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Lihat Pendaftaran
                    </a>
                </li>

            {{-- MENU KHUSUS PASIEN --}}
            @elseif($role === 'pasien')
                <li>
                    <a href="/pasien/pendaftaran" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('pasien/pendaftaran*') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Form Pendaftaran
                    </a>
                </li>

                <li>
                    <a href="/pasien/riwayat" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('pasien/riwayat*') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Riwayat
                    </a>
                </li>

            {{-- MENU KHUSUS DOKTER --}}
            @elseif($role === 'dokter')
                <li>
                    <a href="/dokter/daftar-pasien" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('dokter/daftar-pasien*') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Daftar Pasien
                    </a>
                </li>

                <li>
                    <a href="/dokter/riwayat" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('dokter/riwayat*') ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Riwayat Periksa
                    </a>
                </li>
            @endif

        </ul>
    </nav>
=======
    $currentPage = request()->path();
    $role = strtolower(session('role') ?? '');
    $force = $force_active_menu ?? null;

    if (!function_exists('is_active')) {
    function is_active($pattern, $currentPage, $force = null)
    {
        if ($force !== null && $force === $pattern) {
            return 'bg-blue-50 text-blue-600';
        }

        return request()->is($pattern)
            ? 'bg-blue-50 text-blue-600'
            : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900';
        }
}
    
@endphp

<aside id="app-sidebar" class="fixed left-0 top-0 h-screen w-64 bg-white border-r shadow-md z-40">
    <div class="h-full flex flex-col">

        <div class="p-4 border-b">
            <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-800">
                SI Klinik
            </a>
        </div>

        <nav class="flex-1 overflow-auto p-4">
            <ul class="space-y-1">

                {{-- Dashboard --}}
                <li>
                    <a
                        class="block px-3 py-2 rounded-md flex items-center {{ is_active($role . '/dashboard*', $currentPage, $force) }}"
                        href="{{ url($role . '/dashboard') }}"
                    >
                        <span class="ml-2">Dashboard</span>
                    </a>
                </li>

                {{-- ADMIN --}}
                @if ($role === 'admin')

                    <li>
                        <a
                            class="block px-3 py-2 rounded-md flex items-center {{ is_active('admin/lihat_pengguna*', $currentPage, $force) }}"
                            href="{{ url('admin/pengguna') }}"
                        >
                            <span class="ml-2">Lihat Pengguna</span>
                        </a>
                    </li>

                    <li>
                        <a
                            class="block px-3 py-2 rounded-md flex items-center {{ is_active('admin/spesialis*', $currentPage, $force) }}"
                            href="{{ url('admin/spesialis') }}"
                        >
                            <span class="ml-2">Spesialis</span>
                        </a>
                    </li>

                    <li>
    <a
        class="block px-3 py-2 rounded-md flex items-center {{ is_active('admin/pendaftaran/tambah*', $currentPage, $force) }}"
        href="{{ url('admin/pendaftaran/tambah') }}"
    >
        <span class="ml-2">Pendaftaran</span>
    </a>
</li>

                    <li>
    <a
        class="block px-3 py-2 rounded-md flex items-center {{ is_active('admin/pendaftaran', $currentPage, $force) }}"
        href="{{ url('admin/pendaftaran') }}"
    >
        <span class="ml-2">Lihat Pendaftaran</span>
    </a>
</li>

                {{-- PASIEN --}}
                @elseif ($role === 'pasien')

                    <li>
                        <a
                            class="block px-3 py-2 rounded-md flex items-center {{ is_active('pasien/pendaftaran_form*', $currentPage, $force) }}"
                            href="{{ url('pasien/pendaftaran_form') }}"
                        >
                            <span class="ml-2">Form Pendaftaran</span>
                        </a>
                    </li>

                    <li>
                        <a
                            class="block px-3 py-2 rounded-md flex items-center {{ is_active('pasien/riwayat_pendaftaran*', $currentPage, $force) }}"
                            href="{{ url('pasien/riwayat_pendaftaran') }}"
                        >
                            <span class="ml-2">Riwayat Pendaftaran</span>
                        </a>
                    </li>

                {{-- DOKTER --}}
                @elseif ($role === 'dokter')

                    <li>
                        <a
                            class="block px-3 py-2 rounded-md flex items-center {{ is_active('dokter/daftar_pasien*', $currentPage, $force) }}"
                            href="{{ url('dokter/daftar_pasien') }}"
                        >
                            <span class="ml-2">Daftar Pasien</span>
                        </a>
                    </li>

                    <li>
                        <a
                            class="block px-3 py-2 rounded-md flex items-center {{ is_active('dokter/riwayat_periksa*', $currentPage, $force) }}"
                            href="{{ url('dokter/riwayat_periksa') }}"
                        >
                            <span class="ml-2">Riwayat Periksa</span>
                        </a>
                    </li>

                @endif

            </ul>
        </nav>
    </div>
>>>>>>> ac8524e09c4b6d8e79d9dab77789553ccb3097ea
</aside>