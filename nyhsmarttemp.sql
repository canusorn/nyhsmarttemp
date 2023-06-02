-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2023 at 05:20 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nyhsmarttemp`
--

-- --------------------------------------------------------

--
-- Table structure for table `custom_page`
--

CREATE TABLE `custom_page` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `page` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `esp_id`
--

CREATE TABLE `esp_id` (
  `esp_id` int(11) NOT NULL,
  `device_name` varchar(30) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `project_id` varchar(20) DEFAULT NULL,
  `version` int(10) UNSIGNED DEFAULT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `need_ota` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-no need update\r\n1-need update\r\n2-wait for result\r\n3-fail',
  `time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `esp_id`
--

INSERT INTO `esp_id` (`esp_id`, `device_name`, `user_id`, `project_id`, `version`, `lastupdate`, `need_ota`, `time`) VALUES
(123456, 'DHT-123456', 1, '4', 10, '2023-06-01 16:31:22', 0, '2023-06-01 16:31:19'),
(910099, 'DHT-910099', 1, '3', 10, '2023-06-01 20:32:50', 0, '2023-06-01 14:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_id`
--

CREATE TABLE `project_id` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_id`
--

INSERT INTO `project_id` (`project_id`, `project_name`) VALUES
(0, 'CUSTOM'),
(4, 'DHT');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `position` varchar(30) DEFAULT NULL,
  `regisdatetime` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `pass`, `position`, `regisdatetime`) VALUES
(1, 'charineeprimcrn@gmail.com', '$2y$10$rxG6B4ZphrEIhs/uW04yB.mQsMyIxK0DDlJPGrxziwu/9U/C8r9vG', NULL, '2022-10-06 07:37:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `custom_page`
--
ALTER TABLE `custom_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `esp_id`
--
ALTER TABLE `esp_id`
  ADD PRIMARY KEY (`esp_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_id`
--
ALTER TABLE `project_id`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `custom_page`
--
ALTER TABLE `custom_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `project_id`
--
ALTER TABLE `project_id`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custom_page`
--
ALTER TABLE `custom_page`
  ADD CONSTRAINT `custom_page_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `esp_id`
--
ALTER TABLE `esp_id`
  ADD CONSTRAINT `esp_id_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
