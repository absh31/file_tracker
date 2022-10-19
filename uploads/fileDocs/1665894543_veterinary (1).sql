-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2022 at 01:45 PM
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
-- Database: `veterinary`
--

-- --------------------------------------------------------

--
-- Table structure for table `dist_details`
--

CREATE TABLE `dist_details` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'unique id',
  `dist_name` varchar(50) NOT NULL COMMENT 'name of district',
  `dist_lat` varchar(10) NOT NULL COMMENT 'latitude of district',
  `dist_lon` varchar(10) NOT NULL COMMENT 'longitude of district',
  `zone` varchar(10) DEFAULT NULL COMMENT 'zone of a district',
  `dist_state` int(10) UNSIGNED NOT NULL COMMENT 'state of district',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'active or not'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dist_details`
--

INSERT INTO `dist_details` (`id`, `dist_name`, `dist_lat`, `dist_lon`, `zone`, `dist_state`, `is_active`) VALUES
(50, 'Ahmedabad', '23.0225', '72.5714', 'Red', 1, 1),
(51, 'Surat', '21.1702', '72.8311', 'Orange', 1, 1),
(52, 'Vadodara', '22.3042', '73.1559', 'Red', 1, 1),
(53, 'Rajkot', '22.2970', '70.7979', 'Orange', 1, 1),
(54, 'Bhavnagar', '21.7688', '72.1511', 'Red', 1, 1),
(55, 'Jamnagar', '22.4940', '70.0330', 'Orange', 1, 1),
(56, 'Gir Somnath', '21.5232', '70.4506', 'Orange', 1, 1),
(57, 'Anand', '22.5525', '72.9430', 'Red', 1, 1),
(58, 'Navsari', '20.9488', '72.9400', 'Orange', 1, 1),
(59, 'Surendranagar', '22.7296', '71.6354', 'Orange', 1, 1),
(60, 'Aravalli', '23.5205', '73.3709', 'Red', 1, 1),
(61, 'Banaskantha', '24.3455', '71.7622', 'Red', 1, 1),
(62, 'Bharuch', '21.7051', '72.9959', 'Orange', 1, 1),
(63, 'Botad', '22.1723', '71.6636', 'Orange', 1, 1),
(64, 'Chhota Udaipur', '22.3085', '74.0120', 'Orange', 1, 1),
(65, 'Devbhumi Dwarka', '22.1232', '69.3831', 'Green', 1, 1),
(66, 'Dahod', '22.8345', '74.2606', 'Orange', 1, 1),
(67, 'Gandhinagar', '23.2156', '72.6369', 'Red', 1, 1),
(68, 'Kutch', '23.733', '69.8597', 'Orange', 1, 1),
(69, 'Kheda', '22.9251', '72.9933', 'Orange', 1, 1),
(70, 'Mehsana', '23.5880', '72.3693', 'Orange', 1, 1),
(71, 'Mahisagar', '23.1711', '73.5594', 'Orange', 1, 1),
(72, 'Morbi', '22.8252', '70.8491', 'Green', 1, 1),
(73, 'Narmada', '21.8757', '73.5594', 'Orange', 1, 1),
(74, 'Panchmahal', '22.8011', '73.5594', 'Red', 1, 1),
(75, 'Patan', '23.8500', '72.1210', 'Orange', 1, 1),
(76, 'Porbandar', '21.6417', '69.6293', 'Green', 1, 1),
(77, 'Sabarkantha', '23.8477', '72.9933', 'Orange', 1, 1),
(78, 'Tapi', '21.2789', '73.6065', 'Orange', 1, 1),
(79, 'Dang', '20.8254', '73.7007', 'Orange', 1, 1),
(80, 'Valsad', '20.5992', '72.9342', 'Orange', 1, 1),
(81, 'Amreli', '21.6015', '71.2204', 'Green', 1, 1),
(82, 'Junagadh', '21.5222', '70.4579', 'Green', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `charge_name` varchar(256) NOT NULL,
  `designation` varchar(128) NOT NULL,
  `address` varchar(128) NOT NULL,
  `mobile_number` varchar(10) NOT NULL,
  `email` varchar(128) NOT NULL,
  `geofence_id` varchar(128) DEFAULT NULL,
  `remarks` varchar(256) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `charge_name`, `designation`, `address`, `mobile_number`, `email`, `geofence_id`, `remarks`, `is_active`) VALUES
(1, 'Dharmit Shah', 'Vet - 1_Bhuj', 'DVM', 'Bhuj', '7228967551', 'dharmit.shah2001@gmail.com', '1', '', 1),
(3, 'Mihir', 'Vet - 2_Bhuj', 'DVM', 'ahmedabda', '9327191260', 'mihirsomeshwara0712@gmail.com', '2', '', 1),
(4, 'Abhi', 'Vet - 3_Bhuj', 'DVM', 'Ahmedabad', '7896543210', 'abhishah3102@gmail.com', '3', '', 1),
(5, 'Bhavika Balasra', 'Vet - 1_Anjar', 'DVM', 'Ahmedabad', '7896543210', 'mail@mail.com', '4', '', 1),
(6, 'Diti Soni', 'Vet - 2_Anjar', 'DVM', 'Ahmedabad', '9876543210', 'mail@mail.com', '5', '', 1),
(7, 'Vaishnavi Barot', '', 'DVM', 'Ahmedabad', '8989898989', 'mail@mail.com', NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `geofencing_details`
--

CREATE TABLE `geofencing_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `charge_name` varchar(256) NOT NULL,
  `taluka_name` varchar(200) NOT NULL,
  `area_pincode` int(6) NOT NULL,
  `geofencing_area` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'lat long array, prefer that you like',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` text NOT NULL,
  `is_assigned` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `geofencing_details`
--

INSERT INTO `geofencing_details` (`id`, `charge_name`, `taluka_name`, `area_pincode`, `geofencing_area`, `date`, `remarks`, `is_assigned`, `is_active`) VALUES
(1, 'Vet - 1_Bhuj', 'Bhuj', 0, '[{\"lat\":23.265262,\"lng\":69.695536},{\"lat\":23.269993,\"lng\":69.680858},{\"lat\":23.266681,\"lng\":69.672533},{\"lat\":23.259426,\"lng\":69.670559},{\"lat\":23.247361,\"lng\":69.673305},{\"lat\":23.241289,\"lng\":69.673992},{\"lat\":23.238371,\"lng\":69.687553},{\"lat\":23.240815,\"lng\":69.702059},{\"lat\":23.249648,\"lng\":69.699913},{\"lat\":23.260373,\"lng\":69.69811},{\"lat\":23.26471,\"lng\":69.69545}]', '2022-10-15 08:32:51', 'Remarks', 0, 1),
(2, 'Vet - 2_Bhuj', 'Bhuj', 0, '[{\"lat\":23.240789,\"lng\":69.667323},{\"lat\":23.230813,\"lng\":69.66316},{\"lat\":23.2275,\"lng\":69.675906},{\"lat\":23.237516,\"lng\":69.678653}]', '2022-10-15 09:25:07', 'Vet - 2', 0, 1),
(3, 'Vet - 3_Bhuj', 'Bhuj', 0, '[{\"lat\":23.262841,\"lng\":69.659437},{\"lat\":23.249278,\"lng\":69.642357},{\"lat\":23.237054,\"lng\":69.648108},{\"lat\":23.245887,\"lng\":69.670853},{\"lat\":23.254719,\"lng\":69.671883}]', '2022-10-15 09:26:05', 'Vet - 3', 0, 1),
(4, 'Vet - 1_Anjar', 'Anjar', 0, '[{\"lat\":23.122674,\"lng\":70.02194},{\"lat\":23.121707,\"lng\":70.019064},{\"lat\":23.11928,\"lng\":70.017734},{\"lat\":23.115313,\"lng\":70.017841},{\"lat\":23.114149,\"lng\":70.020588},{\"lat\":23.114406,\"lng\":70.026768},{\"lat\":23.116182,\"lng\":70.027583},{\"lat\":23.118372,\"lng\":70.027197},{\"lat\":23.120977,\"lng\":70.026639},{\"lat\":23.122181,\"lng\":70.024064},{\"lat\":23.122793,\"lng\":70.022669}]', '2022-10-15 09:27:20', 'Anjar Vet 1', 0, 1),
(5, 'Vet - 2_Anjar', 'Anjar', 0, '[{\"lat\":23.116412,\"lng\":70.038318},{\"lat\":23.115149,\"lng\":70.035057},{\"lat\":23.116925,\"lng\":70.029735},{\"lat\":23.114952,\"lng\":70.027632},{\"lat\":23.104097,\"lng\":70.032782},{\"lat\":23.108044,\"lng\":70.042567}]', '2022-10-15 09:28:17', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `state_details`
--

CREATE TABLE `state_details` (
  `state_id` int(10) UNSIGNED NOT NULL COMMENT 'primary key',
  `state_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'state name',
  `state_lat` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'state lattitude',
  `state_long` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'state longitude',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'is active flag'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `state_details`
