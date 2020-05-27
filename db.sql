-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 27, 2020 at 03:26 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sApp`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(50) DEFAULT '',
  `User_type` enum('Admin','Standard') NOT NULL DEFAULT 'Standard',
  `Linked_branch` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_details`
--

CREATE TABLE `accounts_details` (
  `id` int(11) NOT NULL,
  `Account_id` int(11) NOT NULL,
  `Record_type` enum('Opening Balance','Credit','Cheque','Purchase','Sales','Cash','Voucher') NOT NULL,
  `order_id` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Description` varchar(255) NOT NULL,
  `Dr` int(11) NOT NULL DEFAULT '0',
  `Cr` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_info`
--

CREATE TABLE `accounts_info` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` bigint(11) DEFAULT NULL,
  `PAN_No` bigint(20) DEFAULT NULL,
  `Account_type` enum('Vendor','Customer','Cash') NOT NULL DEFAULT 'Customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Branch`
--

CREATE TABLE `Branch` (
  `id` int(11) NOT NULL,
  `Branch_Name` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` bigint(20) DEFAULT NULL,
  `PAN` bigint(20) NOT NULL,
  `Branch_type` enum('Main Branch','Sub Branch') NOT NULL DEFAULT 'Main Branch',
  `Linked_account` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Purchase_Ledger`
--

CREATE TABLE `Purchase_Ledger` (
  `id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Bill_No` int(11) NOT NULL,
  `Sellers_name` int(255) NOT NULL,
  `Sellers_PAN_no` int(255) NOT NULL,
  `Total_Purchase_Amount` decimal(10,2) NOT NULL,
  `VAT_included_purchase_amount` decimal(10,2) NOT NULL,
  `VAT_included_purchase_VAT_amount` decimal(10,2) NOT NULL,
  `Branch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Sales_Ledger`
--

CREATE TABLE `Sales_Ledger` (
  `id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Bill_no` bigint(11) NOT NULL,
  `Customers_name` int(255) NOT NULL,
  `Customers_PAN_no` bigint(11) NOT NULL,
  `Total_sales_amount` decimal(10,2) NOT NULL,
  `VAT_included_sales_amount` decimal(10,2) NOT NULL,
  `VAT_included_sales_VAT` decimal(10,2) NOT NULL,
  `Branch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_details`
--
ALTER TABLE `accounts_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_info`
--
ALTER TABLE `accounts_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Branch`
--
ALTER TABLE `Branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Purchase_Ledger`
--
ALTER TABLE `Purchase_Ledger`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `Sales_Ledger`
--
ALTER TABLE `Sales_Ledger`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_details`
--
ALTER TABLE `accounts_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_info`
--
ALTER TABLE `accounts_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Branch`
--
ALTER TABLE `Branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Purchase_Ledger`
--
ALTER TABLE `Purchase_Ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Sales_Ledger`
--
ALTER TABLE `Sales_Ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
