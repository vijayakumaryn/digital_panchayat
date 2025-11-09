-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2023 at 04:06 PM
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
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `complaint` text NOT NULL,
  `admin_status` varchar(50) DEFAULT 'Pending',
  `updated_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `username`, `complaint`, `admin_status`, `updated_by`, `updated_at`, `created_at`) VALUES
(30, 'ajay', 'b', 'Resolved', NULL, '2023-07-05 13:42:39', '2023-07-04 13:22:04'),
(57, 'vijay', 'uu', 'Resolved', NULL, '2023-07-05 13:36:13', '2023-07-05 05:22:13'),
(58, 'uday', 'dd', 'Resolved', NULL, '2023-07-06 04:35:20', '2023-07-05 05:31:47'),
(59, 'vijay', 'a', 'Pending', NULL, '2023-07-05 13:50:01', '2023-07-05 13:50:01'),
(62, 'vijay', 'my adhar not taking', 'In Progress', NULL, '2023-07-06 04:42:16', '2023-07-06 04:41:05'),
(63, 'vijay', 'a', 'Pending', NULL, '2023-07-06 04:43:00', '2023-07-06 04:43:00'),
(64, 'vijay', 'b', 'Pending', NULL, '2023-07-06 05:45:10', '2023-07-06 05:45:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
