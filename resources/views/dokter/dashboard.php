<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dokter') {
    echo "Akses ditolak!";
    exit;
}

include '../../database/koneksi.php';

$page_title = "Dashboard Pasien";
$page_style = [];
$force_active_menu = 'dashboard';

$id_dokter = $_SESSION['data']['id_dokter'];

$q = mysqli_query($koneksi, "
    SELECT id_daftar, COUNT(*) AS total
    FROM daftar
    WHERE id_dokter = '$id_dokter'
    GROUP BY id_daftar
    ORDER BY id_daftar ASC
");

$label = [];
$data = [];

while ($row = mysqli_fetch_assoc($q)) {
    $label[] = "Daftar " . $row['id_daftar'];
    $data[] = $row['total'];
}

$q2 = mysqli_query($koneksi, "
    SELECT DATE(waktu_daftar) AS tanggal, COUNT(*) AS jumlah
    FROM daftar
    WHERE id_dokter = '$id_dokter'
    GROUP BY DATE(waktu_daftar)
    ORDER BY DATE(waktu_daftar) ASC
");

$label2 = [];
$data2 = [];

while ($row = mysqli_fetch_assoc($q2)) {
    $label2[] = $row['tanggal'];
    $data2[] = (int)$row['jumlah'];
}

include __DIR__ . '/../layout/header.php';
?>

<h2>Dashboard Dokter</h2>

<p>Selamat datang, <?php echo htmlspecialchars($_SESSION['data']['nama_dokter']); ?>!</p>

<div style="max-width: 750px; margin-top: 30px; padding: 25px; background: #fff; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom: 20px; text-align:center; color:#004085;">Kurva Keramaian Pasien Anda</h3>
    <canvas id="chartTanggal" height="150"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('chartKurva'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($label); ?>,
        datasets: [{
            label: 'Jumlah Pasien',
            data: <?php echo json_encode($data); ?>,
            borderWidth: 3,
            tension: 0.4,
            borderColor: 'rgba(0, 90, 170, 1)',
            backgroundColor: 'rgba(0, 90, 170, 0.25)',
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: 'rgba(0, 90, 170, 1)'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});

new Chart(document.getElementById('chartTanggal'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($label2); ?>,
        datasets: [{
            label: 'Jumlah Pasien',
            data: <?php echo json_encode($data2); ?>,
            borderWidth: 3,
            tension: 0.4,
            borderColor: 'rgba(200, 50, 50, 1)',
            backgroundColor: 'rgba(200, 50, 50, 0.25)',
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: 'rgba(200, 50, 50, 1)'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
