-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2026 at 03:55 AM
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
-- Database: `parkingdb`
--
CREATE DATABASE IF NOT EXISTS `parkingdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `parkingdb`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acc_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `acc_type` enum('EMPLOYEE','ADMIN') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acc_id`, `name`, `email`, `password`, `acc_type`) VALUES
(1, 'Marc Iris Sepnio', 'marc@gmail.com', 'p!%mPa99!S2B2Fn', 'ADMIN'),
(2, 'Adrian Jose', 'adrian@gmail.com', '^Vxp3PDP8ZD&*bU', 'EMPLOYEE');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `license_plate` varchar(6) NOT NULL,
  `vehicle_name` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `driver_license` varchar(255) NOT NULL,
  `registration` varchar(255) NOT NULL,
  `entry_time` datetime NOT NULL,
  `exit_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE `parking` (
  `spot_id` int(255) NOT NULL,
  `spot_name` varchar(255) NOT NULL,
  `status` enum('OPEN','TAKEN') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`spot_id`, `spot_name`, `status`) VALUES
(1, 'A1', 'OPEN'),
(2, 'A2', 'OPEN'),
(3, 'A3', 'OPEN'),
(4, 'A4', 'OPEN'),
(5, 'A5', 'OPEN'),
(6, 'B1', 'OPEN'),
(7, 'B2', 'OPEN'),
(8, 'B3', 'OPEN'),
(9, 'B4', 'OPEN'),
(10, 'B5', 'OPEN'),
(11, 'C1', 'OPEN'),
(12, 'C2', 'OPEN'),
(13, 'C3', 'OPEN'),
(14, 'C4', 'OPEN'),
(15, 'C5', 'OPEN'),
(16, 'D1', 'OPEN'),
(17, 'D2', 'OPEN'),
(18, 'D3', 'OPEN'),
(19, 'D4', 'OPEN'),
(20, 'D5', 'OPEN'),
(21, 'E1', 'OPEN'),
(22, 'E2', 'OPEN'),
(23, 'E3', 'OPEN'),
(24, 'E4', 'OPEN'),
(25, 'E5', 'OPEN');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `license_plate` varchar(6) NOT NULL,
  `vehicle_name` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `driver_license` varchar(255) NOT NULL,
  `registration` varchar(255) NOT NULL,
  `current_spot` varchar(3) NOT NULL,
  `entry_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`license_plate`);

--
-- Indexes for table `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`spot_id`),
  ADD UNIQUE KEY `spot_name` (`spot_name`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`license_plate`),
  ADD UNIQUE KEY `current_spot` (`current_spot`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `acc_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `parking`
--
ALTER TABLE `parking`
  MODIFY `spot_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
