<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_daftar = mysqli_real_escape_string($koneksi, $_GET['id_daftar'] ?? '');
$id_pasien = mysqli_real_escape_string($koneksi, $_GET['id_pasien'] ?? '');
$id_dokter = $_SESSION['data']['id_dokter'] ?? '';

if ($id_daftar === '' || $id_pasien === '' || $id_dokter === '') {
    echo "Data tidak lengkap.";
    exit;
}

$page_title = "Surat Keterangan Sakit";
$page_style = ["../../style/css/form_surat_keterangan_sakit.css"];
$force_active_menu = 'daftar_pasien.php';

include __DIR__ . '/../layout/header.php';

$q = mysqli_query($koneksi, "SELECT id_proses FROM proses_pasien WHERE id_daftar='$id_daftar' ORDER BY id_proses DESC LIMIT 1");
$proses = mysqli_fetch_assoc($q);
$id_proses = $proses['id_proses'] ?? null;
?>

<h2>Input Surat Keterangan Sakit</h2>
<form action="../../controller/surat_sakit_proses.php" method="POST">
    <fieldset>
        <legend>Keterangan Dokter</legend>
        <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <textarea id="keterangan" name="keterangan" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="jml_istirahat">Jumlah Hari Istirahat:</label>
            <input type="number" id="jml_istirahat" name="jml_istirahat" min="1" required>
        </div>
        <div class="form-group">
            <label for="tgl_mulai">Tanggal Mulai:</label>
            <input type="date" id="tgl_mulai" name="tgl_mulai" required>
        </div>
        <div class="form-group">
            <label for="tgl_selesai">Tanggal Selesai:</label>
            <input type="date" id="tgl_selesai" name="tgl_selesai" required readonly>
        </div>
    </fieldset>
    <input type="hidden" name="id_daftar" value="<?php echo htmlspecialchars($id_daftar); ?>">
    <input type="hidden" name="id_pasien" value="<?php echo htmlspecialchars($id_pasien); ?>">
    <input type="hidden" name="id_dokter" value="<?php echo htmlspecialchars($id_dokter); ?>">
    <?php if ($id_proses !== null): ?>
        <input type="hidden" name="id_proses" value="<?php echo htmlspecialchars($id_proses); ?>">
    <?php endif; ?>
    <button type="submit" name="aksi" value="simpan_sakit">Simpan Surat Sakit</button>
</form>

<script src="../../style/js/surat_keterangan_sakit_form.js"></script>

<?php include __DIR__ . '/../layout/footer.php'; ?>