-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 24, 2024 at 01:40 AM
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
-- Indexes for dumped tables
--

--
-- Indexes for table `agencydesignrankings`
--
ALTER TABLE `agencydesignrankings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agencydesignrankings`
--
ALTER TABLE `agencydesignrankings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
