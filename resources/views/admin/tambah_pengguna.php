<?php 
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
 echo "Akses ditolak!";
 exit;
}

$force_active_menu = 'dashboard';
$page_title = "Tambah Pengguna";
$page_style = ['tambah_pengguna.css'];
include __DIR__ . '/../layout/header.php';
?>

<h2>Tambah Pengguna</h2>

<div class="tambah-wrapper">

 <a href="tambah_pasien.php">
  <button type="button" class="btn-tambah">Tambah Pasien</button>
 </a>

 <a href="tambah_admin.php">
  <button type="button" class="btn-tambah">Tambah Admin</button>
 </a>

 <a href="tambah_dokter.php">
  <button type="button" class="btn-tambah">Tambah Dokter</button>
 </a>

</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>