-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2026 at 09:21 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freshmart_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Sayur', 'Aneka sayuran segar'),
(2, 'Buah', 'Aneka buah pilihan'),
(3, 'Daging', 'Daging segar'),
(4, 'Produk Harian', 'Telur, susu, dan kebutuhan harian'),
(5, 'Buah-buahan', 'Berbagai macam buah segar'),
(6, 'Sayur-sayuran', 'Berbagai macam sayuran segar'),
(7, 'Ikan & Seafood', 'Ikan dan hasil laut segar'),
(8, 'Produk Susu', 'Susu dan produk olahan susu'),
(9, 'Telur', 'Telur ayam, bebek, dan puyuh'),
(10, 'Bumbu Dapur', 'Bumbu dan rempah-rempah');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 5, 'Pesanan FM-20260621-0001 berhasil dibuat. Silakan upload bukti pembayaran.', 0, '2026-06-21 22:20:32'),
(2, 5, 'Bukti pembayaran pesanan FM-20260621-0001 berhasil diupload.', 0, '2026-06-21 22:21:06'),
(3, 5, 'Pesanan FM-20260624-0002 berhasil dibuat. Silakan upload bukti pembayaran.', 0, '2026-06-24 17:04:47'),
(4, 5, 'Bukti pembayaran pesanan FM-20260624-0002 berhasil diupload.', 0, '2026-06-24 17:05:17'),
(5, 5, 'Pesanan FM-20260624-0003 berhasil dibuat. Silakan upload bukti pembayaran.', 0, '2026-06-24 17:08:20'),
(6, 5, 'Bukti pembayaran pesanan FM-20260624-0003 berhasil diupload.', 0, '2026-06-24 17:08:26'),
(7, 5, 'Pembayaran pesanan FM-20260624-0003 sudah dikonfirmasi.', 0, '2026-06-24 17:10:52');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `buyer_id` int(11) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `shipping_cost` decimal(12,2) DEFAULT 0.00,
  `status` enum('Menunggu Pembayaran','Pembayaran Dikonfirmasi','Sedang Diproses','Sedang Dikirim','Pesanan Diterima','Selesai') DEFAULT 'Menunggu Pembayaran',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `buyer_id`, `total_amount`, `shipping_cost`, `status`, `created_at`) VALUES
