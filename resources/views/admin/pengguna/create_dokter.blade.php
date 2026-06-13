@extends('layout.app')

@section('content')

<h2>Tambah Dokter</h2>

<form method="POST" action="/admin/pengguna/dokter">
@csrf

<div>
    <label>Nama Dokter</label>
    <input name="nama_dokter" placeholder="Contoh: dr. Andi Saputra">
    <small>Masukkan nama lengkap dokter.</small>
</div>

<br>

<div>
    <label>No HP Dokter</label>
    <input name="no_hp_dokter" placeholder="Contoh: 08xxxxxxxxxx">
    <small>Nomor kontak aktif dokter.</small>
</div>

<br>

<div>
    <label>Alamat Dokter</label>
    <textarea name="alamat_dokter" placeholder="Contoh: Bandung"></textarea>
    <small>Alamat tempat tinggal atau praktik dokter.</small>
</div>

<br>

<div>
    <label>Tanggal Lahir</label>
    <input type="date" name="tgl_lahir_dokter">
    <small>Digunakan untuk data identitas dokter.</small>
</div>

<br>

<div>
    <label>Waktu Mulai Kerja</label>
    <input type="time" name="waktu_kerja">
    <small>Jam mulai dokter bertugas.</small>
</div>

<br>

<div>
    <label>Spesialis</label>
    <select name="id_spesialis">
        @foreach($spesialis as $sp)
            <option value="{{ $sp->id_spesialis }}">
                {{ $sp->nama_spesialis }}
            </option>
        @endforeach
    </select>
    <small>Pilih bidang spesialis dokter.</small>
</div>

<br>

<div>
    <label>Password Dokter</label>
    <input name="passworddok" maxlength="6" type="password">
    <small>Password login dokter (maksimal 6 karakter).</small>
</div>

<br>

<button>Simpan</button>

</form>

@endsection