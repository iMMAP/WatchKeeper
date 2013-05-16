-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 24, 2011 at 05:40 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `sms_admin`
--

CREATE TABLE IF NOT EXISTS `sms_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sms_admin`
--

INSERT INTO `sms_admin` (`id`, `username`, `password`, `status`) VALUES
(1, 'admin', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_country`
--

CREATE TABLE IF NOT EXISTS `sms_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sms_country`
--

INSERT INTO `sms_country` (`id`, `country`, `status`) VALUES
(1, 'Pakistan', 1),
(2, 'UAE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_group`
--

CREATE TABLE IF NOT EXISTS `sms_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sms_group`
--

INSERT INTO `sms_group` (`id`, `group_name`, `country_id`, `org_id`, `date_time`, `status`) VALUES
(1, 'iMMAP', 2, 1, '0000-00-00 00:00:00', 1),
(2, 'iMMAP-Pakistan', 1, 2, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_organization`
--

CREATE TABLE IF NOT EXISTS `sms_organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sms_organization`
--

INSERT INTO `sms_organization` (`id`, `organization`, `date_time`, `status`) VALUES
(1, 'UNOCHA', '0000-00-00 00:00:00', 1),
(2, 'iMMAP', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_subgroup`
--

CREATE TABLE IF NOT EXISTS `sms_subgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `subgroup` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sms_subgroup`
--

INSERT INTO `sms_subgroup` (`id`, `group_id`, `subgroup`, `date_time`, `status`) VALUES
(1, 2, 'test2', '0000-00-00 00:00:00', 1),
(2, 1, 'test1', '0000-00-00 00:00:00', 1);
