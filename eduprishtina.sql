-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 04:36 PM
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
-- Database: `eduprishtina`
--

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `grade` int(11) NOT NULL CHECK (`grade` between 1 and 5),
  `school` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_grades`
--

CREATE TABLE `student_grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `grade` int(11) DEFAULT NULL CHECK (`grade` between 1 and 5),
  `schedule` text DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_grades`
--

INSERT INTO `student_grades` (`id`, `student_id`, `subject`, `grade`, `schedule`, `teacher_id`) VALUES
(1, 2, 'Math', 5, '2024/2025 Semester 1', 4),
(2, 2, 'English', 4, '2024/2025 Semester 1', 4),
(3, 2, 'Albanian', 3, '2024/2025 Semester 1', 4),
(4, 2, 'History', 5, '2024/2025 Semester 1', 4),
(5, 2, 'Geography', 4, '2024/2025 Semester 1', 4),
(6, 2, 'Physics', 3, '2024/2025 Semester 1', 4),
(7, 2, 'Biology', 5, '2024/2025 Semester 1', 4),
(8, 2, 'Chemistry', 2, '2024/2025 Semester 1', 4),
(9, 2, 'PE', 5, '2024/2025 Semester 1', 4),
(10, 2, 'Art', 4, '2024/2025 Semester 1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confrim_password` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `isstudent` varchar(255) NOT NULL,
  `isteacher` varchar(255) NOT NULL,
  `isadmin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `confrim_password`, `school`, `isstudent`, `isteacher`, `isadmin`) VALUES
(2, 'darsej', 'kastrati', 'darsej@gmail.com', '$2y$10$DwuXrNQ.7YAp6nYrFKEb1uRZwyffp8G16xvHOGLfbKT3/kv9W9Ypu', '', 'xhevdetdoda', '', '', 'true'),
(3, 'norik', 'kastrati', 'norik@gmail.com', '$2y$10$YMzwqsxV.mgP7qnItAeJte.BIZi9km0GJGdMT0.DB/3jDmqdBda4m', '', 'ahmetgashi', '', 'true', ''),
(4, 'leon ', 'jashari', 'leon@gmail.com', '$2y$10$lBL6ZY4/8.UfzqCAB3EmAOxxPgJNtgBPojHRM0173tNyxqRpc8uLa', '', 'xhevdetdoda', 'true', '', ''),
(5, 'jon', 'behra', 'jon@gmail.com', '$2y$10$4xjsfHo0BtlX1B./QTX2C.kA7Lf.XjKEP0ZlaubHAGBc2pyUjuQtG', '', 'xhevdetdoda', '', 'true', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_grades`
--
ALTER TABLE `student_grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`ID`);

--
-- Constraints for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD CONSTRAINT `student_grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
