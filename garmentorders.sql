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
-- Database: `garmentorders`
--

-- --------------------------------------------------------

--
-- Table structure for table `design_specification`
--

CREATE TABLE `design_specification` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `collar_type` varchar(255) DEFAULT NULL,
  `button` tinyint(1) DEFAULT 0,
  `qty` int(11) NOT NULL,
  `placket_color` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `design_specification`
--

INSERT INTO `design_specification` (`id`, `order_id`, `product_type`, `collar_type`, `button`, `qty`, `placket_color`, `tag`) VALUES
(1, 1, 'Adult T-shirts', 'Classic', 1, 50, 'White', 'Brand Name, Size, Logo'),
(2, 2, 'Adult T-shirts', 'None', 0, 60, 'Black', 'Size, Logo'),
(3, 3, 'Adult Shorts & Bottoms', NULL, 0, 20, NULL, NULL),
(4, 4, 'Kids T-shirts', 'High Collar', 1, 40, 'Blue', 'Brand Name, Size, Logo, Promotion'),
(5, 5, 'Adult Shorts & Bottoms', NULL, 0, 30, NULL, NULL),
(6, 6, 'Kids T-shirts', 'V-Neck', 1, 25, 'Pink', 'Size, Logo'),
(7, 7, 'Other Types', NULL, 0, 55, NULL, NULL),
(8, 8, 'Kids Shorts & Bottoms', NULL, 0, 15, NULL, NULL),
(9, 9, 'Other Types', NULL, 0, 35, NULL, NULL),
(10, 10, 'Kids Shorts & Bottoms', NULL, 0, 45, NULL, NULL),
(11, NULL, NULL, 'Full', 1, 10, NULL, NULL),
(12, NULL, NULL, 'half', 0, 5, NULL, NULL),
(13, NULL, NULL, 'semi', 0, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `extra_details`
--

CREATE TABLE `extra_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `sleeve_type` varchar(50) DEFAULT NULL,
  `need_bottoms` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `extra_details`
--

INSERT INTO `extra_details` (`id`, `order_id`, `name`, `number`, `size`, `sleeve_type`, `need_bottoms`) VALUES
(1, 1, 'John', '25', 'M', 'Half', NULL),
(2, 2, 'Jane', '49', 'L', 'Full', NULL),
(3, 3, 'Alice', '10', 'S', NULL, NULL),
(4, 4, 'Bob', '99', 'XL', 'Sleeveless', NULL),
(5, 5, 'Charlie', '46', 'M', NULL, NULL),
(6, 6, 'Emily', '25', 'S', 'Half', NULL),
(7, 7, 'David', '09', 'L', NULL, NULL),
(8, 8, 'Sophia', '20', 'M', NULL, NULL),
(9, 9, 'Liam', '69', 'XL', NULL, NULL),
(10, 10, 'Olivia', '88', 'M', NULL, NULL),


-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `Other_type` varchar(255) DEFAULT NULL,
  `size` text DEFAULT NULL,
  `sleeve_type` varchar(50) DEFAULT NULL,
  `length` text DEFAULT NULL,
  `total_qty` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `action_by` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `product_type`, `Other_type`, `size`, `sleeve_type`, `length`, `total_qty`, `image`, `description`, `action_by`, `customer_id`) VALUES
(1, 'Adult T-shirts', NULL, 'M', 'Half', NULL, '50', 'tshirt1.jpg', NULL, NULL, NULL),
(2, 'Adult T-shirts', NULL, 'L', 'Full', NULL, '60', 'tshirt2.jpg', NULL, NULL, NULL),
(3, 'Adult Shorts & Bottoms', NULL, 'S', NULL, '45', '20', 'short1.jpg', NULL, NULL, NULL),
(4, 'Kids T-shirts', NULL, 'XL', 'Sleeveless', NULL, '40', 'tshirt3.jpg', NULL, NULL, NULL),
(5, 'Adult Shorts & Bottoms', NULL, 'M', NULL, '42', '30', 'short2.jpg', NULL, NULL, NULL),
(6, 'Kids T-shirts', NULL, 'S', 'Half', NULL, '25', 'tshirt4.jpg', NULL, NULL, NULL),
(7, 'Other Types', NULL, 'L', NULL, NULL, '55', 'flag1.jpg', 'Cozy long flag', NULL, NULL),
(8, 'Kids Shorts & Bottoms', NULL, 'M', NULL, '22', '15', 'short3.jpg', NULL, NULL, NULL),
(9, 'Other Types', NULL, 'XL', NULL, NULL, '35', 'flag2.jpg', 'Heavy long flag', NULL, NULL),
(10, 'Kids Shorts & Bottoms', NULL, 'M', NULL, '39', '45', 'short4.jpg', NULL, NULL, NULL),


--
-- Indexes for dumped tables
--

--
-- Indexes for table `design_specification`
--
ALTER TABLE `design_specification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`,`product_type`);

--
-- Indexes for table `extra_details`
--
ALTER TABLE `extra_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`,`product_type`),
  ADD KEY `fk_customer` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `design_specification`
--
ALTER TABLE `design_specification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `extra_details`
--
ALTER TABLE `extra_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `design_specification`
--
ALTER TABLE `design_specification`
  ADD CONSTRAINT `design_specification_ibfk_1` FOREIGN KEY (`order_id`,`product_type`) REFERENCES `orders` (`order_id`, `product_type`);

--
-- Constraints for table `extra_details`
--
ALTER TABLE `extra_details`
  ADD CONSTRAINT `extra_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `garmentcustomers`.`customers` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
