-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_kantinbiru
CREATE DATABASE IF NOT EXISTS `db_kantinbiru` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_kantinbiru`;

-- Dumping structure for table db_kantinbiru.tb_bayar
CREATE TABLE IF NOT EXISTS `tb_bayar` (
  `id_bayar` bigint NOT NULL,
  `nominal_uang` bigint DEFAULT NULL,
  `total_bayar` bigint NOT NULL,
  `waktu_bayar` timestamp NOT NULL DEFAULT (now()) ON UPDATE CURRENT_TIMESTAMP,
  `tipe` int DEFAULT NULL,
  PRIMARY KEY (`id_bayar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_kantinbiru.tb_bayar: ~11 rows (approximately)
REPLACE INTO `tb_bayar` (`id_bayar`, `nominal_uang`, `total_bayar`, `waktu_bayar`, `tipe`) VALUES
	(2504251236773, 45000, 40000, '2025-04-25 06:22:06', 1),
	(2504251322949, 30000, 26000, '2025-04-25 06:25:01', 2),
	(2504251405962, 40000, 33000, '2025-04-25 07:23:39', 1),
	(2504271458840, 40000, 38000, '2025-04-27 08:00:07', 1),
	(2504271501969, 32000, 32000, '2025-04-27 08:04:08', 2),
	(2504271511550, 60000, 51000, '2025-04-27 08:11:34', 1),
	(2504291604515, 40000, 32000, '2025-04-29 09:06:47', 1),
	(2504291608852, 360000, 360000, '2025-04-29 09:09:14', 2),
	(2504291609231, 18000, 18000, '2025-04-29 09:13:41', 2),
	(2504291613780, 60000, 51000, '2025-04-29 09:14:21', 1),
	(2506131243999, 140000, 32000, '2025-06-13 05:46:29', 1);

