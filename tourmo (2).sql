-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 18, 2022 at 10:31 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tourmo`
--

-- --------------------------------------------------------

--
-- Table structure for table `motorcycle`
--

CREATE TABLE `motorcycle` (
  `mid` int(19) NOT NULL,
  `name` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `transmission` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `motorcycle`
--

INSERT INTO `motorcycle` (`mid`, `name`, `brand`, `transmission`) VALUES
(1, 'MIO 123', 'YAMAHA', 'AUTOMATIC'),
(2, 'RAIDER 150', 'SUZUKI', 'MANUAL'),
(3, 'CLICK 125', 'HONDA', 'AUTOMATIC'),
(4, 'CLICK 150', 'HONDA', 'AUTOMATIC'),
(5, 'AEROX 155', 'YAMAHA', 'AUTOMATIC'),
(6, 'NMAX 155', 'YAMAHA', 'AUTOMATIC'),
(7, 'BEAT 125', 'HONDA', 'AUTOMATIC'),
(8, 'GENIO 125', 'HONDA', 'AUTOMATIC'),
(9, 'GRAVIS', 'YAMAHA', 'AUTOMATIC'),
(10, 'SMASH 115', 'SUZUKI', 'SEMIAUTOMATIC'),
(11, 'XRM 125', 'HONDA', 'SEMIAUTOMATIC'),
(12, 'VEGA FORCE 115', 'YAMAHA', 'SEMIAUTOMATIC');

-- --------------------------------------------------------

--
-- Table structure for table `motourista`
--

CREATE TABLE `motourista` (
  `m_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `motour_name` varchar(50) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `isActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `motourista`
--

INSERT INTO `motourista` (`m_id`, `user_id`, `motour_name`, `latitude`, `longitude`, `isActive`) VALUES
(1, 1, 'Robinson moto rent', '10.3050232', '123.9095174', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `contact` varchar(13) NOT NULL,
  `user_pic` varchar(225) NOT NULL,
  `license_pic` varchar(225) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `isActive` int(2) NOT NULL,
  `isVer` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `firstname`, `middlename`, `lastname`, `contact`, `user_pic`, `license_pic`, `user_type`, `isActive`, `isVer`) VALUES
(1, 'Test@gmail.com', '123', 'John', 'Dee', 'Doe', '09750791317', 'profiles/23b7962e-a5f4-4e81-8294-e00805ced395.jpg', 'certification/73cbb251-c9b5-4ce1-9843-aec9e1c859f2.jpg', 'user', 1, '1'),
(2, 'Monkey@gmail.com', '123', 'Monkey', 'Donisya', 'Luffy', '09750791317', 'profiles/8a682898-8c4c-41e6-bd86-855c010fc622.jpg', 'certification/12828859-7ad5-4a9f-9749-2233c3dd702b.jpg', 'user', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `motor_id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `m_id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pic1` varchar(225) NOT NULL,
  `pic2` varchar(225) NOT NULL,
  `pic3` varchar(225) NOT NULL,
  `offRec` varchar(225) NOT NULL,
  `certReg` varchar(225) NOT NULL,
  `transmission` varchar(50) NOT NULL,
  `onRent` int(2) NOT NULL,
  `isActive` int(2) NOT NULL,
  `tourmopoints` int(11) NOT NULL,
  `isVerified` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`motor_id`, `user_id`, `m_id`, `brand`, `name`, `pic1`, `pic2`, `pic3`, `offRec`, `certReg`, `transmission`, `onRent`, `isActive`, `tourmopoints`, `isVerified`) VALUES
(1, 1, 1, 'YAMAHA', 'MIO 123', 'motor/7b861a8e-27ab-4dc9-b5cb-46362419ac93.jpg', 'motor/a563a457-9f61-4b1b-833f-9ec7c4de6897.jpg', 'motor/0dd5585b-5e7d-4cb7-be06-09799559c07c.jpg', 'or/6d5cd1aa-5dae-4f0b-85df-619b70f1e883.jpg', 'cr/4ebe8575-f476-4e24-b611-cccb8c70c8c6.jpg', 'AUTOMATIC', 0, 0, 500, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `motorcycle`
--
ALTER TABLE `motorcycle`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `motourista`
--
ALTER TABLE `motourista`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`motor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `motorcycle`
--
ALTER TABLE `motorcycle`
  MODIFY `mid` int(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `motourista`
--
ALTER TABLE `motourista`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `motor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
