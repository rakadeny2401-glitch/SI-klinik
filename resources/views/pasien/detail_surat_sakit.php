<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pasien') {
    echo "Akses ditolak!";
    exit;
}

$id_surat = mysqli_real_escape_string($koneksi, $_GET['id_surat'] ?? '');
if ($id_surat === '') {
    echo "ID Surat tidak ditemukan.";
    exit;
}

$id_pasien = (int)($_SESSION['data']['id_pasien'] ?? 0);

$page_title = "Detail Surat Sakit";
$page_style = ["../../style/css/detail_surat.css"];
$force_active_menu = 'riwayat_pendaftaran';

include __DIR__ . '/../layout/header.php';

$q = mysqli_query($koneksi, "
    SELECT s.*, p.nama_pasien, p.umur, d.keluhan, dk.nama_dokter
    FROM surat_ktrgnsakit s
    JOIN pasien p ON s.id_pasien = p.id_pasien
    JOIN daftar d ON s.id_daftar = d.id_daftar
    JOIN dokter dk ON s.id_dokter = dk.id_dokter
    WHERE s.id_surat = '$id_surat' AND s.id_pasien = '$id_pasien'
    LIMIT 1
");

$data = mysqli_fetch_assoc($q);
if (!$data) {
    echo "Surat tidak ditemukan atau akses ditolak.";
    include __DIR__ . '/../layout/footer.php';
    exit;
}
?>

<h2>Detail Surat Keterangan Sakit</h2>
<table class="sp-table">
    <tr><th>Nama Pasien</th><td><?php echo htmlspecialchars($data['nama_pasien']); ?></td></tr>
    <tr><th>Umur</th><td><?php echo htmlspecialchars($data['umur']); ?> tahun</td></tr>
    <tr><th>Keluhan</th><td><?php echo htmlspecialchars($data['keluhan']); ?></td></tr>
    <tr><th>Keterangan</th><td><?php echo htmlspecialchars($data['keterangan']); ?></td></tr>
    <tr><th>Jumlah Istirahat</th><td><?php echo htmlspecialchars($data['jml_istirahat']); ?> hari</td></tr>
    <tr><th>Tanggal Mulai</th><td><?php echo htmlspecialchars($data['tgl_mulai']); ?></td></tr>
    <tr><th>Tanggal Selesai</th><td><?php echo htmlspecialchars($data['tgl_selesai']); ?></td></tr>
    <tr><th>Dokter</th><td><?php echo htmlspecialchars($data['nama_dokter']); ?></td></tr>
</table>

<div class="btn-container">
    <a href="riwayat_pendaftaran.php" class="btn-back">Kembali</a>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
