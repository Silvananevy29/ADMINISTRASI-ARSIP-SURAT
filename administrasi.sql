-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 12:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `administrasi`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_surat` (IN `p_nomor_urut` INT, IN `p_alamat_pengirim` VARCHAR(255), IN `p_tanggal_surat` DATE, IN `p_nomor_surat` VARCHAR(50), IN `p_perihal` VARCHAR(255), IN `p_nomor_disposisi` VARCHAR(50), IN `p_lampiran` VARCHAR(255))   BEGIN
    INSERT INTO surat (nomor_urut, alamat_pengirim, tanggal_surat, nomor_surat, perihal, nomor_disposisi, lampiran)
    VALUES (p_nomor_urut, p_alamat_pengirim, p_tanggal_surat, p_nomor_surat, p_perihal, p_nomor_disposisi, p_lampiran);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `search_surat` (IN `search_term` VARCHAR(255))   BEGIN
    SELECT * FROM v_surat
    WHERE alamat_pengirim LIKE CONCAT('%', search_term, '%')
       OR nomor_surat LIKE CONCAT('%', search_term, '%')
       OR perihal LIKE CONCAT('%', search_term, '%')
       OR nomor_disposisi LIKE CONCAT('%', search_term, '%');
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `laporan_surat`
-- (See below for the actual view)
--
CREATE TABLE `laporan_surat` (
`id` int(11)
,`nomor_urut` int(11)
,`alamat_pengirim` varchar(255)
,`tanggal_surat` date
,`nomor_surat` varchar(50)
,`perihal` varchar(255)
,`nomor_disposisi` varchar(50)
,`lampiran` varchar(255)
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `log_surat`
--

CREATE TABLE `log_surat` (
  `id` int(11) NOT NULL,
  `surat_id` int(11) DEFAULT NULL,
  `aksi` enum('insert','update','delete') DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_surat`
--

INSERT INTO `log_surat` (`id`, `surat_id`, `aksi`, `tanggal`, `keterangan`) VALUES
(1, 1, 'update', '2025-02-09 04:43:39', 'Data surat diubah'),
(2, 2, 'update', '2025-02-09 04:43:39', 'Data surat diubah'),
(3, 3, 'update', '2025-02-09 04:43:39', 'Data surat diubah'),
(4, 4, 'update', '2025-02-09 04:43:39', 'Data surat diubah');

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id` int(11) NOT NULL,
  `nomor_urut` int(11) NOT NULL,
  `alamat_pengirim` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `nomor_surat` varchar(50) NOT NULL,
  `perihal` varchar(255) NOT NULL,
  `nomor_disposisi` varchar(50) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id`, `nomor_urut`, `alamat_pengirim`, `tanggal_surat`, `nomor_surat`, `perihal`, `nomor_disposisi`, `lampiran`, `user_id`, `created_at`) VALUES
(1, 1, 'Dinas Pendidikan', '2025-02-01', '400.3.3.3/234/2024', 'Surat Keterangan Pembukaan Blokir', '1256', '1 Berkas', 1, '2025-02-02 06:07:51'),
(2, 2, 'PKBM Sekar Sari Dahlia', '2025-01-09', '102/232/YAYASAN-SSD/2025', 'Permohonan Perpanjangan Ijin Operasional Lembaga', '19', '1 Berkas', 1, '2025-02-02 17:52:31'),
(3, 3, 'SPS AL IKHLAS', '2025-01-09', '04/SPS AL-IKHLAS/2025', 'Permohonan Perpanjangan Ijin Operasional Lembaga', '49', '1 Berkas', 1, '2025-02-02 17:54:16'),
(4, 0, 'UMC', '2025-02-09', '400.3.3/126/UMC/2025', 'Surat Undangan', '1245', '1 Lembar', 1, '2025-02-09 04:06:38');

--
-- Triggers `surat`
--
DELIMITER $$
CREATE TRIGGER `after_surat_delete` AFTER DELETE ON `surat` FOR EACH ROW BEGIN
    INSERT INTO log_surat (surat_id, aksi, keterangan) VALUES (OLD.id, 'delete', 'Data surat dihapus');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_surat_insert` AFTER INSERT ON `surat` FOR EACH ROW BEGIN
    INSERT INTO log_surat (surat_id, aksi, keterangan) VALUES (NEW.id, 'insert', 'Data surat baru ditambahkan');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_surat_update` AFTER UPDATE ON `surat` FOR EACH ROW BEGIN
    INSERT INTO log_surat (surat_id, aksi, keterangan) VALUES (NEW.id, 'update', 'Data surat diubah');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '123');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_surat`
-- (See below for the actual view)
--
CREATE TABLE `v_surat` (
`id` int(11)
,`alamat_pengirim` varchar(255)
,`tanggal_surat` date
,`nomor_surat` varchar(50)
,`perihal` varchar(255)
,`nomor_disposisi` varchar(50)
,`lampiran` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `laporan_surat`
--
DROP TABLE IF EXISTS `laporan_surat`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `laporan_surat`  AS SELECT `surat`.`id` AS `id`, `surat`.`nomor_urut` AS `nomor_urut`, `surat`.`alamat_pengirim` AS `alamat_pengirim`, `surat`.`tanggal_surat` AS `tanggal_surat`, `surat`.`nomor_surat` AS `nomor_surat`, `surat`.`perihal` AS `perihal`, `surat`.`nomor_disposisi` AS `nomor_disposisi`, `surat`.`lampiran` AS `lampiran`, `surat`.`created_at` AS `created_at` FROM `surat` ;

-- --------------------------------------------------------

--
-- Structure for view `v_surat`
--
DROP TABLE IF EXISTS `v_surat`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_surat`  AS SELECT `surat`.`id` AS `id`, `surat`.`alamat_pengirim` AS `alamat_pengirim`, `surat`.`tanggal_surat` AS `tanggal_surat`, `surat`.`nomor_surat` AS `nomor_surat`, `surat`.`perihal` AS `perihal`, `surat`.`nomor_disposisi` AS `nomor_disposisi`, `surat`.`lampiran` AS `lampiran` FROM `surat` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_surat`
--
ALTER TABLE `log_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_surat` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_surat`
--
ALTER TABLE `log_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `surat`
--
ALTER TABLE `surat`
  ADD CONSTRAINT `fk_user_surat` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
