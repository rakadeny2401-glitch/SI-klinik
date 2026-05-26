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

$nama = isset($_POST['nama_spesialis']) ? trim($_POST['nama_spesialis']) : '';
$nama = mysqli_real_escape_string($koneksi, $nama);

if ($nama === '') {
    echo "Nama spesialis tidak boleh kosong.";
    exit;
}

$chk = mysqli_query($koneksi, "SELECT 1 FROM spesialis WHERE LOWER(nama_spesialis)=LOWER('$nama') LIMIT 1");
if ($chk && mysqli_num_rows($chk) > 0) {
    echo "Spesialis dengan nama tersebut sudah ada.";
    exit;
}

$sql = "INSERT INTO spesialis (nama_spesialis) VALUES ('$nama')";
if (mysqli_query($koneksi, $sql)) {
    header("Location: /puskesmas/view/admin/spesialis.php?status=added");
    exit;
} else {
    echo "Gagal menambah spesialis: " . mysqli_error($koneksi);
}
?>