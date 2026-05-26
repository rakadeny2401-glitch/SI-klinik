<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}
?>

<?php
$force_active_menu = 'dashboard';
$page_style = ['tambah_spesialis.css'];
$page_title = 'Tambah Spesialis';
include __DIR__ . '/../layout/header.php';
?>

<h2>Tambah Spesialis Baru</h2>

<div class="form-card">
    <form method="POST" action="../../controller/tambah_spesialis_proses.php">

        <label>Nama Spesialis</label>
        <input type="text" name="nama_spesialis" required>

        <button type="submit" class="btn-submit">Simpan</button>
        <button type="button" class="btn-back" onclick="window.location.href='dashboard.php'">
            Kembali
        </button>

    </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
