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

$role = isset($_POST['role']) ? $_POST['role'] : '';
$id   = isset($_POST['id']) ? $_POST['id'] : '';

$role = mysqli_real_escape_string($koneksi, $role);
$id   = mysqli_real_escape_string($koneksi, $id);

if ($role === 'pasien') {
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik'] ?? '');
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pasien'] ?? '');
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat_pasien'] ?? '');
    $umur = mysqli_real_escape_string($koneksi, $_POST['umur'] ?? '');
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp'] ?? '');
    $password = isset($_POST['password']) ? mysqli_real_escape_string($koneksi, $_POST['password']) : '';
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? strtoupper(substr(trim($_POST['jenis_kelamin']),0,1)) : '';
    if ($jenis_kelamin !== '') {
        if (!in_array($jenis_kelamin, ['L','P'])) {
            $jenis_kelamin = '';
        } else {
            $jenis_kelamin = mysqli_real_escape_string($koneksi, $jenis_kelamin);
        }
    }

    if (!preg_match('/^\d{16}$/', $nik)) { echo "NIK harus 16 digit."; exit; }
    $chk = mysqli_query($koneksi, "SELECT 1 FROM pasien WHERE nik='$nik' AND id_pasien!='$id' LIMIT 1");
    if ($chk && mysqli_num_rows($chk) > 0) { echo "NIK sudah digunakan oleh pasien lain."; exit; }

    $sets = [];
    $sets[] = "nik='$nik'";
    if ($umur !== '' && !preg_match('/^\d+$/', $umur)) { echo "Umur harus angka."; exit; }
    if ($no_hp !== '' && !preg_match('/^\d+$/', $no_hp)) { echo "No HP harus angka."; exit; }
    if ($jenis_kelamin !== '') {
        $sets[] = "jenis_kelamin='$jenis_kelamin'";
    }
    $sets[] = "nama_pasien='$nama'";
    $sets[] = "alamat_pasien='$alamat'";
    $sets[] = "umur='$umur'";
    $sets[] = "no_hp='$no_hp'";
    if ($password !== '') {
        if (!preg_match('/^\d{6}$/', $password)) { echo "PIN harus 6 digit jika diisi."; exit; }
        $sets[] = "password='$password'";
    }

    $sql = "UPDATE pasien SET " . implode(',', $sets) . " WHERE id_pasien='$id' LIMIT 1";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../view/admin/lihat_pengguna.php?status=updated");
        exit;
    } else {
        echo "Gagal memperbarui pasien: " . mysqli_error($koneksi);
    }

} elseif ($role === 'admin') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_admin'] ?? '');
    $waktu_jaga = mysqli_real_escape_string($koneksi, $_POST['waktu_jaga'] ?? '');
    $password = isset($_POST['passwordadmin']) ? mysqli_real_escape_string($koneksi, $_POST['passwordadmin']) : '';

    $sets = [];
    $sets[] = "nama_admin='$nama'";
    $sets[] = "waktu_jaga='$waktu_jaga'";
    if ($password !== '') {
        if (!preg_match('/^\d{6}$/', $password)) { echo "PIN harus 6 digit jika diisi."; exit; }
        $sets[] = "passwordadmin='$password'";
    }

    $sql = "UPDATE admin SET " . implode(',', $sets) . " WHERE id_admin='$id' LIMIT 1";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../view/admin/lihat_pengguna.php?status=updated");
        exit;
    } else {
        echo "Gagal memperbarui admin: " . mysqli_error($koneksi);
    }

} elseif ($role === 'dokter') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_dokter'] ?? '');
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp_dokter'] ?? '');
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat_dokter'] ?? '');
    $tgl = mysqli_real_escape_string($koneksi, $_POST['tgl_lahir_dokter'] ?? '');
    $waktu = mysqli_real_escape_string($koneksi, $_POST['waktu_kerja'] ?? '');
    $id_spesialis = mysqli_real_escape_string($koneksi, $_POST['id_spesialis'] ?? '');
    $password = isset($_POST['passworddok']) ? mysqli_real_escape_string($koneksi, $_POST['passworddok']) : '';

    $waktu_pulang = '';
    if (!empty($waktu)) {
        $start = new DateTime($waktu);
        $start->modify('+6 hours');
        $waktu_pulang = $start->format('H:i:s');
    }

    $sets = [];
    $sets[] = "nama_dokter='$nama'";
    if ($no_hp !== '' && !preg_match('/^\d+$/', $no_hp)) { echo "No HP dokter harus angka."; exit; }
    $sets[] = "no_hp_dokter='$no_hp'";
    $sets[] = "alamat_dokter='$alamat'";
    $sets[] = "tgl_lahir_dokter='$tgl'";
    $sets[] = "waktu_kerja='$waktu'";
    $sets[] = "waktu_pulang='$waktu_pulang'"; 
    $sets[] = "id_spesialis='$id_spesialis'";
    if ($password !== '') {
        if (!preg_match('/^\d{6}$/', $password)) { echo "PIN harus 6 digit jika diisi."; exit; }
        $sets[] = "passworddok='$password'";
    }

    $sql = "UPDATE dokter SET " . implode(',', $sets) . " WHERE id_dokter='$id' LIMIT 1";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../view/admin/lihat_pengguna.php?status=updated");
        exit;
    } else {
        echo "Gagal memperbarui dokter: " . mysqli_error($koneksi);
    }
}else {
    echo "Role tidak valid.";
}
?>