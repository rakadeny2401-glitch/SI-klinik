<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_dokter = (int)($_SESSION['data']['id_dokter'] ?? 0);

$page_title = "Daftar Pasien";
$page_style = ['daftar_pasien.css'];
$force_active_menu = 'daftar_pasien.php';

include __DIR__ . '/../layout/header.php';

$q = mysqli_query($koneksi, "
    SELECT id_daftar, nama_pasien, umur, keluhan
    FROM daftar
    WHERE id_dokter={$id_dokter} AND status_pendaftaran='dikonfirmasi'
    ORDER BY waktu_daftar DESC

");

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
?>

<div class="detail-container">
    <div class="detail-header">
        <h2>Daftar Pasien</h2>
    </div>

    <?php if (empty($rows)): ?>
        <p style="text-align:center;color:#555;">Tidak ada pasien.</p>
    <?php else: ?>
        <table class="sp-table">
            <tr>
                <th>Nama Pasien</th>
                <th>Umur</th>
                <th>Keluhan</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r['nama_pasien']); ?></td>
                    <td><?php echo htmlspecialchars($r['umur']); ?></td>
                    <td><?php echo htmlspecialchars($r['keluhan']); ?></td>
                    <td>
                        <form method="POST" action="../../controller/periksa_pasien_proses.php" style="display:inline;">
                            <input type="hidden" name="id_daftar" value="<?php echo $r['id_daftar']; ?>">
                            <button type="submit">Periksa</button>
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
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>