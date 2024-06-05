-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jun 2024 pada 11.41
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new-crud`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_user`
--

CREATE TABLE `auth_user` (
  `auth_user_id` int(10) UNSIGNED NOT NULL,
  `auth_user_user_id` int(10) UNSIGNED NOT NULL,
  `auth_user_email` varchar(100) NOT NULL,
  `auth_user_password` varchar(255) NOT NULL,
  `auth_user_token` varchar(255) NOT NULL,
  `auth_user_date_login` datetime DEFAULT NULL,
  `auth_user_date_expired` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_user`
--

INSERT INTO `auth_user` (`auth_user_id`, `auth_user_user_id`, `auth_user_email`, `auth_user_password`, `auth_user_token`, `auth_user_date_login`, `auth_user_date_expired`) VALUES
(18, 16, 'pitek@gmail.com', '123456', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwidWlkIjoiMTYiLCJlbWFpbCI6InBpdGVrQGdtYWlsLmNvbSJ9.Cz9pt0CNj9ac30uDRWT9hM8ji6tafJOFg7nFblhnVW8', '2024-06-04 13:37:28', '2024-06-04 14:37:28'),
(19, 17, 'noob@gmail.com', '123456', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwidWlkIjoiMTciLCJlbWFpbCI6Im5vb2JAZ21haWwuY29tIn0.DHSwf1VYbc5CsjPrDuR_hKmRwnYHX5PQ5rPHUp6GSvg', '2024-06-03 11:40:50', '2024-06-03 12:40:50'),
(20, 13, 'pitekgaming@gmail.com', '123456', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwidWlkIjoiMTMiLCJlbWFpbCI6InBpdGVrZ2FtaW5nQGdtYWlsLmNvbSJ9.GY0E5UgOUi7i0D-Kx_DBhpiKO1qwHI5STry66VEyA3o', '2024-06-03 11:40:54', '2024-06-03 12:40:54'),
(21, 15, 'vin@gmail.com', '123456', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwidWlkIjoiMTUiLCJlbWFpbCI6InZpbkBnbWFpbC5jb20ifQ.IaMi3hTYp2miy7NjYvbuJkxoSLFqRXatWDr6JqGmxBg', '2024-06-03 11:41:02', '2024-06-03 12:41:02'),
(22, 14, 'vino@gmail.com', '123456', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwidWlkIjoiMTQiLCJlbWFpbCI6InZpbm9AZ21haWwuY29tIn0.5i4Kc8jmM-DOGAAyaGGohMKEqvlwarnMXtFYlCz35Ac', '2024-06-03 11:41:03', '2024-06-03 12:41:03'),
(23, 18, 'coba@gmail.com', '123456', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwidWlkIjoiMTgiLCJlbWFpbCI6ImNvYmFAZ21haWwuY29tIn0.UA61m_JGpq9AoD0CfuNxe7N5lnRuHSbENGFS66g-PEk', '2024-06-04 13:17:51', '2024-06-04 14:17:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_deleted_at`) VALUES
(1, 'Makanan', NULL),
(2, 'Minuman', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(10) UNSIGNED NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_no_handphone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_address`, `customer_no_handphone`) VALUES
(45, 'pitek', 'seturan', '0281401284021');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_stock`
--

CREATE TABLE `log_stock` (
  `log_stock_id` int(10) UNSIGNED NOT NULL,
  `log_stock_product_id` int(10) UNSIGNED NOT NULL,
  `log_stock_product_name` varchar(50) NOT NULL,
  `log_stock_status` enum('add','reduce','','') NOT NULL,
  `log_stock_value` int(11) NOT NULL,
  `log_stock_category_id` int(10) UNSIGNED NOT NULL,
  `log_stock_category_name` varchar(50) NOT NULL,
  `log_stock_unit_id` int(10) UNSIGNED NOT NULL,
  `log_stock_unit_name` varchar(50) NOT NULL,
  `log_stock_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `log_stock`
--

INSERT INTO `log_stock` (`log_stock_id`, `log_stock_product_id`, `log_stock_product_name`, `log_stock_status`, `log_stock_value`, `log_stock_category_id`, `log_stock_category_name`, `log_stock_unit_id`, `log_stock_unit_name`, `log_stock_date`) VALUES
(6, 7, 'Permen', 'add', 55, 1, 'Makanan', 4, 'Pcs', '2024-05-02 08:34:33'),
(7, 7, 'Permen', 'reduce', 15, 1, 'Makanan', 4, 'Pcs', '2024-05-02 08:34:38'),
(8, 7, 'Permen', 'reduce', 15, 1, 'Makanan', 4, 'Pcs', '2024-05-02 08:34:39'),
(9, 16, 'Mie Goreng', 'reduce', 20, 1, 'Makanan', 4, 'Pcs', '2024-05-02 09:04:57'),
(10, 7, 'Permen', 'add', 40, 1, 'Makanan', 4, 'Pcs', '2024-05-02 09:04:57'),
(11, 7, 'Permen', 'reduce', 20, 1, 'Makanan', 4, 'Pcs', '2024-05-02 09:06:19'),
(12, 16, 'Mie Goreng', 'add', 40, 1, 'Makanan', 4, 'Pcs', '2024-05-02 09:06:19'),
(13, 7, 'Permen', 'reduce', 20, 1, 'Makanan', 4, 'Pcs', '2024-05-02 09:26:41'),
(14, 16, 'Mie Goreng', 'add', 40, 1, 'Makanan', 4, 'Pcs', '2024-05-02 09:26:41'),
(15, 26, 'Nugget', 'reduce', 100, 1, 'Makanan', 3, 'Kardus', '2024-05-07 10:59:18'),
(16, 21, 'Mie Rebus', 'reduce', 100, 1, 'Makanan', 4, 'Pcs', '2024-05-07 10:59:43'),
(17, 169, 'Sapi', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-16 16:26:15'),
(18, 169, 'Sapi', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-16 16:26:24'),
(19, 169, 'Sapi', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-16 16:28:50'),
(20, 246, 'pessi', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-17 13:23:55'),
(21, 246, 'pessi', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-17 13:24:00'),
(22, 246, 'pessi', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-17 13:25:13'),
(23, 246, 'pessi', 'add', 10, 1, 'Makanan', 1, 'Piring', '2024-05-17 13:26:26'),
(24, 246, 'pessi', 'add', 10, 1, 'Makanan', 1, 'Piring', '2024-05-17 13:26:31'),
(25, 244, 'dodo', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-17 13:40:44'),
(26, 245, 'penaldo', 'add', 20, 1, 'Makanan', 1, 'Piring', '2024-05-17 13:40:44'),
(27, 244, 'dodo', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-17 13:42:44'),
(28, 245, 'penaldo', 'add', 20, 1, 'Makanan', 1, 'Piring', '2024-05-17 13:42:44'),
(29, 246, 'pessi', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-20 14:51:58'),
(30, 246, 'pessi', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-20 14:52:03'),
(31, 244, 'dodo', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-20 14:52:07'),
(32, 245, 'penaldo', 'add', 20, 1, 'Makanan', 1, 'Piring', '2024-05-20 14:52:07'),
(33, 279, 'Mie Rebus', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-30 10:57:16'),
(34, 280, 'Ayam Geprek', 'add', 20, 1, 'Makanan', 1, 'Piring', '2024-05-30 10:57:16'),
(35, 279, 'Mie Rebus', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-30 11:00:52'),
(36, 280, 'Ayam Geprek', 'add', 20, 1, 'Makanan', 1, 'Piring', '2024-05-30 11:00:52'),
(37, 279, 'Mie Rebus', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-30 11:45:33'),
(38, 280, 'Ayam Geprek', 'add', 20, 1, 'Makanan', 1, 'Piring', '2024-05-30 11:45:33'),
(39, 279, 'Mie Rebus', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-30 11:46:16'),
(40, 280, 'Ayam Geprek', 'add', 20, 1, 'Makanan', 1, 'Piring', '2024-05-30 11:46:16'),
(41, 279, 'Mie Rebus', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-05-30 11:46:30'),
(42, 280, 'Ayam Geprek', 'add', 20, 1, 'Makanan', 1, 'Piring', '2024-05-30 11:46:30'),
(43, 279, 'Mie Rebus', 'reduce', 100, 1, 'Makanan', 1, 'Piring', '2024-05-30 13:44:10'),
(44, 279, 'Mie Rebus', 'reduce', 100, 1, 'Makanan', 1, 'Piring', '2024-05-30 13:45:36'),
(45, 279, 'Mie Rebus', 'reduce', 100, 1, 'Makanan', 1, 'Piring', '2024-05-30 13:45:41'),
(46, 279, 'Mie Rebus', 'reduce', 100, 1, 'Makanan', 1, 'Piring', '2024-05-30 13:45:51'),
(47, 279, 'Mie Aceh', 'reduce', 100, 1, 'Makanan', 1, 'Piring', '2024-06-03 10:43:52'),
(48, 279, 'Mie Aceh', 'reduce', 100, 1, 'Makanan', 1, 'Piring', '2024-06-03 10:44:51'),
(49, 279, 'Mie Aceh', 'reduce', 10, 1, 'Makanan', 1, 'Piring', '2024-06-03 10:45:12'),
(50, 280, 'Ayam Geprek', 'add', 20, 1, 'Makanan', 1, 'Piring', '2024-06-03 10:45:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_category_id` int(10) UNSIGNED NOT NULL,
  `product_category_name` varchar(50) NOT NULL,
  `product_created_at` datetime DEFAULT NULL,
  `product_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_category_id`, `product_category_name`, `product_created_at`, `product_updated_at`) VALUES
(279, 'Mie Aceh', 1, 'Makanan', '2024-05-29 11:47:27', '2024-06-04 13:18:14'),
(280, 'Ayam Geprek', 1, 'Makanan', '2024-05-29 11:49:43', NULL),
(282, 'Ayam Goreng', 1, 'Makanan', '2024-06-04 13:29:41', NULL),
(283, 'Mie Rendang', 1, 'Makanan', '2024-06-04 13:30:00', NULL),
(284, 'Mie Soto', 1, 'Makanan', '2024-06-04 13:36:44', NULL),
(285, 'Ayam Rendang', 1, 'Makanan', '2024-06-04 13:37:13', NULL),
(286, 'Ayam Tepung', 1, 'Makanan', '2024-06-04 13:37:28', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_stock`
--

CREATE TABLE `product_stock` (
  `product_stock_id` int(10) UNSIGNED NOT NULL,
  `product_stock_product_id` int(10) UNSIGNED NOT NULL,
  `product_stock_product_name` varchar(50) NOT NULL,
  `product_stock_unit_id` int(10) UNSIGNED NOT NULL,
  `product_stock_unit_name` varchar(50) NOT NULL,
  `product_stock_value` int(11) NOT NULL,
  `product_stock_price_buy` int(10) UNSIGNED NOT NULL,
  `product_stock_price_sell` int(10) UNSIGNED NOT NULL,
  `product_stock_in` int(10) UNSIGNED NOT NULL,
  `product_stock_out` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `product_stock`
--

INSERT INTO `product_stock` (`product_stock_id`, `product_stock_product_id`, `product_stock_product_name`, `product_stock_unit_id`, `product_stock_unit_name`, `product_stock_value`, `product_stock_price_buy`, `product_stock_price_sell`, `product_stock_in`, `product_stock_out`) VALUES
(272, 279, 'Mie Aceh', 1, 'Piring', 98, 200, 350, 0, 60),
(273, 280, 'Ayam Geprek', 1, 'Kardus', 218, 500, 700, 120, 0),
(275, 282, 'Ayam Goreng', 1, 'Piring', 98, 500, 700, 0, 0),
(276, 283, 'Mie Rendang', 1, 'Piring', 498, 250, 300, 0, 0),
(277, 284, 'Mie Soto', 1, 'Piring', 498, 250, 300, 0, 0),
(278, 285, 'Ayam Rendang', 1, 'Piring', 498, 250, 300, 0, 0),
(279, 286, 'Ayam Tepung', 1, 'Piring', 198, 500, 800, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_order`
--

CREATE TABLE `sales_order` (
  `sales_order_id` int(10) UNSIGNED NOT NULL,
  `sales_order_status` enum('pending','payed','confirmed','') NOT NULL,
  `sales_order_product_name` varchar(100) NOT NULL,
  `sales_order_category` varchar(100) NOT NULL,
  `sales_order_unit` varchar(100) NOT NULL,
  `sales_order_value` int(10) UNSIGNED NOT NULL,
  `sales_order_price` int(10) UNSIGNED DEFAULT NULL,
  `sales_order_customer_id` int(10) UNSIGNED NOT NULL,
  `sales_order_date` datetime DEFAULT NULL,
  `sales_order_proof` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sales_order`
--

INSERT INTO `sales_order` (`sales_order_id`, `sales_order_status`, `sales_order_product_name`, `sales_order_category`, `sales_order_unit`, `sales_order_value`, `sales_order_price`, `sales_order_customer_id`, `sales_order_date`, `sales_order_proof`) VALUES
(128, 'pending', 'Mie Aceh', 'Makanan', 'Piring', 2, 700, 45, '2024-06-05 15:16:02', NULL),
(129, 'pending', 'Ayam Geprek', 'Makanan', 'Piring', 2, 1400, 45, '2024-06-05 15:16:02', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(10) UNSIGNED NOT NULL,
  `unit_name` varchar(50) NOT NULL,
  `unit_deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `unit`
--

INSERT INTO `unit` (`unit_id`, `unit_name`, `unit_deleted_at`) VALUES
(1, 'Piring', NULL),
(2, 'Gelas', NULL),
(3, 'Kardus', NULL),
(4, 'Pcs', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_email`, `user_password`) VALUES
(13, 'pitekgaming@gmail.com', '$2y$10$fb7I4DovRTFU2g8M6UpTbOH5YsKjN4CAFm0SBQ3ZJhOO0ahlv1RRW'),
(14, 'vino@gmail.com', '$2y$10$lq9i093F./5hReIr5aK3DupXG9VAfr748g/xK0CC3h8zf2YOaTk6O'),
(15, 'vin@gmail.com', '$2y$10$vjG42EcKL2Rxmlv2Tx0MnOPFHrMODlLsWRDjPaZbrve9mc6DGfqdy'),
(16, 'pitek@gmail.com', '$2y$10$Gv/aaVAWzwBtEG6sxNuAou0lmBBeHyg619vOcVz83EsNlBmBuA0A.'),
(17, 'noob@gmail.com', '$2y$10$ai2E/oPsUAGTTZCZWmqtmuOii.DU.dQlAEFDrG2qRGxn4iCHPdfOy'),
(18, 'coba@gmail.com', '$2y$10$13Lxwwq.t/zDjUGyYPmXQOK1ByJt9KpeuowLtDwKAI7O7lIVuuyXi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auth_user`
--
ALTER TABLE `auth_user`
  ADD PRIMARY KEY (`auth_user_id`),
  ADD KEY `FK_auth_user_user` (`auth_user_user_id`);

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indeks untuk tabel `log_stock`
--
ALTER TABLE `log_stock`
  ADD PRIMARY KEY (`log_stock_id`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `FK_product_category` (`product_category_id`);

--
-- Indeks untuk tabel `product_stock`
--
ALTER TABLE `product_stock`
  ADD PRIMARY KEY (`product_stock_id`),
  ADD KEY `fk_product_stock_product` (`product_stock_product_id`),
  ADD KEY `fk_product_stock_unit` (`product_stock_unit_id`);

--
-- Indeks untuk tabel `sales_order`
--
ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`sales_order_id`);

--
-- Indeks untuk tabel `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auth_user`
--
ALTER TABLE `auth_user`
  MODIFY `auth_user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `log_stock`
--
ALTER TABLE `log_stock`
  MODIFY `log_stock_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT untuk tabel `product_stock`
--
ALTER TABLE `product_stock`
  MODIFY `product_stock_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

--
-- AUTO_INCREMENT untuk tabel `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `sales_order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT untuk tabel `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `auth_user`
--
ALTER TABLE `auth_user`
  ADD CONSTRAINT `FK_auth_user_user` FOREIGN KEY (`auth_user_user_id`) REFERENCES `user` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_product_category` FOREIGN KEY (`product_category_id`) REFERENCES `category` (`category_id`);

--
-- Ketidakleluasaan untuk tabel `product_stock`
--
ALTER TABLE `product_stock`
  ADD CONSTRAINT `fk_product_stock_product` FOREIGN KEY (`product_stock_product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `fk_product_stock_unit` FOREIGN KEY (`product_stock_unit_id`) REFERENCES `unit` (`unit_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
