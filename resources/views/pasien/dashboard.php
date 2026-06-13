<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pasien') {
    echo "Akses ditolak!";
    exit;
}

$page_title = "Dashboard Pasien";
$page_style = []; 
$force_active_menu = 'dashboard'; 

include __DIR__ . '/../layout/header.php';
?>

<h2>Dashboard Pasien</h2>

<p>Selamat datang, <?php echo htmlspecialchars($_SESSION['data']['nama_pasien']); ?>!</p>

<?php include __DIR__ . '/../layout/footer.php'; ?>
