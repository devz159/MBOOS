-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2013 at 11:23 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mboos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('8d0e81eb1b1078b22e7fcc55f8a96da7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:16.0) Gecko/20100101 Firefox/16.0', 1354262842, ''),
('c4ef93987d34ae0d820ad54d57f67d28', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:16.0) Gecko/20100101 Firefox/16.0', 1354132870, 'a:3:{s:15:"SADMIN_USERNAME";s:7:"ianpaul";s:17:"SADMIN_ISLOGGEDIN";b:1;s:11:"SADMIN_ULVL";s:1:"1";}');

-- --------------------------------------------------------

--
-- Table structure for table `mboos_customers`
--

DROP TABLE IF EXISTS `mboos_customers`;
CREATE TABLE IF NOT EXISTS `mboos_customers` (
  `mboos_customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_customer_complete_name` varchar(60) DEFAULT NULL,
  `mboos_customer_addr` varchar(100) NOT NULL,
  `mboos_customer_email` varchar(50) NOT NULL,
  `mboos_customer_pword` varchar(100) NOT NULL,
  `mboos_customer_phone` varchar(50) DEFAULT NULL,
  `mboos_customer_status` enum('1','0') DEFAULT '1',
  PRIMARY KEY (`mboos_customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `mboos_customers`
--

INSERT INTO `mboos_customers` (`mboos_customer_id`, `mboos_customer_complete_name`, `mboos_customer_addr`, `mboos_customer_email`, `mboos_customer_pword`, `mboos_customer_phone`, `mboos_customer_status`) VALUES
(1, 'Ian Paul', 'CDO', 'ian_kionisala@yahoo.com', '25d55ad283aa400af464c76d713c07ad', '09275495240', '1'),
(2, 'ian paul kionisala', 'cdo', 'iankionisala@yahoo.com', '', '09275495240', '1'),
(3, 'Ian Paul Kionisala', 'cdo', 'ianpaul@gmail.com', '25d55ad283aa400af464c76d713c07ad', '09275495240', '1'),
(4, 'marc hergene piedad', 'cdo', 'marc@gmail.com', '25d55ad283aa400af464c76d713c07ad', '09271111222', '1'),
(5, 'deo along', 'cdo', 'deo@gmail.com', '25d55ad283aa400af464c76d713c07ad', '09261234586', '1'),
(6, 'Kenneth Vallejos', 'cugman', 'kenn_vall@yahoo.com', 'dc891be1dea8d9a2406674e135dbd4ff', '7255435395148000002', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mboos_instocks`
--

DROP TABLE IF EXISTS `mboos_instocks`;
CREATE TABLE IF NOT EXISTS `mboos_instocks` (
  `mboos_inStocks_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_inStocks_quantity` varchar(50) DEFAULT NULL,
  `mboos_inStocks_date` datetime DEFAULT NULL,
  `mboos_inStocks_status` enum('1','0') DEFAULT '1',
  `mboos_product_id` int(11) DEFAULT NULL,
  `mboos_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`mboos_inStocks_id`),
  KEY `mboos_product_id` (`mboos_product_id`),
  KEY `mboos_user_id` (`mboos_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mboos_instocks`
--

INSERT INTO `mboos_instocks` (`mboos_inStocks_id`, `mboos_inStocks_quantity`, `mboos_inStocks_date`, `mboos_inStocks_status`, `mboos_product_id`, `mboos_user_id`) VALUES
(1, '5', '2013-02-01 00:00:00', '1', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mboos_orders`
--

DROP TABLE IF EXISTS `mboos_orders`;
CREATE TABLE IF NOT EXISTS `mboos_orders` (
  `mboos_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_order_date` datetime DEFAULT NULL,
  `mboos_order_pick_schedule` datetime DEFAULT NULL,
  `mboos_orders_total_price` double(16,2) NOT NULL,
  `mboos_order_status` enum('1','0') DEFAULT '1',
  `mboos_customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`mboos_order_id`),
  KEY `mboos_customer_id` (`mboos_customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `mboos_orders`
--

INSERT INTO `mboos_orders` (`mboos_order_id`, `mboos_order_date`, `mboos_order_pick_schedule`, `mboos_orders_total_price`, `mboos_order_status`, `mboos_customer_id`) VALUES
(1, '2013-01-25 08:00:00', '2013-01-28 08:15:00', 36.00, '1', 1),
(2, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 100.00, '1', 1),
(3, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 100.00, '1', 1),
(4, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 0.00, '1', 0),
(5, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 0.00, '1', 0),
(6, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 0.00, '1', 0),
(7, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 0.00, '1', 0),
(8, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 0.00, '1', 0),
(9, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 0.00, '1', 0),
(10, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 0.00, '1', 0),
(11, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 0.00, '1', 0),
(12, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 0.00, '1', 0),
(13, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 100.00, '1', 1),
(14, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 100.00, '1', 1),
(15, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 100.00, '1', 1),
(16, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 100.00, '1', 1),
(17, '2013-01-31 00:00:00', '2013-01-31 01:30:00', 100.00, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mboos_order_details`
--

DROP TABLE IF EXISTS `mboos_order_details`;
CREATE TABLE IF NOT EXISTS `mboos_order_details` (
  `mboos_order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_order_detail_quantity` int(11) DEFAULT NULL,
  `mboos_order_detail_price` double(3,2) DEFAULT NULL,
  `mboos_order_id` int(11) DEFAULT NULL,
  `mboos_product_id` int(11) NOT NULL,
  PRIMARY KEY (`mboos_order_detail_id`),
  KEY `mboos_order_id` (`mboos_order_id`),
  KEY `mboos_product_id` (`mboos_product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `mboos_order_details`
--

INSERT INTO `mboos_order_details` (`mboos_order_detail_id`, `mboos_order_detail_quantity`, `mboos_order_detail_price`, `mboos_order_id`, `mboos_product_id`) VALUES
(1, 4, 6.00, 1, 0),
(2, 3, 4.00, 1, 0),
(3, 5, 9.99, 2, 1),
(4, 3, 9.99, 2, 2),
(5, 5, 9.99, 3, 1),
(6, 3, 9.99, 3, 2),
(7, 5, 9.99, 5, 1),
(8, 3, 9.99, 5, 2),
(9, 5, 9.99, 6, 1),
(10, 3, 9.99, 6, 2),
(11, 5, 9.99, 7, 1),
(12, 3, 9.99, 7, 2),
(13, 5, 9.99, 8, 1),
(14, 3, 9.99, 8, 2),
(15, 5, 9.99, 9, 1),
(16, 3, 9.99, 9, 2),
(17, 5, 9.99, 10, 1),
(18, 3, 9.99, 10, 2),
(19, 5, 9.99, 11, 1),
(20, 3, 9.99, 11, 2),
(21, 0, 0.00, 12, 0),
(22, 0, 0.00, 12, 0),
(23, 0, 0.00, 13, 0),
(24, 0, 0.00, 13, 0),
(25, 5, 9.99, 14, 1),
(26, 3, 9.99, 14, 2),
(27, 5, 9.99, 15, 1),
(28, 3, 9.99, 15, 2),
(29, 5, 9.99, 16, 1),
(30, 3, 9.99, 16, 2),
(31, 5, 9.99, 17, 1),
(32, 3, 9.99, 17, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mboos_products`
--

DROP TABLE IF EXISTS `mboos_products`;
CREATE TABLE IF NOT EXISTS `mboos_products` (
  `mboos_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_product_name` varchar(50) DEFAULT NULL,
  `mboos_product_desc` varchar(500) NOT NULL,
  `mboos_product_supplier` varchar(50) DEFAULT NULL,
  `mboos_product_image` varchar(100) DEFAULT NULL,
  `mboos_product_status` enum('1','0') DEFAULT '1',
  `mboos_product_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`mboos_product_id`),
  KEY `mboos_product_category_id` (`mboos_product_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `mboos_products`
--

INSERT INTO `mboos_products` (`mboos_product_id`, `mboos_product_name`, `mboos_product_desc`, `mboos_product_supplier`, `mboos_product_image`, `mboos_product_status`, `mboos_product_category_id`) VALUES
(1, 'English', 'Public Speaking', 'Crown', 'sample.jpg', '1', 1),
(2, 'Economics', 'Basic Economics', 'Crown', 'sample.jpg', '1', 1),
(3, 'Filipino', 'Fil 33', 'Crown', 'sample.jpg', '1', 1),
(4, 'FFP', 'Freshmen Formation Program', 'XU', 'product.jpg', '1', 1),
(5, 'Math 121', 'Analytic and Solid Geometry', 'REX', 'product.jpg', '1', 1),
(6, 'Differential Calculus', 'Math122', 'REX', 'product.jpg', '1', 1),
(7, 'Effective Speech Communication', 'English', 'Crown', 'product.jpg', '1', 1),
(8, 'Pagbasa at Pagsulat sa Iba''t Ibang Disiplina', 'Filipino', 'NBS', 'product.jpg', '1', 1),
(9, 'National Service Training Program', 'NSTP', 'REX', 'product.jpg', '1', 1),
(10, 'Integral Calculus', 'Advance Math', 'REX', 'product.jpg', '1', 1),
(11, 'General Psychology', 'Psy', 'NBS', 'product.jpg', '1', 1),
(14, 'Introduction to Logic', 'Philosophy', 'Crown', 'product.jpg', '1', 1),
(15, 'Inorganic Chemistry', 'Chemistry', 'REX', 'product.jpg', '1', 1),
(16, 'Philosophy of the Human Person', 'Philosophy', 'Crown', 'product.jpg', '1', 1),
(17, 'Life of Rizal', 'History', 'REX', 'product.jpg', '1', 1),
(18, 'Church and Sacraments', 'Religious Studies', 'NBS', 'product.jpg', '1', 1),
(19, 'General Ethics with Emphasis on Moral Regeneration', 'Philosophy', 'Crown', 'product.jpg', '1', 1),
(20, 'Principles of Sociology', 'Sociology', 'Crown', 'product.jpg', '1', 1),
(21, 'Christian Morality', 'Religious Studies', 'Crown', 'product.jpg', '1', 1),
(22, 'Philosophy of Religion', 'Philosophy', 'REX', 'product.jpg', '1', 1),
(23, 'M&G Office Gel Ballpen', 'Pen', 'NBS', 'product.jpg', '1', 3),
(24, 'M&G X55 Gel Ballpen', 'Pen', 'Crown', 'product.jpg', '1', 3),
(25, 'M&G Highlighters', 'Highlighters', 'NBS', 'product.jpg', '1', 3),
(26, 'Zebra N5200 Ballpen', 'Pen', 'NBS', 'product.jpg', '1', 3),
(27, 'Bic RS2 Ballpen', 'Pen', 'NBS', 'product.jpg', '1', 3),
(28, 'Bic Marking 2000 Permanent Marker', 'Marker', 'NBS', 'product.jpg', '1', 3),
(29, 'Bic Glue Stick', 'Glue', 'NBS', 'product.jpg', '1', 3),
(30, 'Bic Correction Pen #556-012 Tipp EX', 'Pen', 'NBS', 'product.jpg', '1', 3),
(31, 'All About Scrapbooking 12"x12"', 'Papersheets', 'NBS', 'product.jpg', '1', 4),
(32, 'All About Scrapbooking Accessories', 'Laces', 'NBS', 'product.jpg', '1', 4),
(33, 'All About  Scrapbooking Eyelet Spring', 'Setter Tool Set', 'NBS', 'product.jpg', '1', 4),
(34, 'All About Scrapbooking Alphabet', 'Stickers', 'NBS', 'product.jpg', '1', 4),
(35, 'Stabilo Swing Cool Highlighters', 'Highlighters', 'NBS', 'product.jpg', '1', 3),
(36, 'Stabilo Colored Pencil', 'Pencil', 'NBS', 'product.jpg', '1', 3),
(37, 'Rotring Technical Pen College Set', 'Pen', 'NBS', 'product.jpg', '1', 3),
(38, 'Zig Kurecolor Twin-Tip Marker', 'Highligters', 'NBS', 'product.jpg', '1', 3),
(39, 'Stabilo Plan Whiteboard Marker Set', 'Marker', 'NBS', 'product.jpg', '1', 3),
(40, 'Stabilo Exam grade Pencil Pack', 'Pencil', 'NBS', 'product.jpg', '1', 3),
(41, 'Sterling One Piece Notebook', 'Notebook', 'NBS', 'product.jpg', '1', 3),
(42, 'Sterling Barbie Notebook', 'Notebook', 'NBS', 'product.jpg', '1', 3),
(43, 'Sterling Tweety Notebook', 'Notebook', 'NBS', 'product.jpg', '1', 3),
(44, 'Sterling Hello Kitty Notebook', 'Notebook', 'NBS', 'product.jpg', '1', 3),
(45, 'HP Scientific Calculator 30s', 'Calculator', 'Crown', 'product.jpg', '1', 4),
(46, 'HP Scientific Calculator 35s', 'Calculator', 'Crown', 'product.jpg', '1', 4),
(47, 'Wescott Scissors Anti-Microbial', 'Scissors', 'Crown', 'product.jpg', '1', 3),
(48, 'Scotch Scissors #1442B', 'Scissors', 'Crown', 'product.jpg', '1', 3),
(49, 'Springleaf Notebook', 'Notebook', 'Crown', 'product.jpg', '1', 3),
(50, 'Advance Notebook', 'Notebook', 'Crown', 'product.jpg', '1', 3),
(51, 'Globe Inflatable #KE-1634', 'Accessories', 'Crown', 'product.jpg', '1', 4),
(52, 'Nabel Body Bag #059', 'Bag', 'Crown', 'product.jpg', '1', 4),
(53, 'Nabel Back Pack #DY-063', 'Bag', 'Crown', 'product.jpg', '1', 4),
(54, 'Maboo Multi-purpose Box with Divider', 'Multi-purpose Box', 'Crown', 'product.jpg', '1', 4),
(55, 'Canson Sketch Pad 91 GSM', 'Pad', 'Crown', 'product.jpg', '1', 3),
(56, 'Golden Water Color', 'Coloring', 'Crown', 'product.jpg', '1', 3),
(57, 'Golden Oil Pastel', 'Coloring', 'Crown', 'product.jpg', '1', 3),
(58, 'Golden Modelling Clay with Moulder', 'Clay', 'Crown', 'product.jpg', '1', 4),
(59, 'Sakura Poster Color 30ml', 'Coloring', 'Crown', 'product.jpg', '1', 3),
(60, 'Berkley Aluminum Ruler', 'Ruler', 'Crown', 'product.jpg', '1', 3),
(61, 'School Blouse and Skirt', 'Uniform', 'REX', 'product.jpg', '1', 2),
(62, 'School Shirt and Pants', 'Uniform', 'REX', 'product.jpg', '1', 2),
(63, 'XU Physical Education Shirt and Jogging Pants', 'Uniform', 'XU', 'product.jpg', '1', 2),
(64, 'NSTP Shirt', 'Uniform', 'XU', 'product.jpg', '1', 2),
(65, 'XU Sesquisentenial anniversary Shirt', 'Shirt', 'XU', 'product.jpg', '1', 2),
(66, 'Xavier University Crusaders Official Jacket', 'Jacket', 'GetBlued', 'product.jpg', '1', 2),
(67, 'Computer Studies Wizards Shirt', 'Shirt', 'GetBlued', 'product.jpg', '1', 2),
(68, 'Artscies Tigers Shirt', 'Shirt', 'GetBlued', 'product.jpg', '1', 2),
(69, 'Aggies Bullriders Shirt', 'Shirt', 'GetBlued', 'product.jpg', '1', 2),
(70, 'Nursing Pythons Shirt ', 'Shirt', 'GetBlued', 'product.jpg', '1', 2),
(71, 'SOE Phoenix Shirt', 'Shirt', 'GetBlued', 'product.jpg', '1', 2),
(72, 'CIT Knights Shirt', 'Shirt', 'GetBlued', 'product.jpg', '1', 2),
(73, 'SBM Eagles Shirt', 'Shirt', 'GetBlued', 'product.jpg', '1', 2),
(74, 'Engineering Warriors Shirt', 'Shirt', 'GetBlued', 'product.jpg', '1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mboos_product_category`
--

DROP TABLE IF EXISTS `mboos_product_category`;
CREATE TABLE IF NOT EXISTS `mboos_product_category` (
  `mboos_product_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_product_category_name` varchar(45) DEFAULT NULL,
  `mboos_product_category_status` enum('1','0') DEFAULT '1',
  PRIMARY KEY (`mboos_product_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mboos_product_category`
--

INSERT INTO `mboos_product_category` (`mboos_product_category_id`, `mboos_product_category_name`, `mboos_product_category_status`) VALUES
(1, 'Books', '1'),
(2, 'Clothings', '1'),
(3, 'School Supplies', '1'),
(4, 'Accessories', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mboos_product_price`
--

DROP TABLE IF EXISTS `mboos_product_price`;
CREATE TABLE IF NOT EXISTS `mboos_product_price` (
  `mboos_product_price_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_product_price` double(16,2) DEFAULT NULL,
  `mboos_product_price_date` datetime DEFAULT NULL,
  `mboos_product_price_status` enum('1','0') DEFAULT '1',
  `mboos_product_id` int(11) NOT NULL,
  PRIMARY KEY (`mboos_product_price_id`),
  KEY `mboos_product_id` (`mboos_product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mboos_product_price`
--

INSERT INTO `mboos_product_price` (`mboos_product_price_id`, `mboos_product_price`, `mboos_product_price_date`, `mboos_product_price_status`, `mboos_product_id`) VALUES
(1, 89.65, '2013-01-24 00:00:00', '1', 1),
(2, 140.00, '2013-01-24 00:00:00', '1', 2),
(3, 140.00, '2013-01-24 00:00:00', '1', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mboos_users`
--

DROP TABLE IF EXISTS `mboos_users`;
CREATE TABLE IF NOT EXISTS `mboos_users` (
  `mboos_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_user_email` varchar(50) DEFAULT NULL,
  `mboos_user_username` varchar(50) DEFAULT NULL,
  `mboos_user_password` varchar(50) DEFAULT NULL,
  `mboos_user_secret_question` varchar(50) NOT NULL,
  `mboos_user_secret_answer` varchar(50) NOT NULL,
  `mboos_user_cat_id` int(11) DEFAULT NULL,
  `mboos_user_status` enum('1','0') DEFAULT '1',
  PRIMARY KEY (`mboos_user_id`),
  KEY `mboos_user_cat_id` (`mboos_user_cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mboos_users`
--

INSERT INTO `mboos_users` (`mboos_user_id`, `mboos_user_email`, `mboos_user_username`, `mboos_user_password`, `mboos_user_secret_question`, `mboos_user_secret_answer`, `mboos_user_cat_id`, `mboos_user_status`) VALUES
(1, 'ian_kionisala@yahoo.com', 'ianpaul', '25d55ad283aa400af464c76d713c07ad', '', '', 1, '1'),
(2, 'thaddeusalong@gmail.com', 'DeoAlong', 'd9429b9d591a6480f8d2bec8583e1845', 'qwe', 'qwe', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `mboos_user_category`
--

DROP TABLE IF EXISTS `mboos_user_category`;
CREATE TABLE IF NOT EXISTS `mboos_user_category` (
  `mboos_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_user_name` varchar(50) DEFAULT NULL,
  `mboos_user_alevel` int(11) DEFAULT NULL,
  PRIMARY KEY (`mboos_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mboos_user_category`
--

INSERT INTO `mboos_user_category` (`mboos_user_id`, `mboos_user_name`, `mboos_user_alevel`) VALUES
(1, 'System Administrator', 1),
(2, 'Bookstore Personnel', 2);

-- --------------------------------------------------------

--
-- Table structure for table `owner_info`
--

DROP TABLE IF EXISTS `owner_info`;
CREATE TABLE IF NOT EXISTS `owner_info` (
  `owner_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_info_company_name` varchar(100) DEFAULT NULL,
  `owner_info_company_email` varchar(50) DEFAULT NULL,
  `owner_info_domain_name` varchar(100) NOT NULL,
  `owner_info_username` varchar(50) DEFAULT NULL,
  `owner_info_password` varchar(50) DEFAULT NULL,
  `owner_info_status` enum('1','0') DEFAULT '0',
  PRIMARY KEY (`owner_info_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `owner_info`
--

INSERT INTO `owner_info` (`owner_info_id`, `owner_info_company_name`, `owner_info_company_email`, `owner_info_domain_name`, `owner_info_username`, `owner_info_password`, `owner_info_status`) VALUES
(1, 'XU Bookstore', 'ian_kionisala@yahoo.com', 'mboos.ipklab.dx.am', 'ianpaul', '827ccb0eea8a706c4c34a16891f84e7b', '1');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`st_id`, `setting`, `value`) VALUES
(1, 'emails', ''),
(2, 'currency', 'aud'),
(3, 'paymethods', 'paypal'),
(4, 'siteurl', 'http://localhost/newcastle/'),
(5, 'encryption_key', 'newcastle'),
(6, 'sess_cookie_name', 'newcastle_session'),
(7, 'siteoffline', '0'),
(8, 'offlinemsg', 'We''ll be back later'),
(9, 'timezone', 'Australia/ACT'),
(10, 'paypalaccount', 'kenn_vall@yahoo.com'),
(11, 'merchantaccount', 'kennvall@gcheckout.com'),
(12, 'showaffiliateprogram', '1'),
(13, 'paypalsandbox', '1'),
(14, 'google_ad_client', 'pub-000000000000000'),
(15, 'google_ad_test_env', '1'),
(16, 'google_adsense_enable', '1'),
(17, 'sitename', 'aus-newcastle');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
