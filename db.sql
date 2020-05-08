-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 08, 2020 at 07:42 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sApp`
--
CREATE DATABASE IF NOT EXISTS `sApp` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sApp`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Branch`
--

CREATE TABLE `Branch` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` bigint(20) DEFAULT NULL,
  `Branch_type` enum('Main Branch','Sub Branch') NOT NULL DEFAULT 'Main Branch'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Purchase_Ledger`
--

CREATE TABLE `Purchase_Ledger` (
  `id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Bill_No` int(11) NOT NULL,
  `Sellers_name` varchar(255) NOT NULL,
  `Sellers_PAN_no` int(255) NOT NULL,
  `Total_Purchase_Amount` int(255) NOT NULL,
  `VAT_included_purchase_amount` int(11) NOT NULL,
  `VAT_included_purchase_VAT_amount` int(11) NOT NULL,
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
  `Customers_name` varchar(255) NOT NULL,
  `Customers_PAN_no` bigint(11) NOT NULL,
  `Total_sales_amount` bigint(11) NOT NULL,
  `VAT_included_sales_amount` bigint(11) NOT NULL,
  `VAT_included_sales_VAT` bigint(11) NOT NULL,
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
