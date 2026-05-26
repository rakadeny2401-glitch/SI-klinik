<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_daftar  = mysqli_real_escape_string($koneksi, $_POST['id_daftar'] ?? '');
$id_pasien  = mysqli_real_escape_string($koneksi, $_POST['id_pasien'] ?? '');
$id_dokter  = $_SESSION['data']['id_dokter'] ?? ($_POST['id_dokter'] ?? '');
$jenis_obat = mysqli_real_escape_string($koneksi, $_POST['jenis_obat'] ?? '');
$aksi       = $_POST['aksi'] ?? '';

if ($id_daftar === '' || $id_pasien === '' || $id_dokter === '') {
    echo "Data tidak lengkap.";
    exit;
}

$q = mysqli_query($koneksi, "SELECT id_proses 
                             FROM proses_pasien 
                             WHERE id_daftar='$id_daftar' AND id_dokter='$id_dokter' 
                             ORDER BY id_proses DESC LIMIT 1");
if (!$q) {
    echo "Query gagal: " . mysqli_error($koneksi);
    exit;
}
$proses   = mysqli_fetch_assoc($q);
$id_proses = $proses['id_proses'] ?? null;

if ($aksi === 'simpan') {
    if ($jenis_obat === '') {
        echo "Jenis obat tidak boleh kosong.";
        exit;
    }

    // buat query insert dengan id_proses NULL jika tidak ada
    if ($id_proses === null || $id_proses === '') {
        $sql = "INSERT INTO resep_obat (id_daftar,id_pasien,id_dokter,jenis_obat,id_proses) 
                VALUES ('$id_daftar','$id_pasien','$id_dokter','$jenis_obat',NULL)";
    } else {
        $id_proses = (int)$id_proses; // pastikan integer
        $sql = "INSERT INTO resep_obat (id_daftar,id_pasien,id_dokter,jenis_obat,id_proses) 
                VALUES ('$id_daftar','$id_pasien','$id_dokter','$jenis_obat','$id_proses')";
    }

    if (mysqli_query($koneksi, $sql)) {
        $update = mysqli_query($koneksi, "UPDATE daftar SET status_pendaftaran='selesai' WHERE id_daftar='$id_daftar'");
        if (!$update) {
            echo "Gagal update status: " . mysqli_error($koneksi);
            exit;
        }
        header("Location: ../view/dokter/pertanyaan_surat.php?id_daftar=$id_daftar&id_pasien=$id_pasien&toast=resep_saved");
        exit;
    } else {
        echo "Gagal simpan resep: " . mysqli_error($koneksi);
    }

} elseif ($aksi === 'lewati') {
    $update = mysqli_query($koneksi, "UPDATE daftar SET status_pendaftaran='selesai' WHERE id_daftar='$id_daftar'");
    if (!$update) {
        echo "Gagal update status: " . mysqli_error($koneksi);
        exit;
    }
    header("Location: ../view/dokter/daftar_pasien.php?toast=lewati");
    exit;

} else {
    echo "Aksi tidak dikenali.";
}
?>