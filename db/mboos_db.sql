-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 14, 2013 at 04:31 PM
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

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `sp_add_listing`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_add_listing`(IN p_title VARCHAR(255), IN p_subcategory MEDIUMTEXT, IN p_images MEDIUMTEXT, IN p_advr INT, IN p_description MEDIUMTEXT, IN p_address VARCHAR(255), IN p_suburb VARCHAR(75), IN p_postcode VARCHAR(10), IN p_state INT, IN p_country INT, IN p_cname VARCHAR(255), IN p_phone VARCHAR(50), IN p_phone2 VARCHAR(50), IN p_email VARCHAR(255), IN p_url MEDIUMTEXT, IN p_package CHAR(1), IN p_recurrent VARCHAR(75), IN p_paypal VARCHAR(255), IN p_status CHAR(1))
BEGIN
DECLARE success INT DEFAULT 0;
DECLARE id INT DEFAULT 0;
DECLARE today TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
DECLARE EXIT HANDLER FOR SQLWARNING ROLLBACK;

START TRANSACTION;
  DROP TEMPORARY TABLE IF EXISTS `tmplast_id`;
  CREATE TEMPORARY TABLE `tmplast_id`(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    lstid INT NULL
    ) ENGINE=Memory COMMENT 'stores temporary LAST_ID INSERTED';


  
  INSERT INTO listing(title, subcategory, images, advr, description, address, suburb, postcode, state, country, cname, phone, phone2, email, url, package, recurrent, paypal, status) VALUES(p_title, p_subcategory, p_images, p_advr, p_description, p_address, p_suburb, p_postcode, p_state, p_country, p_cname, p_phone, p_phone2, p_email, p_url, p_package, p_recurrent, p_paypal, p_status);

  
  SET id = LAST_INSERT_ID();

  
  INSERT INTO `tmplast_id`(lstid) VALUE(id);

  
  INSERT INTO advertiser_listing(ad_id, lst_id, posted) VALUES(p_advr, id, today);

COMMIT;

END$$

DROP PROCEDURE IF EXISTS `sp_admin_listing`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_admin_listing`()
    SQL SECURITY INVOKER
BEGIN

   DECLARE eof INT DEFAULT 0;
   DECLARE mLst_id INT(11) DEFAULT 0;
   DECLARE mTitle VARCHAR(255) DEFAULT '';
   DECLARE mSubcategory VARCHAR(255) DEFAULT '';
   DECLARE mFullname VARCHAR(255) DEFAULT '';
   DECLARE mXpired CHAR(1) DEFAULT '0';
   DECLARE mCategoryFullName VARCHAR(255) DEFAULT '';
   DECLARE mTmpCateg VARCHAR(255) DEFAULT '';

   DECLARE cur_admin_listing CURSOR FOR SELECT l.lst_id, l.title, l.subcategory, CONCAT(a.fname, " ", a.lname) AS fullname, l.expired FROM listing l LEFT JOIN advertiser a ON l.advr=a.ad_id;
   DECLARE CONTINUE HANDLER FOR NOT FOUND SET eof = 1;

   DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
   DECLARE EXIT HANDLER FOR SQLWARNING ROLLBACK;

   START TRANSACTION;

     DROP TEMPORARY TABLE IF EXISTS `tmpadminlistingtbl`;
     CREATE TEMPORARY TABLE `tmpadminlistingtbl`(
       id INT NOT NULL AUTO_INCREMENT,
       lst_id INT NOT NULL,
       title VARCHAR(255) NULL,
       advr VARCHAR(255) NULL,
       categories VARCHAR(255) NULL,
       expired CHAR(1) NULL,
       PRIMARY KEY (id)) ENGINE=Memory COMMENT = 'this table is for web admin monitoring purposes';

     OPEN cur_admin_listing;

     listing_loop: LOOP
       FETCH cur_admin_listing INTO mLst_id, mTitle, mSubcategory, mFullname, mXpired;

         IF eof THEN
           LEAVE listing_loop;
         END IF;
         SET @strCateg = mSubcategory;

         
         loop_split_lbl:
           WHILE @strCateg !='' DO
             
             SET @strSought = SUBSTRING_INDEX(@strCateg, ',', 1);
             SET @strCateg = SUBSTRING(@strCateg, LENGTH(@strSought)+2);

             
             SELECT sub_category INTO mTmpCateg FROM subcategories WHERE scat_id=@strSought;

             IF(ASCII(mCategoryFullName) <> 0) THEN
               SET mCategoryFullName = CONCAT(mCategoryFullName, ", ", mTmpCateg);
             ELSE
               SET mCategoryFullName = CONCAT(mCategoryFullName, mTmpCateg);
             END IF;

           END WHILE;

         INSERT INTO `tmpadminlistingtbl` SET lst_id=mLst_id, title=mTitle, advr=mFullname, categories=mCategoryFullName, expired=mXpired;
         SET mCategoryFullName = '';

     END LOOP listing_loop;

   COMMIT;
 END$$

