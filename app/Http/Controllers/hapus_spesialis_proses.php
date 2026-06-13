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

$id = isset($_POST['id_spesialis']) ? mysqli_real_escape_string($koneksi, $_POST['id_spesialis']) : '';
if ($id === '') {
    echo "ID spesialis diperlukan.";
    exit;
}

$chk = mysqli_query($koneksi, "SELECT 1 FROM dokter WHERE id_spesialis='$id' LIMIT 1");
if ($chk && mysqli_num_rows($chk) > 0) {
    header("Location: ../view/admin/spesialis.php?status=blocked");
    exit;
}

$sql = "DELETE FROM spesialis WHERE id_spesialis='$id' LIMIT 1";
if (mysqli_query($koneksi, $sql)) {
    if (mysqli_affected_rows($koneksi) > 0) {
        header("Location: ../view/admin/spesialis.php?status=deleted");
        exit;
    } else {
        echo "Spesialis tidak ditemukan atau sudah dihapus.";
    }
} else {
    echo "Gagal menghapus spesialis: " . mysqli_error($koneksi);
}
?>