<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_daftar = $_GET['id_daftar'] ?? '';

if ($id_daftar === '') {
    echo "ID daftar tidak ditemukan.";
    exit;
}

mysqli_query($koneksi, "UPDATE daftar SET status_pendaftaran='selesai' WHERE id_daftar='$id_daftar'");

header("Location: ../view/dokter/daftar_pasien.php?toast=lewati");
exit;
?>