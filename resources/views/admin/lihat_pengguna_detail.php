<?php
session_start();
include '../../database/koneksi.php';
include '../../controller/pengguna_detail_proses.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Pengguna</title>
    <link rel="stylesheet" href="../../style/css/lihat_pengguna_detail.css">
    <link rel="stylesheet" href="../../style/css/components.css">
    <script src="/puskesmas/style/js/layout.js"></script>
</head>
<body>

<!-- toast element and global handler are provided in layout/footer.php -->


<div class="detail-container">

    <div class="detail-header">
        <h2>Detail Pengguna (<?php echo h(ucfirst($role)); ?>)</h2>
    </div>

    <?php foreach ($details as $k => $v): ?>
        <?php  
            if (in_array($k, $hidden)) continue;
            $kolom = $label[$k] ?? ucwords(str_replace('_',' ', $k));
        ?>

        <div class="detail-row">
            <div class="detail-label"><?php echo h($kolom); ?></div>
            <div class="detail-value"><?php echo h($v); ?></div>
        </div>
    <?php endforeach; ?>
    
    <div class="btn-group">

        <button class="btn-edit btn-half"
            onclick="window.location.href='edit_pengguna.php?role=<?php echo urlencode($role); ?>&id=<?php echo urlencode($id); ?>'">
            Edit
        </button>

        <form method="POST" action="../../controller/hapus_pengguna_proses.php"
              style="flex:1;" 
              onsubmit="return confirm('Hapus pengguna ini? Tindakan tidak dapat dibatalkan.');">

            <input type="hidden" name="role" value="<?php echo h($role); ?>">
            <input type="hidden" name="id" value="<?php echo h($id); ?>">

            <button type="submit" class="btn-delete btn-half">Hapus</button>
        </form>

    </div>
    <div class="btn-back-wrapper">
        <button class="btn-back" onclick="window.location.href='lihat_pengguna.php'">
            Kembali
        </button>
    </div>

</div>

</body>
</html>
