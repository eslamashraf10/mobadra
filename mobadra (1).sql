-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2025 at 10:07 PM
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
-- Database: `mobadra`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_message`
--

CREATE TABLE `admin_message` (
  `id` int(10) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `department` varchar(100) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_message`
--

INSERT INTO `admin_message` (`id`, `username`, `email`, `department`, `message`) VALUES
(2, 'ahmed', 'name@jsdvh.com', 'IT', 'Operations'),
(3, 'yasser', 'asjdbk@jxvb.com', 'Finance', 'Finance'),
(4, 'khaled', 'kdfnoibd@kjcvbsjk.com', 'IT', ' '),
(5, 'jfnbklkfba', 'sdjbfsaj@kjdsvbajk.com', 'IT', 'dkjasnlkDNK ,abnkjadf,');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `ticket_id`, `user_id`, `text`, `created_at`) VALUES
(3, 4, 4, 'do this thing', '2025-11-25 05:25:38'),
(4, 2, 10, 'kjdnfablk', '2025-11-25 05:27:25'),
(5, 5, 13, '', '2025-11-25 05:27:53'),
(6, 8, 4, 'play hard', '2025-11-25 05:31:53'),
(7, 6, 4, 'gogo play', '2025-11-25 05:38:03'),
(8, 8, 4, 'lkfmd;lbl;adfb', '2025-11-25 05:39:24'),
(9, 4, 4, 'gg', '2025-11-25 05:45:37'),
(10, 12, 11, 'hhhhhhhh', '2025-11-26 16:56:18'),
(11, 14, 11, 'ssssssss', '2025-11-27 14:25:57'),
(12, 19, 11, 'solv', '2025-11-27 14:26:17'),
(13, 16, 7, 'QAW', '2025-11-28 12:09:21');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
(1, 'IT Department'),
(2, 'HR Department'),
(3, 'Finance Department'),
(4, 'Marketing Department'),
(5, 'Sales Department'),
(6, 'Software Engineering Department'),
(7, 'Design Department'),
(8, 'administration department');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `satisfied` enum('0','1') DEFAULT '0',
  `from_user` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `ticket_id`, `user_id`, `satisfied`, `from_user`, `created_at`) VALUES
