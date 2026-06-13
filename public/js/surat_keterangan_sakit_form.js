document.addEventListener("DOMContentLoaded", function() {
    const jmlIstirahat = document.getElementById("jml_istirahat");
    const tglMulai = document.getElementById("tgl_mulai");
    const tglSelesai = document.getElementById("tgl_selesai");

    function hitungTanggalSelesai() {
        const hari = parseInt(jmlIstirahat.value);
        const mulai = new Date(tglMulai.value);

        if (!isNaN(hari) && tglMulai.value) {
            mulai.setDate(mulai.getDate() + (hari - 1));

            const yyyy = mulai.getFullYear();
            const mm = String(mulai.getMonth() + 1).padStart(2, '0');
            const dd = String(mulai.getDate()).padStart(2, '0');

            tglSelesai.value = `${yyyy}-${mm}-${dd}`;
        }
    }

    jmlIstirahat.addEventListener("input", hitungTanggalSelesai);
    tglMulai.addEventListener("change", hitungTanggalSelesai);
});
