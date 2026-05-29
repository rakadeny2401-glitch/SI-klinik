@php
    $page_title = 'Detail Pengguna';
    $page_style = [
        'lihat_pengguna_detail.css',
        'components.css'
    ];
@endphp

@include('layout.header')

@php
    $hidden = $hidden ?? [];
    $label = $label ?? [];
@endphp

<div class="max-w-3xl mx-auto bg-white border rounded-2xl shadow-sm p-6 space-y-6">

    {{-- Header --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Detail Pengguna ({{ ucfirst($role) }})
        </h2>
    </div>

    {{-- Detail Data --}}
    <div class="space-y-3">

        @foreach ($details as $k => $v)

            @if (in_array($k, $hidden))
                @continue
            @endif

            @php
                $kolom = $label[$k] ?? ucwords(str_replace('_', ' ', $k));
            @endphp

            <div class="flex justify-between border-b py-2">
                <div class="font-semibold text-gray-600">
                    {{ $kolom }}
                </div>

                <div class="text-gray-800">
                    {{ $v }}
                </div>
            </div>

        @endforeach

    </div>

    {{-- Buttons --}}
    <div class="flex gap-3 pt-4">

        <a
            href="{{ url('admin/pengguna/edit/' . $role . '/' . $id) }}"
            class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg"
        >
            Edit
        </a>

        <form
            method="POST"
            action="{{ url('admin/pengguna/delete') }}"
            class="flex-1"
            onsubmit="return confirm('Hapus pengguna ini? Tindakan tidak dapat dibatalkan.')"
        >
            @csrf

            <input type="hidden" name="role" value="{{ $role }}">
            <input type="hidden" name="id" value="{{ $id }}">

            <button
                type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg"
            >
                Hapus
            </button>
        </form>

    </div>

    <div>
        <a
            href="{{ url('admin/pengguna') }}"
            class="inline-block text-gray-600 hover:text-black"
        >
            ← Kembali
        </a>
    </div>

</div>

@include('layout.footer')