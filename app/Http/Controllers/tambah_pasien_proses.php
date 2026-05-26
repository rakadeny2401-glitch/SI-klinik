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

$nik = mysqli_real_escape_string($koneksi, $_POST['nik'] ?? '');
$nama_pasien = mysqli_real_escape_string($koneksi, $_POST['nama_pasien'] ?? '');
$alamat_pasien = mysqli_real_escape_string($koneksi, $_POST['alamat_pasien'] ?? '');
$umur = mysqli_real_escape_string($koneksi, $_POST['umur'] ?? '');
$jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin'] ?? '');
$no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp'] ?? '');

$password_raw = preg_replace('/\D/', '', trim($_POST['password'] ?? ''));

if (!preg_match('/^\d{16}$/', $nik)) {
echo "NIK harus 16 digit angka.";
exit;
}
$nik_check = mysqli_query($koneksi, "SELECT 1 FROM pasien WHERE nik='$nik' LIMIT 1");
if ($nik_check && mysqli_num_rows($nik_check) > 0) {
echo "NIK sudah terdaftar.";
exit;
}

do {
$no_identitas = generate_unique_no_identitas($koneksi);
} while ($no_identitas === $nik);

if (!preg_match('/^\d{6}$/', $password_raw)) {
echo "PIN harus 6 digit angka.";
exit;
}
$password_to_save = $password_raw;

if (empty($nik) || empty($nama_pasien) || empty($no_hp) || empty($password_to_save) || empty($jenis_kelamin)) {
echo "Lengkapi semua field pasien yang wajib diisi.";
exit;
}

if (!preg_match('/^\d+$/', $umur)) { echo "Umur harus angka."; exit; }
if (!preg_match('/^\d+$/', $no_hp)) { echo "No HP harus angka."; exit; }

$id_akses = get_id_akses($koneksi, 'pasien');
if ($id_akses === false) {
echo "Hak akses untuk role 'pasien' tidak ditemukan. Mohon periksa tabel hak_akses.";
exit;
}

$query = "INSERT INTO pasien (nik, no_identitas, nama_pasien, alamat_pasien, umur, jenis_kelamin, no_hp, password, id_akses)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'ssssssssi', $nik, $no_identitas, $nama_pasien, $alamat_pasien, $umur, $jenis_kelamin, $no_hp, $password_to_save, $id_akses);

if (mysqli_stmt_execute($stmt)) {
header("Location: ../view/admin/lihat_pengguna.php?status=added&role=pasien");
exit;
} else {
echo "Gagal menambah pasien: " . mysqli_error($koneksi);
}
} else {
echo "Akses tidak sah.";
}
?>