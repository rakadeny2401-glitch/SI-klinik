-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 26, 2026 at 03:43 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puskesmas`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama_admin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `waktu_jaga` time NOT NULL,
  `passwordadmin` char(6) DEFAULT NULL,
  `id_akses` int NOT NULL,
  `no_identitas` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `waktu_jaga`, `passwordadmin`, `id_akses`, `no_identitas`) VALUES
(11, 'Muhamad Ikhsan Nur', '07:00:00', '123456', 2, '1237124399374381'),
(42, 'ilham', '17:25:00', '123456', 2, '1010806004490814');

-- --------------------------------------------------------

--
-- Table structure for table `daftar`
--

CREATE TABLE `daftar` (
  `id_daftar` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_spesialis` int NOT NULL,
  `id_dokter` int DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `nama_pasien` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alamat_pasien` text NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `umur` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nik` char(16) DEFAULT NULL,
  `keluhan` text,
  `waktu_daftar` datetime NOT NULL,
  `status_pendaftaran` enum('pengecekan','dikonfirmasi','pemeriksaan','selesai') DEFAULT 'pengecekan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daftar`
--

INSERT INTO `daftar` (`id_daftar`, `id_pasien`, `id_spesialis`, `id_dokter`, `id_admin`, `nama_pasien`, `alamat_pasien`, `jenis_kelamin`, `umur`, `nik`, `keluhan`, `waktu_daftar`, `status_pendaftaran`) VALUES
(38, 19, 33, 16, 11, 'Alviano Diego Ozbar', 'asd', 'L', '20', '1234567891234565', 'Ruam Ruam', '2025-12-11 09:00:00', 'selesai'),
(39, 18, 33, 16, 11, 'icih karolinee', 'asd', 'P', '21', '1234567891234567', 'Imunisasi', '2025-12-11 09:00:00', 'selesai'),
(40, 19, 33, 16, 11, 'Alviano Diego Ozbar', 'asd', 'L', '20', '1234567891234565', 'muntaber', '2025-12-11 09:00:00', 'selesai'),
(41, 20, 33, 16, 11, 'Robi Samsudin', 'Kp.Sukamanah, Blok 07 Rw 8 Rt 1 cisaranten Kota Bandung', 'L', '40', '1234567891234560', 'tes', '2025-12-13 08:29:00', 'selesai'),
(42, 21, 33, 16, 11, 'Iim Rohiman', 'Perm. Permata Regency Rt01 Rw09 Kab.Bandung ', 'L', '55', '1234567891234561', 'tes lagi\r\n', '2025-12-13 08:45:00', 'selesai'),
(43, 19, 33, 16, 11, 'Alviano Diego Ozbar', 'asd', 'L', '20', '1234567891234565', 'tes2', '2025-12-13 09:00:00', 'selesai'),
(44, 18, 33, 16, 11, 'icih karolinee', 'asd', 'P', '21', '1234567891234567', 'tes', '2025-12-13 09:00:00', 'selesai'),
(45, 19, 33, 16, 11, 'Alviano Diego Ozbar', 'asd', 'L', '20', '1234567891234565', 'bv', '2025-12-14 09:00:00', 'selesai'),
(52, 19, 33, 16, 11, 'Alviano Diego Ozbar', 'asd', 'L', '20', '1234567891234565', 'asd', '2025-12-15 09:00:00', 'selesai'),
(53, 21, 35, 17, 11, 'Iim Rohiman', 'Perm. Permata Regency Rt01 Rw09 Kab.Bandung ', 'L', '55', '1234567891234561', 'asd', '2025-12-15 09:00:00', 'selesai'),
(54, 18, 33, 16, 11, 'icih karolinee', 'asd', 'P', '21', '1234567891234567', 'asd', '2025-12-15 09:00:00', 'selesai'),
(55, 21, 33, 16, 11, 'Iim Rohiman', 'Perm. Permata Regency Rt01 Rw09 Kab.Bandung ', 'L', '55', '1234567891234561', 'asd', '2025-12-15 09:00:00', 'selesai'),
(56, 19, 35, 17, 11, 'Alviano Diego Ozbar', 'asd', 'L', '20', '1234567891234565', 'asd', '2025-12-15 09:00:00', 'selesai'),
(57, 20, 35, 17, 11, 'Robi Samsudin', 'Kp.Sukamanah, Blok 07 Rw 8 Rt 1 cisaranten Kota Bandung', 'L', '40', '1234567891234560', 'asd', '2025-12-15 09:00:00', 'selesai'),
(58, 18, 33, 16, 11, 'icih karolinee', 'asd', 'P', '21', '1234567891234567', 'ruam ruam', '2025-12-15 09:00:00', 'selesai'),
(59, 19, 33, 16, 11, 'Alviano Diego Ozbar', 'asd', 'L', '20', '1234567891234565', 'campak', '2025-12-15 09:00:00', 'selesai'),
(60, 21, 33, 16, 11, 'Iim Rohiman', 'Perm. Permata Regency Rt01 Rw09 Kab.Bandung ', 'L', '55', '1234567891234561', 'rubela', '2025-12-15 09:00:00', 'selesai'),
(61, 20, 33, 16, 11, 'Robi Samsudin', 'Kp.Sukamanah, Blok 07 Rw 8 Rt 1 cisaranten Kota Bandung', 'L', '40', '1234567891234560', 'campak', '2025-12-15 09:00:00', 'selesai'),
(62, 24, 33, 16, 11, 'Ilham Romadona', 'Bandung', 'L', '20', '1234567897334567', 'muntaber', '2025-12-15 09:00:00', 'selesai'),
(74, 18, 33, 16, 11, 'icih karolinee', 'asd', 'P', '21', '1234567891234567', 'Muntaber', '2025-12-23 10:00:00', 'selesai'),
(75, 19, 33, 16, 11, 'Alviano Diego Ozbar', 'Demam Tinggi', 'L', '20', '1234567891234565', 'Demam Tinggi', '2025-12-23 10:00:00', 'selesai'),
(76, 20, 35, 17, 11, 'Robi Samsudin', 'Kp.Sukamanah, Blok 07 Rw 8 Rt 1 cisaranten Kota Bandung', 'L', '40', '1234567891234560', 'kulit deh', '2025-12-23 10:00:00', 'selesai'),
(80, 20, 35, 17, 11, 'Robi Samsudin', 'Kp.Sukamanah, Blok 07 Rw 8 Rt 1 cisaranten Kota Bandung', 'L', '40', '1234567891234560', 'arateul\r\n', '2025-12-23 13:00:00', 'selesai'),
(81, 18, 33, 16, 11, 'icih karolinee', 'asd', 'P', '21', '1234567891234567', 'Benjolan Ditenggorokan', '2026-01-22 09:00:00', 'selesai'),
(82, 21, 33, 16, 11, 'Iim Rohiman', 'Perm. Permata Regency Rt01 Rw09 Kab.Bandung ', 'L', '55', '1234567891234561', 'ruam ruam', '2026-01-22 10:00:00', 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` int NOT NULL,
  `nama_dokter` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `no_hp_dokter` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alamat_dokter` text,
  `tgl_lahir_dokter` date DEFAULT NULL,
  `waktu_kerja` time NOT NULL,
  `waktu_pulang` time DEFAULT NULL,
  `passworddok` char(6) DEFAULT NULL,
  `id_spesialis` int NOT NULL,
  `id_akses` int NOT NULL,
  `no_identitas` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `nama_dokter`, `no_hp_dokter`, `alamat_dokter`, `tgl_lahir_dokter`, `waktu_kerja`, `waktu_pulang`, `passworddok`, `id_spesialis`, `id_akses`, `no_identitas`) VALUES
