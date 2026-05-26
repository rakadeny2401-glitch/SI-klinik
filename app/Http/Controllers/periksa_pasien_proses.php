<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_daftar = mysqli_real_escape_string($koneksi, $_POST['id_daftar'] ?? '');
$id_dokter = $_SESSION['data']['id_dokter'] ?? '';

if ($id_daftar === '' || $id_dokter === '') {
    echo "Data tidak lengkap.";
    exit;
}

$q = mysqli_query($koneksi, "
    SELECT d.id_pasien, d.id_spesialis, d.id_admin 
    FROM daftar d 
    WHERE d.id_daftar='$id_daftar' 
    LIMIT 1
");

if (!$q) {
    echo "Query gagal: " . mysqli_error($koneksi);
    exit;
}

$data = mysqli_fetch_assoc($q);
if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

$id_pasien    = $data['id_pasien'];
$id_spesialis = $data['id_spesialis'];
$id_admin     = $data['id_admin'];

$update = mysqli_query(
    $koneksi,
    "UPDATE daftar SET status_pendaftaran='pemeriksaan' WHERE id_daftar='$id_daftar'"
);

if (!$update) {
    echo "Gagal update status: " . mysqli_error($koneksi);
    exit;
}

header("Location: ../view/dokter/input_resep.php?id_daftar=$id_daftar&id_pasien=$id_pasien");
exit;
?>