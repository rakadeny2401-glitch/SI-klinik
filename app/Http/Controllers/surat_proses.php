<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_daftar    = mysqli_real_escape_string($koneksi, $_POST['id_daftar'] ?? '');
$id_pasien    = mysqli_real_escape_string($koneksi, $_POST['id_pasien'] ?? '');
$id_dokter    = mysqli_real_escape_string($koneksi, $_POST['id_dokter'] ?? '');
$id_proses    = $_POST['id_proses'] ?? null;   
$rekomendasi  = mysqli_real_escape_string($koneksi, $_POST['rekomendasi'] ?? '');
$aksi         = $_POST['aksi'] ?? '';

if ($id_daftar === '' || $id_pasien === '' || $id_dokter === '' || $rekomendasi === '') {
    echo "Data tidak lengkap.";
    exit;
}

if ($aksi === 'simpan_rujukan' || $aksi === 'simpan_sakit') {
    if ($id_proses === null || $id_proses === '') {
        $sql = "INSERT INTO srt_rkrmdsi_rujukan 
                (id_daftar,id_pasien,id_dokter,rekomendasi,id_proses)
                VALUES ('$id_daftar','$id_pasien','$id_dokter','$rekomendasi',NULL)";
    } else {
        $id_proses = (int)$id_proses; 
        $sql = "INSERT INTO srt_rkrmdsi_rujukan 
                (id_daftar,id_pasien,id_dokter,rekomendasi,id_proses)
                VALUES ('$id_daftar','$id_pasien','$id_dokter','$rekomendasi','$id_proses')";
    }

    if (mysqli_query($koneksi, $sql)) {
        mysqli_query($koneksi, "UPDATE daftar SET status_pendaftaran='selesai' WHERE id_daftar='$id_daftar'");
        $toastCode = ($aksi === 'simpan_rujukan') ? 'surat_rujukan_added' : (($aksi === 'simpan_sakit') ? 'surat_sakit_added' : '');
        $location = "../view/dokter/pertanyaan_surat.php?id_daftar=$id_daftar&id_pasien=$id_pasien";
        if ($toastCode !== '') $location .= "&toast=$toastCode";
        header("Location: $location");
        exit;
    } else {
        echo "Gagal simpan surat: " . mysqli_error($koneksi);
    }
} else {
    echo "Aksi tidak dikenali.";
}