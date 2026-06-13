(function () {
    if (window.__localToastShown) return;

    function show(msg, kind) {
        var toast = document.getElementById('localhost-toast');
        var msgEl = document.getElementById('localhost-toast-msg');
        var box = document.getElementById('localhost-toast-box');
        if (!toast || !msgEl) return;

        msgEl.textContent = msg;
        if (box && kind === 'success') box.classList.add('success');
        toast.style.top = '12px';

        setTimeout(function () {
            toast.style.top = '-180px';
            if (box) box.classList.remove('success');
            try {
                var u = new URL(window.location.href);
                u.searchParams.delete('status');
                u.searchParams.delete('role');
                history.replaceState(null, '', u.pathname + u.search);
            } catch (e) {}
        }, 4200);
    }

    function roleLabel(role) {
        if (!role) return null;
        role = role.toLowerCase();
        if (role === 'dokter') return 'Dokter';
        if (role === 'pasien') return 'Pasien';
        if (role === 'admin') return 'Admin';
        if (role === 'spesialis') return 'Spesialis';
        return null;
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (window.__localToastShown) return;
        var params = new URLSearchParams(window.location.search);
        var status = params.get('status');
        var role = params.get('role');
        var toastCode = params.get('toast');
        var label = roleLabel(role);
        var path = window.location.pathname || '';

        var msg = '';
        var kind = '';

        if (!status && toastCode) {
            var toastMap = {
                akses_ditolak: 'Akses ditolak!',
                invalid_method: 'Akses tidak sah.',
                field_kosong: 'Semua field wajib diisi.',
                aktif: 'Anda masih memiliki pendaftaran yang aktif',
                pasien_notfound: 'Pasien tidak ditemukan!',
                dokter_invalid: 'Dokter tidak sesuai dengan spesialis!',
                waktu_invalid: 'Format waktu tidak valid!',
                jadwal_tidak_sesuai: 'Dokter tidak tersedia pada jam tersebut.',
                nama_kosong: 'Nama pasien belum diisi.',
                umur_invalid: 'Umur harus angka!',
                nik_invalid: 'NIK harus 16 digit!',
                simpan_gagal: 'Gagal menyimpan data!',
                surat_rujukan_added: 'Surat rujukan berhasil dibuat!',
                surat_sakit_added: 'Surat keterangan sakit berhasil dibuat!',
                resep_saved: 'Resep berhasil disimpan!',
                added: 'Pendaftaran berhasil dibuat!',
                dokter_notfound: 'Dokter tidak ditemukan!',
                jadwal_kirim: 'Pendaftaran berhasil dikirim!'
            };
            if (toastMap[toastCode]) {
                msg = toastMap[toastCode];
                kind = (toastCode === 'added' || toastCode === 'resep_saved' || toastCode === 'surat_rujukan_added' || toastCode === 'surat_sakit_added') ? 'success' : '';
                show(msg, kind);
                window.__localToastShown = true;
                return;
            }
        }

        if (status === 'added') {
            if (label === 'Dokter' || label === 'Pasien' || label === 'Admin') {
                msg = label + ' berhasil ditambahkan.';
                kind = 'success';
            } else if (label === 'Spesialis') {
                msg = '';
            } else if (path.indexOf('spesialis.php') !== -1) {
                msg = 'Spesialis berhasil ditambahkan.';
                kind = 'success';
            } else {
                msg = 'Data berhasil ditambahkan.';
                kind = 'success';
            }
        } else if (status === 'deleted') {
            if (label) msg = label + ' berhasil dihapus.';
            else if (path.indexOf('lihat_pengguna.php') !== -1 || path.indexOf('lihat_pengguna_detail.php') !== -1) msg = 'Pengguna berhasil dihapus.';
            else msg = 'Data berhasil dihapus.';
        } else if (status === 'updated') {
            if (label) msg = label + ' berhasil diubah.';
            else msg = 'Perubahan berhasil disimpan.';
        } else if (status === 'blocked') {
            msg = 'Tidak dapat menghapus: masih ada data terkait.';
        }

        if (msg) {
            show(msg, kind);
            window.__localToastShown = true;
        }
    });
})();
