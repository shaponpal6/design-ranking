-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 28, 2024 at 07:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `prev` int(11) NOT NULL,
  `organisation` varchar(255) NOT NULL,
  `organisation_url` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `points` int(11) NOT NULL,
  `awards` int(11) NOT NULL,
  `1st` int(11) NOT NULL,
  `2nd` int(11) NOT NULL,
  `3rd` int(11) NOT NULL,
  `black` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `silver` int(11) NOT NULL,
  `bronze` int(11) NOT NULL,
  `comm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agencydesignrankings`
--

INSERT INTO `agencydesignrankings` (`id`, `logo`, `prev`, `organisation`, `organisation_url`, `location`, `points`, `awards`, `1st`, `2nd`, `3rd`, `black`, `gold`, `silver`, `bronze`, `comm`) VALUES
(6, 'uploads/zan-lazarevic-yBEUD8SWABc-unsplash.jpg', 3, 'http://localhost/wdr/agencydesignrankings', '', 'Dhaka', 167, 104, 1, 2, 3, 4, 5, 5, 6, 78),
(8, '', 1, 'test', 'http://localhost/wdr/agencydesignrankings?', 'Dhaka', 7201, 3698, 0, 23, 2, 0, 0, 0, 3430, 243),
(10, '', 2, 'rf', 'http://localhost/wdr/agencydesignrankings?', 'Dhaka', 288, 60, 54, 0, 6, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `user_type` enum('admin','manager','user') DEFAULT 'user',
  `user_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `created_on`, `last_login`, `user_type`, `user_active`) VALUES
(2, 'Hammad Rabadia', 'sp@gmail.com', '$2y$10$Rf2A4gpmHDMUAtvmCmeCSeBX1LoD8LUyTs6gJavAZTittywAtmwnq', '2024-11-23 11:22:29', '2024-11-27 22:18:25', 'admin', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
