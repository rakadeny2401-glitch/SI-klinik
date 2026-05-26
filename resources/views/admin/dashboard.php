<?php
session_start();
include '../../database/koneksi.php';

$force_active_menu = 'dashboard';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak! Silakan login terlebih dahulu.";
    exit;
}

$nama = $_SESSION['data']['nama_admin'];
?>

<?php
$page_style = ['dashboard_admin.css'];
$page_title = 'Dashboard Admin';
include __DIR__ . '/../layout/header.php';
?>
<!-- added notification intentionally disabled on dashboard -->

<h2>Selamat Datang di Puskesmas<br><?php echo $nama; ?></h2>

<section class="dashboard-cards">
    <div class="dashboard-grid">
        <a class="dashboard-card" href="/puskesmas/view/admin/tambah_pengguna.php">
            <div class="card-icon">👥</div>
            <div class="card-body">
                <div class="card-title">Tambah Pengguna</div>
                <div class="card-desc">Buat akun admin atau petugas baru</div>
            </div>
        </a>
        <a class="dashboard-card" href="/puskesmas/view/admin/tambah_spesialis.php">
            <div class="card-icon">🩺</div>
            <div class="card-body">
                <div class="card-title">Tambah Spesialis</div>
                <div class="card-desc">Kelola bidang spesialis dokter</div>
            </div>
        </a>
    </div>
</section>

<!-- toast element provided globally in layout/footer.php -->

<?php include __DIR__ . '/../layout/footer.php'; ?>
