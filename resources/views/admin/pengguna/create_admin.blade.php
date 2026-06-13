@extends('layout.app')

@section('content')

<h2>Tambah Admin</h2>

<form method="POST" action="/admin/pengguna/admin">
@csrf

<input name="nama_admin" placeholder="Nama">
<input name="waktu_jaga" type="time">
<input name="passwordadmin" maxlength="6">

<button>Simpan</button>
</form>

@endsection