-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2025 at 04:13 PM
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
-- Database: `farm`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `c_add` text NOT NULL,
  `c_tel` varchar(10) NOT NULL,
  `c_name` varchar(50) NOT NULL,
  `em_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `c_add`, `c_tel`, `c_name`, `em_id`) VALUES
(1, '123 หมู่ 1 ตำบลเมือง อำเภอเมือง จังหวัดภูเก็ต', '0812345677', 'นายอาทิตย์ กิจดี', 1),
(2, '456 หมู่ 2 ตำบลป่าตอง อำเภอกะทู้ จังหวัดภูเก็ต', '0822345678', 'นางสาวธัญญา สมสุข', 2),
(3, '789 หมู่ 3 ตำบลเชิงทะเล อำเภอถลาง จังหวัดภูเก็ต', '0832345678', 'นายดนชัย มั่นคง', 3),
(4, '101 หมู่ 4 ตำบลราไวย์ อำเภอเมือง จังหวัดภูเก็ต', '0842345678', 'นางสาวพัชรี บริสุทธิ์', 4),
(5, '202 หมู่ 5 ตำบลวิชิต อำเภอเมือง จังหวัดภูเก็ต', '0852345678', 'นายกิตติพงษ์ ทองประเสริฐ', 5),
(6, '303 หมู่ 6 ตำบลฉลอง อำเภอเมือง จังหวัดภูเก็ต', '0862345678', 'นางสาวศิริวรรณ กล้าหาญ', 6),
(7, '404 หมู่ 7 ตำบลกะรน อำเภอเมือง จังหวัดภูเก็ต', '0872345678', 'นายภัทรชัย เจริญกุล', 7),
(8, '505 หมู่ 8 ตำบลกมลา อำเภอกะทู้ จังหวัดภูเก็ต', '0882345678', 'นางสาวธิดารัตน์ พงษ์ศรี', 8);

-- --------------------------------------------------------

--
-- Table structure for table `daily_rubber_price`
--

CREATE TABLE `daily_rubber_price` (
  `id` int(11) NOT NULL,
  `price_date` date NOT NULL,
  `price_per_kg` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_rubber_price`
--

INSERT INTO `daily_rubber_price` (`id`, `price_date`, `price_per_kg`) VALUES
(2, '2025-04-09', 50.00),
(3, '2025-04-10', 50.00),
(4, '2025-04-11', 20.00),
(5, '2025-04-12', 42.00),
(6, '2025-04-13', 51.00),
(7, '2025-05-01', 34.00),
(8, '0000-00-00', 42.00),
(9, '2025-04-17', 85.00),
(10, '2025-07-04', 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `em_id` int(10) NOT NULL,
  `em_name` varchar(50) NOT NULL,
  `em_add` text NOT NULL,
  `em_tel` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`em_id`, `em_name`, `em_add`, `em_tel`) VALUES