DROP PROCEDURE IF EXISTS `sp_advertiser_deactivate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_advertiser_deactivate`(IN pFlag CHAR(1), IN pAdvr INT, OUT pSuccess INT)
    SQL SECURITY INVOKER
BEGIN

 DECLARE EXIT HANDLER FOR SQLWARNING ROLLBACK;
 DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;

 START TRANSACTION;
   UPDATE advertiser SET `status`=pFlag WHERE ad_id=pAdvr;
   SET pSuccess = 1;
 COMMIT;
END$$

DROP PROCEDURE IF EXISTS `sp_categories_count`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_categories_count`()
BEGIN

 
 DECLARE record_not_found INT DEFAULT 0;
 DECLARE cntr INT DEFAULT 0;
 DECLARE subcateg VARCHAR(255) DEFAULT '';
 DECLARE output VARCHAR(255) DEFAULT '';
 DECLARE id  INT DEFAULT 0;

 
 DECLARE cursor_listing CURSOR FOR SELECT subcategory, lst_id FROM listing WHERE status='1' AND expired='0';

 DECLARE CONTINUE HANDLER FOR NOT FOUND SET record_not_found = 1;

 
 DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
 DECLARE EXIT HANDLER FOR SQLWARNING ROLLBACK;

 START TRANSACTION;

 
 DROP TEMPORARY TABLE IF EXISTS `tmpcateg_count`;
 CREATE TEMPORARY TABLE tmpcateg_count(
   `pos` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   `subcategories` VARCHAR(255) NULL,
   `listid` INT
 ) ENGINE=Memory COMMENT = 'Counts the categories';

   
   open cursor_listing;

   loop_listing_lbl: LOOP
     FETCH cursor_listing INTO subcateg, id;

     
     IF record_not_found THEN
       LEAVE loop_listing_lbl;
     END IF;

     
     SET @strCateg = subcateg;

     
     loop_split_lbl:
     WHILE @strCateg !='' DO
       
       SET @strSought = SUBSTRING_INDEX(@strCateg, ',', 1);
       SET @strCateg = SUBSTRING(@strCateg, LENGTH(@strSought)+2);

       
       INSERT INTO tmpcateg_count SET subcategories = @strSought, listid = id;

     END WHILE;
         
     

     


   END LOOP loop_listing_lbl;

   
   close cursor_listing;


 COMMIT;

END$$

DROP PROCEDURE IF EXISTS `sp_filtered_categories_count`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_filtered_categories_count`()
    SQL SECURITY INVOKER
BEGIN

DECLARE record_not_found TINYINT DEFAULT 0;
DECLARE mListId INT DEFAULT 0;
DECLARE mMcat INT DEFAULT 0;
DECLARE mCategDesc VARCHAR(255) DEFAULT '';

DECLARE cur_categ_count CURSOR FOR SELECT t.listid, m.mcat_id, m.category AS `maincategory` FROM ((tmpcateg_count t LEFT JOIN subcategories s ON t.subcategories=s.scat_id) LEFT JOIN maincategories m ON s.mcat_id=m.mcat_id) GROUP BY t.listid, m.category;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET record_not_found = 1;

DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
DECLARE EXIT HANDLER FOR SQLWARNING ROLLBACK;


START TRANSACTION;


CALL sp_categories_count();


DROP TEMPORARY TABLE IF EXISTS `tmp_filtered_categ_count`;
CREATE TEMPORARY TABLE tmp_filtered_categ_count(
`listid` INT NOT NULL,
`mcat_id` INT NOT NULL,
`maincategory` VARCHAR(255) NULL
)ENGINE=Memory COMMENT 'creates another temporary table to filter further maincategories count';


OPEN cur_categ_count;


