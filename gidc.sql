-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 14, 2018 at 07:25 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE IF NOT EXISTS `area` (
  `area_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `total_area` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `name`, `total_area`) VALUES
(9, 'Verna', 1200000);

-- --------------------------------------------------------

--
-- Table structure for table `area_rate`
--

CREATE TABLE IF NOT EXISTS `area_rate` (
  `area_rate_id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `area_rate` int(11) NOT NULL,
  `start_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area_rate`
--

INSERT INTO `area_rate` (`area_rate_id`, `area_id`, `area_rate`, `start_date`) VALUES
(1, 9, 1500, '2018-04-11'),
(2, 9, 2000, '2018-04-11'),
(3, 9, 2500, '2018-04-12');

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1523677267),
('company', '22', 1523677340),
('staff', '23', 1523677950);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
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
('accounts', 1, NULL, NULL, NULL, 1523677267, 1523677267),
('admin', 1, NULL, NULL, NULL, 1523677266, 1523677266),
('changePassword', 2, 'Delete User', NULL, NULL, 1523677266, 1523677266),
('company', 1, NULL, NULL, NULL, 1523677267, 1523677267),
('createArea', 2, 'Create a Area', NULL, NULL, 1523677266, 1523677266),
('createCompany', 2, 'Create a Company', NULL, NULL, 1523677266, 1523677266),
('createOrders', 2, 'Create a Orders', NULL, NULL, 1523677266, 1523677266),
('createPlot', 2, 'Create a Plot', NULL, NULL, 1523677266, 1523677266),
('createRate', 2, 'Create a Rate', NULL, NULL, 1523677266, 1523677266),
('createSite', 2, 'Create a Site', NULL, NULL, 1523677266, 1523677266),
('createTax', 2, 'Create a Tax', NULL, NULL, 1523677266, 1523677266),
('createUsers', 2, 'Create a User', NULL, NULL, 1523677266, 1523677266),
('deleteArea', 2, 'Delete Area', NULL, NULL, 1523677266, 1523677266),
('deleteCompany', 2, 'Delete Company', NULL, NULL, 1523677266, 1523677266),
('deleteOrder', 2, 'Delete Order', NULL, NULL, 1523677266, 1523677266),
('deletePlot', 2, 'Delete Plot', NULL, NULL, 1523677266, 1523677266),
('deleteRate', 2, 'Delete Rate', NULL, NULL, 1523677266, 1523677266),
('deleteSite', 2, 'Delete Site', NULL, NULL, 1523677266, 1523677266),
('deleteTax', 2, 'Delete Site', NULL, NULL, 1523677266, 1523677266),
('deleteUsers', 2, 'Delete User', NULL, NULL, 1523677266, 1523677266),
('indexArea', 2, 'Index a Area', NULL, NULL, 1523677266, 1523677266),
('indexCompany', 2, 'Index a Company', NULL, NULL, 1523677266, 1523677266),
('indexOrders', 2, 'Index a Orders', NULL, NULL, 1523677266, 1523677266),
('indexPlot', 2, 'Index a Plot', NULL, NULL, 1523677266, 1523677266),
('indexRate', 2, 'Index a Rate', NULL, NULL, 1523677266, 1523677266),
('indexSite', 2, 'Index a Site', NULL, NULL, 1523677266, 1523677266),
('indexTax', 2, 'Index a Tax', NULL, NULL, 1523677266, 1523677266),
('indexUsers', 2, 'Index a User', NULL, NULL, 1523677266, 1523677266),
('staff', 1, NULL, NULL, NULL, 1523677267, 1523677267),
('updateArea', 2, 'Update Area', NULL, NULL, 1523677266, 1523677266),
('updateCompany', 2, 'Update Company', NULL, NULL, 1523677266, 1523677266),
('updateOrders', 2, 'Update Orders', NULL, NULL, 1523677266, 1523677266),
('updatePlot', 2, 'Update Plot', NULL, NULL, 1523677266, 1523677266),
('updateRate', 2, 'Update Rate', NULL, NULL, 1523677266, 1523677266),
('updateSite', 2, 'Update Site', NULL, NULL, 1523677266, 1523677266),
('updateTax', 2, 'Update Tax', NULL, NULL, 1523677266, 1523677266),
('updateUsers', 2, 'Update User', NULL, NULL, 1523677266, 1523677266),
('viewArea', 2, 'View Area', NULL, NULL, 1523677266, 1523677266),
('viewCompany', 2, NULL, NULL, NULL, 1523677266, 1523677266),
('viewOrders', 2, 'View Orders', NULL, NULL, 1523677266, 1523677266),
('viewOwnCompany', 2, 'Update own post', 'isCompany', NULL, 1523677267, 1523677267),
('viewPlot', 2, 'View Plot', NULL, NULL, 1523677266, 1523677266),
('viewRate', 2, 'View Rate', NULL, NULL, 1523677266, 1523677266),
('viewSite', 2, 'View Site', NULL, NULL, 1523677266, 1523677266),
('viewTax', 2, 'View Tax', NULL, NULL, 1523677266, 1523677266),
('viewUsers', 2, 'View User', NULL, NULL, 1523677266, 1523677266);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'changePassword'),
('company', 'changePassword'),
('staff', 'changePassword'),
('admin', 'createArea'),
('admin', 'createCompany'),
('staff', 'createCompany'),
('admin', 'createOrders'),
('admin', 'createPlot'),
('admin', 'createRate'),
('admin', 'createSite'),
('admin', 'createTax'),
('admin', 'createUsers'),
('admin', 'deleteArea'),
('admin', 'deleteCompany'),
('admin', 'deleteOrder'),
('admin', 'deletePlot'),
('admin', 'deleteRate'),
('admin', 'deleteSite'),
('admin', 'deleteTax'),
('admin', 'deleteUsers'),
('admin', 'indexArea'),
('admin', 'indexCompany'),
('admin', 'indexOrders'),
('admin', 'indexPlot'),
('admin', 'indexRate'),
('admin', 'indexSite'),
('admin', 'indexTax'),
('admin', 'indexUsers'),
('admin', 'updateArea'),
('admin', 'updateCompany'),
('admin', 'updateOrders'),
('admin', 'updatePlot'),
('admin', 'updateRate'),
('admin', 'updateSite'),
('admin', 'updateTax'),
('admin', 'updateUsers'),
('admin', 'viewArea'),
('admin', 'viewCompany'),
('staff', 'viewCompany'),
('viewOwnCompany', 'viewCompany'),
('admin', 'viewOrders'),
('company', 'viewOwnCompany'),
('admin', 'viewPlot'),
('admin', 'viewRate'),
('admin', 'viewSite'),
('admin', 'viewTax'),
('admin', 'viewUsers');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isCompany', 0x4f3a32303a226170705c726261635c436f6d70616e7952756c65223a333a7b733a343a226e616d65223b733a393a226973436f6d70616e79223b733a393a22637265617465644174223b693a313532333637373236373b733a393a22757064617465644174223b693a313532333637373236373b7d, 1523677267, 1523677267);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`user_id`, `company_id`, `name`, `address`, `remark`, `constitution`, `products`, `gstin`, `owner_name`, `owner_phone`, `owner_mobile`, `competent_name`, `competent_email`, `competent_mobile`) VALUES
(1, 1, 'Google Developers Group', 'Verna, Plot No. 35A, 66 B', '', 'Partnership', 'M. S Barrels', '78SJABSJSBBA76', 'Micheal Jackson', '2706542', '9885412565', 'John Doe', 'john@doe.com', '9865214587'),
(2, 2, 'Cipla', 'Plot No 23, 22 Verna Goa', '', 'Pvt. Ltd', 'Printed Corrugated Cartoons', 'BKJK123K1K23KB', 'James Blunt', '2706744', '9865412547', 'Jan Doe', 'jan@dow.com', '9652147852'),
(4, 3, 'Chowgule FOSS Club', 'Colmorod Residential Complex, Flat S2', '', 'Pvt. Ltd', 'Printed Corrugated Cartoons', 'asv213kkasn1231', 'Aloysius', '9604107696', '9604107696', 'Jan Doe', 'castorgodinho22@gmail.com', '9604107696'),
(11, 4, 'Chowgule FOSS Club', 'Colmorod Residential Complex, Flat S2', '', 'Pvt. Ltd', 'Printed Corrugated Cartoons', '21hkjh312hlh12l', 'Aloysius', '9604107696', '9604107696', 'Jan Doe', 'castorgodinho22@gmail.com', '9604107696'),
(16, 5, 'Cocacola', 'Colmorod Residential Complex, Flat S2', '', 'Pvt. Ltd', 'Printed Corrugated Cartoons', 'sdasdf23wda', 'Aloysius', '9604107696', '9604107696', 'Jan Doe', 'castorgodinho22@gmail.com', '9604107696'),
(18, 6, 'Lays Chips', 'Colmorod Residential Complex, Flat S2', '', 'Pvt. Ltd', 'Printed Corrugated Cartoons', 'sadasd2321asd', 'Aloysius', '9604107696', '9604107696', 'Jan Doe', 'castorgodinho22@gmail.com', '9604107696'),
(19, 7, 'Lays Chips', 'Colmorod Residential Complex, Flat S2', '', 'Pvt. Ltd', 'Printed Corrugated Cartoons', 'sadasd2321asd', 'Aloysius', '9604107696', '9604107696', 'Jan Doe', 'castorgodinho22@gmail.com', '9604107696'),
(22, 8, 'Chowgules', 'Colmorod Residential Complex, Flat S2', '', 'Pvt. Ltd', 'Printed Corrugated Cartoons', 'dasdasfsa234', 'Aloysius', '9604107696', '9604107696', 'Jan Doe', 'castorgodinho22@gmail.com', '9604107696');