(1, 'FM-20260621-0001', 5, '250000.00', '0.00', 'Selesai', '2026-06-21 22:20:32'),
(2, 'FM-20260624-0002', 5, '140000.00', '0.00', 'Menunggu Pembayaran', '2026-06-24 17:04:46'),
(3, 'FM-20260624-0003', 5, '125000.00', '0.00', 'Pembayaran Dikonfirmasi', '2026-06-24 17:08:20');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 53, 2, '125000.00'),
(2, 2, 54, 1, '15000.00'),
(3, 2, 53, 1, '125000.00'),
(4, 3, 29, 1, '125000.00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`, `created_at`) VALUES
(2, 'buyer@freshmart.test', 'f81208b7c29b407f6d556ac7cac8d66152d1404d78f26fc6029090f85ab976ba', '2026-06-19 10:37:11', '2026-06-19 15:07:11');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `proof` varchar(255) DEFAULT NULL,
  `status` enum('Menunggu Konfirmasi','Dikonfirmasi','Ditolak') DEFAULT 'Menunggu Konfirmasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `proof`, `status`) VALUES
(1, 1, 'DANA', 'payment_1782055266_695.png', 'Menunggu Konfirmasi'),
(2, 2, 'Transfer Bank', 'payment_1782295517_979.png', 'Menunggu Konfirmasi'),
(3, 3, 'Transfer Bank', 'payment_1782295706_363.png', 'Dikonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `weight_size` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT 'default-product.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `category_id`, `name`, `weight_size`, `description`, `price`, `stock`, `image`) VALUES
(9, 8, 5, 'Apel Fuji Premium', '1 kg', 'Apel Fuji premium memiliki tekstur renyah, rasa manis alami, dan aroma segar yang cocok dikonsumsi langsung setiap hari.', '42000.00', 65, 'buah.png'),
(10, 8, 5, 'Jeruk Sunkist Segar', '1 kg', 'Jeruk Sunkist segar memiliki rasa manis dengan sedikit sensasi asam yang menyegarkan.', '48000.00', 54, 'buah.png'),
(11, 8, 5, 'Pisang Cavendish', '1 sisir (±1 kg)', 'Pisang Cavendish matang memiliki daging buah yang lembut dan manis.', '32000.00', 80, 'buah.png'),
(12, 8, 5, 'Apel Fuji Premium', '1 kg', 'Apel Fuji premium memiliki tekstur renyah, rasa manis alami, dan aroma segar yang cocok dikonsumsi langsung setiap hari.', '42000.00', 65, 'buah.png'),
(13, 8, 5, 'Jeruk Sunkist Segar', '1 kg', 'Jeruk Sunkist segar memiliki rasa manis dengan sedikit sensasi asam yang menyegarkan.', '48000.00', 54, 'buah.png'),
(14, 8, 5, 'Pisang Cavendish', '1 sisir (±1 kg)', 'Pisang Cavendish matang memiliki daging buah yang lembut dan manis.', '32000.00', 80, 'buah.png'),
(15, 8, 5, 'Apel Fuji Premium', '1 kg', 'Apel Fuji premium memiliki tekstur renyah dan rasa manis alami.', '42000.00', 65, 'buah.png'),
(16, 8, 5, 'Jeruk Sunkist Segar', '1 kg', 'Jeruk Sunkist segar memiliki rasa manis dan sedikit asam.', '48000.00', 54, 'buah.png'),
(17, 8, 5, 'Pisang Cavendish', '1 sisir', 'Pisang Cavendish matang memiliki tekstur lembut dan rasa manis.', '32000.00', 80, 'buah.png'),
(18, 8, 5, 'Mangga Harum Manis', '1 kg', 'Mangga Harum Manis memiliki aroma khas dan rasa manis.', '38000.00', 42, 'buah.png'),
(19, 8, 5, 'Semangka Merah Tanpa Biji', '1 buah', 'Semangka merah tanpa biji memiliki kandungan air yang tinggi.', '45000.00', 28, 'buah.png'),
(20, 9, 6, 'Bayam Hijau Segar', '250 gram', 'Bayam hijau segar cocok untuk sayur bening dan tumisan.', '8000.00', 75, 'sayur.png'),
(21, 9, 6, 'Wortel Berastagi', '500 gram', 'Wortel Berastagi memiliki warna oranye cerah dan tekstur renyah.', '16000.00', 64, 'sayur.png'),
(22, 9, 6, 'Brokoli Premium', '500 gram', 'Brokoli premium memiliki kuntum padat dan warna hijau segar.', '28000.00', 38, 'sayur.png'),
(23, 9, 6, 'Kentang Dieng', '1 kg', 'Kentang Dieng memiliki tekstur padat dan rasa gurih alami.', '26000.00', 70, 'sayur.png'),
(24, 9, 6, 'Tomat Merah Segar', '500 gram', 'Tomat merah segar cocok untuk sambal, sup, dan saus.', '14000.00', 58, 'sayur.png'),
(25, 10, 3, 'Daging Sapi Has Dalam', '500 gram', 'Daging sapi has dalam memiliki tekstur empuk dan serat halus.', '85000.00', 32, 'daging.png'),
(26, 10, 3, 'Daging Sapi Giling', '500 gram', 'Daging sapi giling praktis untuk burger dan saus bolognese.', '68000.00', 45, 'daging.png'),
(27, 10, 3, 'Dada Ayam Fillet', '500 gram', 'Dada ayam fillet tanpa tulang mudah diolah.', '39000.00', 60, 'daging.png'),
(28, 10, 3, 'Paha Ayam Potong', '1 kg', 'Paha ayam potong memiliki tekstur lembut dan rasa gurih.', '46000.00', 55, 'daging.png'),
(29, 10, 3, 'Iga Sapi Segar', '1 kg', 'Iga sapi segar cocok untuk sop dan iga bakar.', '125000.00', 19, 'daging.png'),
(30, 11, 7, 'Ikan Salmon Fillet', '250 gram', 'Salmon fillet memiliki tekstur lembut dan rasa gurih alami.', '92000.00', 26, 'ikan.png'),
(31, 11, 7, 'Ikan Kembung Segar', '1 kg', 'Ikan kembung segar cocok untuk digoreng atau dibakar.', '48000.00', 48, 'ikan.png'),
(32, 11, 7, 'Udang Vaname Kupas', '500 gram', 'Udang vaname kupas praktis untuk berbagai hidangan.', '72000.00', 34, 'ikan.png'),
(33, 11, 7, 'Cumi-Cumi Segar', '500 gram', 'Cumi-cumi segar memiliki tekstur kenyal dan rasa khas.', '58000.00', 30, 'ikan.png'),
(34, 11, 7, 'Ikan Nila Bersih', '1 ekor', 'Ikan nila telah dibersihkan dan siap dimasak.', '36000.00', 40, 'ikan.png'),
(35, 12, 8, 'Susu UHT Full Cream', '1 liter', 'Susu UHT full cream memiliki rasa creamy dan gurih.', '22000.00', 85, 'susu.png'),
(36, 12, 8, 'Susu UHT Cokelat', '1 liter', 'Susu UHT cokelat praktis untuk sarapan dan bekal.', '24000.00', 78, 'susu.png'),
(37, 12, 8, 'Yogurt Plain', '500 ml', 'Yogurt plain memiliki rasa asam lembut dan tekstur kental.', '32000.00', 44, 'susu.png'),
(38, 12, 8, 'Keju Cheddar Olahan', '165 gram', 'Keju cheddar olahan mudah diparut dan dipotong.', '28000.00', 50, 'susu.png'),
(39, 12, 8, 'Mentega Tawar', '200 gram', 'Mentega tawar cocok untuk roti dan kue.', '35000.00', 36, 'susu.png'),
(40, 12, 9, 'Telur Ayam Negeri', '1 kg', 'Telur ayam negeri dipilih dalam kondisi utuh dan segar.', '31000.00', 95, 'telur.png'),
(41, 12, 9, 'Telur Ayam Kampung', '10 butir', 'Telur ayam kampung memiliki rasa gurih.', '36000.00', 42, 'telur.png'),
(42, 12, 9, 'Telur Bebek Segar', '10 butir', 'Telur bebek segar memiliki ukuran lebih besar.', '42000.00', 30, 'telur.png'),
(43, 12, 9, 'Telur Puyuh', '30 butir', 'Telur puyuh cocok untuk semur dan sate.', '23000.00', 52, 'telur.png'),
(44, 12, 9, 'Telur Ayam Omega 3', '10 butir', 'Telur ayam Omega 3 cocok untuk menu harian.', '38000.00', 35, 'telur.png'),
(45, 12, 10, 'Bawang Merah Brebes', '500 gram', 'Bawang merah Brebes memiliki aroma khas.', '24000.00', 68, 'bumbu.png'),
(46, 12, 10, 'Bawang Putih Kating', '500 gram', 'Bawang putih kating memiliki siung besar dan aroma kuat.', '28000.00', 62, 'bumbu.png'),
(47, 12, 10, 'Cabai Merah Keriting', '250 gram', 'Cabai merah keriting cocok untuk sambal dan balado.', '18000.00', 46, 'bumbu.png'),
(48, 12, 10, 'Jahe Merah Segar', '250 gram', 'Jahe merah segar memiliki sensasi hangat.', '16000.00', 40, 'bumbu.png'),
(49, 12, 10, 'Kunyit Segar', '250 gram', 'Kunyit segar memiliki warna kuning alami.', '10000.00', 55, 'bumbu.png'),
(50, 12, 4, 'Beras Premium', '5 kg', 'Beras premium menghasilkan nasi yang pulen.', '78000.00', 70, 'harian.png'),
(51, 12, 4, 'Minyak Goreng', '2 liter', 'Minyak goreng cocok untuk menggoreng dan menumis.', '39000.00', 88, 'harian.png'),
(52, 12, 4, 'Gula Pasir Putih', '1 kg', 'Gula pasir putih mudah larut.', '18000.00', 90, 'harian.png'),
(53, 12, 4, 'Mi Instan Goreng', '1 dus', 'Mi instan goreng cocok untuk persediaan makanan praktis.', '125000.00', 21, 'harian.png'),
(54, 12, 4, 'Tepung Terigu Serbaguna', '1 kg', 'Tepung terigu serbaguna cocok untuk berbagai olahan.', '15000.00', 75, 'harian.png');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('buyer','seller','admin') NOT NULL DEFAULT 'buyer',
  `seller_status` enum('pending','approved','rejected') DEFAULT 'approved',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `seller_status`, `created_at`) VALUES
