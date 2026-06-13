-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2026 at 10:57 AM
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
-- Database: `puskesmas_fix`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` bigint UNSIGNED NOT NULL,
  `nama_admin` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_jaga` time NOT NULL,
  `passwordadmin` char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_akses` bigint UNSIGNED NOT NULL,
  `no_identitas` char(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `waktu_jaga`, `passwordadmin`, `id_akses`, `no_identitas`) VALUES
(1, 'Admin Utama', '08:00:00', '123456', 1, '1234567890123456');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daftar`
--

CREATE TABLE `daftar` (
  `id_daftar` bigint UNSIGNED NOT NULL,
  `id_pasien` bigint UNSIGNED NOT NULL,
  `id_spesialis` bigint UNSIGNED NOT NULL,
  `id_dokter` bigint UNSIGNED DEFAULT NULL,
  `id_admin` bigint UNSIGNED DEFAULT NULL,
  `nama_pasien` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_pasien` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `umur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` char(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keluhan` text COLLATE utf8mb4_unicode_ci,
  `waktu_daftar` datetime NOT NULL,
  `status_pendaftaran` enum('pengecekan','dikonfirmasi','pemeriksaan','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daftar`
--

INSERT INTO `daftar` (`id_daftar`, `id_pasien`, `id_spesialis`, `id_dokter`, `id_admin`, `nama_pasien`, `alamat_pasien`, `jenis_kelamin`, `umur`, `nik`, `keluhan`, `waktu_daftar`, `status_pendaftaran`) VALUES
(8, 1, 2, 1, 1, 'nanang', 'bandung', 'L', '212', '1234567891234567', 'asdas', '2026-06-06 12:12:00', 'selesai'),
(9, 1, 2, 1, 1, 'nanang', 'bandung', 'L', '212', '1234567891234567', 'asd', '2026-06-06 12:12:00', 'selesai'),
(10, 1, 2, 1, 1, 'nanang', 'bandung', 'L', '212', '1234567891234567', 'asd', '2026-06-06 12:12:00', 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` bigint UNSIGNED NOT NULL,
  `nama_dokter` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp_dokter` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_dokter` text COLLATE utf8mb4_unicode_ci,
  `tgl_lahir_dokter` date DEFAULT NULL,
  `waktu_kerja` time NOT NULL,
  `waktu_pulang` time DEFAULT NULL,
  `passworddok` char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_spesialis` bigint UNSIGNED NOT NULL,
  `id_akses` bigint UNSIGNED NOT NULL,
  `no_identitas` char(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `nama_dokter`, `no_hp_dokter`, `alamat_dokter`, `tgl_lahir_dokter`, `waktu_kerja`, `waktu_pulang`, `passworddok`, `id_spesialis`, `id_akses`, `no_identitas`) VALUES
(1, 'siti', '123123', 'bandung', '2026-06-17', '09:00:00', '15:00:00', '123456', 2, 2, '1306359342928060');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id_akses` bigint UNSIGNED NOT NULL,
  `nama_akses` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id_akses`, `nama_akses`) VALUES
(1, 'Admin'),
(2, 'Dokter'),
(3, 'Pasien');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_06_050941_create_hak_akses_table', 1),
(5, '2026_06_06_051046_create_spesialis_table', 1),
(6, '2026_06_06_051200_create_admins_table', 1),
(7, '2026_06_06_051201_create_dokters_table', 1),
(8, '2026_06_06_052000_create_pasiens_table', 1),
(9, '2026_06_06_060000_create_daftars_table', 1),
(10, '2026_06_06_060001_create_proses_pasiens_table', 1),
(11, '2026_06_06_060003_create_resep_obats_table', 1),
(12, '2026_06_06_060004_create_srt_rkmdsi_rujukans_table', 1),
(13, '2026_06_06_060005_create_surat_ktrgn_sakits_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` bigint UNSIGNED NOT NULL,
  `nik` char(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pasien` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_pasien` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `umur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_akses` bigint UNSIGNED NOT NULL,
  `no_identitas` char(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nik`, `nama_pasien`, `alamat_pasien`, `jenis_kelamin`, `umur`, `no_hp`, `password`, `id_akses`, `no_identitas`) VALUES
(1, '1234567891234567', 'nanang', 'bandung', 'L', '212', '123123123', '123456', 3, '1588806783794208');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proses_pasien`
--

CREATE TABLE `proses_pasien` (
  `id_proses` int UNSIGNED NOT NULL,
  `id_daftar` bigint UNSIGNED NOT NULL,
  `id_pasien` bigint UNSIGNED NOT NULL,
  `id_dokter` bigint UNSIGNED NOT NULL,
  `id_admin` bigint UNSIGNED NOT NULL,
  `id_spesialis` bigint UNSIGNED NOT NULL,
  `no_antrian` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pemeriksaan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `proses_pasien`
--

INSERT INTO `proses_pasien` (`id_proses`, `id_daftar`, `id_pasien`, `id_dokter`, `id_admin`, `id_spesialis`, `no_antrian`, `tgl_pemeriksaan`) VALUES
(6, 8, 1, 1, 1, 2, 'T-001', '2026-06-06 12:12:00'),
(7, 9, 1, 1, 1, 2, 'T-002', '2026-06-06 12:12:00'),
(8, 10, 1, 1, 1, 2, 'T-003', '2026-06-06 12:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `resep_obat`
--

CREATE TABLE `resep_obat` (
  `id_resep` bigint UNSIGNED NOT NULL,
  `id_daftar` bigint UNSIGNED NOT NULL,
  `id_pasien` bigint UNSIGNED NOT NULL,
  `id_dokter` bigint UNSIGNED NOT NULL,
  `jenis_obat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proses` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resep_obat`
--

INSERT INTO `resep_obat` (`id_resep`, `id_daftar`, `id_pasien`, `id_dokter`, `jenis_obat`, `id_proses`) VALUES
(1, 8, 1, 1, 'panadol', 6),
(2, 9, 1, 1, 'asd', 7),
(3, 10, 1, 1, 'asdasd', 8),
(4, 10, 1, 1, 'asdasd', 8),
(5, 10, 1, 1, 'asd', 8),
(6, 10, 1, 1, 'asd', 8),
(7, 10, 1, 1, 'asd', 8);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('issO6simTRMCI9Td2MqwFdwrtp5NCgCt6Ns2UYlK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.122.1 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'eyJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9wZW5kYWZ0YXJhblwvbGloYXQiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwiX3Rva2VuIjoiNEt3c1BqRnJyQ1Y4Z3BaaVVweGJLR09VaXowWkFaUEZMMk1rQUVGQSIsInJvbGUiOiJhZG1pbiIsImRhdGEiOnsiaWRfYWRtaW4iOjEsIm5hbWFfYWRtaW4iOiJBZG1pbiBVdGFtYSIsIndha3R1X2phZ2EiOiIwODowMDowMCIsInBhc3N3b3JkYWRtaW4iOiIxMjM0NTYiLCJpZF9ha3NlcyI6MSwibm9faWRlbnRpdGFzIjoiMTIzNDU2Nzg5MDEyMzQ1NiJ9fQ==', 1780742506),
('qHNcTJekTWpdIv897YIWt8VHvOgflrOzd1t08veo', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIyM0dZYTdKdlVtelQ0ZmNvckdRTkhsZEpFVE83NlhYZjJwa09KWEZFIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kb2t0ZXJcL2RhZnRhci1wYXNpZW4iLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwicm9sZSI6ImRva3RlciIsImRhdGEiOnsiaWRfZG9rdGVyIjoxLCJuYW1hX2Rva3RlciI6InNpdGkiLCJub19ocF9kb2t0ZXIiOiIxMjMxMjMiLCJhbGFtYXRfZG9rdGVyIjoiYmFuZHVuZyIsInRnbF9sYWhpcl9kb2t0ZXIiOiIyMDI2LTA2LTE3Iiwid2FrdHVfa2VyamEiOiIwOTowMDowMCIsIndha3R1X3B1bGFuZyI6IjE1OjAwOjAwIiwicGFzc3dvcmRkb2siOiIxMjM0NTYiLCJpZF9zcGVzaWFsaXMiOjIsImlkX2Frc2VzIjoyLCJub19pZGVudGl0YXMiOiIxMzA2MzU5MzQyOTI4MDYwIn19', 1780742430);

-- --------------------------------------------------------

--
-- Table structure for table `spesialis`
--

CREATE TABLE `spesialis` (
  `id_spesialis` bigint UNSIGNED NOT NULL,
  `nama_spesialis` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spesialis`
--

INSERT INTO `spesialis` (`id_spesialis`, `nama_spesialis`) VALUES
(2, 'THT'),
(3, 'Kulit');

-- --------------------------------------------------------

--
-- Table structure for table `srt_rkrmdsi_rujukan`
--

CREATE TABLE `srt_rkrmdsi_rujukan` (
  `id_rujukan` bigint UNSIGNED NOT NULL,
  `id_daftar` bigint UNSIGNED NOT NULL,
  `id_pasien` bigint UNSIGNED NOT NULL,
  `id_dokter` bigint UNSIGNED NOT NULL,
  `rekomendasi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proses` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `srt_rkrmdsi_rujukan`
--

INSERT INTO `srt_rkrmdsi_rujukan` (`id_rujukan`, `id_daftar`, `id_pasien`, `id_dokter`, `rekomendasi`, `id_proses`) VALUES
(1, 8, 1, 1, 'dirujuk ke rshs', 6);

-- --------------------------------------------------------

--
-- Table structure for table `surat_ktrgnsakit`
--

CREATE TABLE `surat_ktrgnsakit` (
  `id_surat` bigint UNSIGNED NOT NULL,
  `id_daftar` bigint UNSIGNED NOT NULL,
  `id_pasien` bigint UNSIGNED NOT NULL,
  `id_dokter` bigint UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jml_istirahat` int NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `id_proses` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_ktrgnsakit`
--

INSERT INTO `surat_ktrgnsakit` (`id_surat`, `id_daftar`, `id_pasien`, `id_dokter`, `keterangan`, `jml_istirahat`, `tgl_mulai`, `tgl_selesai`, `id_proses`) VALUES
(1, 9, 1, 1, 'asdas', 2, '2026-06-06', '2026-06-08', 7),
(2, 10, 1, 1, 'asdsad', 1, '2026-06-06', '2026-06-07', 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `admin_id_akses_foreign` (`id_akses`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `daftar`
--
ALTER TABLE `daftar`
  ADD PRIMARY KEY (`id_daftar`),
  ADD KEY `daftar_id_pasien_foreign` (`id_pasien`),
  ADD KEY `daftar_id_spesialis_foreign` (`id_spesialis`),
  ADD KEY `daftar_id_dokter_foreign` (`id_dokter`),
  ADD KEY `daftar_id_admin_foreign` (`id_admin`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `dokter_id_spesialis_foreign` (`id_spesialis`),
  ADD KEY `dokter_id_akses_foreign` (`id_akses`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `pasien_id_akses_foreign` (`id_akses`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `proses_pasien`
--
ALTER TABLE `proses_pasien`
  ADD PRIMARY KEY (`id_proses`),
  ADD KEY `proses_pasien_id_daftar_foreign` (`id_daftar`),
  ADD KEY `proses_pasien_id_pasien_foreign` (`id_pasien`),
  ADD KEY `proses_pasien_id_dokter_foreign` (`id_dokter`),
  ADD KEY `proses_pasien_id_admin_foreign` (`id_admin`),
  ADD KEY `proses_pasien_id_spesialis_foreign` (`id_spesialis`);

--
-- Indexes for table `resep_obat`
--
ALTER TABLE `resep_obat`
  ADD PRIMARY KEY (`id_resep`),
  ADD KEY `resep_obat_id_daftar_foreign` (`id_daftar`),
  ADD KEY `resep_obat_id_pasien_foreign` (`id_pasien`),
  ADD KEY `resep_obat_id_dokter_foreign` (`id_dokter`),
  ADD KEY `resep_obat_id_proses_foreign` (`id_proses`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
  ADD KEY `srt_rkrmdsi_rujukan_id_daftar_foreign` (`id_daftar`),
  ADD KEY `srt_rkrmdsi_rujukan_id_pasien_foreign` (`id_pasien`),
  ADD KEY `srt_rkrmdsi_rujukan_id_dokter_foreign` (`id_dokter`),
  ADD KEY `srt_rkrmdsi_rujukan_id_proses_foreign` (`id_proses`);

--
-- Indexes for table `surat_ktrgnsakit`
--
ALTER TABLE `surat_ktrgnsakit`
  ADD PRIMARY KEY (`id_surat`),
  ADD KEY `surat_ktrgnsakit_id_daftar_foreign` (`id_daftar`),
  ADD KEY `surat_ktrgnsakit_id_pasien_foreign` (`id_pasien`),
  ADD KEY `surat_ktrgnsakit_id_dokter_foreign` (`id_dokter`),
  ADD KEY `surat_ktrgnsakit_id_proses_foreign` (`id_proses`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daftar`
--
ALTER TABLE `daftar`
  MODIFY `id_daftar` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id_dokter` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id_akses` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proses_pasien`
--
ALTER TABLE `proses_pasien`
  MODIFY `id_proses` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `resep_obat`
--
ALTER TABLE `resep_obat`
  MODIFY `id_resep` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `spesialis`
--
ALTER TABLE `spesialis`
  MODIFY `id_spesialis` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `srt_rkrmdsi_rujukan`
--
ALTER TABLE `srt_rkrmdsi_rujukan`
  MODIFY `id_rujukan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_ktrgnsakit`
--
ALTER TABLE `surat_ktrgnsakit`
  MODIFY `id_surat` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_id_akses_foreign` FOREIGN KEY (`id_akses`) REFERENCES `hak_akses` (`id_akses`);

--
-- Constraints for table `daftar`
--
ALTER TABLE `daftar`
  ADD CONSTRAINT `daftar_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `daftar_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  ADD CONSTRAINT `daftar_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `daftar_id_spesialis_foreign` FOREIGN KEY (`id_spesialis`) REFERENCES `spesialis` (`id_spesialis`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `dokter_id_akses_foreign` FOREIGN KEY (`id_akses`) REFERENCES `hak_akses` (`id_akses`),
  ADD CONSTRAINT `dokter_id_spesialis_foreign` FOREIGN KEY (`id_spesialis`) REFERENCES `spesialis` (`id_spesialis`);

--
-- Constraints for table `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_id_akses_foreign` FOREIGN KEY (`id_akses`) REFERENCES `hak_akses` (`id_akses`);

--
-- Constraints for table `proses_pasien`
--
ALTER TABLE `proses_pasien`
  ADD CONSTRAINT `proses_pasien_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `proses_pasien_id_daftar_foreign` FOREIGN KEY (`id_daftar`) REFERENCES `daftar` (`id_daftar`),
  ADD CONSTRAINT `proses_pasien_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  ADD CONSTRAINT `proses_pasien_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `proses_pasien_id_spesialis_foreign` FOREIGN KEY (`id_spesialis`) REFERENCES `spesialis` (`id_spesialis`);

--
-- Constraints for table `resep_obat`
--
ALTER TABLE `resep_obat`
  ADD CONSTRAINT `resep_obat_id_daftar_foreign` FOREIGN KEY (`id_daftar`) REFERENCES `daftar` (`id_daftar`),
  ADD CONSTRAINT `resep_obat_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  ADD CONSTRAINT `resep_obat_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `resep_obat_id_proses_foreign` FOREIGN KEY (`id_proses`) REFERENCES `proses_pasien` (`id_proses`);

--
-- Constraints for table `srt_rkrmdsi_rujukan`
--
ALTER TABLE `srt_rkrmdsi_rujukan`
  ADD CONSTRAINT `srt_rkrmdsi_rujukan_id_daftar_foreign` FOREIGN KEY (`id_daftar`) REFERENCES `daftar` (`id_daftar`),
  ADD CONSTRAINT `srt_rkrmdsi_rujukan_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  ADD CONSTRAINT `srt_rkrmdsi_rujukan_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `srt_rkrmdsi_rujukan_id_proses_foreign` FOREIGN KEY (`id_proses`) REFERENCES `proses_pasien` (`id_proses`);

--
-- Constraints for table `surat_ktrgnsakit`
--
ALTER TABLE `surat_ktrgnsakit`
  ADD CONSTRAINT `surat_ktrgnsakit_id_daftar_foreign` FOREIGN KEY (`id_daftar`) REFERENCES `daftar` (`id_daftar`),
  ADD CONSTRAINT `surat_ktrgnsakit_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`),
  ADD CONSTRAINT `surat_ktrgnsakit_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`),
  ADD CONSTRAINT `surat_ktrgnsakit_id_proses_foreign` FOREIGN KEY (`id_proses`) REFERENCES `proses_pasien` (`id_proses`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
