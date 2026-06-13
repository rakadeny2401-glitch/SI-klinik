<?php
session_start();
require_once "../database/koneksi.php";

$nama = $_POST['nama'];
$password = $_POST['password'];

$query_admin  = "SELECT * FROM admin WHERE nama_admin='$nama' AND passwordadmin='$password'";
$query_dokter = "SELECT * FROM dokter WHERE nama_dokter='$nama' AND passworddok='$password'";
$query_pasien = "SELECT * FROM pasien WHERE nama_pasien='$nama' AND password='$password'";

$result_admin  = $koneksi->query($query_admin);
$result_dokter = $koneksi->query($query_dokter);
$result_pasien = $koneksi->query($query_pasien);

if ($result_admin->num_rows > 0) {
    $_SESSION['role'] = "admin";
    $_SESSION['data'] = $result_admin->fetch_assoc();
    header("Location: ../view/admin/dashboard.php");
    exit;
}

if ($result_dokter->num_rows > 0) {
    $_SESSION['role'] = "dokter";
    $_SESSION['data'] = $result_dokter->fetch_assoc();
    header("Location: ../view/dokter/dashboard.php");
    exit;
}

if ($result_pasien->num_rows > 0) {
    $_SESSION['role'] = "pasien";
    $_SESSION['data'] = $result_pasien->fetch_assoc();
    header("Location: ../view/pasien/dashboard.php");
    exit;
}

echo "<script>
        alert('Akun tidak ditemukan!');
        window.location.href='../view/login/login_nama.php';
      </script>";
exit;
?>
