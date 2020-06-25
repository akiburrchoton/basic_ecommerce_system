-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2020 at 05:36 PM
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
  `Cat_parent` int(11) NOT NULL COMMENT 'Identify Parent and Child (If 0 -> Parent Category)',
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
(3, 'Motor Bike', 'This is the category where any kinds of Motor Bike can be added. ', 0, 3, 0, 1, 0),
(8, 'Honda', '', 3, 1, 0, 1, 0),
(9, 'Game', '', 0, 4, 1, 0, 0),
(10, 'Fighting Game', 'Fighting Game', 9, 7, 1, 1, 1),
(11, 'Alienware Laptop', 'Grey Alienware Laptop', 2, 5, 1, 1, 1),
(12, 'Samsung', 'Sub category of Smartphone Category', 1, 6, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `comment_itemid` int(11) NOT NULL,
  `comment_userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `comment_status`, `comment_date`, `comment_itemid`, `comment_userid`) VALUES
(1, 'This is a very good smartphone to use. 4.5 Years using with no problem. Great one!', 0, '2020-05-11', 1, 1),
(2, 'This is a very good smartphone to use. 4.5 Years using with no problem. Great one!', 0, '2020-05-11', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Item_name` varchar(255) NOT NULL,
  `Item_description` varchar(255) NOT NULL,
  `Item_price` int(11) NOT NULL,
  `Item_date` date NOT NULL,
  `Item_country` varchar(255) NOT NULL,
  `Item_status` int(11) NOT NULL,
  `Item_rating` smallint(6) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Item_image` varchar(255) NOT NULL,
  `Item_approval` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Item_name`, `Item_description`, `Item_price`, `Item_date`, `Item_country`, `Item_status`, `Item_rating`, `Cat_ID`, `User_ID`, `Item_image`, `Item_approval`) VALUES
(1, 'Samsung S6 Edge', 'Black Samsung S6 Edge\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry.', 600, '2020-04-04', 'Vietnam', 4, 0, 12, 1, '', 1),
(2, 'Honda Hornet', 'Green Honda Hornet 160cc\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry.', 150000, '2020-04-04', 'Japan', 2, 0, 8, 2, '', 1),
(3, 'Alienware 13', 'Alienware 13 R2 Grey\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry.', 90000, '2020-04-04', 'Australia', 3, 0, 11, 1, '', 1),
(9, 'Redmi ', 'Redmi Smart Phone orem Ipsum is simply dummy text of the printing and typesetting industry.', 123, '2020-04-28', 'BD', 2, 0, 1, 2, '', 1);

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
(2, 'akibur', '601f1889667efaebb33b8c12572835da3f027f78', 'Akibur Rahman', 'akibur.choton@gmail.com', 2147483647, 'Road-16, Sector-14.', 1, 1, '2020-03-08', ''),
(3, 'akiburrchoton', '601f1889667efaebb33b8c12572835da3f027f78', 'Akibur Rahman', 'akibur.choton@gmail.com', 1616103020, 'Road-16, Sector-14, Uttara', 1, 0, '2020-03-09', '344_akibur.jpg'),
(4, 'Tandra1', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Sultana Zaman Tandra', 'tandrazaman90@gmail.com', 1683848060, 'Uttara', 1, 0, '2020-03-09', '733474_sultanazaman.jpg'),
(5, 'Dummy', '27e95131edc7ed3c63472067ea1d95cf8f0056cf', 'Dummy Dummy', 'd@d.com', 123123, 'Uttara', 0, 0, '2020-03-27', '846732_Akibur.jpg'),
(45, 'test', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', 'test@test.com', 0, '', 1, 0, '2020-04-24', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Define User ID ', AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
