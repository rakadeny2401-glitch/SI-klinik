@php
    $page_title = 'Detail Spesialis';

    $page_style = [
        'spesialis_admin.css'
    ];
@endphp

@include('layout.header')

<div class="space-y-6">

    <div class="bg-white border rounded-2xl shadow-sm p-6">
        <h2 class="text-3xl font-bold text-gray-800">
            Detail Spesialis
        </h2>
    </div>

    <div class="bg-white border rounded-2xl shadow-sm p-6">

        <div class="mb-4">
            <strong>Nama Spesialis :</strong>
            {{ $spesialis->nama_spesialis }}
        </div>

    </div>

    <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">

        <div class="p-6 border-b">
            <h3 class="text-xl font-semibold">
                Daftar Dokter
            </h3>
        </div>

        @if($dokter->count() == 0)

            <div class="p-6 text-center text-gray-500">
                Tidak ada dokter terdaftar pada spesialis ini.
            </div>

        @else

            <table class="w-full">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Nama Dokter</th>
                        <th class="px-6 py-4 text-left">Jam Kerja</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($dokter as $index => $row)

                        <tr class="border-t">

                            <td class="px-6 py-4">
                                {{ $dokter->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $row->nama_dokter }}
                            </td>

                            <td class="px-6 py-4">

                                {{ $row->waktu_kerja ? \Carbon\Carbon::parse($row->waktu_kerja)->format('H:i') : '-' }}

                                -

                                {{ $row->waktu_pulang ? \Carbon\Carbon::parse($row->waktu_pulang)->format('H:i') : '-' }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            <div class="p-4">
                {{ $dokter->links() }}
            </div>

        @endif

    </div>

    <div>

        <a href="{{ url('/admin/spesialis') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>

    </div>

</div>

@include('layout.footer')