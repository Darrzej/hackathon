-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 10:10 PM
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
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `school` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `role`, `name`, `comment`, `school`, `created_at`, `timestamp`) VALUES
(6, 2, 'admin', 'darsej kastrati', 'heyyyyy', 'xhevdetdoda', '2025-05-25 13:32:29', '2025-05-25 13:32:29'),
(7, 2, 'admin', 'darsej kastrati', 'Hey Ahmet Gashi, this is comment section!', 'ahmetgashi', '2025-05-25 13:36:42', '2025-05-25 13:36:42'),
(8, 2, 'admin', 'darsej kastrati', 'Hey Sami Frasheri, this is comment section!', 'samifrasheri', '2025-05-25 13:39:02', '2025-05-25 13:39:02'),
(9, 3, 'teacher', 'norik kastrati', 'Hey, I am teacher Norik Kastrati!', 'ahmetgashi', '2025-05-25 13:40:24', '2025-05-25 13:40:24'),
(10, 5, 'teacher', 'jon behra', 'Hey, I am teacher Jon Behra!', 'xhevdetdoda', '2025-05-25 13:41:17', '2025-05-25 13:41:17'),
(11, 2, 'admin', 'darsej kastrati', 'hey', 'xhevdetdoda', '2025-05-25 17:23:35', '2025-05-25 17:23:35');

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
  `teacher_id` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_grades`
--

INSERT INTO `student_grades` (`id`, `student_id`, `subject`, `grade`, `schedule`, `teacher_id`, `semester`) VALUES
(1, 2, 'Math', 5, '2024/2025 Semester 1', 4, NULL),
(2, 2, 'English', 4, '2024/2025 Semester 1', 4, NULL),
(3, 2, 'Albanian', 3, '2024/2025 Semester 1', 4, NULL),
(4, 2, 'History', 5, '2024/2025 Semester 1', 4, NULL),
(5, 2, 'Geography', 4, '2024/2025 Semester 1', 4, NULL),
(6, 2, 'Physics', 3, '2024/2025 Semester 1', 4, NULL),
(7, 2, 'Biology', 5, '2024/2025 Semester 1', 4, NULL),
(8, 2, 'Chemistry', 2, '2024/2025 Semester 1', 4, NULL),
(9, 2, 'PE', 5, '2024/2025 Semester 1', 4, NULL),
(10, 2, 'Art', 4, '2024/2025 Semester 1', 4, NULL),
(11, 4, 'Math', 5, NULL, 2, 3),
(12, 4, 'English', 4, NULL, 2, 3),
(13, 4, 'English', 2, NULL, 2, 1),
(14, 4, 'Math', 1, NULL, 2, 2),
(15, 4, 'English', 5, NULL, 2, 2),
(16, 4, 'Albanian', 4, NULL, 2, 3),
(17, 4, 'Geography', 2, NULL, 2, 2),
(18, 4, 'PE', 4, NULL, 12, 1),
(19, 4, 'Biology', 1, NULL, 2, 1),
(20, 4, 'History', 5, NULL, 2, 1),
(21, 10, 'Math', 4, NULL, 14, 1),
(22, 4, 'Chemistry', 5, NULL, 2, 4),
(23, 16, 'Math', 4, NULL, 2, 3),
(24, 16, 'English', 2, NULL, 2, 2),
(25, 16, 'Albanian', 5, NULL, 2, 4),
(26, 16, 'History', 4, NULL, 2, 1),
(27, 16, 'Math', 4, NULL, 2, 2),
(28, 4, 'Geography', 4, NULL, 2, 2),
(29, 16, 'Physics', 1, NULL, 2, 2),
(30, 4, 'Geography', 4, NULL, 2, 3),
(31, 16, 'Art', 5, NULL, 2, 2),
(32, 16, 'PE', 2, NULL, 2, 4),
(33, 4, 'Albanian', 2, NULL, 2, 1),
(34, 10, 'Math', 3, NULL, 2, 1),
(35, 10, 'Math', 4, NULL, 2, 2),
(36, 10, 'Math', 5, NULL, 2, 4),
(37, 10, 'Math', 2, NULL, 2, 4),
(38, 17, 'Math', 1, NULL, 2, 1),
(39, 17, 'Math', 1, NULL, 2, 2),
(40, 17, 'Math', 3, NULL, 2, 3),
(41, 17, 'Math', 5, NULL, 2, 4),
(42, 10, 'English', 4, NULL, 2, 2),
(43, 10, 'Math', 2, NULL, 2, 1),
(44, 10, 'Geography', 5, NULL, 2, 2),
(45, 10, 'Albanian', 3, NULL, 2, 1),
(46, 10, 'PE', 5, NULL, 2, 2),
(47, 10, 'Art', 3, NULL, 2, 3),
(48, 10, 'English', 5, NULL, 2, 1),
(49, 17, 'English', 5, NULL, 2, 1),
(50, 17, 'Albanian', 2, NULL, 2, 2),
(51, 10, 'History', 4, NULL, 2, 4),
(52, 10, 'Chemistry', 3, NULL, 2, 3),
(53, 10, 'Geography', 5, NULL, 2, 2),
(54, 9, 'English', 1, NULL, 2, 1),
(55, 9, 'English', 2, NULL, 2, 2),
(56, 9, 'Math', 2, NULL, 2, 3),
(57, 9, 'English', 5, NULL, 2, 4),
(58, 18, 'Albanian', 3, NULL, 2, 1),
(59, 18, 'Albanian', 5, NULL, 2, 2),
(60, 18, 'Albanian', 1, NULL, 2, 3),
(61, 18, 'Albanian', 1, NULL, 2, 4),
(62, 9, 'Biology', 3, NULL, 2, 3),
(63, 9, 'History', 2, NULL, 2, 4),
(64, 9, 'PE', 4, NULL, 2, 1),
(65, 9, 'Chemistry', 5, NULL, 2, 3),
(66, 9, 'Physics', 3, NULL, 2, 4),
(67, 9, 'Geography', 2, NULL, 2, 1),
(68, 9, 'Geography', 4, NULL, 2, 3),
(69, 9, 'Biology', 1, NULL, 2, 1),
(70, 9, 'Chemistry', 1, NULL, 2, 2),
(71, 18, 'Geography', 5, NULL, 2, 2),
(72, 18, 'Geography', 5, NULL, 2, 1),
(73, 9, 'Geography', 2, NULL, 2, 3),
(74, 18, 'Art', 1, NULL, 2, 2),
(75, 18, 'Physics', 4, NULL, 2, 4),
(76, 18, 'Physics', 3, NULL, 2, 1);

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
(2, 'darsej', 'kastrati', 'darsej@gmail.com', '$2y$10$DwuXrNQ.7YAp6nYrFKEb1uRZwyffp8G16xvHOGLfbKT3/kv9W9Ypu', '', 'admin', '', '', 'true'),
(3, 'norik', 'kastrati', 'norik@gmail.com', '$2y$10$YMzwqsxV.mgP7qnItAeJte.BIZi9km0GJGdMT0.DB/3jDmqdBda4m', '', 'ahmetgashi', 'null', 'true', 'null'),
(4, 'leon ', 'jashari', 'leon@gmail.com', '$2y$10$lBL6ZY4/8.UfzqCAB3EmAOxxPgJNtgBPojHRM0173tNyxqRpc8uLa', '', 'xhevdetdoda', 'true', 'null', 'null'),
(5, 'jon', 'behra', 'jon@gmail.com', '$2y$10$4xjsfHo0BtlX1B./QTX2C.kA7Lf.XjKEP0ZlaubHAGBc2pyUjuQtG', '', 'xhevdetdoda', 'null', 'true', 'null'),
(6, 'darsej1', 'lopa', 'seji@gmail.com', '$2y$10$51c7zhjBygAkp1z8jz4dDuRAPQyiOYpPo1JARTUFY.VSBCWciFaAy', '', 'admin', 'null', 'null', 'true'),
(7, 'fis', 'budakova', 'fis@gmail.com', '$2y$10$lT.5PaaFJEgwiqg1rxR/su73iTpr8A1u97JOIImvc5WfET8bzoNSa', '', 'samifrasheri', 'null', 'null', 'null'),
(8, 'lorik', 'ibri', 'lorik@gmail.com', '$2y$10$hPwK27OwkOx44ReBcAcjfu88yy9DZm2j1sGIRoVlsHeLq7nUjgwOe', '', 'xhevdetdoda', 'null', 'true', 'null'),
(9, 'qamil', 'mazreku', 'qamil@gmail.com', '$2y$10$8CqmNSKdJTD.EttUgL9N9Ojp5YWvoQEOWBHRW8zLUfaEpQJkDIm9O', '', 'ahmetgashi', 'true', 'null', 'null'),
(10, 'aris', 'imeri', 'aris@gmail.com', '$2y$10$3OUDj.yiJIsO5EQxRSScX.4hshaJ1773xryc05lG/2c.Sw9rFSX3a', '', 'samifrasheri', 'true', 'null', 'null'),
(11, 'orges', 'msusi', 'orges@gmail.com', '$2y$10$09PUz2zln7THMYAevY9ci.KCSCx3s2OdcaYoQ1O9tIW1hv65e7Dvm', '', 'samifrasheri', 'null', 'true', 'null'),
(12, 'dion', 'gashi', 'dion@gmail.com', '$2y$10$FYLA8Js/FFx7XZSaORMC.esLZ9K1CF.uauGY4uLTrflQnZC9PsgtS', '', 'xhevdetdoda', 'null', 'true', 'null'),
(13, 'notstudent', 'noschool', 'nothing@gmail.com', '$2y$10$NnBi1VGexwn0Hy4XgJ2O4OM0WdxN3azoc1vzaRe7/h9AYu6soKMJC', '', 'xhevdetdoda', 'null', 'null', 'null'),
(14, 'Hidherim', 'Pacolli', 'hidherim@gmail.com', '$2y$10$BstJ/rugMC0y5P7/jw6n/eldfoDKflYvAV2uX37wyLb0HwJMmrDIO', '', 'samifrasheri', 'null', 'true', 'null'),
(16, 'arta', 'hoxha', 'arta@gmail.com', '$2y$10$NtxXqueFh.BCdgOm7gs1N.o8Jf4B1wtktQo6o8G2hfdADMPWgLSRG', '', 'xhevdetdoda', 'true', '', ''),
(17, 'erina', 'krasniqi', 'erina@gmail.com', '$2y$10$ktP3.Nuq6tz0eCIoJLMHauFK8q.Ovb7C.H9xte62ueSaH55rmxWZq', '', 'samifrasheri', 'true', '', ''),
(18, 'bleona', 'rushiti', 'bleona@gmail.com', '$2y$10$tuiAdfU1kf7NaI/tJtPHC.w5c9aKjoZg6jJl2tEz0uAJp6jfJC0Xy', '', 'ahmetgashi', 'true', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `student_grades`
--
ALTER TABLE `student_grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD CONSTRAINT `student_grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
