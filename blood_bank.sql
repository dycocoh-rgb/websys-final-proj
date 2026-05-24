-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2026 at 02:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
('ADM1', 'Mark', 'adminpass1'),
('ADM2', 'Kiro', 'adminpass2'),
('ADM3', 'Cydrex', 'adminpass3');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` varchar(10) NOT NULL,
  `donor_id` varchar(10) NOT NULL,
  `event_id` varchar(10) NOT NULL,
  `appointment_date_time` datetime NOT NULL,
  `appointment_location` varchar(100) NOT NULL,
  `appointment_status` varchar(20) NOT NULL CHECK (`appointment_status` in ('scheduled','completed','cancelled','no-show'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `donor_id`, `event_id`, `appointment_date_time`, `appointment_location`, `appointment_status`) VALUES
('A001', 'D001', 'E01', '2025-06-10 09:00:00', 'Legazpi Gym', 'completed'),
('A002', 'D002', 'E02', '2025-06-11 10:30:00', 'City Hall', 'completed'),
('A003', 'D003', 'E03', '2025-06-12 08:45:00', 'BU Campus', 'completed'),
('A004', 'D004', 'E04', '2025-06-13 11:00:00', 'Community Center', 'scheduled'),
('A005', 'D005', 'E05', '2025-06-14 13:15:00', 'Red Cross HQ', 'completed'),
('A006', 'D006', 'E06', '2025-06-15 15:00:00', 'Corporate Clinic', 'no-show'),
('A007', 'D007', 'E07', '2025-06-16 09:30:00', 'Barangay Hall', 'scheduled'),
('A008', 'D008', 'E08', '2025-06-17 10:00:00', 'Provincial Hospital', 'completed'),
('A009', 'D009', 'E09', '2025-06-18 14:00:00', 'Eastside Medical', 'scheduled'),
('A010', 'D010', 'E10', '2025-06-19 16:30:00', 'Westcare Hospital', 'completed'),
('A011', 'D011', 'E01', '2025-06-10 10:00:00', 'Legazpi Gym', 'completed'),
('A012', 'D012', 'E02', '2025-06-11 11:00:00', 'City Hall', 'cancelled'),
('A013', 'D013', 'E03', '2025-06-12 09:30:00', 'BU Campus', 'completed'),
('A014', 'D014', 'E05', '2025-06-14 14:00:00', 'Red Cross HQ', 'completed'),
('A015', 'D015', 'E08', '2025-06-17 11:00:00', 'Provincial Hospital', 'scheduled'),
('A016', 'D016', 'E11', '2025-07-01 09:00:00', 'South District Hall', 'scheduled'),
('A017', 'D017', 'E11', '2025-07-01 10:00:00', 'South District Hall', 'scheduled'),
('A018', 'D018', 'E12', '2025-07-05 08:30:00', 'Midtown Clinic', 'completed'),
('A019', 'D019', 'E12', '2025-07-05 09:30:00', 'Midtown Clinic', 'completed'),
('A020', 'D020', 'E13', '2025-07-10 10:00:00', 'Daraga Barangay Hall', 'completed'),
('A021', 'D021', 'E02', '2025-06-11 12:00:00', 'City Hall', 'completed'),
('A022', 'D022', 'E03', '2025-06-12 10:30:00', 'BU Campus', 'completed'),
('A023', 'D023', 'E05', '2025-06-14 15:00:00', 'Red Cross HQ', 'cancelled'),
('A024', 'D024', 'E06', '2025-06-15 09:00:00', 'Corporate Clinic', 'completed'),
('A025', 'D025', 'E07', '2025-06-16 11:00:00', 'Barangay Hall', 'completed'),
('A026', 'D026', 'E08', '2025-06-17 13:00:00', 'Provincial Hospital', 'no-show'),
('A027', 'D027', 'E09', '2025-06-18 15:30:00', 'Eastside Medical', 'completed'),
('A028', 'D028', 'E10', '2025-06-19 08:00:00', 'Westcare Hospital', 'completed'),
('A029', 'D033', 'E11', '2025-07-01 11:00:00', 'South District Hall', 'scheduled'),
('A030', 'D034', 'E12', '2025-07-05 10:30:00', 'Midtown Clinic', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `blood_release`
--

CREATE TABLE `blood_release` (
  `release_id` varchar(10) NOT NULL,
  `request_id` varchar(10) NOT NULL,
  `blood_unit_id` varchar(10) NOT NULL,
  `units_released` int(11) NOT NULL DEFAULT 1,
  `release_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_release`
--

INSERT INTO `blood_release` (`release_id`, `request_id`, `blood_unit_id`, `units_released`, `release_date`) VALUES
('RE01', 'RQ02', 'BU02', 1, '2025-06-10'),
('RE02', 'RQ05', 'BU04', 1, '2025-06-11'),
('RE03', 'RQ07', 'BU06', 1, '2025-06-12'),
('RE04', 'RQ09', 'BU08', 1, '2025-06-13'),
('RE05', 'RQ12', 'BU09', 1, '2025-06-14'),
('RE06', 'RQ16', 'BU11', 1, '2025-06-01'),
('RE07', 'RQ19', 'BU12', 1, '2025-06-06'),
('RE08', 'RQ21', 'BU14', 1, '2025-06-10'),
('RE09', 'RQ02', 'BU17', 1, '2025-06-11'),
('RE10', 'RQ07', 'BU13', 1, '2025-06-12'),
('RE11', 'RQ15', 'BU05', 1, '2026-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `blood_request`
--

CREATE TABLE `blood_request` (
  `request_id` varchar(10) NOT NULL,
  `recipient_id` varchar(10) NOT NULL,
  `blood_type` varchar(5) NOT NULL,
  `units_requested` int(11) NOT NULL,
  `request_location` varchar(100) NOT NULL,
  `request_date` date NOT NULL,
  `req_status` varchar(20) NOT NULL CHECK (`req_status` in ('pending','completed','cancelled'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_request`
