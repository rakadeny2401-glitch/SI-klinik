@php
    $page_title = 'Daftar Spesialis';

    $page_style = [
        'spesialis_admin.css'
    ];
@endphp

@include('layout.header')

<div class="space-y-6">

    <div class="bg-white border rounded-2xl shadow-sm p-6">
        <h2 class="text-3xl font-bold text-gray-800">
            Daftar Spesialis
        </h2>
    </div>

    <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Nama Spesialis</th>
                        <th class="px-6 py-4 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($spesialis as $index => $row)

                        <tr class="border-t">

                            <td class="px-6 py-4">
                                {{ $spesialis->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $row->nama_spesialis }}
                            </td>

                            <td class="px-6 py-4">

                                <a href="{{ url('/admin/spesialis/detail/'.$row->id_spesialis) }}">
    <button
        class="bg-blue-600 text-white px-4 py-2 rounded">
        Detail
    </button>
</a>

                                <button
                                    class="bg-red-600 text-white px-4 py-2 rounded">
                                    Hapus
                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="text-center py-6">
                                Data spesialis tidak ditemukan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-4">
        {{ $spesialis->links() }}
    </div>

</div>

@include('layout.footer')