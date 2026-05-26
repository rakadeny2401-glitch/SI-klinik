<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../view/admin/pendaftaran_form.php?toast=akses_ditolak");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/admin/pendaftaran_form.php?toast=invalid_method");
    exit;
}

$id_pasien = mysqli_real_escape_string($koneksi, $_POST['id_pasien'] ?? '');
$id_spesialis = mysqli_real_escape_string($koneksi, $_POST['id_spesialis'] ?? '');
$id_dokter = mysqli_real_escape_string($koneksi, $_POST['id_dokter'] ?? '');
$keluhan = mysqli_real_escape_string($koneksi, $_POST['keluhan'] ?? '');
$id_admin_value = mysqli_real_escape_string($koneksi, $_POST['id_admin_value'] ?? '');
$waktu_daftar_post = trim($_POST['waktu_daftar'] ?? '');

if (empty($id_spesialis) || empty($id_dokter) || empty($keluhan) || empty($id_admin_value) || empty($waktu_daftar_post)) {
    header("Location: ../view/admin/pendaftaran_form.php?toast=field_kosong");
    exit;
}

if ($id_pasien !== '') {
    $cekAktif = mysqli_query(
        $koneksi,
        "SELECT 1 FROM daftar 
         WHERE id_pasien = '$id_pasien'
         AND status_pendaftaran != 'selesai'
         LIMIT 1"
    );

    if ($cekAktif && mysqli_num_rows($cekAktif) > 0) {
        header("Location: ../view/admin/pendaftaran_form.php?toast=aktif");
        exit;
    }
}

$use_patient_from_db = false;

if ($id_pasien !== '') {
    $chkPasien = mysqli_query($koneksi, "SELECT 1 FROM pasien WHERE id_pasien='$id_pasien' LIMIT 1");
    if (!$chkPasien || mysqli_num_rows($chkPasien) === 0) {
        header("Location: ../view/admin/pendaftaran_form.php?toast=pasien_notfound");
        exit;
    }
    $use_patient_from_db = true;
}

$chkDokter = mysqli_query($koneksi, "SELECT 1 FROM dokter WHERE id_dokter='$id_dokter' AND id_spesialis='$id_spesialis' LIMIT 1");
if (!$chkDokter || mysqli_num_rows($chkDokter) === 0) {
    header("Location: ../view/admin/pendaftaran_form.php?toast=dokter_invalid");
    exit;
}

if (!preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $waktu_daftar_post)) {
    header("Location: ../view/admin/pendaftaran_form.php?toast=waktu_invalid");
    exit;
}

$time_part = substr($waktu_daftar_post, 0, 5);
$waktu_daftar = date('Y-m-d') . " " . $time_part . ":00";

$status_pendaftaran = 'dikonfirmasi';

$create_sql = "CREATE TABLE IF NOT EXISTS daftar (
    id_daftar INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_pasien INT UNSIGNED DEFAULT NULL,
    id_spesialis INT UNSIGNED NOT NULL,
    id_dokter INT UNSIGNED NOT NULL,
    id_admin INT UNSIGNED NOT NULL,
    nama_pasien VARCHAR(255) DEFAULT NULL,
    alamat_pasien TEXT,
    jenis_kelamin CHAR(1) DEFAULT NULL,
    umur VARCHAR(10) DEFAULT NULL,
    nik VARCHAR(32) DEFAULT NULL,
    keluhan TEXT,
    waktu_daftar DATETIME DEFAULT NULL,
    status_pendaftaran ENUM('pengecekan','dikonfirmasi','pemeriksaan','selesai') DEFAULT 'pengecekan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

mysqli_query($koneksi, $create_sql);

$dokRes = mysqli_query(
    $koneksi,
    "SELECT id_dokter, waktu_kerja, waktu_pulang 
     FROM dokter 
     WHERE id_spesialis='$id_spesialis'"
);

if (!$dokRes || mysqli_num_rows($dokRes) === 0) {
    header("Location: ../view/admin/pendaftaran_form.php?toast=dokter_notfound");
    exit;
}

$dokter_terpilih = null;
while ($dokRow = mysqli_fetch_assoc($dokRes)) {
    $jam_mulai  = !empty($dokRow['waktu_kerja']) ? date('H:i', strtotime($dokRow['waktu_kerja'])) : '';
    $jam_pulang = !empty($dokRow['waktu_pulang']) ? date('H:i', strtotime($dokRow['waktu_pulang'])) : '';

    if ($jam_mulai !== '' && $jam_pulang !== '') {
        if ($time_part >= $jam_mulai && $time_part < $jam_pulang) {
            $dokter_terpilih = $dokRow['id_dokter'];
            break;
        }
    }
}

if ($dokter_terpilih === null) {
    header("Location: ../view/admin/pendaftaran_form.php?toast=jadwal_tidak_sesuai");
    exit;
}

$id_dokter = mysqli_real_escape_string($koneksi, $dokter_terpilih);

