@php
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
                            class="block px-3 py-2 rounded-md flex items-center {{ is_active('admin/pendaftaran_form*', $currentPage, $force) }}"
                            href="{{ url('admin/pendaftaran_form') }}"
                        >
                            <span class="ml-2">Pendaftaran</span>
                        </a>
                    </li>

                    <li>
                        <a
                            class="block px-3 py-2 rounded-md flex items-center {{ is_active('admin/lihat_pendaftaran*', $currentPage, $force) }}"
                            href="{{ url('admin/lihat_pendaftaran') }}"
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
</aside>