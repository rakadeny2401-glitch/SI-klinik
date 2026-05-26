<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Puskesmas'; ?></title>

    <?php
    $global_styles = [
        'layout/layout.css',
        'layout/pagination.css'
    ];

    foreach ($global_styles as $gcss) {
        echo '<link rel="stylesheet" href="/puskesmas/style/css/' . $gcss . '">' . PHP_EOL;
    }

    if (!empty($page_style) && is_array($page_style)) {
        foreach ($page_style as $css) {
            echo '<link rel="stylesheet" href="/puskesmas/style/css/' . $css . '">' . PHP_EOL;
        }
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="app-layout">
        <header class="app-topbar">
            <div class="brand">Puskesmas Cisaranten Kulon</div>

            <?php
            $profile_role = isset($_SESSION['role']) ? strtolower($_SESSION['role']) : 'unknown';
            $profile_name = '';

            if ($profile_role == 'admin') {
                $profile_name = $_SESSION['data']['nama_admin'] ?? 'Administrator';
            } elseif ($profile_role == 'pasien') {
                $profile_name = $_SESSION['data']['nama_pasien'] ?? 'Pasien';
            } elseif ($profile_role == 'dokter') {
                $profile_name = $_SESSION['data']['nama_dokter'] ?? 'Dokter';
            } else {
                $profile_name = 'Pengguna';
            }

            $initial = $profile_name ? strtoupper(substr(trim($profile_name), 0, 1)) : 'U';
            ?>

            <div class="topbar-right" style="position:relative">
                <div class="profile">
                    <button id="profileBtn" class="profile-btn" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar"><?php echo htmlspecialchars($initial); ?></span>
                    </button>

                    <div id="profileBadge" class="profile-badge" aria-hidden="true">
                        <div class="badge-header">
                            <span class="badge-avatar"><?php echo htmlspecialchars($initial); ?></span>
                            <div class="badge-meta">
                                <div class="badge-name"><?php echo htmlspecialchars($profile_name); ?></div>
                                <div class="badge-role"><?php echo htmlspecialchars($profile_role); ?></div>
                            </div>
                        </div>

                        <div class="badge-actions">
                            <a class="btn-link" href="/puskesmas/controller/logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?php
        $sidebarPath = __DIR__ . '/sidebar.php';
        if (file_exists($sidebarPath)) {
            include $sidebarPath;
        }
        ?>

        <main id="app-content" class="app-content">
