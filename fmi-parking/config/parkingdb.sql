-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2021 at 05:09 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

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

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `license_plate` varchar(15) NOT NULL,
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `course_from` time NOT NULL,
  `course_to` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_title`, `teacher_id`, `course_day`, `course_from`, `course_to`) VALUES
(12, 'neshtaten kurs', 40, 'Friday', '07:54:00', '20:54:00'),
(13, 'neshtaten kurs 2', 40, 'Wednesday', '13:00:00', '15:00:00'),
(14, 'shtaten kurs', 41, 'Monday', '10:03:00', '12:03:00'),
(17, 'kurs1', 33, 'Monday', '20:15:00', '21:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `parking_spots`
--

CREATE TABLE `parking_spots` (
  `number` int(11) NOT NULL,
  `car` varchar(15) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `time_in` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `free` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parking_spots`
--

INSERT INTO `parking_spots` (`number`, `car`, `owner`, `time_in`, `duration`, `time_out`, `free`) VALUES
(1, NULL, 41, '2021-06-19 20:00:44', NULL, NULL, 0),
(2, NULL, NULL, NULL, NULL, NULL, 1),
(3, NULL, NULL, NULL, NULL, NULL, 1),
(4, NULL, NULL, NULL, NULL, NULL, 1),
(5, NULL, NULL, NULL, NULL, NULL, 1),
(6, NULL, NULL, NULL, NULL, NULL, 1),
(7, NULL, NULL, NULL, NULL, NULL, 1),
(8, NULL, NULL, NULL, NULL, NULL, 1),
(9, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 1),
(10, NULL, NULL, NULL, NULL, NULL, 1),
(11, NULL, NULL, NULL, NULL, NULL, 1),
(12, NULL, NULL, NULL, NULL, NULL, 1),
(13, NULL, NULL, NULL, NULL, NULL, 1),
(14, NULL, NULL, NULL, NULL, NULL, 1),
(15, NULL, NULL, NULL, NULL, NULL, 1),
(16, NULL, NULL, NULL, NULL, NULL, 1),
(17, NULL, NULL, NULL, NULL, NULL, 1),
(18, NULL, NULL, NULL, NULL, NULL, 1),
(19, NULL, NULL, NULL, NULL, NULL, 1),
(20, NULL, NULL, NULL, NULL, NULL, 1),
(21, NULL, NULL, NULL, NULL, NULL, 1),
(22, NULL, NULL, NULL, NULL, NULL, 1),
(23, NULL, NULL, NULL, NULL, NULL, 1),
(24, NULL, NULL, NULL, NULL, NULL, 1),
(25, NULL, NULL, NULL, NULL, NULL, 1),
(26, NULL, NULL, NULL, NULL, NULL, 1),
(27, NULL, NULL, NULL, NULL, NULL, 1),
(28, NULL, NULL, NULL, NULL, NULL, 1),
(29, NULL, NULL, NULL, NULL, NULL, 1),
(30, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_first` varchar(255) NOT NULL,
  `u_last` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_role` enum('admin','permanent','temporary','blocked') NOT NULL DEFAULT 'blocked',
  `u_id` int(11) NOT NULL,
  `car` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_first`, `u_last`, `u_email`, `u_password`, `u_role`, `u_id`, `car`) VALUES
('Bella', 'Sabeva', 'bellasabewa98@abv.bg', '$2y$10$oO.WuSUg1tb.XYNfBRCZDuAYocd5w15NYwAocniXQsXOeim9nDx.C', 'admin', 33, NULL),
('neshtaten', 'neshtatenov', 'neshtaten@abv.bg', '$2y$10$.4PcJB9tybQaRm5FEMZAaO5WM2xpK5tVYUeFJKt8HZNaJ4oL3vS7e', 'temporary', 40, NULL),
('shtaten', 'shtatenov', 'shtaten@abv.bg', '$2y$10$ZF0p7vp9Qzuh/Pos6grWE.UV.8.2pqnCDpsGFflOgE8JKhMINtuxK', 'permanent', 41, NULL),
(' Dobromir', 'Kolev', 'dobromirkolev@abv.bg', '5550525', 'admin', 43, NULL),
('banned', 'bannedov', 'bannat@abv.bg', '$2y$10$Oo8lmbRMJ5w.eIrl1d6QvOorBtYrCmUvPgQ1BDyklk7O7EVtv0aa6', 'blocked', 44, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`license_plate`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `fk_courses_teachers` (`teacher_id`);

--
-- Indexes for table `parking_spots`
--
ALTER TABLE `parking_spots`
  ADD PRIMARY KEY (`number`),
  ADD KEY `car` (`car`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_email` (`u_email`),
  ADD KEY `car` (`car`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_courses_teachers` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `parking_spots`
--
ALTER TABLE `parking_spots`
  ADD CONSTRAINT `parking_spots_ibfk_1` FOREIGN KEY (`car`) REFERENCES `cars` (`license_plate`),
  ADD CONSTRAINT `parking_spots_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`car`) REFERENCES `cars` (`license_plate`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
