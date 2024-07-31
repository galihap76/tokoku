-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 31, 2024 at 03:28 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tokoku`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
(1, '2024_04_12_052307_create_tbl_roles', 1),
(2, '2014_10_12_000000_create_users_table', 2),
(3, '2024_04_19_062952_create_tbl_produk', 3),
(26, '2024_05_03_035036_create_tbl_customer', 4),
(27, '2014_10_12_100000_create_password_reset_tokens_table', 5),
(28, '2019_08_19_000000_create_failed_jobs_table', 5),
(29, '2019_12_14_000001_create_personal_access_tokens_table', 5),
(30, '2024_05_03_040212_create_tbl_beli_produk', 5),
(31, '2024_06_03_045254_create_tbl_pembayaran', 5),
(32, '2024_06_19_033937_create_tbl_produk_terjual', 5),
(33, '2024_07_25_120242_create_tbl_screenshots_produk', 6);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beli_produk`
--

CREATE TABLE `tbl_beli_produk` (
  `id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `status` enum('success','pending','deny') COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tanggal_transaksi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_beli_produk`
--

INSERT INTO `tbl_beli_produk` (`id`, `qty`, `status`, `order_id`, `produk_id`, `user_id`, `tanggal_transaksi`) VALUES
(1, 1, 'success', '603974', 1, 2, '2024-07-31'),
(2, 1, 'success', '833673', 2, 3, '2024-07-31'),
(3, 1, 'success', '808176', 3, 3, '2024-07-31');

--
-- Triggers `tbl_beli_produk`
--
DELIMITER $$
CREATE TRIGGER `after_update_tbl_beli_produk` AFTER UPDATE ON `tbl_beli_produk` FOR EACH ROW BEGIN

DECLARE v_produk_id INT;
DECLARE v_qty INT;

    -- Ambil data dari tbl_beli_produk yang baru di-update
SET v_produk_id = OLD.produk_id;
SET v_qty = OLD.qty;

    -- Periksa status
    IF OLD.status = 'pending' AND NEW.status = 'success' THEN
    
        -- Masukkan data ke tbl_produk_terjual
        INSERT INTO tbl_produk_terjual (jumlah_terjual, produk_id) VALUES (v_qty, v_produk_id);
        
    END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id`, `nomor_telepon`, `user_id`) VALUES
(1, '084567892345', 2),
(2, '086723546789', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembayaran`
--

CREATE TABLE `tbl_pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `metode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pembayaran`
--

INSERT INTO `tbl_pembayaran` (`id`, `total`, `metode`, `order_id`) VALUES
(1, 350000, 'credit_card', '603974'),
(2, 3000000, 'credit_card', '833673'),
(3, 1000000, 'credit_card', '808176');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `status` enum('tersedia','masih dalam pengembangan','tidak tersedia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id`, `nama`, `deskripsi`, `harga`, `status`, `file`, `created_at`, `updated_at`) VALUES
(1, 'Laravel 9 CRUD & Autentikasi', 'Program CRUD beserta autentikasi sederhana dengan Laravel 9 dan MySQL. Di khususkan untuk mahasiswa.', 350000, 'tersedia', 'laravel9-crud-dan-autentikasi.zip', '2024-07-31 13:19:47', '2024-07-31 14:23:00'),
(2, 'Web Film', 'Website film di bangun dengan PHP dan MySQL.', 3000000, 'tersedia', 'web-film.zip', '2024-07-31 13:36:38', '2024-07-31 13:36:38'),
(3, 'Website Makanan', 'Web makanan di bangun dengan JavasScript.', 1000000, 'tersedia', 'web-makanan.zip', '2024-07-31 14:22:40', '2024-07-31 14:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk_terjual`
--

CREATE TABLE `tbl_produk_terjual` (
  `id` bigint UNSIGNED NOT NULL,
  `jumlah_terjual` int NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_produk_terjual`
--

INSERT INTO `tbl_produk_terjual` (`id`, `jumlah_terjual`, `produk_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'costumer');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_screenshots_produk`
--

CREATE TABLE `tbl_screenshots_produk` (
  `id` bigint UNSIGNED NOT NULL,
  `folder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_screenshots_produk`
--

INSERT INTO `tbl_screenshots_produk` (`id`, `folder`, `produk_id`) VALUES
(1, 'extract_screenshots-laravel9-crud-dan-autentikasi_1722432392', 1),
(2, 'extract_screenshots-web-film_1722435185', 2),
(3, 'extract_web-makanan_1722435904', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `profile_picture`, `remember_token`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 'Galih Anggoro Prasetya', 'g4lihanggoro@gmail.com', NULL, '$2y$10$v5B0RKc/6yC.umEV/30N8.RboOJoCuRdcTe64BiW1jr4lHm2eqHnW', 'avatar-admin.png', NULL, 1, '2024-07-31 13:12:15', '2024-07-31 14:26:00'),
(2, 'Makoto Makimura', 'makoto@mail.com', NULL, '$2y$10$InnWPpg3LHyJAQqg1lHq/eBLx.VfSaUOD9KJA4njYAXjXdb5OavCu', 'avatar-4.png', 'XJicTBhqLJ18Tm3loyH62WZ3ehydOOVeScTL2CFN8puOzMZqOvM78GG2PQx1', 2, '2024-07-31 14:06:52', '2024-07-31 14:29:12'),
(3, 'Kazuma Kiryu', 'kazuma@mail.com', NULL, '$2y$10$aouYlqtAhYhFQmfGwNmwkeTmTY2ewZNS1LM8cz3t32pOo.g6jXn2e', 'avatar-5.png', '14t2ASRwFTrYHhnjdYdvJrCSq9LLtoPacCOM3yRehVazrfBNe3TtlIC1nEKq', 2, '2024-07-31 14:18:25', '2024-07-31 14:39:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tbl_beli_produk`
--
ALTER TABLE `tbl_beli_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_beli_produk_produk_id_foreign` (`produk_id`),
  ADD KEY `tbl_beli_produk_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_customer_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_pembayaran_order_id_unique` (`order_id`),
  ADD KEY `tbl_pembayaran_order_id_index` (`order_id`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_produk_terjual`
--
ALTER TABLE `tbl_produk_terjual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_produk_terjual_produk_id_foreign` (`produk_id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_screenshots_produk`
--
ALTER TABLE `tbl_screenshots_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_screenshots_produk_produk_id_foreign` (`produk_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_beli_produk`
--
ALTER TABLE `tbl_beli_produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_produk_terjual`
--
ALTER TABLE `tbl_produk_terjual`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_screenshots_produk`
--
ALTER TABLE `tbl_screenshots_produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_beli_produk`
--
ALTER TABLE `tbl_beli_produk`
  ADD CONSTRAINT `tbl_beli_produk_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_beli_produk_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD CONSTRAINT `tbl_customer_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_produk_terjual`
--
ALTER TABLE `tbl_produk_terjual`
  ADD CONSTRAINT `tbl_produk_terjual_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_screenshots_produk`
--
ALTER TABLE `tbl_screenshots_produk`
  ADD CONSTRAINT `tbl_screenshots_produk_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `tbl_produk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
