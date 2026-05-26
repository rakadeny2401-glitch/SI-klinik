<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pasien') {
    echo "Akses ditolak!";
    exit;
}

$id_pasien = $_SESSION['data']['id_pasien'] ?? '';
$nama_pasien = $_SESSION['data']['nama_pasien'] ?? '';
$nik = $_SESSION['data']['nik'] ?? '';
$alamat = $_SESSION['data']['alamat_pasien'] ?? '';
$jenis_kelamin = $_SESSION['data']['jenis_kelamin'] ?? '';
$umur = $_SESSION['data']['umur'] ?? '';

$querySpesialis = mysqli_query($koneksi, "SELECT id_spesialis, nama_spesialis FROM spesialis ORDER BY nama_spesialis ASC");

$page_style = ['form_pendaftaran_pasien.css'];
$page_title = 'Form Pendaftaran - Pasien';
$force_active_menu = 'pendaftaran';
include __DIR__ . '/../layout/header.php';
?>

<h2>Form Pendaftaran</h2>
<form action="../../controller/tambah_pendaftaran_pasien_proses.php" method="POST" id="form-pendaftaran">
    <fieldset>
        <legend>Data Pasien</legend>
        <div class="form-group">
            <label>Nama Pasien</label>
            <input type="text" name="nama_pasien" value="<?= htmlspecialchars($nama_pasien); ?>" readonly class="readonly">
        </div>

        <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik_manual" value="<?= htmlspecialchars($nik); ?>" readonly class="readonly">
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat_pasien" readonly class="readonly"><?= htmlspecialchars($alamat); ?></textarea>
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <input type="text" name="jenis_kelamin" value="<?= htmlspecialchars($jenis_kelamin); ?>" readonly class="readonly">
        </div>

        <div class="form-group">
            <label>Umur</label>
            <input type="text" name="umur" value="<?= htmlspecialchars($umur); ?>" readonly class="readonly">
        </div>
    </fieldset>

    <fieldset>
        <legend>Data Pendaftaran</legend>
        <div class="form-group">
            <label>Waktu Pendaftaran</label>
            <input type="time" id="waktu_daftar" name="waktu_daftar" required>
        </div>

        <div class="form-group">
            <label>Spesialis</label>
            <select id="id_spesialis" name="id_spesialis" required>
                <option value="">-- Pilih Spesialis --</option>
                <?php while ($s = mysqli_fetch_assoc($querySpesialis)) { ?>
                    <option value="<?= $s['id_spesialis']; ?>"><?= htmlspecialchars($s['nama_spesialis']); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Dokter Terpilih</label>
            <input type="text" id="dokter_terpilih_info" readonly>
            <input type="hidden" id="id_dokter" name="id_dokter">
        </div>

        <div class="form-group">
            <label>Keluhan</label>
            <textarea id="keluhan" name="keluhan" required></textarea>
        </div>

        <input type="hidden" name="id_pasien" value="<?= htmlspecialchars($id_pasien); ?>">
    </fieldset>

    <button type="submit">Simpan</button>
</form>

<div id="dokter-data" data-json="<?php
    $allDokter = mysqli_query($koneksi, "SELECT id_dokter, nama_dokter, id_spesialis, waktu_kerja, waktu_pulang FROM dokter");
    $map = [];
    while ($d = mysqli_fetch_assoc($allDokter)) {
        $mulai = $d['waktu_kerja'] ? substr($d['waktu_kerja'], 0, 5) : '';
        $pulang = $d['waktu_pulang'] ? substr($d['waktu_pulang'], 0, 5) : '';
        $d['jam_kerja'] = $mulai && $pulang ? $mulai.' - '.$pulang : '';
        $map[$d['id_spesialis']][] = $d;
    }
    echo htmlspecialchars(json_encode($map), ENT_QUOTES, 'UTF-8');
?>"></div>

<script src="/puskesmas/style/js/validasi_pendaftaran.js"></script>
<script src="/puskesmas/style/js/pendaftaran_form.js"></script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
