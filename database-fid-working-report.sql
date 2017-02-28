-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 25, 2016 at 02:33 PM
-- Server version: 10.0.26-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `idfuucom_wr`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `login_id` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`login_id`, `password`, `name`) VALUES
('admin', 'admin', 'Fujitsu WR Admin');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `time_break` time NOT NULL,
  `totaltime` time NOT NULL,
  `overtime` time NOT NULL,
  `place` varchar(100) NOT NULL,
  `activity` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `time_out`, `time_break`, `totaltime`, `overtime`, `place`, `activity`, `timestamp`) VALUES
(107, '95877', '2016-08-02', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'jdgjfjhcjhf', 'jgdjgckgckh', '2016-08-24 08:07:19'),
(106, '95892', '2016-08-04', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'jgdjgdjgdgj', 'fjgdjgdjgdjgc', '2016-08-24 08:06:36'),
(57, '95942', '2016-07-12', '06:30:00', '17:10:00', '01:00:00', '09:40:00', '01:40:00', 'TMMIN', 'Create name card in ISTD Karawang', '2016-08-11 02:51:23'),
(58, '95942', '2016-07-13', '06:30:00', '17:05:00', '01:00:00', '09:35:00', '01:35:00', 'TMMIN', 'Create MoM weekly meeting, Weekly meeting ISTD', '2016-08-11 02:52:42'),
(59, '95942', '2016-07-15', '06:30:00', '17:00:00', '01:00:00', '09:30:00', '01:30:00', 'TMMIN', 'Create name card in ISTD Karawang', '2016-08-11 02:53:31'),
(60, '95942', '2016-07-18', '06:30:00', '17:00:00', '01:00:00', '09:30:00', '01:30:00', 'TMMIN', 'Create Code project in Project List', '2016-08-11 02:54:35'),
(61, '95942', '2016-07-19', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'TMMIN', 'Create Code project in Project List Infrastructure, Update Code Project', '2016-08-11 02:56:19'),
(62, '95942', '2016-07-20', '06:05:00', '18:05:00', '01:00:00', '11:00:00', '03:00:00', 'TMMIN', 'Create Code project in Project List Sunter, Update Code Project ', '2016-08-11 02:58:02'),
(63, '95942', '2016-07-21', '06:30:00', '19:10:00', '01:00:00', '11:40:00', '03:40:00', 'TMMIN', 'Create summary project ISTD ', '2016-08-11 02:58:50'),
(64, '95942', '2016-07-22', '06:29:00', '18:05:00', '01:00:00', '10:36:00', '02:36:00', 'TMMIN', 'Meeting Project progrest july 2016 summary, project ISTD', '2016-08-11 03:00:32'),
(65, '95942', '2016-07-25', '06:40:00', '17:30:00', '01:00:00', '09:50:00', '01:50:00', 'TMMIN', 'Create Code project in Project List Karawang, Update Code Project', '2016-08-11 03:02:14'),
(66, '95942', '2016-07-26', '07:30:00', '17:30:00', '01:00:00', '09:00:00', '01:00:00', 'TMMIN', 'Meeting Project list Karawang, update project list karawang', '2016-08-11 03:03:37'),
(67, '95942', '2016-07-27', '06:58:00', '17:40:00', '01:00:00', '09:42:00', '01:42:00', 'TMMIN', 'Meeting Coordination Workload project ISTD, update project list', '2016-08-11 03:05:25'),
(68, '95942', '2016-07-28', '06:30:00', '17:00:00', '01:00:00', '09:30:00', '01:30:00', 'TMMIN', 'Create organization structure ISTD, Create MoM, Update project list', '2016-08-11 03:06:39'),
(69, '95942', '2016-07-29', '06:30:00', '17:32:00', '01:00:00', '10:02:00', '02:02:00', 'TMMIN', 'Create organization structure ISTD, Update project list', '2016-08-11 03:07:39'),
(70, '95911', '2016-08-01', '08:00:00', '18:00:00', '01:00:00', '09:00:00', '01:00:00', 'fid', 'develop', '2016-08-11 04:08:56'),
(71, '95911', '2016-08-02', '08:00:00', '18:30:00', '01:00:00', '09:30:00', '01:30:00', 'fid', 'develop', '2016-08-11 04:09:44'),
(105, '95893', '2016-08-03', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'aaaaaaaaaassssssssssddddddddddffffffffffgggggggggghhhhhhhhhhjjjjjjjjjjkkkkkkkkkklllllllllllppppppppo', 'jgdgjdjgdkhfkhfkhfhkfkhfkhfkhfkhfkhfkhdkhfkhfkhfkhckhvkhckhcjhcjhjgckhckhckhckhckgckgcjgcjhggbgjcgjd', '2016-08-24 08:10:59'),
(104, '95896', '2016-08-02', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'jgdhgdhtd', 'fshfxhfxhf', '2016-08-24 08:00:34'),
(103, '95898', '2016-08-01', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'vtvybyvt', 'cfcfvtvt', '2016-08-24 07:59:34'),
(99, '95811', '2017-01-02', '08:00:00', '18:15:00', '01:00:00', '09:15:00', '01:15:00', 'BBF', 'Opsu', '2016-08-24 07:03:00'),
(100, '95811', '2016-07-01', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'jgfjgfky', 'figdjgfkhfyi', '2016-08-24 07:05:58'),
(101, '99999', '2016-08-01', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'jgcjgcig', 'dutdugdugdu', '2016-08-24 07:57:14'),
(97, '95811', '2016-08-02', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'MBF/BBF', 'Opsu', '2016-08-25 07:32:55'),
(102, '95906', '2016-08-01', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'igcugcigv', 'dutfiyfiyf', '2016-08-24 07:58:11'),
(96, '95811', '2016-08-01', '08:00:00', '20:15:00', '01:00:00', '11:15:00', '03:15:00', 'MBF', 'Opsu', '2016-08-24 06:55:27'),
(84, '95944', '2016-05-02', '08:08:00', '19:48:00', '01:00:00', '10:40:00', '02:40:00', 'FID', 'Bug fixing', '2016-08-19 08:24:10'),
(85, '95944', '2016-05-03', '08:09:00', '17:31:00', '01:00:00', '08:22:00', '00:22:00', 'TMMIN', 'Deploy CIS', '2016-08-19 08:27:28'),
(86, '95944', '2016-06-01', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'TMMIN', 'Through Test', '2016-08-19 08:34:47'),
(87, '95944', '2016-06-02', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'TMMIN', 'Support Sosialisasi CIS', '2016-08-19 08:36:42'),
(88, '95944', '2016-07-01', '09:03:00', '19:00:00', '01:00:00', '08:57:00', '00:57:00', 'TMMIN', 'Deploy and Testing CIS', '2016-08-19 08:38:51'),
(89, '95944', '2016-08-01', '08:41:00', '18:24:00', '01:00:00', '08:43:00', '00:43:00', 'FID', 'Deploy', '2016-08-19 08:41:31'),
(90, '95944', '2016-08-02', '09:15:00', '21:06:00', '01:00:00', '10:51:00', '02:51:00', 'TMMIN', 'Deploy', '2016-08-19 08:42:46'),
(91, '95944', '2016-08-19', '08:00:00', '17:00:00', '01:00:00', '08:00:00', '00:00:00', 'FID', 'Bug Fix', '2016-08-19 09:01:24'),
(108, '95811', '2016-08-24', '08:47:00', '18:50:00', '01:00:00', '09:03:00', '01:03:00', 'aaaaaaaaaassssssssssddddddddddffffffffffgggggggggghhhhhhhhhhjjjjjjjjjjkkkkkkkkkklllllllllloooooooooo', 'aaaaaaaaaassssssssssddddddddddffffffffffgggggggggghhhhhhhhhhjjjjjjjjjjkkkkkkkkkklllllllllloooooooooo', '2016-08-25 07:31:51');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `login_id` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `join_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `pm_leader` varchar(50) NOT NULL,
  `skill` varchar(50) NOT NULL,
  `level` varchar(50) NOT NULL,
  `start_peroid_po` date NOT NULL,
  `end_period_po` date NOT NULL,
  `wbs` varchar(50) NOT NULL,
  `remark` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `device_token` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `company_name`, `login_id`, `password`, `role`, `position`, `join_date`, `end_date`, `status`, `pm_leader`, `skill`, `level`, `start_peroid_po`, `end_period_po`, `wbs`, `remark`, `token`, `device_token`) VALUES
('99999', 'Gylfi', 'FID', '99999', 'fid123', '', 'SA', '2016-08-24', '2016-08-24', 1, '', '', '', '2016-08-24', '2016-08-24', '', '', 'fb32619d7dcb219adb1ef2620e8c0cab', 'f-_enlrYFIc:APA91bHSuqfioqvKq98aI5zDkOrf7pW8wZf89yEvENgQvetqOwvVjCsOzy8HQxKdFrgRBylcLnafaskI2DLkOozeyU5XYUGQMfh9STtrP9z-uDBGtQRpfM8ftv86hA3RQzc2eJtn703L'),
('77777', 'Sigurdsson', 'FID', '77777', 'fid123', '', 'SA', '2016-08-24', '2016-08-24', 1, '', '', '', '2016-08-24', '2016-08-24', '', '', 'c9e9dc645daa94f1082ebcfd8250a3de', 'et7SHrFL6Nw:APA91bFnSIHjxemvobDdp-jBDHwPlLejniWM1SDYk_rmLxv1RaZhC-yLMIcPd7vJxY2dgpEdtGuucirnZz_2OePIinuG3AVe24ycJbqRtNTk5SMF8aUEPiHXucWEywBKsyxcATbyNgfK'),
('95925', 'Witan', 'FID', '95925', 'fid123', '', 'position', '2015-12-08', '2016-10-07', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '1e67c03fcbe149f5d6ecff5b1b086342', 'et7SHrFL6Nw:APA91bFnSIHjxemvobDdp-jBDHwPlLejniWM1SDYk_rmLxv1RaZhC-yLMIcPd7vJxY2dgpEdtGuucirnZz_2OePIinuG3AVe24ycJbqRtNTk5SMF8aUEPiHXucWEywBKsyxcATbyNgfK'),
('95922', 'Choliq Effan', 'TMMIN', '95922', 'fid123', '', 'position', '2015-12-01', '2016-09-30', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95915', 'Mia Rahmi Pratiwi', 'FID', '95915', 'fid123', '', 'position', '2015-11-01', '2016-08-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95913', 'Apriani Kartika', 'FID', '95913', 'fid123', '', 'position', '2015-10-28', '2016-08-27', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '97e64d3ab5d66857080d1058bc4e147a', 'e6oLb6Tt7ug:APA91bHIWpM2_MLIzKGBcn1QUmjkSDPyF1Mm7WSFieq-KZokp7bXDE1QylmkUjBxCOEX2G8ao1BWxjN_r36eYZBewsxpErElGYOmS5_Xqa3AjhFu5dLy855Uk0uHJNSVXT-s5NGQcxoN'),
('95911', 'Anita Sari', 'FID', '95911', 'fid123', '', 'position', '2015-10-22', '2016-10-21', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '76e8c7d73914080149e87c3072823c6f', ''),
('95906', 'Tois Andrean', 'TAM', '95906', 'fid123', '', 'position', '2015-10-09', '2017-01-08', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '7d4eaa0ba2f430118b11a7e9215d746c', 'et7SHrFL6Nw:APA91bFnSIHjxemvobDdp-jBDHwPlLejniWM1SDYk_rmLxv1RaZhC-yLMIcPd7vJxY2dgpEdtGuucirnZz_2OePIinuG3AVe24ycJbqRtNTk5SMF8aUEPiHXucWEywBKsyxcATbyNgfK'),
('95901', 'Indra Buana Aji', 'FID', '95901', 'fid123', '', 'position', '2015-10-05', '2016-10-04', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95898', 'Dina Ramadhani', 'FID', '95898', 'fid123', '', 'position', '2015-10-02', '2016-09-01', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '4908a873e0db8237eef7415eb561ce0f', 'et7SHrFL6Nw:APA91bFnSIHjxemvobDdp-jBDHwPlLejniWM1SDYk_rmLxv1RaZhC-yLMIcPd7vJxY2dgpEdtGuucirnZz_2OePIinuG3AVe24ycJbqRtNTk5SMF8aUEPiHXucWEywBKsyxcATbyNgfK'),
('95896', 'Amal Hamzah', 'BSI', '95896', 'fid123', '', 'position', '2015-10-01', '2016-08-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '113f612e185e7620e205ab019317b311', 'et7SHrFL6Nw:APA91bFnSIHjxemvobDdp-jBDHwPlLejniWM1SDYk_rmLxv1RaZhC-yLMIcPd7vJxY2dgpEdtGuucirnZz_2OePIinuG3AVe24ycJbqRtNTk5SMF8aUEPiHXucWEywBKsyxcATbyNgfK'),
('95893', 'Nikita Yuka Risatriana', 'TMMIN', '95893', 'fid123', '', 'position', '2015-10-01', '2016-08-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '8905a0eec17cb26af7a30af4ab5eb30f', 'et7SHrFL6Nw:APA91bFnSIHjxemvobDdp-jBDHwPlLejniWM1SDYk_rmLxv1RaZhC-yLMIcPd7vJxY2dgpEdtGuucirnZz_2OePIinuG3AVe24ycJbqRtNTk5SMF8aUEPiHXucWEywBKsyxcATbyNgfK'),
('95892', 'Muhammad Arrod', 'FID', '95892', 'fid123', '', 'position', '2015-09-23', '2016-09-22', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '95eed92b86dbd3b852574787a581c156', 'et7SHrFL6Nw:APA91bFnSIHjxemvobDdp-jBDHwPlLejniWM1SDYk_rmLxv1RaZhC-yLMIcPd7vJxY2dgpEdtGuucirnZz_2OePIinuG3AVe24ycJbqRtNTk5SMF8aUEPiHXucWEywBKsyxcATbyNgfK'),
('95877', 'Fahrul Irianto', 'FID', '95877', 'fid123', '', 'position', '2015-07-03', '2016-09-02', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '1614e76ff14548091c1d9a9c2a421def', 'et7SHrFL6Nw:APA91bFnSIHjxemvobDdp-jBDHwPlLejniWM1SDYk_rmLxv1RaZhC-yLMIcPd7vJxY2dgpEdtGuucirnZz_2OePIinuG3AVe24ycJbqRtNTk5SMF8aUEPiHXucWEywBKsyxcATbyNgfK'),
('95856', 'Alex Sandro', 'BBF', '95856', 'fid123', '', 'position', '0000-00-00', '0000-00-00', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95854', 'Asep Irawan', 'FID', '95854', 'fid123', '', 'position', '2015-04-20', '2016-09-19', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95848', 'Yayan Prahardian', 'FID', '95848', 'fid123', '', 'position', '2015-10-09', '2016-09-08', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95844', 'Arri Kurniawan', 'FID', '95844', 'fid123', '', 'position', '2015-04-01', '2016-08-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95838', 'Faisal Amir', 'MBF', '95838', 'fid123', '', 'position', '0000-00-00', '0000-00-00', 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95833', 'Riyanto Mulyo (BSP)', 'FID', '95833', 'fid123', '', 'position', '2015-07-01', '2016-09-30', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95824', 'Nurochim', 'MBF', '95824', 'fid123', '', 'position', '0000-00-00', '0000-00-00', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95815', 'Bahruddin Yusuf', 'FID', '95815', 'fid123', '', 'position', '2015-01-01', '2016-09-30', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95813', 'Deny', 'TMMIN', '95813', 'fid123', 'lkjlkjl', 'position', '2015-01-05', '2016-10-04', 1, 'lkjljlkj', 'kjlkjlk', 'lksdjlkjl', '0000-00-00', '0000-00-00', 'lkjlkjlk', 'lkjlkjlkj', '', ''),
('95811', 'Deny Rachmat Ginanjar', 'MBF', '95811', 'fid123!!', '', 'position', '0000-00-00', '0000-00-00', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '31c673f4aa248a63c7c138ec9da1f257', 'et7SHrFL6Nw:APA91bFnSIHjxemvobDdp-jBDHwPlLejniWM1SDYk_rmLxv1RaZhC-yLMIcPd7vJxY2dgpEdtGuucirnZz_2OePIinuG3AVe24ycJbqRtNTk5SMF8aUEPiHXucWEywBKsyxcATbyNgfK'),
('95809', 'Supri Santoso', 'FID', '95809', 'fid123', '', 'position', '2015-01-01', '2016-12-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95808', 'Kevin Andikaputra', 'TMMIN', '95808', 'fid123', '', 'position', '2015-01-05', '2017-01-04', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95796', 'Sayidiman', 'FID', '95796', 'fid123', '', 'position', '2015-10-01', '2016-12-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95774', 'Iskandar Zulkarnaen', 'TMMIN', '95774', 'fid123', '', 'position', '2014-09-23', '2016-08-22', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95771', 'Suci Nurani Satria', 'FID', '95771', 'fid123', '', 'position', '2015-07-06', '2016-09-05', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95756', 'Intan Puspitasari', 'TMMIN', '95756', 'fid123', '', 'position', '2014-08-19', '2016-08-18', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95754', 'Asvian Rizalahmad', 'FID', '95754', 'fid123', '', 'position', '2015-12-08', '2016-08-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95746', 'Chandra Yudhatama', 'MBF', '95746', 'fid123', '', 'position', '0000-00-00', '0000-00-00', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95700', 'Yusuf Yadi', 'FID', '95700', 'fid123', '', 'position', '2015-12-08', '2016-09-07', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95689', 'Reyza Yusdiansyah', 'FID', '95689', 'fid123', '', 'position', '2014-06-06', '2016-09-05', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95684', 'Margareta Amelia Kasiman', 'FID', '95684', 'fid123', '', 'position', '2014-06-03', '2016-10-02', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95672', 'Henry Debrian Saputra', 'BTMU', '95672', 'fid123', '', 'position', '0000-00-00', '2016-09-30', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95643', 'Suwandi (Manager)', 'MBF', '95643', 'fid123', '', 'position', '0000-00-00', '0000-00-00', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95633', 'Hilmy Arlanosa', 'BTMU', '95633', 'fid123', '', 'position', '0000-00-00', '2016-10-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95626', 'Hariri', 'BTMU', '95626', 'fid123', '', 'position', '0000-00-00', '2017-03-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95615', 'Erikson', 'BTMU', '95615', 'fid123', '', 'position', '0000-00-00', '2017-03-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95614', 'Budi Abianto', 'BTMU', '95614', 'fid123', '', 'position', '0000-00-00', '2017-03-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95613', 'Yosiakarta', 'BTMU', '95613', 'fid123', '', 'position', '0000-00-00', '2017-03-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95612', 'Mario Hendryonald', 'BTMU', '95612', 'fid123', '', 'position', '0000-00-00', '2017-03-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95601', 'Jumadi', 'MBF', '95601', 'fid123', '', 'position', '0000-00-00', '0000-00-00', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95594', 'Aulia Paraulin', 'MBF', '95594', 'fid123', '', 'position', '0000-00-00', '0000-00-00', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95551', 'Goldy Adiguna', 'TMMIN', '95551', 'fid123', '', 'position', '0000-00-00', '0000-00-00', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95529', 'Akhmad Nuryanto', 'TMMIN', '95529', 'fid123', '', 'position', '0000-00-00', '0000-00-00', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95927', 'Hadid Mubarak', 'TAM', '95927', 'fid123', '', 'position', '2015-12-21', '2016-10-20', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95928', 'Kartika Dewi', 'FID', '95928', 'fid123', '', 'position', '2015-12-21', '2016-08-20', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95930', 'Dhaifina Aulia', 'FID', '95930', 'fid123', '', 'position', '2016-01-08', '2016-09-07', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95942', 'Feranita Dwi Pangesti', 'TMMIN', '95942', 'fid123', '', 'position', '2016-06-10', '2016-09-09', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '0a5b447f7360d2bb3360d22c4b2440bc', ''),
('95944', 'Ahmad Fadel Khairi ', 'FID', '95944', 'fid123', '', 'position', '2016-02-17', '2016-09-16', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', 'db632b5774a0faf777ec97f44e51aa07', 'cGAbSxnlaW8:APA91bGxnqgLpLVIE0Bz0I86KCfvshlmdG7mU7iMM2kd4UJjP7H1NdUj6DcZHvCJB4-2rQgRhi6uWLmhoqDqIDXE2QnywoO5wT6lUHWp2U2CQS1FWzUXps7Yz5lML3hAu3nPXXpt_S0O'),
('95945', 'Robi Alisandi', 'FID', '95945', 'fid123', '', 'position', '2016-02-17', '2016-09-16', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95949', 'Yose', 'KAI', '95949', 'fid123', '', 'position', '2016-03-30', '2016-09-29', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95950', 'Mugi Prabowo', 'FID', '95950', 'password', '', 'position', '2016-04-18', '2016-09-17', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95951', 'Fransisco Sitompul', 'FID', '95951', 'fid123', '', 'position', '2016-04-19', '2016-09-18', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '765b4a43723e16209069282b55231607', 'cGAbSxnlaW8:APA91bGxnqgLpLVIE0Bz0I86KCfvshlmdG7mU7iMM2kd4UJjP7H1NdUj6DcZHvCJB4-2rQgRhi6uWLmhoqDqIDXE2QnywoO5wT6lUHWp2U2CQS1FWzUXps7Yz5lML3hAu3nPXXpt_S0O'),
('95953', 'Ritman Sigit', 'FID', '95953', 'fid123', '', 'position', '2016-05-09', '2016-10-08', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95958', 'Hermansyah', 'TAM', '95958', 'fid123', '', 'position', '2016-07-01', '2016-12-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95959', 'Agus Sulaeman', 'TAM', '95959', 'fid123', '', 'position', '2016-07-01', '2016-12-31', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95960', 'Fina Dewantari', 'FID', '95960', 'fid123', '', 'position', '2016-07-11', '2016-09-10', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95961', 'Bagus Al Qodri', 'FID', '95961', 'fid123', '', 'position', '2016-07-11', '2016-09-10', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95962', 'Ade Astriani', 'FID', '95962', 'fid123', '', 'position', '2016-07-11', '2016-09-10', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95963', 'Dinar Hartanto', 'FID', '95963', 'fid123', '', 'position', '2016-07-11', '2016-08-10', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95965', 'Asrul Syam', 'TAM', '95965', 'fid123', '', 'position', '2016-07-21', '2016-10-20', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95966', 'Ginanjar', 'TAM', '95966', 'fid123', '', 'position', '2016-07-21', '2016-10-20', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95967', 'Indra Arif Ramadhan', 'TAM', '95967', 'fid123', '', 'position', '2016-07-21', '2016-10-20', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95968', 'Nirwan Nursabda', 'TAM', '95968', 'fid123', '', 'position', '2016-07-21', '2016-10-20', 1, '', '', '', '0000-00-00', '0000-00-00', '', '', '', ''),
('95973', 'M. Irfan Zidni', 'TAM', '95973', 'fid123', ' ', 'Position', '2016-08-15', '2017-01-14', 1, ' ', ' ', ' ', '2016-08-15', '2016-08-15', ' ', ' ', '', ''),
('95975', 'Muhamad Aldy Fauzy', 'TAM', '95975', 'fid123', ' ', 'Position', '2016-08-15', '2016-11-14', 1, ' ', ' ', ' ', '2016-08-15', '2016-08-15', ' ', ' ', '', ''),
('95974', 'Muhamad Fachrein Rachim', 'TAM', '95974', 'fid123', ' ', 'Position', '2016-08-15', '2016-11-14', 1, ' ', ' ', ' ', '2016-08-15', '2016-08-15', ' ', ' ', '', ''),
('95972', 'Randi Agithia', 'TAM', '95972', 'fid123', '', 'Position', '2016-08-15', '2017-12-14', 1, '', '', '', '2016-08-15', '2016-08-15', '', '', '', ''),
('95879', 'Dian Andriani Safitri', '-', '95879', 'fid123', '', 'Position', '2016-08-18', '2016-11-17', 1, '', '', '', '2016-08-16', '2016-08-16', '', '', '', ''),
('95869', 'Rimbawangi Kartika Putri', 'Fujitsu Indonesia', '95869', 'fid123as', '', 'Admin Support', '2016-08-18', '2016-08-18', 1, '', '', '', '2016-08-18', '2016-08-18', '', '', '', ''),
('jbj', 'snd', 'n ', '99991', 'kjndsj', '', 'n ', '2016-08-24', '2016-08-24', 1, '', '', '', '2016-08-24', '2016-08-24', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `month_attended`
--

CREATE TABLE IF NOT EXISTS `month_attended` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `wo_number` varchar(100) NOT NULL,
  `attended` int(3) NOT NULL,
  `overtime` int(10) NOT NULL,
  `totaltime` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `month_attended`
--

INSERT INTO `month_attended` (`id`, `employee_id`, `timestamp`, `date`, `customer_name`, `project_name`, `wo_number`, `attended`, `overtime`, `totaltime`) VALUES
(25, '95893', '2016-08-24 08:02:34', '2016-08-01', '', '', '', 1, 0, 28800),
(24, '95896', '2016-08-24 08:00:34', '2016-08-01', '', '', '', 1, 0, 28800),
(23, '95898', '2016-08-24 07:59:34', '2016-08-01', '', '', '', 1, 0, 28800),
(22, '95906', '2016-08-24 07:58:11', '2016-08-01', '', '', '', 1, 0, 28800),
(21, '99999', '2016-08-24 07:57:14', '2016-08-01', '', '', '', 1, 0, 28800),
(20, '95811', '2016-08-24 07:05:58', '2016-07-01', '', '', '', 1, 0, 28800),
(19, '95811', '2016-08-24 07:03:00', '2017-01-01', '', '', '', 1, 4500, 33300),
(18, '95811', '2016-08-25 07:31:51', '2016-08-01', 'MBF', 'Fintegrity', '12345678', 3, 15480, 101880),
(10, '95942', '2016-08-11 03:07:39', '2016-07-01', '', '', '', 13, 84900, 459300),
(11, '95911', '2016-08-11 04:09:44', '2016-08-01', '', '', '', 2, 9000, 66600),
(17, '95925', '2016-08-23 07:18:08', '2016-08-01', '', '', '', 0, 0, 0),
(13, '95944', '2016-08-19 08:27:28', '2016-05-01', '', '', '', 2, 10920, 68520),
(14, '95944', '2016-08-19 08:36:42', '2016-06-01', '', '', '', 2, 0, 57600),
(15, '95944', '2016-08-19 08:38:51', '2016-07-01', '', '', '', 1, 3420, 32220),
(16, '95944', '2016-08-19 09:01:24', '2016-08-01', '', '', '', 3, 12840, 99240),
(26, '95892', '2016-08-24 08:06:36', '2016-08-01', '', '', '', 1, 0, 28800),
(27, '95877', '2016-08-24 08:07:19', '2016-08-01', '', '', '', 1, 0, 28800);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `title`, `content`, `timestamp`) VALUES
(1, 'Pemberitahuan Absensi', 'Dihimbau untuk seluruh karyawan untuk mengisikan absensi pada bulan Agustus\r\nTerimakasih', '2016-08-15 03:30:34');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
