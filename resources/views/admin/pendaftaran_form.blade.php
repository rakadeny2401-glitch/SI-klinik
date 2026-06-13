@php
$page_title = 'Form Pendaftaran Pasien';

$page_style = [
    'form_pendaftaran.css'
];
@endphp

@include('layout.header')

<select id="id_spesialis" name="id_spesialis" required>

    <option value="">
        -- Pilih Spesialis --
    </option>

    @foreach($spesialis as $s)

        <option value="{{ $s->id_spesialis }}">
            {{ $s->nama_spesialis }}
        </option>

    @endforeach

</select>

<input
    type="text"
    readonly
    value="{{ session('data.nama_admin') }}">

<input
    type="hidden"
    name="id_admin_value"
    value="{{ session('data.id_admin') }}">

    <div
    id="dokter-data"
    data-json="{{ htmlspecialchars($dokterJson, ENT_QUOTES, 'UTF-8') }}">
</div>

@include('layout.footer')