(1, 2, 10, '1', 4, '2025-11-26 16:25:28'),
(2, 12, 4, '1', 11, '2025-11-26 17:42:35'),
(3, 14, 4, '1', 11, '2025-11-27 14:27:00'),
(4, 16, 4, '1', 7, '2025-11-28 13:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `replay`
--

CREATE TABLE `replay` (
  `id` int(10) NOT NULL,
  `sender` int(10) NOT NULL,
  `reciever` int(10) NOT NULL,
  `ticket_id` int(10) NOT NULL,
  `text` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replay`
--

INSERT INTO `replay` (`id`, `sender`, `reciever`, `ticket_id`, `text`, `created_at`) VALUES
(1, 10, 4, 2, 'good', '2025-11-26 16:17:03'),
(2, 10, 4, 2, 'good', '2025-11-26 16:25:14'),
(3, 4, 11, 12, 'gggggggg', '2025-11-26 16:57:17'),
(4, 11, 4, 12, 'pppppp', '2025-11-26 17:06:40'),
(5, 11, 4, 12, 'ksnvklds', '2025-11-26 17:07:34'),
(6, 4, 11, 12, 'llllll', '2025-11-26 17:25:45'),
(7, 4, 11, 12, 'hi', '2025-11-26 17:32:09'),
(8, 4, 10, 2, 'oooooooo', '2025-11-26 20:44:57'),
(9, 4, 11, 12, 'good luck', '2025-11-27 14:29:45');

-- --------------------------------------------------------

--
-- Table structure for table `ticketattachments`
--

CREATE TABLE `ticketattachments` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticketattachments`
--

INSERT INTO `ticketattachments` (`id`, `ticket_id`, `user_id`, `filename`, `file_path`, `uploaded_at`) VALUES
(3, 19, 4, 'file_1.jpg', 'uploads/file_1.jpg', '2025-11-27 10:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc` text DEFAULT NULL,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `user_id` int(11) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Resolved','In Progress','canceled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `desc`, `priority`, `user_id`, `dept_id`, `status`, `created_at`) VALUES
(1, 'hj kbb', 'kjbjklkl', 'high', 4, 1, 'canceled', '2025-11-21 09:20:21'),
(2, 'breaking on 1', 'reoituyrokcxbkjcxnzbk kjcxnvbkcxnv kjcdnkvz', 'medium', 4, 4, 'Resolved', '2025-11-22 09:06:53'),
(3, 'breaking on 2', 'reoituyrokcxbkjcxnzbk kjcxnvbkcxnv kjcdnkvz', 'medium', 4, 2, 'Resolved', '2025-11-22 09:08:52'),
(4, 'breaking on 6', 'reoituyrokcxbkjcxnzbk kjcxnvbkcxnv kjcdnkvz', 'medium', 5, 5, 'In Progress', '2025-11-22 09:08:52'),
(5, 'breaking on 14', 'reoituyrokcxbkjcxnzbk kjcxnvbkcxnv kjcdnkvz', 'medium', 4, 1, 'Resolved', '2025-11-22 09:08:52'),
(6, 'breaking on 12', 'reoituyrokcxbkjcxnzbk kjcxnvbkcxnv kjcdnkvz', 'medium', 7, 2, 'In Progress', '2025-11-22 09:08:52'),
(7, 'breaking on 10', 'reoituyrokcxbkjcxnzbk kjcxnvbkcxnv kjcdnkvz', 'medium', 9, 4, 'Pending', '2025-11-22 09:08:52'),
(8, 'breaking on 15', 'reoituyrokcxbkjcxnzbk kjcxnvbkcxnv kjcdnkvz', 'medium', 13, 3, 'In Progress', '2025-11-22 09:08:52'),
(9, 'eror', 'poieruthvnkx', 'high', 4, 5, 'canceled', '2025-11-22 12:35:35'),
(10, 'breaking on 100', 'iadfbnlafl;fd', 'low', 4, 1, 'canceled', '2025-11-25 05:29:44'),
(11, 'lfdl;dbf', '.fambcba,;l', 'low', 4, 1, 'canceled', '2025-11-25 10:39:43'),
(12, 'aaa not working', 'asd djjd jdsni jxbxcnasd', 'medium', 4, 1, 'Resolved', '2025-11-26 16:52:15'),
(13, 'hard working', 'mnbifdbn', 'high', 4, 1, 'Pending', '2025-11-26 17:51:34'),
(14, 'ineed help', 'i can\'t do this thing so ineed help', 'medium', 4, 6, 'Resolved', '2025-11-27 10:07:17'),
(15, 'wekmfop', 'vrqekmboieroibmorqeinujmodsvqoigr', 'low', 4, 1, 'Pending', '2025-11-27 10:09:20'),
(16, 'lkmnonbsi', 'fjiegnrgwiohnonwiolnblowgrbljr', 'medium', 4, 1, 'Resolved', '2025-11-27 10:11:16'),
(17, 'مسرنبى نمسيمنلاىةي', 'شيمبنىلانةمشيبلا', 'low', 4, 1, 'Resolved', '2025-11-27 10:39:26'),
(18, 'fdblkndafb', 'akdfnbkadfbl', 'low', 4, 1, 'Pending', '2025-11-27 10:41:18'),
(19, 'klnsdv', 'ppppppp', 'low', 4, 1, 'In Progress', '2025-11-27 10:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `dept_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `password`, `role`, `dept_id`) VALUES
(3, 'aly aly', 'admin1@example.com', '85946924', '1234', 'admin', 8),
(4, 'eslam fayed', 'user1@gmail.com', '872459', '1234', 'user', 1),
(5, 'khaled', 'user2@gmail.com', '65116516165', '1234', 'user', 3),
(7, 'karim', 'user3@gmail.com', '65116516165', '1234', 'user', 3),
(8, 'zaid', 'user4@gmail.com', '65116516165', '1234', 'user', 2),
(9, 'aya', 'user5@gmail.com', '65116516165', '1234', 'user', 4),
(10, 'ahmed', 'user6@gmail.com', '65116516165', '1234', 'user', 1),
(11, 'mazen', 'user7@gmail.com', '65116516165', '1234', 'user', 3),
(12, 'radwa', 'user8@gmail.com', '65116516165', '1234', 'user', 2),
(13, 'anas AAA', 'user9@gmail.com', '65116516165', '1234', 'user', 5),
(14, 'ali', 'user10@gmail.com', '65116516165', '1234', 'user', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_message`
--
ALTER TABLE `admin_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_ibfk_1` (`ticket_id`),
  ADD KEY `comments_ibfk_2` (`user_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_ibfk_1` (`ticket_id`),
  ADD KEY `feedback_ibfk_2` (`user_id`),
  ADD KEY `fromuser_fk` (`from_user`);

--
-- Indexes for table `replay`
--
ALTER TABLE `replay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_ibfk_100` (`sender`),
  ADD KEY `reciever_ibfk_100` (`reciever`),
  ADD KEY `ticket_id_ibfk_3` (`ticket_id`);

--
-- Indexes for table `ticketattachments`
--
ALTER TABLE `ticketattachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticketattachments_ibfk_1` (`ticket_id`),
  ADD KEY `ticketattachments_ibfk_2` (`user_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_ibfk_1` (`user_id`),
  ADD KEY `tickets_ibfk_2` (`dept_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_ibfk_1` (`dept_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_message`
--
ALTER TABLE `admin_message`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `replay`
--
ALTER TABLE `replay`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ticketattachments`
--
ALTER TABLE `ticketattachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fromuser_fk` FOREIGN KEY (`from_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `replay`
--
ALTER TABLE `replay`
  ADD CONSTRAINT `reciever_ibfk_100` FOREIGN KEY (`reciever`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sender_ibfk_100` FOREIGN KEY (`sender`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_id_ibfk_3` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticketattachments`
--
ALTER TABLE `ticketattachments`
  ADD CONSTRAINT `ticketattachments_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticketattachments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
