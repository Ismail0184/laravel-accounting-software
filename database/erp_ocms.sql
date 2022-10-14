-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2015 at 08:41 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `erp_ocms`
--

-- --------------------------------------------------------

--
-- Table structure for table `acc_audits`
--

CREATE TABLE IF NOT EXISTS `acc_audits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `vnumber` int(11) NOT NULL,
  `note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `sendto` int(11) NOT NULL,
  `audit_action` int(11) NOT NULL,
  `reply_id` int(11) NOT NULL,
  `reply_note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `audits_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_audits`
--

INSERT INTO `acc_audits` (`id`, `title`, `vnumber`, `note`, `sendto`, `audit_action`, `reply_id`, `reply_note`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Qoutation needed', 3, 'There is no Qoutation', 4, 1, 1, 'Yes\r\nAdded\r\nSee again', 1, '2015-07-04 23:13:15', '2015-07-05 00:05:54');

-- --------------------------------------------------------

--
-- Table structure for table `acc_budgets`
--

CREATE TABLE IF NOT EXISTS `acc_budgets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `btype` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `byear` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_budgets_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `acc_budgets`
--

INSERT INTO `acc_budgets` (`id`, `name`, `btype`, `byear`, `account_id`, `amount`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Revenue Budget', 'Monthly', 2015, 7, 50000, 1, '2015-06-28 23:50:54', '2015-06-28 23:50:54'),
(3, 'Capital Budget', 'Yearly', 2015, 7, 70000, 1, '2015-06-29 00:04:15', '2015-06-29 00:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `acc_buyerinfos`
--

CREATE TABLE IF NOT EXISTS `acc_buyerinfos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `skype` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_buyerinfos_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_buyerinfos`
--

INSERT INTO `acc_buyerinfos` (`id`, `name`, `contact`, `address`, `country_id`, `email`, `phone`, `skype`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'ABC Company Ltd.', 'Hasan Habib', 'London', 1, 'hasanhabib2009@gmail.com', '01685494832', 'hasan2009', 4, '2015-06-27 22:07:51', '2015-06-27 22:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `acc_clients`
--

CREATE TABLE IF NOT EXISTS `acc_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `skype` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `businessn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_clients_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_clients`
--

INSERT INTO `acc_clients` (`id`, `name`, `contact`, `address1`, `address2`, `email`, `phone`, `skype`, `businessn`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'PQR Company Ltd.', 'Hasan Habib', 'Uttara, Dhaka', 'same', 'hasanhabib2009@gmail.com', '01685494832', 'hasan2009', 'qwe', 1, '2015-06-28 02:45:25', '2015-06-28 02:48:49');

-- --------------------------------------------------------

--
-- Table structure for table `acc_coaconditions`
--

CREATE TABLE IF NOT EXISTS `acc_coaconditions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `maxamount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remainder1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remainder2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remainder3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `depreciatetion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `monthly` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_coaconditions_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `acc_coadetails`
--

CREATE TABLE IF NOT EXISTS `acc_coadetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `acc_id` int(11) NOT NULL,
  `contact` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `accountGroup_id` int(11) NOT NULL,
  `businessn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_coadetails_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `acc_coas`
--

CREATE TABLE IF NOT EXISTS `acc_coas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  `topGroup_id` int(11) NOT NULL,
  `sl` int(11) NOT NULL,
  `atype` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `detail_id` int(10) unsigned NOT NULL,
  `cond_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_coas_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `acc_coas`
--

INSERT INTO `acc_coas` (`id`, `name`, `group_id`, `topGroup_id`, `sl`, `atype`, `detail_id`, `cond_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Balance Sheet', 0, 0, 1, 'Group', 0, 0, 1, '2015-06-28 23:26:07', '2015-06-28 23:26:07'),
(3, 'Profit and Loss Account', 0, 0, 2, 'Group', 0, 0, 1, '2015-06-28 23:28:27', '2015-06-28 23:28:27'),
(4, 'Fixed Asset', 1, 1, 1, 'Group', 0, 0, 1, '2015-06-28 23:32:11', '2015-06-28 23:32:11'),
(6, 'Office Equipment', 4, 1, 1, 'Group', 0, 0, 1, '2015-06-28 23:32:41', '2015-06-28 23:32:41'),
(7, 'Computer', 6, 1, 1, 'Account', 0, 0, 1, '2015-06-28 23:32:59', '2015-06-28 23:32:59'),
(8, 'Printer', 6, 1, 2, 'Account', 0, 0, 1, '2015-06-28 23:37:35', '2015-06-30 01:02:28'),
(9, 'Machinery Equipment', 4, 1, 2, 'Group', 0, 0, 1, '2015-06-28 23:38:12', '2015-06-28 23:38:12'),
(10, 'Current Asset', 1, 0, 2, 'Group', 0, 0, 1, '2015-06-28 23:38:37', '2015-06-28 23:38:37'),
(11, 'Cash and Bank', 1, 1, 3, 'Group', 0, 0, 1, '2015-06-30 00:27:15', '2015-06-30 00:27:15'),
(12, 'Bank Account', 11, 1, 1, 'Group', 0, 0, 1, '2015-06-30 00:27:41', '2015-06-30 00:27:41'),
(14, 'Cash Account', 11, 1, 2, 'Group', 0, 0, 1, '2015-06-30 00:28:15', '2015-06-30 00:28:15'),
(15, 'Cash Account', 11, 1, 2, 'Group', 0, 0, 1, '2015-06-30 00:28:15', '2015-06-30 00:28:15'),
(16, 'Main Cash', 14, 1, 1, 'Account', 0, 0, 1, '2015-06-30 00:28:36', '2015-06-30 00:29:37'),
(17, 'Petty Cash Factory', 14, 1, 2, 'Account', 0, 0, 1, '2015-06-30 00:29:10', '2015-06-30 00:30:07'),
(20, 'Bills Receivable', 10, 1, 1, 'Group', 0, 0, 1, '2015-07-02 00:44:06', '2015-07-02 00:44:06'),
(21, 'ABC Company Ltd.', 20, 1, 1, 'Account', 0, 0, 1, '2015-07-02 00:44:35', '2015-07-02 00:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `acc_companies`
--

CREATE TABLE IF NOT EXISTS `acc_companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `faddress2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `web` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stablish` date NOT NULL,
  `businessn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `md` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `chair` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `d1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `d2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `d3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `companies_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_companies`
--

INSERT INTO `acc_companies` (`id`, `name`, `oaddress`, `faddress2`, `mobile`, `phone`, `fax`, `email`, `web`, `stablish`, `businessn`, `md`, `chair`, `d1`, `d2`, `d3`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'OCMS', 'H#47, R#07, S#12, Uttara, Dhaka-1230', '', '', '', '', '', '', '2015-07-03', '', '', '', '', '', '', 1, '2015-07-02 22:32:14', '2015-07-02 22:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `acc_currencies`
--

CREATE TABLE IF NOT EXISTS `acc_currencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_currencies_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `acc_currencies`
--

INSERT INTO `acc_currencies` (`id`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Dollar', 1, '2015-07-04 22:39:10', '2015-07-04 22:39:10'),
(2, 'EURO', 1, '2015-07-04 22:39:10', '2015-07-04 22:40:33'),
(3, 'Taka', 1, '2015-07-04 22:40:48', '2015-07-04 22:41:07');

-- --------------------------------------------------------

--
-- Table structure for table `acc_frequisitions`
--

CREATE TABLE IF NOT EXISTS `acc_frequisitions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ramount` int(11) NOT NULL,
  `aamount` int(11) NOT NULL,
  `check_id` int(11) NOT NULL,
  `check_action` int(11) NOT NULL,
  `check_note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `appr_id` int(11) NOT NULL,
  `appr_action` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_frequisitions_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_frequisitions`
--

INSERT INTO `acc_frequisitions` (`id`, `name`, `ramount`, `aamount`, `check_id`, `check_action`, `check_note`, `appr_id`, `appr_action`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '1', 6000, 0, 1, 0, '', 0, 0, 1, '2015-06-29 00:58:40', '2015-06-29 01:10:02'),
(2, '1', 5000, 0, 1, 0, '', 0, 0, 1, '2015-06-29 01:07:48', '2015-06-29 01:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `acc_importdetails`
--

CREATE TABLE IF NOT EXISTS `acc_importdetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `im_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_importdetails_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_importdetails`
--

INSERT INTO `acc_importdetails` (`id`, `im_id`, `item_id`, `qty`, `unit_id`, `rate`, `amount`, `currency_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 2, 1, 35000, 70000, 0, 1, '2015-06-28 03:23:19', '2015-06-28 03:23:19'),
(2, 2, 9, 1, 1, 3500, 3500, 0, 1, '2015-06-28 03:24:47', '2015-06-28 03:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `acc_importmasters`
--

CREATE TABLE IF NOT EXISTS `acc_importmasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `idate` date NOT NULL,
  `lcimport_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_importmasters_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_importmasters`
--

INSERT INTO `acc_importmasters` (`id`, `invoice`, `idate`, `lcimport_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'ZAQ 1234', '2015-06-28', 1, 1, '2015-06-28 03:11:50', '2015-06-28 03:11:50'),
(2, '123', '2015-06-22', 1, 1, '2015-06-28 03:24:31', '2015-06-28 03:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `acc_invendetails`
--

CREATE TABLE IF NOT EXISTS `acc_invendetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `im_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `invendetails_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_invendetails`
--

INSERT INTO `acc_invendetails` (`id`, `im_id`, `item_id`, `qty`, `unit_id`, `rate`, `amount`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 1, 1, 3500, 3500, 1, '2015-07-05 23:29:34', '2015-07-05 23:29:34'),
(2, 2, 9, -1, 1, 3500, 3500, 1, '2015-07-05 23:31:32', '2015-07-05 23:31:32');

-- --------------------------------------------------------

--
-- Table structure for table `acc_invenmasters`
--

CREATE TABLE IF NOT EXISTS `acc_invenmasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vnumber` int(11) NOT NULL,
  `idate` date NOT NULL,
  `person` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `itype` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `req_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `currency_id` int(11) NOT NULL,
  `check_id` int(11) NOT NULL,
  `check_action` int(11) NOT NULL,
  `check_note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `audit_id` int(11) NOT NULL,
  `audit_action` int(11) NOT NULL,
  `audit_note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `com_id` int(11) NOT NULL,
  `proj_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `invenmasters_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_invenmasters`
--

INSERT INTO `acc_invenmasters` (`id`, `vnumber`, `idate`, `person`, `itype`, `req_id`, `amount`, `note`, `currency_id`, `check_id`, `check_action`, `check_note`, `audit_id`, `audit_action`, `audit_note`, `com_id`, `proj_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2015-07-06', 'Hasan Habib', 'Receive', 1, 3500, 'For Hasan Habib', 3, 4, 0, '', 0, 0, '', 0, 0, 1, '2015-07-05 23:25:20', '2015-07-05 23:30:01'),
(2, 2, '2015-07-06', 'Hasan Habib', 'Issue', 1, 0, '', 3, 1, 0, '', 0, 0, '', 0, 0, 1, '2015-07-05 23:31:06', '2015-07-05 23:31:06');

-- --------------------------------------------------------

--
-- Table structure for table `acc_lcimports`
--

CREATE TABLE IF NOT EXISTS `acc_lcimports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lcnumber` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `lcdate` date NOT NULL,
  `shipmentdate` date NOT NULL,
  `expdate` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `lcvalue` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `lcqty` int(11) NOT NULL,
  `unit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_lcimports_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_lcimports`
--

INSERT INTO `acc_lcimports` (`id`, `lcnumber`, `lcdate`, `shipmentdate`, `expdate`, `supplier_id`, `country_id`, `lcvalue`, `currency_id`, `lcqty`, `unit`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'XYZ 123456', '2015-06-01', '2015-06-02', '2015-06-03', 1, 1, 10500, 1, 1234, '1', 1, '2015-06-28 00:19:26', '2015-06-28 00:20:40');

-- --------------------------------------------------------

--
-- Table structure for table `acc_lcinfos`
--

CREATE TABLE IF NOT EXISTS `acc_lcinfos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lcnumber` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `lcdate` date NOT NULL,
  `shipmentdate` date NOT NULL,
  `expdate` date NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `lcamount` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `productdetails` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_lcinfos_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_lcinfos`
--

INSERT INTO `acc_lcinfos` (`id`, `lcnumber`, `lcdate`, `shipmentdate`, `expdate`, `buyer_id`, `country_id`, `lcamount`, `currency_id`, `qty`, `unit_id`, `productdetails`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'XYZ 123456', '2015-06-24', '2015-06-24', '2015-06-24', 1, 1, 105000, 1, 2000, 1, '', 4, '2015-06-27 22:37:43', '2015-06-27 22:43:50');

-- --------------------------------------------------------

--
-- Table structure for table `acc_options`
--

CREATE TABLE IF NOT EXISTS `acc_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bstype` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `export` int(11) NOT NULL,
  `import` int(11) NOT NULL,
  `scenter` int(11) NOT NULL,
  `budget` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `audit` int(11) NOT NULL,
  `inventory` int(11) NOT NULL,
  `tcheck_id` int(11) NOT NULL,
  `tappr_id` int(11) NOT NULL,
  `rcheck_id` int(11) NOT NULL,
  `rappr_id` int(11) NOT NULL,
  `frcheck_id` int(11) NOT NULL,
  `frappr_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `options_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_options`
--

INSERT INTO `acc_options` (`id`, `bstype`, `export`, `import`, `scenter`, `budget`, `project`, `audit`, `inventory`, `tcheck_id`, `tappr_id`, `rcheck_id`, `rappr_id`, `frcheck_id`, `frappr_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'gf', 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, '2015-07-03 04:03:53', '2015-07-04 02:36:51');

-- --------------------------------------------------------

--
-- Table structure for table `acc_orderinfos`
--

CREATE TABLE IF NOT EXISTS `acc_orderinfos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ordernumber` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `lcnumber` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ordervalue` int(11) NOT NULL,
  `orderqty` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `productdetails` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_orderinfos_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_orderinfos`
--

INSERT INTO `acc_orderinfos` (`id`, `ordernumber`, `lcnumber`, `ordervalue`, `orderqty`, `unit_id`, `productdetails`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'MNO 123456', '1', 5000, 200, 1, '', 4, '2015-06-27 22:57:06', '2015-06-27 23:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `acc_outlets`
--

CREATE TABLE IF NOT EXISTS `acc_outlets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `emp_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_outlets_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_outlets`
--

INSERT INTO `acc_outlets` (`id`, `name`, `emp_id`, `address`, `mobile`, `email`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Uttara Jonopath', 1, 'Uttara, Dhaka', '01685494832', 'hasanhabib2009@gmail.com', 1, '2015-06-28 22:56:30', '2015-06-28 23:04:29'),
(2, 'Uttara Jonopath', 1, 'Uttara, Dhaka', '01685494832', 'sazzad@ocmsbd.com', 1, '2015-06-28 23:13:53', '2015-06-28 23:14:10');

-- --------------------------------------------------------

--
-- Table structure for table `acc_pbudgets`
--

CREATE TABLE IF NOT EXISTS `acc_pbudgets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `seg_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `cur_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pbudgets_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_pbudgets`
--

INSERT INTO `acc_pbudgets` (`id`, `pro_id`, `seg_id`, `prod_id`, `qty`, `unit_id`, `cur_id`, `rate`, `amount`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 9, 12, 4, 3, 3500, 42000, 1, '2015-07-07 23:59:36', '2015-07-07 23:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `acc_pplannings`
--

CREATE TABLE IF NOT EXISTS `acc_pplannings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `segment` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `stdate` date NOT NULL,
  `cldate` date NOT NULL,
  `bamount` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `gtype` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sl` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pplannings_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `acc_pplannings`
--

INSERT INTO `acc_pplannings` (`id`, `pro_id`, `segment`, `stdate`, `cldate`, `bamount`, `group_id`, `gtype`, `sl`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Fishing Project Planning', '2015-07-07', '2015-07-07', 60000, 0, 'Group', 0, 1, '2015-07-06 22:38:11', '2015-07-06 23:58:14'),
(2, 1, 'Digging Pount', '2015-07-07', '2015-07-07', 10000, 1, 'Group', 0, 1, '2015-07-06 22:40:22', '2015-07-06 23:58:30'),
(3, 1, 'Pona', '2015-07-07', '2015-07-07', 10000, 1, '', 0, 1, '2015-07-06 22:41:49', '2015-07-06 22:41:49'),
(4, 1, 'Maketing', '2015-07-07', '2015-07-07', 5000, 1, 'Account', 0, 1, '2015-07-06 22:42:54', '2015-07-07 00:00:34'),
(5, 1, 'Labour', '2015-07-07', '2015-07-07', 4500, 2, 'Group', 0, 1, '2015-07-06 22:43:33', '2015-07-06 23:59:20'),
(6, 1, 'Daily', '2015-07-07', '2015-07-07', 2000, 5, 'Account', 0, 1, '2015-07-06 22:53:06', '2015-07-06 23:59:42'),
(7, 1, 'Soil Filling', '2015-07-07', '2015-07-07', 10000, 2, 'Account', 0, 1, '2015-07-06 23:39:56', '2015-07-07 00:00:14');

-- --------------------------------------------------------

--
-- Table structure for table `acc_prequisitions`
--

CREATE TABLE IF NOT EXISTS `acc_prequisitions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `rtypes` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `check_id` int(11) NOT NULL,
  `check_action` int(11) NOT NULL,
  `check_note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `appr_id` int(11) NOT NULL,
  `appr_action` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_prequisitions_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `acc_prequisitions`
--

INSERT INTO `acc_prequisitions` (`id`, `name`, `description`, `amount`, `acc_id`, `rtypes`, `check_id`, `check_action`, `check_note`, `appr_id`, `appr_action`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Office Equipment', 'For ERP', 70000, 7, 'n', 1, 1, 'ok', 1, 0, 1, '2015-06-29 00:13:21', '2015-06-29 00:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `acc_products`
--

CREATE TABLE IF NOT EXISTS `acc_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  `topGroup_id` int(11) NOT NULL,
  `ptype` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `sl` int(11) NOT NULL,
  `detail_id` int(11) NOT NULL,
  `cond_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_products_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `acc_products`
--

INSERT INTO `acc_products` (`id`, `name`, `group_id`, `topGroup_id`, `ptype`, `sl`, `detail_id`, `cond_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Office', 0, 0, 'Top Group', 1, 0, 0, 1, '2015-06-28 00:54:20', '2015-06-28 00:59:39'),
(2, 'Knitting', 0, 0, 'Top Group', 2, 0, 0, 1, '2015-06-28 00:54:39', '2015-06-28 00:57:22'),
(4, 'Dyeing', 0, 0, 'Top Group', 3, 0, 0, 1, '2015-06-28 00:57:47', '2015-06-28 00:57:47'),
(5, 'Office Equipment', 1, 1, 'Group', 1, 0, 0, 1, '2015-06-28 01:00:02', '2015-06-28 01:00:02'),
(6, 'Desktop', 5, 1, 'Product', 1, 0, 0, 1, '2015-06-28 01:03:56', '2015-06-28 01:03:56'),
(7, 'Laptop', 5, 1, 'Product', 2, 0, 0, 1, '2015-06-28 01:04:19', '2015-06-28 01:04:19'),
(9, 'Printer', 5, 1, 'Product', 3, 0, 0, 1, '2015-06-28 01:08:32', '2015-06-28 01:08:32');

-- --------------------------------------------------------

--
-- Table structure for table `acc_projects`
--

CREATE TABLE IF NOT EXISTS `acc_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cost` int(11) NOT NULL,
  `pdate` date NOT NULL,
  `sdate` date NOT NULL,
  `fdate` date NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `projects_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_projects`
--

INSERT INTO `acc_projects` (`id`, `name`, `description`, `location`, `cost`, `pdate`, `sdate`, `fdate`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Fishing Project', 'Fishing', 'Gazipur', 100000, '2015-07-02', '2015-07-02', '2015-07-02', 1, '2015-07-02 04:19:02', '2015-07-02 04:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `acc_purchasedetails`
--

CREATE TABLE IF NOT EXISTS `acc_purchasedetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pm_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_purchasedetails_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `acc_purchasedetails`
--

INSERT INTO `acc_purchasedetails` (`id`, `pm_id`, `item_id`, `qty`, `unit_id`, `rate`, `amount`, `currency_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 1, 3, 3500, 3500, 3, 4, '2015-06-28 03:33:03', '2015-06-28 22:25:09'),
(2, 3, 7, 1, 1, 14000, 14000, 3, 4, '2015-06-28 03:38:15', '2015-06-28 03:38:15'),
(3, 0, 0, 0, 0, 0, 70000, 0, 1, '2015-06-29 22:35:38', '2015-06-29 22:35:38');

-- --------------------------------------------------------

--
-- Table structure for table `acc_purchasemasters`
--

CREATE TABLE IF NOT EXISTS `acc_purchasemasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `pdate` date NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `vat_tax` int(11) NOT NULL,
  `transport` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `previous_due` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_purchasemasters_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `acc_purchasemasters`
--

INSERT INTO `acc_purchasemasters` (`id`, `invoice`, `pdate`, `client_id`, `client_address`, `amount`, `discount`, `vat_tax`, `transport`, `paid`, `previous_due`, `balance`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '123', '2015-06-08', 1, '', 0, 0, 0, 0, 0, 0, 0, 4, '2015-06-28 03:26:37', '2015-06-28 03:26:37'),
(2, 'ZAQ 1234', '2015-06-28', 1, 'Uttara, Dhaka', 0, 0, 0, 0, 0, 0, 0, 4, '2015-06-28 03:34:00', '2015-06-28 03:34:00'),
(3, 'ZAQ 1234', '2015-06-08', 1, 'Uttara, Dhaka', 0, 0, 0, 0, 0, 0, 0, 4, '2015-06-28 03:37:55', '2015-06-28 03:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `acc_saledetails`
--

CREATE TABLE IF NOT EXISTS `acc_saledetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sm_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_saledetails_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_saledetails`
--

INSERT INTO `acc_saledetails` (`id`, `sm_id`, `item_id`, `qty`, `unit_id`, `rate`, `amount`, `currency_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 1, 1, 3500, '3500', 3, 1, '2015-06-28 22:47:11', '2015-06-28 22:47:11'),
(2, 2, 7, 2, 1, 14000, '28000', 3, 1, '2015-06-28 22:49:02', '2015-06-28 22:49:02');

-- --------------------------------------------------------

--
-- Table structure for table `acc_salemasters`
--

CREATE TABLE IF NOT EXISTS `acc_salemasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `sdate` date NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `vat_tax` int(11) NOT NULL,
  `pre_due` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_salemasters_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_salemasters`
--

INSERT INTO `acc_salemasters` (`id`, `invoice`, `sdate`, `client_id`, `client_address`, `amount`, `discount`, `vat_tax`, `pre_due`, `paid`, `balance`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '1', '2015-06-29', 1, '', 3500, 0, 0, 0, 3500, 0, 1, '2015-06-28 22:45:31', '2015-06-28 22:47:44'),
(2, '2', '2015-06-29', 1, '', 28000, 0, 0, 0, 20000, 0, 1, '2015-06-28 22:48:44', '2015-06-28 22:52:43');

-- --------------------------------------------------------

--
-- Table structure for table `acc_settings`
--

CREATE TABLE IF NOT EXISTS `acc_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gname` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ccount` int(11) NOT NULL,
  `onem` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `m1` int(11) NOT NULL,
  `m2` int(11) NOT NULL,
  `m3` int(11) NOT NULL,
  `m4` int(11) NOT NULL,
  `m5` int(11) NOT NULL,
  `m6` int(11) NOT NULL,
  `m7` int(11) NOT NULL,
  `m8` int(11) NOT NULL,
  `m9` int(11) NOT NULL,
  `m10` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `settings_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_settings`
--

INSERT INTO `acc_settings` (`id`, `gname`, `ccount`, `onem`, `m1`, `m2`, `m3`, `m4`, `m5`, `m6`, `m7`, `m8`, `m9`, `m10`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Horizone', 5, 'm1', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, '2015-07-02 23:35:58', '2015-07-04 03:39:26');

-- --------------------------------------------------------

--
-- Table structure for table `acc_styles`
--

CREATE TABLE IF NOT EXISTS `acc_styles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ordernumber` int(11) NOT NULL,
  `stylevalue` int(11) NOT NULL,
  `styleqty` int(11) NOT NULL,
  `unit_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_styles_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_styles`
--

INSERT INTO `acc_styles` (`id`, `name`, `ordernumber`, `stylevalue`, `styleqty`, `unit_id`, `description`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Menswear', 1, 12, 12, '1', '', 4, '2015-06-27 23:24:02', '2015-06-27 23:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `acc_suppliers`
--

CREATE TABLE IF NOT EXISTS `acc_suppliers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `skype` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_suppliers_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `acc_suppliers`
--

INSERT INTO `acc_suppliers` (`id`, `name`, `contact`, `address`, `country_id`, `email`, `phone`, `skype`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'PQR Company Ltd.', 'Hasan Habib', 'London', 1, 'hasanhabib2009@gmail.com', '', '', 4, '2015-06-27 23:53:21', '2015-06-28 00:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `acc_trandetails`
--

CREATE TABLE IF NOT EXISTS `acc_trandetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tm_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `tranwith_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `lc_id` int(11) NOT NULL,
  `ord_id` int(11) NOT NULL,
  `stl_id` int(11) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `trandetails_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=70 ;

--
-- Dumping data for table `acc_trandetails`
--

INSERT INTO `acc_trandetails` (`id`, `tm_id`, `acc_id`, `tranwith_id`, `amount`, `currency_id`, `lc_id`, `ord_id`, `stl_id`, `stu_id`, `user_id`, `created_at`, `updated_at`) VALUES
(40, 1, 21, 16, 3500, 0, 0, 0, 0, 0, 1, '2015-07-02 02:01:16', '2015-07-02 02:01:16'),
(42, 1, 7, 16, 35000, 0, 0, 0, 0, 0, 1, '2015-07-02 02:01:37', '2015-07-02 02:01:37'),
(43, 1, 16, 7, -38500, 0, 0, 0, 0, 0, 1, '2015-07-02 02:01:37', '2015-07-02 02:01:37'),
(54, 7, 21, 16, -73500, 0, 0, 0, 0, 0, 1, '2015-07-02 02:10:55', '2015-07-02 02:10:55'),
(56, 7, 17, 16, -35000, 0, 0, 0, 0, 0, 1, '2015-07-02 02:11:15', '2015-07-02 02:11:15'),
(57, 7, 16, 17, 108500, 0, 0, 0, 0, 0, 1, '2015-07-02 02:11:16', '2015-07-02 02:11:16'),
(60, 8, 8, 21, 3500, 0, 0, 0, 0, 0, 1, '2015-07-02 02:16:53', '2015-07-02 02:16:53'),
(62, 8, 7, 21, 35000, 0, 0, 0, 0, 0, 1, '2015-07-02 02:17:11', '2015-07-02 02:17:11'),
(63, 8, 21, 7, -38500, 0, 0, 0, 0, 0, 1, '2015-07-02 02:17:11', '2015-07-02 02:17:11'),
(64, 9, 17, 16, 3500, 0, 0, 0, 0, 0, 1, '2015-07-02 02:28:09', '2015-07-02 02:28:09'),
(65, 9, 16, 17, -3500, 0, 0, 0, 0, 0, 1, '2015-07-02 02:28:09', '2015-07-02 02:28:09'),
(66, 10, 21, 16, 70000, 0, 0, 0, 0, 0, 1, '2015-07-07 21:27:41', '2015-07-07 21:27:41'),
(67, 10, 16, 21, -70000, 0, 0, 0, 0, 0, 1, '2015-07-07 21:27:41', '2015-07-07 21:27:41'),
(68, 11, 21, 21, 7000000, 0, 0, 0, 0, 0, 1, '2015-07-07 22:37:54', '2015-07-07 22:37:54'),
(69, 11, 21, 21, -7000000, 0, 0, 0, 0, 0, 1, '2015-07-07 22:37:55', '2015-07-07 22:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `acc_tranmasters`
--

CREATE TABLE IF NOT EXISTS `acc_tranmasters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vnumber` int(11) NOT NULL,
  `tdate` date NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tranwith_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `req_id` int(11) NOT NULL,
  `check_id` int(11) NOT NULL,
  `check_action` int(11) NOT NULL,
  `check_note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `appr_id` int(11) NOT NULL,
  `appr_action` int(11) NOT NULL,
  `appr_note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `audit_id` int(11) NOT NULL,
  `audit_action` int(11) NOT NULL,
  `audit_note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ttype` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `com_id` int(11) NOT NULL,
  `proj_id` int(11) NOT NULL,
  `person` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `tranmasters_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `acc_tranmasters`
--

INSERT INTO `acc_tranmasters` (`id`, `vnumber`, `tdate`, `note`, `tranwith_id`, `currency_id`, `amount`, `req_id`, `check_id`, `check_action`, `check_note`, `appr_id`, `appr_action`, `appr_note`, `audit_id`, `audit_action`, `audit_note`, `ttype`, `com_id`, `proj_id`, `person`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2015-07-01', 'A new computer has been purchased for accountant to use ERP ', 16, 3, 35000, 0, 1, 1, 'ok', 0, 0, '', 0, 0, '', 'Payment', 0, 0, 'Hasan Habib', 1, '2015-06-30 22:10:14', '2015-07-04 01:50:14'),
(2, 2, '2015-07-01', 'For Accountant', 16, 3, 105000, 1, 1, 1, 'ok', 0, 0, '', 0, 0, '', 'Payment', 0, 0, 'Hasan Habib', 1, '2015-06-30 22:27:37', '2015-07-04 01:02:52'),
(7, 3, '2015-07-02', 'Cash received from ABC Company Ltd. as sale of scrap and received cash from Petty cash of factory', 16, 3, 108500, 0, 1, 1, 'ok', 0, 1, 'ok', 1, 1, 'checked and found correct', 'Receipt', 0, 0, 'Hasan Habib', 1, '2015-07-02 00:13:21', '2015-07-04 02:12:14'),
(8, 4, '2015-07-02', 'Purchase computer and printer as credit from ABC Company Ltd.', 21, 3, 38500, 0, 1, 1, 'ok', 0, 1, 'ok', 1, 1, 'ok', 'Journal', 0, 0, 'Hasan Habib', 1, '2015-07-02 00:37:52', '2015-07-04 02:10:35'),
(10, 5, '2015-07-08', '', 16, 3, 0, 0, 1, 0, '', 0, 0, '', 0, 0, '', 'Payment', 0, 0, 'Hasan Habib', 1, '2015-07-07 21:27:02', '2015-07-07 21:27:02'),
(11, 6, '2015-07-08', '', 21, 3, 0, 1, 1, 0, '', 0, 0, '', 0, 0, '', 'Payment', 0, 0, 'Hasan Habib', 1, '2015-07-07 22:37:17', '2015-07-07 22:37:17');

-- --------------------------------------------------------

--
-- Table structure for table `acc_units`
--

CREATE TABLE IF NOT EXISTS `acc_units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `acc_units_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `acc_units`
--

INSERT INTO `acc_units` (`id`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'PC', 1, '2015-07-05 22:12:48', '2015-07-05 22:12:48'),
(2, 'Dozen', 1, '2015-07-05 22:13:14', '2015-07-05 22:13:14'),
(4, 'Kg', 1, '2015-07-05 22:13:32', '2015-07-05 22:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `acc_warehouses`
--

CREATE TABLE IF NOT EXISTS `acc_warehouses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `incharge` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `warehouses_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `acc_warehouses`
--

INSERT INTO `acc_warehouses` (`id`, `name`, `address`, `incharge`, `mobile`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Uttara Jonopath', 'Uttara, Dhaka', 'Hasan Habib', '01685494832', 1, '2015-07-04 21:46:51', '2015-07-04 21:46:51');

-- --------------------------------------------------------

--
-- Table structure for table `hrm_employee_basic_info`
--

CREATE TABLE IF NOT EXISTS `hrm_employee_basic_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mother_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `husband_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `no_of_child` int(11) NOT NULL,
  `dob` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nid` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bcn` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `passport` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `marital_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `religion` int(10) unsigned NOT NULL,
  `driving_license` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tin_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_barnch` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `acc_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mob_office` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mob_personal` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `employee_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sameas` tinyint(4) NOT NULL,
  `per_road` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `per_house` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `per_flat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `per_vill` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `per_po` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `per_ps` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `per_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `per_dist` int(10) unsigned NOT NULL,
  `per_zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `per_division` int(10) unsigned NOT NULL,
  `per_country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pre_road` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pre_house` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pre_flat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pre_vill` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pre_po` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pre_ps` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pre_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pre_dist` int(10) unsigned NOT NULL,
  `pre_zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pre_division` int(10) unsigned NOT NULL,
  `pre_country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `employee_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `employee_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_nature` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hrm_employee_basic_info_email_unique` (`email`),
  UNIQUE KEY `hrm_employee_basic_info_employee_code_unique` (`employee_code`),
  KEY `hrm_employee_basic_info_user_id_foreign` (`user_id`),
  KEY `hrm_employee_basic_info_religion_foreign` (`religion`),
  KEY `hrm_employee_basic_info_per_dist_foreign` (`per_dist`),
  KEY `hrm_employee_basic_info_per_division_foreign` (`per_division`),
  KEY `hrm_employee_basic_info_pre_dist_foreign` (`pre_dist`),
  KEY `hrm_employee_basic_info_pre_division_foreign` (`pre_division`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lib_attendance_payment_names`
--

CREATE TABLE IF NOT EXISTS `lib_attendance_payment_names` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_attendance_payment_names_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `lib_attendance_payment_names`
--

INSERT INTO `lib_attendance_payment_names` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Atten-Staff', 1, '2015-06-17 04:55:10', '2015-06-17 04:55:10', NULL),
(2, 'Atten-Worker', 1, '2015-06-17 04:55:20', '2015-06-17 04:55:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_depts`
--

CREATE TABLE IF NOT EXISTS `lib_depts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_depts_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `lib_depts`
--

INSERT INTO `lib_depts` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 1, '2015-06-14 22:49:10', '2015-06-14 22:49:10', NULL),
(2, 'Corporate', 1, '2015-06-14 22:49:28', '2015-06-14 22:49:28', NULL),
(3, 'Horizon Fashion Wear Ltd.', 1, '2015-06-14 22:49:38', '2015-06-14 22:49:38', NULL),
(4, 'Horizon Sweaters Ltd.', 1, '2015-06-14 22:49:49', '2015-06-14 22:49:49', NULL),
(5, 'Lab', 1, '2015-06-14 22:50:00', '2015-06-14 22:50:00', NULL),
(6, 'Maintenance', 1, '2015-06-14 22:50:11', '2015-06-14 22:50:11', NULL),
(7, 'Production', 1, '2015-06-14 22:50:21', '2015-06-14 22:50:21', NULL),
(8, 'RMG', 1, '2015-06-14 22:50:31', '2015-06-14 22:50:31', NULL),
(9, 'Sahaba Yarn Ltd.', 1, '2015-06-14 22:50:46', '2015-06-14 22:50:46', NULL),
(10, 'Security', 1, '2015-06-14 22:51:07', '2015-06-14 22:51:07', NULL),
(11, 'Store', 1, '2015-06-14 22:51:20', '2015-06-14 22:51:20', NULL),
(12, 'Sweater', 1, '2015-06-14 22:51:33', '2015-06-14 22:51:33', NULL),
(13, 'Textile Horizon', 1, '2015-06-14 22:51:45', '2015-06-18 03:02:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_designations`
--

CREATE TABLE IF NOT EXISTS `lib_designations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_designations_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=208 ;

--
-- Dumping data for table `lib_designations`
--

INSERT INTO `lib_designations` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Managing Director', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(2, 'Chairman', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(3, 'Public Relation Officer', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(4, 'Director', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(5, 'Deputy  General Manager', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(6, 'Manager-Public Relation', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(7, 'Asst. Manager', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(8, 'Peon', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(9, 'Driver', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(10, 'Deputy Manager', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(11, 'Manager', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(12, 'Asst. Manager - Collection & Audit', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(13, 'Sr. Executive', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(14, 'Manager-Tax, VAT & Company Law', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(15, 'Executive', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(16, 'Asst. Merchendiser', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(17, 'S. Guard', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(18, 'Cleaner', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(19, 'Messenger', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(20, 'Officer', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(21, 'In-charge', 1, '2015-06-16 05:06:09', '2015-06-16 05:06:09', NULL),
(22, 'Supervisor', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(23, 'Asst. Designer', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(24, 'Operator', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(25, 'Jr. Operator', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(26, 'GM-Marketing & Merchandising', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(27, 'Sr.Merchendiser', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(28, 'Merchendiser', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(29, 'Q.C.', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(30, 'Trainee', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(31, 'Supervisor (AOP)', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(32, 'Coordinartor', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(33, 'ASST.PRODUCTION OFFICER', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(34, 'Dyeing Asst.', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(35, 'Store Officer', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(36, 'Store Keeper', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(37, 'ASST. STORE KEEPER', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(38, 'Asst. Store In-charge', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(39, 'Delivery Man', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(40, 'Store Asst.', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(41, 'Asst.Store Keeper', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(42, 'Manager-Sewing Machanic', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(43, 'Mechanic', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(44, 'Line Q.C.', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(45, 'Production Manager', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(46, 'Technician', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(47, 'Finishing Quality In-charge', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(48, 'Quality In-charge', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(49, 'Quality Supervisor', 1, '2015-06-16 05:06:10', '2015-06-16 05:06:10', NULL),
(50, 'Finishing Supervisor', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(51, 'Electrician', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(52, 'Asst. Mechanic', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(53, 'G.P.Q', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(54, 'Sr. Mechanic', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(55, 'SMO', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(56, 'JSMO', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(57, 'GSMO', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(58, 'Q.I.', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(59, 'Sample Iron Man', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(60, 'JR. FOLDER', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(61, 'Team Leader', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(62, 'JR. PACKER', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(63, 'F. ASST.', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(64, 'Folding man', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(65, 'Needle Man', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(66, 'Iron Man', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(67, 'Sr. Q.I', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(68, 'SSMO', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(69, 'Packer', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(70, 'INPUT MAN', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(71, 'Folder', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(72, 'Sucker Man', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(73, 'HANG T. MAN', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(74, 'ASort Man', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(75, 'Receive Man', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(76, 'ASMO', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(77, 'SPOT R. MAN', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(78, 'Poly Man', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(79, 'JR. Polyman', 1, '2015-06-16 05:06:11', '2015-06-16 05:06:11', NULL),
(80, 'JR. Sucker Man', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(81, 'JR.Spot man', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(82, 'Wash man', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(83, 'JR. Receive Man', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(84, 'JR. Input Man', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(85, 'Reporter', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(86, 'Deputy Managing Director', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(87, 'Purchase Asst.', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(88, 'Imam', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(89, 'Muazzin', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(90, 'Cook', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(91, 'Helper-Covered Van', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(92, 'Sr. Programmer', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(93, 'Executive - HR & Compliance', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(94, 'Admin Asst.', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(95, 'Executive, Admin & HR', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(96, 'JR.Executive-Admin & HR', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(97, 'Welfare officer', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(98, 'Civil Engineer', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(99, 'Medical Officer', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(100, 'Time Keeper', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(101, 'Production Auditor', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(102, 'Loader', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(103, 'Gardener', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(104, 'ASST.HOUSE KEEPER', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(105, 'Child Attendant/Aya', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(106, 'Asst. House Keeper', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(107, 'Guard', 1, '2015-06-16 05:06:12', '2015-06-16 05:06:12', NULL),
(108, 'Checker', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(109, 'Sub Asst. Engineer', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(110, 'Maintenance Asst.', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(111, 'Fitter', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(112, 'Boiler(operator)', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(113, 'Jr. Fitter', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(114, 'Asst. Operator', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(115, 'Asst. Fitter', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(116, 'Sr. Operator', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(117, 'Asst. Engineer', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(118, 'Mechanic (A/C)', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(119, 'Asst. Plumber', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(120, 'Asst. Mechanical Fitter', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(121, 'A. Boiler Operator', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(122, 'Asst. E.T.P Operator', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(123, 'In-charge(G.S)', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(124, 'Batch Man', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(125, 'Jr. Executive', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(126, 'Marketing Jr. Exicutive', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(127, 'Helper', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(128, 'Writer Man', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(129, 'Asst. Q. C.', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(130, 'H/W Asst.', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(131, 'In-charge(soft&hard)', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(132, 'A.Batch', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(133, 'Shift In-charge', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(134, 'Lab Assistant', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(135, 'Knitting Operator', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(136, 'Asst.Manager (I E)', 1, '2015-06-16 05:06:13', '2015-06-16 05:06:13', NULL),
(137, 'Trainee Programmar', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(138, 'Programmer', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(139, 'Designer', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(140, 'Quality Manager', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(141, 'Sample Man', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(142, 'In-charge(Tecnician)', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(143, 'Yarn Controller', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(144, 'Master', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(145, 'Asst.Technician', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(146, 'Linking Supervisor', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(147, 'Sr.Designer', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(148, 'A. Yarn Controlar', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(149, 'Merchandiser', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(150, 'Asst. Production Manager', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(151, 'Supervisor(Wash)', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(152, 'Fitter  Man', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(153, 'Operator (Jacquard)', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(154, 'Inspector', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(155, 'A.Opt. (Jacquard)', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(156, 'Production Officer', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(157, 'Neck Asst.', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(158, 'Distributor', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(159, 'Operator (Winding)', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(160, 'Operator (Mending)', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(161, 'Auto Placed Operator', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(162, 'Knitting Asst.', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(163, 'Operator (O/L)', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(164, 'P.Q.C.Operator', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(165, 'Getup Operator', 1, '2015-06-16 05:06:14', '2015-06-16 05:06:14', NULL),
(166, 'P.Q.C. Asst.', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(167, 'Light Check Opt.', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(168, 'GLMO', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(169, 'L.Asst.', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(170, 'Linking Inspector', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(171, 'L.H.S.Operator', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(172, 'Overlock Asst.', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(173, 'Asst.Distributor', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(174, 'Iron Q.C', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(175, 'Wash Asst.', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(176, 'Iron Dis.', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(177, 'Helper (Winding)', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(178, 'Distributor(Wash)', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(179, 'Asst. Fitter Man', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(180, 'Sample Finishing Man', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(181, 'Cutter Man', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(182, 'Pattern Master', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(183, 'FABRIC COR.', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(184, 'Marker Man', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(185, 'ASST. CUTTING IN-CHARGE', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(186, 'CUTTER', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(187, 'ASST. CUTTER', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(188, 'JR. CUTTER', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(189, 'FABREC RV. MAN', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(190, 'Bundle Man', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(191, 'Cutting Asst.', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(192, 'JR. Scissor Man', 1, '2015-06-16 05:06:15', '2015-06-16 05:06:15', NULL),
(193, 'STICKER MAN', 1, '2015-06-16 05:06:16', '2015-06-18 03:19:10', NULL),
(194, 'Scissor Man', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(195, 'SR.INPUT MAN', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(196, 'Colour Master', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(197, 'Printer', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(198, 'Layer Man', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(199, 'JR. IRON MAN', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(200, 'Printing Asst.', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(201, 'Jr. Printer', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(202, 'Camera Man', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(203, 'Asst. Colour Master', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(204, 'Accounts', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(205, 'Coordinartor (Shipment)', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(206, 'Medical Assistant', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL),
(207, 'Fire Safety Officer', 1, '2015-06-16 05:06:16', '2015-06-16 05:06:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_districts`
--

CREATE TABLE IF NOT EXISTS `lib_districts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `districts_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=65 ;

--
-- Dumping data for table `lib_districts`
--

INSERT INTO `lib_districts` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Barguna', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(2, 'Barisal', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(3, 'Bhola', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(4, 'Jhalokati', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(5, 'Patuakhali', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(6, 'Pirojpur', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(7, 'Bandarban', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(8, 'Brahmanbaria', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(9, 'Chandpur', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(10, 'Chittagong', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(11, 'Comilla', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(12, 'Cox''s Bazar', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(13, 'Feni', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(14, 'Khagrachhari', 1, '2015-06-16 06:06:19', '2015-06-16 06:06:19', NULL),
(15, 'Lakshmipur', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(16, 'Noakhali', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(17, 'Rangamati', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(18, 'Dhaka', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(19, 'Faridpur', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(20, 'Gazipur', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(21, 'Gopalganj', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(22, 'Jamalpur', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(23, 'Kishoreganj', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(24, 'Madaripur', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(25, 'Manikganj', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(26, 'Munshiganj', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(27, 'Mymensingh', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(28, 'Narayanganj', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(29, 'Narsingdi', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(30, 'Netrakona', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(31, 'Rajbari', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(32, 'Shariatpur', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(33, 'Sherpur', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(34, 'Tangail', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(35, 'Bagerhat', 1, '2015-06-16 06:06:20', '2015-06-16 06:06:20', NULL),
(36, 'Chuadanga', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(37, 'Jessore', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(38, 'Jhenaidah', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(39, 'Khulna', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(40, 'Kushtia', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(41, 'Magura', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(42, 'Meherpur', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(43, 'Narail', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(44, 'Satkhira', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(45, 'Bogra', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(46, 'Joypurhat', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(47, 'Naogaon', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(48, 'Natore', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(49, 'Nawabganj', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(50, 'Pabna', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(51, 'Rajshahi', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(52, 'Sirajganj', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(53, 'Dinajpur', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(54, 'Gaibandha', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(55, 'Kurigram', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(56, 'Lalmonirhat', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(57, 'Nilphamari', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(58, 'Panchagarh', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(59, 'Rangpur', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(60, 'Thakurgaon', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(61, 'Habiganj', 1, '2015-06-16 06:06:21', '2015-06-16 06:06:21', NULL),
(62, 'Moulvibazar', 1, '2015-06-16 06:06:22', '2015-06-16 06:06:22', NULL),
(63, 'Sunamganj', 1, '2015-06-16 06:06:22', '2015-06-16 06:06:22', NULL),
(64, 'Sylhet', 1, '2015-06-16 06:06:22', '2015-06-18 03:28:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_divisions`
--

CREATE TABLE IF NOT EXISTS `lib_divisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `divisions_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `lib_divisions`
--

INSERT INTO `lib_divisions` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Barisal', 1, '2015-06-16 04:03:00', '2015-06-16 04:03:00', NULL),
(2, 'Chittagong', 1, '2015-06-16 04:03:09', '2015-06-16 04:03:09', NULL),
(3, 'Dhaka', 1, '2015-06-16 04:03:17', '2015-06-16 04:03:17', NULL),
(4, 'Khulna', 1, '2015-06-16 04:03:29', '2015-06-16 04:03:29', NULL),
(5, 'Rajshahi', 1, '2015-06-16 04:03:38', '2015-06-16 04:03:38', NULL),
(6, 'Rangpur', 1, '2015-06-16 04:03:47', '2015-06-16 04:03:47', NULL),
(7, 'Sylhet', 1, '2015-06-16 04:03:56', '2015-06-18 03:32:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_govt_salaries`
--

CREATE TABLE IF NOT EXISTS `lib_govt_salaries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`),
  KEY `lib_govt_salaries_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lib_govt_salaries`
--

INSERT INTO `lib_govt_salaries` (`id`, `name`, `amount`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Food', '650', 1, '2015-06-17 03:04:08', '2015-06-18 03:43:52', NULL),
(2, 'Medical', '250', 1, '2015-06-17 03:05:28', '2015-06-18 03:43:57', NULL),
(3, 'Convence', '200', 1, '2015-06-17 03:06:29', '2015-06-18 03:44:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_grades`
--

CREATE TABLE IF NOT EXISTS `lib_grades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grades_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `lib_grades`
--

INSERT INTO `lib_grades` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 1, '2015-06-17 04:09:30', '2015-06-17 04:09:30', NULL),
(2, '2', 1, '2015-06-17 04:09:34', '2015-06-17 04:09:34', NULL),
(3, '3', 1, '2015-06-17 04:09:39', '2015-06-17 04:09:39', NULL),
(4, '4', 1, '2015-06-17 04:09:43', '2015-06-17 04:09:43', NULL),
(5, '5', 1, '2015-06-17 04:09:47', '2015-06-17 04:09:47', NULL),
(6, '6', 1, '2015-06-17 04:09:51', '2015-06-17 04:09:51', NULL),
(7, '7', 1, '2015-06-17 04:09:55', '2015-06-18 03:51:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_languages`
--

CREATE TABLE IF NOT EXISTS `lib_languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lib_languages_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=393 ;

--
-- Dumping data for table `lib_languages`
--

INSERT INTO `lib_languages` (`id`, `code`, `value`, `created_at`, `updated_at`) VALUES
(1, 'roles', 'Roles', '2015-06-13 16:49:45', '2015-06-13 16:49:45'),
(2, 'display_name', 'Display Name', '2015-06-13 19:49:02', '2015-06-13 19:49:02'),
(3, 'name', 'Name', '2015-06-13 19:51:55', '2015-06-13 19:51:55'),
(4, 'level', 'Level', '2015-06-13 19:52:28', '2015-06-13 19:52:28'),
(5, 'permissions', 'Permissions', '2015-06-13 19:52:48', '2015-06-13 19:52:48'),
(6, 'create', 'Create', '2015-06-13 19:53:23', '2015-06-13 19:53:23'),
(7, 'edit', 'Edit', '2015-06-13 19:54:15', '2015-06-13 19:54:15'),
(8, 'delete', 'Delete', '2015-06-13 19:55:24', '2015-06-13 19:55:24'),
(9, 'sl', 'SL.', '2015-06-13 19:55:54', '2015-06-13 20:35:21'),
(10, 'add_new', 'Add New', '2015-06-13 20:36:34', '2015-06-13 20:36:34'),
(11, 'create_role', 'Create Role', '2015-06-13 20:45:06', '2015-06-13 20:45:06'),
(12, 'description', 'Description', '2015-06-13 20:46:25', '2015-06-13 20:46:25'),
(13, 'id', 'ID.', '2015-06-13 20:53:45', '2015-06-13 20:53:45'),
(14, 'update', 'Update', '2015-06-13 21:02:06', '2015-06-13 21:02:06'),
(15, 'create_new', 'Create New', '2015-06-13 21:11:38', '2015-06-13 21:11:38'),
(16, 'email', 'Email', '2015-06-13 21:50:41', '2015-06-13 21:50:41'),
(17, 'phone', 'Phone', '2015-06-13 21:51:13', '2015-06-13 21:51:13'),
(18, 'message', 'Message', '2015-06-13 21:51:26', '2015-06-13 21:51:26'),
(19, 'roles_permissions', 'Roles & Permissions', '2015-06-13 22:01:03', '2015-06-13 22:01:03'),
(20, 'route', 'Route Function', '2015-06-13 22:01:42', '2015-06-18 10:35:10'),
(21, 'save', 'Save', '2015-06-13 22:02:31', '2015-06-13 22:02:31'),
(22, 'edit_permission', 'Edit Permission', '2015-06-13 22:21:03', '2015-06-13 22:21:03'),
(23, 'create_permission', 'Create Permission', '2015-06-13 22:26:59', '2015-06-13 22:26:59'),
(24, 'users', 'Users', '2015-06-13 22:34:14', '2015-06-13 22:34:14'),
(25, 'password', 'Password', '2015-06-13 22:36:04', '2015-06-13 22:36:04'),
(26, 'password_confirmation', 'Password confirmation', '2015-06-13 22:36:25', '2015-06-14 21:34:00'),
(27, 'user_id', 'User ID', '2015-06-14 22:57:38', '2015-06-14 22:57:38'),
(28, 'amount', 'Amount', '2015-06-17 03:03:26', '2015-06-17 03:03:26'),
(29, 'restore', 'Restore', '2015-06-17 23:18:42', '2015-06-17 23:18:42'),
(30, 'back_to', 'Back To', '2015-06-17 23:36:09', '2015-06-17 23:36:09'),
(31, 'fullname', 'Name', '2015-06-20 01:12:00', '2015-06-20 01:12:00'),
(32, 'father_name', 'Father''s Name', '2015-06-20 01:12:20', '2015-06-20 01:12:20'),
(33, 'mother_name', 'Mother''s Name', '2015-06-20 01:12:44', '2015-06-20 01:12:44'),
(34, 'husband_name', 'Husband''s Name', '2015-06-20 01:13:06', '2015-06-20 01:13:06'),
(35, 'no_of_child', 'No. of Children', '2015-06-20 01:13:24', '2015-06-20 01:13:24'),
(36, 'dob', 'Date Of Birth', '2015-06-20 01:13:42', '2015-06-20 01:13:42'),
(37, 'nid', 'National ID', '2015-06-20 01:14:02', '2015-06-20 01:14:02'),
(38, 'bcn', 'Birth Certificate No.', '2015-06-20 01:14:20', '2015-06-20 01:14:20'),
(39, 'nationality', 'Nationality', '2015-06-20 01:14:42', '2015-06-20 01:14:42'),
(40, 'passport', 'Passport ID', '2015-06-20 01:15:01', '2015-06-20 01:15:01'),
(41, 'sex', 'Sex', '2015-06-20 01:15:18', '2015-06-20 01:15:18'),
(42, 'marital_status', 'Marital Status', '2015-06-20 01:15:37', '2015-06-20 01:15:37'),
(43, 'religion', 'Religion', '2015-06-20 01:16:04', '2015-06-20 01:16:04'),
(44, 'driving_license', 'Driving License No', '2015-06-20 01:16:22', '2015-06-20 01:16:22'),
(45, 'tin_no', 'TIN No', '2015-06-20 01:16:39', '2015-06-20 01:16:39'),
(46, 'bank_name', 'Name', '2015-06-20 01:17:07', '2015-06-20 01:17:07'),
(47, 'bank_barnch', 'Branch', '2015-06-20 01:17:43', '2015-06-20 01:17:43'),
(48, 'acc_no', 'Acc No', '2015-06-20 01:18:03', '2015-06-20 01:18:03'),
(49, 'mob_office', 'Mobile (Off.)', '2015-06-20 01:18:46', '2015-06-20 01:18:46'),
(50, 'mob_personal', 'Mobile (Personal)', '2015-06-20 01:19:04', '2015-06-20 01:19:04'),
(51, 'employee_img', 'Image', '2015-06-20 01:40:48', '2015-06-20 01:40:48'),
(52, 'sameas', 'Same as Present Address', '2015-06-20 01:41:09', '2015-06-20 01:41:09'),
(53, 'hrm_road', 'Road', '2015-06-20 01:41:53', '2015-06-20 01:41:53'),
(54, 'hrm_house', 'House', '2015-06-20 01:42:18', '2015-06-20 01:42:18'),
(55, 'hrm_flat', 'Flat', '2015-06-20 01:42:36', '2015-06-20 01:42:36'),
(56, 'hrm_village', 'Village', '2015-06-20 01:43:06', '2015-06-20 01:43:06'),
(57, 'hrm_po', 'P.O.', '2015-06-20 01:43:32', '2015-06-20 01:43:32'),
(58, 'hrm_ps', 'P.S.', '2015-06-20 01:43:50', '2015-06-20 01:43:50'),
(59, 'hrm_city', 'City', '2015-06-20 01:44:25', '2015-06-20 01:44:25'),
(60, 'hrm_dist', 'District', '2015-06-20 01:44:43', '2015-06-20 01:44:43'),
(61, 'hrm_zip', 'Zip Code', '2015-06-20 01:45:00', '2015-06-20 01:45:00'),
(62, 'hrm_division', 'Division', '2015-06-20 01:45:29', '2015-06-20 01:45:29'),
(63, 'hrm_country', 'Country', '2015-06-20 01:45:47', '2015-06-20 01:45:47'),
(64, 'employee_status', 'Employee Status', '2015-06-20 01:46:39', '2015-06-20 01:46:39'),
(65, 'employee_code', 'Employee Code', '2015-06-20 01:46:59', '2015-06-20 01:46:59'),
(66, 'employee_type', 'Employee Type', '2015-06-20 01:47:20', '2015-06-20 01:47:20'),
(67, 'employee_nature', 'Nature of Employment', '2015-06-20 01:47:43', '2015-06-20 01:47:43'),
(68, 'hrm_basic_info', 'Basic Information', '2015-06-20 22:09:43', '2015-06-20 22:09:43'),
(69, 'hrm_bank_info', 'Bank Information', '2015-06-20 22:16:35', '2015-06-20 22:16:35'),
(70, 'hrm_contact_info', 'Contact Information', '2015-06-20 22:21:28', '2015-06-20 22:21:28'),
(71, 'hrm_per_add', 'Permanent Address', '2015-06-20 22:46:49', '2015-06-20 22:46:49'),
(72, 'hrm_address', 'Address', '2015-06-20 22:51:15', '2015-06-20 22:51:15'),
(73, 'hrm_pre_add', 'Present Address', '2015-06-20 22:52:10', '2015-06-20 22:52:10'),
(74, 'hrm_employee_office_info', 'Official Information', '2015-06-20 23:57:52', '2015-06-20 23:57:52'),
(75, 'help', 'Help', '2015-06-25 22:35:58', '2015-06-25 22:35:58'),
(77, 'addnew', 'Add New', '2015-06-25 22:36:32', '2015-06-25 22:36:32'),
(78, 'cond_id', 'Condition', '2015-06-25 22:37:01', '2015-06-25 22:37:01'),
(79, 'detail_id', 'Details', '2015-06-25 22:37:26', '2015-06-25 22:37:26'),
(81, 'group_id', 'Group', '2015-06-25 22:39:38', '2015-06-25 22:39:38'),
(83, 'topGroup_id', 'Top Group', '2015-06-25 22:40:09', '2015-06-25 22:40:09'),
(85, 'atype', 'Account Type', '2015-06-25 22:40:46', '2015-06-25 22:40:46'),
(229, 'contact', 'Contact', '2015-06-16 19:12:32', '2015-06-16 19:12:32'),
(230, 'address1', 'Address', '2015-06-16 19:14:09', '2015-06-21 21:06:21'),
(231, 'address2', 'Corporate', '2015-06-16 19:14:30', '2015-06-16 19:14:30'),
(232, 'accountGroup', 'Account Group', '2015-06-16 19:15:08', '2015-06-16 19:15:08'),
(233, 'businessn', 'Business Nature', '2015-06-16 19:16:31', '2015-06-28 02:48:34'),
(234, 'maxamount', 'Maximum Amount', '2015-06-16 22:10:51', '2015-06-16 22:10:51'),
(235, 'remainder1', 'First Reminder', '2015-06-16 22:11:20', '2015-06-16 22:13:31'),
(236, 'remainder2', 'Second Reminder', '2015-06-16 22:11:39', '2015-06-16 22:13:22'),
(237, 'remainder3', 'Third Reminder', '2015-06-16 22:12:07', '2015-06-16 22:13:13'),
(238, 'depreciatetion', 'Depreciatetion', '2015-06-16 22:13:55', '2015-06-16 22:13:55'),
(239, 'monthly', 'Monthly Exp.', '2015-06-16 22:15:51', '2015-06-16 22:15:51'),
(240, 'lcnumber', 'LC No', '2015-06-17 15:45:43', '2015-06-17 15:46:53'),
(241, 'lcdate', 'LC Date', '2015-06-17 15:47:18', '2015-06-17 15:47:18'),
(242, 'buyer_id', 'Buyer', '2015-06-17 15:47:37', '2015-06-17 15:47:37'),
(243, 'country_id', 'Country', '2015-06-17 15:47:57', '2015-06-17 15:47:57'),
(244, 'lcamount', 'LC Value', '2015-06-17 15:48:24', '2015-06-17 15:48:24'),
(245, 'currency_id', 'Currency', '2015-06-17 15:48:51', '2015-06-17 15:48:51'),
(246, 'qty', 'Quantity', '2015-06-17 15:49:13', '2015-06-17 15:49:13'),
(247, 'productdetails', 'Product Details', '2015-06-17 15:49:35', '2015-06-17 15:49:35'),
(248, 'ordervalue', 'Order Value', '2015-06-17 16:22:10', '2015-06-17 16:22:10'),
(249, 'orderqty', 'Order Quantity', '2015-06-17 16:22:38', '2015-06-17 16:22:38'),
(250, 'ordernumber', 'Order No', '2015-06-17 16:29:28', '2015-06-17 16:29:28'),
(251, 'address', 'Address', '2015-06-17 16:55:45', '2015-06-17 16:55:45'),
(252, 'skype', 'Skype', '2015-06-17 16:56:12', '2015-06-17 16:56:12'),
(253, 'types', 'Budget Types', '2015-06-17 20:04:41', '2015-06-17 20:04:41'),
(254, 'account_id', 'Account Head', '2015-06-17 20:05:02', '2015-06-17 20:05:02'),
(255, 'check_id', 'Check By', '2015-06-17 21:23:48', '2015-06-17 21:24:17'),
(256, 'reject_id', 'Rejected By', '2015-06-17 21:29:08', '2015-06-17 21:29:46'),
(257, 'appr_id', 'Approved By', '2015-06-17 21:30:07', '2015-06-17 21:30:07'),
(258, 'rtypes', 'Requisition Type', '2015-06-17 21:34:45', '2015-06-17 21:34:45'),
(259, 'check_note', 'Note', '2015-06-18 20:10:51', '2015-06-18 20:18:25'),
(260, 'check_action', 'Action', '2015-06-18 20:19:00', '2015-06-18 20:19:45'),
(261, 'user_idc', 'Created By', '2015-06-18 20:53:56', '2015-06-18 20:53:56'),
(262, 'approve', 'Approve', '2015-06-18 21:10:31', '2015-06-18 21:10:31'),
(263, 'appr_action', 'Approve Action', '2015-06-18 21:15:44', '2015-06-18 21:15:44'),
(264, 'ramount', 'Amount', '2015-06-19 01:39:45', '2015-06-19 01:39:45'),
(265, 'aamount', 'Approve Amount', '2015-06-19 01:40:27', '2015-06-19 15:29:10'),
(266, 'check', 'Check', '2015-06-19 20:43:39', '2015-06-19 20:43:39'),
(267, 'buyer', 'Buyer', '2015-06-20 17:29:03', '2015-06-20 17:29:03'),
(268, 'unit', 'Unit', '2015-06-20 20:39:44', '2015-06-20 20:39:44'),
(269, 'ptype', 'Type', '2015-06-22 17:04:26', '2015-06-22 17:04:26'),
(270, 'stylevalue', 'Style Value ', '2015-06-22 20:06:33', '2015-06-22 20:06:33'),
(271, 'styleqty', 'Style Quantity', '2015-06-22 20:06:59', '2015-06-22 20:06:59'),
(272, 'btype', 'Budget Type', '2015-06-23 16:08:47', '2015-06-23 16:08:47'),
(273, 'byear', 'Budger Year', '2015-06-23 16:32:28', '2015-06-23 16:32:57'),
(274, 'expdate', 'Expire Date', '2015-06-23 17:01:35', '2015-06-23 17:01:35'),
(275, 'shipmentdate', 'Shipment Date', '2015-06-23 17:02:11', '2015-06-23 17:02:11'),
(276, 'lcvalue', 'LC Value', '2015-06-23 17:30:03', '2015-06-23 17:30:03'),
(277, 'lcqty', 'LC Quantity', '2015-06-23 17:30:34', '2015-06-23 17:30:34'),
(278, 'supplier_id', 'Supplier', '2015-06-23 17:39:41', '2015-06-23 17:39:41'),
(279, 'invoice', 'Invoice', '2015-06-23 18:57:04', '2015-06-23 18:57:04'),
(280, 'pdate', 'Date', '2015-06-23 18:57:23', '2015-06-23 18:57:23'),
(281, 'client_id', 'Client', '2015-06-23 18:57:46', '2015-06-23 20:39:52'),
(282, 'client_address', 'Address', '2015-06-23 18:58:26', '2015-06-23 20:40:06'),
(283, 'discount', 'Discount', '2015-06-23 18:58:49', '2015-06-23 18:58:49'),
(284, 'vat_tax', 'VAT and TAX', '2015-06-23 18:59:10', '2015-06-23 18:59:10'),
(285, 'transport', 'Transport', '2015-06-23 18:59:36', '2015-06-23 18:59:36'),
(286, 'paid', 'Paid', '2015-06-23 18:59:56', '2015-06-23 18:59:56'),
(287, 'previous_due', 'Previous Due', '2015-06-23 19:00:29', '2015-06-23 19:00:29'),
(288, 'balance', 'Balance', '2015-06-23 19:00:49', '2015-06-23 19:00:49'),
(289, 'item_id', 'Item Name', '2015-06-23 20:02:14', '2015-06-23 20:02:14'),
(290, 'rate', 'Rate', '2015-06-23 20:02:33', '2015-06-23 20:02:33'),
(291, 'idate', 'Date', '2015-06-24 19:59:46', '2015-06-24 19:59:46'),
(292, 'lcimport_id', 'Import LC', '2015-06-24 20:00:25', '2015-06-24 20:00:25'),
(293, 'sdate', 'Date', '2015-06-24 22:27:25', '2015-06-24 22:27:25'),
(294, 'pre_due', 'Previous Due', '2015-06-24 22:27:51', '2015-06-24 22:27:51'),
(295, 'emp_id', 'Employee', '2015-06-25 15:54:11', '2015-06-25 15:54:11'),
(296, 'mobile', 'Mobile', '2015-06-25 15:54:32', '2015-06-25 15:54:32'),
(297, 'unit_id', 'Unit', '2015-06-26 23:18:33', '2015-06-26 23:18:33'),
(298, 'COA', 'COA', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(299, 'pm_id', 'Purchase ID', '2015-06-28 03:41:38', '2015-06-28 03:41:38'),
(300, 'sm_id', 'Sale ID', '2015-06-28 22:28:45', '2015-06-28 22:28:45'),
(301, 'vnumber', 'Voucher No', '2015-06-29 02:09:34', '2015-06-29 02:09:34'),
(302, 'tdate', 'Date', '2015-06-29 02:10:04', '2015-06-29 02:10:04'),
(303, 'note', 'Note', '2015-06-29 02:10:23', '2015-06-29 02:10:23'),
(304, 'appr_note', 'Note', '2015-06-29 02:10:56', '2015-06-29 02:10:56'),
(305, 'ttype', 'Transaction Mod', '2015-06-29 02:11:17', '2015-06-29 21:29:58'),
(306, 'com_id', 'Company', '2015-06-29 02:11:40', '2015-06-29 02:11:40'),
(307, 'proj_id', 'Project', '2015-06-29 02:12:05', '2015-06-29 02:12:05'),
(308, 'lc_id', 'LC Number', '2015-06-29 02:12:31', '2015-06-29 02:12:31'),
(309, 'ord_id', 'Order No', '2015-06-29 02:13:02', '2015-06-29 02:13:02'),
(310, 'stl_id', 'Style No', '2015-06-29 02:14:25', '2015-06-29 02:14:25'),
(312, 'stu_id', 'Student', '2015-06-29 02:14:49', '2015-06-29 02:14:49'),
(313, 'tranwith_id', 'Transaction With', '2015-06-29 04:00:01', '2015-07-02 00:34:14'),
(315, 'toperson', 'Paid To', '2015-06-29 04:10:07', '2015-06-30 00:22:46'),
(316, 'acc_id', 'Account Head', '2015-06-29 21:13:35', '2015-06-29 21:13:35'),
(317, 'tm_id', 'Transaction ID', '2015-06-29 22:44:35', '2015-06-29 22:44:35'),
(318, 'fmperson', 'Received From', '2015-06-30 00:23:57', '2015-06-30 00:24:31'),
(320, 'person', 'Through(Person)', '2015-06-30 00:25:53', '2015-06-30 22:26:45'),
(321, 'ndate', 'Notification Date', '2015-07-01 02:54:43', '2015-07-01 02:54:43'),
(322, 'req_id', 'Purchase Requisition', '2015-07-01 04:28:57', '2015-07-01 04:28:57'),
(323, 'ref', 'Reference', '2015-07-01 04:32:48', '2015-07-01 04:32:48'),
(324, 'location', 'Location', '2015-07-02 04:06:19', '2015-07-02 04:06:19'),
(325, 'cost', 'Project Cost', '2015-07-02 04:06:47', '2015-07-02 04:06:47'),
(326, 'fdate', 'Finished Date', '2015-07-02 04:08:40', '2015-07-02 04:08:40'),
(327, 'oaddress', ' Office Address', '2015-07-02 22:17:19', '2015-07-02 22:17:19'),
(329, 'faddress2', ' Factory Address', '2015-07-02 22:17:46', '2015-07-02 22:18:53'),
(330, 'fax', 'Fax', '2015-07-02 22:19:23', '2015-07-02 22:19:23'),
(332, 'web', 'Website', '2015-07-02 22:20:15', '2015-07-02 22:20:15'),
(334, 'stablish', 'Date of Stablishment', '2015-07-02 22:20:57', '2015-07-02 22:20:57'),
(335, 'md', 'Managing Director', '2015-07-02 22:21:25', '2015-07-02 22:21:25'),
(336, 'chair', 'Chairman', '2015-07-02 22:21:50', '2015-07-02 22:21:50'),
(337, 'd1', 'Director 1', '2015-07-02 22:22:14', '2015-07-02 22:22:14'),
(338, 'd2', 'Director 2', '2015-07-02 22:22:36', '2015-07-02 22:22:36'),
(339, 'd3', 'Director 3', '2015-07-02 22:23:03', '2015-07-02 22:23:03'),
(340, 'gname', 'Group Name', '2015-07-02 23:17:02', '2015-07-02 23:17:02'),
(341, 'ccount', 'Number of Companies', '2015-07-02 23:17:39', '2015-07-02 23:17:39'),
(342, 'm1', 'Accounting', '2015-07-02 23:19:35', '2015-07-02 23:19:35'),
(343, 'm2', 'Human Resources Management', '2015-07-02 23:20:14', '2015-07-02 23:21:30'),
(344, 'm3', 'Merchandising and Marketing ', '2015-07-02 23:20:40', '2015-07-02 23:21:53'),
(345, 'm4', 'Knitting', '2015-07-02 23:22:29', '2015-07-02 23:22:29'),
(346, 'm5', 'Dyeing', '2015-07-02 23:23:11', '2015-07-02 23:23:11'),
(347, 'm6', 'Planning', '2015-07-02 23:23:36', '2015-07-02 23:23:36'),
(348, 'm7', 'Invenory', '2015-07-02 23:24:12', '2015-07-02 23:24:12'),
(349, 'm8', 'Printing', '2015-07-02 23:24:33', '2015-07-02 23:24:33'),
(350, 'export', 'Export', '2015-07-03 02:39:09', '2015-07-03 02:39:09'),
(352, 'import', 'Import', '2015-07-03 02:39:25', '2015-07-03 02:39:25'),
(353, 'scenter', 'Sale Center', '2015-07-03 02:40:08', '2015-07-03 02:40:08'),
(355, 'budget', 'Budget', '2015-07-03 02:40:32', '2015-07-03 02:40:32'),
(356, 'project', 'Project', '2015-07-03 02:40:56', '2015-07-03 02:40:56'),
(357, 'audit', 'Internal Audit', '2015-07-03 02:41:21', '2015-07-03 02:41:21'),
(358, 'inventory', 'Inventory', '2015-07-03 02:41:47', '2015-07-03 02:41:47'),
(360, 'tcheck_id', 'Transaction Check By', '2015-07-03 02:42:26', '2015-07-03 02:43:07'),
(361, 'tappr_id', 'Transaction Approve By', '2015-07-03 02:43:39', '2015-07-03 02:43:39'),
(363, 'rcheck_id', 'Requisition Check By', '2015-07-03 02:44:11', '2015-07-03 02:44:11'),
(364, 'rappr_id', 'Requisition Approve By', '2015-07-03 02:44:44', '2015-07-03 02:44:44'),
(365, 'frcheck_id', 'Fund Requisition Check By', '2015-07-03 02:45:25', '2015-07-03 02:45:25'),
(366, 'frappr_id', 'Fund Requisition Approve By', '2015-07-03 02:46:00', '2015-07-03 02:46:00'),
(367, 'bstype', 'Business Type', '2015-07-03 02:48:03', '2015-07-03 02:48:03'),
(368, 'onem', 'One Module', '2015-07-04 03:07:53', '2015-07-04 03:07:53'),
(369, 'm9', 'Commercial', '2015-07-04 03:37:15', '2015-07-04 03:37:15'),
(370, 'incharge', 'In Charge', '2015-07-04 21:45:08', '2015-07-04 21:45:08'),
(372, 'title', 'Title', '2015-07-04 23:00:38', '2015-07-04 23:00:38'),
(373, 'sendto', 'Sent To', '2015-07-04 23:01:04', '2015-07-04 23:01:04'),
(374, 'audit_action', 'Audit Action', '2015-07-04 23:01:46', '2015-07-04 23:01:46'),
(375, 'reply_id', 'Reply By', '2015-07-04 23:02:20', '2015-07-04 23:02:20'),
(376, 'reply_note', 'Reply Note', '2015-07-04 23:02:43', '2015-07-04 23:02:43'),
(377, 'reply', 'Reply', '2015-07-04 23:58:57', '2015-07-04 23:58:57'),
(378, 'itype', 'Type', '2015-07-05 02:15:33', '2015-07-05 02:15:33'),
(380, 'audit_id', 'Audit By', '2015-07-05 02:18:25', '2015-07-05 02:18:25'),
(381, 'audit_note', 'Audit Note', '2015-07-05 02:19:04', '2015-07-05 02:19:04'),
(382, 'pro_id', 'Project No', '2015-07-06 00:02:50', '2015-07-06 00:02:50'),
(383, 'segment', 'Project Segment', '2015-07-06 00:03:27', '2015-07-06 00:03:27'),
(384, 'stdate', 'Start Date', '2015-07-06 00:04:09', '2015-07-06 00:04:09'),
(385, 'cldate', 'Close Date', '2015-07-06 00:04:29', '2015-07-06 00:04:29'),
(386, 'bamount', 'Amount', '2015-07-06 00:05:01', '2015-07-06 00:05:01'),
(387, 'gtype', 'Group Type', '2015-07-06 23:55:50', '2015-07-06 23:55:50'),
(388, 'seg_id', 'Segment', '2015-07-07 00:17:38', '2015-07-07 00:17:38'),
(389, 'prod_id', 'Product', '2015-07-07 00:18:28', '2015-07-07 00:18:28'),
(390, 'cur_id', 'Currency', '2015-07-07 00:19:15', '2015-07-07 00:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `lib_line_info`
--

CREATE TABLE IF NOT EXISTS `lib_line_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lineinfos_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;

--
-- Dumping data for table `lib_line_info`
--

INSERT INTO `lib_line_info` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Cutting', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(2, 'Finishing', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(3, 'Finishing(Production)', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(4, 'Floor-1', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(5, 'Floor-2', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(6, 'Knitting', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(7, 'Linking', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(8, 'Linking (Production)', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(9, 'Maintenance', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(10, 'Mending', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(11, 'Mending (Production)', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(12, 'Printing', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(13, 'Quality', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(14, 'Sample', 1, '2015-06-17 07:06:53', '2015-06-17 07:06:53', NULL),
(15, 'Sewing', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(16, 'Store', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(17, 'Sweater', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(18, 'Team-01', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(19, 'Team-02', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(20, 'Team-03', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(21, 'Team-04', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(22, 'Team-05', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(23, 'Team-06', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(24, 'Team-07', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(25, 'Team-08', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(26, 'Team-09', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(27, 'Team-10', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(28, 'Team-11', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(29, 'Team-12', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(30, 'Team-13', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(31, 'Team-14', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(32, 'Team-15', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(33, 'Team-16', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(34, 'Team-17', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(35, 'Team-18', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(36, 'Team-19', 1, '2015-06-17 07:06:54', '2015-06-17 07:06:54', NULL),
(37, 'Team-20', 1, '2015-06-17 07:06:55', '2015-06-17 07:06:55', NULL),
(38, 'Trimming', 1, '2015-06-17 07:06:55', '2015-06-17 07:06:55', NULL),
(39, 'Trimming (Production)', 1, '2015-06-17 07:06:55', '2015-06-17 07:06:55', NULL),
(40, 'Wash', 1, '2015-06-17 07:06:55', '2015-06-17 07:06:55', NULL),
(41, 'Winding', 1, '2015-06-17 07:06:55', '2015-06-17 07:06:55', NULL),
(42, 'Winding (Production)', 1, '2015-06-17 07:06:55', '2015-06-18 03:55:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_other_salaries`
--

CREATE TABLE IF NOT EXISTS `lib_other_salaries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_other_salaries_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `lib_other_salaries`
--

INSERT INTO `lib_other_salaries` (`id`, `name`, `amount`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Stamp', '10', 1, '2015-06-17 04:29:52', '2015-06-17 04:29:52', NULL),
(2, 'Att. Bonus', '500', 1, '2015-06-17 04:30:10', '2015-06-18 04:20:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_projects`
--

CREATE TABLE IF NOT EXISTS `lib_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_projects_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `lib_projects`
--

INSERT INTO `lib_projects` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'All', 1, '2015-06-15 09:45:13', '2015-06-19 21:50:03', NULL),
(2, 'Sahaba yarn Ltd. (Yarn Dyeing)', 1, '2015-06-14 22:37:16', '2015-06-14 22:37:16', NULL),
(3, 'Sahaba yarn Ltd. (Sweater)', 1, '2015-06-14 22:37:30', '2015-06-14 22:37:30', NULL),
(4, 'Sahaba yarn Ltd. (Febric Dyeing)', 1, '2015-06-14 22:37:46', '2015-06-14 22:37:46', NULL),
(5, 'Corporate', 1, '2015-06-14 22:38:03', '2015-06-14 22:38:03', NULL),
(6, 'Textile Horizon', 1, '2015-06-14 22:38:13', '2015-06-18 10:04:30', NULL),
(7, 'Horizon Fashion Wear Ltd.', 1, '2015-06-14 22:37:03', '2015-06-14 22:37:03', NULL),
(8, 'Fishing Project', 1, '2015-07-02 04:17:04', '2015-07-02 04:18:13', '2015-07-02 04:18:13'),
(9, 'Fishing Project', 1, '2015-07-02 04:17:51', '2015-07-02 04:18:03', '2015-07-02 04:18:03');

-- --------------------------------------------------------

--
-- Table structure for table `lib_religions`
--

CREATE TABLE IF NOT EXISTS `lib_religions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `religions_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lib_religions`
--

INSERT INTO `lib_religions` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Buddha', 1, '2015-06-16 03:04:54', '2015-06-16 03:04:54', NULL),
(2, 'Christian', 1, '2015-06-16 03:05:03', '2015-06-16 03:05:03', NULL),
(3, 'Hindu', 1, '2015-06-16 03:05:12', '2015-06-16 03:05:12', NULL),
(4, 'Islam', 1, '2015-06-16 03:05:21', '2015-06-18 04:26:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_sections`
--

CREATE TABLE IF NOT EXISTS `lib_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sections_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=52 ;

--
-- Dumping data for table `lib_sections`
--

INSERT INTO `lib_sections` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Yarn Store', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(2, 'Yarn Dyeing', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(3, 'Winding (Production)', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(4, 'Winding', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(5, 'Utility', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(6, 'Trimming (Production)', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(7, 'Trimming', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(8, 'Accounts', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(9, 'Admin', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(10, 'Audit & Administration', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(11, 'CAD', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(12, 'Commercial', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(13, 'Corporate', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(14, 'Cutting', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(15, 'Dyes C. Store', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(16, 'Electrical', 1, '2015-06-17 07:06:37', '2015-06-17 07:06:37', NULL),
(17, 'Embroidery', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(18, 'Fabric Dyeing', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(19, 'Finishing', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(20, 'Finishing (Production)', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(21, 'General Store', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(22, 'Holding', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(23, 'Horizon Fashion Wear Ltd.', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(24, 'IT', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(25, 'Knitting', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(26, 'Lab', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(27, 'Linking', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(28, 'Linking (Production)', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(29, 'Maintenance', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(30, 'Maintenance-1', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(31, 'Maintenance-2', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(32, 'Marketing', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(33, 'Mechanical', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(34, 'Mending', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(35, 'Mending (Production)', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(36, 'Merchandising', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(37, 'Planning', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(38, 'Printing', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(39, 'Production', 1, '2015-06-17 07:06:38', '2015-06-17 07:06:38', NULL),
(40, 'Quality', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(41, 'Sahaba yarn Ltd.', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(42, 'Sample', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(43, 'Section', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(44, 'Security', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(45, 'Sewing', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(46, 'Store - HSL', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(47, 'Store F & A', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(48, 'Store SYL', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(49, 'Sweater', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(50, 'T.H. Store', 1, '2015-06-17 07:06:39', '2015-06-17 07:06:39', NULL),
(51, 'Textile Horizon', 1, '2015-06-17 07:06:39', '2015-06-18 04:33:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_staff_categories`
--

CREATE TABLE IF NOT EXISTS `lib_staff_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_staff_categories_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `lib_staff_categories`
--

INSERT INTO `lib_staff_categories` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Staff', 1, '2015-06-17 01:49:40', '2015-06-17 01:49:40', NULL),
(2, 'Worker', 1, '2015-06-17 01:49:50', '2015-06-18 04:37:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_sub_sections`
--

CREATE TABLE IF NOT EXISTS `lib_sub_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_sub_sections_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `lib_sub_sections`
--

INSERT INTO `lib_sub_sections` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'A. Gardener', 1, '2015-06-16 05:13:39', '2015-06-16 05:13:39', NULL),
(2, 'Asst.Cook', 1, '2015-06-16 05:13:49', '2015-06-16 05:13:49', NULL),
(3, 'Cook', 1, '2015-06-16 05:13:56', '2015-06-16 05:13:56', NULL),
(4, 'Sweeper', 1, '2015-06-16 05:14:05', '2015-06-16 05:14:05', NULL),
(5, 'Team Leader', 1, '2015-06-16 05:14:16', '2015-06-16 05:14:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_units`
--

CREATE TABLE IF NOT EXISTS `lib_units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `units_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `lib_units`
--

INSERT INTO `lib_units` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Corporate', 1, '2015-06-16 04:25:48', '2015-06-16 04:25:48', NULL),
(2, 'Factory', 1, '2015-06-16 04:25:56', '2015-06-16 04:25:56', NULL),
(3, 'Factory - Gazipur', 1, '2015-06-16 04:26:11', '2015-06-16 04:26:11', NULL),
(4, 'Head Office', 1, '2015-06-16 04:26:27', '2015-06-16 04:26:27', NULL),
(5, 'Sahaba Yarn Ltd.', 1, '2015-06-16 04:26:42', '2015-06-16 04:26:42', NULL),
(6, 'Sahaba Yarn Ltd. sweater division', 1, '2015-06-16 04:26:56', '2015-06-16 04:26:56', NULL),
(7, 'Textile Horizon', 1, '2015-06-16 04:27:09', '2015-06-18 02:06:37', NULL),
(8, 'Pcs', 1, '2015-07-04 22:12:32', '2015-07-04 22:13:29', '2015-07-04 22:13:29'),
(9, 'Pcs', 1, '2015-07-04 22:13:07', '2015-07-04 22:13:19', '2015-07-04 22:13:19'),
(10, 'Pcs', 1, '2015-07-04 22:14:18', '2015-07-04 22:14:35', '2015-07-04 22:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `makers`
--

CREATE TABLE IF NOT EXISTS `makers` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `makers`
--

INSERT INTO `makers` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Toyota', 'Toyota cars', '2013-03-11 00:00:00', '2013-03-11 00:00:00'),
(2, 'Honda', 'Honda cars', '2013-03-11 00:00:00', '2013-03-11 00:00:00'),
(3, 'Mercedes', 'Mercedes cars', '2013-03-11 00:00:00', '2013-03-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_03_30_121557_entrust_setup_tables', 1),
('2015_06_13_111543_create_languages_table', 1),
('2015_06_15_094901_create_projects_table', 1),
('2015_06_15_095135_create_depts_table', 1),
('2015_06_15_105325_create_designations_table', 1),
('2015_06_15_163856_create_religions_table', 2),
('2015_06_16_090842_create_districts_table', 3),
('2015_06_16_093238_create_divisions_table', 4),
('2015_06_16_101732_create_units_table', 5),
('2015_06_16_104921_create_sections_table', 6),
('2015_06_16_110007_create_sub_sections_table', 7),
('2015_06_17_073110_create_staff_categories_table', 8),
('2015_06_17_084138_create_govt_salaries_table', 9),
('2015_06_17_092755_create_lineinfos_table', 10),
('2015_06_17_100014_create_grades_table', 11),
('2015_06_17_101144_create_other_salaries_table', 12),
('2015_06_17_103537_create_attendance_payment_names_table', 13),
('2015_06_20_053928_create_employee_basic_infos_table', 14),
('2015_06_16_034812_create_acccoas_table', 15),
('2015_06_17_065836_create_coadetails_table', 16),
('2015_06_17_102927_create_products_table', 17),
('2015_06_18_040902_create_orderinfos_table', 18),
('2015_06_18_044738_create_buyerinfos_table', 19),
('2015_06_18_054120_create_suppliers_table', 20),
('2015_06_18_075600_create_budgets_table', 21),
('2015_06_18_091142_create_prequisitions_table', 22),
('2015_06_18_095002_create_coaconditions_table', 23),
('2015_06_19_033401_create_lcinfos_table', 24),
('2015_06_19_104855_create_frequisitions_table', 25),
('2015_06_22_094337_create_clients_table', 26),
('2015_06_23_075135_create_styles_table', 27),
('2015_06_24_051452_create_lcimports_table', 28),
('2015_06_24_064242_create_purchasemasters_table', 29),
('2015_06_24_074923_create_purchasedetails_table', 30),
('2015_06_25_074838_create_importmasters_table', 31),
('2015_06_25_100258_create_salemasters_table', 32),
('2015_06_25_103758_create_outlets_table', 33),
('2015_06_26_074418_create_importdetails_table', 34),
('2015_06_27_135106_create_saledetails_table', 34),
('2015_06_25_064242_create_purchasemasters_table', 35),
('2015_06_28_094917_create_saledetails_table', 36),
('2015_06_29_075421_create_tranmasters_table', 37),
('2015_06_29_093803_create_trandetails_table', 38),
('2015_07_02_093518_create_projects_table', 39),
('2015_07_03_040327_create_companies_table', 40),
('2015_07_03_050824_create_settings_table', 41),
('2015_07_03_082859_create_options_table', 42),
('2015_07_05_033459_create_warehouses_table', 43),
('2015_07_05_035916_create_units_table', 44),
('2015_07_05_042308_create_currencies_table', 44),
('2015_07_05_044857_create_audits_table', 45),
('2015_07_05_080040_create_invenmasters_table', 46),
('2015_07_06_032011_create_invendetails_table', 47),
('2015_07_06_054932_create_pplannings_table', 48),
('2015_07_07_060419_create_pbudgets_table', 49);

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE IF NOT EXISTS `models` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `maker_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `maker_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 'Honda S2000', '', '2013-03-11 22:32:07', '2013-03-11 22:32:07'),
(2, 2, 'Civic', '', '2013-03-11 22:32:46', '2013-03-11 22:32:46'),
(3, 2, 'Fit', '', '2013-03-11 22:34:35', '2013-03-11 22:34:35'),
(4, 1, 'asdf asdf', '', '2013-03-11 22:35:31', '2013-03-11 22:35:31'),
(5, 1, 'Yaris', '', '2013-03-11 22:36:01', '2013-03-11 22:36:01'),
(6, 1, 'Corolla', '', '2013-03-11 22:36:23', '2013-03-11 22:36:23'),
(7, 1, 'Camry', '', '2013-03-11 22:36:31', '2013-03-11 22:36:31'),
(8, 3, 'SLK 500', '', '2013-03-11 22:36:47', '2013-03-11 22:36:47'),
(9, 3, 'C300', '', '2013-03-11 22:36:50', '2013-03-11 22:36:50'),
(10, 2, 'another item', '', '2013-03-11 22:36:52', '2013-03-11 22:36:52');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `route` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=249 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `route`, `created_at`, `updated_at`) VALUES
(1, 'manage_roles', 'Manage roles', '', 'RolesController@index', '2015-06-08 17:14:52', '2015-06-19 21:22:40'),
(2, 'create_roles', 'Create roles', '', 'RolesController@create', '2015-06-08 17:14:52', '2015-06-19 21:23:03'),
(3, 'update_roles', 'Update roles', '', 'RolesController@edit', '2015-06-08 17:14:52', '2015-06-19 21:23:36'),
(4, 'delete_roles', 'Delete roles', '', 'RolesController@destroy', '2015-06-08 17:14:52', '2015-06-19 21:24:36'),
(5, 'manage_users', 'Manager users', '', 'UsersController@index', '2015-06-08 17:14:52', '2015-06-19 21:25:34'),
(6, 'create_users', 'Create users', '', 'UsersController@create', '2015-06-08 17:14:53', '2015-06-19 21:26:05'),
(7, 'update_users', 'Update users', '', 'UsersController@edit', '2015-06-08 17:14:53', '2015-06-19 21:26:31'),
(8, 'delete_users', 'Delete users', '', 'UsersController@destroy', '2015-06-08 17:14:53', '2015-06-19 21:27:25'),
(9, 'manage_permissions', 'Manage permissions', '', 'PermissionsController@index', '2015-06-08 17:14:53', '2015-06-19 21:38:05'),
(10, 'create_permissions', 'Create permissions', '', 'PermissionsController@create', '2015-06-08 17:14:53', '2015-06-19 21:38:31'),
(11, 'update_permissions', 'Update permissions', '', 'PermissionsController@edit', '2015-06-08 17:14:53', '2015-06-19 21:38:50'),
(12, 'delete_permissions', 'Delete permissions', '', 'PermissionsController@destroy', '2015-06-08 17:14:53', '2015-06-19 21:39:21'),
(13, 'role_permission', 'Role & Permission', '', 'RolesPermissionsController@index', '2015-06-13 10:02:18', '2015-06-19 21:40:04'),
(14, 'user_only', 'User Only', '', '/', '2015-06-10 17:25:29', '2015-06-10 17:25:29'),
(15, 'admin_user', 'Admin User', '', '/', '2015-06-10 20:39:51', '2015-06-12 12:52:37'),
(16, 'manage_language', 'Manage language', '', 'LanguageController@index', '2015-06-12 17:26:01', '2015-06-19 21:41:18'),
(17, 'create_language', 'Create language', '', 'LanguageController@create', '2015-06-12 17:26:55', '2015-06-19 21:41:41'),
(18, 'update_language', 'Update language', '', 'LanguageController@edit', '2015-06-12 17:27:36', '2015-06-19 21:41:55'),
(19, 'delete_language', 'Delete language', '', 'LanguageController@destroy', '2015-06-12 17:28:14', '2015-06-19 21:42:13'),
(20, 'manage_project', 'Manage project', '', 'ProjectController@index', '2015-06-14 15:09:03', '2015-06-19 21:44:11'),
(21, 'create_project', 'Create project', '', 'ProjectController@create', '2015-06-14 15:10:01', '2015-06-19 21:44:33'),
(22, 'update_project', 'Update project', '', 'ProjectController@edit', '2015-06-14 15:10:55', '2015-06-19 21:44:54'),
(23, 'delete_project', 'Delete project', '', 'ProjectController@destroy', '2015-06-14 15:11:35', '2015-06-19 21:45:29'),
(24, 'trashed_project', 'Trashed projects', '', 'ProjectController@trashed', '2015-06-17 22:22:07', '2015-06-19 22:57:22'),
(25, 'manage_dept', 'Manage departments', '', 'DeptController@index', '2015-06-14 16:27:46', '2015-06-19 21:47:39'),
(26, 'create_dept', 'Create Department', '', 'DeptController@create', '2015-06-14 16:28:49', '2015-06-19 21:47:57'),
(27, 'update_dept', 'Update Department', '', 'DeptController@edit', '2015-06-14 16:29:42', '2015-06-19 21:48:14'),
(28, 'delete_dept', 'Delete Department', '', 'DeptController@destroy', '2015-06-14 16:30:33', '2015-06-19 21:48:31'),
(29, 'trashed_dept', 'Trashed Departments', '', 'DeptController@trashed', '2015-06-17 21:02:21', '2015-06-19 22:59:18'),
(30, 'manage_religion', 'Manage religion', '', 'ReligionController@index', '2015-06-15 04:49:35', '2015-06-19 22:00:12'),
(31, 'create_religion', 'Create religion', '', 'ReligionController@create', '2015-06-15 04:50:19', '2015-06-19 22:00:40'),
(32, 'update_religion', 'Update religion', '', 'ReligionController@edit', '2015-06-15 04:50:59', '2015-06-19 22:01:10'),
(33, 'delete_religion', 'Delete religion', '', 'ReligionController@destroy', '2015-06-15 04:51:37', '2015-06-19 22:01:33'),
(34, 'trashed_religion', 'Trashed religions', '', 'ReligionController@trashed', '2015-06-17 22:25:08', '2015-06-19 22:59:13'),
(35, 'manage_designation', 'Manage Designations', '', 'DesignationController@index', '2015-06-15 16:59:23', '2015-06-19 22:04:18'),
(36, 'create_designation', 'Create designation', '', 'DesignationController@create', '2015-06-15 16:59:56', '2015-06-19 22:04:44'),
(37, 'update_designation', 'Update designation', '', 'DesignationController@edit', '2015-06-15 17:00:29', '2015-06-19 22:05:05'),
(38, 'delete_designation', 'Delete designation', '', 'DesignationController@destroy', '2015-06-15 17:00:59', '2015-06-19 22:05:24'),
(39, 'trashed_designation', 'Trashed designation', '', 'DesignationController@trashed', '2015-06-17 21:18:29', '2015-06-19 22:59:07'),
(40, 'manage_district', 'Manage districts', '', 'DistrictController@index', '2015-06-15 21:22:24', '2015-06-19 22:06:50'),
(41, 'create_district', 'Create district', '', 'DistrictController@create', '2015-06-15 21:23:10', '2015-06-19 22:07:19'),
(42, 'update_district', 'Update district', '', 'DistrictController@edit', '2015-06-15 21:23:53', '2015-06-19 22:07:45'),
(43, 'delete_district', 'Delete district', '', 'DistrictController@destroy', '2015-06-15 21:24:48', '2015-06-19 22:08:22'),
(44, 'trashed_district', 'Trashed district', '', 'DistrictController@trashed', '2015-06-17 21:22:32', '2015-06-19 22:59:03'),
(45, 'manage_division', 'Manage divisions', '', 'DivisionController@index', '2015-06-15 21:38:37', '2015-06-19 22:10:06'),
(46, 'create_division', 'Create division', '', 'DivisionController@create', '2015-06-15 21:40:14', '2015-06-19 22:10:37'),
(47, 'update_division', 'Update division', '', 'DivisionController@edit', '2015-06-15 21:40:50', '2015-06-19 22:11:11'),
(48, 'delete_division', 'Delete division', '', 'DivisionController@destroy', '2015-06-15 21:41:36', '2015-06-19 22:11:27'),
(49, 'trashed_division', 'Trashed division', '', 'DivisionController@trashed', '2015-06-17 21:29:44', '2015-06-19 22:58:55'),
(50, 'manage_unit', 'Manage units', '', 'UnitController@index', '2015-06-15 22:23:42', '2015-06-19 22:13:17'),
(51, 'create_unit', 'Create unit', '', 'UnitController@create', '2015-06-15 22:24:13', '2015-06-19 22:14:13'),
(52, 'update_unit', 'Update unit', '', 'UnitController@edit', '2015-06-15 22:24:43', '2015-06-19 22:15:03'),
(53, 'delete_unit', 'Delete unit', '', 'UnitController@destroy', '2015-06-15 22:25:26', '2015-06-19 22:15:48'),
(54, 'trashed_unit', 'Trashed unit', '', 'UnitController@trashed', '2015-06-17 19:55:23', '2015-06-19 22:58:50'),
(55, 'manage_section', 'Manage sections', '', 'SectionController@index', '2015-06-15 22:55:15', '2015-06-19 22:25:56'),
(56, 'create_section', 'Create section', '', 'SectionController@create', '2015-06-15 22:55:44', '2015-06-19 22:26:21'),
(57, 'update_section', 'Update section', '', 'SectionController@edit', '2015-06-15 22:56:16', '2015-06-19 22:26:45'),
(58, 'delete_section', 'Delete section', '', 'SectionController@destroy', '2015-06-15 22:56:48', '2015-06-19 22:27:13'),
(59, 'trashed_section', 'Trashed sections', '', 'SectionController@trashed', '2015-06-17 22:32:03', '2015-06-19 22:58:45'),
(60, 'manage_sub_section', 'Manage Sub Sections', '', 'SubSectionController@index', '2015-06-15 23:10:26', '2015-06-19 22:28:25'),
(61, 'create_sub_section', 'Create Sub Section', '', 'SubSectionController@create', '2015-06-15 23:11:10', '2015-06-19 22:28:44'),
(62, 'update_sub_section', 'Update Sub Section', '', 'SubSectionController@edit', '2015-06-15 23:11:52', '2015-06-19 22:29:14'),
(63, 'delete_sub_section', 'Delete Sub Section', '', 'SubSectionController@destroy', '2015-06-15 23:12:27', '2015-06-19 22:29:37'),
(64, 'trashed_sub_section', 'Trashed sub section', '', 'SubSectionController@trashed', '2015-06-17 20:43:54', '2015-06-19 22:58:40'),
(65, 'manage_staff_category', 'Manage staff categories', '', 'StaffCategoryController@index', '2015-06-16 19:41:47', '2015-06-19 22:31:21'),
(66, 'create_staff_category', 'Create Staff Category', '', 'StaffCategoryController@create', '2015-06-16 19:43:06', '2015-06-19 22:31:36'),
(67, 'update_staff_category', 'Update Staff Category', '', 'StaffCategoryController@edit', '2015-06-16 19:43:50', '2015-06-19 22:31:55'),
(68, 'delete_staff_category', 'Delete Staff Category', '', 'StaffCategoryController@destroy', '2015-06-16 19:44:47', '2015-06-19 22:32:17'),
(69, 'trashed_staff_category', 'Trashed Staff Categories', '', 'StaffCategoryController@trashed', '2015-06-17 22:35:01', '2015-06-19 22:58:31'),
(70, 'manage_govt_salary', 'Manage Govt. Salary', '', 'GovtSalaryController@index', '2015-06-16 20:57:22', '2015-06-19 22:34:08'),
(71, 'create_govt_salary', 'Create Govt. Salary', '', 'GovtSalaryController@create', '2015-06-16 20:59:08', '2015-06-19 22:34:29'),
(72, 'update_govt_salary', 'Update Govt. Salary', '', 'GovtSalaryController@edit', '2015-06-16 20:59:57', '2015-06-19 22:34:48'),
(73, 'delete_govt_salary', 'Delete Govt. Salary', '', 'GovtSalaryController@destroy', '2015-06-16 21:00:50', '2015-06-19 22:35:07'),
(74, 'trashed_govt_salary', 'Trashed Govt. salaries', '', 'GovtSalaryController@trashed', '2015-06-17 21:36:47', '2015-06-19 22:58:25'),
(75, 'manage_lineinfo', 'Manage lineinfo', '', 'LineinfoController@index', '2015-06-16 21:36:36', '2015-06-19 22:36:06'),
(76, 'create_lineinfo', 'Create lineinfo', '', 'LineinfoController@create', '2015-06-16 21:37:41', '2015-06-19 22:36:27'),
(77, 'update_lineinfo', 'Update lineinfo', '', 'LineinfoController@edit', '2015-06-16 21:38:23', '2015-06-19 22:36:48'),
(78, 'delete_lineinfo', 'Delete lineinfo', '', 'LineinfoController@destroy', '2015-06-16 21:38:56', '2015-06-19 22:37:09'),
(79, 'trashed_lineinfo', 'Trashed lineinfo', '', 'LineinfoController@trashed', '2015-06-17 21:53:13', '2015-06-19 22:58:20'),
(80, 'manage_grade', 'Manage grade', '', 'GradeController@index', '2015-06-16 22:06:38', '2015-06-19 22:50:27'),
(81, 'create_grade', 'Create grade', '', 'GradeController@create', '2015-06-16 22:07:39', '2015-06-19 22:50:38'),
(82, 'update_grade', 'Update grade', '', 'GradeController@edit', '2015-06-16 22:08:09', '2015-06-19 22:50:55'),
(83, 'delete_grade', 'Delete grade', '', 'GradeController@destroy', '2015-06-16 22:08:38', '2015-06-19 22:52:04'),
(84, 'trashed_grade', 'Trashed grades', '', 'GradeController@trashed', '2015-06-17 21:48:46', '2015-06-19 22:58:13'),
(85, 'manage_other_salary', 'Manage Other Salary', '', 'OtherSalaryController@index', '2015-06-16 22:21:29', '2015-06-19 22:52:52'),
(86, 'create_other_salary', 'Create Other Salary', '', 'OtherSalaryController@create', '2015-06-16 22:22:16', '2015-06-19 22:53:04'),
(87, 'update_other_salary', 'Update Other Salary', '', 'OtherSalaryController@edit', '2015-06-16 22:23:04', '2015-06-19 22:53:23'),
(88, 'delete_other_salary', 'Delete Other Salary', '', 'OtherSalaryController@destroy', '2015-06-16 22:23:57', '2015-06-19 22:53:43'),
(89, 'trashed_other_salary', 'Trashed other salary', '', 'OtherSalaryController@trashed', '2015-06-17 21:59:28', '2015-06-19 22:58:08'),
(90, 'manage_attendance_payment_name', 'Manage Attendance payment names', '', 'AttendancePaymentNameController@index', '2015-06-16 22:51:44', '2015-06-19 22:56:18'),
(91, 'create_attendance_payment_name', 'Create Attendance payment name', '', 'AttendancePaymentNameController@create', '2015-06-16 22:52:42', '2015-06-19 22:56:00'),
(92, 'update_attendance_payment_name', 'Update Attendance payment name', '', 'AttendancePaymentNameController@edit', '2015-06-16 22:53:59', '2015-06-19 22:55:29'),
(93, 'delete_attendance_payment_name', 'Delete Attendance payment name', '', 'AttendancePaymentNameController@destroy', '2015-06-16 22:54:46', '2015-06-19 22:55:08'),
(94, 'trashed_attendance_payment_name', 'Trashed Attendance payment names', '', 'AttendancePaymentNameController@trashed', '2015-06-17 20:57:31', '2015-06-19 22:58:04'),
(95, 'manage_employee_basic_info', 'Manage Employee Basic Information', '', 'EmployeeBasicInfoController@index', '2015-06-20 00:30:51', '2015-06-20 00:30:51'),
(96, 'create_employee_basic_info', 'Create New Employee', '', 'EmployeeBasicInfoController@create', '2015-06-20 00:31:56', '2015-06-20 00:31:56'),
(97, 'update_employee_basic_info', 'Update Employee Info', '', 'EmployeeBasicInfoController@edit', '2015-06-20 00:32:34', '2015-06-20 00:32:34'),
(98, 'delete_employee_basic_info', 'Delete Employee basic info', '', 'EmployeeBasicInfoController@destroy', '2015-06-20 00:33:12', '2015-06-20 00:33:12'),
(99, 'trashed_employee_basic_info', 'Trashed Employee', '', 'EmployeeBasicInfoController@trashed', '2015-06-20 00:33:46', '2015-06-20 00:33:46'),
(100, 'manage_acccoa', 'Manage acccoa', '', 'AcccoaController@index', '2015-06-16 20:33:13', '2015-06-26 02:34:27'),
(101, 'create_acccoa', 'Create acccoa', '', 'acccoa/create', '2015-06-16 20:34:18', '2015-06-16 20:34:18'),
(102, 'update_acccoa', 'Update acccoa', '', 'acccoa/{users}/edit', '2015-06-16 20:49:56', '2015-06-16 20:49:56'),
(103, 'delete_acccoa', 'Delete acccoa', '', 'acccoa/{acccoa}', '2015-06-16 20:54:14', '2015-06-16 21:08:17'),
(104, 'manage_coadetail', 'Manage coadetail', '', 'CoadetailController@index', '2015-06-16 20:56:22', '2015-06-25 23:21:14'),
(105, 'create_coadetail', 'Create coadetail', '', 'CoadetailController@create', '2015-06-16 20:57:31', '2015-06-25 23:21:34'),
(106, 'update_coadetail', 'Update coadetail', '', 'CoadetailController@edit', '2015-06-16 20:59:12', '2015-06-25 23:21:56'),
(107, 'delete_coadetail', 'Delete coadetail', '', 'CoadetailController@delete', '2015-06-16 21:06:58', '2015-06-25 23:22:13'),
(108, 'manage_coacondition', 'manage coacondition', '', 'coacondition', '2015-06-16 22:05:56', '2015-06-16 22:05:56'),
(109, 'create_coacondition', 'create coacondition', '', 'coacondition/create', '2015-06-16 22:06:30', '2015-06-16 22:06:30'),
(110, 'update_coacondition', 'update coacondition', '', 'coacondition/{coacondition}/edit', '2015-06-16 22:08:22', '2015-06-16 22:09:54'),
(111, 'delete_coacondition', 'delete coacondition', '', 'coacondition/{coacondition}', '2015-06-16 22:09:03', '2015-06-16 22:09:03'),
(112, 'manage_product', 'manage_product', '', 'product', '2015-06-16 23:03:04', '2015-06-16 23:03:04'),
(113, 'create_product', 'create_product', '', 'product/create', '2015-06-16 23:03:48', '2015-06-16 23:03:48'),
(114, 'update_product', 'update_product', '', 'product/{product}/edit', '2015-06-16 23:04:37', '2015-06-16 23:04:37'),
(115, 'delete_product', 'delete_product', '', 'product/{product}', '2015-06-16 23:05:13', '2015-06-16 23:05:13'),
(116, 'manage_lcinfo', 'manage lcinfo', '', 'lcinfo', '2015-06-17 15:41:16', '2015-06-17 15:41:16'),
(117, 'create_lcinfo', 'create lcinfo', '', 'lcinfo/create', '2015-06-17 15:42:01', '2015-06-17 15:42:01'),
(118, 'update_lcinfo', 'update lcinfo', '', 'cinfo/{cinfo}/edit', '2015-06-17 15:42:43', '2015-06-17 15:43:24'),
(119, 'delete_lcinfo', 'delete lcinfo', '', 'lcinfo/{lcinfo}', '2015-06-17 15:44:22', '2015-06-17 16:00:56'),
(120, 'manage_orderinfo', 'manage orderinfo', '', 'orderinfo', '2015-06-17 16:16:26', '2015-06-17 16:16:26'),
(121, 'create_orderinfo', 'create orderinfo', '', 'orderinfo/create', '2015-06-17 16:19:37', '2015-06-17 16:19:37'),
(122, 'update_orderinfo', 'update orderinfo', '', 'orderinfo/{orderinfo}/edit', '2015-06-17 16:20:25', '2015-06-17 16:20:25'),
(123, 'delete_orderinfo', 'delete orderinfo', '', 'orderinfo/{orderinfo}', '2015-06-17 16:21:20', '2015-06-17 16:21:20'),
(124, 'manage_buyerinfo', 'manage buyerinfo', '', 'BuyerinfoController@index', '2015-06-17 16:52:47', '2015-06-25 23:11:19'),
(125, 'create_buyerinfo', 'manage buyerinfo', '', 'BuyerinfoController@create', '2015-06-17 16:53:47', '2015-06-25 23:12:26'),
(126, 'update_buyerinfo', 'update buyerinfo', '', 'BuyerinfoController@edit', '2015-06-17 16:54:29', '2015-06-25 23:12:41'),
(127, 'delete_buyerinfo', 'delete buyerinfo', '', 'BuyerinfoController@delete', '2015-06-17 16:54:59', '2015-06-25 23:13:01'),
(128, 'manage_budget', 'Manage Budget', '', 'budget', '2015-06-17 20:00:59', '2015-06-17 20:00:59'),
(129, 'create_budget', 'Create Budget', '', 'budget/create', '2015-06-17 20:02:58', '2015-06-17 20:02:58'),
(130, 'update_budget', 'Update Budget', '', 'budget/{budget}/edit', '2015-06-17 20:03:37', '2015-06-17 20:03:37'),
(131, 'delete_budget', 'Delete Budget', '', 'budget/{budget}', '2015-06-17 20:04:12', '2015-06-17 20:04:12'),
(132, 'manage_prequisition', 'Manage Rpequisition', '', 'prequisition', '2015-06-17 21:21:21', '2015-06-17 21:21:21'),
(133, 'create_prequisition', 'Create Rpequisition', '', 'prequisition/create', '2015-06-17 21:21:48', '2015-06-17 21:21:48'),
(134, 'update_prequisition', 'Update prequisition', '', 'prequisition/{prequisition}/edit', '2015-06-17 21:22:37', '2015-06-17 21:22:37'),
(135, 'delete_prequisition', 'Delete prequisition', '', 'prequisition/{prequisition}', '2015-06-17 21:23:11', '2015-06-17 21:23:11'),
(136, 'manage_frequisition', 'Manage Frequisition', '', 'frequisition', '2015-06-19 01:33:36', '2015-06-19 01:33:36'),
(137, 'create_frequisition', 'Create Frequisition', '', 'frequisition/create', '2015-06-19 01:34:26', '2015-06-19 01:34:26'),
(138, 'update_frequisition', 'update frequisition', '', 'frequisition/{frequisition}/edit', '2015-06-19 01:35:58', '2015-06-19 01:35:58'),
(139, 'delete_frequisition', 'delete frequisition', '', 'frequisition/{delete_frequisition}', '2015-06-19 01:37:06', '2015-06-19 01:37:06'),
(140, 'manage_client', 'manage client', '', 'client', '2015-06-21 21:51:21', '2015-06-21 21:51:21'),
(141, 'create_client', 'Create client', '', 'client/create', '2015-06-21 21:52:06', '2015-06-21 21:52:06'),
(142, 'update_client', 'update client', '', 'client/{client}/edit', '2015-06-22 15:06:59', '2015-06-22 15:07:27'),
(143, 'delete_client', 'delete client', '', 'client/{client}', '2015-06-22 15:09:10', '2015-06-22 15:09:10'),
(144, 'manage_style', 'manage style', '', 'style', '2015-06-22 20:03:28', '2015-06-22 20:03:28'),
(145, 'create_style', 'create style', '', 'style/creae', '2015-06-22 20:04:05', '2015-06-22 20:04:05'),
(146, 'update_style', 'update style', '', 'style/{style}/edit', '2015-06-22 20:05:06', '2015-06-22 20:05:06'),
(147, 'delete_style', 'delete style', '', 'style/{style}', '2015-06-22 20:05:43', '2015-06-22 20:43:25'),
(148, 'manage_supplier', 'manage supplier', '', 'supplier', '2015-06-22 20:49:56', '2015-06-22 20:49:56'),
(149, 'create_supplier', 'create supplier', '', 'supplier/create', '2015-06-22 20:50:58', '2015-06-22 20:50:58'),
(150, 'update_supplier', 'update supplier', '', 'supplier/{supplier}/edit', '2015-06-22 20:56:47', '2015-06-22 20:56:47'),
(151, 'delete_supplier', 'delete supplier', '', 'supplier/{supplier}', '2015-06-22 20:57:46', '2015-06-22 20:57:46'),
(152, 'manage_lcimport', 'manage lcimport', '', 'lcimport', '2015-06-23 17:27:09', '2015-06-23 17:27:09'),
(153, 'create_lcimport', 'create lcimport', '', 'lcimport/create', '2015-06-23 17:28:01', '2015-06-23 17:28:01'),
(154, 'update_lcimport', 'update lcimport', '', 'lcimport/{lcimport}/edit', '2015-06-23 17:28:43', '2015-06-23 17:28:43'),
(155, 'delete_lcimport', 'delete lcimport', '', 'lcimport/{lcimport}', '2015-06-23 17:29:28', '2015-06-23 17:29:28'),
(156, 'manage_purchasemaster', 'manage purchasemaster', '', 'purchasemaster', '2015-06-23 18:53:49', '2015-06-23 18:53:49'),
(157, 'create_purchasemaster', 'create purchasemaster', '', 'purchasemaster/create', '2015-06-23 18:54:36', '2015-06-23 18:56:30'),
(158, 'update_purchasemaster', 'update purchasemaster', '', 'purchasemaster/{purchasemaster}/edit', '2015-06-23 18:55:20', '2015-06-23 18:55:20'),
(159, 'delete_purchasemaster', 'delete purchasemaster', '', 'purchasemaster/{purchasemaster}', '2015-06-23 18:55:48', '2015-06-23 18:55:48'),
(160, 'manage_purchasedetail', 'manage purchasedetail', '', 'purchasedetail', '2015-06-23 19:59:44', '2015-06-23 19:59:44'),
(161, 'create_purchasedetail', 'create purchasedetail', '', 'purchasedetail/create', '2015-06-23 20:00:16', '2015-06-23 20:00:16'),
(162, 'update_purchasedetail', 'Update purchasedetail', '', 'purchasedetail/{purchasedetail}/edit', '2015-06-23 20:00:57', '2015-06-23 20:00:57'),
(163, 'delete_purchasedetail', 'Delete purchasedetail', '', 'purchasedetail/{purchasedetail}', '2015-06-23 20:01:25', '2015-06-23 20:01:25'),
(164, 'manage_importmaster', 'manage importmaster', '', 'importmaster', '2015-06-24 19:57:25', '2015-06-24 19:57:25'),
(165, 'create_importmaster', 'create importmaster', '', 'importmaster/create', '2015-06-24 19:58:05', '2015-06-24 19:58:05'),
(166, 'update_importmaster', 'update importmaster', '', 'importmaster/{importmaster}/edit', '2015-06-24 19:58:46', '2015-06-24 19:58:46'),
(167, 'delete_importmaster', 'Delete importmaster', '', ' importmaster/{importmaster}', '2015-06-24 19:59:13', '2015-06-24 19:59:13'),
(168, 'manage_importdetail', 'manage importdetail', '', 'importdetail', '2015-06-24 20:37:55', '2015-06-24 20:37:55'),
(169, 'create_importdetail', 'create importdetail', '', 'importdetail/create', '2015-06-24 20:38:35', '2015-06-24 20:38:35'),
(170, 'update_importdetail', 'update importdetail', '', 'importdetail/{importdetail}/edit', '2015-06-24 20:39:16', '2015-06-24 20:39:16'),
(171, 'delete_importdetail', 'delete importdetail', '', 'importdetail/{importdetail}', '2015-06-24 20:39:47', '2015-06-24 20:39:47'),
(172, 'manage_salemaster', 'manage salemaster', '', 'salemaster', '2015-06-24 22:24:07', '2015-06-24 22:24:07'),
(173, 'create_salemaster', 'create salemaster', '', 'salemaster/create', '2015-06-24 22:24:46', '2015-06-24 22:24:46'),
(174, 'update_salemaster', 'update salemaster', '', 'salemaster/{salemaster}/edit', '2015-06-24 22:25:29', '2015-06-24 22:25:29'),
(175, 'delete_salemaster', 'delete salemaster', '', 'salemaster/{salemaster}', '2015-06-24 22:26:45', '2015-06-24 22:26:45'),
(176, 'manage_outlet', 'manage outlet', '', 'outlet', '2015-06-25 15:50:59', '2015-06-25 15:50:59'),
(177, 'create_outlet', 'create outlet', '', 'outlet/create', '2015-06-25 15:51:43', '2015-06-25 15:51:43'),
(178, 'update_outlet', 'update outlet', '', 'outlet/{outlet}/edit', '2015-06-25 15:52:42', '2015-06-25 15:52:42'),
(179, 'delete_outlet', 'delete outlet', '', 'outlet/delete', '2015-06-25 15:53:39', '2015-06-25 15:53:39'),
(181, 'manage_saledetail', 'manage saledetail', '', 'saledetail', '2015-06-28 22:04:39', '2015-06-28 22:04:39'),
(183, 'create_saledetail', 'create saledetail', '', 'saledetail/create', '2015-06-28 22:05:23', '2015-06-28 22:05:23'),
(184, 'update_saledetail', 'update saledetail', '', 'saledetail/{saledetail}/edit', '2015-06-28 22:06:14', '2015-06-28 22:06:14'),
(185, 'delete_saledetail', 'delete saledetail', '', 'saledetail/{saledetail}', '2015-06-28 22:06:49', '2015-06-28 22:06:49'),
(186, 'manage_tranmaster', 'manage tranmaster', '', 'tranmaster', '2015-06-29 02:02:47', '2015-06-29 02:02:47'),
(188, 'create_tranmaster', 'create tranmaster', '', 'tranmaster/create', '2015-06-29 02:03:10', '2015-06-29 02:03:10'),
(189, 'update_tranmaster', 'update tranmaster', '', 'tranmaster/{tranmaster}/edit', '2015-06-29 02:03:49', '2015-06-29 02:03:49'),
(190, 'delete_tranmaster', 'delete tranmaster', '', 'tranmaster/{tranmaster}', '2015-06-29 02:04:18', '2015-06-29 02:04:18'),
(191, 'manage_trandetail', 'manage tandetail', '', 'trandetail', '2015-06-29 22:32:38', '2015-06-29 22:33:21'),
(192, 'create_trandetail', 'create trandetail', '', 'trandetail/create', '2015-06-29 22:33:59', '2015-06-29 22:33:59'),
(194, 'update_trandetail', 'update trandetail', '', 'trandetail/{trandetail}/edit', '2015-06-29 22:34:33', '2015-06-29 22:34:33'),
(195, 'delete_trandetail', 'delete trandetail', '', 'trandetail/{trandetail}', '2015-06-29 22:35:06', '2015-06-29 22:35:06'),
(197, 'manage_acc-project', 'manage acc-project', '', 'acc-project', '2015-07-02 03:58:25', '2015-07-02 03:58:25'),
(198, 'create_acc-project', 'create acc-project', '', 'acc-project/create', '2015-07-02 03:59:09', '2015-07-02 03:59:09'),
(199, 'update_acc-project', 'update acc-project', '', 'acc-project/{acc-project}/edit', '2015-07-02 03:59:52', '2015-07-02 03:59:52'),
(200, 'delete_acc-project', 'delete acc-project', '', 'acc-project/{acc-project}', '2015-07-02 04:00:37', '2015-07-02 04:00:37'),
(201, 'manage_company', 'manage company', '', 'company', '2015-07-02 22:14:41', '2015-07-02 22:14:41'),
(202, 'create_company', 'Create company', '', 'company/create', '2015-07-02 22:15:15', '2015-07-02 22:15:15'),
(203, 'update_company', 'Update company', '', ' company/{company}/edit', '2015-07-02 22:15:50', '2015-07-02 22:15:50'),
(204, 'delete_company', 'Delete company', '', 'company/{company}', '2015-07-02 22:16:21', '2015-07-02 22:16:21'),
(206, 'manage_setting', 'manage setting', '', 'setting', '2015-07-02 23:13:57', '2015-07-02 23:13:57'),
(207, 'create_setting', 'Create setting', '', 'setting/create', '2015-07-02 23:14:37', '2015-07-02 23:14:37'),
(208, 'update_setting', 'Update setting', '', 'setting/{setting}/edit', '2015-07-02 23:15:17', '2015-07-02 23:15:17'),
(209, 'delete_setting', 'Delete setting', '', 'setting/{setting}', '2015-07-02 23:15:54', '2015-07-02 23:15:54'),
(210, 'manage_option', 'manage option', '', 'option', '2015-07-03 02:36:25', '2015-07-03 02:36:25'),
(211, 'create_option', 'Create option', '', 'option/create', '2015-07-03 02:36:56', '2015-07-03 02:36:56'),
(212, 'update_option', 'Update option', '', 'option/{option]/edit', '2015-07-03 02:37:29', '2015-07-03 02:37:29'),
(213, 'delete_option', 'Delete option', '', 'option/{ option}', '2015-07-03 02:38:14', '2015-07-03 02:38:14'),
(214, 'checked_tranmaster', 'checked tranmaster', '', 'TranmasterController@checked', '2015-07-03 22:57:21', '2015-07-03 22:57:21'),
(215, 'manage_warehouse', 'Manage warehouse', '', 'warehouse', '2015-07-04 21:42:39', '2015-07-04 21:42:39'),
(216, 'create_warehouse', 'create warehouse', '', 'warehouse/create', '2015-07-04 21:43:09', '2015-07-04 21:43:09'),
(217, 'update_warehouse', 'Update warehouse', '', 'warehouse/{warehouse}/edit', '2015-07-04 21:43:39', '2015-07-04 21:43:39'),
(219, 'delete_warehouse', 'delete warehouse', '', 'warehouse/{warehouse}', '2015-07-04 21:44:07', '2015-07-04 21:44:07'),
(220, 'manage_acc-unit', 'Manage acc-unit', '', 'acc-unit', '2015-07-04 22:10:30', '2015-07-04 22:10:30'),
(221, 'create_acc-unit', 'Create acc-unit', '', 'acc-unit/create', '2015-07-04 22:11:07', '2015-07-04 22:11:07'),
(222, 'update_acc-unit', 'Update acc-unit', '', 'acc-unit/{acc-unit}/edit', '2015-07-04 22:11:42', '2015-07-04 22:11:42'),
(224, 'delete_acc-unit', 'Delete acc-unit', '', 'acc-unit/{acc-unit}', '2015-07-04 22:12:07', '2015-07-04 22:12:07'),
(225, 'mansage_acc-currency', 'Manage acc-currency', '', 'acc-currency', '2015-07-04 22:32:31', '2015-07-04 22:32:31'),
(226, 'create_acc-currency', 'Create acc-currency', '', 'acc-currency/create', '2015-07-04 22:33:03', '2015-07-04 22:33:03'),
(227, 'update_acc-currency', 'Update acc-currency', '', 'acc-currency/{acc-currency}/edit', '2015-07-04 22:33:35', '2015-07-04 22:33:35'),
(228, 'delete_acc-currency', 'Delete acc-currency', '', 'acc-currency/{acc-currency}', '2015-07-04 22:34:03', '2015-07-04 22:34:03'),
(229, 'manage_audit', 'Manage Audit', '', 'audit', '2015-07-04 22:58:35', '2015-07-04 22:58:35'),
(230, 'create_audit', 'Create audit', '', 'audit/create', '2015-07-04 22:59:02', '2015-07-04 22:59:02'),
(231, 'update_audit', 'Update audit', '', 'audit/{audit}/edit', '2015-07-04 22:59:36', '2015-07-04 22:59:36'),
(232, 'delete_audit', 'Delete Aduit', '', 'audit/{audit}', '2015-07-04 23:00:10', '2015-07-04 23:00:10'),
(233, 'manage_invenmaster', 'Manage invenmaster', '', 'invenmaster', '2015-07-05 02:12:56', '2015-07-05 02:12:56'),
(234, 'create_invenmaster', 'Create invenmaster', '', 'invenmaster/create', '2015-07-05 02:13:30', '2015-07-05 02:13:30'),
(235, 'update_invenmaster', 'Update invenmaster', '', 'invenmaster/{invenmaster}/edit', '2015-07-05 02:14:10', '2015-07-05 02:14:10'),
(236, 'delete_invenmaster', 'Delete invenmaster', '', 'invenmaster/{invenmaster}', '2015-07-05 02:14:40', '2015-07-05 02:14:40'),
(237, 'manage_invendetail', 'manage invendetail', '', 'invendetail', '2015-07-05 22:17:25', '2015-07-05 22:17:25'),
(238, 'create_invendetail', 'Create invendetail', '', 'invendetail/create', '2015-07-05 22:18:19', '2015-07-05 22:18:19'),
(239, 'update_invendetail', 'Update invendetail', '', 'invendetail/{invendetail}/edit', '2015-07-05 22:19:06', '2015-07-05 22:21:13'),
(240, 'delete_invendetail', 'Delete invendetail', '', 'invendetail/{invendetail}', '2015-07-05 22:19:51', '2015-07-05 22:19:51'),
(241, 'manage_pplanning', 'manage pplanning', '', 'pplanning', '2015-07-05 23:59:54', '2015-07-05 23:59:54'),
(242, 'create_pplanning', 'Create pplanning', '', 'pplanning/create', '2015-07-06 00:00:27', '2015-07-06 00:00:27'),
(243, 'update_pplanning', 'Update pplanning', '', 'pplanning/{pplanning}', '2015-07-06 00:01:01', '2015-07-06 00:01:01'),
(244, 'delete_pplanning', 'Delete pplanning', '', 'pplanning/{pplanning}', '2015-07-06 00:01:37', '2015-07-06 00:01:37'),
(245, 'manage_pbudget', 'Manage pbudget', '', 'pbudget', '2015-07-07 00:14:59', '2015-07-07 00:14:59'),
(246, 'create_pbudget', 'Create pbudget', '', ' pbudget/create', '2015-07-07 00:15:33', '2015-07-07 00:15:33'),
(247, 'update_pbudget', 'Update pbudget', '', 'pbudget/{pbudget}/edit', '2015-07-07 00:16:08', '2015-07-07 00:16:08'),
(248, 'delete_pbudget', 'Delete pbudget', '', ' pbudget/{pbudget}', '2015-07-07 00:16:42', '2015-07-07 00:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1),
(153, 1),
(154, 1),
(155, 1),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(160, 1),
(161, 1),
(162, 1),
(163, 1),
(164, 1),
(165, 1),
(166, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(171, 1),
(172, 1),
(173, 1),
(174, 1),
(175, 1),
(176, 1),
(177, 1),
(178, 1),
(179, 1),
(181, 1),
(183, 1),
(184, 1),
(185, 1),
(186, 1),
(188, 1),
(189, 1),
(190, 1),
(191, 1),
(192, 1),
(194, 1),
(195, 1),
(197, 1),
(198, 1),
(199, 1),
(200, 1),
(201, 1),
(202, 1),
(203, 1),
(204, 1),
(206, 1),
(207, 1),
(208, 1),
(209, 1),
(210, 1),
(211, 1),
(212, 1),
(213, 1),
(214, 1),
(215, 1),
(216, 1),
(217, 1),
(219, 1),
(220, 1),
(221, 1),
(222, 1),
(224, 1),
(225, 1),
(226, 1),
(227, 1),
(228, 1),
(229, 1),
(230, 1),
(231, 1),
(232, 1),
(233, 1),
(234, 1),
(235, 1),
(236, 1),
(237, 1),
(238, 1),
(239, 1),
(240, 1),
(241, 1),
(242, 1),
(243, 1),
(244, 1),
(245, 1),
(246, 1),
(247, 1),
(248, 1),
(1, 2),
(2, 2),
(3, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(14, 2),
(15, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(90, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(99, 2),
(100, 2),
(101, 2),
(102, 2),
(103, 2),
(104, 2),
(105, 2),
(106, 2),
(107, 2),
(108, 2),
(109, 2),
(110, 2),
(111, 2),
(112, 2),
(113, 2),
(114, 2),
(115, 2),
(116, 2),
(117, 2),
(118, 2),
(119, 2),
(120, 2),
(121, 2),
(122, 2),
(123, 2),
(124, 2),
(125, 2),
(126, 2),
(127, 2),
(128, 2),
(129, 2),
(130, 2),
(131, 2),
(132, 2),
(133, 2),
(134, 2),
(135, 2),
(136, 2),
(137, 2),
(138, 2),
(139, 2),
(140, 2),
(141, 2),
(142, 2),
(143, 2),
(144, 2),
(145, 2),
(146, 2),
(147, 2),
(148, 2),
(149, 2),
(150, 2),
(151, 2),
(152, 2),
(153, 2),
(154, 2),
(155, 2),
(156, 2),
(157, 2),
(158, 2),
(159, 2),
(160, 2),
(161, 2),
(162, 2),
(163, 2),
(164, 2),
(165, 2),
(166, 2),
(167, 2),
(168, 2),
(169, 2),
(170, 2),
(171, 2),
(172, 2),
(173, 2),
(174, 2),
(175, 2),
(176, 2),
(177, 2),
(178, 2),
(179, 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `level`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'Administrator', NULL, 999, '2015-06-08 23:14:51', '2015-06-08 23:14:51'),
(2, 'admin', 'Admin', '', 100, '2015-06-13 19:59:53', '2015-06-16 05:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sazzad Hossain', 'sazzad@ocmsbd.com', '$2y$10$J3R1OHuwgELST0cWbPZV5eRYOt9a14wO05W4F6H3SaLHyOMk2xp1i', 'Ne5M9UTtsmjBqo2chwHgTjd5Ms11dbOF83HeEuj8cdRVu3Vqy33D4gJaQUDd', '2015-06-08 23:14:49', '2015-06-26 04:24:11', NULL),
(2, 'Editor', 'editor@editor.com', '$2y$10$Zzxs12HurKioDMNck3mq4.hga0mNccH325xeoAayjD.8ObO2Whopa', 'FevVnU4zj4KXHS4QgJjgrEolgK1ELbwlxJyac2dSEKebAGOS9tJJYf58Cnjs', '2015-06-08 23:14:49', '2015-06-14 19:43:17', NULL),
(3, 'User', 'user@user.com', '$2y$10$BBVeWjyZB3RyGSz1PBvG0OqDP19v3e7jQIpLnUmHZc9.mRPz2/N4a', 'AaD6bwcrcoKUmsFciT8ZwLcUeK4AlCOjrOB2wakIMgbJHsCmg7eyYQ46ANGd', '2015-06-08 23:14:49', '2015-06-11 16:22:07', NULL),
(4, 'Hasan', 'hasan@ocmsbd.com', '$2y$10$BVxTTBkchBfd6SiIId2H1OHSzTRO.6w65bKRipfEhcpHhlsrVsUNW', 'Vt96FHFE1IhUbX0s3wk6UwmHV4BNlk4H7unvWyzSElyCsPZX8YsW3BEkC4Oc', '2015-06-20 21:16:56', '2015-07-07 21:08:08', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acc_audits`
--
ALTER TABLE `acc_audits`
  ADD CONSTRAINT `audits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_budgets`
--
ALTER TABLE `acc_budgets`
  ADD CONSTRAINT `acc_budgets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_buyerinfos`
--
ALTER TABLE `acc_buyerinfos`
  ADD CONSTRAINT `acc_buyerinfos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_clients`
--
ALTER TABLE `acc_clients`
  ADD CONSTRAINT `acc_clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_coaconditions`
--
ALTER TABLE `acc_coaconditions`
  ADD CONSTRAINT `acc_coaconditions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_coadetails`
--
ALTER TABLE `acc_coadetails`
  ADD CONSTRAINT `acc_coadetails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_coas`
--
ALTER TABLE `acc_coas`
  ADD CONSTRAINT `acc_coas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_companies`
--
ALTER TABLE `acc_companies`
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_currencies`
--
ALTER TABLE `acc_currencies`
  ADD CONSTRAINT `acc_currencies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_frequisitions`
--
ALTER TABLE `acc_frequisitions`
  ADD CONSTRAINT `acc_frequisitions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_importdetails`
--
ALTER TABLE `acc_importdetails`
  ADD CONSTRAINT `acc_importdetails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_importmasters`
--
ALTER TABLE `acc_importmasters`
  ADD CONSTRAINT `acc_importmasters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_invendetails`
--
ALTER TABLE `acc_invendetails`
  ADD CONSTRAINT `invendetails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_invenmasters`
--
ALTER TABLE `acc_invenmasters`
  ADD CONSTRAINT `invenmasters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_lcimports`
--
ALTER TABLE `acc_lcimports`
  ADD CONSTRAINT `acc_lcimports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_lcinfos`
--
ALTER TABLE `acc_lcinfos`
  ADD CONSTRAINT `acc_lcinfos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_options`
--
ALTER TABLE `acc_options`
  ADD CONSTRAINT `options_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_orderinfos`
--
ALTER TABLE `acc_orderinfos`
  ADD CONSTRAINT `acc_orderinfos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_outlets`
--
ALTER TABLE `acc_outlets`
  ADD CONSTRAINT `acc_outlets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_pbudgets`
--
ALTER TABLE `acc_pbudgets`
  ADD CONSTRAINT `pbudgets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_pplannings`
--
ALTER TABLE `acc_pplannings`
  ADD CONSTRAINT `pplannings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_prequisitions`
--
ALTER TABLE `acc_prequisitions`
  ADD CONSTRAINT `acc_prequisitions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_products`
--
ALTER TABLE `acc_products`
  ADD CONSTRAINT `acc_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_projects`
--
ALTER TABLE `acc_projects`
  ADD CONSTRAINT `projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_purchasedetails`
--
ALTER TABLE `acc_purchasedetails`
  ADD CONSTRAINT `acc_purchasedetails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_purchasemasters`
--
ALTER TABLE `acc_purchasemasters`
  ADD CONSTRAINT `acc_purchasemasters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_saledetails`
--
ALTER TABLE `acc_saledetails`
  ADD CONSTRAINT `acc_saledetails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_salemasters`
--
ALTER TABLE `acc_salemasters`
  ADD CONSTRAINT `acc_salemasters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_settings`
--
ALTER TABLE `acc_settings`
  ADD CONSTRAINT `settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_styles`
--
ALTER TABLE `acc_styles`
  ADD CONSTRAINT `acc_styles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_suppliers`
--
ALTER TABLE `acc_suppliers`
  ADD CONSTRAINT `acc_suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_trandetails`
--
ALTER TABLE `acc_trandetails`
  ADD CONSTRAINT `trandetails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_tranmasters`
--
ALTER TABLE `acc_tranmasters`
  ADD CONSTRAINT `tranmasters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_units`
--
ALTER TABLE `acc_units`
  ADD CONSTRAINT `acc_units_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `acc_warehouses`
--
ALTER TABLE `acc_warehouses`
  ADD CONSTRAINT `warehouses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `hrm_employee_basic_info`
--
ALTER TABLE `hrm_employee_basic_info`
  ADD CONSTRAINT `hrm_employee_basic_info_per_dist_foreign` FOREIGN KEY (`per_dist`) REFERENCES `lib_districts` (`id`),
  ADD CONSTRAINT `hrm_employee_basic_info_per_division_foreign` FOREIGN KEY (`per_division`) REFERENCES `lib_divisions` (`id`),
  ADD CONSTRAINT `hrm_employee_basic_info_pre_dist_foreign` FOREIGN KEY (`pre_dist`) REFERENCES `lib_districts` (`id`),
  ADD CONSTRAINT `hrm_employee_basic_info_pre_division_foreign` FOREIGN KEY (`pre_division`) REFERENCES `lib_divisions` (`id`),
  ADD CONSTRAINT `hrm_employee_basic_info_religion_foreign` FOREIGN KEY (`religion`) REFERENCES `lib_religions` (`id`),
  ADD CONSTRAINT `hrm_employee_basic_info_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_attendance_payment_names`
--
ALTER TABLE `lib_attendance_payment_names`
  ADD CONSTRAINT `lib_attendance_payment_names_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_depts`
--
ALTER TABLE `lib_depts`
  ADD CONSTRAINT `lib_depts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_designations`
--
ALTER TABLE `lib_designations`
  ADD CONSTRAINT `lib_designations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_districts`
--
ALTER TABLE `lib_districts`
  ADD CONSTRAINT `districts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_divisions`
--
ALTER TABLE `lib_divisions`
  ADD CONSTRAINT `divisions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_govt_salaries`
--
ALTER TABLE `lib_govt_salaries`
  ADD CONSTRAINT `lib_govt_salaries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_grades`
--
ALTER TABLE `lib_grades`
  ADD CONSTRAINT `grades_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_line_info`
--
ALTER TABLE `lib_line_info`
  ADD CONSTRAINT `lineinfos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_other_salaries`
--
ALTER TABLE `lib_other_salaries`
  ADD CONSTRAINT `lib_other_salaries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_projects`
--
ALTER TABLE `lib_projects`
  ADD CONSTRAINT `lib_projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_religions`
--
ALTER TABLE `lib_religions`
  ADD CONSTRAINT `religions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_sections`
--
ALTER TABLE `lib_sections`
  ADD CONSTRAINT `sections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_staff_categories`
--
ALTER TABLE `lib_staff_categories`
  ADD CONSTRAINT `lib_staff_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_sub_sections`
--
ALTER TABLE `lib_sub_sections`
  ADD CONSTRAINT `lib_sub_sections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lib_units`
--
ALTER TABLE `lib_units`
  ADD CONSTRAINT `units_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
