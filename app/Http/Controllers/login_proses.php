<?php
session_start();
include '../database/koneksi.php'; 

$no = $_POST['no_identitas'];
$no = mysqli_real_escape_string($koneksi, $no);

$sql_admin = "SELECT * FROM admin WHERE no_identitas = '$no'";
$admin = mysqli_query($koneksi, $sql_admin);

$sql_dokter = "SELECT * FROM dokter WHERE no_identitas = '$no'";
$dokter = mysqli_query($koneksi, $sql_dokter);

$sql_pasien = "SELECT * FROM pasien WHERE no_identitas = '$no'";
$pasien = mysqli_query($koneksi, $sql_pasien);

if(mysqli_num_rows($admin) > 0){
    $_SESSION['role'] = 'admin';
    $_SESSION['data'] = mysqli_fetch_assoc($admin);
    header("Location: ../view/admin/dashboard.php");
    exit;
}

if(mysqli_num_rows($dokter) > 0){
    $_SESSION['role'] = 'dokter';
    $_SESSION['data'] = mysqli_fetch_assoc($dokter);
    header("Location: ../view/dokter/dashboard.php");
    exit;
}

if(mysqli_num_rows($pasien) > 0){
    $_SESSION['role'] = 'pasien';
    $_SESSION['data'] = mysqli_fetch_assoc($pasien);
    header("Location: ../view/pasien/dashboard.php");
    exit;
}

echo "<script>
        alert('Nomor identitas tidak ditemukan!');
        window.location.href='../index.php';
      </script>";
?>