--

INSERT INTO `blood_request` (`request_id`, `recipient_id`, `blood_type`, `units_requested`, `request_location`, `request_date`, `req_status`) VALUES
('RQ01', 'RC001', 'O+', 2, 'Central Hospital', '2025-05-01', 'pending'),
('RQ02', 'RC002', 'O+', 1, 'St. Mary Clinic', '2025-06-09', 'completed'),
('RQ03', 'RC003', 'B+', 3, 'City Medical Center', '2025-05-05', 'pending'),
('RQ04', 'RC004', 'AB+', 2, 'Provincial Hospital', '2025-05-07', 'cancelled'),
('RQ05', 'RC005', 'A-', 1, 'Eastside ER', '2025-06-10', 'completed'),
('RQ06', 'RC006', 'A-', 1, 'Westcare Hospital', '2025-05-11', 'pending'),
('RQ07', 'RC007', 'AB+', 1, 'General Hospital', '2025-06-11', 'completed'),
('RQ08', 'RC008', 'O+', 2, 'Legazpi Clinic', '2025-05-15', 'pending'),
('RQ09', 'RC009', 'O+', 1, 'Daraga Infirmary', '2025-05-17', 'completed'),
('RQ10', 'RC010', 'B+', 3, 'Albay Medical Center', '2025-06-19', 'completed'),
('RQ11', 'RC011', 'A+', 1, 'South District Hospital', '2025-05-20', 'pending'),
('RQ12', 'RC012', 'O-', 2, 'Midtown Medical', '2025-05-22', 'completed'),
('RQ13', 'RC013', 'AB-', 1, 'Daraga Health Center', '2025-05-24', 'pending'),
('RQ14', 'RC014', 'B-', 2, 'Camalig Clinic', '2025-05-26', 'cancelled'),
('RQ15', 'RC015', 'A+', 1, 'Legazpi General Hospital', '2025-05-29', 'completed'),
('RQ16', 'RC016', 'O+', 2, 'Albay Provincial Hospital', '2025-05-31', 'completed'),
('RQ17', 'RC017', 'B-', 1, 'Daraga Health Center', '2025-06-02', 'completed'),
('RQ18', 'RC018', 'AB+', 2, 'Camalig Clinic', '2025-06-04', 'cancelled'),
('RQ19', 'RC001', 'O-', 1, 'Central Hospital', '2025-06-05', 'completed'),
('RQ20', 'RC003', 'B+', 2, 'City Medical Center', '2025-06-07', 'completed'),
('RQ21', 'RC005', 'A+', 1, 'Eastside ER', '2025-06-09', 'completed'),
('RQ22', 'RC007', 'O+', 3, 'General Hospital', '2025-06-10', 'completed'),
('RQ23', 'RC019', 'O+', 2, 'Legazpi General Hospital', '2026-05-25', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `blood_unit`
--

CREATE TABLE `blood_unit` (
  `blood_unit_id` varchar(10) NOT NULL,
  `appointment_id` varchar(10) NOT NULL,
  `units_collected` int(11) NOT NULL DEFAULT 1,
  `unit_status` varchar(10) NOT NULL CHECK (`unit_status` in ('stored','released','reserved','expired')),
  `expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_unit`
--

INSERT INTO `blood_unit` (`blood_unit_id`, `appointment_id`, `units_collected`, `unit_status`, `expiry_date`) VALUES
('BU01', 'A001', 1, 'stored', '2025-07-15'),
('BU02', 'A002', 1, 'released', '2025-07-16'),
('BU03', 'A003', 1, 'stored', '2025-07-17'),
('BU04', 'A005', 1, 'released', '2025-07-19'),
('BU05', 'A008', 1, 'released', '2025-07-22'),
('BU06', 'A010', 1, 'released', '2025-07-24'),
('BU07', 'A011', 1, 'stored', '2025-07-15'),
('BU08', 'A013', 1, 'reserved', '2025-07-17'),
('BU09', 'A014', 1, 'stored', '2025-07-19'),
('BU10', 'A001', 1, 'stored', '2025-07-15'),
('BU11', 'A021', 1, 'stored', '2025-07-26'),
('BU12', 'A022', 1, 'released', '2025-07-27'),
('BU13', 'A024', 1, 'stored', '2025-07-28'),
('BU14', 'A025', 1, 'released', '2025-07-29'),
('BU15', 'A027', 1, 'stored', '2025-07-30'),
('BU16', 'A028', 1, 'stored', '2025-07-31'),
('BU17', 'A003', 1, 'reserved', '2025-07-17'),
('BU18', 'A005', 1, 'stored', '2025-07-19'),
('BU19', 'A008', 1, 'stored', '2025-07-22'),
('BU20', 'A010', 1, 'expired', '2025-07-24'),
('BU21', 'A020', 1, 'stored', '2026-07-04'),
('BU22', 'A030', 1, 'stored', '2026-07-04'),
('BU23', 'A019', 1, 'stored', '2026-07-04'),
('BU24', 'A018', 1, 'stored', '2026-07-04');

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `user_database` varchar(10) NOT NULL,
  `admin_id` varchar(10) NOT NULL,
  `chapter_LOC` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`user_database`, `admin_id`, `chapter_LOC`) VALUES
('db_01', 'ADM1', 'Legazpi City'),
('db_02', 'ADM2', 'Albay'),
('db_03', 'ADM3', 'Daraga');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `donor_id` varchar(10) NOT NULL,
  `user_role_id` varchar(10) NOT NULL,
  `no_times_donated` int(11) NOT NULL DEFAULT 0,
  `blood_type` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`donor_id`, `user_role_id`, `no_times_donated`, `blood_type`) VALUES
