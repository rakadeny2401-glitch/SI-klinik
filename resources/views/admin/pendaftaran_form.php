<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak!";
    exit;
}

$querySpesialis = mysqli_query($koneksi, "SELECT id_spesialis, nama_spesialis FROM spesialis ORDER BY nama_spesialis ASC");

$page_style = ['form_pendaftaran.css'];
$page_title = 'Form Pendaftaran Pasien';
include __DIR__ . '/../layout/header.php';
?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<div id="localhost-toast-box"></div>
<h2>Form Pendaftaran Pasien</h2>
<form action="../../controller/tambah_pendaftaran_proses.php" method="POST" id="form-pendaftaran">
    <fieldset>
        <legend>Data Pasien</legend>
        <div class="form-group">
            <label>NIK Pasien</label>
            <select id="nik" name="id_pasien" style="width:100%"></select>
        </div>
        
        <div class="form-group">
            <label>Nama Pasien</label>
            <input type="text" id="nama_pasien" name="nama_pasien" readonly>
        </div>
        
        <div class="form-group">
            <label>NIK</label>
            <input type="text" id="nik_manual" name="nik_manual" readonly>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea id="alamat_pasien" name="alamat_pasien" readonly></textarea>
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <input type="text" id="jenis_kelamin" name="jenis_kelamin" readonly>
        </div>

        <div class="form-group">
            <label>Umur</label>
            <input type="text" id="umur" name="umur" readonly>
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
                    <option value="<?= $s['id_spesialis']; ?>">
                        <?= htmlspecialchars($s['nama_spesialis']); ?>
                    </option>
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

            <div class="form-group">
                <label>Admin</label>
                <input type="text" readonly value="<?= htmlspecialchars($_SESSION['data']['nama_admin']); ?>">
                <input type="hidden" name="id_admin_value" value="<?= htmlspecialchars($_SESSION['data']['id_admin']); ?>">
            </div>
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
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/puskesmas/style/js/validasi_pendaftaran.js"></script>
    <script src="/puskesmas/style/js/pendaftaran_form.js"></script>
    <script>
        $('#nik').on('select2:select', function (e) {
        let d = e.params.data;
        $('#nama_pasien').val(d.nama);
        $('#nik_manual').val(d.nik);
        $('#alamat_pasien').val(d.alamat);
        $('#jenis_kelamin').val(d.jk);
        $('#umur').val(d.umur);
        updateDokterOtomatis();
    });

    </script>

    <?php include __DIR__ . '/../layout/footer.php'; ?>
