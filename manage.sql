-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2025 at 04:09 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manage`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `canceled`
--

CREATE TABLE `canceled` (
  `reservation_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `room_id` int(11) NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `guest` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `canceled`
--

INSERT INTO `canceled` (`reservation_id`, `username`, `room_id`, `checkin`, `checkout`, `total`, `duration`, `guest`) VALUES
(2, 'tahura_alam', 1011, '2025-01-07', '2025-01-10', 200.00, 4, 1),
(4, 'tahura_alam', 1013, '2025-01-10', '2025-01-11', 30.00, 1, 1),
(11, 'tahura_alam', 1013, '2025-01-24', '2025-01-27', 90.00, 3, 1),
(19, 'nab12', 1012, '2025-01-30', '2025-01-31', 100.00, 1, 2),
(20, 'nab12', 1011, '2025-01-06', '2025-01-07', 50.00, 1, 1),
(21, 'nab12', 1011, '2025-01-06', '2025-01-07', 50.00, 1, 1),
(23, 'tahura_alam', 1011, '2025-03-12', '2025-03-13', 50.00, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `date`, `location`, `description`) VALUES
(1, 'Annual Conferences', '2025-02-15', 'Hotel Grand Ballroom', 'A yearly conference bringing together industry experts to discuss upcoming trends and innovations.'),
(2, 'Gala night ', '2025-01-07', 'Grand hall ', 'approx 200 students');

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `username` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `password` varchar(4) NOT NULL,
  `Gpay` int(11) NOT NULL,
  `Gpay_balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`username`, `fname`, `lname`, `city`, `password`, `Gpay`, `Gpay_balance`) VALUES
('Asfi', 'asfi', 'alam', ' dhaka', '1234', 1811523292, 10000.00),
('darok', 'Daraksha', 'Alam', 'Dhaka', '1234', 1911523292, 10000.00),
('lams', 'lamia', 'akhter', 'khulna', '2345', 1711523292, 2600.00),
('nab12', 'Nabiha', 'alam', 'Dhaka', '1234', 1711523292, 150.98),
('safa', 'Safa', 'alam', 'dhaka', '1234', 1788, 10000.00),
('tahura_alam', 'TAHURA', 'Alam', 'dubai', ' 123', 1711523292, 744.00);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `guest` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `room_id`, `username`, `checkin`, `checkout`, `total`, `duration`, `guest`) VALUES
(3, 1013, 'tahura_alam', '2025-01-04', '2025-01-05', 30.00, 1, 1),
(6, 1015, 'tahura_alam', '2025-01-04', '2025-01-05', 100.00, 1, 1),
(10, 1011, 'tahura_alam', '2025-01-24', '2025-01-27', 150.00, 3, 1),
(13, 1011, 'lams', '2025-01-29', '2025-01-31', 100.00, 2, 1),
(14, 1012, 'lams', '2025-01-04', '2025-01-05', 100.00, 1, 2),
(15, 1014, 'lams', '2025-01-04', '2025-01-31', 2700.00, 27, 2),
(16, 1016, 'lams', '2025-01-04', '2025-01-08', 280.00, 4, 2),
(17, 1017, 'nab12', '2025-01-04', '2025-01-31', 1890.00, 27, 1),
(18, 1018, 'nab12', '2025-01-04', '2025-01-31', 1350.00, 27, 2),
(22, 1011, 'tahura_alam', '2025-02-07', '2025-02-14', 350.00, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `floor` int(11) NOT NULL,
  `guest` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `floor`, `guest`, `type`, `price`) VALUES
(1011, 1, 1, 'superior room', 50.00),
(1012, 1, 2, 'special room', 100.00),
(1013, 3, 1, 'special room', 30.00),
(1014, 3, 2, 'sea view', 100.00),
(1015, 3, 1, 'sea view', 100.00),
(1016, 3, 2, 'city view', 70.00),
(1017, 3, 1, 'city view', 70.00),
(1018, 4, 2, 'superior room', 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `task` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `role`, `email`, `phone`, `task`) VALUES
(2, 'amina', 'waiter', 'yarasagosine@outlook.com', '01686303795', 'serve table 103'),
(4, 'jahanara', 'Manager', 'yarasagosindkhkh@outlook.com', '01686303756', 'manage the guests '),
(5, 'Golam sun', 'dancer', 'sun@gmail.com', '01635058933', 'dance before table 03'),
(6, 'lam', 'cleaner', 'yarasagosindkhkh@outlook.com', '01686303755', 'clean toilet 504'),
(8, 'sadia987', 'waiter', 'yarasagosindkhkh@outlook.com', '01686303799', 'serve 401 table'),
(9, 'sadia987', 'waiter', 'yarasagosindkhkh@outlook.com', '01686303755', 'serve table 104'),
(10, 'sanila', 'pol dancer', 'yarasagosine@outlook.com', '01686303755', 'serve table 09'),
(11, 'sanila', 'waiter', 'afrinsanjida765@gmail.com', '01686303752', 'serve table 06'),
(12, 'nabiha', 'writer', 'essiahgnany@hotmail.com', '01686303754', 'write a novel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `canceled`
--
ALTER TABLE `canceled`
  ADD PRIMARY KEY (`reservation_id`),
  ADD UNIQUE KEY `reservation_id` (`reservation_id`),
  ADD KEY `fk_canceled_username` (`username`),
  ADD KEY `fk_canceled_room_id` (`room_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD UNIQUE KEY `reservation_id` (`reservation_id`),
  ADD KEY `fk_reservation_username` (`username`),
  ADD KEY `fk_reservation_room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_id` (`room_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `canceled`
--
ALTER TABLE `canceled`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1019;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `canceled`
--
ALTER TABLE `canceled`
  ADD CONSTRAINT `fk_canceled_room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_canceled_username` FOREIGN KEY (`username`) REFERENCES `guest` (`username`) ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservation_username` FOREIGN KEY (`username`) REFERENCES `guest` (`username`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