main_loop:LOOP

  
  FETCH cur_categ_count INTO mListId, mMcat, mCategDesc;

  
  IF record_not_found THEN
    LEAVE main_loop;
  END IF;

  
     INSERT INTO tmp_filtered_categ_count SET listid = mListId, mcat_id = mMcat, maincategory = mCategDesc;

END LOOP main_loop;

COMMIT;

END$$

DROP PROCEDURE IF EXISTS `sp_inccount`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_inccount`(IN p_link VARCHAR(15), IN p_lst_id INT)
BEGIN
 
 
 
 
 DECLARE cntr INT DEFAULT 0;
 DECLARE pv INT DEFAULT 0;
 DECLARE pc INT DEFAULT 0;
 DECLARE uc INT DEFAULT 0;
 DECLARE en INT DEFAULT 0;
 DECLARE cur_listing CURSOR FOR SELECT pgviews, pclicks, uclicks, enq FROM listing WHERE lst_id = p_lst_id;

 
 
 

 DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
 DECLARE EXIT HANDLER FOR SQLWARNING ROLLBACK;


 START TRANSACTION;


   
   OPEN cur_listing;
   FETCH cur_listing INTO pv, pc, uc, en;

   
   IF NOT STRCMP(p_link, 'pageview') THEN
     
     
     SET pv = pv + 1;


     UPDATE listing SET pgviews=pv WHERE lst_id=p_lst_id;
   END IF;

   
   IF NOT STRCMP(p_link, 'phone') THEN
     
     

     SET pc = pc+ 1;
     UPDATE listing SET pclicks=pc WHERE lst_id=p_lst_id;
   END IF;

   
   IF NOT STRCMP(p_link, 'email') THEN
     
     

     SET en = en + 1;
     UPDATE listing SET enq=en WHERE lst_id=p_lst_id;
   END IF;

   
   IF NOT STRCMP(p_link, 'url') THEN
     
     

     SET uc = uc + 1;
     UPDATE listing SET uclicks=uc WHERE lst_id=p_lst_id;
   END IF;

COMMIT;

END$$

DROP PROCEDURE IF EXISTS `sp_insert_orders`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_orders`(IN arg_itemnumber VARCHAR(50), IN arg_email VARCHAR(255), IN arg_amount DECIMAL(8,2), IN arg_status VARCHAR(3), IN arg_state MEDIUMTEXT, IN arg_zip VARCHAR(25), IN arg_address MEDIUMTEXT, IN arg_country VARCHAR(255), IN arg_paypal_trxnid VARCHAR(255), IN arg_created VARCHAR(255), OUT arg_success TINYINT)
BEGIN

   DECLARE m_lstid INT DEFAULT 0;
   DECLARE m_advr INT DEFAULT 0;

   DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
   DECLARE EXIT HANDLER FOR SQLWARNING ROLLBACK;

   SET arg_success = 0;

   START TRANSACTION;

   
    SET m_lstid = SUBSTRING_INDEX(m_itemnumber, '-', 1);
    SET m_advr = SUBSTRING_INDEX(m_itemnumber, '-', -1);

     
     INSERT INTO orders SET itemnumber = arg_itemnumber, email = arg_email, amount = arg_amount, `status` = arg_status, state = arg_state, zip_code = arg_zip, address = arg_address, country = arg_country, paypal_trans_id = arg_paypal_trxnid, created_at = arg_created;

     
     UPDATE listing SET expired = '0', `status` = '1';

     
     SET arg_success = 1;

   COMMIT;

 END$$

