-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 08:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ass`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `f_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Reviewed','Resolved') DEFAULT 'Pending',
  `rating` enum('1','2','3','4','5') NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`f_id`, `id`, `message`, `created_at`, `status`, `rating`) VALUES
(1, 6, 'Great service! I am very happy with the product.', '2025-04-27 23:12:33', 'Resolved', '5'),
(2, 8, 'The experience was good, but the delivery was a bit slow.', '2025-04-27 23:12:33', 'Resolved', '4'),
(3, 10, 'Loved the quality, but the packaging could be better.', '2025-04-27 23:12:33', 'Resolved', '4'),
(4, 9, 'Excellent customer support! I will definitely recommend.', '2025-04-27 23:12:33', 'Resolved', '5'),
(5, 5, 'Not satisfied with the product. It arrived damaged.', '2025-04-27 23:12:33', 'Reviewed', '2'),
(6, 6, 'Great quality, fast shipping, very happy with the purchase!', '2025-04-27 23:12:33', 'Resolved', '5'),
(7, 7, 'The product was okay, but it didn’t meet my expectations.', '2025-04-27 23:12:33', 'Pending', '3'),
(8, 8, 'I am very disappointed. The item was not as described.', '2025-04-27 23:12:33', 'Reviewed', '2'),
(9, 9, 'Fantastic! Just what I needed. Thank you for the quick response!', '2025-04-27 23:12:33', 'Resolved', '5'),
(11, 11, 'Everything was perfect, would buy again!', '2025-04-27 23:12:33', 'Resolved', '5'),
(12, 12, 'I am still waiting for a response to my complaint.', '2025-04-27 23:12:33', 'Pending', '3'),
(13, 13, 'The product is good but could use some improvements.', '2025-04-27 23:12:33', 'Reviewed', '4'),
(14, 14, 'Amazing experience. Will definitely purchase again from this store!', '2025-04-27 23:12:33', 'Resolved', '5'),
(15, 15, 'The support team was very helpful in resolving my issue.', '2025-04-27 23:12:33', 'Reviewed', '4'),
(16, 1, 'xdcefvrgbthynj', '2025-12-14 04:27:44', 'Pending', '5'),
(17, 1, 'qswdefgrtyjuiolkjfdhsrdefollikujtyrhgefwden', '2025-12-14 04:29:55', 'Pending', '4');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Paid','Shipped','Completed','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `id`, `total_amount`, `status`) VALUES
(39, 1, 9.25, 'Paid'),
(40, 1, 9.25, 'Paid'),
(41, 1, 9.25, 'Paid'),
(42, 1, 9.25, 'Paid'),
(43, 1, 9.25, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `oi_id` int(11) NOT NULL,
  `o_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`oi_id`, `o_id`, `p_id`, `quantity`, `price`) VALUES
(7, 39, 37, 1, 5.90),
(8, 40, 37, 1, 5.90),
(9, 41, 50, 1, 5.90),
(10, 42, 50, 1, 5.90),
(11, 43, 50, 1, 5.90);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_description` text DEFAULT NULL,
  `p_quantity` int(11) NOT NULL,
  `p_price` decimal(10,2) NOT NULL,
  `p_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `p_name`, `p_description`, `p_quantity`, `p_price`, `p_photo`) VALUES
(37, 'Salmon Sushi (2 pcs)', 'Raw Salmon.', 100, 5.90, 'SalmonSushi.jpg'),
(50, 'Tuna Mayo Maki (4pcs)', 'fresh, raw tuna, often deep red, served as simple slices (sashimi/nigiri) or rolled with vinegared rice, seaweed (nori), and sometimes spicy mayo or cucumber (maki)', 100, 5.90, '20251215_074836_Tuna-Maki.jpg'),
(51, 'Egg Sushi (2pcs)', 'a slice of subtly sweet, layered Japanese rolled omelet (Tamagoyaki) placed over a small bed of seasoned sushi rice, often secured with a thin strip of nori seaweed, offering a delicate, fluffy, and savory-sweet flavor.', 100, 4.90, 'EggSushi.jpg'),
(69, 'Egg Mayo Sushi (2pcs)', 'a type of sushi featuring a creamy and rich filling made primarily from chopped hard-boiled eggs mixed with Japanese mayonnaise.', 35, 3.00, '20251215_070105_EggMayi.jpg'),
(70, 'Chuka Kurage Himo Sushi (2pcs)', 'seasoned, thinly sliced jellyfish served as a sushi topping.', 50, 5.90, '20251215_072552_Gunkan-Chuka-Kurage-Himo.jpg'),
(71, 'Spicy Yakiniku Sushi (2pcs)', 'Spicy pan-fried beef with spicy mayo.', 45, 6.50, '20251215_072817_Spicy-Yakiniku-Gunkan-edit.jpg'),
(72, 'Soboro Sushi (2pcs)', 'Minced chicken & mayo', 45, 5.80, '20251215_072929_Tori-Soboro-Gunkan.jpg'),
(73, 'Cheesy Smoked Duck Sushi (2pcs)', 'Smoked duck with cheese sauce.', 40, 6.90, '20251215_073053_Gunkan-Cheesy-Smoked-Duck-1.jpg'),
(74, 'Kani Tsubukko (2pcs)', 'Crabstick mayo with fish roe.', 60, 4.40, '20251215_073407_Gunkan-Kani-Tsubukko.jpg'),
(75, 'Iidako Sushi (2 pcs)', 'Seasoned baby octopus.', 50, 3.20, '20251215_074513_Goma-Iidako.jpg'),
(76, 'Spicy Golden Ball (2pcs)', 'Deep-fried egg with crabstick mayo & spicy mayo.', 50, 5.00, '20251215_073739_Spicy-Golden-Ball-edit.jpg'),
(77, 'Kappa Maki (2pcs)', 'a simple, traditional Japanese sushi roll (hosomaki) featuring crisp cucumber sticks, seasoned sushi rice, and a wrapping of nori seaweed', 55, 2.00, '20251215_073914_Maki-Kappa-Maki.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` varchar(100) NOT NULL,
  `expire` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `role` enum('admin','member') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `photo`, `role`) VALUES
