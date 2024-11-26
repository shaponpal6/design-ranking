-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2024 at 10:27 AM
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
-- Database: `wdr_admin_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `agencydesignrankings`
--

CREATE TABLE `agencydesignrankings` (
  `id` int NOT NULL,
  `logo` varchar(255) NOT NULL,
  `prev` int NOT NULL,
  `organisation` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `points` int NOT NULL,
  `awards` int NOT NULL,
  `1st` int NOT NULL,
  `2nd` int NOT NULL,
  `3rd` int NOT NULL,
  `black` int NOT NULL,
  `gold` int NOT NULL,
  `silver` int NOT NULL,
  `bronze` int NOT NULL,
  `comm` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `agencydesignrankings`
--

INSERT INTO `agencydesignrankings` (`id`, `logo`, `prev`, `organisation`, `location`, `points`, `awards`, `1st`, `2nd`, `3rd`, `black`, `gold`, `silver`, `bronze`, `comm`) VALUES
(2, 'uploads/67428df8f0ed6_Kind-Logo.png', 1, 'Kind 1', 'Norway 1', 180, 40, 3, 5, 3, 3, 3, 3, 4, 2),
(3, 'uploads/67428df8f0ed6_Kind-Logo.png', 2, 'New Org', 'Bangladesh', 190, 30, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'uploads/67428df8f0ed6_Kind-Logo.png', 3, 'New One', 'India', 120, 30, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'uploads/67428df8f0ed6_Kind-Logo.png', 4, 'Digital Pixel', 'Pakistan', 200, 30, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `user_type` enum('admin','manager','user') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `user_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `created_on`, `last_login`, `user_type`, `user_active`) VALUES
(2, 'Hammad Rabadia', 'hammadrabadia@gmail.com', '$2y$10$mui.2KX/nP0GIDUC5hEVLuwcEP2fls.nWlMsUuuTn.AhTS2AfWcIy', '2024-11-23 11:22:29', '2024-11-25 14:05:18', 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agencydesignrankings`
--
ALTER TABLE `agencydesignrankings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agencydesignrankings`
--
ALTER TABLE `agencydesignrankings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
