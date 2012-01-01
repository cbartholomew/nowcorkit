-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 01, 2012 at 04:54 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `board_posting`
--

INSERT INTO `board_posting` VALUES(8, 1, 5, 0, 3, '2012-01-12', '2011-12-13 19:34:10');
INSERT INTO `board_posting` VALUES(9, 2, 5, 3, 1, '2012-01-12', '2011-12-13 19:36:03');
INSERT INTO `board_posting` VALUES(10, 2, 2, 2, 3, '2012-01-31', '2012-01-01 15:38:55');
INSERT INTO `board_posting` VALUES(11, 2, 7, 2, 1, '2012-01-31', '2012-01-01 15:38:59');
INSERT INTO `board_posting` VALUES(12, 2, 9, 2, 1, '2012-01-31', '2012-01-01 15:39:02');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `board_preferences`
--

INSERT INTO `board_preferences` VALUES(1, 'Test Board', 'This is a test board', '', 'Rockland', '21', '02370', 3, 30, 'off', 0, 1, 0.00, 0, '', 2, '2011-12-12 18:26:41');
INSERT INTO `board_preferences` VALUES(2, 'Chris Test Chrome', 'testing chrome', '51 Maple Street', 'Rockland ', '21', '02370', 1, 30, '', 0, 2, 0.00, 10, 'Paypal invoice : cbartholomew@gmail.com', 2, '2011-12-12 20:36:56');
INSERT INTO `board_preferences` VALUES(3, 'New Test', 'This is a test ', '', 'rockland', '21', '02370', 3, 30, '', 0, 3, 0.00, 12, 'This is a test to see if this can be handled. \n\nNow for the update.', 2, '2012-01-01 11:25:26');

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
  `facebook_users_id` bigint(20) NOT NULL,
  `facebook_users_name` varchar(100) NOT NULL,
  `facebook_users_first_name` varchar(50) NOT NULL,
  `facebook_users_last_name` varchar(50) NOT NULL,
  `facebook_users_link` varchar(100) NOT NULL,
  `facebook_users_username` varchar(50) DEFAULT NULL,
  `facebook_users_gender` varchar(1) NOT NULL,
  `facebook_users_locale` varchar(10) NOT NULL,
  `facebook_users_location_id` bigint(20) DEFAULT NULL,
  `facebook_users_location_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`facebook_users_id`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `forgot_password`
--

INSERT INTO `forgot_password` VALUES(13, '0f7296e2fb2542ec588a300633c7430a', '2011-12-27 20:42:30', 'cbartholomew@gmail.com', 1, 'xfxClNK+7u+rgM500VprqxI9zG3ysjOb7diy+0QqQX8=');
INSERT INTO `forgot_password` VALUES(14, 'a6510f951c6e29d02a02b4ba60add214', '2011-12-27 20:42:30', 'cbartholomew@gmail.com', 1, 'gNbJ%2FyfCk0u2%2BD8n%2F69IRpgnMdiJjS8%2BXEywRs%2B17Xk%3D');
INSERT INTO `forgot_password` VALUES(15, 'ef5c272f60dc6f51e445879345f29985', '2011-12-27 20:42:30', 'cbartholomew@gmail.com', 1, '4pPq0UTvVukVj%2B8rM9wMElt2%2F8whaYhSEh2%2FoAQJvsY%3D');
INSERT INTO `forgot_password` VALUES(16, '2e7329c35bbc96d8dfd0e485eff34cff', '2011-12-27 20:42:30', 'cbartholomew@gmail.com', 1, '%2FmNQz0mQT1%2FdxKMnNmlZVIDiSNZPMRpJapcc4rYnegw%3D');
INSERT INTO `forgot_password` VALUES(17, '1fad3924246e9e3fdd048d706c5280dc', '2011-12-31 12:44:16', 'cbartholomew@gmail.com', 1, 'YmyqdljGkjmXRDI8ILbnrkpZekVhjvL2BsEwCoT7m8A%3D');
INSERT INTO `forgot_password` VALUES(18, '8d3c6ac19d7bc894cf08915e881a043e', '2011-12-31 16:27:14', 'cbartholomew@gmail.com', 1, 'rGvDEhmH3E8TW2%2BiamHyIY93VPwYSPaWB1bK7Pw3ync%3D');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `image_flyers`
--

INSERT INTO `image_flyers` VALUES(1, 'CS50 Fair', 2, 2, '2011-12-08 11:00:52');
INSERT INTO `image_flyers` VALUES(2, 'Owl', 3, 2, '2011-12-08 11:08:39');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `image_meta_data`
--

INSERT INTO `image_meta_data` VALUES(1, '2_beaver_mask_august14.jpg', 'image/jpeg', 17545, 'flyers/images/', 2, '2011-12-08 11:00:18');
INSERT INTO `image_meta_data` VALUES(2, '2_balloon_poster_outlined_150x150_p1.png', 'image/png', 38108, 'flyers/images/', 2, '2011-12-08 11:00:52');
INSERT INTO `image_meta_data` VALUES(3, '2_374706_10100707866586588_10728273_59733166_561711987_n.jpg', 'image/jpeg', 73241, 'flyers/images/', 2, '2011-12-08 11:08:39');
INSERT INTO `image_meta_data` VALUES(5, '2_owl.jpg', 'image/jpeg', 58455, 'flyers/images/', 2, '2011-12-12 18:33:25');
INSERT INTO `image_meta_data` VALUES(6, '2_selbillboard.png', 'image/png', 6790, 'flyers/images/', 2, '2011-12-12 20:35:53');
INSERT INTO `image_meta_data` VALUES(7, '2_null', 'null', 0, 'null', 2, '2011-12-14 19:05:45');
INSERT INTO `image_meta_data` VALUES(8, '2_null', 'null', 0, 'null', 2, '2011-12-14 19:18:46');
INSERT INTO `image_meta_data` VALUES(9, '2_beaver_mask_august14.jpg', 'image/jpeg', 17545, 'flyers/images/', 2, '2011-12-31 17:40:13');
INSERT INTO `image_meta_data` VALUES(10, '2_wallstreet460.jpg', 'image/jpeg', 50458, 'flyers/images/', 2, '2011-12-31 18:14:46');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `post_status`
--

INSERT INTO `post_status` VALUES(1, 'Posted');
INSERT INTO `post_status` VALUES(2, 'Pending Approval');
INSERT INTO `post_status` VALUES(3, 'Not Approved');
INSERT INTO `post_status` VALUES(4, 'PPS Posted');
INSERT INTO `post_status` VALUES(5, 'PPS Queue');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `text_flyers`
--

INSERT INTO `text_flyers` VALUES(1, 'Heyo This is a Text Flyer', 'Text Flyer ', 'My Location', '12/08/2011', 1, 'Christopher Bartholomew', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_1_2.png', 2, '2011-12-08 10:52:12');
INSERT INTO `text_flyers` VALUES(2, 'Testing QR Codes', 'This is a test for QR codes', 'location', '12/09/2011', 0, '', '', 'on', 'flyers/qrcodes/qr_2_2.png', 2, '2011-12-08 12:43:30');
INSERT INTO `text_flyers` VALUES(3, 'This is a text flyer', 'Hello, this is my special test text file that i will be using to test', 'Home', '12/14/2011', 1, 'Christopher Bartholomew', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_3_2.png', 2, '2011-12-12 20:27:51');
INSERT INTO `text_flyers` VALUES(4, 'Text Flyer', 'This is a text flyer', 'Testing', '', 0, '', '', 'off', '', 3, '2011-12-13 19:30:16');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `text_image_flyers`
--

INSERT INTO `text_image_flyers` VALUES(1, 'Testing text and Image', 'text and Image flyer', 'some location', '12/16/2011', 1, 'Christopher Bartholomew', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_1_2.png', 2, 1, '2011-12-08 11:00:18');
INSERT INTO `text_image_flyers` VALUES(2, 'Testing Owl', 'This is a test Owl', 'Some Location', '', 0, '', '', 'on', 'flyers/qrcodes/qr_2_2.png', 2, 4, '2011-12-12 18:25:34');
INSERT INTO `text_image_flyers` VALUES(3, 'Test Image Flyer', 'Test Image Flyer', 'some location', '12/03/2011', 0, '', '', 'on', 'flyers/qrcodes/qr_3_2.png', 2, 5, '2011-12-12 18:33:25');
INSERT INTO `text_image_flyers` VALUES(4, 'Shield\\''s MRI blah ', 'Blah Testing Image & Text flyers for chrome os', 'Home', '12/12/2011', 1, 'Christopher Bartholomew', 'cbartholomew@gmail.com', 'off', '', 2, 6, '2011-12-12 20:35:53');
INSERT INTO `text_image_flyers` VALUES(5, 'test', 'test', 'test', '', 0, '', '', 'off', '', 2, 7, '2011-12-14 19:05:45');
INSERT INTO `text_image_flyers` VALUES(6, 'test', 'test', 'test', '', 0, '', '', 'off', '', 2, 8, '2011-12-14 19:18:46');
INSERT INTO `text_image_flyers` VALUES(7, 'Test Image', 'Test Image', 'Some Location', '12/31/2011', 0, 'Christopher Bartholomew', '', 'off', '', 2, 9, '2011-12-31 17:40:13');
INSERT INTO `text_image_flyers` VALUES(8, 'WallStreet Image', 'This is a test to see if the QR Code freaks out on the board after the recent adjustments', 'here', '12/31/2011', 1, 'Christopher Bartholomew', 'cbartholomew@gmail.com', 'on', 'flyers/qrcodes/qr_8_2.png', 2, 10, '2011-12-31 18:14:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_cork_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `users_facebook_users_id` bigint(20) DEFAULT NULL,
  `users_email` varchar(100) DEFAULT NULL,
  `users_hash` varchar(255) DEFAULT NULL,
  `users_first_name` varchar(50) NOT NULL,
  `users_last_name` varchar(50) NOT NULL,
  `users_state_id` int(2) NOT NULL,
  `users_subscription_type` tinyint(1) NOT NULL DEFAULT '0',
  `users_last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `users_account_disable` tinyint(1) NOT NULL DEFAULT '0',
  `users_created_dttm` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_login_count` int(11) NOT NULL,
  PRIMARY KEY (`users_cork_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(2, NULL, 'cbartholomew@gmail.com', '$1$c00w5vkb$IM8VxY4kyAvqbxVzqG.12.', 'Christopher', 'Bartholomew', 21, 0, '2012-01-01 12:31:51', 0, '0000-00-00 00:00:00', 6);
INSERT INTO `users` VALUES(3, NULL, 'bartc@u.washington.edu', '$1$N/VXWqQI$t.tsaQ3g3VUhggGPOeJif.', 'Christopher', 'Bartholomew', 47, 0, '2011-12-13 19:29:45', 0, '2011-12-12 19:10:04', 0);
INSERT INTO `users` VALUES(4, NULL, 'newtest@gmail.com', '$1$0uAaQBYF$Q4YVz1ymOh.2yyFAchUhN0', 'Christopher', 'Bartholomew', 47, 0, '2011-12-12 19:12:55', 0, '2011-12-12 19:12:55', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users_flyers`
--

INSERT INTO `users_flyers` VALUES(2, 2, 2, 3);
INSERT INTO `users_flyers` VALUES(3, 2, 1, 3);
INSERT INTO `users_flyers` VALUES(4, 2, 2, 4);
INSERT INTO `users_flyers` VALUES(5, 3, 1, 4);
INSERT INTO `users_flyers` VALUES(6, 2, 2, 5);
INSERT INTO `users_flyers` VALUES(7, 2, 2, 6);
INSERT INTO `users_flyers` VALUES(8, 2, 2, 7);
INSERT INTO `users_flyers` VALUES(9, 2, 2, 8);