(1, 'joeylaumh06@gmail.com', '41db09e9142697c898f6f43d3ac64a2422798a6c', 'Joey Lau Ming Hui', '1.png', 'admin'),
(2, 'qiyan@gmail.com', '6def653a6fc4c88efd95f667d88d2349fcd2817b', 'Chong Qi Yan', '2.png', 'admin'),
(3, 'qilin@gmail.cpm', 'a08b967d4acc0d66c4391ca868161ca60250acf3', 'Chong Qi Lin', '3.png', 'admin'),
(4, 'yunmo@gmail.com', 'da87e39746d466b1d4493da26c8207f790d41c53', 'Gan Zhi Ying', '4.png', 'admin'),
(5, 'greentea@gmail.com', '3cf5364a255428e39d5a0ec6017c9df9cb42b34f', 'Chin Yu Xuan', '5.png', 'member'),
(6, 'alice@gmail.com', 'f0bd251b08338c230d420f33106faf13a12cace5', 'Alice Tan Li Ying', 'cat.jpg', 'member'),
(7, 'brian@example.com', '0873574da91656e64c932eb0b4bb30affc189139', 'Brian Ng Wei Jie', '7.png', 'member'),
(8, 'carmen@example.com', '3d946e281bb2112005d2d570dea219ee2790966b', 'Carmen Lee Jia Xin', '8.png', 'member'),
(9, 'danny@example.com', '11ee4b32e45e083230cb2c9b6ca91ae524c44b2a', 'Danny Chong Yi Xuan', '9.png', 'member'),
(10, 'elisa@example.com', '538fbf0c9897f8fb8e9b2e188fa56b2a580119db', 'Elisa Teo Mei Fang', '10.png', 'member'),
(11, 'felix@example.com', 'aebd14ca679f1fae02418b71c30ce622d658369a', 'Felix Goh Jun Kai', '11.png', 'member'),
(12, 'grace@example.com', 'd4011813dc4ebaaf9e86b389ba4efad263cd2a5b', 'Grace Lim Siew Ling', '12.png', 'member'),
(13, 'harris@example.com', '188694835236c3929de268fcffcce84cc8b32c33', 'Harris Wong Kai Ming', '13.png', 'member'),
(14, 'ivy@example.com', '630a6f349d492fa9e34fb7d58da63f35403c2b06', 'Ivy Chin Mei Yee', '14.png', 'member'),
(15, 'jack@example.com', '4a27b3ae456b0a3f7ae14e8d0b0847549b711859', 'Jack Tan Jun Hao', '15.png', 'member'),
(16, 'kelly@example.com', 'a8c34c5de28bfd233d3cc010d92f76d900f7324b', 'Kelly Lim Pei Wen', '16.png', 'member'),
(17, 'leon@example.com', '275f367a9df19158de72e218e6f5cb1728f760c1', 'Leon Ong Wei Han', '17.png', 'member'),
(18, 'mia@example.com', '27258354aaebba8ae382f5b9d6c4c8ef42d799fd', 'Mia Goh Li Ling', '18.png', 'member'),
(19, 'nathan@example.com', '7cd32cc44f0dbac4b255418d146e1b6710d9e151', 'Nathan Lee Kai Jun', '19.png', 'member'),
(20, 'olivia@example.com', '514bde88a91911bfe92d18f4015effa07df73484', 'Olivia Chan Xue Yi', '20.png', 'member'),
(21, 'peter@example.com', '328854132bf61a37c6b4a64be7b23d03b74f8f83', 'Peter Lau Jian Ming', '21.png', 'member'),
(22, 'queenie@example.com', '8e07fdff12aab5244fce515149944b1ec314d48a', 'Queenie Teh Jia Hui', '22.png', 'member'),
(23, 'ryan@example.com', '428485ace74306977e4979d687e57ab2fb85a4aa', 'Ryan Liew Wei Yang', '23.png', 'member'),
(29, 'kentsee02@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'kentsee', '24.png', 'admin'),
(30, 'm1@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'See', '25.png', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`oi_id`),
  ADD KEY `o_id` (`o_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `oi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`o_id`) REFERENCES `orders` (`o_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `product` (`p_id`);

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
