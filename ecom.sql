-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2020 at 04:11 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'Define User ID ',
  `Username` varchar(255) NOT NULL COMMENT 'To identify the user',
  `Password` varchar(255) NOT NULL COMMENT 'User Password',
  `FullName` varchar(255) NOT NULL COMMENT 'User''s Fullname',
  `Email` varchar(255) NOT NULL COMMENT 'User''s Email',
  `PhoneNumber` int(11) NOT NULL,
  `PAddress` varchar(255) NOT NULL,
  `RegStatus` int(11) NOT NULL COMMENT 'Registration status',
  `GroupID` int(11) NOT NULL COMMENT 'Group of Users',
  `Date` date NOT NULL COMMENT 'Date',
  `Avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `FullName`, `Email`, `PhoneNumber`, `PAddress`, `RegStatus`, `GroupID`, `Date`, `Avatar`) VALUES
(1, 'tandra', '601f1889667efaebb33b8c12572835da3f027f78', 'Tandra Zaman', 'tandra@gmail.com', 1683848060, 'Uttara Dhaka', 0, 1, '2020-03-05', '733474_sultanazaman.jpg'),
(17, 'akibur', '601f1889667efaebb33b8c12572835da3f027f78', 'Akibur Rahman', 'akibur.choton@gmail.com', 2147483647, 'Road-16, Sector-14.', 0, 1, '2020-03-08', ''),
(27, 'akibur', '601f1889667efaebb33b8c12572835da3f027f78', 'Akibur Rahman Choton', 'akibur.choton@gmail.com', 1616103020, 'Road-16, Sector-14, Uttara', 1, 0, '2020-03-09', '344_akibur.jpg'),
(28, 'Tandra1', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Sultana Zaman Tandra', 'tandrazaman90@gmail.com', 1683848060, 'Uttara', 1, 0, '2020-03-09', '733474_sultanazaman.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Define User ID ', AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