DROP PROCEDURE IF EXISTS `sp_payment_history`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_payment_history`()
    SQL SECURITY INVOKER
BEGIN
   DECLARE int_record_not_found INT DEFAULT 0;
   DECLARE `mId` INT DEFAULT 0;
   DECLARE mItemNumber VARCHAR(255) DEFAULT '';
   DECLARE mEmail VARCHAR(255) DEFAULT '';
   DECLARE mAmount DECIMAL(8,2) DEFAULT 0.0;
   DECLARE mStatus VARCHAR(255) DEFAULT '';
   DECLARE mPaypal_trans_id VARCHAR(255) DEFAULT '';
   DECLARE mCreated_at DATETIME DEFAULT '0000-00-00 00:00:00';

   DECLARE cur_orders CURSOR FOR SELECT id, itemnumber, email, amount, `status`, paypaL_trans_id, created_at FROM orders;

   DECLARE CONTINUE HANDLER FOR NOT FOUND SET int_record_not_found = 1;


   DECLARE EXIT HANDLER FOR SQLEXCEPTION ROLLBACK;
   DECLARE EXIT HANDLER FOR SQLWARNING ROLLBACK;

   START TRANSACTION;

   DROP TEMPORARY TABLE IF EXISTS `tmp_payment_history_tbl`;
   CREATE TEMPORARY TABLE `tmp_payment_history_tbl`(
     id INT NOT NULL,
     itemnumber VARCHAR(50) DEFAULT '',
     lst_id INT DEFAULT 0,
     advr INT DEFAULT 0,
     email VARCHAR(150) NULL,
     amount DECIMAL(8,2) DEFAULT 0.00,
     `status` VARCHAR(50) NULL,
     paypal_trans_id VARCHAR(32) NULL,
     created_at DATETIME,
     INDEX (advr)
   )ENGINE = Memory COMMENT = 'creates temp table for payment history';

   
   OPEN cur_orders;

   SET @lstid = 0;
   SET @advr = 0;

   loop_orders: LOOP
     
     FETCH cur_orders INTO `mId`, mItemNumber, mEmail, mAmount, mStatus, mPaypal_trans_id, mCreated_at;

     
     IF int_record_not_found THEN
       LEAVE loop_orders;
     END IF;

     
     SET @lstid = SUBSTRING_INDEX(mItemNumber, '-', 1);
     SET @advr = SUBSTRING_INDEX(mItemNumber, '-', -1);

     INSERT INTO `tmp_payment_history_tbl` SET id=`mId`, itemnumber=mItemNumber, lst_id=@lstid, advr=@advr, email=mEmail, amount=mAmount, `status`=mStatus, paypal_trans_id=mPaypal_trans_id, created_at=mCreated_at;

   END LOOP loop_orders;

   
   CLOSE cur_orders;

   COMMIT;

 END$$

DROP PROCEDURE IF EXISTS `sp_search`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_search`(IN niddle VARCHAR(255))
BEGIN
 SELECT lst_id as id, title, description, address, phone FROM listing WHERE MATCH(title, description) AGAINST(niddle) ORDER BY title DESC;
