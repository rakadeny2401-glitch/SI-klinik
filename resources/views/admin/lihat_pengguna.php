<?php
session_start();
include '../../database/koneksi.php';
include '../../controller/lihat_pengguna_proses.php';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 5;

$totalData = count($rows);
$totalPage = ceil($totalData / $perPage);
$start = ($page - 1) * $perPage;
$rows = array_slice($rows, $start, $perPage);


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}
$page_style = ['lihat_pengguna.css'];
$page_title = 'Daftar Pengguna';
include __DIR__ . '/../layout/header.php';
?>

<!-- global toast handler (spesialis-toast.js) in layout/footer.php will handle messages -->

<h2>Daftar Pengguna</h2>

<form method="GET" action="">
    <label>Filter role: </label>
    <select name="role">
        <option value="all" <?php if($filter==='all') echo 'selected'; ?>>Semua</option>
        <option value="pasien" <?php if($filter==='pasien') echo 'selected'; ?>>Pasien</option>
        <option value="dokter" <?php if($filter==='dokter') echo 'selected'; ?>>Dokter</option>
        <option value="admin" <?php if($filter==='admin') echo 'selected'; ?>>Admin</option>
    </select>

    <label style="margin-left:12px">Cari: </label>
    <input type="text" name="q" value="<?php echo htmlspecialchars((string)$q); ?>" placeholder="Cari...">
    <button type="submit">Terapkan</button>
</form>

<table>
    <thead>
        <tr>
            <th>Role</th>
            <th>Nama</th>
            <th>No Identitas</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($rows) === 0): ?>
        <tr><td colspan="5">Tidak ada pengguna ditemukan.</td></tr>
    <?php else: ?>
        <?php foreach($rows as $r): ?>
            <tr>
                <td><?php echo htmlspecialchars((string)$r['role']); ?></td>
                <td><?php echo htmlspecialchars((string)$r['nama']); ?></td>
                <td><?php echo htmlspecialchars((string)$r['identifier']); ?></td>
                <td><?php echo htmlspecialchars((string)($r['no_hp'] ?? '-')); ?></td>
                <td class="actions"><a href="lihat_pengguna_detail.php?role=<?php echo urlencode($r['role']); ?>&id=<?php echo urlencode($r['id']); ?>">Lihat</a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?php if ($totalPage > 1): ?>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&role=<?= urlencode($filter) ?>&q=<?= urlencode($q) ?>">« Back</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
        <a href="?page=<?= $i ?>&role=<?= urlencode($filter) ?>&q=<?= urlencode($q) ?>"
           class="<?= $i == $page ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $totalPage): ?>
        <a href="?page=<?= $page + 1 ?>&role=<?= urlencode($filter) ?>&q=<?= urlencode($q) ?>">Next »</a>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- toast element is provided in layout/footer.php -->

<?php include __DIR__ . '/../layout/footer.php'; ?>