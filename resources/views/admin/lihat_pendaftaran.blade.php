@php
$page_title = 'Daftar Pendaftaran';

$page_style = [
    'lihat_pendaftaran.css'
];
@endphp

@include('layout.header')

<h2>Daftar Pendaftaran</h2>

<table border="1" cellpadding="6" cellspacing="0">

<thead>
<tr>
    <th>No</th>
    <th>Nama Pasien</th>
    <th>NIK</th>
    <th>Spesialis</th>
    <th>Dokter</th>
    <th>No Antrian</th>
    <th>Tanggal Pemeriksaan</th>
    <th>Status</th>
    <th>Admin</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($rows as $index => $r)

<tr>

    <td>{{ $rows->firstItem() + $index }}</td>

    <td>{{ $r->nama_pasien ?? '-' }}</td>

    <td>{{ $r->nik ?? '-' }}</td>

    <td>{{ $r->nama_spesialis ?? '-' }}</td>

    <td>{{ $r->nama_dokter ?? '-' }}</td>

    <td>{{ $r->no_antrian ?? '-' }}</td>

    <td>{{ $r->tgl_pemeriksaan ?? '-' }}</td>

    <td>{{ $r->status_pendaftaran ?? '-' }}</td>

    <td>{{ $r->nama_admin ?? '-' }}</td>

    <td>

        @if(($r->status_pendaftaran ?? '') === 'pengecekan')

            <form method="POST"
                  action="{{ url('/admin/pendaftaran/konfirmasi') }}"
                  onsubmit="return confirm('Konfirmasi pendaftaran ini?');">

                @csrf

                <input
                    type="hidden"
                    name="id_value"
                    value="{{ $r->id_pendaftaran }}">

                <button type="submit">
                    Konfirmasi
                </button>

            </form>

        @else

            -

        @endif

    </td>

</tr>

@empty

<tr>
    <td colspan="10">
        Tidak ada pendaftaran ditemukan.
    </td>
</tr>

@endforelse

</tbody>

</table>

<div class="mt-4">
    {{ $rows->links() }}
</div>

@include('layout.footer')