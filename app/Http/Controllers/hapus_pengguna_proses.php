<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Akses tidak sah.";
    exit;
}

$role = isset($_POST['role']) ? $_POST['role'] : '';
$id   = isset($_POST['id']) ? $_POST['id'] : '';

$role = mysqli_real_escape_string($koneksi, $role);
$id   = mysqli_real_escape_string($koneksi, $id);

if ($role === 'pasien') {
    $table = 'pasien';
    $idcol = 'id_pasien';
} elseif ($role === 'admin') {
    $table = 'admin';
    $idcol = 'id_admin';
} elseif ($role === 'dokter') {
    $table = 'dokter';
    $idcol = 'id_dokter';
} else {
    echo "Role tidak valid.";
    exit;
}

$sql = "DELETE FROM $table WHERE $idcol='$id' LIMIT 1";
if (mysqli_query($koneksi, $sql)) {
    if (mysqli_affected_rows($koneksi) > 0) {
        header("Location: ../view/admin/lihat_pengguna.php?status=deleted");
        exit;
    } else {
        echo "Pengguna tidak ditemukan atau sudah dihapus.";
    }
} else {
    echo "Gagal menghapus pengguna: " . mysqli_error($koneksi);
}

?>