END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `func_list_id`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_list_id`(itemnumber VARCHAR(255)) RETURNS int(11)
    DETERMINISTIC
BEGIN

  DECLARE listID INT DEFAULT 0;

  SET listID = TRIM(SUBSTRING_INDEX(itemnumber, '-', 1));

  RETURN listID;

END$$

DELIMITER ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `mboos_customer_fname` varchar(50) DEFAULT NULL,
  `mboos_customer_mname` varchar(50) DEFAULT NULL,
  `mboos_customer_lname` varchar(50) DEFAULT NULL,
  `mboos_customer_phone` varchar(50) DEFAULT NULL,
  `mboos_customer_status` enum('1','0') DEFAULT '1',
  PRIMARY KEY (`mboos_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mboos_orders`
--

DROP TABLE IF EXISTS `mboos_orders`;
CREATE TABLE IF NOT EXISTS `mboos_orders` (
  `mboos_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_order_date` datetime DEFAULT NULL,
  `mboos_order_pick_schedule` datetime DEFAULT NULL,
  `mboos_order_status` enum('1','0') DEFAULT '1',
  `comment` longtext,
  `mboos_customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`mboos_order_id`),
  KEY `mboos_customer_id` (`mboos_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mboos_order_details`
--

DROP TABLE IF EXISTS `mboos_order_details`;
CREATE TABLE IF NOT EXISTS `mboos_order_details` (
  `mboos_order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_order_detail_quantity` int(11) DEFAULT NULL,
  `mboos_order_detail_price` double DEFAULT NULL,
  `mboos_order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`mboos_order_detail_id`),
  KEY `mboos_order_id` (`mboos_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `mboos_product_availability` int(11) NOT NULL,
  `mboos_product_status` enum('1','0') DEFAULT '1',
  `mboos_product_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`mboos_product_id`),
  KEY `mboos_product_category_id` (`mboos_product_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mboos_products`
--

INSERT INTO `mboos_products` (`mboos_product_id`, `mboos_product_name`, `mboos_product_desc`, `mboos_product_supplier`, `mboos_product_image`, `mboos_product_availability`, `mboos_product_status`, `mboos_product_category_id`) VALUES
(1, 'Math', 'College Algebra', 'Crown Store', 'sample.jpg', 10, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mboos_product_category`
--

DROP TABLE IF EXISTS `mboos_product_category`;
CREATE TABLE IF NOT EXISTS `mboos_product_category` (
  `mboos_product_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `mboos_product_category_name` varchar(45) DEFAULT NULL,
  `mboos_product_category_image` varchar(45) DEFAULT NULL,
  `mboos_product_category_status` enum('1','0') DEFAULT '1',
  PRIMARY KEY (`mboos_product_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mboos_product_category`
--

INSERT INTO `mboos_product_category` (`mboos_product_category_id`, `mboos_product_category_name`, `mboos_product_category_image`, `mboos_product_category_status`) VALUES
(1, 'Books', NULL, '1'),
(2, 'Clothings', NULL, '1'),
(3, 'School Supplies', NULL, '1'),
(4, 'Others', NULL, '1'),
(5, 'Accessories', NULL, '1');

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
  `mboos_product_id` int(10) NOT NULL,
  PRIMARY KEY (`mboos_product_price_id`),
  KEY `mboos_product_id` (`mboos_product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mboos_product_price`
--

INSERT INTO `mboos_product_price` (`mboos_product_price_id`, `mboos_product_price`, `mboos_product_price_date`, `mboos_product_price_status`, `mboos_product_id`) VALUES
(1, 100.00, '2013-01-11 00:00:00', '1', 1),
(2, 102.00, '2013-01-10 00:00:00', '0', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mboos_users`
--

INSERT INTO `mboos_users` (`mboos_user_id`, `mboos_user_email`, `mboos_user_username`, `mboos_user_password`, `mboos_user_secret_question`, `mboos_user_secret_answer`, `mboos_user_cat_id`, `mboos_user_status`) VALUES
(1, 'ian_kionisala@yahoo.com', 'ianpaul', '25d55ad283aa400af464c76d713c07ad', 'how old are you?', '23', 1, '1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
  `owner_info_username` varchar(50) DEFAULT NULL,
  `owner_info_password` varchar(50) DEFAULT NULL,
  `owner_info_status` enum('1','0') DEFAULT '0',
  PRIMARY KEY (`owner_info_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `owner_info`
--

INSERT INTO `owner_info` (`owner_info_id`, `owner_info_company_name`, `owner_info_company_email`, `owner_info_username`, `owner_info_password`, `owner_info_status`) VALUES
(1, 'XU Bookstore', 'ian_kionisala@yahoo.com', 'ianpaul', '827ccb0eea8a706c4c34a16891f84e7b', '1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mboos_instocks`
--
ALTER TABLE `mboos_instocks`
  ADD CONSTRAINT `mboos_instocks_ibfk_1` FOREIGN KEY (`mboos_product_id`) REFERENCES `mboos_products` (`mboos_product_id`),
  ADD CONSTRAINT `mboos_instocks_ibfk_2` FOREIGN KEY (`mboos_user_id`) REFERENCES `mboos_users` (`mboos_user_id`);

--
-- Constraints for table `mboos_orders`
--
ALTER TABLE `mboos_orders`
  ADD CONSTRAINT `mboos_orders_ibfk_1` FOREIGN KEY (`mboos_customer_id`) REFERENCES `mboos_customers` (`mboos_customer_id`);

--
-- Constraints for table `mboos_order_details`
--
ALTER TABLE `mboos_order_details`
  ADD CONSTRAINT `mboos_order_details_ibfk_1` FOREIGN KEY (`mboos_order_id`) REFERENCES `mboos_orders` (`mboos_order_id`);

--
-- Constraints for table `mboos_products`
--
ALTER TABLE `mboos_products`
  ADD CONSTRAINT `mboos_products_ibfk_1` FOREIGN KEY (`mboos_product_category_id`) REFERENCES `mboos_product_category` (`mboos_product_category_id`);

--
-- Constraints for table `mboos_product_price`
--
ALTER TABLE `mboos_product_price`
  ADD CONSTRAINT `mboos_product_price_ibfk_1` FOREIGN KEY (`mboos_product_id`) REFERENCES `mboos_products` (`mboos_product_id`);

--
-- Constraints for table `mboos_users`
--
ALTER TABLE `mboos_users`
  ADD CONSTRAINT `mboos_users_ibfk_1` FOREIGN KEY (`mboos_user_cat_id`) REFERENCES `mboos_user_category` (`mboos_user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
