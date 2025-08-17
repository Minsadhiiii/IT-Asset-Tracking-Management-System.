-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 06:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `snipeit_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessory`
--

CREATE TABLE `accessory` (
  `accessoryID` int(11) NOT NULL,
  `modelNo` varchar(50) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `remaining` int(11) DEFAULT NULL,
  `itemID` int(11) DEFAULT NULL,
  `warrantyID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accessory`
--

INSERT INTO `accessory` (`accessoryID`, `modelNo`, `quantity`, `remaining`, `itemID`, `warrantyID`) VALUES
(1, 'ACC123', 30, 0, 5, 1),
(4, 'BH67', 24, 23, 52, 15);

-- --------------------------------------------------------

--
-- Table structure for table `asset`
--

CREATE TABLE `asset` (
  `assetID` int(11) NOT NULL,
  `assetTag` varchar(100) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `modelName` varchar(255) DEFAULT NULL,
  `nextAuditDate` date DEFAULT NULL,
  `itemID` int(11) DEFAULT NULL,
  `warrantyID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asset`
--

INSERT INTO `asset` (`assetID`, `assetTag`, `serial`, `modelName`, `nextAuditDate`, `itemID`, `warrantyID`) VALUES
(3, 'AD3456', 'SN12345', 'Dell Inspiron 15', '0000-00-00', 1, 1),
(26, 'HP7876', 'GYH6789', 'LaserJet 1020', NULL, 60, 17),
(27, 'HG2121', 'FFRFRS', '', NULL, 65, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assetassignment`
--

CREATE TABLE `assetassignment` (
  `assignmentID` int(11) NOT NULL,
  `assignmentDate` date NOT NULL,
  `returnDate` date DEFAULT NULL,
  `itemID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `expCheckinDate` date DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Active',
  `officeID` int(11) DEFAULT NULL,
  `checkinNotes` text DEFAULT NULL,
  `checkoutNotes` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `checkedOutDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assetassignment`
--

INSERT INTO `assetassignment` (`assignmentID`, `assignmentDate`, `returnDate`, `itemID`, `userID`, `expCheckinDate`, `status`, `officeID`, `checkinNotes`, `checkoutNotes`, `quantity`, `checkedOutDate`) VALUES
(7, '2024-11-27', '2024-11-30', 1, NULL, '2024-11-30', 'Completed', 2, 'No', 'No', NULL, '2024-12-04 21:43:30'),
(8, '2024-11-26', '2024-11-30', 1, 2, '2024-11-30', 'Completed', 3, 'Piliyandala', 'Noo', NULL, '2024-12-04 21:43:30'),
(9, '2024-11-28', '2024-11-29', 1, 1, '2024-11-30', 'Completed', 2, 'No', 'No', NULL, '2024-12-04 21:43:30'),
(10, '2024-11-28', NULL, 3, 1, NULL, 'Completed', NULL, NULL, 'No', NULL, '2024-12-04 21:43:30'),
(11, '2024-11-23', NULL, 3, 1, NULL, 'Active', NULL, NULL, 'No', NULL, '2024-12-04 21:43:30'),
(12, '2024-11-30', NULL, 50, 2, NULL, 'Active', NULL, NULL, 'nn', NULL, '2024-12-04 21:43:30'),
(13, '2024-11-28', NULL, 1, 1, NULL, 'Completed', NULL, NULL, 'No', 30, '2024-12-04 21:43:30'),
(15, '2024-11-28', NULL, 52, 2, NULL, 'Active', NULL, NULL, 'No', 1, '2024-12-04 21:43:30'),
(17, '2024-11-29', NULL, 7, 2, NULL, 'Completed', NULL, NULL, 'No', 1, '2024-12-04 21:43:30'),
(18, '2024-11-29', NULL, 7, 1, NULL, 'Active', NULL, NULL, 'No', 1, '2024-12-04 21:43:30'),
(19, '2024-11-27', NULL, 6, 1, NULL, 'Completed', NULL, NULL, 'No', 32, '2024-12-04 21:43:30'),
(20, '2024-11-28', NULL, 6, 2, NULL, 'Active', NULL, NULL, 'No', 10, '2024-12-04 21:43:30'),
(21, '2024-12-20', '2024-12-13', 1, 2, '2025-01-02', 'Completed', 2, '', '', NULL, '2024-12-04 21:43:30'),
(22, '2024-12-06', '2024-12-05', 1, 2, '2024-12-04', 'Completed', 3, '', '', NULL, '2024-12-04 21:43:30'),
(23, '2024-12-05', NULL, 60, 2, '2024-12-06', 'Active', 2, NULL, '', NULL, '2024-12-04 21:44:05'),
(24, '2024-12-13', NULL, 65, 2, '2024-12-20', 'Active', 2, NULL, '', NULL, '2024-12-04 22:51:23');

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `auditID` int(11) NOT NULL,
  `auditDate` date NOT NULL,
  `auditor` varchar(255) DEFAULT NULL,
  `findings` text DEFAULT NULL,
  `itemID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`auditID`, `auditDate`, `auditor`, `findings`, `itemID`) VALUES
(1, '2024-05-01', 'Auditor A', 'No issues found', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `name`) VALUES
(1, 'Laptops'),
(2, 'Desktops'),
(3, 'Printerss'),
(4, 'Accessories'),
(5, 'Software'),
(6, 'Mouse'),
(7, 'Keyboard'),
(8, 'Prineter Paper'),
(9, 'Ram'),
(10, 'HDD'),
(11, 'TV'),
(13, 'SDsew'),
(14, 'gtvv'),
(21, 'Asd');

-- --------------------------------------------------------

--
-- Table structure for table `component`
--

CREATE TABLE `component` (
  `componentID` int(11) NOT NULL,
  `serial` varchar(50) NOT NULL,
  `modelNo` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `remaining` int(11) DEFAULT NULL,
  `itemID` int(11) DEFAULT NULL,
  `warrantyID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `component`
--

INSERT INTO `component` (`componentID`, `serial`, `modelNo`, `quantity`, `remaining`, `itemID`, `warrantyID`) VALUES
(1, 'CSN123', 'ModelX', 40, 38, 7, 1),
(4, 'HG6732', 'HG67832', 20, 20, 56, 16);

-- --------------------------------------------------------

--
-- Table structure for table `consumable`
--

CREATE TABLE `consumable` (
  `consumableID` int(11) NOT NULL,
  `modelNo` varchar(50) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `remaining` int(11) DEFAULT NULL,
  `itemID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consumable`
--

INSERT INTO `consumable` (`consumableID`, `modelNo`, `quantity`, `remaining`, `itemID`) VALUES
(1, 'CON123', 68, 58, 6),
(4, 'SH6789', 33, 33, 59);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `officeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `email`, `phone`, `officeID`) VALUES
(1, 'IT Department', 'it@office.com', '+94119876543', 1),
(2, 'HR Department', 'hr@office.com', '+94111223344', 2),
(3, 'IT Department', 'it@office.com', '+94119876543', 1),
(4, 'HR Department', 'hr@office.com', '+94111223344', 2);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `categoryID` int(11) DEFAULT NULL,
  `manufacturerID` int(11) DEFAULT NULL,
  `orderID` int(11) DEFAULT NULL,
  `statusID` int(11) DEFAULT NULL,
  `officeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `name`, `image`, `notes`, `categoryID`, `manufacturerID`, `orderID`, `statusID`, `officeID`) VALUES
(1, 'Dell Inspiron 16', 'dellins.jpeg', '15-inch laptop', 1, 1, 1, 1, 3),
(3, 'Adobe Photoshop', 'ps.png', 'Image editing Software', 5, NULL, 3, 1, 1),
(5, 'Acer Predator', 's-l400.jpg', 'Mouse', 6, 3, 5, 1, 1),
(6, 'A4 75GSM Paper', 'images (2).jpg', 'Priner Paper', 8, 3, 6, 1, 4),
(7, 'Crucial 4GB DDR3L-1600 SODIMM', 'ram.jpg', '4 GB Ram', 9, 4, 7, 1, 3),
(49, 'Adobe Reader', 'download.jpg', '', 5, 5, NULL, 1, 4),
(50, 'Windows 7', 'd302d7664552bb4bdad844c335c3ad25.jpg', 'Samitha', 5, 5, 20, 1, 2),
(52, 'Logitech Prodigy', 'images (1).jpg', 'Blue', 7, 4, 21, 1, 2),
(53, '', '40449-11779371.jpg', '256 HDD', NULL, NULL, NULL, 1, NULL),
(54, 'HDD WD100', '40449-11779371.jpg', '256 HDD', NULL, NULL, NULL, 1, NULL),
(56, 'HDD 256', '40449-11779371.jpg', '256 GB', 10, 2, 22, 1, 2),
(59, 'Laserjet Paper (Ream)', 'L7621238.jpg', '101 Sheets', 8, 3, 23, 1, 2),
(60, 'HP LaserJet 1020', '20231106104601HP-LASERJET-1008A-PRINTER-1200x900.jpg', 'Printer', 3, 2, 24, 5, 3),
(65, 'Dell Vostro', 'dell-vostro.jpg', 'No', 1, 1, NULL, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `license`
--

CREATE TABLE `license` (
  `licenseID` int(11) NOT NULL,
  `productKey` varchar(255) NOT NULL,
  `seats` int(11) DEFAULT NULL,
  `available` int(11) DEFAULT NULL,
  `licensedToName` varchar(255) DEFAULT NULL,
  `licensedToEmail` varchar(255) DEFAULT NULL,
  `expDate` date NOT NULL,
  `itemID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `license`
--

INSERT INTO `license` (`licenseID`, `productKey`, `seats`, `available`, `licensedToName`, `licensedToEmail`, `expDate`, `itemID`) VALUES
(1, 'ABCD-1234-EFGH-5678', 5, 4, 'Company A', 'admin@companya.com', '2025-01-01', 3),
(4, 'ABCD-1234-EFGH-5676', 4, 4, 'Chamath', 'chamath@gmail.com', '2025-12-20', 49),
(5, '7777', 7, 6, 'Samitha', 'samitha@gmail.com', '0000-00-00', 50);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `maintenanceID` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `completionDate` date DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `itemID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`maintenanceID`, `startDate`, `completionDate`, `type`, `description`, `cost`, `itemID`) VALUES
(1, '2024-03-01', '2024-03-05', 'Repair', 'Replaced faulty hardware', 150.00, 1),
(4, '2024-12-05', '2024-12-10', 'nnix', 'niaxs', 1000.00, 60),
(5, '2024-12-13', '2024-12-27', 'Software', 'Sawd', 1000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `manufacturerID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `supportEmail` varchar(255) DEFAULT NULL,
  `supportPhone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`manufacturerID`, `name`, `url`, `supportEmail`, `supportPhone`) VALUES
(1, 'Dell', 'https://www.dell.com', 'support@dell.com', '+18005551234'),
(2, 'HP', 'https://www.hp.com', 'support@hp.com', '+18002255435'),
(3, 'Acer', 'https://www.acer.com', 'support@acer.com', '+18005551234'),
(4, 'Lenovo', 'https://www.lenovo.com', 'support@lenovo.com', '+18002255435'),
(5, 'Adobe', 'www.adobe.com', NULL, '0776522211'),
(7, 'AMG', '', '', ''),
(8, 'ODelA', 'sas', 'aa@gmail.com', '1212'),
(9, 'dwe', 'ewe.com', 'wc@gmail.com', '077652121');

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

CREATE TABLE `office` (
  `officeID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office`
--

INSERT INTO `office` (`officeID`, `name`, `address`, `email`, `phone`) VALUES
(1, 'Head Office Pettah', '123 Main St, Colombo', 'head@office.com', '+94112345678'),
(2, 'Bambalapitiya Branch', '456 Elm St, Kandy', 'branch@office.com', '+94812345679'),
(3, 'Piliyandala Branch', '123 Main St, Colombo', 'head@office.com', '+94112345678'),
(4, 'Peliyagoda Branch', '456 Elm St, Kandy', 'branch@office.com', '+94812345679'),
(5, 'Wattala', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `orderID` int(11) NOT NULL,
  `purchaseDate` date DEFAULT NULL,
  `purchaseCost` decimal(10,2) DEFAULT NULL,
  `supplierID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`orderID`, `purchaseDate`, `purchaseCost`, `supplierID`) VALUES
(1, '2024-01-15', 1200.50, 1),
(2, '2024-02-20', 2500.75, 2),
(3, '2024-01-15', 1400.50, 2),
(4, '2024-02-20', 2900.75, 2),
(5, '2024-11-27', 4000.00, 4),
(6, '2024-11-20', 1000.00, 3),
(7, '2024-11-22', 4000.00, 3),
(9, '2024-11-26', 230000.00, NULL),
(10, '2024-11-20', 300000.00, 3),
(11, '2024-11-20', 300000.00, 3),
(12, '2024-11-26', 100000.00, 4),
(13, '2024-11-26', 100000.00, 4),
(14, '2024-11-27', 34333.00, 2),
(15, '2024-11-30', 23254.00, 2),
(16, '2024-11-27', 46999.00, 3),
(17, '2024-11-18', 300000.00, 2),
(18, '2024-11-20', 340000.00, 2),
(19, '2024-11-29', 450000.00, 4),
(20, '2024-11-22', 3400.00, 2),
(21, '2024-11-27', 2700.00, 3),
(22, '2024-11-26', 4500.00, 3),
(23, '2024-11-25', 3003.00, 1),
(24, '2024-11-26', 5000.00, 3);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `statusID` int(11) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`statusID`, `type`) VALUES
(1, 'Ready to Deploy'),
(2, 'Pending'),
(5, 'Deployed'),
(6, 'Active'),
(7, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplierID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `contactName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplierID`, `name`, `address`, `contactName`, `email`, `phone`) VALUES
(1, 'Tech Supplies Co.', '789 Pine St, Galle', 'Alice Brown', 'alice@techsupplies.com', '+94712345678'),
(2, 'Office Equipments Ltd.', '321 Maple St, Jaffna', 'Bob Green', 'bob@officeeq.com', '+94798765432'),
(3, 'Perera Supplies Co.', '789 Pine St, Galle', 'Alice Brown', 'alice@techsupplies.com', '+94712345678'),
(4, 'Pettah Accessories Ltd.', '321 Maple St, Jaffna', 'Bob Green', 'bob@officeeq.com', '+94798765432'),
(5, 'Sena Brothers PVT Ltd', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `loginEnabled` tinyint(1) DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `departmentID` int(11) DEFAULT NULL,
  `statusID` int(11) DEFAULT NULL,
  `locationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `fname`, `lname`, `role`, `email`, `password`, `loginEnabled`, `image`, `departmentID`, `statusID`, `locationID`) VALUES
(1, 'John', 'Doe', 'Admin', 'john.doe@office.com', '$2y$10$cAHAuazZe.fq8UyxpYQLreF4ZHsXQL6GbPm340edaTQrcabKrC0CK', 1, 'john_doe.png', 1, 6, 1),
(2, 'Jane', 'Smitha', 'Employee', 'abc@gmail.com', '$2y$10$yhTAjhZiAYS0TuAMXJu6y.3tOyDush2TitJ/D08Iacxgo..JWkI5K', 1, 'jane_smith.png', 2, 6, 2),
(5, 'cew', 'cw', 'Admin', 'cwe@gmail.com', '$2y$10$10hgbb/3hNeIPpVzDcj4/eHLcOhM94PPCb/hQXfh8bIdV.XQoiNHa', 0, '', 2, 6, 2),
(6, 'dxwe', 'wcwe', 'Employee', 's@gmail.com', '$2y$10$a29L1w/uu7ZGSDjPv0AASuij3KkIr0PqW8nfanMMgOIoRxsy0cInm', 0, '', 1, 7, 1),
(10, 'snipe', '13', 'Admin', 'snipeit@gmail.com', '$2y$10$p0nkZzgjyKdOS/1Id3nB7u2wgf.V9jZQQbtxmfPPZoSfXs5HqsOTu', 1, '', 2, 5, 3),
(11, 'Nimal', 'Perera', 'Employee', 'nimal@gmail.com', '$2y$10$AxmaAOkNlNC3nF.fGdGFYu3YkvrN/qz5Q6kpQoSZ6cPc8IZs9dNhO', 1, '', 1, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `warranty`
--

CREATE TABLE `warranty` (
  `warrantyID` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warranty`
--

INSERT INTO `warranty` (`warrantyID`, `startDate`, `endDate`, `status`) VALUES
(1, '2024-01-01', '2026-01-01', 'Active'),
(2, '2023-06-15', '2025-06-15', 'Active'),
(3, '2024-01-01', '2026-01-01', 'Active'),
(4, '2023-06-15', '2025-06-15', 'Active'),
(5, '2024-11-26', '2026-11-24', NULL),
(6, '2024-11-20', '2026-11-20', NULL),
(7, '2024-11-20', '2026-11-20', NULL),
(8, '2024-11-25', '2026-11-26', NULL),
(9, '2024-11-25', '2026-11-26', NULL),
(10, '2024-11-29', '2027-10-14', NULL),
(11, '2024-11-29', '2024-11-30', NULL),
(12, '2024-11-19', '2026-11-20', NULL),
(13, '2024-11-20', '2026-11-20', NULL),
(14, '2024-11-29', '2027-12-08', NULL),
(15, '2024-11-27', '2025-02-23', NULL),
(16, '2024-11-26', '2025-04-16', NULL),
(17, '2024-11-26', '2026-11-26', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessory`
--
ALTER TABLE `accessory`
  ADD PRIMARY KEY (`accessoryID`),
  ADD KEY `itemID` (`itemID`),
  ADD KEY `warrantyID` (`warrantyID`);

--
-- Indexes for table `asset`
--
ALTER TABLE `asset`
  ADD PRIMARY KEY (`assetID`),
  ADD UNIQUE KEY `assetTag` (`assetTag`),
  ADD KEY `itemID` (`itemID`),
  ADD KEY `warrantyID` (`warrantyID`);

--
-- Indexes for table `assetassignment`
--
ALTER TABLE `assetassignment`
  ADD PRIMARY KEY (`assignmentID`),
  ADD KEY `itemID` (`itemID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `assetassignment_ibfk_3````` (`officeID`),
  ADD KEY `assetassignment_ibfk_4` (`status`);

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`auditID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `component`
--
ALTER TABLE `component`
  ADD PRIMARY KEY (`componentID`),
  ADD KEY `itemID` (`itemID`),
  ADD KEY `warrantyID` (`warrantyID`);

--
-- Indexes for table `consumable`
--
ALTER TABLE `consumable`
  ADD PRIMARY KEY (`consumableID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `officeID` (`officeID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `categoryID` (`categoryID`),
  ADD KEY `manufacturerID` (`manufacturerID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `statusID` (`statusID`),
  ADD KEY `officeID` (`officeID`);

--
-- Indexes for table `license`
--
ALTER TABLE `license`
  ADD PRIMARY KEY (`licenseID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`maintenanceID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`manufacturerID`);

--
-- Indexes for table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`officeID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `supplierID` (`supplierID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`statusID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplierID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `departmentID` (`departmentID`),
  ADD KEY `statusID` (`statusID`),
  ADD KEY `user_ibfk_3` (`locationID`);

--
-- Indexes for table `warranty`
--
ALTER TABLE `warranty`
  ADD PRIMARY KEY (`warrantyID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessory`
--
ALTER TABLE `accessory`
  MODIFY `accessoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `asset`
--
ALTER TABLE `asset`
  MODIFY `assetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `assetassignment`
--
ALTER TABLE `assetassignment`
  MODIFY `assignmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `auditID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `component`
--
ALTER TABLE `component`
  MODIFY `componentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `consumable`
--
ALTER TABLE `consumable`
  MODIFY `consumableID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `license`
--
ALTER TABLE `license`
  MODIFY `licenseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `maintenanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `manufacturerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `office`
--
ALTER TABLE `office`
  MODIFY `officeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `statusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `warranty`
--
ALTER TABLE `warranty`
  MODIFY `warrantyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessory`
--
ALTER TABLE `accessory`
  ADD CONSTRAINT `accessory_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accessory_ibfk_2` FOREIGN KEY (`warrantyID`) REFERENCES `warranty` (`warrantyID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asset`
--
ALTER TABLE `asset`
  ADD CONSTRAINT `asset_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asset_ibfk_2` FOREIGN KEY (`warrantyID`) REFERENCES `warranty` (`warrantyID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assetassignment`
--
ALTER TABLE `assetassignment`
  ADD CONSTRAINT `assetassignment_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assetassignment_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assetassignment_ibfk_3``` FOREIGN KEY (`officeID`) REFERENCES `office` (`officeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `audit`
--
ALTER TABLE `audit`
  ADD CONSTRAINT `audit_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `component`
--
ALTER TABLE `component`
  ADD CONSTRAINT `component_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `component_ibfk_2` FOREIGN KEY (`warrantyID`) REFERENCES `warranty` (`warrantyID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `consumable`
--
ALTER TABLE `consumable`
  ADD CONSTRAINT `consumable_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`officeID`) REFERENCES `office` (`officeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`manufacturerID`) REFERENCES `manufacturer` (`manufacturerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_3` FOREIGN KEY (`orderID`) REFERENCES `order` (`orderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_4` FOREIGN KEY (`statusID`) REFERENCES `status` (`statusID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_5` FOREIGN KEY (`officeID`) REFERENCES `office` (`officeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `license`
--
ALTER TABLE `license`
  ADD CONSTRAINT `license_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`supplierID`) REFERENCES `supplier` (`supplierID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`statusID`) REFERENCES `status` (`statusID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`locationID`) REFERENCES `office` (`officeID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
