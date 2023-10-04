-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2023 at 12:28 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `photo` varchar(45) DEFAULT NULL,
  `created_on` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`, `type`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Juan', 'Delacruz', 'demo/b6.jpg', 'August 31, 2019', 'Administrator'),
(2, 'humanresources', '81dc9bdb52d04dc20036dbd8313ed055', 'Cardo', 'Dalisay', 'demo/b6.jpg', 'August 31, 2019', 'Human Resources'),
(3, 'teamleader', '81dc9bdb52d04dc20036dbd8313ed055', 'Tito', 'Sotto', 'demo/b6.jpg', 'August 31, 2019', 'Team Leader');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `attendance_id` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `time_in_morning` varchar(45) DEFAULT NULL,
  `time_out_morning` varchar(45) DEFAULT NULL,
  `time_in_afternoon` varchar(45) DEFAULT NULL,
  `time_out_afternoon` varchar(45) DEFAULT NULL,
  `time_in_graveyard` varchar(45) DEFAULT NULL,
  `time_out_graveyard` varchar(45) DEFAULT NULL,
  `status_morning` int(11) DEFAULT NULL,
  `status_afternoon` int(11) DEFAULT NULL,
  `status_graveyard` int(11) DEFAULT NULL,
  `num_hr_morning` double DEFAULT NULL,
  `num_hr_afternoon` double DEFAULT NULL,
  `num_hr_graveyard` double DEFAULT NULL,
  `month` varchar(45) DEFAULT NULL,
  `year` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `attendance_id`, `date`, `time_in_morning`, `time_out_morning`, `time_in_afternoon`, `time_out_afternoon`, `time_in_graveyard`, `time_out_graveyard`, `status_morning`, `status_afternoon`, `status_graveyard`, `num_hr_morning`, `num_hr_afternoon`, `num_hr_graveyard`, `month`, `year`) VALUES
(4, 2, '5103246', '2023-09-20', '09:30:00', '09:44:43', NULL, '09:51:44', NULL, '09:58:57', 0, NULL, NULL, 0.23333333333333, 0, NULL, 'September', '2023'),
(5, 3, '5640321', '2023-09-20', '09:41:02', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'September', '2023'),
(16, 7, '3205146', '2023-09-25', '06:00:15', '17:08:26', NULL, NULL, NULL, NULL, 0, NULL, NULL, 8, NULL, NULL, 'September', '2023'),
(17, 7, '0146235', '2023-09-28', '06:00:51', '18:05:47', NULL, NULL, NULL, NULL, 0, NULL, NULL, 8, NULL, NULL, 'September', '2023'),
(21, 2, '5063214', '2023-09-28', NULL, NULL, '13:59:39', '00:11:57', NULL, NULL, NULL, 1, NULL, NULL, 12.783333333333, NULL, 'September', '2023'),
(22, 3, '6514203', '2023-09-28', NULL, NULL, NULL, NULL, '21:59:18', '09:06:27', NULL, NULL, 1, NULL, NULL, NULL, 'September', '2023'),
(29, 2, '2310564', '2023-10-02', NULL, NULL, '14:05:13', '02:05:32', NULL, NULL, NULL, 0, NULL, NULL, 8, NULL, 'October', '2023'),
(30, 8, '5426301', '2023-10-03', NULL, NULL, NULL, NULL, '21:59:40', '09:00:02', NULL, NULL, 1, NULL, NULL, 8, 'October', '2023'),
(31, 3, '6315402', '2023-10-03', NULL, NULL, NULL, NULL, '22:00:31', NULL, NULL, NULL, 0, NULL, NULL, NULL, 'October', '2023'),
(32, 2, '2406153', '2023-10-03', NULL, NULL, '22:59:28', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 'October', '2023'),
(33, 7, '1025643', '2023-10-04', '05:59:56', '16:00:12', NULL, NULL, NULL, NULL, 1, NULL, NULL, 8, NULL, NULL, 'October', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `barcode`
--

CREATE TABLE `barcode` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(45) DEFAULT NULL,
  `generated_on` varchar(45) DEFAULT NULL,
  `path` varchar(45) DEFAULT NULL,
  `bool_gen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `barcode`
--

