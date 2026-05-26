<?php
session_start();
include '../../database/koneksi.php';
$force_active_menu = 'dashboard';

$querySpesialis = mysqli_query($koneksi, "SELECT * FROM spesialis");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
echo "Akses ditolak!";
exit;
}

$role = 'dokter'; 

$page_title = "Tambah " . ucfirst($role);
$page_style = ['form_tambah_pengguna.css'];
$alias_page = 'dashboard.php'; 

include __DIR__ . '/../layout/header.php';
?>
<!-- added notification intentionally disabled for dokter creation -->

<h2>Tambah Dokter</h2>

<form action="../../controller/tambah_dokter_proses.php" method="POST">
<input type="hidden" name="role" value="<?php echo $role; ?>">

Nama Dokter:<br>
<input type="text" name="nama_dokter" required><br><br>

No HP Dokter:<br>
<input type="text" name="no_hp_dokter" inputmode="numeric" pattern="\d*" required><br><br>

Alamat Dokter:<br>
<textarea name="alamat_dokter" required></textarea><br><br>

Tanggal Lahir:<br>
<input type="date" name="tgl_lahir_dokter" required><br><br>

Waktu Kerja:<br>
<input type="time" name="waktu_kerja" required><br><br>

Spesialis :<br>
<select name="id_spesialis" required>
<option value="">-- Pilih Spesialis --</option>
<?php while ($sp = mysqli_fetch_assoc($querySpesialis)) { ?>
<option value="<?php echo $sp['id_spesialis']; ?>">
 <?php echo $sp['nama_spesialis']; ?>
</option>
<?php } ?>
</select>
<br><br>

PIN:<br>
<input type="text" id="password-dokter" name="passworddok" maxlength="6" required><br>
<div class="pw-note" id="note-dokter" style="color:#0b5;display:none;margin-top:6px;">PIN harus 6 digit angka</div>
<br>

<button type="submit">Simpan</button>
</form>

<a href="tambah_pengguna.php"><button>Kembali</button></a>

<script src="../../style/js/validasi_simpan_pengguna.js"></script>

<!-- toast element provided globally in layout/footer.php -->
<?php include __DIR__ . '/../layout/footer.php'; ?>