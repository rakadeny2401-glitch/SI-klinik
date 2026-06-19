@php
    $role = session('role');
    $activeMenu = $force_active_menu ?? '';
@endphp

<aside class="w-64 min-h-screen bg-[#f8f9fa] border-r border-[#e5e7eb] py-4 font-sans shrink-0">
    <nav class="px-3">
        <ul class="space-y-1">
            <li>
                @if($role === 'admin')
                    <a href="/admin/dashboard" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('admin/dashboard') || $activeMenu === 'dashboard' ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                @elseif($role === 'dokter')
                    <a href="/dokter/dashboard" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('dokter/dashboard') || $activeMenu === 'dashboard' ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                @elseif($role === 'pasien')
                    <a href="/pasien/dashboard" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('pasien/dashboard') || $activeMenu === 'dashboard' ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                @else
                    <a href="/" class="flex items-center px-4 py-2.5 text-[14px] font-medium text-gray-600 hover:bg-gray-100 rounded-lg">Dashboard</a>
                @endif
            </li>

            @if($role === 'admin')
                <li>
                    <a href="/admin/pengguna" class="flex items-center px-4 py-2.5 text-[14px] font-medium rounded-lg transition-colors {{ request()->is('admin/pengguna*') && $activeMenu !== 'dashboard' ? 'bg-[#e6f0fa] text-[#004085] font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
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
</aside>
