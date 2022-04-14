-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2021 at 01:27 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `happy_pet`
--

-- --------------------------------------------------------

--
-- Table structure for table `certification`
--

CREATE TABLE `certification` (
  `cert_id` int(11) NOT NULL,
  `suser_id` int(11) NOT NULL,
  `cert_pic` varchar(255) NOT NULL,
  `cert_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `fac_id` int(11) NOT NULL,
  `sUser_id` int(11) NOT NULL,
  `fac_pic` varchar(255) NOT NULL,
  `fac_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `mess_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `suser_id` int(11) NOT NULL,
  `message` int(255) NOT NULL,
  `mess_type` int(10) NOT NULL,
  `mess_date` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `pet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_category` varchar(10) NOT NULL,
  `petname` varchar(50) NOT NULL,
  `weight` int(10) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `breed` varchar(10) NOT NULL,
  `color` varchar(10) NOT NULL,
  `pet_med_id` int(11) NOT NULL,
  `pet_status` varchar(10) NOT NULL,
  `ppic` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`pet_id`, `user_id`, `pet_category`, `petname`, `weight`, `dob`, `breed`, `color`, `pet_med_id`, `pet_status`, `ppic`) VALUES
(1, 2, 'dog', 'Hachi', 10, '1/1/2021', 'Rottweiler', 'brown', 0, 'active', 'profiles/download.png'),
(2, 3, 'cat', 'Princess', 5, '2/6/2021', 'Siamese', 'black', 0, 'active', 'profiles/download.png'),
(3, 2, 'dog', 'Winter', 8, '12/4/2019', 'Maltese', 'white', 0, 'inactive', 'profiles/download.png');

-- --------------------------------------------------------

--
-- Table structure for table `pet_medical`
--

CREATE TABLE `pet_medical` (
  `petmed_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pet_routine`
--

CREATE TABLE `pet_routine` (
  `petRoutine_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `pet` varchar(50) NOT NULL,
  `time` varchar(10) NOT NULL,
  `todo` varchar(255) NOT NULL,
  `food` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `serviceuser`
--

CREATE TABLE `serviceuser` (
  `sUser_id` int(11) NOT NULL,
  `sFname` varchar(50) NOT NULL,
  `sLname` varchar(50) NOT NULL,
  `sEmail` varchar(50) NOT NULL,
  `sPassword` varchar(50) NOT NULL,
  `sBirthday` varchar(10) NOT NULL,
  `sContact` varchar(13) NOT NULL,
  `sAddress` varchar(50) NOT NULL,
  `sDateAdded` varchar(20) NOT NULL,
  `sType` varchar(25) NOT NULL,
  `sStatus` varchar(10) NOT NULL,
  `sRate` int(10) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `sPic` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `serviceuser`
--

INSERT INTO `serviceuser` (`sUser_id`, `sFname`, `sLname`, `sEmail`, `sPassword`, `sBirthday`, `sContact`, `sAddress`, `sDateAdded`, `sType`, `sStatus`, `sRate`, `sub_id`, `sPic`) VALUES
(1, 'Rhemart', 'Mora', 'mora@gmail.com', '123', '12/14/1992', '123456789011', 'Naga, Cebu', '10/2/2021', 'Keeper', 'active', 250, 1, 'profiles/download.png\r\n\r\n'),
(2, 'Rain', 'Arom', 'arom@gmail.com', '123', '1/1/2019', '09324242303', 'Cebu City', '1/25/2020', 'Trainer', 'inactive', 300, 2, 'profiles/download.png\r\n'),
(3, 'Alfred', 'Knight', 'al@gmail.com', '123', '3/6/2015', '896453543765', 'Pardo,  Bulacao', '7/25/217', 'Both', 'active', 200, 3, 'profiles/download.png\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `sub_id` int(11) NOT NULL,
  `sub_type` varchar(10) NOT NULL,
  `sub_rate` int(10) NOT NULL,
  `sub_for` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `trans_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `suser_id` int(11) NOT NULL,
  `date_start` varchar(10) NOT NULL,
  `date_end` varchar(10) NOT NULL,
  `service_type` varchar(10) NOT NULL,
  `location` varchar(50) NOT NULL,
  `date_created` varchar(10) NOT NULL,
  `trans_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_pic` varchar(200) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `contact` varchar(12) NOT NULL,
  `address` varchar(50) NOT NULL,
  `birthday` varchar(10) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `date_added` varchar(10) NOT NULL,
  `user_status` varchar(15) NOT NULL,
  `sub_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `user_pic`, `firstname`, `lastname`, `contact`, `address`, `birthday`, `user_type`, `date_added`, `user_status`, `sub_id`) VALUES
(1, 'admin1@gmail.com', '123', 'profiles/download.png', 'Jutti', 'Admin', '09232878787', '', '1/1/1998', 'admin', '10/2/2021', 'active', 0),
(2, 'lemming@gmail.com', '123', 'profiles/download.png', 'Charles', 'Lemming', '345437653', 'Bulacao, Cebu City', '5/8/1995', 'user', '3/4/2020', 'active', 2),
(3, 'ylanan@gmail.com', '123', 'profiles/download.png', 'John Carlo', 'Ylanan', '435357642', 'Bulacao, Cebu City', '8/1/1999', 'user', '4/8/2021', 'inactive', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certification`
--
ALTER TABLE `certification`
  ADD PRIMARY KEY (`cert_id`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`fac_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`mess_id`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `pet_medical`
--
ALTER TABLE `pet_medical`
  ADD PRIMARY KEY (`petmed_id`);

--
-- Indexes for table `pet_routine`
--
ALTER TABLE `pet_routine`
  ADD PRIMARY KEY (`petRoutine_id`);

--
-- Indexes for table `serviceuser`
--
ALTER TABLE `serviceuser`
  ADD PRIMARY KEY (`sUser_id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`sub_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certification`
--
ALTER TABLE `certification`
  MODIFY `cert_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `fac_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `mess_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pet_medical`
--
ALTER TABLE `pet_medical`
  MODIFY `petmed_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_routine`
--
ALTER TABLE `pet_routine`
  MODIFY `petRoutine_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `serviceuser`
--
ALTER TABLE `serviceuser`
  MODIFY `sUser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
