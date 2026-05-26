(function(){
    // Per-page toast handling removed — handled by global handler.
    // Keep form helper functions below.

    function getDokterMap(){
        var el = document.getElementById('dokter-data');
        if (!el) return {};
        try { return JSON.parse(el.getAttribute('data-json') || '{}'); } catch(e){ return {}; }
    }
    var dokterBySpesialis = getDokterMap();

   function loadPasienData(){
    var select = document.getElementById('nik');
    if (!select) return;
    var option = select.options[select.selectedIndex];
    if (!option) return;

    if (option.value === ''){
        document.getElementById('nama_pasien').value = '';
        document.getElementById('alamat_pasien').value = '';
        document.getElementById('jenis_kelamin').value = '';
        document.getElementById('umur').value = '';
        document.getElementById('nama_pasien').readOnly = false;
        document.getElementById('alamat_pasien').readOnly = false;
        document.getElementById('jenis_kelamin').readOnly = false;
        document.getElementById('umur').readOnly = false;
        document.getElementById('nik_manual').value = '';
        document.getElementById('nik_manual').readOnly = false;
    } else {
        document.getElementById('nama_pasien').value = option.getAttribute('data-nama') || '';
        document.getElementById('alamat_pasien').value = option.getAttribute('data-alamat') || '';
        document.getElementById('jenis_kelamin').value = option.getAttribute('data-jenis-kelamin') || '';
        document.getElementById('umur').value = option.getAttribute('data-umur') || '';
        document.getElementById('nama_pasien').readOnly = true;
        document.getElementById('alamat_pasien').readOnly = true;
        document.getElementById('jenis_kelamin').readOnly = true;
        document.getElementById('umur').readOnly = true;
        document.getElementById('nik_manual').value = option.getAttribute('data-nik') || '';
        document.getElementById('nik_manual').readOnly = true;
    }
}

    function updateDokterOtomatis(){
        var spesialisEl = document.getElementById('id_spesialis');
        var waktuEl = document.getElementById('waktu_daftar');
        var infoEl = document.getElementById('dokter_terpilih_info');
        var hiddenIdEl = document.getElementById('id_dokter');

        if (!spesialisEl || !waktuEl) return;
        var sp = spesialisEl.value;
        var t = waktuEl.value?.slice(0,5);
        let text = 'Akan dipilih otomatis berdasarkan jam kerja';
        let id = '';

        if (sp && t && dokterBySpesialis[sp]) {
            const found = dokterBySpesialis[sp].find(d => {
                const mulai = d.waktu_kerja?.slice(0,5);
                const pulang = d.waktu_pulang?.slice(0,5);
                return mulai && pulang && t >= mulai && t < pulang;
            });
            if (found) {
                text = `${found.nama_dokter} (${found.jam_kerja})`;
                id = found.id_dokter;
            } else {
                text = 'Tidak ada dokter yang praktik pada jam ini';
            }
        }
        if (infoEl) infoEl.value = text;
        if (hiddenIdEl) hiddenIdEl.value = id;
    }

    window.loadPasienData = loadPasienData;

    document.addEventListener('DOMContentLoaded', () => {
        const spesialisEl = document.getElementById('id_spesialis');
        const waktuEl = document.getElementById('waktu_daftar');
        if (spesialisEl) spesialisEl.addEventListener('change', updateDokterOtomatis);
        if (waktuEl) waktuEl.addEventListener('change', updateDokterOtomatis);
    });
    window.updateDokterOtomatis = updateDokterOtomatis;
})();
