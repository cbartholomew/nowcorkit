-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 50.63.228.94
-- Generation Time: Dec 08, 2011 at 04:25 PM
-- Server version: 5.0.91
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `nowcorkitdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `board_posting`
--

CREATE TABLE `board_posting` (
  `board_post_id` int(11) NOT NULL auto_increment,
  `board_post_board_id` int(11) NOT NULL,
  `board_post_users_flyers_id` int(11) NOT NULL,
  `board_post_users_cork_id` int(11) NOT NULL,
  `board_post_post_status_id` int(11) NOT NULL,
  `board_post_expire_dttm` date NOT NULL,
  `board_post_created_dttm` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`board_post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `board_posting`
--



-- --------------------------------------------------------

--
-- Table structure for table `board_preferences`
--

CREATE TABLE `board_preferences` (
  `board_id` int(11) NOT NULL auto_increment,
  `board_title` varchar(50) NOT NULL,
  `board_description` varchar(200) NOT NULL,
  `board_address` varchar(50) default NULL,
  `board_city` varchar(50) NOT NULL,
  `board_state_id` varchar(2) NOT NULL,
  `board_zip` varchar(10) NOT NULL,
  `board_permission_type_id` int(11) NOT NULL,
  `board_expiration_days` smallint(6) NOT NULL,
  `board_enable_shuffler` varchar(3) NOT NULL,
  `board_shuffler_interval` mediumint(9) default NULL,
  `board_pps_id` int(11) NOT NULL,
  `board_pps_cash_amount` decimal(10,2) default NULL,
  `board_pps_flyerdays` smallint(11) default NULL,
  `board_users_cork_id` int(11) NOT NULL,
  `board_created_dttm` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`board_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `board_preferences`
--


-- --------------------------------------------------------

--
-- Table structure for table `contact_type`
--

CREATE TABLE `contact_type` (
  `contact_type_id` int(11) NOT NULL auto_increment,
  `contact_type_desc` varchar(50) NOT NULL,
  PRIMARY KEY  (`contact_type_id`)
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
  `facebook_users_username` varchar(50) default NULL,
  `facebook_users_gender` varchar(1) NOT NULL,
  `facebook_users_locale` varchar(10) NOT NULL,
  `facebook_users_location_id` bigint(20) default NULL,
  `facebook_users_location_name` varchar(100) default NULL,
  PRIMARY KEY  (`facebook_users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='when using facebook oAuth, accounts will be placed in this t';

--
-- Dumping data for table `facebook_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `flyer_type`
--

CREATE TABLE `flyer_type` (
  `flyer_type_id` int(11) NOT NULL auto_increment,
  `flyer_type_desc` varchar(50) NOT NULL,
  `flyer_type_table_pointer` varchar(50) NOT NULL,
  PRIMARY KEY  (`flyer_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `flyer_type`
--

INSERT INTO `flyer_type` VALUES(1, 'text', 'text_flyers');
INSERT INTO `flyer_type` VALUES(2, 'text_image', 'text_image_flyers');
INSERT INTO `flyer_type` VALUES(3, 'image', 'image_flyers');

-- --------------------------------------------------------

--
-- Table structure for table `image_flyers`
--

CREATE TABLE `image_flyers` (
  `image_flyer_id` int(11) NOT NULL auto_increment,
  `image_flyer_title` varchar(50) NOT NULL,
  `image_flyer_image_meta_data_id` int(11) NOT NULL,
  `image_flyer_users_cork_id` int(11) NOT NULL,
  `image_flyer_created_dttm` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`image_flyer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `image_flyers`
--


-- --------------------------------------------------------

--
-- Table structure for table `image_meta_data`
--

CREATE TABLE `image_meta_data` (
  `image_meta_data_id` int(11) NOT NULL auto_increment,
  `image_meta_data_file_name` varchar(2083) NOT NULL,
  `image_meta_data_type` varchar(15) NOT NULL,
  `image_meta_data_size` bigint(20) NOT NULL,
  `image_meta_data_image_location` mediumtext NOT NULL,
  `image_meta_data_users_cork_id` int(11) NOT NULL,
  `image_meta_data_created_dttm` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`image_meta_data_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `image_meta_data`
--

INSERT INTO `image_meta_data` VALUES(1, '1_balloon_poster_outlined_150x150_p1.png', 'image/png', 38108, 'flyers/images/', 1, '2011-12-08 13:45:07');
INSERT INTO `image_meta_data` VALUES(2, '1_holidayparty.png', 'image/png', 327787, 'flyers/images/', 1, '2011-12-08 13:45:39');
INSERT INTO `image_meta_data` VALUES(3, '1_wallstreet460.jpg', 'image/jpeg', 50458, 'flyers/images/', 1, '2011-12-08 14:01:22');
INSERT INTO `image_meta_data` VALUES(4, '6_Publication1.jpg', 'image/jpeg', 99812, 'flyers/images/', 6, '2011-12-08 14:33:07');
INSERT INTO `image_meta_data` VALUES(5, '2_patrickstar.gif', 'image/gif', 51494, 'flyers/images/', 2, '2011-12-08 15:42:36');
INSERT INTO `image_meta_data` VALUES(6, '2_Christmas_Party_flyer_by_Rev3ngeR.jpg', 'image/jpeg', 365923, 'flyers/images/', 2, '2011-12-08 15:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `permission_type`
--

CREATE TABLE `permission_type` (
  `permission_type_id` int(11) NOT NULL auto_increment,
  `permission_type_desc` varchar(50) NOT NULL,
  PRIMARY KEY  (`permission_type_id`)
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
  `post_status_id` int(11) NOT NULL auto_increment,
  `post_status_desc` varchar(25) NOT NULL,
  PRIMARY KEY  (`post_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `post_status`
--

INSERT INTO `post_status` VALUES(1, 'Posted');
INSERT INTO `post_status` VALUES(2, 'Pending Approval');
INSERT INTO `post_status` VALUES(3, 'Not Approved');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `state_id` int(2) NOT NULL auto_increment,
  `state_desc` varchar(30) NOT NULL,
  PRIMARY KEY  (`state_id`)
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
  `text_flyer_id` int(11) NOT NULL auto_increment,
  `text_flyer_title` varchar(50) NOT NULL,
  `text_flyer_desc` text NOT NULL,
  `text_flyer_location` varchar(50) NOT NULL,
  `text_flyer_event_date` varchar(10) default NULL,
  `text_flyer_contact_type_id` int(11) default NULL,
  `text_flyer_contact_name` varchar(50) default NULL,
  `text_flyer_contact_information` varchar(2083) default NULL,
  `text_flyer_generate_qr_code` varchar(3) NOT NULL,
  `text_flyer_qr_code_location` varchar(2083) default NULL,
  `text_flyer_users_cork_id` int(11) NOT NULL,
  `text_flyer_created_dttm` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`text_flyer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `text_flyers`
--



CREATE TABLE `text_image_flyers` (
  `text_image_flyer_id` int(11) NOT NULL auto_increment,
  `text_image_flyer_title` varchar(50) NOT NULL,
  `text_image_flyer_desc` text NOT NULL,
  `text_image_flyer_location` varchar(50) NOT NULL,
  `text_image_flyer_event_date` varchar(10) default NULL,
  `text_image_flyer_contact_type_id` int(11) default NULL,
  `text_image_flyer_contact_name` varchar(50) default NULL,
  `text_image_flyer_contact_information` varchar(2083) default NULL,
  `text_image_flyer_generate_qr_code` varchar(3) NOT NULL,
  `text_image_flyer_qr_code_location` varchar(2083) default NULL,
  `text_image_flyer_users_cork_id` int(11) NOT NULL,
  `text_image_flyer_image_meta_data_id` int(11) NOT NULL,
  `text_image_flyer_created_dttm` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`text_image_flyer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `text_image_flyers`
--



-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_cork_id` bigint(20) NOT NULL auto_increment,
  `users_facebook_users_id` bigint(20) default NULL,
  `users_email` varchar(100) default NULL,
  `users_hash` varchar(255) default NULL,
  `users_first_name` varchar(50) NOT NULL,
  `users_last_name` varchar(50) NOT NULL,
  `users_state_id` int(2) NOT NULL,
  `users_subscription_type` tinyint(1) NOT NULL default '0',
  `users_last_login` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `users_account_disable` tinyint(1) NOT NULL default '0',
  `users_created_dttm` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`users_cork_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, NULL, 'cbartholomew@gmail.com', '$1$vPf/V5DG$X/6RoO9hQY42hgQCB/ibj1', 'Christopher', 'Bartholomew', 21, 0, '2011-12-07 17:54:38', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users_flyers`
--

CREATE TABLE `users_flyers` (
  `users_flyers_id` int(11) NOT NULL auto_increment,
  `users_flyers_users_cork_id` int(11) NOT NULL,
  `users_flyers_flyers_type_id` int(11) NOT NULL,
  `users_flyers_flyers_id` int(11) NOT NULL,
  PRIMARY KEY  (`users_flyers_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;


