-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2023 at 03:15 PM
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
  `site_location` varchar(45) DEFAULT NULL,
  `leave_credits` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barcode`
--
ALTER TABLE `barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
