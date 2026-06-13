<?php
$colsRes = mysqli_query($koneksi, "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'daftar'");
$daftarCols = [];
if ($colsRes) {
    while ($c = mysqli_fetch_assoc($colsRes)) {
        $daftarCols[] = $c['COLUMN_NAME'];
    }
}

function has_col($cols, $name) { return in_array($name, $cols); }

$idCol = null;
foreach (array('id_pendaftaran','id_daftar','id','id_pend') as $candidate) {
    if (has_col($daftarCols, $candidate)) { 
        $idCol = $candidate; 
        break; 
    }
}

$selectParts = array();
if ($idCol) $selectParts[] = "d.`" . $idCol . "` AS id_pendaftaran";
foreach (array('nama_pasien','nik','keluhan','waktu_daftar','status_pendaftaran','created_at','id_spesialis','id_dokter','id_admin') as $f) {
    if (has_col($daftarCols, $f)) $selectParts[] = "d.`$f`";
}

if (empty($selectParts)) $select = 'd.*'; 
else $select = implode(', ', $selectParts);

$joinSpesialis = has_col($daftarCols, 'id_spesialis') ? 'LEFT JOIN spesialis s ON d.id_spesialis = s.id_spesialis' : '';
$joinDokter = has_col($daftarCols, 'id_dokter') ? 'LEFT JOIN dokter doc ON d.id_dokter = doc.id_dokter' : '';
$joinAdmin = has_col($daftarCols, 'id_admin') ? 'LEFT JOIN admin a ON d.id_admin = a.id_admin' : '';

$orderParts = array();
if (has_col($daftarCols, 'waktu_daftar')) $orderParts[] = 'd.waktu_daftar DESC';
if (has_col($daftarCols, 'created_at')) $orderParts[] = 'd.created_at DESC';
if (empty($orderParts)) $orderBy = ''; 
else $orderBy = 'ORDER BY ' . implode(', ', $orderParts);

$extraSelect = array();
if ($joinSpesialis) $extraSelect[] = 's.nama_spesialis';
if ($joinDokter) $extraSelect[] = 'doc.nama_dokter';
if ($joinAdmin) $extraSelect[] = 'a.nama_admin';

$extraSelect[] = 'pp.no_antrian';
$extraSelect[] = 'pp.tgl_pemeriksaan';

$allSelect = $select . ', ' . implode(', ', $extraSelect);

$sql = "
SELECT $allSelect
FROM daftar d
$joinSpesialis
$joinDokter
$joinAdmin
LEFT JOIN proses_pasien pp ON pp.id_daftar = d.$idCol
$orderBy
";

$res = mysqli_query($koneksi, $sql);
?>
