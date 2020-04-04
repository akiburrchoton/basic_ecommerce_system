-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2020 at 12:19 PM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Cat_id` int(11) NOT NULL,
  `Cat_name` varchar(255) NOT NULL,
  `Cat_description` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `Cat_parent` int(11) NOT NULL COMMENT 'Identify Parent and Child',
  `Cat_ordering` int(11) NOT NULL,
  `Cat_visibility` int(11) NOT NULL,
  `Cat_comments` int(11) NOT NULL,
  `Cat_ads` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Cat_id`, `Cat_name`, `Cat_description`, `Cat_parent`, `Cat_ordering`, `Cat_visibility`, `Cat_comments`, `Cat_ads`) VALUES
(1, 'Smartphone', 'This is Smart phone category. Any kind of smart can be included in this category.', 0, 1, 0, 1, 0),
(2, 'Computer', 'In here any kind of computer can be added in here. ', 0, 2, 0, 0, 1),
(3, 'Headphone', 'This is the category where any kinds of headphone can be added. ', 0, 3, 0, 1, 0),
(8, 'New Headphone', '', 3, 1, 0, 1, 0),
(9, 'Game', '', 0, 4, 1, 0, 0),
(10, 'Fighting Game', 'Fighting Game', 9, 7, 1, 1, 1),
(11, 'Alienware Laptop', 'Grey Alienware Laptop', 2, 5, 1, 1, 1),
(12, 'Samsung', 'Sub category of Smartphone Category', 1, 6, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Item_name` varchar(255) NOT NULL,
  `Item_description` int(255) NOT NULL,
  `Item_price` int(11) NOT NULL,
  `Item_date` date NOT NULL,
  `Item_country` varchar(255) NOT NULL,
  `Item_status` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Item_approval` int(11) NOT NULL,
  `Item_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'tandra', '601f1889667efaebb33b8c12572835da3f027f78', 'Tandra Zaman', 'tandra@gmail.com', 1683848060, 'Uttara Dhaka', 1, 1, '2020-03-05', '733474_sultanazaman.jpg'),
(17, 'akibur', '601f1889667efaebb33b8c12572835da3f027f78', 'Akibur Rahman', 'akibur.choton@gmail.com', 2147483647, 'Road-16, Sector-14.', 1, 1, '2020-03-08', ''),
(27, 'akiburrchoton', '601f1889667efaebb33b8c12572835da3f027f78', 'Akibur Rahman', 'akibur.choton@gmail.com', 1616103020, 'Road-16, Sector-14, Uttara', 1, 0, '2020-03-09', '344_akibur.jpg'),
(28, 'Tandra1', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Sultana Zaman Tandra', 'tandrazaman90@gmail.com', 1683848060, 'Uttara', 1, 0, '2020-03-09', '733474_sultanazaman.jpg'),
(44, 'Dummy', '27e95131edc7ed3c63472067ea1d95cf8f0056cf', 'Dummy Dummy', 'd@d.com', 123123, 'Uttara', 0, 0, '2020-03-27', '846732_Akibur.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Cat_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Define User ID ', AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
