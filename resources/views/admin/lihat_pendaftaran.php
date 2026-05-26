<?php
session_start();
include '../../database/koneksi.php';
include '../../controller/lihat_pendaftaran_proses.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 5;

$data = [];
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
}

$totalData = count($data);
$totalPage = ceil($totalData / $perPage);
$start = ($page - 1) * $perPage;
$rows = array_slice($data, $start, $perPage);

$page_style = ['lihat_pendaftaran.css'];
$page_title = 'Daftar Pendaftaran';
include __DIR__ . '/../layout/header.php';
?>

<h2>Daftar Pendaftaran</h2>

<table border="1" cellpadding="6" cellspacing="0">
<thead>
<tr>
    <th>No</th>
    <th>Nama Pasien</th>
    <th>NIK</th>
    <th>Spesialis</th>
    <th>Dokter</th>
    <th>No Antrian</th>
    <th>Tanggal Pemeriksaan</th>
    <th>Status</th>
    <th>Admin</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php if (empty($rows)): ?>
<tr><td colspan="10">Tidak ada pendaftaran ditemukan.</td></tr>
<?php else: ?>
<?php $no = ($page - 1) * $perPage + 1; ?>
<?php foreach ($rows as $r): ?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= htmlspecialchars($r['nama_pasien'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($r['nik'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($r['nama_spesialis'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($r['nama_dokter'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($r['no_antrian'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($r['tgl_pemeriksaan'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($r['status_pendaftaran'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($r['nama_admin'] ?? '-'); ?></td>
    <td>
        <?php if (($r['status_pendaftaran'] ?? '') === 'pengecekan'): ?>
        <form method="POST" action="/puskesmas/controller/konfirmasi_pendaftaran_proses.php" onsubmit="return confirm('Konfirmasi pendaftaran ini?');">
            <input type="hidden" name="id_value" value="<?= htmlspecialchars($r['id_pendaftaran']); ?>">
            <button type="submit">Konfirmasi</button>
        </form>
        <?php else: ?>
        -
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>

<?php if ($totalPage > 1): ?>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">« Back</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $totalPage): ?>
        <a href="?page=<?= $page + 1 ?>">Next »</a>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php include __DIR__ . '/../layout/footer.php'; ?>
