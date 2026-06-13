<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

$id_value = mysqli_real_escape_string($koneksi, $_POST['id_value'] ?? '');
$id_admin = mysqli_real_escape_string($koneksi, $_SESSION['data']['id_admin'] ?? '');

if ($id_value === '' || $id_admin === '') {
    exit;
}

$colsRes = mysqli_query($koneksi, "
    SELECT COLUMN_NAME 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'daftar'
");

$daftarCols = [];
while ($c = mysqli_fetch_assoc($colsRes)) {
    $daftarCols[] = $c['COLUMN_NAME'];
}

$idCol = null;
foreach (['id_pendaftaran','id_daftar','id','id_pend'] as $candidate) {
    if (in_array($candidate, $daftarCols)) {
        $idCol = $candidate;
        break;
    }
}

if (!$idCol) exit;

$qDaftar = mysqli_query(
    $koneksi,
    "SELECT id_pasien,id_dokter,id_spesialis,waktu_daftar,status_pendaftaran
     FROM daftar
     WHERE `$idCol`='$id_value'
     LIMIT 1"
);

if (!$qDaftar || mysqli_num_rows($qDaftar) === 0) exit;

$d = mysqli_fetch_assoc($qDaftar);
if ($d['status_pendaftaran'] !== 'pengecekan') {
    header('Location: ../view/admin/lihat_pendaftaran.php');
    exit;
}

mysqli_begin_transaction($koneksi);

try {

    mysqli_query($koneksi,"
        UPDATE daftar 
        SET status_pendaftaran='dikonfirmasi',
            id_admin='$id_admin'
        WHERE `$idCol`='$id_value'
        LIMIT 1
    ");

    // === TAMBAHAN: hitung antrian resmi ===
    $qSp = mysqli_query($koneksi,"
        SELECT nama_spesialis 
        FROM spesialis 
        WHERE id_spesialis='{$d['id_spesialis']}'
        LIMIT 1
    ");
    $sp = mysqli_fetch_assoc($qSp);
    $kode_spesialis = strtoupper(substr(trim($sp['nama_spesialis']),0,1));

    $qCount = mysqli_query($koneksi,"
        SELECT COUNT(*) AS total 
        FROM proses_pasien pp
        JOIN daftar df ON df.id_daftar = pp.id_daftar
        WHERE pp.id_spesialis='{$d['id_spesialis']}'
        AND df.status_pendaftaran!='selesai'
        FOR UPDATE
    ");
    $rowCount = mysqli_fetch_assoc($qCount);
    $urutan = ((int)$rowCount['total']) + 1;

    $no_antrian = $kode_spesialis.'-'.str_pad($urutan,3,'0',STR_PAD_LEFT);

    $qLast = mysqli_query($koneksi,"
        SELECT tgl_pemeriksaan 
        FROM proses_pasien 
        WHERE id_spesialis='{$d['id_spesialis']}'
        ORDER BY tgl_pemeriksaan DESC
        LIMIT 1
        FOR UPDATE
    ");

    if ($qLast && mysqli_num_rows($qLast) > 0) {
        $last = mysqli_fetch_assoc($qLast);
        $tgl_pemeriksaan = date('Y-m-d H:i:s', strtotime('+30 minutes', strtotime($last['tgl_pemeriksaan'])));
    } else {
        $tgl_pemeriksaan = $d['waktu_daftar'];
    }

    // === TAMBAHAN: INSERT proses_pasien RESMI ===
    mysqli_query($koneksi,"
        INSERT INTO proses_pasien
        (id_daftar,id_pasien,id_dokter,id_admin,id_spesialis,tgl_pemeriksaan,no_antrian)
        VALUES
        ('$id_value','{$d['id_pasien']}','{$d['id_dokter']}','$id_admin','{$d['id_spesialis']}','$tgl_pemeriksaan','$no_antrian')
    ");

    mysqli_commit($koneksi);
    header('Location: ../view/admin/lihat_pendaftaran.php?toast=confirmed');
    exit;

} catch (Throwable $e) {
    mysqli_rollback($koneksi);
    exit;
}
?>