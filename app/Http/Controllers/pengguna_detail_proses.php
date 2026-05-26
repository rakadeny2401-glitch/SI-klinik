<?php
$role = isset($_GET['role']) ? $_GET['role'] : '';
$id   = isset($_GET['id']) ? $_GET['id'] : '';

$role = mysqli_real_escape_string($koneksi, $role);
$id   = mysqli_real_escape_string($koneksi, $id);

$details = null;

if ($role === 'pasien') {
    $res = mysqli_query($koneksi, "SELECT * FROM pasien WHERE id_pasien='$id' LIMIT 1");
    $details = mysqli_fetch_assoc($res);

    $id_akses = $details['id_akses'];
    $akses = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama_akses FROM hak_akses WHERE id_akses='$id_akses'"));
    $details['hak_akses'] = $akses['nama_akses'] ?? '-';

} elseif ($role === 'admin') {
    $res = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id' LIMIT 1");
    $details = mysqli_fetch_assoc($res);

    $id_akses = $details['id_akses'];
    $akses = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama_akses FROM hak_akses WHERE id_akses='$id_akses'"));
    $details['hak_akses'] = $akses['nama_akses'] ?? '-';

} elseif ($role === 'dokter') {
    $res = mysqli_query($koneksi, "SELECT * FROM dokter WHERE id_dokter='$id' LIMIT 1");
    $details = mysqli_fetch_assoc($res);

    $id_akses = $details['id_akses'];
    $akses = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama_akses FROM hak_akses WHERE id_akses='$id_akses'"));
    $details['hak_akses'] = $akses['nama_akses'] ?? '-';

    $id_sp = $details['id_spesialis'];
    $sp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama_spesialis FROM spesialis WHERE id_spesialis='$id_sp'"));
    $details['spesialis'] = $sp['nama_spesialis'] ?? '-';
} else {
    echo "Role tidak valid.";
    exit;
}

if (!$details) {
    echo "Pengguna tidak ditemukan.";
    exit;
}

function h($s){ return htmlspecialchars((string)$s); }

$hidden = ['id_pasien','id_admin','id_dokter','id_spesialis','id_akses','password','passwordadmin','passworddok'];

$label = [
    'nama_pasien'   => 'Nama',
    'nama_admin'    => 'Nama',
    'nama_dokter'   => 'Nama',
    'nik'           => 'NIK',
    'no_identitas'  => 'No Identitas',
    'no_hp'         => 'No HP',
    'no_hp_dokter'  => 'No HP',
    'jenis_kelamin' => 'Jenis Kelamin',
    'hak_akses'     => 'Peran',
    'spesialis'     => 'Spesialis',
    'alamat'        => 'Alamat',
    'tanggal_lahir' => 'Tanggal Lahir'
];
?>