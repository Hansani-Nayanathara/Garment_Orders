-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2024 at 09:32 AM
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
-- Database: `garmentcustomers`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `mobile_number` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `action_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `mobile_number`, `name`, `address`, `delivery_date`, `action_by`) VALUES
(1, '1234567890', 'John Doe', '123 Elm St, Springfield', '2024-09-01', NULL),
(2, '0987654321', 'Jane Smith', '456 Oak St, Springfield', '2024-09-05', NULL),
(3, '2345678901', 'Alice Johnson', '789 Maple St, Springfield', NULL, NULL),
(4, '8765432109', 'Bob Brown', '135 Pine St, Springfield', '2024-09-10', NULL),
(5, '3456789012', 'Charlie Davis', '246 Cedar St, Springfield', '2024-09-15', NULL),
(6, '7654321098', 'Emily Wilson', '357 Birch St, Springfield', NULL, NULL),
(7, '4567890123', 'David Miller', '468 Ash St, Springfield', '2024-09-20', NULL),
(8, '6543210987', 'Sophia Taylor', '579 Willow St, Springfield', '2024-09-25', NULL),
(9, '5678901234', 'Liam Moore', '680 Palm St, Springfield', '2024-09-30', NULL),
(10, '5432109876', 'Olivia Anderson', '791 Walnut St, Springfield', NULL, NULL),


-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `total_invoice_amount` decimal(10,2) DEFAULT NULL,
  `advance_paid` decimal(10,2) NOT NULL,
  `estimated_delivery_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `customer_id`, `invoice_number`, `total_invoice_amount`, `advance_paid`, `estimated_delivery_date`) VALUES
(1, 1, 1001, 250.00, 100.00, '2024-09-15'),
(2, 2, 1002, 300.00, 150.00, '2024-09-20'),
(3, 3, 1003, 200.00, 80.00, '2024-09-10'),
(4, 4, 1004, 350.00, 120.00, '2024-09-25'),
(5, 5, 1005, 150.00, 50.00, '2024-09-18'),
(6, 6, 1006, 400.00, 180.00, '2024-09-30'),
(7, 7, 1007, 500.00, 200.00, '2024-09-22'),
(8, 8, 1008, 220.00, 90.00, '2024-09-27'),
(9, 9, 1009, 330.00, 130.00, '2024-10-02'),
(10, 10, 1010, 180.00, 70.00, '2024-09-12'),


--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `mobile_number` (`mobile_number`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
