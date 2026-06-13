@extends('layout.app')

@section('content')

<h2>Tambah Pasien</h2>

<form method="POST" action="/admin/pengguna/pasien">
@csrf

<div>
    <label>NIK</label>
    <input name="nik" maxlength="16" placeholder="16 digit NIK">
    <small>Nomor Induk Kependudukan pasien.</small>
</div>

<br>

<div>
    <label>Nama Pasien</label>
    <input name="nama_pasien" placeholder="Contoh: Siti Aminah">
    <small>Nama lengkap pasien sesuai identitas.</small>
</div>

<br>

<div>
    <label>Alamat</label>
    <textarea name="alamat_pasien" placeholder="Contoh: Jl. Melati No. 10"></textarea>
    <small>Alamat tempat tinggal pasien.</small>
</div>

<br>

<div>
    <label>Umur</label>
    <input name="umur" placeholder="Contoh: 25">
    <small>Umur pasien dalam tahun.</small>
</div>

<br>

<div>
    <label>Jenis Kelamin</label>
    <input name="jenis_kelamin" placeholder="L / P">
    <small>L = Laki-laki, P = Perempuan.</small>
</div>

<br>

<div>
    <label>No HP</label>
    <input name="no_hp" placeholder="08xxxxxxxxxx">
    <small>Nomor kontak pasien yang aktif.</small>
</div>

<br>

<div>
    <label>Password Pasien</label>
    <input name="password" maxlength="6" type="password">
    <small>Password login pasien (maksimal 6 karakter).</small>
</div>

<br>

<button>Simpan</button>

</form>

@endsection