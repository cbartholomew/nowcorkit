-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 01, 2012 at 02:41 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nowcorkitdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `board_maintenance`
--

CREATE TABLE `board_maintenance` (
  `maintenance_id` int(11) NOT NULL AUTO_INCREMENT,
  `maintenance_name` varchar(100) NOT NULL,
  `maintenance_dttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_successful` tinyint(4) NOT NULL,
  `maintenance_notes` varchar(255) NOT NULL,
  PRIMARY KEY (`maintenance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `board_maintenance`
--


-- --------------------------------------------------------

--
-- Table structure for table `board_posting`
--

CREATE TABLE `board_posting` (
  `board_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `board_post_board_id` int(11) NOT NULL,
  `board_post_users_flyers_id` int(11) NOT NULL,
  `board_post_users_cork_id` int(11) NOT NULL,
  `board_post_post_status_id` int(11) NOT NULL,
  `board_post_expire_dttm` date NOT NULL,
  `board_post_created_dttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`board_post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `board_posting`
--

INSERT INTO `board_posting` VALUES(5, 1, 3, 1, 4, '2012-02-21', '2012-01-22 20:35:29');
INSERT INTO `board_posting` VALUES(6, 1, 3, 1, 3, '2012-02-21', '2012-01-22 22:15:20');
INSERT INTO `board_posting` VALUES(7, 1, 3, 1, 2, '2012-02-21', '2012-01-22 22:15:23');
INSERT INTO `board_posting` VALUES(18, 3, 1, 1, 1, '2012-02-22', '2012-01-23 21:56:22');
INSERT INTO `board_posting` VALUES(19, 3, 1, 1, 4, '2012-02-22', '2012-01-23 21:59:28');
INSERT INTO `board_posting` VALUES(27, 4, 5, 1, 1, '2012-02-27', '2012-01-28 09:54:36');
INSERT INTO `board_posting` VALUES(30, 4, 7, 1, 4, '2012-02-28', '2012-01-28 16:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `board_preferences`
--

CREATE TABLE `board_preferences` (
  `board_id` int(11) NOT NULL AUTO_INCREMENT,
  `board_title` varchar(50) NOT NULL,
  `board_description` varchar(200) NOT NULL,
  `board_address` varchar(50) DEFAULT NULL,
  `board_city` varchar(50) NOT NULL,
  `board_state_id` varchar(2) NOT NULL,
  `board_zip` varchar(10) NOT NULL,
  `board_permission_type_id` int(11) NOT NULL,
  `board_expiration_days` smallint(6) NOT NULL,
  `board_enable_shuffler` varchar(3) DEFAULT NULL,
  `board_shuffler_interval` mediumint(9) DEFAULT NULL,
  `board_pps_id` int(11) NOT NULL,
  `board_pps_cash_amount` decimal(10,2) DEFAULT NULL,
  `board_pps_flyerdays` smallint(11) DEFAULT NULL,
  `board_pps_payment` mediumtext,
  `board_users_cork_id` int(11) NOT NULL,
  `board_created_dttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`board_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `board_preferences`
--

INSERT INTO `board_preferences` VALUES(4, 'Development Boardz', 'This is the new baord', '', 'Rockland', '21', '02370', 3, 30, '', 0, 3, 1.50, 30, 'Not a real board.', 1, '2012-01-23 22:16:45');

-- --------------------------------------------------------

--
-- Table structure for table `board_status`
--

CREATE TABLE `board_status` (
  `board_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `board_preferences_id` int(11) NOT NULL,
  `board_status_last_updated_dttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `board_status_is_displaying` smallint(6) NOT NULL,
  PRIMARY KEY (`board_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `board_status`
--

INSERT INTO `board_status` VALUES(4, 4, '2012-01-29 17:34:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_type`
--

CREATE TABLE `contact_type` (
  `contact_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_type_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`contact_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `contact_type`
--

INSERT INTO `contact_type` VALUES(1, 'Email');
INSERT INTO `contact_type` VALUES(2, 'Phone');
INSERT INTO `contact_type` VALUES(3, 'Social Network Link');

-- --------------------------------------------------------

--
-- Table structure for table `facebook_users`
--

CREATE TABLE `facebook_users` (
  `oauth_users_id` bigint(20) NOT NULL,
  `oauth_users_name` varchar(100) NOT NULL,
  `oauth_users_first_name` varchar(50) NOT NULL,
  `oauth_users_last_name` varchar(50) NOT NULL,
  `oauth_users_link` varchar(100) NOT NULL,
  `oauth_users_username` varchar(50) DEFAULT NULL,
  `oauth_users_gender` varchar(1) NOT NULL,
  `oauth_users_locale` varchar(10) NOT NULL,
  `oauth_users_location_id` bigint(20) DEFAULT NULL,
  `oauth_users_location_name` varchar(100) DEFAULT NULL,
  `oauth_users_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`oauth_users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='when using facebook oAuth, accounts will be placed in this table.';

--
-- Dumping data for table `facebook_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `flyer_type`
--

CREATE TABLE `flyer_type` (
  `flyer_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `flyer_type_desc` varchar(50) NOT NULL,
  `flyer_type_table_pointer` varchar(50) NOT NULL,
  PRIMARY KEY (`flyer_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `flyer_type`
--

INSERT INTO `flyer_type` VALUES(1, 'text', 'text_flyers');
INSERT INTO `flyer_type` VALUES(2, 'text_image', 'text_image_flyers');
INSERT INTO `flyer_type` VALUES(3, 'image', 'image_flyers');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `forgot_password_id` int(11) NOT NULL AUTO_INCREMENT,
  `forgot_password_session_id` char(34) NOT NULL,
  `forgot_password_session_expire` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `forgot_password_users_email` varchar(50) NOT NULL,
  `forgot_password_email_sent` int(8) NOT NULL,
  `forgot_password_url_hash` char(255) NOT NULL,
  PRIMARY KEY (`forgot_password_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `forgot_password`
--


-- --------------------------------------------------------

--
-- Table structure for table `image_flyers`
--

CREATE TABLE `image_flyers` (
  `image_flyer_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_flyer_title` varchar(50) NOT NULL,
  `image_flyer_image_meta_data_id` int(11) NOT NULL,
  `image_flyer_users_cork_id` int(11) NOT NULL,
  `image_flyer_created_dttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`image_flyer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `image_flyers`
--

INSERT INTO `image_flyers` VALUES(1, 'Minify Image Only', 3, 1, '2012-01-24 01:41:13');

-- --------------------------------------------------------

--
-- Table structure for table `image_meta_data`
--

CREATE TABLE `image_meta_data` (
  `image_meta_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_meta_data_file_name` varchar(2083) NOT NULL,
  `image_meta_data_type` varchar(15) NOT NULL,
  `image_meta_data_size` bigint(20) NOT NULL,
  `image_meta_data_image_location` mediumtext NOT NULL,
  `image_meta_data_users_cork_id` int(11) NOT NULL,
  `image_meta_data_created_dttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`image_meta_data_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `image_meta_data`
--

INSERT INTO `image_meta_data` VALUES(1, '1_heart_0.png', 'image/png', 68867, 'flyers/images/', 1, '2012-01-17 15:03:45');
INSERT INTO `image_meta_data` VALUES(2, '1_usam.gif', 'image/gif', 59677, 'flyers/images/', 1, '2012-01-24 01:40:25');
INSERT INTO `image_meta_data` VALUES(3, '1_balloon_poster_outlined_150x150_p1.png', 'image/png', 38108, 'flyers/images/', 1, '2012-01-24 01:41:13');

-- --------------------------------------------------------

--
-- Table structure for table `permission_type`
--

CREATE TABLE `permission_type` (
  `permission_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_type_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`permission_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permission_type`
--

INSERT INTO `permission_type` VALUES(1, 'By Approval ');
INSERT INTO `permission_type` VALUES(2, 'Private');
INSERT INTO `permission_type` VALUES(3, 'Public');

-- --------------------------------------------------------

--
-- Table structure for table `post_status`
--

CREATE TABLE `post_status` (
  `post_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_status_desc` varchar(25) NOT NULL,
  PRIMARY KEY (`post_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `post_status`
--

INSERT INTO `post_status` VALUES(1, 'Posted');
INSERT INTO `post_status` VALUES(2, 'Pending Approval');
INSERT INTO `post_status` VALUES(3, 'Not Approved');
INSERT INTO `post_status` VALUES(4, 'PPS Posted');
INSERT INTO `post_status` VALUES(5, 'PPS Queue');
INSERT INTO `post_status` VALUES(6, 'Expired');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `state_id` int(2) NOT NULL AUTO_INCREMENT,
  `state_desc` varchar(30) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='state' AUTO_INCREMENT=51 ;

--
-- Dumping data for table `state`
--

INSERT INTO `state` VALUES(1, 'Alabama');
INSERT INTO `state` VALUES(2, 'Alaska');
INSERT INTO `state` VALUES(3, 'Arizona');
INSERT INTO `state` VALUES(4, 'Arkansas');
INSERT INTO `state` VALUES(5, 'California');
INSERT INTO `state` VALUES(6, 'Colorado');
INSERT INTO `state` VALUES(7, 'Connecticut');
INSERT INTO `state` VALUES(8, 'Delaware');
INSERT INTO `state` VALUES(9, 'Florida');
INSERT INTO `state` VALUES(10, 'Georgia');
INSERT INTO `state` VALUES(11, 'Hawaii');
INSERT INTO `state` VALUES(12, 'Idaho');
INSERT INTO `state` VALUES(13, 'Illinois');
INSERT INTO `state` VALUES(14, 'Indiana');
INSERT INTO `state` VALUES(15, 'Iowa');
INSERT INTO `state` VALUES(16, 'Kansas');
INSERT INTO `state` VALUES(17, 'Kentucky');
INSERT INTO `state` VALUES(18, 'Louisiana');
INSERT INTO `state` VALUES(19, 'Maine');
INSERT INTO `state` VALUES(20, 'Maryland');
INSERT INTO `state` VALUES(21, 'Massachusetts');
INSERT INTO `state` VALUES(22, 'Michigan');
INSERT INTO `state` VALUES(23, 'Minnesota');
INSERT INTO `state` VALUES(24, 'Mississippi');
INSERT INTO `state` VALUES(25, 'Missouri');
INSERT INTO `state` VALUES(26, 'Montana');
INSERT INTO `state` VALUES(27, 'Nebraska');
INSERT INTO `state` VALUES(28, 'Nevada');
INSERT INTO `state` VALUES(29, 'New Hampshire');
INSERT INTO `state` VALUES(30, 'New Jersey');
INSERT INTO `state` VALUES(31, 'New Mexico');
INSERT INTO `state` VALUES(32, 'New York');
INSERT INTO `state` VALUES(33, 'North Carolina');
INSERT INTO `state` VALUES(34, 'North Dakota');
INSERT INTO `state` VALUES(35, 'Ohio');
INSERT INTO `state` VALUES(36, 'Oklahoma');
INSERT INTO `state` VALUES(37, 'Oregon');
INSERT INTO `state` VALUES(38, 'Pennsylvania');
INSERT INTO `state` VALUES(39, 'Rhode Island');
INSERT INTO `state` VALUES(40, 'South Carolina');
INSERT INTO `state` VALUES(41, 'South Dakota');
INSERT INTO `state` VALUES(42, 'Tennessee');
INSERT INTO `state` VALUES(43, 'Texas');
INSERT INTO `state` VALUES(44, 'Utah');
INSERT INTO `state` VALUES(45, 'Vermont');
INSERT INTO `state` VALUES(46, 'Virginia');
INSERT INTO `state` VALUES(47, 'Washington');
INSERT INTO `state` VALUES(48, 'West Virginia');
INSERT INTO `state` VALUES(49, 'Wisconsin');
INSERT INTO `state` VALUES(50, 'Wyoming');

-- --------------------------------------------------------

--
-- Table structure for table `text_flyers`
--

CREATE TABLE `text_flyers` (
  `text_flyer_id` int(11) NOT NULL AUTO_INCREMENT,
  `text_flyer_title` varchar(50) NOT NULL,
  `text_flyer_desc` text NOT NULL,
  `text_flyer_location` varchar(50) NOT NULL,
  `text_flyer_event_date` varchar(10) DEFAULT NULL,
  `text_flyer_contact_type_id` int(11) DEFAULT NULL,
  `text_flyer_contact_name` varchar(50) DEFAULT NULL,
  `text_flyer_contact_information` varchar(2083) DEFAULT NULL,
  `text_flyer_generate_qr_code` varchar(3) NOT NULL,
  `text_flyer_qr_code_location` varchar(2083) DEFAULT NULL,
  `text_flyer_users_cork_id` int(11) NOT NULL,
  `text_flyer_created_dttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`text_flyer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `text_flyers`
--

INSERT INTO `text_flyers` VALUES(1, 'test', 'test', 'test', '', 0, '', '', 'off', '', 1, '2012-01-17 13:48:44');
INSERT INTO `text_flyers` VALUES(2, 'test', 'test', 'test', '', 0, '', '', 'off', '', 1, '2012-01-17 14:52:05');
INSERT INTO `text_flyers` VALUES(3, 'test', 'test', 'test', '', 0, '', '', 'off', '', 1, '2012-01-17 15:01:54');
INSERT INTO `text_flyers` VALUES(4, 'New Text Flyer', 'New Text Flyer', 'My Home', '01/31/2012', 1, 'Christopher Bartholomew', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_4_1.png', 1, '2012-01-17 15:04:34');
INSERT INTO `text_flyers` VALUES(5, 'NowCorkIt.com - The digital corkboard', 'Text flyer', 'this is ', '01/17/2012', 1, 'Christopher Bartholomew', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_5_1.png', 1, '2012-01-17 15:07:33');
INSERT INTO `text_flyers` VALUES(6, 'Flyer Development', 'This is a flyer in development', 'My Home', '01/31/2012', 1, 'Christopher', 'cbartholomew@gmail.com', 'off', '', 1, '2012-01-19 23:56:27');
INSERT INTO `text_flyers` VALUES(7, 'testing edits', 'test', 'test', '01/31/2012', 1, 'test', 'test@test.com', 'on', 'flyers/qrcodes/qr_7_1.png', 1, '2012-01-19 23:57:19');
INSERT INTO `text_flyers` VALUES(8, 'Flyer Test One', 'Flyer Test Two', 'This Location', '01/31/2012', 1, 'Christopher', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_8_1.png', 1, '2012-01-20 16:09:55');
INSERT INTO `text_flyers` VALUES(9, 'test', 'test', 'test', '', 0, '', '', 'off', '', 1, '2012-01-20 16:11:22');
INSERT INTO `text_flyers` VALUES(10, 'test', 'test', 'test', '', 0, '', '', 'off', '', 1, '2012-01-20 16:12:38');
INSERT INTO `text_flyers` VALUES(11, 'test', 'test', 'test', '', 0, '', '', 'off', '', 1, '2012-01-20 16:13:04');
INSERT INTO `text_flyers` VALUES(12, 'MINIFY', 'MINIFY TEST', 'Home', '01/24/2012', 1, 'Christopher Bartholomew', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_12_1.png', 1, '2012-01-24 01:24:59');
INSERT INTO `text_flyers` VALUES(13, 'This Should Post', 'This flyer should be the first flyer that shows on the corkboard', 'My house', '01/28/2012', 1, 'Christopher Bartholomew', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_13_1.png', 1, '2012-01-28 16:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `text_image_flyers`
--

CREATE TABLE `text_image_flyers` (
  `text_image_flyer_id` int(11) NOT NULL AUTO_INCREMENT,
  `text_image_flyer_title` varchar(50) NOT NULL,
  `text_image_flyer_desc` text NOT NULL,
  `text_image_flyer_location` varchar(50) NOT NULL,
  `text_image_flyer_event_date` varchar(10) DEFAULT NULL,
  `text_image_flyer_contact_type_id` int(11) DEFAULT NULL,
  `text_image_flyer_contact_name` varchar(50) DEFAULT NULL,
  `text_image_flyer_contact_information` varchar(2083) DEFAULT NULL,
  `text_image_flyer_generate_qr_code` varchar(3) NOT NULL,
  `text_image_flyer_qr_code_location` varchar(2083) DEFAULT NULL,
  `text_image_flyer_users_cork_id` int(11) NOT NULL,
  `text_image_flyer_image_meta_data_id` int(11) NOT NULL,
  `text_image_flyer_created_dttm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`text_image_flyer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `text_image_flyers`
--

INSERT INTO `text_image_flyers` VALUES(1, 'Heart', 'Heart', 'Heart', '01/18/2012', 1, 'Chri', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_1_1.png', 1, 1, '2012-01-17 15:03:45');
INSERT INTO `text_image_flyers` VALUES(2, 'Minfy w/ Image', 'Testing Minify w/ Images', 'Home', '01/24/2012', 1, 'Christopher Bartholomew', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_2_1.png', 1, 2, '2012-01-24 01:40:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_cork_id` bigint(50) unsigned NOT NULL AUTO_INCREMENT,
  `users_third_party_account_id` char(50) DEFAULT NULL,
  `users_third_party_account_type_id` int(11) DEFAULT NULL,
  `users_email` varchar(100) DEFAULT NULL,
  `users_hash` varchar(255) DEFAULT NULL,
  `users_first_name` varchar(50) NOT NULL,
  `users_last_name` varchar(50) NOT NULL,
  `users_state_id` int(2) NOT NULL DEFAULT '0',
  `users_subscription_type` tinyint(1) NOT NULL DEFAULT '0',
  `users_last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `users_account_disable` tinyint(1) NOT NULL DEFAULT '0',
  `users_created_dttm` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_login_count` int(11) NOT NULL,
  PRIMARY KEY (`users_cork_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, '105499867526169935261', 2, 'cbartholomew@gmail.com', NULL, 'Christopher', 'Bartholomew', 21, 0, '2012-05-01 14:35:13', 0, '2012-01-17 10:09:15', 19);
INSERT INTO `users` VALUES(6, '107446617003733349590', 2, 'bartcuw@gmail.com', '', 'Chris', 'Bartholomew', 0, 0, '2012-05-01 13:06:11', 0, '2012-05-01 11:08:25', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_flyers`
--

CREATE TABLE `users_flyers` (
  `users_flyers_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_flyers_users_cork_id` int(11) NOT NULL,
  `users_flyers_flyers_type_id` int(11) NOT NULL,
  `users_flyers_flyers_id` int(11) NOT NULL,
  PRIMARY KEY (`users_flyers_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users_flyers`
--

INSERT INTO `users_flyers` VALUES(1, 1, 1, 6);
INSERT INTO `users_flyers` VALUES(3, 1, 1, 8);
INSERT INTO `users_flyers` VALUES(5, 1, 2, 2);
INSERT INTO `users_flyers` VALUES(6, 1, 3, 1);
INSERT INTO `users_flyers` VALUES(7, 1, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `users_third_party_accounts_type`
--

CREATE TABLE `users_third_party_accounts_type` (
  `users_third_party_accounts_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_third_party_accounts_type_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`users_third_party_accounts_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users_third_party_accounts_type`
--

INSERT INTO `users_third_party_accounts_type` VALUES(1, 'Original');
INSERT INTO `users_third_party_accounts_type` VALUES(2, 'GooglePlus');
INSERT INTO `users_third_party_accounts_type` VALUES(3, 'Twitter');
INSERT INTO `users_third_party_accounts_type` VALUES(4, 'Facebook');
