<?php
session_start();
include '../../database/koneksi.php';
$force_active_menu = 'dashboard';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
echo "Akses ditolak!";
exit;
}

$role = 'admin'; 

$page_title = "Tambah " . ucfirst($role);
$page_style = ['form_tambah_pengguna.css'];
$alias_page = 'dashboard.php'; 

include __DIR__ . '/../layout/header.php';
?>
<!-- added notification intentionally disabled for admin creation -->

<h2>Tambah Admin</h2>

<form action="../../controller/tambah_pengguna_proses.php" method="POST">
<input type="hidden" name="role" value="<?php echo $role; ?>">

Nama Admin:<br>
<input type="text" name="nama_admin" required><br><br>

Waktu Jaga:<br>
<input type="time" name="waktu_jaga" required><br><br>

PIN:<br>
<input type="text" id="password-admin" name="passwordadmin" maxlength="6" required><br>
<div class="pw-note" id="note-admin" style="color:#0b5;display:none;margin-top:6px;">PIN harus 6 digit angka</div>
<br>

<button type="submit">Simpan</button>
</form>

<a href="tambah_pengguna.php"><button>Kembali</button></a>

<script src="../../style/js/validasi_simpan_pengguna.js"></script>

<!-- toast element provided globally in layout/footer.php -->
<?php include __DIR__ . '/../layout/footer.php'; ?>