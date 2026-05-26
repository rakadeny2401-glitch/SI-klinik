<?php
$current_page = basename($_SERVER['PHP_SELF']);

function _is_active($file, $current, $force = null) {
    if ($force !== null && $force === $file) {
        return 'active';
    }
    return $file === $current ? 'active' : '';
}

$force = isset($force_active_menu) ? $force_active_menu : null;
$role  = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<aside class="app-sidebar" id="app-sidebar">
    <nav>
        <ul>
            <li>
                <a class="<?php echo _is_active('dashboard', $current_page, $force); ?>"
                   href="/puskesmas/view/<?php echo $role; ?>/dashboard.php">
                   Dashboard
                </a>
            </li>

            <?php if ($role === 'admin'): ?>

                <li>
                    <a class="<?php echo _is_active('lihat_pengguna.php', $current_page, $force); ?>"
                       href="/puskesmas/view/admin/lihat_pengguna.php">
                       Lihat Pengguna
                    </a>
                </li>

                <li>
                    <a class="<?php echo _is_active('spesialis.php', $current_page, $force); ?>"
                       href="/puskesmas/view/admin/spesialis.php">
                       Spesialis
                    </a>
                </li>

                <li>
                    <a class="<?php echo _is_active('pendaftaran_form.php', $current_page, $force); ?>"
                       href="/puskesmas/view/admin/pendaftaran_form.php">
                       Pendaftaran
                    </a>
                </li>

                <li>
                    <a class="<?php echo _is_active('lihat_pendaftaran.php', $current_page, $force); ?>"
                       href="/puskesmas/view/admin/lihat_pendaftaran.php">
                       Lihat Pendaftaran
                    </a>
                </li>

            <?php elseif ($role === 'pasien'): ?>

                <li>
                    <a class="<?php echo _is_active('pendaftaran_form.php', $current_page, $force); ?>"
                       href="/puskesmas/view/pasien/pendaftaran_form.php">
                       Form Pendaftaran
                    </a>
                </li>

                <li>
                    <a class="<?php echo _is_active('riwayat_pendaftaran.php', $current_page, $force); ?>"
                       href="/puskesmas/view/pasien/riwayat_pendaftaran.php">
                       Riwayat Pendaftaran
                    </a>
                </li>

            <?php elseif ($role === 'dokter'): ?>

                <li>
                    <a class="<?php echo _is_active('daftar_pasien.php', $current_page, $force); ?>"
                       href="/puskesmas/view/dokter/daftar_pasien.php">
                       Daftar Pasien
                    </a>
                </li>

                <li>
                    <a class="<?php echo _is_active('riwayat_periksa.php', $current_page, $force); ?>"
                       href="/puskesmas/view/dokter/riwayat_periksa.php">
                       Riwayat Periksa
                    </a>
                </li>

            <?php endif; ?>

        </ul>
    </nav>
</aside>
