-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 10:29 AM
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
-- Database: `devil`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `isbn` varchar(20) CHARACTER SET utf8mb4  NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4  NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `cover_image` varchar(225) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `available_copies` int DEFAULT NULL,
  `copies` int NOT NULL DEFAULT '1',
  `shelf_code` varchar(50) CHARACTER SET utf8mb4  DEFAULT NULL,
  `status` enum('Available','Lended','Damaged') NOT NULL DEFAULT 'Available',
  `total_pages` int DEFAULT NULL,
  `features` text CHARACTER SET utf8mb4,
  `volume` text CHARACTER SET utf8mb4,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publisher_name` text,
  `published_date` date DEFAULT NULL,
  `moral` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `isbn`, `title`, `author`, `cover_image`, `category`, `language`, `available_copies`, `copies`, `shelf_code`, `status`, `total_pages`, `features`, `volume`, `created_date`, `publisher_name`, `published_date`, `moral`) VALUES
(2, 'LMS-B0-01', 'The Great Gatsby', 'F. Scott Fitzgerald', 'Great.jpeg', 'Fiction', 'English', 10, 10, '', 'Available', 0, '', '', '2025-04-18 11:53:44', '', '1970-01-01', ''),
(5, 'LMS-B0-03', 'The Silent Library', 'John Doe', 'SilentLibrary.jpeg', 'Mystery', 'English', 5, 5, 'A1', 'Available', 320, 'Illustrated; Hardcover', 'Volume 1', '2025-04-22 15:18:27', '1', '2014-05-01', 'Knowledge is power.'),
(7, 'LMS-B0-05', 'Legends of Light', 'Akira Tanaka', 'LegendsOfLight.jpeg', 'Fantasy', 'Japanese', 6, 7, 'C3', 'Damaged', 290, 'Deluxe edition; Colored Maps', 'Volume 3', '2025-04-22 15:18:27', '3', '2020-12-01', 'Hope shines brightest in darkness.'),
(8, 'LMS-B0-06', 'The Lost Island', 'Emily Rose', 'LostIsland.jpeg', 'Adventure', 'English', 6, 6, 'D1', 'Available', 350, '', '', '2025-04-22 15:26:39', '', '1970-01-01', ''),
(9, 'LMS-B0-07', 'Digital Fortress', NULL, NULL, 'Tech Thriller', 'English', 5, 5, 'D2', 'Available', 400, NULL, 'Vol. 1', '2025-04-22 15:26:39', '2', '2023-01-15', NULL),
(10, 'LMS-B0-08', 'The Art of Zen', 'Takeshi Mori', NULL, 'Philosophy', 'Japanese', 3, 3, 'D3', 'Available', 220, 'Minimalist', '', '2025-04-22 15:26:39', '', '1970-01-01', 'Inner peace matters.');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_records`
--

CREATE TABLE `borrow_records` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('borrowed','returned','overdue') CHARACTER SET utf8mb4 DEFAULT 'overdue'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrow_records`
--

INSERT INTO `borrow_records` (`id`, `user_id`, `book_id`, `borrow_date`, `due_date`, `return_date`, `status`) VALUES
(1, 2, 2, '2025-04-01', NULL, '2025-04-28', 'returned'),
(3, 6, 2, '2025-04-28', '2025-05-13', '2025-04-28', 'returned'),
(5, 7, 7, '2025-04-29', '2025-05-14', NULL, 'borrowed'),
(6, 3, 7, '2025-04-29', '2025-05-14', '2025-04-30', 'returned'),
(7, 3, 8, '2025-04-30', '2025-05-15', '2025-04-30', 'returned');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `activity` text,
  `activity_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'borrow_days', '14'),
(2, 'fine_per_day', '10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `user_nameId` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `phone` text CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `profile_photo` text CHARACTER SET utf8mb4,
  `fine` decimal(10,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_nameId`, `name`, `phone`, `email`, `password`, `role`, `profile_photo`, `fine`, `created_at`) VALUES
(1, 'lib-admin', 'Admin', '9999999999', 'admin@lms.com', '$2y$10$SxXwCDkJ2NuEt6XGFeECsuPEPaBsv0WCVhh0layLdu9Ku6DRunxwq', 'admin', 'assets/uploads/profile_photos/1745956550_admin.jpeg', 0.00, '2025-04-16 20:26:20'),
(2, 'Lion-2', 'Lion King', '1234567890', 'lion@king.com', '$2y$10$GyXbauWyqv0Dg741PK8ufudf5Pq.vZkRI63Ai8d1hEiXa3JDdexWu', 'user', '', 0.00, '2025-04-16 20:30:43'),
(3, 'hero-3', 'Hero Sama', '08097989507', 'sama@hero.com', '$2y$10$Rgk5CQUmTse.sbpS37TCQ.oj511dz4euthhBe9pRlZR1lZjUdjhV.', 'user', '', 0.00, '2025-04-16 21:06:10'),
(5, '', 'Deeapk', '1234567890', 'd@l.com', '$2y$10$2l8RFmLfYg9klTQdY.WAheFeYXNjOGn39Fzhv9UUbaqmDD7qFtCUK', 'user', '', 0.00, '2025-04-19 06:34:44'),
(6, 'new-6', 'new user', '1234567890', 'new@user.com', '$2y$10$s7gtxvIyC1UxjUwYzBDJAuYygD./JQoz4bDvZ56pXN6Ogb245Zr4C', 'user', '', 0.00, '2025-04-19 08:07:22'),
(7, 'vinay-7', 'vinay vishwakarma', '0987654321', 'vi@v.com', '$2y$10$zx3fJQ/bHPajnugAQ01du.RdYdRdQTPqStC1NoR0M68ZIRx7uFgvS', 'user', NULL, 0.00, '2025-04-24 12:25:36'),
(8, 'bude-8', 'bude', '1234567890', 'bude@lms.com', '$2y$10$u9VbIFT3d8U3QLV1r0kyn.2FtedskCpwcKM.P0lHojOYHMJwBeLW.', 'user', NULL, 0.00, '2025-04-28 18:35:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indexes for table `borrow_records`
--
ALTER TABLE `borrow_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user_nameId` (`user_nameId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `borrow_records`
--
ALTER TABLE `borrow_records`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_records`
--
ALTER TABLE `borrow_records`
  ADD CONSTRAINT `borrow_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrow_records_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;