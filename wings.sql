-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 07:18 PM
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
-- Database: `wings`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `expiration_date` date NOT NULL,
  `category` enum('Freezer','Chiller','Stockroom') NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_name`, `amount`, `expiration_date`, `category`, `image_url`, `created_at`) VALUES
(7, 'BUFFALO WINGS SAUCE', 10, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_1EFEFBF1-B399-4494-A3B6-EAC169290A30.jpeg', '2024-10-03 15:07:06'),
(9, 'SOUR CREAM SAUCE', 10, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_8171B44E-E835-4F50-9D22-C7D7A6F065DC.jpeg', '2024-10-03 15:10:16'),
(10, 'HONEY BUTTER SAUCE', 10, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_8D1343D9-04F3-402C-A532-9D8412B8684A.jpeg', '2024-10-03 15:11:24'),
(11, 'LEMON GLADE SAUCE', 10, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_C102FB0B-E465-41DB-954B-15560C72BDF2.jpeg', '2024-10-03 15:12:03'),
(12, 'SWEET CHILI SAUCE', 10, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_9B1126C8-E2B7-4831-AD2C-82C9A316EE80.jpeg', '2024-10-03 15:12:40'),
(13, 'BARBEQUE SAUCE', 10, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_56180308-480D-4148-AA1A-EDF8DFB6A9FD.jpeg', '2024-10-03 15:13:22'),
(14, 'TERIYAKI SAUCE', 10, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_F77C7D9F-292F-403B-9B63-466A28FC8D2D.jpeg', '2024-10-03 15:13:59'),
(15, 'CHILI SAUCE', 10, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_6ADA132E-F737-4878-BB4B-09159B16CD76.jpeg', '2024-10-03 15:14:30'),
(17, 'SOY GARLIC SAUCE', 20, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_DE4E7374-C540-4F43-BBE9-011FA59E6A60.jpeg', '2024-10-03 15:15:48'),
(18, 'GARLIC PAMESAN SAUCE', 10, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_2BE99392-6A20-4E75-B1C8-138FF9332621.jpeg', '2024-10-03 15:16:20'),
(19, 'CHEESE SAUCE', 20, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_701111BC-E0F7-404E-A3D7-CB3A6E98D750.jpeg', '2024-10-03 15:17:01'),
(20, 'SALTED EGG SAUCE', 20, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_27F912B3-1C58-4EDF-A8B8-FEB7F6DC38A8.jpeg', '2024-10-03 15:17:28'),
(21, 'YANGNYEOM KOREAN SAUCE', 20, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_D8428A01-DBF1-40F7-A4F1-C8577C391F68.jpeg', '2024-10-03 15:18:09'),
(22, 'SPECIAL KOREAN SAUCE', 20, '2024-10-03', 'Stockroom', 'uploads/Messenger_creation_62874509-531B-4A23-8622-ED3CFF485415.jpeg', '2024-10-03 15:18:45'),
(23, 'CHICKEN WINGS', 250, '2024-10-03', 'Freezer', 'uploads/Messenger_creation_CD083907-7ED7-4A42-81B0-93E118FC4987.jpeg', '2024-10-03 15:23:37'),
(24, 'CHEESE', 40, '2024-10-03', 'Chiller', 'uploads/Messenger_creation_EC2478BC-C012-41D1-BD98-3EC210752C54.jpeg', '2024-10-03 15:24:02'),
(26, 'ICE', 65, '2024-10-03', 'Freezer', 'uploads/Messenger_creation_1F4F2704-8406-4C3A-A757-F19E1E0E8A88.jpeg', '2024-10-03 15:24:50'),
(27, 'NACHOS CHIP', 65, '2024-10-03', 'Chiller', 'uploads/Messenger_creation_AB8F3CB3-A2EB-457D-AE34-842A91B96BA0.jpeg', '2024-10-03 15:25:29'),
(28, 'WINGS DRUMETTES', 150, '2024-10-03', 'Freezer', 'uploads/Messenger_creation_65E1850F-10CE-4B15-99FA-3335011F7C64.jpeg', '2024-10-03 15:27:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `firstname`, `lastname`) VALUES
(9, 'ivan@gmail.com', '$2y$10$vwygDjez4SN4spdqY.s.E.17FNF0pBET1zjf2ogH/Izemd6rFx/5q', 'Ivan Carl', 'Delos Reyes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