(16, 'Dilan', '0881023541120', 'Jln. Riau No.781 Kota Bandung', '1998-12-11', '07:30:00', '13:30:00', '123456', 33, 3, '1237175257816291'),
(17, 'Ancika Mehrunisa Rabu', '0881023541121', 'Jln. Banda No.48 Kota Bandung', '2000-01-09', '07:30:00', '13:30:00', '123456', 35, 3, '640778721204822');

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id_akses` int NOT NULL,
  `nama_akses` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id_akses`, `nama_akses`) VALUES
(1, 'pasien'),
(2, 'admin'),
(3, 'dokter');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int NOT NULL,
  `nik` char(16) DEFAULT NULL,
  `nama_pasien` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alamat_pasien` text NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `umur` varchar(10) NOT NULL,
  `no_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` char(6) DEFAULT NULL,
  `id_akses` int NOT NULL,
  `no_identitas` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nik`, `nama_pasien`, `alamat_pasien`, `jenis_kelamin`, `umur`, `no_hp`, `password`, `id_akses`, `no_identitas`) VALUES
(18, '1234567891234567', 'icih karolinee', 'asd', 'P', '21', '085845457241', '111111', 1, '7344500640818426'),
(19, '1234567891234565', 'Alviano Diego Ozbar', 'asd', 'L', '20', '085845457241', '123456', 1, '7413410149839520'),
(20, '1234567891234560', 'Robi Samsudin', 'Kp.Sukamanah, Blok 07 Rw 8 Rt 1 cisaranten Kota Bandung', 'L', '40', '089735142814', '123456', 1, '1180526083236038'),
(21, '1234567891234561', 'Iim Rohiman', 'Perm. Permata Regency Rt01 Rw09 Kab.Bandung ', 'L', '55', '089735142817', '123456', 1, '0548374744288086'),
(24, '1234567897334567', 'Ilham Romadona', 'Bandung', 'L', '20', '089735142814', '123456', 1, '0764329535926759'),
(25, '1434567891234567', 'Azhar Abe', 'Melong', 'L', '20', '089735142817', '123456', 1, '7061124173808940'),
(26, '1239023871563271', 'asdasd', 'asd', 'L', '12', '1254321', '123445', 1, '4798328398275499'),
(27, '1234567891234522', 'Azhar Abe', 'cijerah II', 'L', '20', '12123123', '123445', 1, '5680157651701792');

