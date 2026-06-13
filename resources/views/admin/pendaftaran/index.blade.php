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
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">NIK Pasien</label>
                    <select name="id_pasien" id="id_pasien" class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white focus:border-[#1b159d] focus:shadow-[0_0_0_3px_rgba(27,21,157,0.1)]">
                        <option value="">Ketik NIK atau Nama Pasien</option>
                        @foreach($pasien as $p)
                            <option value="{{ $p->id_pasien }}">
                                {{ $p->nama_pasien }} - {{ $p->nik }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Nama Pasien</label>
                    <input type="text" name="nama_pasien" id="nama_pasien" class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white focus:border-[#1b159d] focus:shadow-[0_0_0_3px_rgba(27,21,157,0.1)] disabled:bg-white disabled:border-[#e5e7eb] disabled:text-[#1f2937] disabled:cursor-not-allowed">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">NIK</label>
                    <input type="text" name="nik_manual" id="nik_manual" class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white focus:border-[#1b159d] focus:shadow-[0_0_0_3px_rgba(27,21,157,0.1)] disabled:bg-white disabled:border-[#e5e7eb] disabled:text-[#1f2937] disabled:cursor-not-allowed">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Alamat</label>
                    <textarea name="alamat_pasien" id="alamat_pasien" class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white min-h-[120px] resize-y focus:border-[#1b159d] focus:shadow-[0_0_0_3px_rgba(27,21,157,0.1)] disabled:bg-white disabled:border-[#e5e7eb] disabled:text-[#1f2937] disabled:cursor-not-allowed"></textarea>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Jenis Kelamin</label>
                    <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white focus:border-[#1b159d] focus:shadow-[0_0_0_3px_rgba(27,21,157,0.1)] disabled:bg-white disabled:border-[#e5e7eb] disabled:text-[#1f2937] disabled:cursor-not-allowed">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Umur</label>
                    <input type="text" name="umur" id="umur" class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white focus:border-[#1b159d] focus:shadow-[0_0_0_3px_rgba(27,21,157,0.1)] disabled:bg-white disabled:border-[#e5e7eb] disabled:text-[#1f2937] disabled:cursor-not-allowed">
                </div>
            </div>
        </div>

        <div class="border border-[#e5e7eb] rounded-xl pt-6.25 px-5 pb-3.75 mb-6.25 relative">
            <span class="absolute -top-3 left-5 bg-white px-2.5 text-2xl font-bold text-[#1b159d]">Data Pendaftaran</span>
            
            <div class="flex flex-col gap-4.5">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Waktu Pendaftaran</label>
                    <input type="time" name="waktu_daftar" id="waktu_daftar" required class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white focus:border-[#1b159d] focus:shadow-[0_0_0_3px_rgba(27,21,157,0.1)]">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Spesialis</label>
                    <select name="id_spesialis" class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white focus:border-[#1b159d] focus:shadow-[0_0_0_3px_rgba(27,21,157,0.1)]">
                        <option value="">-- Pilih Spesialis --</option>
                        @foreach($spesialis as $s)
                            <option value="{{ $s->id_spesialis }}">{{ $s->nama_spesialis }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Dokter Terpilih</label>
                    <input type="text" id="dokter_nama" disabled class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white disabled:bg-white disabled:border-[#e5e7eb] disabled:text-[#1f2937] disabled:cursor-not-allowed">
                    <small id="dokter_status" class="block mt-1.5 text-[13px]"></small>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Keluhan</label>
                    <textarea name="keluhan" class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white min-h-[120px] resize-y focus:border-[#1b159d] focus:shadow-[0_0_0_3px_rgba(27,21,157,0.1)]"></textarea>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-[#4b5563]">Admin</label>
                    <input type="text" value="{{ $nama_admin ?? '-' }}" disabled class="w-full p-3 border border-[#d1d5db] rounded-auto text-sm text-[#1f2937] outline-none transition-all duration-200 bg-white disabled:bg-white disabled:border-[#e5e7eb] disabled:text-[#1f2937] disabled:cursor-not-allowed">
                </div>
            </div>
        </div>

        <div class="mt-2.5">
            <button type="submit" class="bg-[#004085] text-white py-3 px-7 rounded-lg text-[15px] font-bold cursor-pointer transition-colors duration-200 hover:bg-[#002752]">
                Simpan
            </button>
        </div>

    </form>
</div>

<script>
// Logic Javascript tetap aman di sini
const pasienData = @json($pasienMap);
const dokterData = @json($dokter);
const fields = ['nama_pasien','alamat_pasien','jenis_kelamin','umur','nik_manual'];
let selectedSpesialis = null;

document.querySelector('select[name="id_spesialis"]').addEventListener('change', function () {
    selectedSpesialis = this.value;
    document.getElementById('dokter_nama').value = '';
    document.getElementById('dokter_status').innerText = '';
});

document.getElementById('id_pasien').addEventListener('change', function () {
    let id = this.value;
    if (!id) {
        fields.forEach(f => {
            document.getElementById(f).value = '';
            document.getElementById(f).disabled = false;
        });
        return;
    }
    let p = pasienData[id];
    if (p) {
        document.getElementById('nama_pasien').value = p.nama_pasien || '';
        document.getElementById('alamat_pasien').value = p.alamat_pasien || '';
        document.getElementById('jenis_kelamin').value = p.jenis_kelamin || '';
        document.getElementById('umur').value = p.umur || '';
        document.getElementById('nik_manual').value = p.nik || '';
        fields.forEach(f => {
            document.getElementById(f).disabled = true;
        });
    }
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