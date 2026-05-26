<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

$id_dokter = $_SESSION['data']['id_dokter'] ?? '';
if ($id_dokter === '') {
    echo "Data dokter tidak lengkap.";
    exit;
}

$page_title = "Riwayat Pemeriksaan Dokter";
$page_style = ['riwayat_periksa.css'];
$force_active_menu = 'riwayat';

include __DIR__ . '/../layout/header.php';

// fetch riwayat pemeriksaan and prepare pagination
$q = mysqli_query($koneksi, "
        SELECT p.id_pasien, p.nama_pasien, p.umur, d.keluhan, pr.id_proses, d.id_daftar
        FROM proses_pasien pr
        JOIN pasien p ON pr.id_pasien = p.id_pasien
        JOIN daftar d ON pr.id_daftar = d.id_daftar
        WHERE pr.id_dokter = '$id_dokter' 
            AND d.status_pendaftaran = 'selesai'
        ORDER BY pr.id_proses DESC
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

<div class="riwayat-container">
    <div class="riwayat-header">
        <h2>Riwayat Pemeriksaan Dokter</h2>
    </div>

    <table class="riwayat-table">
        <thead>
            <tr>
                <th>Nama Pasien</th>
                <th>Umur</th>
                <th>Keluhan</th>
                <th>Obat Diberikan</th>
                <th>Rekomendasi</th>
                <th>Detail Surat</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): 
                $id_pasien = $row['id_pasien'];
                $id_daftar = $row['id_daftar'];
                $id_proses = $row['id_proses'];

                $qObat = mysqli_query($koneksi, "SELECT jenis_obat FROM resep_obat WHERE id_proses='$id_proses'");
                $obatList = [];
                while ($o = mysqli_fetch_assoc($qObat)) {
                    $obatList[] = $o['jenis_obat'];
                }
                $obatStr = $obatList ? implode(', ', $obatList) : '-';

                $qSakit = mysqli_query($koneksi, "SELECT id_surat FROM surat_ktrgnsakit WHERE id_proses='$id_proses' LIMIT 1");
                $suratSakit = mysqli_fetch_assoc($qSakit);

                $qRujukan = mysqli_query($koneksi, "SELECT id_rujukan FROM srt_rkrmdsi_rujukan WHERE id_proses='$id_proses' LIMIT 1");
                $suratRujukan = mysqli_fetch_assoc($qRujukan);

                $rekomendasiList = [];
                $linkList = [];

                if ($suratSakit) {
                    $rekomendasiList[] = 'Surat Sakit';
                    $linkList[] = "<a class='action-btn' href='detail_surat_sakit.php?id_surat={$suratSakit['id_surat']}'>Surat Sakit</a>";
                }

                if ($suratRujukan) {
                    $rekomendasiList[] = 'Surat Rujukan RS';
                    $linkList[] = "<a class='action-btn' href='detail_surat_rujukan.php?id_rujukan={$suratRujukan['id_rujukan']}'>Surat Rujukan</a>";
                }

                $rekomendasi = $rekomendasiList ? implode(' & ', $rekomendasiList) : '-';
                $linkSurat = $linkList ? "<div class='action-group'>" . implode('', $linkList) . "</div>" : '-';
            ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_pasien']); ?></td>
                <td><?= htmlspecialchars($row['umur']); ?> tahun</td>
                <td><?= htmlspecialchars($row['keluhan']); ?></td>
                <td><?= htmlspecialchars($obatStr); ?></td>
                <td><?= htmlspecialchars($rekomendasi); ?></td>
                <td><?= $linkSurat; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
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
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
