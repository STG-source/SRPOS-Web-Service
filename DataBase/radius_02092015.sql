-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2015 at 12:27 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `radius`
--

-- --------------------------------------------------------

--
-- Table structure for table `radacct`
--

CREATE TABLE IF NOT EXISTS `radacct` (
  `radacctid` bigint(21) NOT NULL AUTO_INCREMENT,
  `acctsessionid` varchar(64) NOT NULL DEFAULT '',
  `acctuniqueid` varchar(32) NOT NULL DEFAULT '',
  `username` varchar(64) NOT NULL DEFAULT '',
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `realm` varchar(64) DEFAULT '',
  `nasipaddress` varchar(15) NOT NULL DEFAULT '',
  `nasportid` varchar(15) DEFAULT NULL,
  `nasporttype` varchar(32) DEFAULT NULL,
  `acctstarttime` datetime DEFAULT NULL,
  `acctstoptime` datetime DEFAULT NULL,
  `acctsessiontime` int(12) DEFAULT NULL,
  `acctauthentic` varchar(32) DEFAULT NULL,
  `connectinfo_start` varchar(50) DEFAULT NULL,
  `connectinfo_stop` varchar(50) DEFAULT NULL,
  `acctinputoctets` bigint(20) DEFAULT NULL,
  `acctoutputoctets` bigint(20) DEFAULT NULL,
  `calledstationid` varchar(50) NOT NULL DEFAULT '',
  `callingstationid` varchar(50) NOT NULL DEFAULT '',
  `acctterminatecause` varchar(32) NOT NULL DEFAULT '',
  `servicetype` varchar(32) DEFAULT NULL,
  `framedprotocol` varchar(32) DEFAULT NULL,
  `framedipaddress` varchar(15) NOT NULL DEFAULT '',
  `acctstartdelay` int(12) DEFAULT NULL,
  `acctstopdelay` int(12) DEFAULT NULL,
  `xascendsessionsvrkey` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`radacctid`),
  KEY `username` (`username`),
  KEY `framedipaddress` (`framedipaddress`),
  KEY `acctsessionid` (`acctsessionid`),
  KEY `acctsessiontime` (`acctsessiontime`),
  KEY `acctuniqueid` (`acctuniqueid`),
  KEY `acctstarttime` (`acctstarttime`),
  KEY `acctstoptime` (`acctstoptime`),
  KEY `nasipaddress` (`nasipaddress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `radcheck`
--

CREATE TABLE IF NOT EXISTS `radcheck` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '==',
  `value` varchar(253) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `username` (`username`(32))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=199 ;

--
-- Dumping data for table `radcheck`
--

INSERT INTO `radcheck` (`id`, `username`, `attribute`, `op`, `value`) VALUES
(1, 'user1', '123', ':=', '123'),
(2, 'najuuuu', 'user', '==', '5566'),
(4, 'najuumm', 'user', '==', '5566'),
(5, 'm2', 'Expiration', ':=', '14 May 2015 10:00'),
(6, 'vvee', 'Expiration', ':=', '14 May 2015 10:00'),
(7, 'V58060004', 'User-Password', ':=', '7777'),
(8, 'V58060004', 'Max-All-Session', ':=', '300'),
(9, 'V58060004', 'Expiration', ':=', '24 May 2015 24:00'),
(10, 'V58060005', 'User-Password', ':=', '7777'),
(11, 'V58060005', 'Max-All-Session', ':=', '300'),
(12, 'V58060005', 'Expiration', ':=', '24 May 2015 24:00'),
(13, 'V58060006', 'User-Password', ':=', '7777'),
(14, 'V58060006', 'Max-All-Session', ':=', '300'),
(15, 'V58060006', 'Expiration', ':=', '24 May 2015 24:00'),
(16, 'V58060007', 'User-Password', ':=', '7777'),
(17, 'V58060007', 'Max-All-Session', ':=', '300'),
(18, 'V58060007', 'Expiration', ':=', '24 May 2015 24:00'),
(19, 'C58060001', 'User-Password', ':=', '7777'),
(20, 'C58060001', 'Max-All-Session', ':=', '300'),
(21, 'C58060001', 'Expiration', ':=', '24 May 2015 24:00'),
(22, 'C58060002', 'User-Password', ':=', '7777'),
(23, 'C58060002', 'Max-All-Session', ':=', '300'),
(24, 'C58060002', 'Expiration', ':=', '24 May 2015 24:00'),
(25, 'C58060003', 'User-Password', ':=', '7777'),
(26, 'C58060003', 'Max-All-Session', ':=', '300'),
(27, 'C58060003', 'Expiration', ':=', '24 May 2015 24:00'),
(28, 'C58060004', 'User-Password', ':=', '7777'),
(29, 'C58060004', 'Max-All-Session', ':=', '10800'),
(30, 'C58060004', 'Expiration', ':=', '24 May 2015 24:00'),
(31, 'C58060005', 'User-Password', ':=', '7777'),
(32, 'C58060005', 'Max-All-Session', ':=', '300'),
(33, 'C58060005', 'Expiration', ':=', '24 May 2015 24:00'),
(34, 'V58060008', 'User-Password', ':=', '7777'),
(35, 'V58060008', 'Max-All-Session', ':=', '300'),
(36, 'V58060008', 'Expiration', ':=', '24 May 2015 24:00'),
(37, 'V58060009', 'User-Password', ':=', '7777'),
(38, 'V58060009', 'Max-All-Session', ':=', '300'),
(39, 'V58060009', 'Expiration', ':=', '24 May 2015 24:00'),
(40, 'C58060006', 'User-Password', ':=', '7777'),
(41, 'C58060006', 'Max-All-Session', ':=', '300'),
(42, 'C58060006', 'Expiration', ':=', '24 May 2015 24:00'),
(43, 'C58060007', 'User-Password', ':=', '7777'),
(44, 'C58060007', 'Max-All-Session', ':=', '300'),
(45, 'C58060007', 'Expiration', ':=', '24 May 2015 24:00'),
(46, 'C58060008', 'User-Password', ':=', '7777'),
(47, 'C58060008', 'Max-All-Session', ':=', '300'),
(48, 'C58060008', 'Expiration', ':=', '24 May 2015 24:00'),
(49, 'V58060010', 'User-Password', ':=', '7777'),
(50, 'V58060010', 'Max-All-Session', ':=', '300'),
(51, 'V58060010', 'Expiration', ':=', '24 May 2015 24:00'),
(52, 'C58060009', 'User-Password', ':=', '7777'),
(53, 'C58060009', 'Max-All-Session', ':=', '300'),
(54, 'C58060009', 'Expiration', ':=', '24 May 2015 24:00'),
(55, 'C58060010', 'User-Password', ':=', '7777'),
(56, 'C58060010', 'Max-All-Session', ':=', '300'),
(57, 'C58060010', 'Expiration', ':=', '24 May 2015 24:00'),
(58, 'V58060011', 'User-Password', ':=', '7777'),
(59, 'V58060011', 'Max-All-Session', ':=', '300'),
(60, 'V58060011', 'Expiration', ':=', '24 May 2015 24:00'),
(61, 'V58060013', 'User-Password', ':=', '7777'),
(62, 'V58060013', 'Max-All-Session', ':=', '300'),
(63, 'V58060013', 'Expiration', ':=', '24 May 2015 24:00'),
(64, 'V58060014', 'User-Password', ':=', '7777'),
(65, 'V58060014', 'Max-All-Session', ':=', '300'),
(66, 'V58060014', 'Expiration', ':=', '24 May 2015 24:00'),
(67, 'V58060015', 'User-Password', ':=', '7777'),
(68, 'V58060015', 'Max-All-Session', ':=', '300'),
(69, 'V58060015', 'Expiration', ':=', '24 May 2015 24:00'),
(70, 'V58060016', 'User-Password', ':=', '7777'),
(71, 'V58060016', 'Max-All-Session', ':=', '300'),
(72, 'V58060016', 'Expiration', ':=', '24 May 2015 24:00'),
(73, 'V58060001', 'User-Password', ':=', '7777'),
(74, 'V58060001', 'Max-All-Session', ':=', '300'),
(75, 'V58060001', 'Expiration', ':=', '24 May 2015 24:00'),
(76, 'V58060002', 'User-Password', ':=', '7777'),
(77, 'V58060002', 'Max-All-Session', ':=', '300'),
(78, 'V58060002', 'Expiration', ':=', '24 May 2015 24:00'),
(79, 'V58060001', 'User-Password', ':=', '7777'),
(80, 'V58060001', 'Max-All-Session', ':=', '300'),
(81, 'V58060001', 'Expiration', ':=', '24 May 2015 24:00'),
(82, 'V58060002', 'User-Password', ':=', '7777'),
(83, 'V58060002', 'Max-All-Session', ':=', '300'),
(84, 'V58060002', 'Expiration', ':=', '24 May 2015 24:00'),
(85, 'V58060003', 'User-Password', ':=', '7777'),
(86, 'V58060003', 'Max-All-Session', ':=', '300'),
(87, 'V58060003', 'Expiration', ':=', '24 May 2015 24:00'),
(88, 'V58070001', 'User-Password', ':=', '7777'),
(89, 'V58070001', 'Max-All-Session', ':=', '300'),
(90, 'V58070001', 'Expiration', ':=', '24 May 2015 24:00'),
(91, 'V58070002', 'User-Password', ':=', '7777'),
(92, 'V58070002', 'Max-All-Session', ':=', '300'),
(93, 'V58070002', 'Expiration', ':=', '24 May 2015 24:00'),
(94, 'V58070003', 'User-Password', ':=', '7777'),
(95, 'V58070003', 'Max-All-Session', ':=', '300'),
(96, 'V58070003', 'Expiration', ':=', '24 May 2015 24:00'),
(97, 'V58070004', 'User-Password', ':=', '7777'),
(98, 'V58070004', 'Max-All-Session', ':=', '300'),
(99, 'V58070004', 'Expiration', ':=', '24 May 2015 24:00'),
(100, 'C58070001', 'User-Password', ':=', '7777'),
(101, 'C58070001', 'Max-All-Session', ':=', '300'),
(102, 'C58070001', 'Expiration', ':=', '24 May 2015 24:00'),
(103, 'V58070005', 'User-Password', ':=', '7777'),
(104, 'V58070005', 'Max-All-Session', ':=', '300'),
(105, 'V58070005', 'Expiration', ':=', '24 May 2015 24:00'),
(106, 'V58070006', 'User-Password', ':=', '7777'),
(107, 'V58070006', 'Max-All-Session', ':=', '300'),
(108, 'V58070006', 'Expiration', ':=', '24 May 2015 24:00'),
(109, 'V58070007', 'User-Password', ':=', '7777'),
(110, 'V58070007', 'Max-All-Session', ':=', '300'),
(111, 'V58070007', 'Expiration', ':=', '24 May 2015 24:00'),
(112, 'V58070008', 'User-Password', ':=', '7777'),
(113, 'V58070008', 'Max-All-Session', ':=', '300'),
(114, 'V58070008', 'Expiration', ':=', '24 May 2015 24:00'),
(115, 'V58070009', 'User-Password', ':=', '7777'),
(116, 'V58070009', 'Max-All-Session', ':=', '300'),
(117, 'V58070009', 'Expiration', ':=', '24 May 2015 24:00'),
(118, 'V58070010', 'User-Password', ':=', '7777'),
(119, 'V58070010', 'Max-All-Session', ':=', '300'),
(120, 'V58070010', 'Expiration', ':=', '24 May 2015 24:00'),
(121, 'V58070011', 'User-Password', ':=', '7777'),
(122, 'V58070011', 'Max-All-Session', ':=', '300'),
(123, 'V58070011', 'Expiration', ':=', '24 May 2015 24:00'),
(124, 'V58070012', 'User-Password', ':=', '7777'),
(125, 'V58070012', 'Max-All-Session', ':=', '300'),
(126, 'V58070012', 'Expiration', ':=', '24 May 2015 24:00'),
(127, 'V58070013', 'User-Password', ':=', '7777'),
(128, 'V58070013', 'Max-All-Session', ':=', '300'),
(129, 'V58070013', 'Expiration', ':=', '24 May 2015 24:00'),
(130, 'V58070015', 'User-Password', ':=', '7777'),
(131, 'V58070015', 'Max-All-Session', ':=', '300'),
(132, 'V58070015', 'Expiration', ':=', '24 May 2015 24:00'),
(133, 'V58070016', 'User-Password', ':=', '7777'),
(134, 'V58070016', 'Max-All-Session', ':=', '300'),
(135, 'V58070016', 'Expiration', ':=', '24 May 2015 24:00'),
(136, 'C58070005', 'User-Password', ':=', '7777'),
(137, 'C58070005', 'Max-All-Session', ':=', '300'),
(138, 'C58070005', 'Expiration', ':=', '24 May 2015 24:00'),
(139, 'C58070006', 'User-Password', ':=', '7777'),
(140, 'C58070006', 'Max-All-Session', ':=', '300'),
(141, 'C58070006', 'Expiration', ':=', '24 May 2015 24:00'),
(142, 'C58070007', 'User-Password', ':=', '7777'),
(143, 'C58070007', 'Max-All-Session', ':=', '300'),
(144, 'C58070007', 'Expiration', ':=', '24 May 2015 24:00'),
(145, 'C58070008', 'User-Password', ':=', '7777'),
(146, 'C58070008', 'Max-All-Session', ':=', '300'),
(147, 'C58070008', 'Expiration', ':=', '24 May 2015 24:00'),
(148, 'C58070009', 'User-Password', ':=', '7777'),
(149, 'C58070009', 'Max-All-Session', ':=', '300'),
(150, 'C58070009', 'Expiration', ':=', '24 May 2015 24:00'),
(151, 'V58070017', 'User-Password', ':=', '7777'),
(152, 'V58070017', 'Max-All-Session', ':=', '300'),
(153, 'V58070017', 'Expiration', ':=', '24 May 2015 24:00'),
(154, 'V58070018', 'User-Password', ':=', '7777'),
(155, 'V58070018', 'Max-All-Session', ':=', '300'),
(156, 'V58070018', 'Expiration', ':=', '24 May 2015 24:00'),
(157, 'V58070019', 'User-Password', ':=', '7777'),
(158, 'V58070019', 'Max-All-Session', ':=', '300'),
(159, 'V58070019', 'Expiration', ':=', '24 May 2015 24:00'),
(160, 'C58070010', 'User-Password', ':=', '7777'),
(161, 'C58070010', 'Max-All-Session', ':=', '300'),
(162, 'C58070010', 'Expiration', ':=', '24 May 2015 24:00'),
(163, 'C58070011', 'User-Password', ':=', '7777'),
(164, 'C58070011', 'Max-All-Session', ':=', '300'),
(165, 'C58070011', 'Expiration', ':=', '24 May 2015 24:00'),
(166, 'C58070012', 'User-Password', ':=', '7777'),
(167, 'C58070012', 'Max-All-Session', ':=', '300'),
(168, 'C58070012', 'Expiration', ':=', '24 May 2015 24:00'),
(169, 'C58070013', 'User-Password', ':=', '7777'),
(170, 'C58070013', 'Max-All-Session', ':=', '300'),
(171, 'C58070013', 'Expiration', ':=', '24 May 2015 24:00'),
(172, 'C58070014', 'User-Password', ':=', '7777'),
(173, 'C58070014', 'Max-All-Session', ':=', '300'),
(174, 'C58070014', 'Expiration', ':=', '24 May 2015 24:00'),
(175, 'C58080006', 'User-Password', ':=', 'a562nj'),
(176, 'C58080006', 'Max-All-Session', ':=', '10800'),
(177, 'C58080006', 'Expiration', ':=', '30 August 2015 24:00'),
(178, 'C58080007', 'User-Password', ':=', '8sah35'),
(179, 'C58080007', 'Max-All-Session', ':=', '10800'),
(180, 'C58080007', 'Expiration', ':=', '30 August 2015 24:00'),
(181, 'C58080007', 'User-Password', ':=', '8sah35'),
(182, 'C58080007', 'Max-All-Session', ':=', '10800'),
(183, 'C58080007', 'Expiration', ':=', '30 August 2015 24:00'),
(184, 'C58080008', 'User-Password', ':=', '8028ue'),
(185, 'C58080008', 'Max-All-Session', ':=', '10800'),
(186, 'C58080008', 'Expiration', ':=', '30 August 2015 24:00'),
(187, 'C58080009', 'User-Password', ':=', '1Cjjfz'),
(188, 'C58080009', 'Max-All-Session', ':=', '10800'),
(189, 'C58080009', 'Expiration', ':=', '30 August 2015 24:00'),
(190, 'C58080009', 'User-Password', ':=', '1Cjjfz'),
(191, 'C58080009', 'Max-All-Session', ':=', '10800'),
(192, 'C58080009', 'Expiration', ':=', '30 August 2015 24:00'),
(193, 'C58080009', 'User-Password', ':=', '1Cjjfz'),
(194, 'C58080009', 'Max-All-Session', ':=', '10800'),
(195, 'C58080009', 'Expiration', ':=', '30 August 2015 24:00'),
(196, 'C58080010', 'User-Password', ':=', '6xmgh7'),
(197, 'C58080011', 'User-Password', ':=', 'j108bg'),
(198, 'C58080012', 'User-Password', ':=', '0C9c59');

-- --------------------------------------------------------

--
-- Table structure for table `radgroupcheck`
--

CREATE TABLE IF NOT EXISTS `radgroupcheck` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '==',
  `value` varchar(253) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `groupname` (`groupname`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `radgroupreply`
--

CREATE TABLE IF NOT EXISTS `radgroupreply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '=',
  `value` varchar(253) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `groupname` (`groupname`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `radpostauth`
--

CREATE TABLE IF NOT EXISTS `radpostauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `pass` varchar(64) NOT NULL DEFAULT '',
  `reply` varchar(32) NOT NULL DEFAULT '',
  `authdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `radreply`
--

CREATE TABLE IF NOT EXISTS `radreply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '=',
  `value` varchar(253) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `username` (`username`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `radusergroup`
--

CREATE TABLE IF NOT EXISTS `radusergroup` (
  `username` varchar(64) NOT NULL DEFAULT '',
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `priority` int(11) NOT NULL DEFAULT '1',
  KEY `username` (`username`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
