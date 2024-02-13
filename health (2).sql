-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2024 at 09:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `health`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id_appointment` int(10) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_number` int(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id_appointment`, `topic`, `appointment_date`, `appointment_number`, `time`) VALUES
(25, 'ทดสอบ 1', '2024-02-15', 1, '2024-02-07 02:49:10'),
(26, 'ทดสอบ 2', '2024-02-07', 2, '2024-02-07 02:49:47'),
(28, 'ทดสอบ 3', '2024-02-22', 5, '2024-02-07 03:52:03'),
(29, 'ตรวจประจำปี', '2024-02-24', 9, '2024-02-07 04:09:32');

-- --------------------------------------------------------

--
-- Table structure for table `chronic_disease_info`
--

CREATE TABLE `chronic_disease_info` (
  `user_id` int(18) NOT NULL,
  `name` varchar(255) NOT NULL,
  `chronic_disease` varchar(255) NOT NULL,
  `procedures` varchar(255) NOT NULL,
  `treatment_history` varchar(255) NOT NULL,
  `complications` varchar(255) NOT NULL,
  `id_chronic` int(18) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chronic_disease_info`
--

INSERT INTO `chronic_disease_info` (`user_id`, `name`, `chronic_disease`, `procedures`, `treatment_history`, `complications`, `id_chronic`, `date`) VALUES
(555, 'kk', 'เอดส์', 'ไม่อะอะ', '5ปี', 'Complication1', 2, '2024-01-16 05:56:17'),
(555, 'kk', 'เอดส์ 3', ' ไม่มี', '9 ปี', 'Complication1', 3, '2024-01-16 05:56:34'),
(555, 'kk', 'เอดส์2', 'ไม่อะอะ', '5ปี', '', 4, '2024-01-16 05:57:06');

-- --------------------------------------------------------

--
-- Table structure for table `general_info`
--

CREATE TABLE `general_info` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `age` int(10) NOT NULL,
  `weight` int(10) NOT NULL,
  `height` int(10) NOT NULL,
  `exercise_frequency` varchar(255) NOT NULL,
  `health_condition` varchar(255) NOT NULL,
  `has_medical_history` varchar(255) NOT NULL,
  `treatment_history` varchar(255) NOT NULL,
  `bmi` int(10) NOT NULL,
  `bmi_category` varchar(255) NOT NULL,
  `checkup_level` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_info`
--

INSERT INTO `general_info` (`id`, `user_id`, `age`, `weight`, `height`, `exercise_frequency`, `health_condition`, `has_medical_history`, `treatment_history`, `bmi`, `bmi_category`, `checkup_level`, `date`, `gender`) VALUES
(52, 555, 45, 6621, 6166226, '0', 'wd', '1', '', 0, 'น้ำหนักน้อย / ผอม (มากกว่าคนปกติ)', 'executive check', '2024-01-29 05:07:16', 'ชาย'),
(55, 1921, 23, 92, 188, '0', 'ไม่มี', '0', '', 26, 'อ้วน / โรคอ้วนระดับ 2', 'advanced check', '2024-01-24 05:32:53', ''),
(56, 1921, 24, 91, 189, '0', 'ไม่มี', '0', '', 25, 'อ้วน / โรคอ้วนระดับ 2', 'advanced check', '2024-01-24 05:43:48', ''),
(57, 123, 54, 45, 170, '0', '', '0', '', 16, 'น้ำหนักน้อย / ผอม (มากกว่าคนปกติ)', 'supreme check', '2024-01-26 03:10:20', ''),
(58, 123, 41, 50, 180, '0', 'ไม่มี', '0', '', 15, 'น้ำหนักน้อย / ผอม (มากกว่าคนปกติ)', 'executive check', '2024-01-29 04:17:45', 'male'),
(59, 123, 41, 50, 180, '0', 'ไม่มี', '0', '', 15, 'น้ำหนักน้อย / ผอม (มากกว่าคนปกติ)', 'executive check', '2024-01-29 04:17:45', 'male'),
(60, 123, 45, 65, 182, '0', 'ไม่มี', '0', '', 15, 'น้ำหนักน้อย / ผอม (มากกว่าคนปกติ)', 'executive check', '2024-02-07 04:07:14', 'ชาย'),
(61, 123, 45, 50, 181, '0', 'ไม่มี', '0', '', 15, 'น้ำหนักน้อย / ผอม (มากกว่าคนปกติ)', 'executive check', '2024-02-07 04:07:17', 'ชาย'),
(62, 1921, 80, 45, 170, '0', '', '0', '', 16, 'น้ำหนักน้อย / ผอม (มากกว่าคนปกติ)', 'supreme check', '2024-01-29 04:20:25', 'หญิง'),
(63, 1921, 80, 65, 170, '0', '', '0', '', 16, 'น้ำหนักน้อย / ผอม (มากกว่าคนปกติ)', 'supreme check', '2024-02-01 03:49:58', 'หญิง'),
(64, 1921, 90, 45, 170, '0', '', '0', '', 16, 'น้ำหนักน้อย / ผอม (มากกว่าคนปกติ)', 'supreme check', '2024-01-29 05:09:48', 'ชาย Male'),
(65, 112233, 18, 80, 190, '0', '', '0', '', 22, 'ปกติ (สุขภาพดี)', 'basic check', '2024-02-12 04:28:16', 'ชาย');

-- --------------------------------------------------------

--
-- Table structure for table `google_fit_steps`
--

CREATE TABLE `google_fit_steps` (
  `id` int(255) NOT NULL,
  `user_id` int(20) NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `steps_count` int(20) NOT NULL,
  `calories_burned` decimal(20,0) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `google_fit_steps`
--

INSERT INTO `google_fit_steps` (`id`, `user_id`, `start_time`, `end_time`, `steps_count`, `calories_burned`, `date`) VALUES
(920, 555, '2024-01-15', '2024-01-16', 2027, 81, '2024-01-23 05:43:52'),
(921, 555, '2024-01-16', '2024-01-17', 908, 36, '2024-01-23 05:43:52'),
(922, 555, '2024-01-17', '2024-01-18', 1410, 56, '2024-01-23 05:43:52'),
(923, 555, '2024-01-18', '2024-01-19', 1713, 69, '2024-01-23 05:43:53'),
(924, 555, '2024-01-19', '2024-01-20', 1507, 60, '2024-01-23 05:43:53'),
(925, 555, '2024-01-20', '2024-01-21', 802, 32, '2024-01-23 05:43:53'),
(926, 555, '2024-01-21', '2024-01-22', 1776, 71, '2024-01-23 05:43:53'),
(934, 555, '2024-01-15', '2024-01-16', 2037, 81, '2024-01-22 05:54:22'),
(935, 555, '2024-01-16', '2024-01-17', 898, 36, '2024-01-22 05:54:23'),
(936, 555, '2024-01-17', '2024-01-18', 1410, 56, '2024-01-22 05:54:23'),
(937, 555, '2024-01-18', '2024-01-19', 1713, 69, '2024-01-22 05:54:23'),
(938, 555, '2024-01-19', '2024-01-20', 1507, 60, '2024-01-22 05:54:23'),
(939, 555, '2024-01-20', '2024-01-21', 831, 33, '2024-01-22 05:54:23'),
(940, 555, '2024-01-21', '2024-01-22', 1747, 70, '2024-01-22 05:54:23'),
(941, 555, '2024-01-15', '2024-01-16', 2037, 81, '2024-01-22 05:54:41'),
(942, 555, '2024-01-16', '2024-01-17', 898, 36, '2024-01-22 05:54:41'),
(943, 555, '2024-01-17', '2024-01-18', 1410, 56, '2024-01-22 05:54:42'),
(944, 555, '2024-01-18', '2024-01-19', 1713, 69, '2024-01-22 05:54:42'),
(945, 555, '2024-01-19', '2024-01-20', 1507, 60, '2024-01-22 05:54:42'),
(946, 555, '2024-01-20', '2024-01-21', 831, 33, '2024-01-22 05:54:42'),
(947, 555, '2024-01-21', '2024-01-22', 1747, 70, '2024-01-22 05:54:42'),
(948, 555, '2024-01-16', '2024-01-17', 1532, 61, '2024-01-23 01:59:06'),
(949, 555, '2024-01-17', '2024-01-18', 812, 32, '2024-01-23 01:59:06'),
(950, 555, '2024-01-18', '2024-01-19', 1308, 52, '2024-01-23 01:59:06'),
(951, 555, '2024-01-19', '2024-01-20', 2510, 100, '2024-01-23 01:59:06'),
(952, 555, '2024-01-20', '2024-01-21', 774, 31, '2024-01-23 01:59:06'),
(953, 555, '2024-01-21', '2024-01-22', 905, 36, '2024-01-23 01:59:06'),
(954, 555, '2024-01-22', '2024-01-23', 915, 37, '2024-01-23 01:59:06'),
(962, 123, '2024-01-16', '2024-01-17', 1251, 50, '2024-01-23 03:23:14'),
(963, 123, '2024-01-17', '2024-01-18', 1375, 55, '2024-01-23 03:23:14'),
(964, 123, '2024-01-18', '2024-01-19', 1020, 41, '2024-01-23 03:23:14'),
(965, 123, '2024-01-19', '2024-01-20', 2235, 89, '2024-01-23 03:23:14'),
(966, 123, '2024-01-20', '2024-01-21', 798, 32, '2024-01-23 03:23:14'),
(967, 123, '2024-01-21', '2024-01-22', 1654, 66, '2024-01-23 03:23:14'),
(968, 123, '2024-01-22', '2024-01-23', 142, 6, '2024-01-23 03:23:14'),
(969, 112, '2024-01-17', '2024-01-18', 1375, 55, '2024-01-24 03:41:44'),
(970, 112, '2024-01-18', '2024-01-19', 1044, 42, '2024-01-24 03:41:44'),
(971, 112, '2024-01-19', '2024-01-20', 2211, 88, '2024-01-24 03:41:44'),
(972, 112, '2024-01-20', '2024-01-21', 798, 32, '2024-01-24 03:41:44'),
(973, 112, '2024-01-21', '2024-01-22', 1654, 66, '2024-01-24 03:41:44'),
(974, 112, '2024-01-22', '2024-01-23', 142, 6, '2024-01-24 03:41:44'),
(975, 112, '2024-01-17', '2024-01-18', 1410, 56, '2024-01-24 05:31:40'),
(976, 112, '2024-01-18', '2024-01-19', 1711, 68, '2024-01-24 05:31:40'),
(977, 112, '2024-01-19', '2024-01-20', 1509, 60, '2024-01-24 05:31:40'),
(978, 112, '2024-01-20', '2024-01-21', 802, 32, '2024-01-24 05:31:40'),
(979, 112, '2024-01-21', '2024-01-22', 1776, 71, '2024-01-24 05:31:40'),
(980, 112, '2024-01-22', '2024-01-23', 16, 1, '2024-01-24 05:31:40'),
(981, 123, '2024-01-22', '2024-01-23', 266, 11, '2024-01-29 02:33:57'),
(982, 123, '2024-01-22', '2024-01-23', 266, 11, '2024-01-29 02:34:02'),
(985, 555, '2024-02-01', '2024-02-02', 2223, 89, '2024-02-08 02:33:37'),
(986, 555, '2024-02-02', '2024-02-03', 2260, 90, '2024-02-08 02:33:37'),
(987, 555, '2024-02-03', '2024-02-04', 400, 16, '2024-02-08 02:33:37'),
(988, 555, '2024-02-04', '2024-02-05', 2945, 118, '2024-02-08 02:33:37'),
(989, 555, '2024-02-05', '2024-02-06', 2113, 85, '2024-02-08 02:33:37'),
(990, 555, '2024-02-06', '2024-02-07', 2685, 107, '2024-02-08 02:33:37'),
(991, 555, '2024-02-07', '2024-02-08', 1931, 77, '2024-02-08 02:33:37'),
(992, 112233, '2024-02-06', '2024-02-07', 2963, 119, '2024-02-13 02:54:40'),
(993, 112233, '2024-02-07', '2024-02-08', 1681, 67, '2024-02-13 02:54:40'),
(994, 112233, '2024-02-06', '2024-02-07', 2963, 119, '2024-02-13 02:59:31'),
(995, 112233, '2024-02-07', '2024-02-08', 1681, 67, '2024-02-13 02:59:31');

-- --------------------------------------------------------

--
-- Table structure for table `health_checkup`
--

CREATE TABLE `health_checkup` (
  `id_topic` int(10) NOT NULL,
  `checkup_subject` varchar(255) NOT NULL COMMENT 'เรื่องที่ตรวจ',
  `checkup_details` varchar(255) NOT NULL COMMENT 'รายละเอียด'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `health_checkup`
--

INSERT INTO `health_checkup` (`id_topic`, `checkup_subject`, `checkup_details`) VALUES
(4, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys'),
(5, 'เอกซเรย์ปอดและหัวใจ', 'Chest X-Ray'),
(6, 'ตรวจปัสสาวะ', 'Urine Examination'),
(7, 'ตรวจอุจจาระ', 'Stool simple sedimen'),
(15, 'ความสมบูรณ์ของเม็ดเลือด', 'complete Blood Count'),
(16, 'ตรวจน้ำตาลในเลือด', 'Fasting Blood Sugar'),
(17, 'ตรวจไขมันในเลือด', 'Lipid Profile'),
(18, 'ตรวจไขมันในเลือด(คลอเรสเตอรอล)', 'Cholesterol'),
(19, 'ตรวจไขมันในเลือด(ไขมันไตรกลีเซอไรด์)', 'Triglyceride'),
(20, 'ตรวจไขมันในเลือด(ไขมันตัวดี)', 'HDL'),
(21, 'ตรวจไขมันในเลือด(ไขมันตัวร้าย)', 'LDL Cholesterrol');

-- --------------------------------------------------------

--
-- Table structure for table `set_test`
--

CREATE TABLE `set_test` (
  `id_test_set` int(20) NOT NULL,
  `id_topic` int(20) NOT NULL,
  `checkup_subject` varchar(255) NOT NULL,
  `checkup_details` varchar(255) NOT NULL,
  `sect` int(20) NOT NULL,
  `topic_sect` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `set_test`
--

INSERT INTO `set_test` (`id_test_set`, `id_topic`, `checkup_subject`, `checkup_details`, `sect`, `topic_sect`) VALUES
(110, 4, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys', 1, 'ทดสอบ 1'),
(111, 5, 'เอกซเรย์ปอดและหัวใจ', 'Chest X-Ray', 1, 'ทดสอบ 1'),
(112, 6, 'ตรวจปัสสาวะ', 'Urine Examination', 1, 'ทดสอบ 1'),
(113, 7, 'ตรวจอุจจาระ', 'Stool simple sedimen', 1, 'ทดสอบ 1'),
(114, 15, 'ความสมบูรณ์ของเม็ดเลือด', 'complete Blood Count', 1, 'ทดสอบ 1'),
(115, 16, 'ตรวจน้ำตาลในเลือด', 'Fasting Blood Sugar', 1, 'ทดสอบ 1'),
(116, 17, 'ตรวจไขมันในเลือด', 'Lipid Profile', 1, 'ทดสอบ 1'),
(117, 18, 'ตรวจไขมันในเลือด(คลอเรสเตอรอล)', 'Cholesterol', 1, 'ทดสอบ 1'),
(118, 19, 'ตรวจไขมันในเลือด(ไขมันไตรกลีเซอไรด์)', 'Triglyceride', 1, 'ทดสอบ 1'),
(119, 20, 'ตรวจไขมันในเลือด(ไขมันตัวดี)', 'HDL', 1, 'ทดสอบ 1'),
(120, 4, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys', 2, 'ทดสอบ 2'),
(121, 5, 'เอกซเรย์ปอดและหัวใจ', 'Chest X-Ray', 2, 'ทดสอบ 2'),
(122, 6, 'ตรวจปัสสาวะ', 'Urine Examination', 2, 'ทดสอบ 2'),
(123, 7, 'ตรวจอุจจาระ', 'Stool simple sedimen', 2, 'ทดสอบ 2'),
(124, 4, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys', 5, 'ทดสอบ 3 '),
(125, 5, 'เอกซเรย์ปอดและหัวใจ', 'Chest X-Ray', 5, 'ทดสอบ 3 '),
(126, 6, 'ตรวจปัสสาวะ', 'Urine Examination', 5, 'ทดสอบ 3 '),
(127, 7, 'ตรวจอุจจาระ', 'Stool simple sedimen', 5, 'ทดสอบ 3 '),
(128, 15, 'ความสมบูรณ์ของเม็ดเลือด', 'complete Blood Count', 5, 'ทดสอบ 3 '),
(129, 4, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys', 9, 'ตรวจประจำปี 1'),
(130, 5, 'เอกซเรย์ปอดและหัวใจ', 'Chest X-Ray', 9, 'ตรวจประจำปี 1'),
(131, 6, 'ตรวจปัสสาวะ', 'Urine Examination', 9, 'ตรวจประจำปี 1'),
(132, 7, 'ตรวจอุจจาระ', 'Stool simple sedimen', 9, 'ตรวจประจำปี 1'),
(133, 15, 'ความสมบูรณ์ของเม็ดเลือด', 'complete Blood Count', 9, 'ตรวจประจำปี 1'),
(134, 16, 'ตรวจน้ำตาลในเลือด', 'Fasting Blood Sugar', 9, 'ตรวจประจำปี 1'),
(135, 17, 'ตรวจไขมันในเลือด', 'Lipid Profile', 9, 'ตรวจประจำปี 1'),
(136, 18, 'ตรวจไขมันในเลือด(คลอเรสเตอรอล)', 'Cholesterol', 9, 'ตรวจประจำปี 1'),
(137, 19, 'ตรวจไขมันในเลือด(ไขมันไตรกลีเซอไรด์)', 'Triglyceride', 9, 'ตรวจประจำปี 1'),
(138, 20, 'ตรวจไขมันในเลือด(ไขมันตัวดี)', 'HDL', 9, 'ตรวจประจำปี 1'),
(139, 21, 'ตรวจไขมันในเลือด(ไขมันตัวร้าย)', 'LDL Cholesterrol', 9, 'ตรวจประจำปี 1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `phone` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` varchar(10) NOT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `phone`, `time`, `role`, `profile_picture`) VALUES
(112, 'kle', 112233, '2024-01-24 04:50:30', 'user', 'uploads/3_-_ข_ขวด_Thai_Alphabets.jpg'),
(123, '่่jj', 123, '2024-01-18 03:17:38', 'user', 'uploads/20201217_thaigov_ประยุทธ์-จันทร์โอชา_IMG_20201217131039000000-1024x681.jpg'),
(555, 'kk', 555, '2024-01-18 05:31:13', 'user', 'uploads/3_-_ข_ขวด_Thai_Alphabets.jpg'),
(1921, 'gemmy', 1921, '2024-01-15 05:44:45', 'user', 'uploads/20201217_thaigov_ประยุทธ์-จันทร์โอชา_IMG_20201217131039000000-1024x681.jpg'),
(112233, 'pp', 112233, '2024-01-15 07:16:05', 'admin', 'uploads/20201217_thaigov_ประยุทธ์-จันทร์โอชา_IMG_20201217131039000000-1024x681.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_gmail`
--

CREATE TABLE `users_gmail` (
  `id` int(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_id` int(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_gmail`
--

INSERT INTO `users_gmail` (`id`, `email`, `user_id`, `date`) VALUES
(45, '', 1921, '2024-01-18 06:55:58'),
(46, '', 1921, '2024-01-18 06:57:39'),
(47, '', 1921, '2024-01-18 06:58:05'),
(48, '', 1921, '2024-01-18 06:58:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_checkup`
--

CREATE TABLE `user_checkup` (
  `id` int(20) NOT NULL,
  `user_id` int(18) NOT NULL,
  `name` varchar(255) NOT NULL,
  `checkup_level` varchar(255) NOT NULL,
  `id_topic` int(10) NOT NULL,
  `check_up_times` int(10) NOT NULL,
  `checkup_subject` varchar(255) NOT NULL,
  `checkup_details` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_checkup`
--

INSERT INTO `user_checkup` (`id`, `user_id`, `name`, `checkup_level`, `id_topic`, `check_up_times`, `checkup_subject`, `checkup_details`, `date`) VALUES
(289, 123, '่่jj', 'executive check', 4, 2, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys', '2024-02-07 02:50:45'),
(290, 123, '่่jj', 'executive check', 5, 2, 'เอกซเรย์ปอดและหัวใจ', 'Chest X-Ray', '2024-02-07 02:50:46'),
(291, 123, '่่jj', 'executive check', 6, 2, 'ตรวจปัสสาวะ', 'Urine Examination', '2024-02-07 02:50:46'),
(292, 123, '่่jj', 'executive check', 4, 1, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys', '2024-02-07 02:50:55'),
(293, 123, '่่jj', 'executive check', 5, 1, 'เอกซเรย์ปอดและหัวใจ', 'Chest X-Ray', '2024-02-07 02:50:55'),
(294, 123, '่่jj', 'executive check', 6, 1, 'ตรวจปัสสาวะ', 'Urine Examination', '2024-02-07 02:50:55'),
(295, 123, '่่jj', 'executive check', 7, 1, 'ตรวจอุจจาระ', 'Stool simple sedimen', '2024-02-07 02:50:55'),
(296, 123, '่่jj', 'executive check', 15, 1, 'ความสมบูรณ์ของเม็ดเลือด', 'complete Blood Count', '2024-02-07 02:50:55'),
(297, 555, 'kk', 'executive check', 4, 2, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys', '2024-02-07 02:58:19'),
(298, 555, 'kk', 'executive check', 4, 1, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys', '2024-02-07 02:58:24'),
(299, 555, 'kk', 'executive check', 5, 1, 'เอกซเรย์ปอดและหัวใจ', 'Chest X-Ray', '2024-02-08 02:54:41'),
(300, 555, 'kk', 'executive check', 4, 5, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys', '2024-02-07 03:52:14'),
(301, 555, 'kk', 'executive check', 5, 5, 'เอกซเรย์ปอดและหัวใจ', 'Chest X-Ray', '2024-02-07 03:52:14'),
(302, 555, 'kk', 'executive check', 6, 5, 'ตรวจปัสสาวะ', 'Urine Examination', '2024-02-08 02:54:56'),
(309, 112233, 'pp', 'basic check', 7, 2, 'ตรวจอุจจาระ', 'Stool simple sedimen', '2024-02-12 04:28:25'),
(313, 112233, 'pp', 'basic check', 4, 9, 'รับการตรวจร่างกายจาก', 'Vital Signs and Phys', '2024-02-12 04:28:39'),
(314, 112233, 'pp', 'basic check', 5, 9, 'เอกซเรย์ปอดและหัวใจ', 'Chest X-Ray', '2024-02-12 04:28:39'),
(315, 112233, 'pp', 'basic check', 6, 9, 'ตรวจปัสสาวะ', 'Urine Examination', '2024-02-12 04:28:39'),
(316, 112233, 'pp', 'basic check', 7, 9, 'ตรวจอุจจาระ', 'Stool simple sedimen', '2024-02-12 04:28:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id_appointment`);

--
-- Indexes for table `chronic_disease_info`
--
ALTER TABLE `chronic_disease_info`
  ADD PRIMARY KEY (`id_chronic`);

--
-- Indexes for table `general_info`
--
ALTER TABLE `general_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `google_fit_steps`
--
ALTER TABLE `google_fit_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `health_checkup`
--
ALTER TABLE `health_checkup`
  ADD PRIMARY KEY (`id_topic`);

--
-- Indexes for table `set_test`
--
ALTER TABLE `set_test`
  ADD PRIMARY KEY (`id_test_set`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_gmail`
--
ALTER TABLE `users_gmail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_checkup`
--
ALTER TABLE `user_checkup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id_appointment` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `chronic_disease_info`
--
ALTER TABLE `chronic_disease_info`
  MODIFY `id_chronic` int(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `general_info`
--
ALTER TABLE `general_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `google_fit_steps`
--
ALTER TABLE `google_fit_steps`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=996;

--
-- AUTO_INCREMENT for table `health_checkup`
--
ALTER TABLE `health_checkup`
  MODIFY `id_topic` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `set_test`
--
ALTER TABLE `set_test`
  MODIFY `id_test_set` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112235;

--
-- AUTO_INCREMENT for table `users_gmail`
--
ALTER TABLE `users_gmail`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `user_checkup`
--
ALTER TABLE `user_checkup`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=317;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