-- Dumping structure for table db_kantinbiru.tb_kategori_menu
CREATE TABLE IF NOT EXISTS `tb_kategori_menu` (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `jenis_menu` int DEFAULT NULL,
  `kategori_menu` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_kantinbiru.tb_kategori_menu: ~6 rows (approximately)
REPLACE INTO `tb_kategori_menu` (`id_kategori`, `jenis_menu`, `kategori_menu`) VALUES
	(23, 1, 'Makanan Berat'),
	(25, 1, 'Snack/Gorengan'),
	(26, 4, 'Masakan Dapur'),
	(28, 1, 'Additional'),
	(30, 2, 'Minuman Botol'),
	(31, 1, 'Makanan Titipan');

-- Dumping structure for table db_kantinbiru.tb_list_order
CREATE TABLE IF NOT EXISTS `tb_list_order` (
  `id_list_order` int NOT NULL AUTO_INCREMENT,
  `menu` int DEFAULT NULL,
  `kode_order` bigint DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `catatan_menu` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status_menu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_list_order`),
  KEY `menu` (`menu`),
  KEY `order` (`kode_order`) USING BTREE,
  CONSTRAINT `FK_tb_list_order_tb_menu` FOREIGN KEY (`menu`) REFERENCES `tb_menu` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_tb_list_order_tb_order` FOREIGN KEY (`kode_order`) REFERENCES `tb_order` (`id_order`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_kantinbiru.tb_list_order: ~27 rows (approximately)
REPLACE INTO `tb_list_order` (`id_list_order`, `menu`, `kode_order`, `jumlah`, `catatan_menu`, `status_menu`) VALUES
	(78, 96, 2504251236773, 2, '', '3'),
	(79, 122, 2504251236773, 4, 'coklat tiramisu', NULL),
	(80, 100, 2504251322949, 2, '', '3'),
	(81, 97, 2504251322949, 2, '', '3'),
	(82, 122, 2504251405962, 3, 'Tiramisu', NULL),
	(83, 96, 2504251405962, 2, '', '3'),
	(84, 96, 2504271458840, 2, '', '3'),
	(85, 97, 2504271458840, 2, '', '3'),
	(86, 122, 2504271458840, 2, '', NULL),
	(87, 127, 2504271501969, 2, '', NULL),
	(88, 96, 2504271501969, 2, '', '3'),
	(89, 97, 2504271501969, 2, '', '3'),
	(90, 60, 2504271511550, 3, '', NULL),
	(91, 61, 2504271511550, 3, '', NULL),
	(92, 62, 2504271511550, 3, '', NULL),
	(93, 60, 2504291604515, 2, '', NULL),
	(94, 62, 2504291604515, 2, '', NULL),
	(95, 98, 2504291604515, 3, '', '3'),
	(96, 85, 2504291608852, 20, '', NULL),
	(97, 122, 2504291608852, 20, '', NULL),
	(98, 96, 2504291609231, 3, '', '3'),
	(99, 96, 2504291613780, 2, '', '3'),
	(100, 98, 2504291613780, 3, '', '3'),
	(101, 100, 2504291613780, 3, '', '3'),
	(102, 60, 2506131243999, 2, '', NULL),
	(103, 96, 2506131243999, 2, '', '3'),
	(104, 98, 2506131243999, 2, '', '3');

-- Dumping structure for table db_kantinbiru.tb_menu
CREATE TABLE IF NOT EXISTS `tb_menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `foto` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama_menu` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `deskripsi` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kategori` int DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `stock` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_tb_menu_tb_kategori_menu` (`kategori`),
  CONSTRAINT `FK_tb_menu_tb_kategori_menu` FOREIGN KEY (`kategori`) REFERENCES `tb_kategori_menu` (`id_kategori`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_kantinbiru.tb_menu: ~76 rows (approximately)
REPLACE INTO `tb_menu` (`id`, `foto`, `nama_menu`, `deskripsi`, `kategori`, `harga`, `stock`) VALUES
	(60, '25241-aqua.jpeg', 'Aqua Botol', '600ml', 30, 4000, NULL),
	(61, '38406-asinan_buah.jpg', 'Asinan Buah', 'Titipan milik .... ', 31, 10000, NULL),
	(62, '56038-bengbeng.jpg', 'Beng - Beng', '', 25, 3000, NULL),
	(63, '46229-better.jpg', 'Better', '', 25, 2500, NULL),
	(64, '81897-caffino.jpg', 'Caffino', '', 30, 6000, NULL),
	(66, '24064-chocolatos.jpeg', 'Chocolatos Kecil', '', 25, 1000, NULL),
	(67, '93047-chocolatos_besar.jpeg', 'Chocolatos Besar', '', 25, 2000, NULL),
	(68, '27825-chocopie.jpg', 'Chocopie', '', 25, 2500, NULL),
	(69, '76316-choki.jpg', 'Choki Choki', '', 25, 1000, NULL),
	(70, '86551-cocacola.jpeg', 'Coca Cola', 'Ukuran 450ml', 30, 6000, NULL),
	(71, '26543-tisue.png', 'Tissue', '', 26, 3000, NULL),
	(72, '63781-piscok.jpg', 'Piscok', 'Titipan atas nama ...', 31, 3000, NULL),
	(73, '63442-nabati.jpeg', 'Nabati', '', 25, 3000, NULL),
	(74, '36832-charm.png', 'Charm', '', 26, 3000, NULL),
	(75, '19316-cookies.png', 'Cookies', '', 31, 7000, NULL),
	(76, '24022-donat.jpg', 'Donat Lapis', '', 31, 5000, NULL),
	(77, '90513-donat_kentang.jpg', 'Donat Kentang', '', 31, 3000, NULL),
	(78, '76978-fanta.jpeg', 'Fanta', '', 30, 6000, NULL),
	(79, '89300-floridina.jpg', 'Floridina', '', 30, 4000, NULL),
	(80, '84026-frestea.png', 'Frestea', '', 30, 4000, NULL),
	(81, '88947-garuda_corn.jpg', 'Garuda Corn', '', 25, 2000, NULL),
	(82, '96216-goodtime.jpeg', 'Good Time', '', 25, 3000, NULL),
	(83, '70653-hydroplus.jpg', 'Hydroplus', '', 30, 6000, NULL),
	(84, '42185-indomie_goreng.jpg', 'Indomie Goreng Single', '', 23, 6000, NULL),
	(85, '47704-indomie_goreng.jpg', 'Indomie Goreng Double', '', 23, 11000, NULL),
	(86, '55376-indomie_kuah.jpeg', 'Indomie Kuah Single', '', 23, 6000, NULL),
	(87, '43542-indomie_kuah.jpeg', 'Indomie Kuah Double', '', 23, 11000, NULL),
	(88, '74173-keripik_tempe.jpeg', 'Keripik Tempe', '', 25, 6000, NULL),
	(89, '84666-kue_lontar.jpg', 'Kue Lontar', '', 25, 5000, NULL),
	(90, '19629-makaroni_boncabe.jpg', 'Boncabe Makaroni', '', 25, 2000, NULL),
	(91, '42445-mie_enak.jpeg', 'Mie Enak', '', 25, 1500, NULL),
	(92, '77849-mie_kremes.png', 'Mie Kremes', '', 25, 1500, NULL),
	(93, '55221-mie_sukses.jpeg', 'Mie Sukses Isi 2', '', 23, 8000, NULL),
	(94, '29388-mooh_yogurt.png', 'Yogurt Mooh', '', 30, 2500, NULL),
	(96, '17892-nasi_ayam_pedas_manis.jpeg', 'Nasi Ayam Pedas Manis', 'Titipan milik Pak Michael', 26, 6000, 30),
	(97, '95314-nasi_chicken_steak.jpg', 'Nasi Steak Ayam', '', 26, 6000, NULL),
	(98, '37276-nasi_goreng.jpg', 'Nasi Goreng', '', 26, 6000, NULL),
	(99, '73521-nasi_ikan.jpg', 'Nasi Ikan Suwir', '', 31, 7000, NULL),
	(100, '48724-nasi_kuning.jpg', 'Nasi Kuning', '', 26, 7000, NULL),
	(101, '98342-nasi_putih.png', 'Nasi Putih', '', 28, 3000, NULL),
	(102, '58765-nasi_telur.jpg', 'Nasi Telur', '', 23, 6000, NULL),
	(103, '98456-nextar.jpeg', 'Nextar', '', 25, 3000, NULL),
	(104, '14829-nutriboost.jpg', 'Nutriboost', '', 30, 6000, NULL),
	(105, '89067-onigiri.jpeg', 'Onigiri', '', 25, 7000, NULL),
	(106, '30851-oreo.jpg', 'Oreo', '', 25, 3000, NULL),
	(107, '15631-padimas.jpg', 'Roti Padimas', '', 25, 3000, NULL),
	(108, '37695-pilus.jpg', 'Garuda Pilus Kacang', '', 25, 1000, NULL),
	(109, '61987-pop_mie.jpg', 'Pop Mie', '', 25, 7000, NULL),
	(110, '31692-pudding_roti.jpeg', 'Roti Pudding', '', 31, 6000, NULL),
	(111, '10028-pulpy.jpg', 'Minute Maid Pulpy', '', 30, 6000, NULL),
	(112, '39176-rambak.jpeg', 'Kerupuk Rambak', '', 28, 2500, NULL),
	(113, '26161-risolmayo.jpg', 'Risol Mayo', '', 31, 3000, NULL),
	(114, '70020-roti_aroma.jpg', 'Roti Aroma', '', 31, 4000, NULL),
	(115, '49482-roti_pizza.jpg', 'Pizza Roti', '', 31, 4000, NULL),
	(116, '30954-roti_sasana.jpeg', 'Roti Sasana', '', 31, 4000, NULL),
	(117, '35127-sari_gandum.jpeg', 'Roma Kue Sari Gandum', '', 25, 3000, NULL),
	(118, '87380-sariroti_sandwich.jpeg', 'Sari Roti Sandwich', '', 31, 4500, NULL),
	(119, '76481-sariroti_sobek.jpeg', 'Sari Roti Sobek', '', 31, 9000, NULL),
	(120, '26630-soto.jpeg', 'Soto Bening / Soto Kare', '', 23, 6000, NULL),
	(121, '46804-sprite.jpg', 'Sprite', '', 30, 6000, NULL),
	(122, '42989-susu_cimory.jpeg', 'Susu Cimory', '', 30, 7000, NULL),
	(123, '37079-susu_frisian_flag.jpg', 'Susu Frisian Flag', '', 30, 7000, NULL),
	(124, '29292-susu_milk_life.jpg', 'Susu Milk Life', '', 30, 7000, NULL),
	(125, '20817-susu_ultra.jpeg', 'Susu Ultra', '', 30, 7000, NULL),
	(126, '15455-taro.jpg', 'Taro', '', 25, 2000, NULL),
	(127, '68746-teh_pucuk.jpg', 'Teh Pucuk Harum', '', 30, 4000, NULL),
	(128, '68931-telor_goreng.jpg', 'Telor Goreng (Dadar / Ceplok)', '', 28, 3000, NULL),
	(129, '25988-telur_rebus.jpg', 'Telur Rebus', '', 28, 3000, NULL),
	(130, '89857-tictac.jpg', 'Tictac', '', 25, 1000, NULL),
	(131, '56100-tricks.jpeg', 'Tricks', '', 25, 1500, NULL),
	(132, '27714-walens_coklat.jpeg', 'Choco Walens Soes Coklat', '', 25, 2000, NULL),
	(133, '93264-yakult.jpeg', 'Yakult', '', 30, 2500, NULL),
	(134, '17527-yogurt_cimory.jpg', 'Yogurt Cimory', '', 30, 9000, NULL),
	(135, '81848-yupi.jpeg', 'Permen', '', 25, 1000, NULL),
	(136, '72951-yuzu.jpg', 'Yuzu', '', 30, 6000, NULL),
	(137, '10105-tricks.jpeg', 'Snack Tricks', '', 25, 2500, NULL);

-- Dumping structure for table db_kantinbiru.tb_order
CREATE TABLE IF NOT EXISTS `tb_order` (
  `id_order` bigint NOT NULL DEFAULT '0',
  `pelanggan` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `meja` int DEFAULT NULL,
  `pelayan` int DEFAULT NULL,
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `waktu_order` timestamp NULL DEFAULT (now()) ON UPDATE CURRENT_TIMESTAMP,
  `catatan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_order`) USING BTREE,
  KEY `pelayan` (`pelayan`),
  CONSTRAINT `FK_tb_order_tb_user` FOREIGN KEY (`pelayan`) REFERENCES `tb_user` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_kantinbiru.tb_order: ~11 rows (approximately)
REPLACE INTO `tb_order` (`id_order`, `pelanggan`, `meja`, `pelayan`, `status`, `waktu_order`, `catatan`) VALUES
	(2504251236773, 'Aryo', 12, 6, NULL, '2025-04-25 05:36:23', ''),
	(2504251322949, 'Klemens', 2, 6, NULL, '2025-04-25 06:22:42', ''),
	(2504251405962, 'Gracia', 13, 1, NULL, '2025-04-25 07:05:16', ''),
	(2504271458840, 'Angel', 1, 1, NULL, '2025-04-27 07:58:57', ''),
	(2504271501969, 'Reza', 2, 1, NULL, '2025-04-27 08:01:30', ''),
	(2504271511550, 'Hizkia', 1, 6, NULL, '2025-04-27 08:11:14', ''),
	(2504291604515, 'Reza', 1, 2, NULL, '2025-04-29 09:05:15', ''),
	(2504291608852, 'Risa', 1, 1, NULL, '2025-04-29 09:08:33', ''),
	(2504291609231, 'Evangs', 2, 1, NULL, '2025-04-29 09:10:48', ''),
	(2504291613780, 'Titus', 2, 1, NULL, '2025-04-29 09:13:49', ''),
	(2506131243999, 'Krista', 12, 1, NULL, '2025-06-13 05:43:43', '');

-- Dumping structure for table db_kantinbiru.tb_user
CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `username` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `level` int DEFAULT NULL,
  `nim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_kantinbiru.tb_user: ~5 rows (approximately)
REPLACE INTO `tb_user` (`id`, `nama`, `username`, `password`, `level`, `nim`) VALUES
	(1, 'Aryo Priyadi', 'admin@kantin.com', '21232f297a57a5a743894a0e4a801fc3', 1, '672021121'),
	(2, 'Fungsio Kantin', 'fungsio@kantin.com', '5f4dcc3b5aa765d61d8327deb882cf99', 3, '672022000'),
	(5, 'Aryo Priyadi', 'adminbackup@kantin.com', '5f4dcc3b5aa765d61d8327deb882cf99', 1, '672021121'),
	(6, 'Bidang 3 SMF', 'bidang3@kantin.com', '5f4dcc3b5aa765d61d8327deb882cf99', 2, '672022000'),
	(7, 'Ibu Maya', 'dapur@kantin.com', '5f4dcc3b5aa765d61d8327deb882cf99', 4, '672020000');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