(1, 'Seller Fresh Mart', 'seller@freshmart.test', '$2y$10$9JYMm5kqjG2Q5/sDJh0XB.nT3fHqjBmt.ip1kG5QXpChaukn2Y0Wm', 'seller', 'approved', '2026-06-09 11:54:52'),
(4, 'Admin Fresh Mart', 'admin@freshmart.test', '$2y$10$MnVUc/4jh2Zvke/Y4TKErefXwEkVDMqT4aoRO68WrjIVn0zQ7Cv3G', 'admin', 'approved', '2026-06-09 11:53:41'),
(5, 'Buyer Demo', 'buyer@freshmart.test', '$2y$10$55AeHyOnsIQUVrlTqazlF.hQXR0PH1.ue7sPSMkhea07gRDwAZ4nm', 'buyer', 'approved', '2026-06-09 11:54:20'),
(8, 'Toko Buah Segar', 'buah@freshmart.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'seller', 'approved', '2026-06-17 22:59:56'),
(9, 'Sayur Nusantara', 'sayur@freshmart.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'seller', 'approved', '2026-06-17 22:59:56'),
(10, 'Daging Pilihan', 'daging@freshmart.test', '$2y$10$HQ/QGfuhoxXv7bTM8PLpQuVfNSYWS2DuFl7wcEFTt6i60ZdeOHAmO', 'seller', 'approved', '2026-06-17 22:59:56'),
(11, 'Laut Segar', 'ikan@freshmart.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'seller', 'approved', '2026-06-17 22:59:56'),
(12, 'Daily Fresh Store', 'harian@freshmart.test', '$2y$10$Bmo6FUzOSFLxSXWvCMga9euaHcnoejyftHqVmd4Hd21gjVn6Twioi', 'seller', 'approved', '2026-06-17 22:59:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
