<?php
session_start();
include '../../database/koneksi.php';
$force_active_menu = 'dashboard';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
echo "Akses ditolak!";
exit;
}

$role = 'pasien'; 

$page_title = "Tambah " . ucfirst($role);
$page_style = ['form_tambah_pengguna.css'];
$alias_page = 'dashboard.php'; 

include __DIR__ . '/../layout/header.php';
?>
<!-- added notification intentionally disabled for pasien creation -->

<h2>Tambah Pasien</h2>

<form action="../../controller/tambah_pasien_proses.php" method="POST">
<input type="hidden" name="role" value="<?php echo $role; ?>">

NIK:<br>
<input type="text" name="nik" maxlength="16" required><br><br>

Nama Pasien:<br>
<input type="text" name="nama_pasien" required><br><br>

Alamat:<br>
<textarea name="alamat_pasien" required></textarea><br><br>

Umur:<br>
<input type="text" name="umur" inputmode="numeric" pattern="\d*" required><br><br>

Jenis Kelamin:<br>
<label><input type="radio" name="jenis_kelamin" value="L" required> Laki-laki</label>
<label><input type="radio" name="jenis_kelamin" value="P"> Perempuan</label>
<br><br>

No HP:<br>
<input type="text" name="no_hp" inputmode="numeric" pattern="\d*" required><br><br>

PIN:<br>
<input type="text" id="password-pasien" name="password" maxlength="6" required><br>
<div class="pw-note" id="note-pasien" style="color:#0b5;display:none;margin-top:6px;">PIN harus 6 digit angka</div>
<br>

<button type="submit">Simpan</button>
</form>

<a href="tambah_pengguna.php"><button>Kembali</button></a>

<script src="../../style/js/validasi_simpan_pengguna.js"></script>

<!-- toast element provided globally in layout/footer.php -->
<?php include __DIR__ . '/../layout/footer.php'; ?>