('D001', 'UR002', 2, 'O+'),
('D002', 'UR003', 1, 'A-'),
('D003', 'UR006', 3, 'AB+'),
('D004', 'UR007', 4, 'AB+'),
('D005', 'UR008', 2, 'O-'),
('D006', 'UR009', 1, 'A-'),
('D007', 'UR011', 3, 'O+'),
('D008', 'UR012', 2, 'A+'),
('D009', 'UR014', 1, 'B+'),
('D010', 'UR015', 5, 'O+'),
('D011', 'UR016', 2, 'A+'),
('D012', 'UR018', 3, 'O-'),
('D013', 'UR020', 1, 'B-'),
('D014', 'UR021', 4, 'O+'),
('D015', 'UR022', 2, 'A+'),
('D016', 'UR024', 1, 'AB-'),
('D017', 'UR025', 3, 'O+'),
('D018', 'UR026', 3, 'A-'),
('D019', 'UR028', 2, 'B+'),
('D020', 'UR030', 5, 'A+'),
('D021', 'UR031', 2, 'O+'),
('D022', 'UR032', 3, 'B+'),
('D023', 'UR034', 1, 'O-'),
('D024', 'UR035', 2, 'A+'),
('D025', 'UR036', 5, 'B-'),
('D026', 'UR038', 1, 'O+'),
('D027', 'UR040', 3, 'A+'),
('D028', 'UR041', 2, 'AB+'),
('D029', 'UR042', 1, 'O+'),
('D030', 'UR044', 4, 'B+'),
('D031', 'UR046', 2, 'A-'),
('D032', 'UR048', 3, 'O+'),
('D033', 'UR049', 1, 'B+'),
('D034', 'UR051', 3, 'O+'),
('D035', 'UR053', 1, 'A+'),
('D036', 'UR055', 3, 'AB-'),
('D037', 'UR057', 2, 'O-'),
('D038', 'UR058', 1, 'B-'),
('D039', 'UR059', 0, 'O-');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` varchar(10) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `event_location` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `managed_by` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_name`, `event_date`, `event_location`, `capacity`, `managed_by`) VALUES
('E01', 'Blood Drive North', '2025-06-10', 'Legazpi Gym', 50, 'ADM1'),
('E02', 'City Hall Donation Camp', '2025-06-11', 'City Hall', 75, 'ADM2'),
('E03', 'University Blood Drive', '2025-06-12', 'BU Campus', 100, 'ADM2'),
('E04', 'Community Mobile Drive', '2025-06-13', 'Community Center', 40, 'ADM3'),
('E05', 'Red Cross Weekend Event', '2025-06-14', 'Red Cross HQ', 120, 'ADM2'),
('E06', 'Corporate Donation Day', '2025-06-15', 'Corporate Clinic', 60, 'ADM2'),
('E07', 'Barangay Health Outreach', '2025-06-16', 'Barangay Hall', 35, 'ADM2'),
('E08', 'Provincial Blood Mission', '2025-06-17', 'Provincial Hospital', 90, 'ADM2'),
('E09', 'Eastside Emergency Drive', '2025-06-18', 'Eastside Medical', 55, 'ADM1'),
('E10', 'Westcare Lifesaver Event', '2025-06-19', 'Westcare Hospital', 80, 'ADM3'),
('E11', 'South District Blood Drive', '2025-07-01', 'South District Hall', 60, 'ADM1'),
('E12', 'Midtown Donation Marathon', '2025-07-05', 'Midtown Clinic', 90, 'ADM2'),
('E13', 'Rural Outreach Program', '2025-07-10', 'Daraga Barangay Hall', 45, 'ADM3');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `feedback` text NOT NULL,
  `submitted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `feedback`, `submitted_at`) VALUES
(1, 'U001', 'The donation process was smooth and organized.', '2025-06-20 09:00:00'),
(2, 'U002', 'Staff were very helpful during my appointment.', '2025-06-20 09:15:00'),
(3, 'U003', 'Waiting time was short and manageable.', '2025-06-20 09:30:00'),
(4, 'U004', 'The event location was easy to find.', '2025-06-20 09:45:00'),
(5, 'U005', 'I appreciated the reminder before my schedule.', '2025-06-20 10:00:00'),
(6, 'U006', 'The screening process was explained clearly.', '2025-06-20 10:15:00'),
(7, 'U007', 'Overall experience was excellent and efficient.', '2025-06-20 10:30:00'),
(8, 'U008', 'The registration steps were simple to follow.', '2025-06-20 10:45:00'),
(9, 'U009', 'I felt comfortable and well assisted throughout.', '2025-06-20 11:00:00'),
(10, 'U010', 'Notifications and updates were timely and helpful.', '2025-06-20 11:15:00'),
(11, 'U011', 'Great organization and friendly volunteers.', '2025-06-20 11:30:00'),
(12, 'U012', 'The venue was clean and well-prepared.', '2025-06-20 11:45:00'),
(13, 'U013', 'Quick and hassle-free donation experience.', '2025-06-20 12:00:00'),
(14, 'U014', 'I will definitely donate again at the next event.', '2025-06-20 12:15:00'),
(15, 'U015', 'The health screening was thorough and professional.', '2025-06-20 12:30:00'),
(16, 'U016', 'The staff were professional and caring throughout.', '2025-06-21 08:00:00'),
(17, 'U017', 'Easy to register and the process was well-explained.', '2025-06-21 08:15:00'),
(18, 'U018', 'I felt safe and well-informed during my donation.', '2025-06-21 08:30:00'),
(19, 'U019', 'The volunteers were friendly and very accommodating.', '2025-06-21 08:45:00'),
(20, 'U020', 'Excellent event management and crowd control.', '2025-06-21 09:00:00'),
(21, 'U021', 'The refreshments after donation were a nice touch.', '2025-06-21 09:15:00'),
(22, 'U022', 'Very organized and the lines moved quickly.', '2025-06-21 09:30:00'),
(23, 'U023', 'I appreciated the follow-up message after my donation.', '2025-06-21 09:45:00'),
(24, 'U024', 'The health screening was quick and professional.', '2025-06-21 10:00:00'),
(25, 'U025', 'Great initiative, I will recommend this to my friends.', '2025-06-21 10:15:00'),
(26, 'U026', 'The appointment reminder was very helpful.', '2025-06-21 10:30:00'),
(27, 'U027', 'Clean and comfortable venue for the blood drive.', '2025-06-21 10:45:00'),
(28, 'U028', 'Staff answered all my questions patiently.', '2025-06-21 11:00:00'),
(29, 'U029', 'Smooth experience from registration to donation.', '2025-06-21 11:15:00'),
(30, 'U030', 'Happy to contribute and will definitely come back.', '2025-06-21 11:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `profile_id` varchar(10) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `sex` char(1) NOT NULL CHECK (`sex` in ('M','F')),
  `address` varchar(200) NOT NULL,
  `mobile_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `user_id`, `fname`, `lname`, `mname`, `birth_date`, `sex`, `address`, `mobile_no`) VALUES