(1, 'นายสมชาย ใจดี', '123 หมู่ 1 ต.ในเมือง อ.เมือง จ.กรุงเทพมหานคร', 812345678),
(2, 'นางสาวสุนีย์ สุขใจ', '456 หมู่ 2 ต.บางพลี อ.บางพลี จ.สมุทรปราการ', 823456789),
(3, 'นายสมศักดิ์ พัฒนกุล', '789 หมู่ 3 ต.บางบอน อ.บางบอน จ.กรุงเทพมหานคร', 834567890),
(4, 'นางสาวสุกัญญา ทองดี', '101 หมู่ 4 ต.บางขุนเทียน อ.บางขุนเทียน จ.กรุงเทพมหานคร', 845678901),
(5, 'นายอนันต์ ชื่นจิต', '202 หมู่ 5 ต.บางนา อ.บางนา จ.กรุงเทพมหานคร', 856789012),
(6, 'นางสาวอรทัย ศรีสุข', '303 หมู่ 6 ต.บางกอกน้อย อ.บางกอกน้อย จ.กรุงเทพมหานคร', 867890123),
(7, 'นายวิชัย แซ่ตั้ง', '404 หมู่ 7 ต.บางกอกใหญ่ อ.บางกอกใหญ่ จ.กรุงเทพมหานคร', 878901234),
(8, 'นางสาวจิตรา บุญมา', '505 หมู่ 8 ต.บางพลัด อ.บางพลัด จ.กรุงเทพมหานคร', 889012345),
(9, 'นายเกรียงไกร ทวีสุข', '606 หมู่ 9 ต.บางซื่อ อ.บางซื่อ จ.กรุงเทพมหานคร', 890123456),
(10, 'นางสาวมาลินี วัฒนกุล', '707 หมู่ 10 ต.บางรัก อ.บางรัก จ.กรุงเทพมหานคร', 901234567);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `em_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `employer_share` decimal(10,2) DEFAULT NULL,
  `employee_share` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `c_id`, `em_id`, `total_amount`, `employer_share`, `employee_share`) VALUES
(1, 1, 1, 6000.00, 3300.00, 2700.00),
(2, 2, 2, 8000.00, 5600.00, 2400.00),
(3, 3, 3, 4000.00, 2000.00, 2000.00),
(4, 3, 3, 8500.00, 4250.00, 4250.00),
(5, 1, 1, 4000.00, 2400.00, 1600.00);

-- --------------------------------------------------------

--
-- Table structure for table `rubber_receiving`
--

CREATE TABLE `rubber_receiving` (
  `rr_order` int(11) UNSIGNED NOT NULL,
  `rr_id` int(11) UNSIGNED DEFAULT NULL,
  `c_id` int(11) NOT NULL,
  `em_id` int(10) NOT NULL,
  `rr_date` date DEFAULT NULL,
  `rr_quantity` decimal(10,2) DEFAULT NULL,
  `rr_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rubber_receiving`
--

INSERT INTO `rubber_receiving` (`rr_order`, `rr_id`, `c_id`, `em_id`, `rr_date`, `rr_quantity`, `rr_price`, `total_price`) VALUES
(1, NULL, 1, 1, '2025-04-09', 300.00, 50.00, 15000.00),
(2, NULL, 3, 3, '2025-04-09', 200.00, 50.00, 10000.00),
(3, NULL, 2, 2, '2025-04-09', 100.00, 50.00, 5000.00),
(4, NULL, 6, 6, '2025-04-10', 200.00, 30.00, 6000.00),
(5, NULL, 3, 3, '2025-05-01', 300.00, 34.00, 10200.00),
(6, NULL, 3, 3, '2025-04-10', 100.00, 40.00, 4000.00),
(7, NULL, 1, 1, '2025-04-10', 300.00, 40.00, 12000.00),
(8, NULL, 7, 7, '2025-04-10', 100.00, 50.00, 5000.00),
(9, NULL, 1, 1, '2025-04-11', 300.00, 20.00, 6000.00),
(10, NULL, 2, 2, '2025-04-11', 400.00, 20.00, 8000.00),
(11, NULL, 3, 3, '2025-04-11', 200.00, 20.00, 4000.00),
(12, NULL, 3, 3, '2025-04-17', 100.00, 85.00, 8500.00),
(13, NULL, 1, 1, '2025-07-04', 100.00, 40.00, 4000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `ลูกจ้าง` (`em_id`);

--
-- Indexes for table `daily_rubber_price`
--
ALTER TABLE `daily_rubber_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`em_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `em_id` (`em_id`);

--
-- Indexes for table `rubber_receiving`
--
ALTER TABLE `rubber_receiving`
  ADD PRIMARY KEY (`rr_order`),
  ADD KEY `rubber_receiving_ibfk_1` (`c_id`),
  ADD KEY `rubber_receiving_ibfk_2` (`em_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_rubber_price`
--
ALTER TABLE `daily_rubber_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rubber_receiving`
--
ALTER TABLE `rubber_receiving`
  MODIFY `rr_order` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `ลูกจ้าง` FOREIGN KEY (`em_id`) REFERENCES `employee` (`em_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`em_id`) REFERENCES `employee` (`em_id`);

--
-- Constraints for table `rubber_receiving`
--
ALTER TABLE `rubber_receiving`
  ADD CONSTRAINT `rubber_receiving_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rubber_receiving_ibfk_2` FOREIGN KEY (`em_id`) REFERENCES `employee` (`em_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
