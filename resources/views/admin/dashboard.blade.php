@php
    $page_title = 'Dashboard Admin';

    $page_style = [
        'dashboard_admin.css'
    ];

    $role = strtolower(session('role') ?? '');

    if ($role !== 'admin') {
        abort(403, 'Akses ditolak');
    }

    $nama = session('data')['nama_admin'] ?? 'Administrator';
@endphp

@include('layout.header')

<div class="space-y-6">

    {{-- Welcome --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <h2 class="text-3xl font-bold text-gray-800">
            Selamat Datang di Puskesmas
        </h2>

        <p class="mt-2 text-gray-600 text-lg">
            {{ $nama }}
        </p>
    </div>

    {{-- Dashboard Cards --}}
    <section class="dashboard-cards">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Tambah Pengguna --}}
            <a
                href="{{ url('admin/tambah_pengguna') }}"
                class="bg-white rounded-2xl shadow-sm border p-6 hover:shadow-md transition duration-300 flex items-center gap-5"
            >
                <div class="text-5xl">
                    👥
                </div>

                <div>
                    <div class="text-xl font-semibold text-gray-800">
                        Tambah Pengguna
                    </div>

                    <div class="text-gray-500 mt-1">
                        Buat akun admin atau petugas baru
                    </div>
                </div>
            </a>

            {{-- Tambah Spesialis --}}
            <a
                href="{{ url('admin/tambah_spesialis') }}"
                class="bg-white rounded-2xl shadow-sm border p-6 hover:shadow-md transition duration-300 flex items-center gap-5"
            >
                <div class="text-5xl">
                    🩺
                </div>

                <div>
                    <div class="text-xl font-semibold text-gray-800">
                        Tambah Spesialis
                    </div>

                    <div class="text-gray-500 mt-1">
                        Kelola bidang spesialis dokter
                    </div>
                </div>
            </a>

        </div>
    </section>

</div>

@include('layout.footer')