('P001', 'U001', 'Alex', 'Ramos', 'M', '1995-02-10', 'M', '123 Rizal St, Legazpi', '+639171111111'),
('P002', 'U002', 'Bianca', 'Lopez', 'T', '1994-07-18', 'F', '45 Mabini Ave, Daraga', '+639181111112'),
('P003', 'U003', 'Carlo', 'Diaz', 'P', '1998-11-04', 'M', '78 Luna Rd, Albay', '+639191111113'),
('P004', 'U004', 'Diana', 'Cruz', 'R', '1990-03-22', 'F', '9 Bonifacio Blvd, Legazpi', '+639201111114'),
('P005', 'U005', 'Ethan', 'Reyes', 'G', '1996-09-15', 'M', '14 Sampaguita St, Albay', '+639211111115'),
('P006', 'U006', 'Faith', 'Santos', 'L', '1991-12-01', 'F', '88 Acacia Ave, Legazpi', '+639221111116'),
('P007', 'U007', 'Gabriel', 'Tan', 'C', '1994-05-27', 'M', '32 Narra St, Daraga', '+639231111117'),
('P008', 'U008', 'Hannah', 'Uy', 'D', '1993-08-09', 'F', '67 Molave St, Legazpi', '+639241111118'),
('P009', 'U009', 'Ivan', 'Mendoza', 'S', '1997-01-14', 'M', '21 Yakal Ave, Albay', '+639251111119'),
('P010', 'U010', 'Julia', 'Flores', 'N', '1992-10-30', 'F', '54 Mahogany Rd, Daraga', '+639261111120'),
('P011', 'U011', 'James', 'Garcia', 'B', '1993-04-10', 'M', '10 Magallanes St, Legazpi', '+639271111121'),
('P012', 'U012', 'Karen', 'Reyes', 'A', '1995-08-22', 'F', '22 Peñaranda St, Legazpi', '+639281111122'),
('P013', 'U013', 'Luis', 'Bautista', 'C', '1990-06-15', 'M', '35 Quezon Ave, Legazpi', '+639291111123'),
('P014', 'U014', 'Maria', 'Santos', 'D', '1997-11-03', 'F', '47 Rizal St, Legazpi', '+639301111124'),
('P015', 'U015', 'Nelson', 'Cruz', 'E', '1988-02-28', 'M', '58 Burgos St, Legazpi', '+639311111125'),
('P016', 'U016', 'Olivia', 'Tan', 'F', '1996-07-19', 'F', '63 Del Rosario St, Legazpi', '+639321111126'),
('P017', 'U017', 'Pedro', 'Garcia', 'G', '1994-03-07', 'M', '74 Lapu-Lapu St, Legazpi', '+639331111127'),
('P018', 'U018', 'Queen', 'Lim', 'H', '1991-09-14', 'F', '85 Rizal Ave, Legazpi', '+639341111128'),
('P019', 'U019', 'Rafael', 'Torres', 'I', '1999-01-25', 'M', '96 Mabini St, Legazpi', '+639351111129'),
('P020', 'U020', 'Sara', 'Mendoza', 'J', '1993-05-30', 'F', '107 Luna St, Legazpi', '+639361111130'),
('P021', 'U021', 'Tony', 'Villanueva', 'K', '1987-12-11', 'M', '118 Del Pilar St, Legazpi', '+639371111131'),
('P022', 'U022', 'Uma', 'Pascual', 'L', '1995-04-20', 'F', '12 Rizal St, Ligao', '+639381111132'),
('P023', 'U023', 'Victor', 'Ramos', 'M', '1992-08-08', 'M', '23 Quezon Blvd, Tabaco', '+639391111133'),
('P024', 'U024', 'Wendy', 'Gomez', 'N', '1998-02-17', 'F', '34 Mabini Ave, Tiwi', '+639401111134'),
('P025', 'U025', 'Xavier', 'Dela Cruz', 'O', '1990-11-29', 'M', '45 Bonifacio St, Oas', '+639411111135'),
('P026', 'U026', 'Yvonne', 'Aquino', 'P', '1996-06-06', 'F', '56 Luna Rd, Polangui', '+639421111136'),
('P027', 'U027', 'Zeus', 'Cabrera', 'Q', '1994-10-13', 'M', '67 Rizal Ave, Libon', '+639431111137'),
('P028', 'U028', 'Anna', 'Flores', 'R', '1991-03-24', 'F', '78 Del Rosario St, Guinobatan', '+639441111138'),
('P029', 'U029', 'Ben', 'Herrera', 'S', '1997-07-02', 'M', '89 Peñaranda St, Camalig', '+639451111139'),
('P030', 'U030', 'Clara', 'Ibañez', 'T', '1993-12-18', 'F', '90 Burgos Ave, Malilipot', '+639461111140'),
('P031', 'U031', 'Dan', 'Jacinto', 'U', '1988-05-09', 'M', '101 Quezon St, Santo Domingo', '+639471111141'),
('P032', 'U032', 'Ella', 'Kristobal', 'V', '1999-09-27', 'F', '112 Mabini Rd, Bacacay', '+639481111142'),
('P033', 'U033', 'Felix', 'Luna', 'W', '1995-01-15', 'M', '123 Rizal Blvd, Rapu-Rapu', '+639491111143'),
('P034', 'U034', 'Grace', 'Nicolas', 'X', '1992-06-03', 'F', '14 Quezon Ave, Daraga', '+639501111144'),
('P035', 'U035', 'Henry', 'Ocampo', 'Y', '1990-10-21', 'M', '25 Mabini St, Camalig', '+639511111145'),
('P036', 'U036', 'Iris', 'Peña', 'Z', '1997-04-14', 'F', '36 Luna Ave, Ligao', '+639521111146'),
('P037', 'U037', 'Joel', 'Quizon', 'A', '1993-08-30', 'M', '47 Rizal St, Polangui', '+639531111147'),
('P038', 'U038', 'Kate', 'Reyes', 'B', '1996-02-07', 'F', '58 Bonifacio Blvd, Oas', '+639541111148'),
('P039', 'U039', 'Leo', 'Santos', 'C', '1988-11-19', 'M', '69 Del Pilar St, Tabaco', '+639551111149'),
('P040', 'U040', 'Mia', 'Torres', 'D', '1994-07-26', 'F', '70 Peñaranda Ave, Tiwi', '+639561111150'),
('P041', 'U041', 'Nico', 'Urbano', 'E', '1991-01-11', 'M', '81 Burgos St, Libon', '+639571111151'),
('P042', 'U042', 'Olive', 'Valdez', 'F', '1998-05-05', 'F', '92 Quezon Rd, Guinobatan', '+639581111152'),
('P043', 'U043', 'Pat', 'Wenceslao', 'G', '1995-09-22', 'M', '103 Mabini St, Bacacay', '+639591111153'),
('P044', 'U044', 'Quinn', 'Xavier', 'H', '1992-03-16', 'F', '114 Rizal Ave, Malilipot', '+639601111154'),
('P045', 'U045', 'Rose', 'Yap', 'I', '1996-12-08', 'F', '125 Luna St, Santo Domingo', '+639611111155'),
('P046', 'U046', 'Antonio', 'Reyes', 'B', '1993-03-15', 'M', '22 Rizal St, Legazpi', '+639621111156'),
('P047', 'U047', 'Bernadette', 'Lim', 'C', '1991-07-22', 'F', '34 Mabini Ave, Legazpi', '+639631111157'),
('P048', 'U048', 'Carlos', 'Santos', 'D', '1996-11-08', 'M', '45 Luna Rd, Tabaco', '+639641111158'),
('P049', 'U049', 'Delia', 'Garcia', 'E', '1989-04-30', 'F', '56 Quezon St, Ligao', '+639651111159'),
('P050', 'U050', 'Eduardo', 'Cruz', 'F', '1997-08-17', 'M', '67 Bonifacio Ave, Daraga', '+639661111160'),
('P051', 'U051', 'Fiona', 'Mendoza', 'G', '1994-02-05', 'F', '78 Del Pilar St, Camalig', '+639671111161'),
('P052', 'U052', 'George', 'Tan', 'H', '1990-06-28', 'M', '89 Peñaranda St, Legazpi', '+639681111162'),
('P053', 'U053', 'Helen', 'Aquino', 'I', '1998-10-14', 'F', '90 Burgos Rd, Polangui', '+639691111163'),
('P054', 'U054', 'Isaac', 'Torres', 'J', '1992-01-09', 'M', '101 Rizal Ave, Daraga', '+639701111164'),
('P055', 'U055', 'Jasmine', 'Villa', 'K', '1995-05-23', 'F', '112 Mabini St, Legazpi', '+639711111165'),
('P056', 'U056', 'Henrick', 'Dycoco', 'Taronga', '2026-05-16', 'M', 'San Vicente, Libon, Albay', '+639934627752'),
('P057', 'U057', 'Henrick', 'Dycoco', 'T', '2004-06-17', 'M', 'San Vicente, Libon, Albay', '+639934627752');

