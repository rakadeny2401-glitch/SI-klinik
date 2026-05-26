<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pasien') {
    echo "Akses ditolak!";
    exit;
}

$id_pasien = (int)($_SESSION['data']['id_pasien'] ?? 0);

$page_title = 'Riwayat Pendaftaran';
$page_style = ['riwayat_periksa.css'];
$force_active_menu = 'riwayat_pendaftaran';
include __DIR__ . '/../layout/header.php';

$q = mysqli_query($koneksi, "
    SELECT d.id_daftar, d.nama_pasien, d.umur, d.keluhan, d.waktu_daftar, d.status_pendaftaran,
           pp.id_proses, pp.no_antrian, pp.tgl_pemeriksaan,
           s.nama_spesialis, doc.nama_dokter
    FROM daftar d
    LEFT JOIN proses_pasien pp ON pp.id_daftar = d.id_daftar
    LEFT JOIN spesialis s ON s.id_spesialis = pp.id_spesialis
    LEFT JOIN dokter doc ON doc.id_dokter = pp.id_dokter
    WHERE d.id_pasien = '$id_pasien'
    ORDER BY d.waktu_daftar DESC

");

$data = [];
if ($q) {
    while ($row = mysqli_fetch_assoc($q)) $data[] = $row;
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 5;
$totalData = count($data);
$totalPage = ($totalData > 0) ? (int)ceil($totalData / $perPage) : 1;
$start = ($page - 1) * $perPage;
$rows = array_slice($data, $start, $perPage);
?>

<div class="riwayat-container">
    <div class="riwayat-header"><h2>Riwayat Pendaftaran</h2></div>

    <table class="riwayat-table">
        <thead>
            <tr>
                    <th>Nama Pasien</th>
                    <th>Umur</th>
                    <th>Keluhan</th>
                    <th>Spesialis</th>
                    <th>Dokter</th>
                    <th>No Antrian</th>
                    <th>Tanggal Pemeriksaan</th>
                    <th>Hasil</th>
                    <th>Status</th>
                </tr>
        </thead>
        <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['nama_pasien']); ?></td>
                    <td><?= htmlspecialchars($r['umur']); ?> tahun</td>
                    <td><?= htmlspecialchars($r['keluhan']); ?></td>
                    <td><?= htmlspecialchars($r['nama_spesialis'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($r['nama_dokter'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($r['no_antrian'] ?? '-'); ?></td>
                    <td><?= htmlspecialchars($r['tgl_pemeriksaan'] ?? $r['waktu_daftar']); ?></td>
                    <td>
                        <?php
                            $hasilText = '-';
                            if (!empty($r['id_proses'])) {
                                $pid = (int)$r['id_proses'];
                                $qSakit = mysqli_query($koneksi, "SELECT id_surat FROM surat_ktrgnsakit WHERE id_proses='$pid' LIMIT 1");
                                $sSakit = $qSakit ? mysqli_fetch_assoc($qSakit) : null;
                                $qRujuk = mysqli_query($koneksi, "SELECT id_rujukan FROM srt_rkrmdsi_rujukan WHERE id_proses='$pid' LIMIT 1");
                                $sRujuk = $qRujuk ? mysqli_fetch_assoc($qRujuk) : null;

                                if ($sSakit) {
                                    $hasilText = "<a class='action-btn' href='/puskesmas/view/pasien/detail_surat_sakit.php?id_surat=" . htmlspecialchars($sSakit['id_surat']) . "'>Surat Sakit</a>";
                                } elseif ($sRujuk) {
                                    $hasilText = "<a class='action-btn' href='/puskesmas/view/pasien/detail_surat_rujukan.php?id_rujukan=" . htmlspecialchars($sRujuk['id_rujukan']) . "'>Surat Rujukan</a>";
                                } else {
                                    $hasilText = '-';
                                }
                            }
                            echo $hasilText;
                        ?>
                    </td>
                    <td><?= htmlspecialchars($r['status_pendaftaran'] ?? '-'); ?></td>
                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($totalPage > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?><a href="?page=<?= $page - 1 ?>">« Back</a><?php endif; ?>
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($page < $totalPage): ?><a href="?page=<?= $page + 1 ?>">Next »</a><?php endif; ?>
    </div>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
