-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2023 at 07:11 PM
-- Server version: 10.4.24-MariaDB 
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vj`
--

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `property_id` varchar(100) DEFAULT NULL,
  `property_owner` varchar(100) DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT 'Pending',
  `payment_date` datetime DEFAULT NULL,
  `username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `property_id`, `property_owner`, `payment_amount`, `payment_method`, `payment_status`, `payment_date`, `username`) VALUES
(5, '64', 'vijay', '45.00', 'online', 'Cancelled', '2023-07-17 18:43:33', ''),
(6, '64', 'vijay', '77.00', 'online', 'Paid', '2023-07-17 18:50:11', ''),
(7, '64', 'vijay', '77.00', 'online', 'Cancelled', '2023-07-17 18:54:50', ''),
(8, '34', 'vijay', '300.00', 'online', 'Paid', '2023-07-17 20:49:43', ''),
(9, '34', 'vijay', '300.00', 'in_person', 'Paid', '2023-07-17 20:50:29', ''),
(10, '64', 'vijay', '34.00', 'mail_in', 'Paid', '2023-07-17 21:18:56', ''),
(11, '69', 'vijay', '555.00', 'online', 'Pending', '2023-07-17 22:24:11', ''),
(12, '64', 'uday', '66.00', 'online', 'Paid', '2023-07-17 22:27:28', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