-- --------------------------------------------------------

--
-- Table structure for table `recipient`
--

CREATE TABLE `recipient` (
  `recipient_id` varchar(10) NOT NULL,
  `user_role_id` varchar(10) NOT NULL,
  `last_request_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipient`
--

INSERT INTO `recipient` (`recipient_id`, `user_role_id`, `last_request_date`) VALUES
('RC001', 'UR004', '2025-05-01'),
('RC002', 'UR010', '2025-05-03'),
('RC003', 'UR013', '2025-05-05'),
('RC004', 'UR017', '2025-05-07'),
('RC005', 'UR019', '2025-05-09'),
('RC006', 'UR023', '2025-05-11'),
('RC007', 'UR027', '2025-05-13'),
('RC008', 'UR029', '2025-05-15'),
('RC009', 'UR033', '2025-05-17'),
('RC010', 'UR037', '2025-05-19'),
('RC011', 'UR039', '2025-05-21'),
('RC012', 'UR043', '2025-05-23'),
('RC013', 'UR045', '2025-05-25'),
('RC014', 'UR047', '2025-05-27'),
('RC015', 'UR050', '2025-05-29'),
('RC016', 'UR052', '2025-05-31'),
('RC017', 'UR054', '2025-06-02'),
('RC018', 'UR056', '2025-06-04'),
('RC019', 'UR002', '2026-05-25'),
('RC020', 'UR059', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `user_id` varchar(10) NOT NULL,
  `user_database` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`user_id`, `user_database`, `email`, `password`, `created_at`) VALUES
('U001', 'db_01', 'alex.ramos@example.com', 'Pass@001', '2025-01-01'),
('U002', 'db_03', 'bianca.lopez@example.com', 'Pass@002', '2025-01-03'),
('U003', 'db_02', 'carlo.diaz@example.com', 'Pass@003', '2025-01-05'),
('U004', 'db_01', 'diana.cruz@example.com', 'Pass@004', '2025-01-07'),
('U005', 'db_02', 'ethan.reyes@example.com', 'Pass@005', '2025-01-09'),
('U006', 'db_01', 'faith.santos@example.com', 'Pass@006', '2025-01-11'),
('U007', 'db_03', 'gabriel.tan@example.com', 'Pass@007', '2025-01-13'),
('U008', 'db_01', 'hannah.uy@example.com', 'Pass@008', '2025-01-15'),
('U009', 'db_02', 'ivan.mendoza@example.com', 'Pass@009', '2025-01-17'),
('U010', 'db_03', 'julia.flores@example.com', 'Pass@010', '2025-01-19'),
('U011', 'db_01', 'james.garcia@example.com', 'Pass@011', '2025-01-21'),
('U012', 'db_01', 'karen.reyes@example.com', 'Pass@012', '2025-01-23'),
('U013', 'db_01', 'luis.bautista@example.com', 'Pass@013', '2025-01-25'),
('U014', 'db_01', 'maria.santos@example.com', 'Pass@014', '2025-01-27'),
('U015', 'db_01', 'nelson.cruz@example.com', 'Pass@015', '2025-01-29'),
('U016', 'db_01', 'olivia.tan@example.com', 'Pass@016', '2025-01-31'),
('U017', 'db_01', 'pedro.garcia@example.com', 'Pass@017', '2025-02-02'),
('U018', 'db_01', 'queen.lim@example.com', 'Pass@018', '2025-02-04'),
('U019', 'db_01', 'rafael.torres@example.com', 'Pass@019', '2025-02-06'),
('U020', 'db_01', 'sara.mendoza@example.com', 'Pass@020', '2025-02-08'),
('U021', 'db_01', 'tony.villanueva@example.com', 'Pass@021', '2025-02-10'),
('U022', 'db_02', 'uma.pascual@example.com', 'Pass@022', '2025-02-12'),
('U023', 'db_02', 'victor.ramos@example.com', 'Pass@023', '2025-02-14'),
('U024', 'db_02', 'wendy.gomez@example.com', 'Pass@024', '2025-02-16'),
('U025', 'db_02', 'xavier.dela.cruz@example.com', 'Pass@025', '2025-02-18'),
('U026', 'db_02', 'yvonne.aquino@example.com', 'Pass@026', '2025-02-20'),
('U027', 'db_02', 'zeus.cabrera@example.com', 'Pass@027', '2025-02-22'),
('U028', 'db_02', 'anna.flores@example.com', 'Pass@028', '2025-02-24'),
('U029', 'db_02', 'ben.herrera@example.com', 'Pass@029', '2025-02-26'),
('U030', 'db_02', 'clara.ibañez@example.com', 'Pass@030', '2025-02-28'),
('U031', 'db_02', 'dan.jacinto@example.com', 'Pass@031', '2025-03-02'),
('U032', 'db_02', 'ella.kristobal@example.com', 'Pass@032', '2025-03-04'),
('U033', 'db_02', 'felix.luna@example.com', 'Pass@033', '2025-03-06'),
('U034', 'db_03', 'grace.nicolas@example.com', 'Pass@034', '2025-03-08'),
('U035', 'db_03', 'henry.ocampo@example.com', 'Pass@035', '2025-03-10'),
('U036', 'db_03', 'iris.peña@example.com', 'Pass@036', '2025-03-12'),
('U037', 'db_03', 'joel.quizon@example.com', 'Pass@037', '2025-03-14'),
('U038', 'db_03', 'kate.reyes@example.com', 'Pass@038', '2025-03-16'),
('U039', 'db_03', 'leo.santos@example.com', 'Pass@039', '2025-03-18'),
('U040', 'db_03', 'mia.torres@example.com', 'Pass@040', '2025-03-20'),
('U041', 'db_03', 'nico.urbano@example.com', 'Pass@041', '2025-03-22'),
('U042', 'db_03', 'olive.valdez@example.com', 'Pass@042', '2025-03-24'),
('U043', 'db_03', 'pat.wenceslao@example.com', 'Pass@043', '2025-03-26'),
('U044', 'db_03', 'quinn.xavier@example.com', 'Pass@044', '2025-03-28'),
('U045', 'db_03', 'rose.yap@example.com', 'Pass@045', '2025-03-30'),
('U046', 'db_01', 'antonio.reyes@example.com', 'Pass@046', '2025-04-01'),
('U047', 'db_01', 'bernadette.lim@example.com', 'Pass@047', '2025-04-03'),
('U048', 'db_02', 'carlos.santos@example.com', 'Pass@048', '2025-04-05'),
('U049', 'db_02', 'delia.garcia@example.com', 'Pass@049', '2025-04-07'),
('U050', 'db_03', 'eduardo.cruz@example.com', 'Pass@050', '2025-04-09'),
('U051', 'db_03', 'fiona.mendoza@example.com', 'Pass@051', '2025-04-11'),
('U052', 'db_01', 'george.tan@example.com', 'Pass@052', '2025-04-13'),
('U053', 'db_02', 'helen.aquino@example.com', 'Pass@053', '2025-04-15'),
('U054', 'db_03', 'isaac.torres@example.com', 'Pass@054', '2025-04-17'),
('U055', 'db_01', 'jasmine.villa@example.com', 'Pass@055', '2025-04-19'),
('U056', 'db_02', 'inwik@gmail.com', '123456a', '2026-05-23'),
('U057', 'db_01', 'dickhen@gmail', '1234567a', '2026-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `user_role_id` varchar(10) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `time_assigned` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `role_id` varchar(10) NOT NULL DEFAULT 'R1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`user_role_id`, `user_id`, `time_assigned`, `is_active`, `role_id`) VALUES
('UR001', 'U001', '2025-01-02 08:00:00', 0, 'R1'),
('UR002', 'U001', '2025-04-04 08:15:00', 1, 'R2'),
('UR003', 'U002', '2025-01-06 08:30:00', 0, 'R1'),
('UR004', 'U002', '2025-04-08 08:45:00', 1, 'R2'),
('UR005', 'U003', '2025-01-10 09:00:00', 0, 'R1'),
('UR006', 'U003', '2025-05-12 09:15:00', 1, 'R1'),
('UR007', 'U004', '2025-01-14 09:30:00', 1, 'R1'),
('UR008', 'U005', '2025-01-16 09:45:00', 1, 'R1'),
('UR009', 'U006', '2025-01-18 10:00:00', 1, 'R1'),
('UR010', 'U007', '2025-01-20 10:15:00', 1, 'R2'),
('UR011', 'U008', '2025-02-01 08:00:00', 1, 'R1'),
('UR012', 'U009', '2025-02-03 08:00:00', 1, 'R1'),
('UR013', 'U010', '2025-02-05 08:00:00', 1, 'R2'),
('UR014', 'U011', '2025-02-07 08:00:00', 1, 'R1'),
('UR015', 'U012', '2025-02-09 08:00:00', 1, 'R1'),
('UR016', 'U013', '2025-02-11 08:00:00', 1, 'R1'),
('UR017', 'U014', '2025-02-13 08:00:00', 1, 'R2'),
('UR018', 'U015', '2025-02-15 08:00:00', 1, 'R1'),
('UR019', 'U016', '2025-02-17 08:00:00', 1, 'R2'),
('UR020', 'U017', '2025-02-19 08:00:00', 1, 'R1'),
('UR021', 'U018', '2025-02-21 08:00:00', 1, 'R1'),
('UR022', 'U019', '2025-02-23 08:00:00', 1, 'R1'),
('UR023', 'U020', '2025-02-25 08:00:00', 1, 'R2'),
('UR024', 'U021', '2025-02-27 08:00:00', 1, 'R1'),
('UR025', 'U022', '2025-03-01 08:00:00', 1, 'R1'),
('UR026', 'U023', '2025-03-03 08:00:00', 1, 'R1'),
('UR027', 'U024', '2025-03-05 08:00:00', 1, 'R2'),
('UR028', 'U025', '2025-03-07 08:00:00', 1, 'R1'),
('UR029', 'U026', '2025-03-09 08:00:00', 1, 'R2'),
('UR030', 'U027', '2025-03-11 08:00:00', 1, 'R1'),
('UR031', 'U028', '2025-03-13 08:00:00', 1, 'R1'),
('UR032', 'U029', '2025-03-15 08:00:00', 1, 'R1'),
('UR033', 'U030', '2025-03-17 08:00:00', 1, 'R2'),
('UR034', 'U031', '2025-03-19 08:00:00', 1, 'R1'),
('UR035', 'U032', '2025-03-21 08:00:00', 1, 'R1'),
('UR036', 'U033', '2025-03-23 08:00:00', 1, 'R1'),
('UR037', 'U034', '2025-03-25 08:00:00', 1, 'R2'),
('UR038', 'U035', '2025-03-27 08:00:00', 1, 'R1'),
('UR039', 'U036', '2025-03-29 08:00:00', 1, 'R2'),
('UR040', 'U037', '2025-03-31 08:00:00', 1, 'R1'),
('UR041', 'U038', '2025-04-02 08:00:00', 1, 'R1'),
('UR042', 'U039', '2025-04-04 08:00:00', 1, 'R1'),
('UR043', 'U040', '2025-04-06 08:00:00', 1, 'R2'),
('UR044', 'U041', '2025-04-08 08:00:00', 1, 'R1'),
('UR045', 'U042', '2025-04-10 08:00:00', 1, 'R2'),
('UR046', 'U043', '2025-04-12 08:00:00', 1, 'R1'),
('UR047', 'U044', '2025-04-14 08:00:00', 1, 'R2'),
('UR048', 'U045', '2025-04-16 08:00:00', 1, 'R1'),
('UR049', 'U046', '2025-04-02 08:00:00', 1, 'R1'),
('UR050', 'U047', '2025-04-04 08:00:00', 1, 'R2'),
('UR051', 'U048', '2025-04-06 08:00:00', 1, 'R1'),
('UR052', 'U049', '2025-04-08 08:00:00', 1, 'R2'),
('UR053', 'U050', '2025-04-10 08:00:00', 1, 'R1'),
('UR054', 'U051', '2025-04-12 08:00:00', 1, 'R2'),
('UR055', 'U052', '2025-04-14 08:00:00', 1, 'R1'),
('UR056', 'U053', '2025-04-16 08:00:00', 1, 'R2'),
('UR057', 'U054', '2025-04-18 08:00:00', 1, 'R1'),
('UR058', 'U055', '2025-04-20 08:00:00', 1, 'R1'),
('UR059', 'U056', '2026-05-23 20:34:45', 1, 'R2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `blood_release`
--
ALTER TABLE `blood_release`
  ADD PRIMARY KEY (`release_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `blood_unit_id` (`blood_unit_id`);

--
-- Indexes for table `blood_request`
--
ALTER TABLE `blood_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `blood_unit`
--
ALTER TABLE `blood_unit`
  ADD PRIMARY KEY (`blood_unit_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`user_database`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`donor_id`),
  ADD KEY `user_role_id` (`user_role_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `managed_by` (`managed_by`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `recipient`
--
ALTER TABLE `recipient`
  ADD PRIMARY KEY (`recipient_id`),
  ADD KEY `user_role_id` (`user_role_id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_database` (`user_database`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`user_role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor` (`donor_id`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);

--
-- Constraints for table `blood_release`
--
ALTER TABLE `blood_release`
  ADD CONSTRAINT `blood_release_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `blood_request` (`request_id`),
  ADD CONSTRAINT `blood_release_ibfk_2` FOREIGN KEY (`blood_unit_id`) REFERENCES `blood_unit` (`blood_unit_id`);

--
-- Constraints for table `blood_request`
--
ALTER TABLE `blood_request`
  ADD CONSTRAINT `blood_request_ibfk_1` FOREIGN KEY (`recipient_id`) REFERENCES `recipient` (`recipient_id`);

--
-- Constraints for table `blood_unit`
--
ALTER TABLE `blood_unit`
  ADD CONSTRAINT `blood_unit_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`appointment_id`);

--
-- Constraints for table `chapter`
--
ALTER TABLE `chapter`
  ADD CONSTRAINT `chapter_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `donor`
--
ALTER TABLE `donor`
  ADD CONSTRAINT `donor_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`user_role_id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`managed_by`) REFERENCES `admin` (`admin_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`);

--
-- Constraints for table `recipient`
--
ALTER TABLE `recipient`
  ADD CONSTRAINT `recipient_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`user_role_id`);

--
-- Constraints for table `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `user_account_ibfk_1` FOREIGN KEY (`user_database`) REFERENCES `chapter` (`user_database`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
