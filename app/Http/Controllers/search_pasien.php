<?php
include '../database/koneksi.php';

$term = isset($_GET['q']) ? trim($_GET['q']) : '';

$result = [];

if ($term !== '') {
    $sql = mysqli_query($koneksi, "
        SELECT id_pasien, nik, nama_pasien, alamat_pasien, jenis_kelamin, umur
        FROM pasien
        WHERE nik LIKE '%$term%' OR nama_pasien LIKE '%$term%'
        ORDER BY nama_pasien ASC
        LIMIT 20
    ");

    while ($p = mysqli_fetch_assoc($sql)) {
        $result[] = [
            'id' => $p['id_pasien'],
            'text' => $p['nik'].' - '.$p['nama_pasien'],
            'nama' => $p['nama_pasien'],
            'nik' => $p['nik'],
            'alamat' => $p['alamat_pasien'],
            'jk' => $p['jenis_kelamin'],
            'umur' => $p['umur']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($result);
