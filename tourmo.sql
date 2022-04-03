-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2022 at 04:48 PM
-- Server version: 10.4.24-MariaDB
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
-- Table structure for table `motourista`
--

CREATE TABLE `motourista` (
  `m_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `isActive` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `firstname`, `middlename`, `lastname`, `contact`, `user_pic`, `license_pic`, `user_type`, `isActive`) VALUES
(1, 'test@gmail.com', '123', 'John', 'de', 'Doe', '09750791317', 'profiles/wp9378515-dave2d-wallpapers.jpg', 'certification/wp9378515-dave2d-wallpapers.jpg', 'user', 1),
(2, 'test1@gmail.com', '123', 'test', 'test', 'test', '09750791317', 'profiles/Remini20220127160315579__1_-removebg-preview.png', 'certification/IMG_20220127_161949.jpg', 'user', 1),
(3, 'test3@gmail.com', 'test', 'test', 'test', 'tse', '09750791317', 'profiles/', 'certification/', 'user', 1),
(4, 'test6@gmail.com', 'test', 'test', 'test', 'tse', '09750791317', 'profiles/e1cb1004-f219-4b05-b299-daf7cdb48dee.jpg', 'certification/64493c78-14fe-4f0d-912f-1869e8fc330e.jpg', 'user', 1),
(5, 'Check@gmail.com', '123', 'Test', 'Tes', 'Test', '09750791317', 'profiles/179c1350-9b44-4208-b658-33f8915f1a86.jpg', 'certification/d3fc16b7-c638-4f8b-9be8-ace40bb5f9a5.jpg', 'user', 1),
(6, 'Racho@gmail.com', '123', 'Racho', 'Das', 'Chadchad', '09750791317', 'profiles/66deabb6-b7f2-4e45-afeb-d35844cadbd4.jpg', 'certification/3a92d359-9ec7-4960-beca-c4a78dc930de.jpg', 'user', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `motor_id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `pic1` int(11) NOT NULL,
  `pic2` int(11) NOT NULL,
  `pic3` int(11) NOT NULL,
  `offRec` int(11) NOT NULL,
  `certReg` int(11) NOT NULL,
  `transmission` int(11) NOT NULL,
  `onRent` int(11) NOT NULL,
  `isActive` int(11) NOT NULL,
  `tourmopoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `motourista`
--
ALTER TABLE `motourista`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `motor_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
