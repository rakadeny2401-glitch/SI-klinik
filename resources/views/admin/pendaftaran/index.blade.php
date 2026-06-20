@extends('layout.app')

@section('content')

<h2 class="text-3xl font-bold text-[#222] mb-6.25 font-sans">
    Form Pendaftaran Pasien
</h2>

@if(session('error'))
<div class="bg-[#fee2e2] text-[#991b1b] p-3 rounded-lg mb-5 text-sm">
    {{ session('error') }}
</div>
@endif

<div class="bg-white max-w-[900px] p-7.5 rounded-2xl shadow-[0_8px_25px_rgba(0,0,0,0.04)] font-sans">
    <form method="POST" action="/admin/pendaftaran">
        @csrf

        <div class="border border-[#e5e7eb] rounded-xl pt-6.25 px-5 pb-3.75 mb-6.25 relative">
            <span class="absolute -top-3 left-5 bg-white px-2.5 text-2xl font-bold text-[#1b159d]">Data Pasien</span>
            
            <div class="flex flex-col gap-4.5">
                <div class="flex flex-col gap-1.5 relative">
                    <label class="text-sm font-semibold text-[#4b5563]">NIK Pasien</label>
                    <input type="text" id="nik_pasien" name="nik_pasien" autocomplete="off" placeholder="Ketik NIK pasien..."
                           class="w-full p-3 border border-[#d1d5db] text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white focus:border-[#1b159d]">
                    <div id="nik_suggestions" class="absolute top-full left-0 w-full bg-white border border-[#d1d5db] rounded-md shadow-md mt-1 hidden z-10"></div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Nama Pasien</label>
                    <input type="text" id="nama_pasien" readonly placeholder="akan terisi otomatis"
                           class="w-full p-3 border border-[#d1d5db] text-sm disabled:bg-white">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">NIK</label>
                    <input type="text" id="nik_manual" readonly placeholder="akan terisi otomatis"
                           class="w-full p-3 border border-[#d1d5db] text-sm disabled:bg-white">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Alamat</label>
                    <textarea id="alamat_pasien" readonly placeholder="akan terisi otomatis"
                              class="w-full p-3 border border-[#d1d5db] text-sm min-h-[120px] disabled:bg-white"></textarea>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Jenis Kelamin</label>
                    <input type="text" id="jenis_kelamin" disabled placeholder="akan terisi otomatis"
                           class="w-full p-3 border border-[#d1d5db] text-sm disabled:bg-white">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Umur</label>
                    <input type="text" id="umur" disabled placeholder="akan terisi otomatis"
                           class="w-full p-3 border border-[#d1d5db] text-sm disabled:bg-white">
                </div>
            </div>
        </div>

        <div class="border border-[#e5e7eb] rounded-xl pt-6.25 px-5 pb-3.75 mb-6.25 relative">
            <span class="absolute -top-3 left-5 bg-white px-2.5 text-2xl font-bold text-[#1b159d]">Data Pendaftaran</span>
            
            <div class="flex flex-col gap-4.5">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Spesialis</label>
                    <select name="id_spesialis" id="id_spesialis" class="w-full p-3 border border-[#d1d5db] text-sm bg-white">
                        <option value="">-- Pilih Spesialis --</option>
                        @foreach($spesialis as $s)
                            <option value="{{ $s->id_spesialis }}">{{ $s->nama_spesialis }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Waktu Pendaftaran</label>
                    <input type="time" name="waktu_daftar" id="waktu_daftar" required class="w-full p-3 border border-[#d1d5db] text-sm bg-white">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Dokter Terpilih</label>
                    <input type="text" id="dokter_nama" disabled placeholder="akan terisi otomatis"
                           class="w-full p-3 border border-[#d1d5db] text-sm disabled:bg-white">
                    <small id="dokter_status" class="block mt-1.5 text-[13px]"></small>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Keluhan</label>
                    <textarea name="keluhan" class="w-full p-3 border border-[#d1d5db] text-sm min-h-[120px] resize-y bg-white"></textarea>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Admin</label>
                    <input type="text" value="{{ $nama_admin ?? '-' }}" disabled class="w-full p-3 border border-[#d1d5db] text-sm disabled:bg-white">
                </div>
            </div>
        </div>

        <div class="mt-2.5">
            <button type="submit" class="bg-[#004085] text-white py-3 px-7 rounded-lg text-[15px] font-bold cursor-pointer hover:bg-[#002752]">
                Simpan
            </button>
        </div>
    </form>
</div>

<script>
const pasienData = @json($pasienMap);
const dokterData = @json($dokter);
const nikInput = document.getElementById('nik_pasien');
const suggestionsBox = document.getElementById('nik_suggestions');
let selectedSpesialis = null;

nikInput.addEventListener('input', function() {
    const query = this.value.trim();
    suggestionsBox.innerHTML = '';
    if (!query) {
        suggestionsBox.classList.add('hidden');
        return;
    }
    const matches = Object.values(pasienData).filter(p => p.nik.startsWith(query));
    if (matches.length === 0) {
        suggestionsBox.classList.add('hidden');
        return;
    }
    matches.forEach(p => {
        const option = document.createElement('div');
        option.textContent = p.nik + ' - ' + p.nama_pasien;
        option.className = 'px-3 py-2 cursor-pointer hover:bg-gray-100 text-sm';
        option.addEventListener('click', function() {
            nikInput.value = p.nik;
            document.getElementById('nama_pasien').value = p.nama_pasien || '';
            document.getElementById('alamat_pasien').value = p.alamat_pasien || '';
            document.getElementById('jenis_kelamin').value = p.jenis_kelamin || '';
            document.getElementById('umur').value = p.umur || '';
            document.getElementById('nik_manual').value = p.nik || '';
            suggestionsBox.classList.add('hidden');
        });
        suggestionsBox.appendChild(option);
    });
    suggestionsBox.classList.remove('hidden');
});

document.addEventListener('click', function(e) {
    if (!nikInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
        suggestionsBox.classList.add('hidden');
    }
});

document.getElementById('id_spesialis').addEventListener('change', function () {
    selectedSpesialis = this.value;
    document.getElementById('dokter_nama').value = '';
    document.getElementById('dokter_status').innerText = '';
});

document.getElementById('waktu_daftar').addEventListener('change', function () {
    let jam = this.value;
    if (!jam) return;
    let timePart = jam.substring(0, 5);
    if (!selectedSpesialis) {
        document.getElementById('dokter_nama').value = '';
        document.getElementById('dokter_status').innerText = 'Pilih spesialis terlebih dahulu';
        document.getElementById('dokter_status').style.color = 'red';
        return;
    }
    let found = null;
    dokterData.forEach(d => {
        if (String(d.id_spesialis) !== String(selectedSpesialis)) return;
        let start = (d.waktu_kerja || '').substring(0, 5);
        let end = (d.waktu_pulang || '').substring(0, 5);
        if (start && end && timePart >= start && timePart < end) {
            found = d;
        }
    });
    if (found) {
        document.getElementById('dokter_nama').value = found.nama_dokter;
        document.getElementById('dokter_status').innerText = 'Dokter tersedia';
        document.getElementById('dokter_status').style.color = 'green';
    } else {
        document.getElementById('dokter_nama').value = '';
        document.getElementById('dokter_status').innerText = 'Tidak ada dokter di spesialis ini pada jam tersebut';
        document.getElementById('dokter_status').style.color = 'red';
    }
});
</script>
@endsection