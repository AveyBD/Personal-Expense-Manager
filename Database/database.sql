-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2018 at 11:28 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cetra_pem`
--

-- --------------------------------------------------------

--
-- Table structure for table `pem_accounts`
--

CREATE TABLE `pem_accounts` (
  `acc_id` int(11) NOT NULL COMMENT 'Index',
  `acc_name` tinytext COLLATE utf8_bin NOT NULL,
  `acc_number` tinytext COLLATE utf8_bin NOT NULL,
  `acc_balance` decimal(12,0) DEFAULT NULL,
  `remarks` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `pem_categories`
--

CREATE TABLE `pem_categories` (
  `cat_id` int(11) NOT NULL COMMENT 'Index',
  `category` tinytext COLLATE utf8_bin NOT NULL COMMENT 'Category Name',
  `remarks` text COLLATE utf8_bin COMMENT 'Remarks (optional)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pem_categories`
--

INSERT INTO `pem_categories` (`cat_id`, `category`, `remarks`) VALUES
(3, 'Grocery', NULL),
(4, 'Online Shopping', NULL),
(5, 'Utility Bills', 'MSEB, BSNL and Mobile Bills'),
(6, 'Hotel', NULL),
(7, 'Edibles', 'Any Food item (like Mithaai) which is to be consumed at home.'),
(8, 'Medication', NULL),
(9, 'Home Care', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pem_expenses`
--

CREATE TABLE `pem_expenses` (
  `exp_id` int(11) NOT NULL COMMENT 'Index',
  `exp_item` text COLLATE utf8_bin NOT NULL COMMENT 'Expense Item Name',
  `exp_category` int(10) NOT NULL COMMENT 'Category',
  `payment_type` int(10) DEFAULT NULL COMMENT 'Mode of Payment',
  `exp_source` int(10) NOT NULL COMMENT 'Source of Expense',
  `exp_amount` decimal(35,2) NOT NULL COMMENT 'Expense Amount',
  `exp_date` date NOT NULL COMMENT 'Date',
  `exp_remarks` text COLLATE utf8_bin COMMENT 'Remarks (optional)',
  `user_id` int(10) DEFAULT NULL COMMENT 'User ID of User making this entry'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `pem_exp_source`
--

CREATE TABLE `pem_exp_source` (
  `source_id` int(11) NOT NULL COMMENT 'Index',
  `source_name` tinytext COLLATE utf8_bin NOT NULL COMMENT 'Name of Source (eg. Credit Card, Savings Account etc)',
  `source_type` int(10) DEFAULT NULL COMMENT 'Type',
  `source_acc` int(10) DEFAULT NULL,
  `remarks` text COLLATE utf8_bin COMMENT 'Remarks (optional)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `pem_payment_type`
--

CREATE TABLE `pem_payment_type` (
  `type_id` int(11) NOT NULL COMMENT 'Index',
  `payment_type` tinytext COLLATE utf8_bin NOT NULL COMMENT 'Payment Type',
  `remarks` text COLLATE utf8_bin COMMENT 'Remarks (optional)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `userlevelpermissions`
--

CREATE TABLE `userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) COLLATE utf8_bin NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `userlevelpermissions`
--

INSERT INTO `userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_categories', 0),
(-2, '{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_exp_source', 0),
(-2, '{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_expenses', 0),
(-2, '{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_payment_type', 0),
(-2, '{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}users', 0),
(0, '{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_categories', 0),
(0, '{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_exp_source', 0),
(0, '{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_expenses', 0),
(0, '{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}pem_payment_type', 0),
(0, '{0CE8814C-5AE1-40E3-91A4-888B83DCC6F0}users', 0);

-- --------------------------------------------------------

--
-- Table structure for table `userlevels`
--

CREATE TABLE `userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(80) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `userlevels`
--

INSERT INTO `userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'Index',
  `name` varchar(50) NOT NULL COMMENT 'Real Name',
  `email` varchar(50) DEFAULT NULL COMMENT 'Email ID',
  `login` varchar(50) NOT NULL COMMENT 'User Name',
  `password` varchar(50) NOT NULL COMMENT 'Password',
  `user_level` int(2) NOT NULL COMMENT 'User Level',
  `profile_photo` varchar(100) DEFAULT NULL,
  `profile_info` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pem_accounts`
--
ALTER TABLE `pem_accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `pem_categories`
--
ALTER TABLE `pem_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `pem_expenses`
--
ALTER TABLE `pem_expenses`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `pem_exp_source`
--
ALTER TABLE `pem_exp_source`
  ADD PRIMARY KEY (`source_id`);

--
-- Indexes for table `pem_payment_type`
--
ALTER TABLE `pem_payment_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `userlevelpermissions`
--
ALTER TABLE `userlevelpermissions`
  ADD PRIMARY KEY (`userlevelid`,`tablename`);

--
-- Indexes for table `userlevels`
--
ALTER TABLE `userlevels`
  ADD PRIMARY KEY (`userlevelid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pem_accounts`
--
ALTER TABLE `pem_accounts`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Index';
--
-- AUTO_INCREMENT for table `pem_categories`
--
ALTER TABLE `pem_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Index', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `pem_expenses`
--
ALTER TABLE `pem_expenses`
  MODIFY `exp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Index', AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `pem_exp_source`
--
ALTER TABLE `pem_exp_source`
  MODIFY `source_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Index', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `pem_payment_type`
--
ALTER TABLE `pem_payment_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Index', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Index';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
