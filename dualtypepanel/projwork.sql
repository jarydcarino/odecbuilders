-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 25, 2015 at 03:15 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ololrenders`
--

-- --------------------------------------------------------

--
-- Table structure for table `projwork`
--

CREATE TABLE IF NOT EXISTS `projwork` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `eID` int(11) NOT NULL,
  `project` varchar(40) NOT NULL,
  `timeIn` time NOT NULL,
  `timeOut` time DEFAULT NULL,
  `hrWork` time DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `projwork`
--

INSERT INTO `projwork` (`id`, `eID`, `project`, `timeIn`, `timeOut`, `hrWork`, `date`) VALUES
(3, 112, 'Nignog Building', '22:44:00', '22:48:00', NULL, '2015-03-25'),
(4, 112, 'Nignog Building', '22:47:00', '22:48:00', NULL, '2015-03-25');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
