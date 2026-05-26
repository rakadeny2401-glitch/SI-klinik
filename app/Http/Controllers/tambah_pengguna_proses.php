<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
echo "Akses ditolak!";
exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

function generate_unique_no_identitas($koneksi) {
$tries = 0;
do {
$no_identitas = '';
for ($i = 0; $i < 16; $i++) {
$no_identitas .= random_int(0, 9);
}
$no_identitas_esc = mysqli_real_escape_string($koneksi, $no_identitas);
$check_sql = "SELECT 1 FROM pasien WHERE no_identitas='$no_identitas_esc' UNION SELECT 1 FROM admin WHERE no_identitas='$no_identitas_esc' UNION SELECT 1 FROM dokter WHERE no_identitas='$no_identitas_esc' LIMIT 1";
$res = mysqli_query($koneksi, $check_sql);
$exists = $res && mysqli_num_rows($res) > 0;
$tries++;
} while ($exists && $tries < 50);
return $no_identitas;
}

function get_id_akses($koneksi, $role) {
$role_esc = mysqli_real_escape_string($koneksi, trim($role));
if ($role_esc === '') return false;
$sql = "SELECT id_akses FROM hak_akses WHERE LOWER(nama_akses) = LOWER('$role_esc') LIMIT 1";
$res = mysqli_query($koneksi, $sql);
if ($res && mysqli_num_rows($res) > 0) {
$row = mysqli_fetch_assoc($res);
return (int) $row['id_akses'];
}
return false;
}

$nama_admin = mysqli_real_escape_string($koneksi, $_POST['nama_admin'] ?? '');
$waktu_jaga = mysqli_real_escape_string($koneksi, $_POST['waktu_jaga'] ?? '');

$password_raw = preg_replace('/\D/', '', trim($_POST['passwordadmin'] ?? ''));

if (!preg_match('/^\d{6}$/', $password_raw)) {
echo "PIN admin harus 6 digit angka.";
exit;
}
$password_to_save = $password_raw;

if (empty($nama_admin) || empty($password_to_save)) {
echo "Lengkapi semua field admin yang wajib diisi.";
exit;
}

$id_akses = get_id_akses($koneksi, 'admin');
if ($id_akses === false) {
echo "Hak akses untuk role 'admin' tidak ditemukan. Mohon periksa tabel hak_akses.";
exit;
}

$no_identitas = generate_unique_no_identitas($koneksi);
$query = "INSERT INTO admin (nama_admin, waktu_jaga, passwordadmin, id_akses, no_identitas)
VALUES (?, ?, ?, ?, ?)";

 $stmt = mysqli_prepare($koneksi, $query);
 mysqli_stmt_bind_param($stmt, 'sssis', $nama_admin, $waktu_jaga, $password_to_save, $id_akses, $no_identitas);

if (mysqli_stmt_execute($stmt)) {
header("Location: ../view/admin/lihat_pengguna.php?status=added&role=admin");
exit;
} else {
echo "Gagal menambah admin: " . mysqli_error($koneksi);
}

} else {
echo "Akses tidak sah.";
}
?>