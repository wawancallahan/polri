-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2022 at 03:04 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `polri`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pangkat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `pangkat`, `nama`, `kode`, `user_id`) VALUES
(1, '23', 'TES', '232', 1),
(2, 'sasd', 'ss', 'asda', 2);

-- --------------------------------------------------------

--
-- Table structure for table `data_laporan`
--

CREATE TABLE `data_laporan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laporan_id` bigint(20) UNSIGNED NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_laporan`
--

INSERT INTO `data_laporan` (`id`, `laporan_id`, `model`, `jenis`, `isi`) VALUES
(2, 2, 'surat_perintah', 'dasar', '2'),
(4, 1, 'laporan_harian_hasil', 'dasar', 'a'),
(5, 3, 'laporan_harian_hasil', 'dasar', '2'),
(7, 3, 'surat_perintah', 'dasar', 'WARADS'),
(8, 3, 'surat_perintah', 'untuk', 'MARI');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_laporan`
--

CREATE TABLE `kegiatan_laporan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tema_laporan_id` bigint(20) UNSIGNED NOT NULL,
  `nama` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `person` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sasaran` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hasil_kegiatan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokumentasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kegiatan_laporan`
--

INSERT INTO `kegiatan_laporan` (`id`, `tema_laporan_id`, `nama`, `person`, `sasaran`, `hasil_kegiatan`, `dokumentasi`) VALUES
(4, 2, 'asd2', '2', '2', '2', '6433b1559dae969b8eb5ed6a3c2c2ee4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_harian_hasil`
--

CREATE TABLE `laporan_harian_hasil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surat_perintah_id` bigint(20) UNSIGNED NOT NULL,
  `waktu` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rute` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kendaraan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ditemukan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tindakan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_harian_hasil`
--

INSERT INTO `laporan_harian_hasil` (`id`, `surat_perintah_id`, `waktu`, `rute`, `kendaraan`, `ditemukan`, `tindakan`, `tanggal`) VALUES
(1, 3, '5', '4', '3', '2', '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `regu`
--

CREATE TABLE `regu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regu`
--

INSERT INTO `regu` (`id`, `kode`, `nama`) VALUES
(1, '1', 'SATGAS OPS KONTINJENSI  COVID – 19 AMAN NUSA- II 2020 ');

-- --------------------------------------------------------

--
-- Table structure for table `regu_anggota`
--

CREATE TABLE `regu_anggota` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `regu_id` bigint(20) UNSIGNED NOT NULL,
  `anggota_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regu_anggota`
--

INSERT INTO `regu_anggota` (`id`, `regu_id`, `anggota_id`, `type`) VALUES
(8, 1, 1, '1'),
(9, 1, 2, '0');

-- --------------------------------------------------------

--
-- Table structure for table `surat_perintah`
--

CREATE TABLE `surat_perintah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `regu_id` bigint(20) UNSIGNED NOT NULL,
  `pertimbangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selesai` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dikeluarkan_di` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_perintah`
--

INSERT INTO `surat_perintah` (`id`, `nomor`, `regu_id`, `pertimbangan`, `selesai`, `dikeluarkan_di`, `tanggal`) VALUES
(2, '12344', 1, 'ssasdas', NULL, 'Samarinda', '2022-02-19'),
(3, '12344', 1, 'WES WARAS', NULL, 'Samarinda', '2022-02-12');

-- --------------------------------------------------------

--
-- Table structure for table `tema_laporan`
--

CREATE TABLE `tema_laporan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surat_perintah_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tema_laporan`
--

INSERT INTO `tema_laporan` (`id`, `surat_perintah_id`, `nama`, `tanggal`) VALUES
(2, 2, 'SATGAS PENCEGAHAN', '2022-02-19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`) VALUES
(1, 'TES', '1', 'c4ca4238a0b923820dcc509a6f75849b', 'ANGGOTA'),
(2, 'ss', '2', 'c81e728d9d4c2f636f067f89cc14862c', 'ANGGOTA'),
(3, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_user_id_foreign` (`user_id`);

--
-- Indexes for table `data_laporan`
--
ALTER TABLE `data_laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan_laporan`
--
ALTER TABLE `kegiatan_laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_laporan_tema_laporan_id_foreign` (`tema_laporan_id`);

--
-- Indexes for table `laporan_harian_hasil`
--
ALTER TABLE `laporan_harian_hasil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_harian_hasil_surat_perintah_id_foreign` (`surat_perintah_id`);

--
-- Indexes for table `regu`
--
ALTER TABLE `regu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regu_anggota`
--
ALTER TABLE `regu_anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regu_anggota_regu_id_foreign` (`regu_id`),
  ADD KEY `regu_anggota_anggota_id_foreign` (`anggota_id`);

--
-- Indexes for table `surat_perintah`
--
ALTER TABLE `surat_perintah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_perintah_regu_id_foreign` (`regu_id`);

--
-- Indexes for table `tema_laporan`
--
ALTER TABLE `tema_laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tema_laporan_surat_perintah_id_foreign` (`surat_perintah_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_laporan`
--
ALTER TABLE `data_laporan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kegiatan_laporan`
--
ALTER TABLE `kegiatan_laporan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporan_harian_hasil`
--
ALTER TABLE `laporan_harian_hasil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `regu`
--
ALTER TABLE `regu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `regu_anggota`
--
ALTER TABLE `regu_anggota`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `surat_perintah`
--
ALTER TABLE `surat_perintah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tema_laporan`
--
ALTER TABLE `tema_laporan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `kegiatan_laporan`
--
ALTER TABLE `kegiatan_laporan`
  ADD CONSTRAINT `kegiatan_laporan_tema_laporan_id_foreign` FOREIGN KEY (`tema_laporan_id`) REFERENCES `tema_laporan` (`id`);

--
-- Constraints for table `laporan_harian_hasil`
--
ALTER TABLE `laporan_harian_hasil`
  ADD CONSTRAINT `laporan_harian_hasil_surat_perintah_id_foreign` FOREIGN KEY (`surat_perintah_id`) REFERENCES `surat_perintah` (`id`);

--
-- Constraints for table `regu_anggota`
--
ALTER TABLE `regu_anggota`
  ADD CONSTRAINT `regu_anggota_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`),
  ADD CONSTRAINT `regu_anggota_regu_id_foreign` FOREIGN KEY (`regu_id`) REFERENCES `regu` (`id`);

--
-- Constraints for table `surat_perintah`
--
ALTER TABLE `surat_perintah`
  ADD CONSTRAINT `surat_perintah_regu_id_foreign` FOREIGN KEY (`regu_id`) REFERENCES `regu` (`id`);

--
-- Constraints for table `tema_laporan`
--
ALTER TABLE `tema_laporan`
  ADD CONSTRAINT `tema_laporan_surat_perintah_id_foreign` FOREIGN KEY (`surat_perintah_id`) REFERENCES `surat_perintah` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
