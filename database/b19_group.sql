-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2021 at 05:30 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore_php_teaching`
--

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_acp` tinyint(1) DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `ordering` int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `group_acp`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`) VALUES
(1, 'Admin', 1, '2013-11-11 00:00:00', 'admin', NULL, NULL, 'active', 5),
(2, 'Manager', 1, '2013-11-07 00:00:00', 'admin', '2020-09-05 06:06:03', 'admin', 'active', 4),
(3, 'Member', 0, '2020-09-07 04:41:34', 'admin', '2020-09-07 11:00:57', 'admin', 'active', 10),
(4, 'Register', 0, '2020-09-07 04:41:57', 'admin', '2020-10-30 21:21:41', 'admin', 'inactive', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