-- --------------------------------------------------------

--
-- Table structure for table `interest`
--

CREATE TABLE IF NOT EXISTS `interest` (
  `interest_id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `interest`
--

INSERT INTO `interest` (`interest_id`, `name`, `type`, `rate`, `start_date`) VALUES
(1, 'Penal Interest', 'Penal Interest', 10, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int(11) NOT NULL,
  `rate_id` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `interest_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `invoice_code` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `rate_id`, `tax_id`, `order_id`, `interest_id`, `start_date`, `total_amount`, `invoice_code`) VALUES
(1, 1, 1, 38, 1, '2018-04-14', 586051, ''),
(2, 1, 1, 38, 1, '2018-04-14', 586051, ''),
(3, 1, 1, 38, 1, '2018-04-14', 586051, ''),
(4, 1, 1, 38, 1, '2018-04-14', 586051, ''),
(5, 1, 1, 38, 1, '2018-04-14', 586051, '');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
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

CREATE TABLE IF NOT EXISTS `orders` (
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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `company_id`, `built_area`, `shed_area`, `godown_area`, `start_date`, `end_date`, `shed_no`, `godown_no`, `area_id`, `total_area`) VALUES
(19, 'GIDC12345VERNA', 2, NULL, NULL, 121, '2018-04-30', NULL, NULL, 520, 9, 0),
(20, 'GIDC12345VERNA', 1, 1500, NULL, NULL, '2018-04-13', NULL, NULL, NULL, 9, 150000),
(21, 'GIDC1235VERNA', 2, NULL, 10000, NULL, '2018-04-12', NULL, 43, NULL, 9, 50000),
(22, 'GIDC12345VERNA', 1, NULL, NULL, 10, '2018-04-16', NULL, NULL, 10, 9, 12000),
(23, 'GIDC12345VERNA', 1, NULL, NULL, NULL, '2018-04-18', NULL, NULL, NULL, 9, 1500),
(24, 'GIDC12345VERNA', 1, 5000, NULL, NULL, '2018-04-18', NULL, NULL, NULL, 9, 1500),
(25, 'GIDC1234s5VERNA', 1, NULL, NULL, 1221, '2018-04-17', NULL, NULL, 121212, 9, 1500),
(26, 'GIDC12345VERNA', 1, NULL, NULL, 21, '2018-04-17', NULL, NULL, 123213, 9, 123123),
(27, 'GIDC12345VERNA', 1, NULL, NULL, 123312, '2018-04-16', NULL, NULL, 12, 9, 1500),
(28, 'GIDC12345VERNA', 1, NULL, NULL, 121221, '2018-04-10', NULL, NULL, 212, 9, 1500),
(29, 'GIDC12345VERNA', 1, NULL, NULL, 121221, '2018-04-10', NULL, NULL, 212, 9, 1500),
(30, 'GIDC12345VERNA', 1, NULL, NULL, 121221, '2018-04-10', NULL, NULL, 212, 9, 1500),
(31, 'GIDC12345VERNA', 1, NULL, NULL, 121221, '2018-04-10', NULL, NULL, 212, 9, 1500),
(32, 'GIDC12345VERNA', 1, NULL, NULL, 121221, '2018-04-10', NULL, NULL, 212, 9, 1500),
(33, 'GIDC12345VERNAe', 1, NULL, NULL, 21323, '0000-00-00', NULL, NULL, 12, 9, 1232),
(34, 'GIDC12345VERNA', 1, NULL, NULL, 31221, '2018-04-23', NULL, NULL, 12, 9, 12312),
(35, 'GIDC12345VERNA', 1, NULL, NULL, 31221, '2018-04-23', NULL, NULL, 12, 9, 12312),
(36, 'GIDC12345VeeERNA', 1, NULL, NULL, 31221, '2018-04-23', NULL, NULL, 12, 9, 12312),
(37, 'GIDC12345VeeERNA', 1, NULL, NULL, 31221, '2018-04-23', NULL, NULL, 12, 9, 12312),
(38, 'GIDC12345VeeeERNA', 1, NULL, NULL, 31221, '2018-04-23', NULL, NULL, 12, 9, 12312);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `plot_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`plot_id`, `order_id`) VALUES
(7, 19),
(8, 19),
(9, 19),
(10, 20),
(11, 20),
(12, 20),
(13, 21),
(14, 21),
(15, 22),
(16, 22),
(17, 23),
(18, 24),
(19, 25),
(20, 25),
(21, 26),
(22, 27),
(23, 27),
(24, 28),
(25, 28),
(26, 29),
(27, 30),
(28, 31),
(29, 32),
(30, 33),
(31, 34),
(32, 35),
(33, 36),
(34, 37),
(35, 38);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `mode` varchar(50) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plot`
--