-- --------------------------------------------------------

--
-- Table structure for table `proses_pasien`
--

CREATE TABLE `proses_pasien` (
  `id_proses` int UNSIGNED NOT NULL,
  `id_daftar` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_dokter` int NOT NULL,
  `id_admin` int NOT NULL,
  `id_spesialis` int NOT NULL,
  `no_antrian` varchar(10) NOT NULL,
  `tgl_pemeriksaan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `proses_pasien`
--

INSERT INTO `proses_pasien` (`id_proses`, `id_daftar`, `id_pasien`, `id_dokter`, `id_admin`, `id_spesialis`, `no_antrian`, `tgl_pemeriksaan`) VALUES
(30, 38, 19, 16, 11, 33, 'A-001', '2025-12-11 09:00:00'),
(31, 39, 18, 16, 11, 33, 'A-002', '2025-12-11 09:30:00'),
(32, 40, 19, 16, 11, 33, 'A-001', '2025-12-11 09:00:00'),
(33, 41, 20, 16, 11, 33, 'A-001', '2025-12-13 08:29:00'),
(34, 42, 21, 16, 11, 33, 'A-002', '2025-12-13 08:45:00'),
(35, 43, 19, 16, 11, 33, 'A-003', '2025-12-13 09:00:00'),
(36, 44, 18, 16, 11, 33, 'A-004', '2025-12-13 09:30:00'),
(37, 45, 19, 16, 11, 33, 'A-002', '2025-12-14 09:00:00'),
(44, 52, 19, 16, 11, 33, 'A-002', '2025-12-15 09:00:00'),
(45, 53, 21, 17, 11, 35, 'K-001', '2025-12-15 09:00:00'),
(46, 54, 18, 16, 11, 33, 'A-001', '2025-12-15 09:00:00'),
(47, 55, 21, 16, 11, 33, 'A-002', '2025-12-15 09:30:00'),
(48, 56, 19, 17, 11, 35, 'K-001', '2025-12-15 09:00:00'),
(49, 57, 20, 17, 11, 35, 'K-002', '2025-12-15 09:30:00'),
(50, 58, 18, 16, 11, 33, 'A-001', '2025-12-15 09:00:00'),
(51, 59, 19, 16, 11, 33, 'A-002', '2025-12-15 09:30:00'),
(52, 60, 21, 16, 11, 33, 'A-003', '2025-12-15 10:00:00'),
(53, 61, 20, 16, 11, 33, 'A-004', '2025-12-15 10:30:00'),
(54, 62, 24, 16, 11, 33, 'A-005', '2025-12-15 11:00:00'),
(56, 74, 18, 16, 11, 33, 'A-001', '2025-12-15 11:30:00'),
(57, 75, 19, 16, 11, 33, 'A-002', '2025-12-15 12:00:00'),
(58, 76, 20, 17, 11, 35, 'K-001', '2025-12-15 10:00:00'),
(59, 80, 20, 17, 11, 35, 'K-001', '2025-12-15 10:30:00'),
(60, 80, 20, 17, 11, 35, 'K-002', '2025-12-15 11:00:00'),
(61, 82, 21, 16, 11, 33, 'A-001', '2026-01-22 10:00:00'),
(62, 81, 18, 16, 11, 33, 'A-002', '2026-01-22 10:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `resep_obat`
--

CREATE TABLE `resep_obat` (
  `id_resep` int NOT NULL,
  `id_daftar` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_dokter` int NOT NULL,
  `jenis_obat` text NOT NULL,
  `id_proses` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `resep_obat`
--

INSERT INTO `resep_obat` (`id_resep`, `id_daftar`, `id_pasien`, `id_dokter`, `jenis_obat`, `id_proses`) VALUES
(18, 38, 19, 16, 'CTM, Apurinol', 30),
(19, 39, 18, 16, 'Obat Rubella 250cc', 31),
(20, 40, 19, 16, 'Paracetamol, Pereda Nyeri, Panadol', 32),
(21, 41, 20, 16, 'Panadol', 33),
(22, 42, 21, 16, 'ads', 34),
(23, 43, 19, 16, 'asd', 35),
(24, 45, 19, 16, 'asd', 37),
(25, 54, 18, 16, 'Panadol', 46),
(26, 55, 21, 16, 'Paramex', 47),
(27, 56, 19, 17, 'Panadol', 48),
(28, 57, 20, 17, 'Panadol', 49),
(29, 58, 18, 16, 'panadol', 50),
(30, 62, 24, 16, 'asd', 54),
(31, 76, 20, 17, 'Panadol', 58),
(32, 80, 20, 17, 'ctm', 59),
(33, 74, 18, 16, 'Oralit', 56),
(34, 75, 19, 16, 'paramex', 57),
(35, 82, 21, 16, 'Hydrocortisone Cream 2.5%', 61),
(36, 81, 18, 16, 'asd', 62);

-- --------------------------------------------------------

--
-- Table structure for table `spesialis`
--

CREATE TABLE `spesialis` (
  `id_spesialis` int NOT NULL,
  `nama_spesialis` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `spesialis`
--

INSERT INTO `spesialis` (`id_spesialis`, `nama_spesialis`) VALUES
(33, 'Anak'),
(35, 'Kulit'),
(64, 'THT');

-- --------------------------------------------------------

--
-- Table structure for table `srt_rkrmdsi_rujukan`
--

CREATE TABLE `srt_rkrmdsi_rujukan` (
  `id_rujukan` int NOT NULL,
  `id_daftar` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_dokter` int NOT NULL,
  `rekomendasi` text NOT NULL,
  `id_proses` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `srt_rkrmdsi_rujukan`
--

INSERT INTO `srt_rkrmdsi_rujukan` (`id_rujukan`, `id_daftar`, `id_pasien`, `id_dokter`, `rekomendasi`, `id_proses`) VALUES
(4, 39, 18, 16, 'Direkomendasikan cek ke rumah sakit terdekat', 31),
(5, 45, 19, 16, 'Rujukan Ke RSHS', 37),
(6, 54, 18, 16, 'Menuju Ke RSHS', 46),
(7, 56, 19, 17, 'Diajukan untuk dirujuk ke rumah sakit besar', 48),
(8, 80, 20, 17, 'Apabila kembali merasakan gatal yang tidak reda dalam 1-2 hari kedepan, maka surat ini dibuat untuk memberikan rekomendasi kepada An.Robi Samsudin untuk melakukan pemeriksaan lebih lanjut ke rumah sakit Hasan Sadikin Bandung. ', 59),
(9, 80, 20, 17, 'Apabila kembali merasakan gatal yang tidak reda dalam 1-2 hari kedepan, maka surat ini dibuat untuk memberikan rekomendasi kepada An.Robi Samsudin untuk melakukan pemeriksaan lebih lanjut ke rumah sakit Hasan Sadikin Bandung. ', 59),
(10, 74, 18, 16, 'Dirujuk ke Rumah Sakit Hasan Sadikin Bandung', 56),
(11, 81, 18, 16, 'diperlukan penanganan medis lebih lanjut, surat ini di tujukan kepada\r\nrumah sakit Hasan Sadikin', 62);

-- --------------------------------------------------------

--
-- Table structure for table `surat_ktrgnsakit`
--

CREATE TABLE `surat_ktrgnsakit` (
  `id_surat` int NOT NULL,
  `id_daftar` int NOT NULL,
  `id_pasien` int NOT NULL,
  `id_dokter` int NOT NULL,
  `keterangan` text NOT NULL,
  `jml_istirahat` int NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `id_proses` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `surat_ktrgnsakit`
--

INSERT INTO `surat_ktrgnsakit` (`id_surat`, `id_daftar`, `id_pasien`, `id_dokter`, `keterangan`, `jml_istirahat`, `tgl_mulai`, `tgl_selesai`, `id_proses`) VALUES
(3, 38, 19, 16, 'Surat Izin untuk tidak mengikuti kegiatan perkuliahan selama 1 hari', 1, '2025-12-11', '2025-12-12', 30),
(4, 41, 20, 16, 'Pasien mengajukan cuti selama 1 hari', 1, '2025-12-13', '2025-12-14', 33),
(5, 45, 19, 16, 'wqe', 2, '2025-12-14', '2025-12-15', 37),
(6, 54, 18, 16, 'Sakit 2 hari', 2, '2025-12-15', '2025-12-16', 46),
(7, 55, 21, 16, 'sakit dalam 1 hari', 1, '2025-12-15', '2025-12-15', 47),
(8, 56, 19, 17, 'sakit dalam 1 minggu', 7, '2025-12-15', '2025-12-21', 48),
(9, 57, 20, 17, 'Izin tidak masuk sekolah dalam 2 hari', 2, '2025-12-15', '2025-12-16', 49),
(10, 62, 24, 16, 'izin tidak sekolah selama 2 hari', 2, '2025-12-16', '2025-12-17', 54),
(11, 76, 20, 17, 'izin tidak masuk sekolah selama 2 hari ', 2, '2025-12-23', '2025-12-24', 58),
(12, 74, 18, 16, 'Diperlukan istirahat dirumah selama 2 hari', 2, '2025-12-29', '2025-12-30', 56),
(13, 82, 21, 16, 'dinyatakan sakit dalam 2 hari kedepan, sehingga perlu istirahat yang cukup untuk mengembalikan kesehatan pasien', 2, '2026-01-22', '2026-01-23', 61);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `no_identitas` (`no_identitas`),
  ADD KEY `id_akses` (`id_akses`);

--
-- Indexes for table `daftar`
--
ALTER TABLE `daftar`
  ADD PRIMARY KEY (`id_daftar`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_spesialis` (`id_spesialis`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `fk_daftar_nik` (`nik`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD UNIQUE KEY `no_identitas` (`no_identitas`),
  ADD KEY `id_spesialis` (`id_spesialis`),
  ADD KEY `id_akses` (`id_akses`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `no_identitas` (`no_identitas`),
  ADD KEY `id_akses` (`id_akses`);

--
-- Indexes for table `proses_pasien`
--
ALTER TABLE `proses_pasien`
  ADD PRIMARY KEY (`id_proses`),
  ADD KEY `id_daftar` (`id_daftar`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_spesialis` (`id_spesialis`);

--
-- Indexes for table `resep_obat`
--
ALTER TABLE `resep_obat`
  ADD PRIMARY KEY (`id_resep`),
  ADD KEY `id_daftar` (`id_daftar`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `idx_resep_id_proses` (`id_proses`);

--
-- Indexes for table `spesialis`
--
ALTER TABLE `spesialis`
  ADD PRIMARY KEY (`id_spesialis`);

--
-- Indexes for table `srt_rkrmdsi_rujukan`
--
ALTER TABLE `srt_rkrmdsi_rujukan`
  ADD PRIMARY KEY (`id_rujukan`),
  ADD KEY `id_daftar` (`id_daftar`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_proses` (`id_proses`);

--
-- Indexes for table `surat_ktrgnsakit`
--
ALTER TABLE `surat_ktrgnsakit`
  ADD PRIMARY KEY (`id_surat`),
  ADD KEY `id_daftar` (`id_daftar`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `surat_ktrgnsakit_ibfk_4` (`id_proses`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `daftar`
--
ALTER TABLE `daftar`
  MODIFY `id_daftar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id_dokter` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id_akses` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `proses_pasien`
--
ALTER TABLE `proses_pasien`
  MODIFY `id_proses` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `resep_obat`
--
ALTER TABLE `resep_obat`
  MODIFY `id_resep` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `spesialis`
--
ALTER TABLE `spesialis`
  MODIFY `id_spesialis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `srt_rkrmdsi_rujukan`
--
ALTER TABLE `srt_rkrmdsi_rujukan`
  MODIFY `id_rujukan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `surat_ktrgnsakit`
--
ALTER TABLE `surat_ktrgnsakit`
  MODIFY `id_surat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_akses`) REFERENCES `hak_akses` (`id_akses`);

--
-- Constraints for table `daftar`
--
ALTER TABLE `daftar`
  ADD CONSTRAINT `daftar_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `daftar_ibfk_2` FOREIGN KEY (`id_spesialis`) REFERENCES `spesialis` (`id_spesialis`),
  ADD CONSTRAINT `daftar_ibfk_3` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  ADD CONSTRAINT `daftar_ibfk_4` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `fk_daftar_nik` FOREIGN KEY (`nik`) REFERENCES `pasien` (`nik`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `dokter_ibfk_1` FOREIGN KEY (`id_spesialis`) REFERENCES `spesialis` (`id_spesialis`),
  ADD CONSTRAINT `dokter_ibfk_2` FOREIGN KEY (`id_akses`) REFERENCES `hak_akses` (`id_akses`);

--
-- Constraints for table `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_ibfk_1` FOREIGN KEY (`id_akses`) REFERENCES `hak_akses` (`id_akses`);

--
-- Constraints for table `proses_pasien`
--
ALTER TABLE `proses_pasien`
  ADD CONSTRAINT `proses_pasien_ibfk_1` FOREIGN KEY (`id_daftar`) REFERENCES `daftar` (`id_daftar`),
  ADD CONSTRAINT `proses_pasien_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `proses_pasien_ibfk_3` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  ADD CONSTRAINT `proses_pasien_ibfk_4` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `proses_pasien_ibfk_5` FOREIGN KEY (`id_spesialis`) REFERENCES `spesialis` (`id_spesialis`);

--
-- Constraints for table `resep_obat`
--
ALTER TABLE `resep_obat`
  ADD CONSTRAINT `fk_resep_proses4` FOREIGN KEY (`id_proses`) REFERENCES `proses_pasien` (`id_proses`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `resep_obat_ibfk_1` FOREIGN KEY (`id_daftar`) REFERENCES `daftar` (`id_daftar`),
  ADD CONSTRAINT `resep_obat_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `resep_obat_ibfk_3` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`);

--
-- Constraints for table `srt_rkrmdsi_rujukan`
--
ALTER TABLE `srt_rkrmdsi_rujukan`
  ADD CONSTRAINT `fk_rkm_proses` FOREIGN KEY (`id_proses`) REFERENCES `proses_pasien` (`id_proses`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `srt_rkrmdsi_rujukan_ibfk_1` FOREIGN KEY (`id_daftar`) REFERENCES `daftar` (`id_daftar`),
  ADD CONSTRAINT `srt_rkrmdsi_rujukan_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `srt_rkrmdsi_rujukan_ibfk_3` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`);

--
-- Constraints for table `surat_ktrgnsakit`
--
ALTER TABLE `surat_ktrgnsakit`
  ADD CONSTRAINT `surat_ktrgnsakit_ibfk_1` FOREIGN KEY (`id_daftar`) REFERENCES `daftar` (`id_daftar`),
  ADD CONSTRAINT `surat_ktrgnsakit_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `surat_ktrgnsakit_ibfk_3` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  ADD CONSTRAINT `surat_ktrgnsakit_ibfk_4` FOREIGN KEY (`id_proses`) REFERENCES `proses_pasien` (`id_proses`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