--

INSERT INTO `state_details` (`state_id`, `state_name`, `state_lat`, `state_long`, `is_active`) VALUES
(1, 'Gujarat', '23.2156', '72.6369', 1);

-- --------------------------------------------------------

--
-- Table structure for table `taluka`
--

CREATE TABLE `taluka` (
  `id` int(11) NOT NULL,
  `taluka_name` varchar(256) NOT NULL,
  `latitude` varchar(256) NOT NULL,
  `longitude` varchar(256) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taluka`
--

INSERT INTO `taluka` (`id`, `taluka_name`, `latitude`, `longitude`, `is_active`) VALUES
(1, 'Abdasa', '23.25', '69', 1),
(2, 'Anjar', '23.1167', '70.0281', 1),
(3, 'Bhachau', '23.2930', '70.3390', 1),
(4, 'Bhuj', '23.2420', '69.6669', 1),
(5, 'Gandhidham', '23.0753', '70.1337', 1),
(6, 'Lakhpat', '23.8145', '68.7692', 1),
(7, 'Mandvi', '22.8333', '69.3555', 1),
(8, 'Mundra', '22.8396', '69.7241', 1),
(9, 'Nakhatrana', '23.3431', '69.2669', 1),
(10, 'Rapar', '23.5730', '70.6447', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL,
  `role_id` int(10) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `remarks` varchar(256) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `role_id`, `username`, `password`, `name`, `email`, `contact`, `remarks`, `is_active`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Dharmit Shah', 'dharmit.shah2001@gmail.com', '7228967551', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcase`
--

CREATE TABLE `tblcase` (
  `id` int(11) NOT NULL,
  `case_id` varchar(128) NOT NULL,
  `complainant_name` varchar(256) NOT NULL,
  `complainant_contact` varchar(10) NOT NULL,
  `animal_type` varchar(256) DEFAULT NULL,
  `animal_species` varchar(256) DEFAULT NULL,
  `problem` varchar(256) DEFAULT NULL,
  `latitude` varchar(256) NOT NULL,
  `longitude` varchar(256) NOT NULL,
  `photo` varchar(256) NOT NULL,
  `status` varchar(256) DEFAULT NULL,
  `doctor_auth` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcase`
--

INSERT INTO `tblcase` (`id`, `case_id`, `complainant_name`, `complainant_contact`, `animal_type`, `animal_species`, `problem`, `latitude`, `longitude`, `photo`, `status`, `doctor_auth`) VALUES
(1, '1665826188', 'Mihir', '9876543210', 'Cow', 'Malva', 'Mastitis', '23.106775', '72.59442833333334', 'IMG1462209440.jpg', 'Completed', 'Vet - 1_Bhuj'),
(2, '1665826295', 'Abhi', '9876543210', 'Cow', 'Bos taurus', 'Mastitis', '23.106775', '72.59442833333334', 'IMG1897382357.jpg', NULL, 'Vet - 1_Bhuj');

-- --------------------------------------------------------

--
-- Table structure for table `tblrole`
--

CREATE TABLE `tblrole` (
  `id` int(11) NOT NULL,
  `role_name` varchar(128) NOT NULL,
  `taluka_name` varchar(256) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblrole`
--

INSERT INTO `tblrole` (`id`, `role_name`, `taluka_name`, `is_active`) VALUES
(1, 'Vet - 1', 'Abdasa', 1),
(2, 'Vet - 2', 'Abdasa', 1),
(3, 'Vet - 1', 'Anjar', 1),
(4, 'Vet - 2', 'Anjar', 1),
(5, 'Vet - 1', 'Bhachau', 1),
(6, 'Vet - 2', 'Bhachau', 1),
(7, 'Vet - 1', 'Bhuj', 1),
(8, 'Vet - 2', 'Bhuj', 1),
(9, 'Vet - 3', 'Bhuj', 1),
(10, 'Vet - 1', 'Gandhidham', 1),
(11, 'Vet - 2', 'Gandhidham', 1),
(12, 'Vet - 3', 'Gandhidham', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbltoken`
--

CREATE TABLE `tbltoken` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `fcm_token` varchar(512) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbltoken`
--

INSERT INTO `tbltoken` (`id`, `phone_number`, `fcm_token`, `datetime`) VALUES
(1, '7228967551', 'cpw14h9fRliSnvqxmDyzmS:APA91bFm-GZ_gLMeftcVNkd12XQ7_Qf8ZUw-mXvVHj4umuNF-n5MRlRyz_R-2srU9MyXDirYBuJtJQL2CpewBF2fHqd4mXA7r8gw1vVd1PiB_0-MW6KrFbdVGDYnX-OG5QeBl1RqZ_V5', '2022-10-10 05:37:26'),
(2, '7228967551', 'feXfMC8MR9WvLY1FvhaTin:APA91bF3O5DlfElhukwW3YrcuxR5I0nOwtLvyUXfYXeSLnKDt0CcfL32xMTOfvgKhw_SzcohXAqNDzd8opC1GZfq_kTyGy-7fYXZCO5dsp67XdkZozx4AdQrW-Mt1mEdOPoNWzrvQbBp', '2022-10-15 10:52:19'),
(3, '7228967551', 'd1DfI-plRg-jcoU0c7Rvvs:APA91bE-M2vOOMM6XCPMWfg4KuSzByK09aM1BLyud2FQZJueLpVh4y7Ld5LlOVTthy9ztkplQUjCSI9q5olRG73NQTFJ0GnRoGmo-0EPyUdpbjCbi2b6Vni58F5SxtIPnO-Cx849lxY3', '2022-10-15 11:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `tblvisit`
--

CREATE TABLE `tblvisit` (
  `id` int(11) NOT NULL,
  `case_id` varchar(256) NOT NULL,
  `dateofvisit` timestamp NOT NULL DEFAULT current_timestamp(),
  `condition_now` varchar(256) NOT NULL,
  `treatment` varchar(256) NOT NULL,
  `dose` varchar(256) NOT NULL,
  `latitude` varchar(256) NOT NULL,
  `longitude` varchar(256) NOT NULL,
  `photo` varchar(256) NOT NULL,
  `next_visit_date` varchar(256) DEFAULT NULL,
  `remarks` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblvisit`
--

INSERT INTO `tblvisit` (`id`, `case_id`, `dateofvisit`, `condition_now`, `treatment`, `dose`, `latitude`, `longitude`, `photo`, `next_visit_date`, `remarks`) VALUES
(1, '1665826188', '2022-10-15 09:29:48', 'Redness in Skin', 'Self Care', 'Dicloxacillin. Erythromycin\n', '23.106775', '72.59442833333334', 'IMG1462209440.jpg', NULL, ''),
(2, '1665826295', '2022-10-14 08:31:35', 'Critical Red Ness of Skin', 'Self care, regular visits', 'Dicloxacillin. Erythromycin\n', '23.106775', '72.59442833333334', 'IMG1897382357.jpg', '2022-10-15', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dist_details`
--
ALTER TABLE `dist_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dist_state` (`dist_state`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geofencing_details`
--
ALTER TABLE `geofencing_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state_details`
--
ALTER TABLE `state_details`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `taluka`
--
ALTER TABLE `taluka`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcase`
--
ALTER TABLE `tblcase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblrole`
--
ALTER TABLE `tblrole`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltoken`
--
ALTER TABLE `tbltoken`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblvisit`
--
ALTER TABLE `tblvisit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dist_details`
--
ALTER TABLE `dist_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'unique id', AUTO_INCREMENT=749;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `geofencing_details`
--
ALTER TABLE `geofencing_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `state_details`
--
ALTER TABLE `state_details`
  MODIFY `state_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'primary key', AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `taluka`
--
ALTER TABLE `taluka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcase`
--
ALTER TABLE `tblcase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblrole`
--
ALTER TABLE `tblrole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbltoken`
--
ALTER TABLE `tbltoken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblvisit`
--
ALTER TABLE `tblvisit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dist_details`
--
ALTER TABLE `dist_details`
  ADD CONSTRAINT `dist_details_ibfk_1` FOREIGN KEY (`dist_state`) REFERENCES `state_details` (`state_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
