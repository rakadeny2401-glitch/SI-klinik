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
    <title>Edit Pengguna <?php echo htmlspecialchars($role_friendly ?? $role); ?></title>
    <link rel="stylesheet" href="../../style/css/edit_pengguna.css">

</head>
<body>

<div class="edit-container">

    <div class="edit-header">
        <h2>Edit Pengguna (<?php echo htmlspecialchars(ucfirst($role)); ?>)</h2>
    </div>

    <form action="../../controller/edit_pengguna_proses.php" method="POST" onsubmit="return validateForm()">

        <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <?php if ($role === 'pasien'): ?>

            <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik" maxlength="16"
                       value="<?php echo htmlspecialchars($details['nik'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama_pasien"
                       value="<?php echo htmlspecialchars($details['nama_pasien'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat_pasien" required><?php echo htmlspecialchars($details['alamat_pasien'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>Umur</label>
                <input type="text" name="umur" inputmode="numeric" pattern="\d*"
                       value="<?php echo htmlspecialchars($details['umur'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <label><input type="radio" name="jenis_kelamin" value="L" <?php echo ($details['jenis_kelamin'] ?? '') === 'L' ? 'checked' : ''; ?>> Laki-laki</label>
                <label><input type="radio" name="jenis_kelamin" value="P" <?php echo ($details['jenis_kelamin'] ?? '') === 'P' ? 'checked' : ''; ?>> Perempuan</label>
            </div>

            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp" inputmode="numeric" pattern="\d*"
                       value="<?php echo htmlspecialchars($details['no_hp'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>PIN (opsional)</label>
                <input type="text" id="password-pasien" name="password" maxlength="6">
                <div class="pw-note" id="note-pasien" style="display:none;">PIN harus 6 digit angka</div>
            </div>

        <?php elseif ($role === 'admin'): ?>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama_admin"
                       value="<?php echo htmlspecialchars($details['nama_admin'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Waktu Jaga</label>
                <input type="time" name="waktu_jaga"
                       value="<?php echo htmlspecialchars($details['waktu_jaga'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>PIN (opsional)</label>
                <input type="text" id="password-admin" name="passwordadmin" maxlength="6">
                <div class="pw-note" id="note-admin" style="display:none;">PIN harus 6 digit angka</div>
            </div>

        <?php elseif ($role === 'dokter'): ?>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama_dokter"
                       value="<?php echo htmlspecialchars($details['nama_dokter'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp_dokter" inputmode="numeric" pattern="\d*"
                       value="<?php echo htmlspecialchars($details['no_hp_dokter'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat_dokter"><?php echo htmlspecialchars($details['alamat_dokter'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir_dokter"
                       value="<?php echo htmlspecialchars($details['tgl_lahir_dokter'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Waktu Kerja</label>
                <input type="time" name="waktu_kerja"
                       value="<?php echo htmlspecialchars($details['waktu_kerja'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Spesialis</label>
                <select name="id_spesialis" required>
                    <option value="">-- Pilih Spesialis --</option>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM spesialis");
                    while ($r = mysqli_fetch_assoc($q)) {
                        $sel = ($details['id_spesialis'] == $r['id_spesialis']) ? 'selected' : '';
                        echo "<option value='".htmlspecialchars($r['id_spesialis'])."' $sel>"
                             .htmlspecialchars($r['nama_spesialis'])."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>PIN (opsional)</label>
                <input type="text" id="password-dokter" name="passworddok" maxlength="6">
                <div class="pw-note" id="note-dokter" style="display:none;">PIN harus 6 digit angka</div>
            </div>

        <?php else: ?>
            <p>Role tidak valid.</p>
        <?php endif; ?>

        <div class="btn-group">
            <button type="submit" class="btn-save btn-half">Simpan</button>
        </div>

    </form>

    <div class="btn-back-wrapper">
        <button class="btn-back"
                onclick="window.location.href='lihat_pengguna_detail.php?role=<?php echo urlencode($role); ?>&id=<?php echo urlencode($id); ?>'">
            Kembali
        </button>
    </div>

</div>

<script src="../../style/js/edit-pengguna.js"></script>

</body>
</html>
