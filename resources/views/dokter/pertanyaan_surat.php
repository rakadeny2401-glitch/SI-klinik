<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_daftar = mysqli_real_escape_string($koneksi, $_GET['id_daftar'] ?? '');
$id_pasien = mysqli_real_escape_string($koneksi, $_GET['id_pasien'] ?? '');

if ($id_daftar === '' || $id_pasien === '') {
    echo "Data tidak lengkap.";
    exit;
}

$page_title = "Pertanyaan Surat";
$page_style = ["../../style/css/surat_questions.css"];
$force_active_menu = 'daftar_pasien.php';

include __DIR__ . '/../layout/header.php';

$qRujukan = mysqli_query($koneksi, "SELECT 1 FROM srt_rkrmdsi_rujukan WHERE id_daftar='$id_daftar' LIMIT 1");
$rujukan_sudah_ada = mysqli_num_rows($qRujukan) > 0;
?>

<div class="surat-container">
    <h2 class="title">Apakah perlu membuat surat tambahan?</h2>

    <div class="button-group">

        <?php if (!$rujukan_sudah_ada): ?>
        <form action="surat_rujukan_form.php" method="GET">
            <input type="hidden" name="id_daftar" value="<?= htmlspecialchars($id_daftar); ?>">
            <input type="hidden" name="id_pasien" value="<?= htmlspecialchars($id_pasien); ?>">
            <button type="submit" class="btn blue">Surat Rekomendasi Rujukan</button>
        </form>
        <?php endif; ?>

        <form action="surat_keterangan_sakit_form.php" method="GET">
            <input type="hidden" name="id_daftar" value="<?= htmlspecialchars($id_daftar); ?>">
            <input type="hidden" name="id_pasien" value="<?= htmlspecialchars($id_pasien); ?>">
            <button type="submit" class="btn green">Surat Keterangan Sakit</button>
        </form>

        <form action="daftar_pasien.php" method="GET">
            <button type="submit" class="btn gray">Kembali</button>
        </form>

    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
