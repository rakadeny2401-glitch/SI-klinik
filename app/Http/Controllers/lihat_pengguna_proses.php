<?php
$filter = isset($_GET['role']) ? $_GET['role'] : 'all';
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$q_esc = mysqli_real_escape_string($koneksi, $q);

$conds = array();
if ($q_esc !== ''){
    $conds[] = "(nama_pasien LIKE '%$q_esc%' OR nik LIKE '%$q_esc%')"; 
}

$rows = array();

function fetch_pasien($koneksi, $q_esc){
    $sql = "SELECT id_pasien AS id, 'pasien' AS role, nik AS identifier, nama_pasien AS nama, no_hp AS no_hp FROM pasien";
    if ($q_esc !== ''){
        $sql .= " WHERE nama_pasien LIKE '%$q_esc%' OR nik LIKE '%$q_esc%'";
    }
    return mysqli_query($koneksi, $sql);
}
function fetch_admin($koneksi, $q_esc){
    $sql = "SELECT id_admin AS id, 'admin' AS role, no_identitas AS identifier, nama_admin AS nama, NULL AS no_hp FROM admin";
    if ($q_esc !== ''){
        $sql .= " WHERE nama_admin LIKE '%$q_esc%' OR no_identitas LIKE '%$q_esc%'";
    }
    return mysqli_query($koneksi, $sql);
}
function fetch_dokter($koneksi, $q_esc){
    $sql = "SELECT id_dokter AS id, 'dokter' AS role, no_identitas AS identifier, nama_dokter AS nama, no_hp_dokter AS no_hp FROM dokter";
    if ($q_esc !== ''){
        $sql .= " WHERE nama_dokter LIKE '%$q_esc%' OR no_identitas LIKE '%$q_esc%'";
    }
    return mysqli_query($koneksi, $sql);
}

if ($filter === 'pasien'){
    $res = fetch_pasien($koneksi, $q_esc);
    while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
} elseif ($filter === 'admin'){
    $res = fetch_admin($koneksi, $q_esc);
    while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
} elseif ($filter === 'dokter'){
    $res = fetch_dokter($koneksi, $q_esc);
    while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
} else {
    $res = fetch_pasien($koneksi, $q_esc);
    while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
    $res = fetch_admin($koneksi, $q_esc);
    while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
    $res = fetch_dokter($koneksi, $q_esc);
    while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
}
?>