CREATE TABLE IF NOT EXISTS `plot` (
  `plot_id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `area_of_plot` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plot`
--

INSERT INTO `plot` (`plot_id`, `area_id`, `name`, `area_of_plot`) VALUES
(6, NULL, '22', 0),
(7, NULL, '11', 0),
(8, NULL, '22', 0),
(9, NULL, '33', 0),
(10, NULL, '56', 0),
(11, NULL, '44', 0),
(12, NULL, '33', 0),
(13, 9, '10', 0),
(14, 9, '20', 0),
(15, 9, '43', 0),
(16, 9, '21', 0),
(17, 9, '10', 0),
(18, 9, '10', 0),
(19, 9, '12', 0),
(20, 9, '12', 0),
(21, 9, '12', 0),
(22, 9, '12', 0),
(23, 9, '22', 0),
(24, 9, '12', 0),
(25, 9, '22', 0),
(26, 9, '12', 0),
(27, 9, '12', 0),
(28, 9, '12', 0),
(29, 9, '12', 0),
(30, 9, '10', 0),
(31, 9, '22', 0),
(32, 9, '22', 0),
(33, 9, '22', 0),
(34, 9, '22', 0),
(35, 9, '22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
  `rate_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `from_area` int(11) NOT NULL,
  `to_area` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`rate_id`, `area_id`, `from_area`, `to_area`, `rate`, `date`) VALUES
(1, 9, 0, 10000000, 40, '2018-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE IF NOT EXISTS `tax` (
  `tax_id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `rate` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`tax_id`, `name`, `rate`, `date`) VALUES
(1, 'GST', 19, '2018-04-14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `type`) VALUES
(1, 'castorgodinho@yahoo.in', '$2y$13$HJcuDsYRJKn5pqgpZwZ3.ekJwMT9RTL/ZAd2a3pkkOhQvNoVwh5e.', NULL),
(2, 'cipla@gmail.com', '$2y$13$2d9TMNV9H0iIKFQCAgJjIOlbVCdfVbPCH7EI05JpPrOaC5wY6KX8e', NULL),
(3, 'castorgodinho22@gmail.com', '$2y$13$gIHTyS5ZEuV30AWnKjSuXu0gJKJZGtfGclOpoTFeNvV1mdokmmXNi', NULL),
(4, 'castorgodinho22@gmail.com', '$2y$13$Dxlpc5szm6LNu76ysJSc2utCU8s/I0MpYdfQQa4H2/n0T5HWOEVjm', NULL),
(5, 'castorgodinho22@gmail.com', '$2y$13$or66jg9R9DJKdYFwltaHQuTF.L0mu4xOpFypnb4cbY0EpcLpG2fcO', NULL),
(6, 'castor@gmail.com', '$2y$13$VFTa2yVTN2M8a6BY6GQjgOj0g7l9dGwZpLTCz7f/HeFlD9MPmTKpC', NULL),
(7, 'castorgodin@gmail.com', '$2y$13$1ZrtybbgMgiz5vn4I0bGE.R731p41YSo8GNxQ0kAovKV64REZ4zvW', 'accounts'),
(8, 'castorgowdin@gmail.com', '$2y$13$DMNgejEusdkGS9XH.Vm2t.wXCm0uym1ouzA5cNbtLb1IbmgvZHS8m', 'staff'),
(9, 'asd@ads', '$2y$13$f85OIWZi3s7BRuZUB/sjCuBUUmthIQx7hZXg/zImDsbT4KnbhVMjK', 'accounts'),
(10, 'das@das', '$2y$13$sGupCVbzi4CdgbXpJkex9e91c9HswSELebazMOpwWUkh.KXXj4jT.', 'admin'),
(11, 'castorgodinho@gmail.com', '$2y$13$13W6wQPh8LD0TU1dLoC5ZupLX/uxsQ9yWdLwZ5UyEQkDH./T.ctsi', NULL),
(12, 'cas@gas.com', '$2y$13$Zxl3lgj4FqVQh/Nk3pK4q.oWkLYa9yWgteSpdS44BfqvdWy.MDtIi', 'accounts'),
(16, 'coca@cola.com', '$2y$13$3lCWbr7wFuBTL5ei3U5GKeqwR8Lsaa74eRHYQWHNDXZRa8Nd223ia', NULL),
(18, 'castorgodinho22@gmail.com', '$2y$13$AXCLnbWydKcySdqxThMA0OV1SJ.LucYeYMUd/ca0ZTr/KyK8p4VsO', NULL),
(19, 'castorgodinho22@gmail.com', '$2y$13$KnVWvobF5gb4pa8hR5Q/luKk3Rh2DQNWNiXkiDHKjLXSl/fkbzl0S', 'company'),
(22, 'cass@gmail.com', '$2y$13$VBqE08Wjmfa25iKqUZWgU.bbR4wx2YmUUun6gSMpX1awfxeFfpfvi', 'company'),
(23, 'ccg003@gmail.com', '$2y$13$IpLcpvRdMi7VdWBfNpqjl.m5NEC026kdIFl4B38Q9Ym0M0uBwik0C', 'staff');

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
  ADD KEY `payment_order_id` (`order_id`),
  ADD KEY `payment_invoice_id` (`invoice_id`);

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
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `area_rate`
--
ALTER TABLE `area_rate`
  MODIFY `area_rate_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `interest`
--
ALTER TABLE `interest`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `plot`
--
ALTER TABLE `plot`
  MODIFY `plot_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
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
  ADD CONSTRAINT `payment_invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`),
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
