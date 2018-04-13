-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 12, 2018 at 12:37 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gidc`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `area_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `total_area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `name`, `total_area`) VALUES
(9, 'Verna', 1200000);

-- --------------------------------------------------------

--
-- Table structure for table `area_rate`
--

CREATE TABLE `area_rate` (
  `area_rate_id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `area_rate` int(11) NOT NULL,
  `start_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area_rate`
--

INSERT INTO `area_rate` (`area_rate_id`, `area_id`, `area_rate`, `start_date`) VALUES
(1, 9, 1500, '2018-04-11'),
(2, 9, 2000, '2018-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('company', '1', 1523510933);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('company', 1, NULL, NULL, NULL, 1523510933, 1523510933),
('createCompany', 2, 'Create a Company', NULL, NULL, 1523510933, 1523510933),
('deleteCompany', 2, 'Delete Company', NULL, NULL, 1523510933, 1523510933),
('updateCompany', 2, 'Update Company', NULL, NULL, 1523510933, 1523510933),
('viewCompany', 2, NULL, NULL, NULL, 1523510933, 1523510933);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('company', 'updateCompany'),
('company', 'viewCompany');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `remark` varchar(150) NOT NULL,
  `constitution` varchar(60) DEFAULT NULL,
  `products` varchar(60) DEFAULT NULL,
  `gstin` varchar(30) DEFAULT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `owner_phone` varchar(10) DEFAULT NULL,
  `owner_mobile` varchar(10) DEFAULT NULL,
  `competent_name` varchar(100) DEFAULT NULL,
  `competent_email` varchar(100) DEFAULT NULL,
  `competent_mobile` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`user_id`, `company_id`, `name`, `address`, `remark`, `constitution`, `products`, `gstin`, `owner_name`, `owner_phone`, `owner_mobile`, `competent_name`, `competent_email`, `competent_mobile`) VALUES
(1, 1, 'Google Developers Group', 'Verna, Plot No. 35A, 66 B', '', 'Partnership', 'M. S Barrels', '78SJABSJSBBA76', 'Micheal Jackson', '2706542', '9885412565', 'John Doe', 'john@doe.com', '9865214587'),
(2, 2, 'Cipla', 'Plot No 23, 22 Verna Goa', '', 'Pvt. Ltd', 'Printed Corrugated Cartoons', 'BKJK123K1K23KB', 'James Blunt', '2706744', '9865412547', 'Jan Doe', 'jan@dow.com', '9652147852');

-- --------------------------------------------------------

--
-- Table structure for table `interest`
--

CREATE TABLE `interest` (
  `interest_id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `rate_id` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `interest_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1523509687),
('m140506_102106_rbac_init', 1523509768),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1523509768);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_number` varchar(20) NOT NULL,
  `company_id` int(11) NOT NULL,
  `built_area` int(11) DEFAULT NULL,
  `shed_area` int(11) DEFAULT NULL,
  `godown_area` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `shed_no` int(11) DEFAULT NULL,
  `godown_no` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `total_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `company_id`, `built_area`, `shed_area`, `godown_area`, `start_date`, `end_date`, `shed_no`, `godown_no`, `area_id`, `total_area`) VALUES
(19, 'GIDC12345VERNA', 2, NULL, NULL, 121, '2018-04-30', NULL, NULL, 520, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `plot_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`plot_id`, `order_id`) VALUES
(7, 19),
(8, 19),
(9, 19);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `mode` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plot`
--

CREATE TABLE `plot` (
  `plot_id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `area_of_plot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plot`
--

INSERT INTO `plot` (`plot_id`, `area_id`, `name`, `area_of_plot`) VALUES
(6, NULL, '22', 0),
(7, NULL, '11', 0),
(8, NULL, '22', 0),
(9, NULL, '33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `rate_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `from_area` int(11) NOT NULL,
  `to_area` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `tax_id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `rate` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`) VALUES
(1, 'castorgodinho@yahoo.in', '$2y$13$HJcuDsYRJKn5pqgpZwZ3.ekJwMT9RTL/ZAd2a3pkkOhQvNoVwh5e.'),
(2, 'cipla@gmail.com', '$2y$13$2d9TMNV9H0iIKFQCAgJjIOlbVCdfVbPCH7EI05JpPrOaC5wY6KX8e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `area_rate`
--
ALTER TABLE `area_rate`
  ADD PRIMARY KEY (`area_rate_id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `company_fk_user_id` (`user_id`);

--
-- Indexes for table `interest`
--
ALTER TABLE `interest`
  ADD PRIMARY KEY (`interest_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `invoice_rate_id` (`rate_id`),
  ADD KEY `invoice_tax_id` (`tax_id`),
  ADD KEY `invoice_order` (`order_id`),
  ADD KEY `invoice_interest` (`interest_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders_fk_company_id` (`company_id`),
  ADD KEY `orders_area_id` (`area_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`plot_id`,`order_id`),
  ADD KEY `order_details_order_id` (`order_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payment_order_id` (`order_id`);

--
-- Indexes for table `plot`
--
ALTER TABLE `plot`
  ADD PRIMARY KEY (`plot_id`),
  ADD KEY `plot_fk_area_id` (`area_id`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`rate_id`),
  ADD KEY `rate_fk_area_id` (`area_id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `area_rate`
--
ALTER TABLE `area_rate`
  MODIFY `area_rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `interest`
--
ALTER TABLE `interest`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plot`
--
ALTER TABLE `plot`
  MODIFY `plot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_interest` FOREIGN KEY (`interest_id`) REFERENCES `interest` (`interest_id`),
  ADD CONSTRAINT `invoice_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `invoice_rate_id` FOREIGN KEY (`rate_id`) REFERENCES `rate` (`rate_id`),
  ADD CONSTRAINT `invoice_tax_id` FOREIGN KEY (`tax_id`) REFERENCES `tax` (`tax_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_area_id` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`),
  ADD CONSTRAINT `orders_fk_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_plot_id` FOREIGN KEY (`plot_id`) REFERENCES `plot` (`plot_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `plot`
--
ALTER TABLE `plot`
  ADD CONSTRAINT `plot_fk_area_id` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`);

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_fk_area_id` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
