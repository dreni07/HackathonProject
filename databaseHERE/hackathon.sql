-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 03:21 PM
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
-- Database: `hackathon`
--

-- --------------------------------------------------------

--
-- Table structure for table `admintable`
--

CREATE TABLE `admintable` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(100) NOT NULL,
  `admin_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admintable`
--

INSERT INTO `admintable` (`admin_id`, `admin_username`, `admin_password`) VALUES
(1, 'Dren', 'drenllazani');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `id_order`) VALUES
(1, 3),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Health'),
(2, 'Sports & Outdoors'),
(3, 'Home & Kitchen'),
(4, 'Technology'),
(5, 'Electronics'),
(6, 'Toys & Games'),
(7, 'Clothes'),
(8, 'Pets');

-- --------------------------------------------------------

--
-- Table structure for table `interactions`
--

CREATE TABLE `interactions` (
  `interactions_id` int(11) NOT NULL,
  `product_interacted` int(11) NOT NULL,
  `user_interacted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interactions`
--

INSERT INTO `interactions` (`interactions_id`, `product_interacted`, `user_interacted`) VALUES
(1, 3, 8),
(2, 7, 8),
(3, 4, 8),
(4, 7, 8),
(5, 11, 9),
(6, 2, 10),
(7, 1, 10),
(8, 4, 10),
(9, 7, 10),
(10, 11, 10),
(11, 1, 12),
(12, 3, 12),
(13, 2, 12),
(14, 4, 12),
(15, 2, 12),
(16, 4, 12),
(17, 6, 12),
(18, 5, 12),
(19, 8, 12),
(20, 1, 12),
(21, 13, 12),
(22, 5, 12),
(23, 7, 12),
(24, 8, 12),
(25, 6, 12),
(26, 11, 12),
(27, 5, 12),
(28, 5, 12),
(29, 12, 12),
(30, 9, 12),
(31, 5, 12),
(32, 2, 12),
(33, 4, 12),
(34, 8, 12),
(35, 11, 12),
(36, 8, 12),
(37, 7, 12),
(38, 13, 12),
(39, 13, 12),
(40, 1, 12),
(41, 2, 12),
(42, 4, 12),
(43, 9, 12),
(44, 7, 12),
(45, 8, 13),
(46, 6, 13),
(47, 5, 13),
(48, 4, 13),
(49, 3, 13),
(50, 1, 13),
(51, 7, 13),
(52, 7, 13),
(53, 1, 13),
(54, 10, 13),
(55, 12, 13),
(56, 11, 13),
(57, 1, 13),
(58, 10, 13),
(59, 10, 13),
(60, 2, 13),
(61, 11, 13),
(62, 2, 13),
(63, 9, 13),
(64, 9, 13),
(65, 13, 13),
(66, 2, 13),
(67, 1, 13),
(68, 2, 13),
(69, 11, 13),
(70, 10, 13),
(71, 1, 13),
(72, 1, 13),
(73, 1, 13),
(74, 3, 13),
(75, 5, 13),
(76, 8, 13),
(77, 7, 13),
(78, 8, 13),
(79, 1, 13),
(80, 3, 13),
(81, 5, 13),
(82, 8, 13),
(83, 2, 13),
(84, 3, 13),
(85, 8, 13),
(86, 4, 13),
(87, 3, 13),
(88, 3, 13),
(89, 5, 13),
(90, 6, 13),
(91, 4, 13),
(92, 10, 13),
(93, 1, 13),
(94, 2, 13),
(95, 3, 13),
(96, 7, 13),
(97, 10, 13),
(98, 4, 13),
(99, 6, 13),
(100, 4, 13),
(101, 1, 13),
(102, 2, 13),
(103, 5, 13),
(104, 12, 13),
(105, 28, 13),
(106, 2, 13),
(107, 6, 13),
(108, 7, 13);

-- --------------------------------------------------------

--
-- Table structure for table `likedproducts`
--

CREATE TABLE `likedproducts` (
  `likedProductId` int(11) NOT NULL,
  `product_liked_id` int(11) NOT NULL,
  `user_liked_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likedproducts`
--

INSERT INTO `likedproducts` (`likedProductId`, `product_liked_id`, `user_liked_id`) VALUES
(1, 3, 7),
(2, 3, 8),
(3, 3, 12),
(4, 6, 12),
(5, 5, 12),
(6, 8, 12),
(7, 13, 12),
(8, 8, 13),
(9, 6, 13),
(10, 5, 13),
(11, 4, 13),
(12, 3, 13),
(13, 7, 13),
(14, 9, 13),
(15, 13, 13),
(16, 2, 13),
(17, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_title` text NOT NULL,
  `news_desc` text NOT NULL,
  `news_image` text NOT NULL,
  `news_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_title`, `news_desc`, `news_image`, `news_date`) VALUES
('Sending Emails', 'Sending Emails For Everyone', 'mail.png', '2024-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `order_completion` enum('Pending','Accepted','Failed') DEFAULT 'Pending',
  `order_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `id_product`, `id_user`, `order_quantity`, `order_completion`, `order_date`) VALUES
(1, 3, 7, 3, 'Accepted', '2024-11-23'),
(2, 3, 7, 1, 'Accepted', '2024-11-23'),
(3, 3, 7, 1, 'Accepted', '2024-11-23'),
(4, 2, 7, 2, 'Accepted', '2024-11-24'),
(5, 8, 12, 2, 'Accepted', '2024-11-24'),
(6, 7, 12, 2, 'Accepted', '2024-11-24'),
(7, 5, 12, 1, 'Accepted', '2024-11-24'),
(8, 7, 12, 1, 'Accepted', '2024-11-24'),
(9, 5, 12, 1, 'Accepted', '2024-11-24'),
(10, 5, 12, 2, 'Accepted', '2024-11-24'),
(11, 4, 12, 3, 'Accepted', '2024-11-24'),
(12, 6, 12, 8, 'Accepted', '2024-11-24'),
(13, 5, 12, 1, 'Accepted', '2024-11-24'),
(14, 8, 12, 1, 'Accepted', '2024-11-24'),
(15, 1, 12, 1, 'Accepted', '2024-11-24'),
(16, 13, 12, 1, 'Accepted', '2024-11-24'),
(17, 5, 12, 1, 'Accepted', '2024-11-24'),
(18, 7, 12, 3, 'Accepted', '2024-11-24'),
(19, 8, 12, 3, 'Accepted', '2024-11-24'),
(20, 11, 12, 5, 'Accepted', '2024-11-24'),
(21, 5, 12, 3, 'Accepted', '2024-11-24'),
(22, 5, 12, 3, 'Accepted', '2024-11-24'),
(23, 12, 12, 3, 'Accepted', '2024-11-24'),
(24, 9, 12, 4, 'Accepted', '2024-11-24'),
(25, 2, 12, 1, 'Accepted', '2024-11-24'),
(26, 8, 12, 2, 'Accepted', '2024-11-24'),
(27, 11, 12, 5, 'Accepted', '2024-11-24'),
(28, 4, 12, 4, 'Accepted', '2024-11-24'),
(29, 7, 12, 1, 'Accepted', '2024-11-24'),
(30, 13, 12, 2, 'Accepted', '2024-11-24'),
(31, 9, 12, 2, 'Accepted', '2024-11-24'),
(32, 2, 12, 2, 'Accepted', '2024-11-24'),
(33, 1, 12, 2, 'Accepted', '2024-11-24'),
(34, 4, 12, 1, 'Accepted', '2024-11-24'),
(35, 1, 13, 4, 'Accepted', '2024-11-24'),
(36, 7, 13, 1, 'Accepted', '2024-11-24'),
(37, 1, 13, 1, 'Accepted', '2024-11-24'),
(38, 10, 13, 1, 'Accepted', '2024-11-24'),
(39, 12, 13, 1, 'Accepted', '2024-11-24'),
(40, 11, 13, 3, 'Accepted', '2024-11-24'),
(41, 1, 13, 2, 'Accepted', '2024-11-24'),
(42, 10, 13, 1, 'Accepted', '2024-11-24'),
(43, 2, 13, 2, 'Accepted', '2024-11-24'),
(44, 11, 13, 2, 'Accepted', '2024-11-24'),
(45, 2, 13, 1, 'Accepted', '2024-11-24'),
(46, 9, 13, 2, 'Accepted', '2024-11-24'),
(47, 2, 13, 1, 'Accepted', '2024-11-24'),
(48, 1, 13, 2, 'Accepted', '2024-11-24'),
(49, 11, 13, 2, 'Accepted', '2024-11-24'),
(50, 10, 13, 1, 'Accepted', '2024-11-24'),
(51, 1, 13, 1, 'Accepted', '2024-11-24'),
(52, 1, 13, 1, 'Accepted', '2024-11-24'),
(53, 8, 13, 5, 'Accepted', '2024-11-24'),
(54, 3, 13, 1, 'Accepted', '2024-11-24'),
(55, 5, 13, 3, 'Accepted', '2024-11-24'),
(56, 7, 13, 1, 'Accepted', '2024-11-24'),
(57, 8, 13, 1, 'Accepted', '2024-11-24'),
(58, 1, 13, 4, 'Accepted', '2024-11-24'),
(59, 3, 13, 1, 'Accepted', '2024-11-24'),
(60, 5, 13, 1, 'Accepted', '2024-11-24'),
(61, 8, 13, 1, 'Accepted', '2024-11-24'),
(62, 8, 13, 3, 'Accepted', '2024-11-24'),
(63, 3, 13, 3, 'Accepted', '2024-11-24'),
(64, 4, 13, 4, 'Accepted', '2024-11-24'),
(65, 3, 13, 3, 'Accepted', '2024-11-24'),
(66, 5, 13, 4, 'Accepted', '2024-11-24'),
(67, 6, 13, 5, 'Accepted', '2024-11-24'),
(68, 3, 13, 1, 'Accepted', '2024-11-24'),
(69, 4, 13, 3, 'Accepted', '2024-11-24'),
(70, 10, 13, 3, 'Accepted', '2024-11-24'),
(71, 3, 13, 1, 'Accepted', '2024-11-24'),
(72, 2, 13, 2, 'Accepted', '2024-11-24'),
(73, 7, 13, 3, 'Accepted', '2024-11-24'),
(74, 10, 13, 3, 'Accepted', '2024-11-24'),
(75, 4, 13, 2, 'Accepted', '2024-11-24'),
(76, 6, 13, 2, 'Accepted', '2024-11-24'),
(77, 4, 13, 1, 'Accepted', '2024-11-24'),
(78, 2, 13, 2, 'Accepted', '2024-11-24'),
(79, 5, 13, 2, 'Accepted', '2024-11-24'),
(80, 28, 13, 3, 'Accepted', '2024-11-24'),
(81, 12, 13, 1, 'Accepted', '2024-11-24'),
(82, 6, 13, 1, 'Accepted', '2024-11-24'),
(83, 2, 13, 1, 'Accepted', '2024-11-24'),
(84, 7, 13, 1, 'Accepted', '2024-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_category` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_in_stock` int(11) NOT NULL,
  `product_description` varchar(255) DEFAULT NULL,
  `added_by_ai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_category`, `product_name`, `product_image`, `product_price`, `product_in_stock`, `product_description`, `added_by_ai`) VALUES
(1, 1, 'All Weather Jacket', 'all_weather.jpg', 29.00, 6, 'Super Weather Jacket!Dont Miss It', NULL),
(2, 4, 'Gaming Pc', 'gamingpc.avif', 1110.00, 5, '5ghz Proccessor 16GB RAM 512GB SSD', NULL),
(3, 4, 'Iphone 15', 'iphone15.avif', 900.00, 0, 'Iphone 15 NEW', NULL),
(4, 3, 'Garden Tools', 'gardenTools.avif', 34.00, 0, '	\r\nGarden Tools To Make Your Life Easier', NULL),
(5, 8, 'Pet Toys', 'pettoys.avif', 8.00, 0, 'Dont Miss The Chance To Buy Your Pet Some Toys!', NULL),
(6, 4, 'Headphones', 'headphones.avif', 91.00, 2, 'Super Ultra New Headphones', NULL),
(7, 1, 'Dior Savage', 'dior-savage.avif', 85.00, 5, 'Dior Savage Replica For Optimal Price', NULL),
(8, 2, 'Monitor', 'monitor.avif', 102.00, 0, '240Hz Monitor For Gaming', NULL),
(9, 2, 'Keyboard', 'gamingKey.avif', 30.00, 10, 'Mechanical Gaming Keyboard', NULL),
(10, 4, 'Macbook', 'macbook.avif', 1150.00, 4, 'Newest Macbook On Stock', NULL),
(11, 2, 'Mouse', 'bluetoothMouse.avif', 12.00, 2, 'Bluetooth Mouse For Your Electronic Device', NULL),
(12, 2, 'Samsung', 'samsung.avif', 900.00, 2, 'Samsung Ultra S23 With An Option To Fold It', NULL),
(13, 2, 'Proccessor', 'proccessori.avif', 345.00, 10, '5ghz I7 Gen 11', NULL),
(28, 1, 'Wellness Tracker ', 'https://images.unsplash.com/34/rcaNUh3pQ9GD8w7Iy8qE__DSC0940.jpg?ixid=M3w2NzkwNTZ8MHwxfHJhbmRvbXx8fHx8fHx8fDE3MzI0NjA3NzF8&ixlib=rb-4.0.3', 49.00, 7, ' A sleek, lightweight fitness tracker that monitors your heart rate, steps, sleep patterns, and calories burned, helping you stay on top of your health goals.', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `temp_table`
--

CREATE TABLE `temp_table` (
  `last_product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_table`
--

INSERT INTO `temp_table` (`last_product`) VALUES
(13);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_interactions`
--

CREATE TABLE `tmp_interactions` (
  `tmp_interaction_id` int(11) NOT NULL,
  `tmp_product_id` int(11) NOT NULL,
  `interaction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tmp_interactions`
--

INSERT INTO `tmp_interactions` (`tmp_interaction_id`, `tmp_product_id`, `interaction_id`) VALUES
(2, 1, 5),
(1, 2, 4),
(3, 3, 3),
(1, 4, 2),
(4, 5, 1),
(1, 6, 11),
(2, 7, 10),
(1, 8, 9),
(3, 9, 8),
(1, 10, 7),
(3, 11, 16),
(4, 12, 15),
(3, 13, 14),
(4, 14, 13),
(4, 15, 12),
(2, 16, 24),
(1, 17, 23),
(8, 18, 22),
(2, 19, 21),
(1, 20, 20),
(2, 21, 30),
(2, 22, 29),
(8, 23, 28),
(8, 24, 27),
(2, 25, 26),
(2, 26, 35),
(2, 27, 34),
(3, 28, 33),
(4, 29, 32),
(8, 30, 31),
(1, 31, 44),
(2, 32, 43),
(3, 33, 42),
(4, 34, 41),
(1, 35, 40),
(4, 36, 49),
(3, 37, 48),
(8, 38, 47),
(4, 39, 46),
(2, 40, 45),
(1, 41, 57),
(2, 42, 56),
(2, 43, 55),
(4, 44, 54),
(1, 45, 53),
(2, 46, 65),
(2, 47, 64),
(2, 48, 63),
(4, 49, 62),
(2, 50, 61),
(2, 51, 69),
(4, 52, 68),
(1, 53, 67),
(4, 54, 66),
(2, 55, 65),
(1, 56, 73),
(1, 57, 72),
(1, 58, 71),
(4, 59, 70),
(2, 60, 69),
(1, 61, 79),
(2, 62, 78),
(1, 63, 77),
(2, 64, 76),
(8, 65, 75),
(3, 66, 86),
(2, 67, 85),
(4, 68, 84),
(4, 69, 83),
(2, 70, 82),
(1, 71, 93),
(4, 72, 92),
(3, 73, 91),
(4, 74, 90),
(8, 75, 89),
(3, 76, 100),
(4, 77, 99),
(3, 78, 98),
(4, 79, 97),
(1, 80, 96),
(1, 81, 108),
(4, 82, 107),
(4, 83, 106),
(1, 84, 105),
(2, 85, 104);

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_clicked` int(11) NOT NULL,
  `the_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `user_id`, `product_clicked`, `the_date`) VALUES
(1, 7, 4, '2024-11-23'),
(2, 7, 4, '2024-11-23'),
(3, 7, 4, '2024-11-23'),
(4, 7, 2, '2024-11-23'),
(5, 7, 4, '2024-11-23'),
(6, 7, 1, '2024-11-23'),
(7, 7, 4, '2024-11-23'),
(8, 8, 7, '2024-11-24'),
(9, 8, 4, '2024-11-24'),
(10, 8, 7, '2024-11-24'),
(11, 9, 11, '2024-11-24'),
(12, 10, 2, '2024-11-24'),
(13, 10, 1, '2024-11-24'),
(14, 10, 4, '2024-11-24'),
(15, 10, 7, '2024-11-24'),
(16, 10, 11, '2024-11-24'),
(17, 12, 1, '2024-11-24'),
(18, 12, 2, '2024-11-24'),
(19, 12, 2, '2024-11-24'),
(20, 12, 4, '2024-11-24'),
(21, 12, 7, '2024-11-24'),
(22, 13, 10, '2024-11-24'),
(23, 13, 2, '2024-11-24'),
(24, 13, 1, '2024-11-24'),
(25, 13, 1, '2024-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'Dren', 'drenllazani10@gmail.com', '$2y$10$Q1YiOd2wKR2DqFOWAHdGDezmeYBqnOQ.nCNP4YymR4HhWKvSat0JG'),
(2, 'Dreni', 'drenllazani10@gmail.com', '$2y$10$D2VrbAxJLghS5LzkzaTN5evhgJZnqlE72hfG002LxBHqh61PeFsMq'),
(3, 'Ylli', 'drenllaza@gmail.com', '$2y$10$gm.zGIENWSZquVSm0mV/3O63l64i3EfG0iz4eymJMiq9Z08RsR8iu'),
(4, 'Vlera', 'vlerllazani@gmail.com', '$2y$10$hLAndypTx5DnO5G0aLMhNOwOffZRuW6LZfBs.J.C7ZgOdFWjxGDMO'),
(5, 'Alma', 'almakamberi@gmail.com', '$2y$10$Q9p6t2UDjiv6qxNwkANitu9spEJ9jqrzfqSdWYPVtZ5hjYcEhX.We'),
(6, 'Dreni', 'drenllazani10@gmail.com', '$2y$10$v8jHGD.tcKE2SCQziU9XsuGAFjgVFyjze56m0H2JK5x5b/tDFjGra'),
(7, 'Blerta', 'blerta@gmail.com', '$2y$10$ETS4n1NDoURmPi75jlAYouG4YJhmjB56LzyvrKH5uWT4ZRvJA2vce'),
(8, 'Lulzim', 'lulzimllazani10@gmail.com', '$2y$10$VGYXYCWKU3GYndzpadeSMe5/JaqRlnMt6fU8WlUJWzNmXKLYgfNoG'),
(9, 'Ramize', 'ramize@gmail.com', '$2y$10$gl1QLW9l0s4AriT276FZu.FFZWJRPf98ST0FBNTK4RvSyVocAwN7C'),
(10, 'Luli', 'luli@gmail.com', '$2y$10$9G4LoeSVUZFrlruK294P6ue.qUrI7tf08HCMlX2aPHPbFleqP5.kC'),
(11, 'Luli', 'luli@gmail.com', '$2y$10$8cQrt8.leHVfe8GMkBcNb.LzvzogzSDcQ/sxi94g337NjtccA4Xki'),
(12, 'Leart', 'leart@gmail.com', '$2y$10$qPfnoQlhU8FnE/IJtNSfAeXBo58yb7aeWDMuyDQZVoBtYCuBXT8jW'),
(13, 'Rion', 'rioni@gmail.com', '$2y$10$S3CimN1KqcYbcL7b56H9CejuYb2.yDGEJvYB0v0OEkqvoovZoY8NO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admintable`
--
ALTER TABLE `admintable`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `interactions`
--
ALTER TABLE `interactions`
  ADD PRIMARY KEY (`interactions_id`),
  ADD KEY `interactions_ibfk_1` (`user_interacted`),
  ADD KEY `product_interacted` (`product_interacted`);

--
-- Indexes for table `likedproducts`
--
ALTER TABLE `likedproducts`
  ADD PRIMARY KEY (`likedProductId`),
  ADD KEY `product_liked_id` (`product_liked_id`),
  ADD KEY `user_liked_id` (`user_liked_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_category` (`product_category`);

--
-- Indexes for table `tmp_interactions`
--
ALTER TABLE `tmp_interactions`
  ADD PRIMARY KEY (`tmp_product_id`),
  ADD KEY `tmp_interaction_id` (`tmp_interaction_id`),
  ADD KEY `interaction_id` (`interaction_id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admintable`
--
ALTER TABLE `admintable`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `interactions`
--
ALTER TABLE `interactions`
  MODIFY `interactions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `likedproducts`
--
ALTER TABLE `likedproducts`
  MODIFY `likedProductId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tmp_interactions`
--
ALTER TABLE `tmp_interactions`
  MODIFY `tmp_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `interactions`
--
ALTER TABLE `interactions`
  ADD CONSTRAINT `interactions_ibfk_1` FOREIGN KEY (`user_interacted`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interactions_ibfk_2` FOREIGN KEY (`product_interacted`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likedproducts`
--
ALTER TABLE `likedproducts`
  ADD CONSTRAINT `likedproducts_ibfk_1` FOREIGN KEY (`product_liked_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likedproducts_ibfk_2` FOREIGN KEY (`user_liked_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_category`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tmp_interactions`
--
ALTER TABLE `tmp_interactions`
  ADD CONSTRAINT `tmp_interactions_ibfk_1` FOREIGN KEY (`tmp_interaction_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tmp_interactions_ibfk_2` FOREIGN KEY (`interaction_id`) REFERENCES `interactions` (`interactions_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
