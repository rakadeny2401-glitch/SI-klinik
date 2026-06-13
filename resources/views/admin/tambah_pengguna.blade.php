@php
    $page_title = 'Tambah Pengguna';

    $page_style = [
        'tambah_pengguna.css'
    ];

    $force_active_menu = 'dashboard';
@endphp

@include('layout.header')

<h2>Tambah Pengguna</h2>

<div class="tambah-wrapper">

    <a href="{{ url('admin/tambah-pasien') }}">
        <button type="button" class="btn-tambah">
            Tambah Pasien
        </button>
    </a>

    <a href="{{ url('admin/tambah-admin') }}">
        <button type="button" class="btn-tambah">
            Tambah Admin
        </button>
    </a>

    <a href="{{ url('admin/tambah-dokter') }}">
        <button type="button" class="btn-tambah">
            Tambah Dokter
        </button>
    </a>

</div>

@include('layout.footer')