<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

$q = mysqli_query($koneksi, "SELECT * FROM spesialis ORDER BY nama_spesialis ASC");

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

$page_style = ['spesialis_admin.css'];
$page_title = 'Kelola Spesialis';
include __DIR__ . '/../layout/header.php';
?>

<!-- page meta for status-based scripts -->
<div id="page-meta" data-status="<?php echo isset($_GET['status']) ? htmlspecialchars($_GET['status']) : ''; ?>"></div>

<h3>Daftar Spesialis</h3>

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Spesialis</th>
        <th>Aksi</th>
    </tr>
    <?php $i = ($page - 1) * $perPage + 1; foreach ($rows as $r): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($r['nama_spesialis']); ?></td>
            <td>
                <a href="spesialis_detail.php?id=<?php echo urlencode($r['id_spesialis']); ?>">
                    <button type="button">Detail</button>
                </a>
                <form method="POST" action="../../controller/hapus_spesialis_proses.php"
                      style="display:inline"
                      onsubmit="return confirm('Hapus spesialis ini?\nJika masih ada dokter di spesialis ini, hapus tidak akan dilakukan.');">
                    <input type="hidden" name="id_spesialis" value="<?php echo htmlspecialchars($r['id_spesialis']); ?>">
                    <button type="submit"
                            style="background:#c82333;color:#fff;border:0;padding:6px 8px;cursor:pointer;">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php if ($totalPage > 1): ?>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>">« Back</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page < $totalPage): ?>
        <a href="?page=<?= $page + 1 ?>">Next »</a>
    <?php endif; ?>
</div>
<?php endif; ?>


<?php include __DIR__ . '/../layout/footer.php'; ?>