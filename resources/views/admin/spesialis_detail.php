<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';
if ($id === '') { echo "ID spesialis tidak valid."; exit; }

$res = mysqli_query($koneksi, "SELECT * FROM spesialis WHERE id_spesialis='$id' LIMIT 1");
$sp = mysqli_fetch_assoc($res);
if (!$sp) { echo "Spesialis tidak ditemukan."; exit; }

$q = mysqli_query($koneksi, "SELECT id_dokter, nama_dokter, alamat_dokter, waktu_kerja, waktu_pulang
                             FROM dokter
                             WHERE id_spesialis='$id'
                             ORDER BY nama_dokter ASC");

$data = [];
if ($q) {
    while ($row = mysqli_fetch_assoc($q)) {
        $data[] = $row;
    }
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 5;
$totalData = count($data);
$totalPage = ($totalData > 0) ? (int)ceil($totalData / $perPage) : 1;
$start = ($page - 1) * $perPage;
$rows = array_slice($data, $start, $perPage);

$force_active_menu = 'spesialis.php';
$page_style = ['spesialis_admin.css'];
$page_title = 'Detail Spesialis';
include __DIR__ . '/../layout/header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Spesialis - <?php echo htmlspecialchars($sp['nama_spesialis']); ?></title>
    <link rel="stylesheet" href="../../style/css/spesialis_detail.css">
</head>
<body>

<div class="detail-container">

    <div class="detail-header">
        <h2>Detail Spesialis</h2>
    </div>

    <div class="detail-row">
        <div class="detail-label">Nama Spesialis</div>
        <div class="detail-value"><?php echo htmlspecialchars($sp['nama_spesialis']); ?></div>
    </div>

    <div class="detail-header" style="margin-top:30px;">
        <h2>Daftar Dokter</h2>
    </div>

    <?php if (mysqli_num_rows($q) === 0): ?>

        <p style="text-align:center;color:#555;">Tidak ada dokter terdaftar pada spesialis ini.</p>

    <?php else: ?>

        <table class="sp-table">
            <tr>
                <th>No</th>
                <th>Nama Dokter</th>
                <th>Jam Kerja</th>
            </tr>

            <?php $i = ($page - 1) * $perPage + 1; foreach ($rows as $r): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo htmlspecialchars($r['nama_dokter']); ?></td>
                    <td>
                        <?php 
                        $jam_mulai = !empty($r['waktu_kerja']) ? date('H:i', strtotime($r['waktu_kerja'])) : '-';
                        $jam_pulang = !empty($r['waktu_pulang']) ? date('H:i', strtotime($r['waktu_pulang'])) : '-';
                        echo $jam_mulai . " - " . $jam_pulang;
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php endif; ?>

    <?php if ($totalPage > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?id=<?php echo urlencode($id); ?>&page=<?= $page - 1 ?>">« Back</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="?id=<?php echo urlencode($id); ?>&page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPage): ?>
            <a href="?id=<?php echo urlencode($id); ?>&page=<?= $page + 1 ?>">Next »</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="btn-back-wrapper">
        <button class="btn-back" onclick="window.location.href='spesialis.php'">Kembali</button>
    </div>

</div>

</body>
</html>