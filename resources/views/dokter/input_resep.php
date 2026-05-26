<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_daftar = mysqli_real_escape_string($koneksi, $_GET['id_daftar'] ?? '');
$id_dokter = $_SESSION['data']['id_dokter'] ?? '';

if ($id_daftar === '' || $id_dokter === '') {
    echo "Data tidak lengkap.";
    exit;
}

$page_title = "Input Resep Obat";
$page_style = ["../../style/css/form_resep.css"];
$force_active_menu = 'daftar_pasien.php';

include __DIR__ . '/../layout/header.php';

$q = mysqli_query($koneksi, "SELECT id_pasien, nama_pasien, umur, keluhan FROM daftar WHERE id_daftar='$id_daftar' AND id_dokter='$id_dokter' LIMIT 1");
$pasien = mysqli_fetch_assoc($q);

if (!$pasien) {
    echo "Data pasien tidak ditemukan.";
    include __DIR__ . '/../layout/footer.php';
    exit;
}
?>

<div class="form-container">
    <h2>Input Resep Obat</h2>

    <form action="../../controller/input_resep_proses.php" method="POST">
        
        <div class="section-box">
            <h3>Data Pasien</h3>
            <p><strong>Nama:</strong> <?= htmlspecialchars($pasien['nama_pasien']); ?></p>
            <p><strong>Umur:</strong> <?= htmlspecialchars($pasien['umur']); ?> tahun</p>
            <p><strong>Keluhan:</strong> <?= htmlspecialchars($pasien['keluhan']); ?></p>
        </div>

        <div class="section-box">
            <h3>Resep Obat</h3>
            <div class="form-group">
                <label for="jenis_obat">Jenis Obat</label>
                <textarea id="jenis_obat" name="jenis_obat" rows="4"></textarea>
            </div>
        </div>

        <input type="hidden" name="id_daftar" value="<?= $id_daftar; ?>">
        <input type="hidden" name="id_pasien" value="<?= $pasien['id_pasien']; ?>">
        <input type="hidden" name="id_dokter" value="<?= $id_dokter; ?>">

        <button type="submit" name="aksi" value="simpan" class="btn-submit">Simpan Resep</button>
    </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