if ($use_patient_from_db) {
    $sql = "INSERT INTO daftar (
                id_pasien, id_spesialis, id_dokter, id_admin, 
                nama_pasien, alamat_pasien, jenis_kelamin, umur, nik, 
                keluhan, waktu_daftar, status_pendaftaran
            )
            SELECT p.id_pasien, '$id_spesialis', '$id_dokter', '$id_admin_value',
                   p.nama_pasien, p.alamat_pasien, p.jenis_kelamin, p.umur, p.nik,
                   '$keluhan', '$waktu_daftar', '$status_pendaftaran'
            FROM pasien p
            WHERE p.id_pasien='$id_pasien'
            LIMIT 1";
} else {
    $nama_pasien_post   = mysqli_real_escape_string($koneksi, $_POST['nama_pasien'] ?? '');
    $alamat_pasien_post = mysqli_real_escape_string($koneksi, $_POST['alamat_pasien'] ?? '');
    $jenis_kelamin_post = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin'] ?? '');
    $umur_post          = mysqli_real_escape_string($koneksi, $_POST['umur'] ?? '');
    $nik_manual         = mysqli_real_escape_string($koneksi, $_POST['nik_manual'] ?? '');

    if ($nama_pasien_post === '') {
        header("Location: ../view/admin/pendaftaran_form.php?toast=nama_kosong");
        exit;
    }
    if ($umur_post !== '' && !preg_match('/^\d+$/', $umur_post)) {
        header("Location: ../view/admin/pendaftaran_form.php?toast=umur_invalid");
        exit;
    }
    if ($nik_manual !== '' && !preg_match('/^\d{16}$/', $nik_manual)) {
        header("Location: ../view/admin/pendaftaran_form.php?toast=nik_invalid");
        exit;
    }

    $sql = "INSERT INTO daftar (
                id_pasien, id_spesialis, id_dokter, id_admin, 
                nama_pasien, alamat_pasien, jenis_kelamin, umur, nik, 
                keluhan, waktu_daftar, status_pendaftaran
            )
            VALUES (
                NULL, '$id_spesialis', '$id_dokter', '$id_admin_value',
                '$nama_pasien_post', '$alamat_pasien_post', '$jenis_kelamin_post', '$umur_post', '$nik_manual',
                '$keluhan', '$waktu_daftar', '$status_pendaftaran'
            )";
}

if (mysqli_query($koneksi, $sql)) {
$id_daftar_baru = mysqli_insert_id($koneksi);

mysqli_begin_transaction($koneksi);

try {
    $qSp = mysqli_query($koneksi, "SELECT nama_spesialis FROM spesialis WHERE id_spesialis='$id_spesialis' LIMIT 1");
    $sp = mysqli_fetch_assoc($qSp);
    $kode_spesialis = strtoupper(substr(trim($sp['nama_spesialis']),0,1));

    $qCountAktif = mysqli_query($koneksi, "
    SELECT COUNT(*) AS aktif 
    FROM proses_pasien pp
    JOIN daftar d ON d.id_daftar = pp.id_daftar
    WHERE pp.id_spesialis = '$id_spesialis'
    AND d.status_pendaftaran != 'selesai'
    FOR UPDATE
    ");

    $rowAktif = mysqli_fetch_assoc($qCountAktif);
    $jumlahAktif = (int)$rowAktif['aktif'];

    if ($jumlahAktif === 0) {
        $urutan = 1;
        $tgl_pemeriksaan = $waktu_daftar;
    } else {
        $urutan = $jumlahAktif + 1;

        $qLast = mysqli_query($koneksi, "
        SELECT tgl_pemeriksaan 
        FROM proses_pasien pp
        JOIN daftar d ON d.id_daftar = pp.id_daftar
        WHERE pp.id_spesialis = '$id_spesialis'
        AND d.status_pendaftaran != 'selesai'
        ORDER BY tgl_pemeriksaan DESC
        LIMIT 1 FOR UPDATE
    ");

    $last = mysqli_fetch_assoc($qLast);

    $last_time = strtotime($last['tgl_pemeriksaan']);
    $now_time  = strtotime($waktu_daftar);

    if ($last_time >= $now_time) {
        $tgl_pemeriksaan = date('Y-m-d H:i:s', strtotime("+30 minutes", $last_time));
    }else {
        $tgl_pemeriksaan = $waktu_daftar;
    }
    }
    $noAntrian = $kode_spesialis.'-'.str_pad($urutan,3,'0',STR_PAD_LEFT);

    mysqli_query($koneksi, "INSERT INTO proses_pasien (id_daftar,id_pasien,id_dokter,id_admin,id_spesialis,tgl_pemeriksaan,no_antrian)
                            VALUES ('$id_daftar_baru','$id_pasien','$id_dokter','$id_admin_value','$id_spesialis','$tgl_pemeriksaan','$noAntrian')");

    mysqli_commit($koneksi);

    header("Location: ../view/admin/pendaftaran_form.php?toast=added");
    exit;
} catch (Throwable $e) {
    mysqli_rollback($koneksi);
    header("Location: ../view/admin/pendaftaran_form.php?toast=jadwal_gagal");
    exit;
}
}
?>
