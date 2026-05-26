<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_daftar     = mysqli_real_escape_string($koneksi, $_POST['id_daftar'] ?? '');
$id_pasien     = mysqli_real_escape_string($koneksi, $_POST['id_pasien'] ?? '');
$id_dokter     = mysqli_real_escape_string($koneksi, $_POST['id_dokter'] ?? '');
$id_proses     = $_POST['id_proses'] ?? null;
$keterangan    = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');
$jml_istirahat = (int)($_POST['jml_istirahat'] ?? 0);
$tgl_mulai     = mysqli_real_escape_string($koneksi, $_POST['tgl_mulai'] ?? '');
$tgl_selesai   = mysqli_real_escape_string($koneksi, $_POST['tgl_selesai'] ?? '');
$aksi          = $_POST['aksi'] ?? '';

if ($id_daftar === '' || $id_pasien === '' || $id_dokter === '' || $keterangan === '' || $jml_istirahat <= 0 || $tgl_mulai === '' || $tgl_selesai === '') {
    echo "Data tidak lengkap.";
    exit;
}

if ($aksi === 'simpan_sakit') {
    if ($id_proses === null || $id_proses === '') {
        $sql = "INSERT INTO surat_ktrgnsakit (id_daftar,id_pasien,id_dokter,keterangan,jml_istirahat,tgl_mulai,tgl_selesai,id_proses)
                VALUES ('$id_daftar','$id_pasien','$id_dokter','$keterangan','$jml_istirahat','$tgl_mulai','$tgl_selesai',NULL)";
    } else {
        $id_proses = (int)$id_proses;
        $sql = "INSERT INTO surat_ktrgnsakit (id_daftar,id_pasien,id_dokter,keterangan,jml_istirahat,tgl_mulai,tgl_selesai,id_proses)
                VALUES ('$id_daftar','$id_pasien','$id_dokter','$keterangan','$jml_istirahat','$tgl_mulai','$tgl_selesai','$id_proses')";
    }

    if (mysqli_query($koneksi, $sql)) {
        mysqli_query($koneksi, "UPDATE daftar SET status_pendaftaran='selesai' WHERE id_daftar='$id_daftar'");
        header("Location: ../view/dokter/daftar_pasien.php?toast=surat_sakit_added");
        exit;
    } else {
        echo "Gagal simpan surat sakit: " . mysqli_error($koneksi);
    }
} else {
    echo "Aksi tidak dikenali.";
}