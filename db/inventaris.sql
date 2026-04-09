-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 16, 2025 at 02:15 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris4`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `category_name` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'XL'),
(2, 'TELKOMSEL');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `price` decimal(10,0) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `stock`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 'Voucher XL 1Gb', 9, '20000', '2025-01-16 03:00:23', '2025-01-16 14:14:58'),
(2, 2, 'Telkomsel 1GB', 12, '10000', '2025-01-16 03:01:07', '2025-01-16 14:14:58');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `user_id` int NOT NULL,
  `purchase_date` date NOT NULL,
  `total` decimal(10,2) DEFAULT '0.00',
  `faktur` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `supplier_id`, `user_id`, `purchase_date`, `total`, `faktur`, `created_at`) VALUES
(20, 1, 1, '2025-01-16', '69000.00', 'FAKTUR-004', '2025-01-16 11:55:49'),
(19, 1, 1, '2025-01-16', '138000.00', 'FAKTUR-003', '2025-01-16 11:55:10'),
(18, 1, 1, '2025-01-16', '47000.00', 'FAKTUR-002', '2025-01-16 11:52:21'),
(17, 1, 1, '2025-01-16', '95000.00', 'FAKTUR-001', '2025-01-16 11:50:37'),
(21, 1, 1, '2025-01-16', '25000.00', 'FAKTUR-005', '2025-01-16 11:58:30'),
(22, 1, 1, '2025-01-16', '52000.00', 'FAKTUR-006', '2025-01-16 14:00:32'),
(23, 1, 1, '2025-01-16', '55000.00', 'FAKTUR-007', '2025-01-16 14:02:04'),
(24, 1, 1, '2025-01-16', '25000.00', 'FAKTUR-008', '2025-01-16 14:03:33'),
(25, 1, 1, '2025-01-16', '25678.00', 'FAKTUR-009', '2025-01-16 14:03:55'),
(26, 1, 1, '2025-01-16', '252222.00', 'FAKTUR-010', '2025-01-16 14:07:24'),
(27, 1, 1, '2025-01-16', '252222.00', 'FAKTUR-011', '2025-01-16 14:08:07'),
(28, 1, 1, '2025-01-16', '11000.00', 'FAKTUR-012', '2025-01-16 14:10:10'),
(29, 1, 1, '2025-01-16', '40000.00', 'FAKTUR-013', '2025-01-16 14:14:58');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_detail`
--

CREATE TABLE `purchase_detail` (
  `id` int NOT NULL,
  `purchase_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `purchase_detail`
--

INSERT INTO `purchase_detail` (`id`, `purchase_id`, `product_id`, `quantity`, `price`, `total`) VALUES
(27, 20, 2, 2, '22000.00', '44000.00'),
(26, 20, 1, 1, '25000.00', '25000.00'),
(25, 19, 2, 4, '22000.00', '88000.00'),
(24, 19, 1, 2, '25000.00', '50000.00'),
(23, 18, 2, 1, '22000.00', '22000.00'),
(22, 18, 1, 1, '25000.00', '25000.00'),
(21, 17, 2, 1, '20000.00', '20000.00'),
(20, 17, 1, 3, '25000.00', '75000.00'),
(28, 21, 1, 1, '25000.00', '25000.00'),
(29, 22, 2, 1, '22000.00', '22000.00'),
(30, 22, 1, 1, '30000.00', '30000.00'),
(31, 23, 1, 1, '25000.00', '25000.00'),
(32, 23, 2, 1, '30000.00', '30000.00'),
(33, 24, 1, 1, '25000.00', '25000.00'),
(34, 25, 1, 1, '25678.00', '25678.00'),
(35, 26, 1, 1, '30000.00', '30000.00'),
(36, 26, 2, 1, '222222.00', '222222.00'),
(37, 27, 1, 1, '30000.00', '30000.00'),
(38, 27, 2, 1, '222222.00', '222222.00'),
(39, 28, 1, 1, '5000.00', '5000.00'),
(40, 28, 2, 1, '6000.00', '6000.00'),
(41, 29, 1, 1, '20000.00', '20000.00'),
(42, 29, 2, 2, '10000.00', '20000.00');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `return_type` enum('purchase','sale') NOT NULL,
  `transaction_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `return_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `product_id`, `user_id`, `return_type`, `transaction_id`, `quantity`, `reason`, `return_date`) VALUES
(1, 1, 1, 'purchase', 17, 1, 'Barang cacat produksi', '2025-01-15 17:00:00'),
(2, 1, 1, 'sale', 1, 1, 'Pengembalian dari pelanggan', '2025-01-15 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `quantity` int NOT NULL,
  `info` text,
  `sale_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `user_id`, `quantity`, `info`, `sale_date`) VALUES
(1, 1, 1, 2, 'Barang rusak', '2025-01-15 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_info` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `address`, `contact_info`) VALUES
(1, 'PT Mitra Komunikasi Nusantara', 'Jl. Jendral Sudirman No. 10, Jakarta', '081234567890');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nip` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nip`, `name`, `username`, `password`, `role`) VALUES
(1, '00001', 'Administrator', 'admin', 'admin', 'admin'),
(2, '00002', 'Budi Santoso', 'user', '123', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faktur` (`faktur`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `returns_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
