<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function generate_unique_no_identitas($koneksi) {
        $tries = 0;
        do {
            $no_identitas = '';
            for ($i = 0; $i < 16; $i++) {
                $no_identitas .= random_int(0, 9);
            }
            $no_identitas_esc = mysqli_real_escape_string($koneksi, $no_identitas);
            $check_sql = "SELECT 1 FROM pasien WHERE no_identitas='$no_identitas_esc' 
                          UNION SELECT 1 FROM admin WHERE no_identitas='$no_identitas_esc' 
                          UNION SELECT 1 FROM dokter WHERE no_identitas='$no_identitas_esc' LIMIT 1";
            $res = mysqli_query($koneksi, $check_sql);
            $exists = $res && mysqli_num_rows($res) > 0;
            $tries++;
        } while ($exists && $tries < 50);
        return $no_identitas;
    }

    function get_id_akses($koneksi, $role) {
        $role_esc = mysqli_real_escape_string($koneksi, trim($role));
        if ($role_esc === '') return false;
        $sql = "SELECT id_akses FROM hak_akses WHERE LOWER(nama_akses) = LOWER('$role_esc') LIMIT 1";
        $res = mysqli_query($koneksi, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            return (int) $row['id_akses'];
        }
        return false;
    }

    $nama_dokter = mysqli_real_escape_string($koneksi, $_POST['nama_dokter'] ?? '');
    $no_hp_dokter = mysqli_real_escape_string($koneksi, $_POST['no_hp_dokter'] ?? '');
    $alamat_dokter = mysqli_real_escape_string($koneksi, $_POST['alamat_dokter'] ?? '');
    $tgl_lahir_dokter = mysqli_real_escape_string($koneksi, $_POST['tgl_lahir_dokter'] ?? '');
    $waktu_kerja = mysqli_real_escape_string($koneksi, $_POST['waktu_kerja'] ?? '');

    $waktu_pulang = '';
    if (!empty($waktu_kerja)) {
        $start = new DateTime($waktu_kerja);
        $start->modify('+6 hours');
        $waktu_pulang = $start->format('H:i:s');
    }

    $id_spesialis = mysqli_real_escape_string($koneksi, $_POST['id_spesialis'] ?? '');

    $password_raw = preg_replace('/\D/', '', trim($_POST['passworddok'] ?? ''));

    $id_dokter = isset($_POST['id_dokter']) ? trim($_POST['id_dokter']) : '';
    $id_dokter_esc = $id_dokter === '' ? '' : mysqli_real_escape_string($koneksi, $id_dokter);

    if (!preg_match('/^\d{6}$/', $password_raw)) {
        echo "PIN dokter harus 6 digit angka.";
        exit;
    }
    $password_to_save = $password_raw;

    if (empty($nama_dokter) || empty($no_hp_dokter) || empty($password_to_save) || empty($id_spesialis) || empty($alamat_dokter)) {
        echo "Lengkapi semua field dokter yang wajib diisi.";
        exit;
    }

    if (!preg_match('/^\d+$/', $no_hp_dokter)) { 
        echo "No HP dokter harus angka."; 
        exit; 
    }

    $id_akses = get_id_akses($koneksi, 'dokter');
    if ($id_akses === false) {
        echo "Hak akses untuk role 'dokter' tidak ditemukan. Mohon periksa tabel hak_akses.";
        exit;
    }

    $no_identitas = generate_unique_no_identitas($koneksi);

    $cols = [
        'nama_dokter','no_hp_dokter','alamat_dokter','tgl_lahir_dokter',
        'waktu_kerja','waktu_pulang','passworddok','id_spesialis','id_akses','no_identitas'
    ];
    $params = 'ssssssssii';
    $vals = [
        $nama_dokter,$no_hp_dokter,$alamat_dokter,$tgl_lahir_dokter,
        $waktu_kerja,$waktu_pulang,$password_to_save,$id_spesialis,$id_akses,$no_identitas
    ];

    if ($id_dokter !== '') {
        if (!preg_match('/^\d+$/', $id_dokter)) { 
            echo "ID Dokter harus berupa angka jika diisi."; 
            exit; 
        }
        $chk = mysqli_query($koneksi, "SELECT 1 FROM dokter WHERE id_dokter='$id_dokter_esc' LIMIT 1");
        if ($chk && mysqli_num_rows($chk) > 0) { 
            echo "ID Dokter sudah ada. Gunakan ID lain atau kosongkan field untuk auto-assign."; 
            exit; 
        }
        array_unshift($cols, 'id_dokter');
        array_unshift($vals, $id_dokter);
        $params = 'i' . $params;
    }

    $placeholders = implode(', ', array_fill(0, count($cols), '?'));
    $query = "INSERT INTO dokter (" . implode(',', $cols) . ") VALUES ({$placeholders})";

    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, $params, ...$vals);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../view/admin/lihat_pengguna.php?status=added&role=dokter");
        exit;
    } else {
        echo "Gagal menambah dokter: " . mysqli_error($koneksi);
    }
} else {
    echo "Akses tidak sah.";
}
?>