<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

$page_title = "Surat Rekomendasi Rujukan";
$page_style = ["../../style/css/form_surat_rujukan.css"];
$force_active_menu = 'daftar_pasien.php';

include __DIR__ . '/../layout/header.php';

$q = mysqli_query($koneksi, "SELECT id_proses FROM proses_pasien WHERE id_daftar='$id_daftar' ORDER BY id_proses DESC LIMIT 1");
if (!$q) {
    echo "Query gagal: " . mysqli_error($koneksi);
    include __DIR__ . '/../layout/footer.php';
    exit;
}
$proses = mysqli_fetch_assoc($q);
$id_proses = $proses['id_proses'] ?? null;
?>

<h2>Input Surat Rekomendasi Rujukan</h2>
<form action="../../controller/surat_proses.php" method="POST">
    <fieldset>
        <legend>Rekomendasi Dokter</legend>
        <div class="form-group">
            <label for="rekomendasi">Isi Rekomendasi:</label>
            <textarea id="rekomendasi" name="rekomendasi" rows="5" required></textarea>
        </div>
    </fieldset>
    <input type="hidden" name="id_daftar" value="<?php echo htmlspecialchars($id_daftar); ?>">
    <input type="hidden" name="id_pasien" value="<?php echo htmlspecialchars($id_pasien); ?>">
    <input type="hidden" name="id_dokter" value="<?php echo htmlspecialchars($id_dokter); ?>">
    <?php if ($id_proses !== null): ?>
        <input type="hidden" name="id_proses" value="<?php echo htmlspecialchars($id_proses); ?>">
    <?php endif; ?>
    <button type="submit" name="aksi" value="simpan_rujukan">Simpan Surat Rujukan</button>
</form>

<?php include __DIR__ . '/../layout/footer.php'; ?>