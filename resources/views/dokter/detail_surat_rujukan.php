<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_rujukan = mysqli_real_escape_string($koneksi, $_GET['id_rujukan'] ?? '');
if ($id_rujukan === '') {
    echo "ID Surat Rujukan tidak ditemukan.";
    exit;
}

$page_title = "Detail Surat Rujukan";
$page_style = ["../../style/css/detail_surat.css"];
$force_active_menu = 'riwayat_periksa.php';

include __DIR__ . '/../layout/header.php';

$q = mysqli_query($koneksi, "
    SELECT r.*, p.nama_pasien, p.umur, d.keluhan, dk.nama_dokter
    FROM srt_rkrmdsi_rujukan r
    JOIN pasien p ON r.id_pasien = p.id_pasien
    JOIN daftar d ON r.id_daftar = d.id_daftar
    JOIN dokter dk ON r.id_dokter = dk.id_dokter
    WHERE r.id_rujukan = '$id_rujukan'
    LIMIT 1
");

$data = mysqli_fetch_assoc($q);
if (!$data) {
    echo "Surat rujukan tidak ditemukan.";
    include __DIR__ . '/../layout/footer.php';
    exit;
}
?>

<h2>Detail Surat Rekomendasi Rujukan</h2>

<table class="sp-table">
    <tr><th>Nama Pasien</th><td><?php echo htmlspecialchars($data['nama_pasien']); ?></td></tr>
    <tr><th>Umur</th><td><?php echo htmlspecialchars($data['umur']); ?> tahun</td></tr>
    <tr><th>Keluhan</th><td><?php echo htmlspecialchars($data['keluhan']); ?></td></tr>
    <tr><th>Rekomendasi</th><td><?php echo htmlspecialchars($data['rekomendasi']); ?></td></tr>
    <tr><th>Dokter</th><td><?php echo htmlspecialchars($data['nama_dokter']); ?></td></tr>
</table>

<div class="btn-container">
    <a href="riwayat_periksa.php" class="btn-back">Kembali</a>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>