INSERT INTO `barcode` (`id`, `employee_id`, `generated_on`, `path`, `bool_gen`) VALUES
(1, '659218403', '2023-09-17', 'employee_barcode/659218403.png', 1),
(2, '057481236', '2023-09-17', 'employee_barcode/057481236.png', 1),
(3, '158369407', '2023-09-17', 'employee_barcode/158369407.png', 1),
(4, '409257836', '2023-09-17', 'employee_barcode/409257836.png', 1),
(5, '627513480', '2023-09-17', 'employee_barcode/627513480.png', 1),
(6, '634587910', '2023-09-24', 'employee_barcode/634587910.png', 1),
(7, '892063751', '2023-10-01', 'employee_barcode/892063751.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int(11) NOT NULL,
  `cash_id` varchar(45) DEFAULT NULL,
  `date_advance` varchar(45) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `attained` varchar(45) DEFAULT NULL,
  `year_graduated` varchar(45) DEFAULT NULL,
  `eid` varchar(45) DEFAULT NULL,
  `degree_received` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(45) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `created_on` varchar(45) DEFAULT NULL,
  `photo` longtext DEFAULT NULL,
  `fullname` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phonenumber` varchar(45) DEFAULT NULL,
  `birthdate` varchar(45) DEFAULT NULL,
  `sex` varchar(45) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `civil_status` varchar(45) DEFAULT NULL,
  `citizenship` varchar(45) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `religion` varchar(45) DEFAULT NULL,
  `spouse` varchar(45) DEFAULT NULL,
  `spouse_occupation` varchar(45) DEFAULT NULL,
  `father` varchar(45) DEFAULT NULL,
  `father_occupation` varchar(45) DEFAULT NULL,
  `mother` varchar(45) DEFAULT NULL,
  `mother_occupation` varchar(45) DEFAULT NULL,
  `parent_address` varchar(45) DEFAULT NULL,
  `emergency_name` varchar(45) DEFAULT NULL,
  `emergency_contact` varchar(45) DEFAULT NULL,
  `project_name` varchar(45) DEFAULT NULL,
  `site_location` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `position_id`, `schedule_id`, `created_on`, `photo`, `fullname`, `address`, `email`, `phonenumber`, `birthdate`, `sex`, `position`, `civil_status`, `citizenship`, `height`, `weight`, `religion`, `spouse`, `spouse_occupation`, `father`, `father_occupation`, `mother`, `mother_occupation`, `parent_address`, `emergency_name`, `emergency_contact`, `project_name`, `site_location`) VALUES
(2, '158369407', 2, 28, '2023-09-17', 'images.jpg', 'Mercedes A. Gil', '23A/22 Zieme Squares Suite 794, San Narciso 9', 'candace57@lakin.biz', '09451516516', '1984-04-09', 'Female', '2', 'Married', 'FIlipino', 155, 68, 'Catholic', 'Cristian Alvarez', 'Janitor', 'Eduardo Cabrera', 'Chef', 'Emilio Ferrer', 'House Keeping', '60A/86 Terry Green Suite 342, Poblacion, Munt', 'Emilio Ferrer', '09881516161', NULL, NULL),
(3, '057481236', 3, 29, '2023-09-17', 'download.png', 'Rocío  G. Jimenez', '18 Kassulke Route Suite 640, Carcar City 1330', 'haven.schmidt@yahoo.com', '09416161651', '1986-04-13', 'Female', '3', 'Separated', 'Filipino', 165, 65, 'Born Again', 'Alberto Gallardo', 'Boxer', 'Ruben Garrido', 'Captain', 'Manuel Suarez', 'Chef', '83A Roberts Neck Suite 333, Poblacion, Trece ', 'Manuel Suarez', '09516516165', NULL, NULL),
(7, '634587910', 3, 27, '2023-09-24', 'Max-R_Headshot (1).jpg', 'Test Test Test', 'Ttset', 'tset@test', '4234324', '1975-03-02', 'Male', '3', 'Single', 'Etst', 3423, 42423, 'Fafdsf', 'Fsdfsd', 'Fsdfsd', 'Fsdfsd', 'Fsdfsfsf', 'Sdfdsf', 'Sdfsdf', 'Sdfdsf', 'Fsdfs', '14134132423', NULL, NULL),
(8, '892063751', 1, 29, '2023-10-02', 'Max-R_Headshot (1).jpg', 'Cvbcvbcvb Cbcvbcv Bcvbcvbcb', 'Bcbcvbcv', 'bvcbcv@cvbcvb', '24324243432', '2018-02-03', 'Male', '1', 'Single', 'Xcvxvxcv', 423423, 4234234, 'Xcvxc', 'Vxcvcxv', 'Cxvcvx', 'Vcxvxv', 'Xcvxv', 'Xvcxvcx', 'Vxcvcxv', 'Xvxcv', 'Xcvcxvxcv', '234324234', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_acct`
--

CREATE TABLE `employee_acct` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `photo` varchar(45) DEFAULT NULL,
  `created_on` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `userid` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave`
--

CREATE TABLE `employee_leave` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date_of_leave` varchar(45) DEFAULT NULL,
  `days_of_leave` varchar(45) DEFAULT NULL,
  `reason_for_leave` longtext DEFAULT NULL,
  `leave_status` varchar(45) DEFAULT NULL,
  `date_filed` varchar(45) DEFAULT NULL,
  `type_of_leave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE `overtime` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `overtime_id` varchar(45) DEFAULT NULL,
  `hours` double DEFAULT NULL,
  `rate_hour` double DEFAULT NULL,
  `date_overtime` varchar(45) DEFAULT NULL,
  `ot_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `position_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `description`, `rate`, `position_id`) VALUES
(1, 'Operation Manager', 700, '950647812'),
(2, 'Team Leader', 650, '927435106'),
(3, 'Consultant', 750, '249063581');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `schedule_id` varchar(45) DEFAULT NULL,
  `time_in_morning` varchar(45) DEFAULT NULL,
  `time_out_morning` varchar(45) DEFAULT NULL,
  `time_in_afternoon` varchar(45) DEFAULT NULL,
  `time_out_afternoon` varchar(45) DEFAULT NULL,
  `time_in_graveyard` varchar(45) DEFAULT NULL,
  `time_out_graveyard` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `schedule_id`, `time_in_morning`, `time_out_morning`, `time_in_afternoon`, `time_out_afternoon`, `time_in_graveyard`, `time_out_graveyard`) VALUES
(27, '4325107', '06:00:00', '15:00:00', NULL, NULL, NULL, NULL),
(28, '4325108', NULL, NULL, '14:00:00', '23:00:00', NULL, NULL),
(29, '4325109', NULL, NULL, NULL, NULL, '22:00:00', '07:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barcode`
--
ALTER TABLE `barcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_acct`
--
ALTER TABLE `employee_acct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_leave`
--
ALTER TABLE `employee_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `barcode`
--
ALTER TABLE `barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employee_acct`
--
ALTER TABLE `employee_acct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_leave`
--
ALTER TABLE `employee_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
