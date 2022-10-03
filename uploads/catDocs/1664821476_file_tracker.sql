-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2022 at 06:09 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `file_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblactivity`
--

CREATE TABLE `tblactivity` (
  `activity_id` int(11) NOT NULL,
  `activity_file_track_no` varchar(200) NOT NULL,
  `activity_from` int(11) NOT NULL,
  `activity_to` int(11) NOT NULL,
  `activity_remarks` text NOT NULL,
  `activity_type` varchar(200) NOT NULL,
  `activity_ack` tinyint(1) NOT NULL,
  `activity_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbldept`
--

CREATE TABLE `tbldept` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(200) NOT NULL,
  `dept_email` varchar(200) NOT NULL,
  `dept_desc` text NOT NULL,
  `dept_active` tinyint(1) NOT NULL,
  `dept_files` int(11) NOT NULL,
  `dept_time` varchar(200) NOT NULL,
  `dept_remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbldept`
--

INSERT INTO `tbldept` (`dept_id`, `dept_name`, `dept_email`, `dept_desc`, `dept_active`, `dept_files`, `dept_time`, `dept_remarks`) VALUES
(1, 'General', '-', '-', 1, 0, '0', ''),
(2, 'test', 'abhishah3102@gmail.com', 'test', 0, 0, '', 'test'),
(3, 'test 1', 'abhishah3102@gmail.com', '', 0, 0, '', ''),
(4, 'test 2', 'abhishah3102@gmail.com', 'test', 0, 0, '', 'test 1');

-- --------------------------------------------------------

--
-- Table structure for table `tbldocument`
--

CREATE TABLE `tbldocument` (
  `document_id` int(11) NOT NULL,
  `document_file_track_no` varchar(200) NOT NULL,
  `document_title` varchar(200) NOT NULL,
  `document_path` text NOT NULL,
  `document_by` int(11) NOT NULL,
  `document_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbldocument`
--

INSERT INTO `tbldocument` (`document_id`, `document_file_track_no`, `document_title`, `document_path`, `document_by`, `document_time`) VALUES
(1, '1', 'absh', '..\\uploads\\images\\login_bg.jpg', 1, ''),
(2, '1', 'absnwdnkenmoemnoenfciowncowjmcfo', '..\\uploads\\images\\login_bg.jpg', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tblfile`
--

CREATE TABLE `tblfile` (
  `file_id` int(11) NOT NULL,
  `file_track_no` varchar(200) NOT NULL,
  `file_title` varchar(200) NOT NULL,
  `file_person_name` varchar(200) NOT NULL,
  `file_desc` text NOT NULL,
  `file_filecat_id` int(11) NOT NULL,
  `file_added_by` int(11) NOT NULL,
  `file_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_current_holder` int(11) NOT NULL,
  `file_status` varchar(200) NOT NULL,
  `file_completed` tinyint(1) NOT NULL,
  `file_complete_time` varchar(200) NOT NULL,
  `file_remarks` text NOT NULL,
  `file_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblfile`
--

INSERT INTO `tblfile` (`file_id`, `file_track_no`, `file_title`, `file_person_name`, `file_desc`, `file_filecat_id`, `file_added_by`, `file_time`, `file_current_holder`, `file_status`, `file_completed`, `file_complete_time`, `file_remarks`, `file_active`) VALUES
(3, '1', 'Test', 'Abhi', 'absh ', 1, 1, '2022-10-02 13:42:46', 1, 'Added', 0, '', '123', 1),
(4, '12', 'Test 1', 'Abhi', 'test 123456', 2, 1, '2022-10-02 13:42:46', 1, 'Added', 1, '', '4185', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblfilecat`
--

CREATE TABLE `tblfilecat` (
  `filecat_id` int(11) NOT NULL,
  `filecat_name` varchar(200) NOT NULL,
  `filecat_format` text NOT NULL,
  `filecat_doc_path` text NOT NULL,
  `filecat_remarks` text NOT NULL,
  `filecat_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblfilecat`
--

INSERT INTO `tblfilecat` (`filecat_id`, `filecat_name`, `filecat_format`, `filecat_doc_path`, `filecat_remarks`, `filecat_active`) VALUES
(1, 'test', 'abshshajkaka', '', 'qwertyuilkjhdsascvbnm,', 1),
(2, 'test 1', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblofficer`
--

CREATE TABLE `tblofficer` (
  `officer_id` int(11) NOT NULL,
  `officer_username` varchar(200) NOT NULL,
  `officer_password` varchar(200) NOT NULL,
  `officer_name` varchar(200) NOT NULL,
  `officer_mobile` varchar(200) NOT NULL,
  `officer_email` varchar(200) NOT NULL,
  `officer_role_id` int(11) NOT NULL,
  `officer_dept_id` int(11) NOT NULL,
  `officer_active` tinyint(1) NOT NULL,
  `officer_remarks` text NOT NULL,
  `officer_files` int(11) NOT NULL,
  `officer_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblofficer`
--

INSERT INTO `tblofficer` (`officer_id`, `officer_username`, `officer_password`, `officer_name`, `officer_mobile`, `officer_email`, `officer_role_id`, `officer_dept_id`, `officer_active`, `officer_remarks`, `officer_files`, `officer_time`) VALUES
(1, 'file_admin', '3f01af067880c23239203d7529f5e6bb', 'Abhi Shah', '7041308465', 'abhishah3102@gmail.com', 1, 1, 1, '', 0, ''),
(3, 'absh', 'd41d8cd98f00b204e9800998ecf8427e', 'Test', '7041308465', 'abhishah3102@gmail.com', 1, 1, 1, 'none', 0, ''),
(4, 'absh', '3f01af067880c23239203d7529f5e6bb', 'Test 1', '7041308465', 'abhishah3102@gmail.com', 1, 1, 0, '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tblrole`
--

CREATE TABLE `tblrole` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(200) NOT NULL,
  `role_priority` int(11) NOT NULL,
  `role_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblrole`
--

INSERT INTO `tblrole` (`role_id`, `role_name`, `role_priority`, `role_active`) VALUES
(1, 'Admin', 1, 1),
(2, 'test', 3, 0),
(3, 'test 1', 3, 0),
(4, 'test 3', 3, 1),
(5, 'test 2', 3, 0),
(6, 'test 2', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblactivity`
--
ALTER TABLE `tblactivity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `tbldept`
--
ALTER TABLE `tbldept`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `tbldocument`
--
ALTER TABLE `tbldocument`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `tblfile`
--
ALTER TABLE `tblfile`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `tblfilecat`
--
ALTER TABLE `tblfilecat`
  ADD PRIMARY KEY (`filecat_id`);

--
-- Indexes for table `tblofficer`
--
ALTER TABLE `tblofficer`
  ADD PRIMARY KEY (`officer_id`);

--
-- Indexes for table `tblrole`
--
ALTER TABLE `tblrole`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblactivity`
--
ALTER TABLE `tblactivity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbldept`
--
ALTER TABLE `tbldept`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbldocument`
--
ALTER TABLE `tbldocument`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblfile`
--
ALTER TABLE `tblfile`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblfilecat`
--
ALTER TABLE `tblfilecat`
  MODIFY `filecat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblofficer`
--
ALTER TABLE `tblofficer`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblrole`
--
ALTER TABLE `tblrole`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
