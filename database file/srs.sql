-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 09:27 PM
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
-- Database: `srs`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_periods`
--

CREATE TABLE `academic_periods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `semester` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','inactive','completed') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_periods`
--

INSERT INTO `academic_periods` (`id`, `semester`, `academic_year`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2024, '2024-01-08', '2024-05-31', 'completed', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(2, 2, 2024, '2024-06-01', '2024-10-31', 'completed', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(3, 1, 2025, '2025-01-08', '2025-05-31', 'completed', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(4, 2, 2025, '2025-06-01', '2025-10-31', 'active', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(5, 1, 2026, '2026-01-08', '2026-05-31', 'active', '2026-06-08 00:52:56', '2026-06-08 00:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late','excused') NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `academic_period_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `sub_field` varchar(255) DEFAULT NULL,
  `credits` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub_field_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `course_code`, `department`, `sub_field`, `credits`, `created_at`, `updated_at`, `sub_field_id`) VALUES
(1, 'Introduction to Nursing', 'NUR101', 'Nursing', 'Basic Nursing', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 1),
(2, 'Medical-Surgical Nursing', 'NUR201', 'Nursing', 'Clinical Nursing', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 2),
(3, 'Human Anatomy', 'MED101', 'Medicine', 'Basic Sciences', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 3),
(4, 'Pathology', 'MED201', 'Medicine', 'Clinical Medicine', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 4),
(5, 'Public Health Fundamentals', 'PH101', 'Public Health', 'Public Health', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 67),
(6, 'Epidemiology', 'PH201', 'Public Health', 'Disease Prevention', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 68),
(7, 'Introduction to Informatics', 'INF101', 'Informatics', 'Computer Fundamentals', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 5),
(8, 'Database Systems', 'INF201', 'Informatics', 'Software Development', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 6),
(9, 'Electrical Engineering Fundamentals', 'EE101', 'Electrical Engineering', 'Circuits', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 9),
(10, 'Digital Systems', 'EE201', 'Electrical Engineering', 'Electronics', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 10),
(11, 'Engineering Mechanics', 'ME101', 'Mechanical Engineering', 'Mechanics', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 11),
(12, 'Thermodynamics', 'ME201', 'Mechanical Engineering', 'Energy Systems', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 12),
(13, 'Engineering Materials', 'CE101', 'Civil Engineering', 'Materials', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 13),
(14, 'Structural Analysis', 'CE201', 'Civil Engineering', 'Structures', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 14),
(15, 'Programming Fundamentals', 'CSE101', 'Computer Science', 'Programming', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 7),
(16, 'Data Structures', 'CSE201', 'Computer Science', 'Algorithms', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 8),
(17, 'Introduction to Psychology', 'PSY101', 'Psychology', 'General Psychology', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 15),
(18, 'Clinical Psychology', 'PSY201', 'Psychology', 'Clinical Practice', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 16),
(19, 'Sociology Fundamentals', 'SOC101', 'Sociology', 'Social Theory', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 17),
(20, 'Social Research Methods', 'SOC201', 'Sociology', 'Research Methods', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 18),
(21, 'Introduction to Political Science', 'POS101', 'Political Science', 'Political Theory', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 19),
(22, 'International Relations', 'POS201', 'Political Science', 'Global Politics', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 20),
(23, 'Microeconomics', 'ECO101', 'Economics', 'Microeconomics', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 21),
(24, 'Macroeconomics', 'ECO201', 'Economics', 'Macroeconomics', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 22),
(25, 'General Biology', 'BIO101', 'Biology', 'Cell Biology', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 23),
(26, 'Molecular Biology', 'BIO201', 'Biology', 'Molecular Biology', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 24),
(27, 'General Chemistry', 'CHE101', 'Chemistry', 'Organic Chemistry', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 25),
(28, 'Analytical Chemistry', 'CHE201', 'Chemistry', 'Analytical Methods', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 26),
(29, 'Physics I', 'PHY101', 'Physics', 'Classical Physics', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 27),
(30, 'Physics II', 'PHY201', 'Physics', 'Modern Physics', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 28),
(31, 'Environmental Science Fundamentals', 'ENV101', 'Environmental Science', 'Ecology', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 29),
(32, 'Environmental Management', 'ENV201', 'Environmental Science', 'Conservation', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 30),
(33, 'Introduction to Business', 'BUS101', 'Business', 'Business Fundamentals', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 31),
(34, 'Business Strategy', 'BUS201', 'Business', 'Strategy', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 32),
(35, 'Financial Accounting', 'ACC101', 'Accounting', 'Financial Reporting', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 33),
(36, 'Management Accounting', 'ACC201', 'Accounting', 'Cost Analysis', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 34),
(37, 'Corporate Finance', 'FIN101', 'Finance', 'Financial Management', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 35),
(38, 'Investment Analysis', 'FIN201', 'Finance', 'Investments', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 36),
(39, 'Marketing Principles', 'MKT101', 'Marketing', 'Marketing Strategy', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 37),
(40, 'Digital Marketing', 'MKT201', 'Marketing', 'Digital Strategy', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 38),
(41, 'Management Principles', 'MGT101', 'Management', 'Organizational Management', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 39),
(42, 'Human Resource Management', 'MGT201', 'Management', 'HR Strategy', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 40),
(43, 'Introduction to Literature', 'LIT101', 'Literature', 'Literary Analysis', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 41),
(44, 'World Literature', 'LIT201', 'Literature', 'Comparative Literature', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 42),
(45, 'World History', 'HIS101', 'History', 'World Events', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 43),
(46, 'Modern History', 'HIS201', 'History', 'Contemporary History', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 44),
(47, 'Introduction to Philosophy', 'PHI101', 'Philosophy', 'Philosophical Thinking', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 45),
(48, 'Ethics', 'PHI201', 'Philosophy', 'Moral Philosophy', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 46),
(49, 'Fine Arts Fundamentals', 'ART101', 'Fine Arts', 'Art Theory', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 47),
(50, 'Contemporary Art', 'ART201', 'Fine Arts', 'Modern Art', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 48),
(51, 'Language Studies', 'LNG101', 'Languages', 'Linguistics', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 49),
(52, 'Translation Studies', 'LNG201', 'Languages', 'Applied Languages', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 50),
(53, 'Calculus I', 'MATH101', 'Mathematics', 'Calculus', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 51),
(54, 'Linear Algebra', 'MATH201', 'Mathematics', 'Algebra', 4, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 52),
(55, 'Statistics Fundamentals', 'STAT101', 'Statistics', 'Descriptive Statistics', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 53),
(56, 'Inferential Statistics', 'STAT201', 'Statistics', 'Hypothesis Testing', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 54),
(57, 'Applied Mathematics I', 'AMATH101', 'Applied Mathematics', 'Numerical Methods', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 55),
(58, 'Applied Mathematics II', 'AMATH201', 'Applied Mathematics', 'Optimization', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 56),
(59, 'Introduction to Law', 'LAW101', 'Law', 'Legal Principles', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 57),
(60, 'Constitutional Law', 'LAW201', 'Law', 'Constitutional Studies', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 58),
(61, 'Educational Theory', 'EDU101', 'Education', 'Pedagogy', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 59),
(62, 'Curriculum Development', 'EDU201', 'Education', 'Instructional Design', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 60),
(63, 'Agricultural Fundamentals', 'AGR101', 'Agriculture', 'Crop Science', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 61),
(64, 'Soil Science', 'AGR201', 'Agriculture', 'Soil Management', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 62),
(65, 'Engineering Field Fundamentals', 'ENG101', 'Engineering Field', 'General Engineering', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 63),
(66, 'Professional Practice', 'ENG201', 'Engineering Field', 'Engineering Ethics', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 64),
(67, 'Health Administration Basics', 'HAD101', 'Health Academic', 'Healthcare Management', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 65),
(68, 'Health Policy', 'HAD201', 'Health Academic', 'Policy Studies', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 66),
(69, 'Introduction to Social Science', 'SS101', 'Social Science', 'Social Theory', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 69),
(70, 'Research Methods', 'SS201', 'Social Science', 'Methodology', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 70),
(71, 'Natural Science Overview', 'NS101', 'Natural Science', 'Science Foundations', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 71),
(72, 'Scientific Methods', 'NS201', 'Natural Science', 'Research Techniques', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 72),
(73, 'Other Studies I', 'OTH101', 'Other', 'General Studies', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 73),
(74, 'Other Studies II', 'OTH201', 'Other', 'Special Topics', 3, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 74);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `department_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `department_code`, `created_at`, `updated_at`) VALUES
(1, 'Health Academic', 'Health and Medical Sciences', 'HA', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(2, 'Nursing', 'Nursing and Healthcare', 'NUR', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(3, 'Medicine', 'Medical Sciences', 'MED', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(4, 'Public Health', 'Public Health and Epidemiology', 'PH', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(5, 'Informatics', 'Information Technology', 'INF', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(6, 'Computer Science', 'Computer Science and Programming', 'CS', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(7, 'Electrical Engineering', 'Electrical Engineering', 'EE', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(8, 'Mechanical Engineering', 'Mechanical Engineering', 'ME', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(9, 'Civil Engineering', 'Civil Engineering', 'CE', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(10, 'Engineering Field', 'General Engineering', 'EF', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(11, 'Psychology', 'Psychology and Behavior', 'PSY', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(12, 'Sociology', 'Sociology and Social Studies', 'SOC', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(13, 'Political Science', 'Political Science', 'POS', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(14, 'Economics', 'Economics and Finance', 'ECO', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(15, 'Biology', 'Biology and Life Sciences', 'BIO', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(16, 'Chemistry', 'Chemistry', 'CHE', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(17, 'Physics', 'Physics', 'PHY', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(18, 'Environmental Science', 'Environmental Science', 'ENV', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(19, 'Business', 'Business Administration', 'BUS', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(20, 'Accounting', 'Accounting and Finance', 'ACC', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(21, 'Finance', 'Finance and Investment', 'FIN', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(22, 'Marketing', 'Marketing', 'MKT', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(23, 'Management', 'Business Management', 'MGT', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(24, 'Literature', 'Literature and Language Arts', 'LIT', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(25, 'History', 'History', 'HIS', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(26, 'Philosophy', 'Philosophy', 'PHI', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(27, 'Fine Arts', 'Fine Arts and Design', 'ART', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(28, 'Languages', 'Languages and Linguistics', 'LNG', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(29, 'Mathematics', 'Mathematics', 'MAT', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(30, 'Statistics', 'Statistics', 'STA', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(31, 'Applied Mathematics', 'Applied Mathematics', 'AMAT', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(32, 'Law', 'Law', 'LAW', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(33, 'Education', 'Education', 'EDU', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(34, 'Agriculture', 'Agriculture', 'AGR', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(35, 'Social Science', 'Social Sciences', 'SS', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(36, 'Natural Science', 'Natural Sciences', 'NS', '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(37, 'Other', 'Other Programs', 'OTH', '2026-06-08 00:52:56', '2026-06-08 00:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `semester` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `academic_period_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `semester` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `status` enum('draft','submitted') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `academic_period_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `course_id`, `grade`, `teacher_id`, `semester`, `academic_year`, `status`, `created_at`, `updated_at`, `academic_period_id`) VALUES
(3, 29, 8, 'A-', 9, 1, 2026, 'submitted', '2026-06-20 06:26:50', '2026-06-20 06:27:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(58, '2026_04_28_173723_create_users_table', 1),
(59, '2026_04_28_173741_create_courses_table', 1),
(60, '2026_04_28_173749_create_grades_table', 1),
(61, '2026_04_28_173752_create_attendances_table', 1),
(62, '2026_05_04_083318_create_enrollments_table', 1),
(63, '2026_05_04_092024_add_status_to_grades_table', 1),
(64, '2026_05_04_123240_create_teacher_courses_table', 1),
(65, '2026_05_04_131355_add_sub_field_to_courses_table', 1),
(66, '2026_06_08_000000_create_student_teacher_assignments_table', 1),
(67, '2026_06_08_000100_create_departments_table', 1),
(68, '2026_06_08_000200_create_sub_fields_table', 1),
(69, '2026_06_08_000300_create_academic_periods_table', 1),
(70, '2026_06_08_000400_add_3nf_foreign_keys', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_teacher_assignments`
--

CREATE TABLE `student_teacher_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_teacher_assignments`
--

INSERT INTO `student_teacher_assignments` (`id`, `student_id`, `teacher_id`, `assigned_by`, `created_at`, `updated_at`) VALUES
(3, 27, 19, 4, '2026-06-20 05:34:08', '2026-06-20 05:34:08'),
(4, 28, 25, 4, '2026-06-20 05:37:30', '2026-06-20 05:37:30'),
(5, 29, 9, 4, '2026-06-20 06:12:42', '2026-06-20 06:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `sub_fields`
--

CREATE TABLE `sub_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_fields`
--

INSERT INTO `sub_fields` (`id`, `name`, `department_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Basic Nursing', 2, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(2, 'Clinical Nursing', 2, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(3, 'Basic Sciences', 3, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(4, 'Clinical Medicine', 3, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(5, 'Computer Fundamentals', 5, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(6, 'Software Development', 5, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(7, 'Programming', 6, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(8, 'Algorithms', 6, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(9, 'Circuits', 7, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(10, 'Electronics', 7, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(11, 'Mechanics', 8, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(12, 'Energy Systems', 8, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(13, 'Materials', 9, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(14, 'Structures', 9, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(15, 'General Psychology', 11, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(16, 'Clinical Practice', 11, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(17, 'Social Theory', 12, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(18, 'Research Methods', 12, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(19, 'Political Theory', 13, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(20, 'Global Politics', 13, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(21, 'Microeconomics', 14, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(22, 'Macroeconomics', 14, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(23, 'Cell Biology', 15, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(24, 'Molecular Biology', 15, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(25, 'Organic Chemistry', 16, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(26, 'Analytical Methods', 16, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(27, 'Classical Physics', 17, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(28, 'Modern Physics', 17, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(29, 'Ecology', 18, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(30, 'Conservation', 18, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(31, 'Business Fundamentals', 19, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(32, 'Strategy', 19, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(33, 'Financial Reporting', 20, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(34, 'Cost Analysis', 20, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(35, 'Financial Management', 21, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(36, 'Investments', 21, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(37, 'Marketing Strategy', 22, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(38, 'Digital Strategy', 22, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(39, 'Organizational Management', 23, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(40, 'HR Strategy', 23, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(41, 'Literary Analysis', 24, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(42, 'Comparative Literature', 24, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(43, 'World Events', 25, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(44, 'Contemporary History', 25, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(45, 'Philosophical Thinking', 26, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(46, 'Moral Philosophy', 26, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(47, 'Art Theory', 27, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(48, 'Modern Art', 27, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(49, 'Linguistics', 28, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(50, 'Applied Languages', 28, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(51, 'Calculus', 29, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(52, 'Algebra', 29, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(53, 'Descriptive Statistics', 30, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(54, 'Hypothesis Testing', 30, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(55, 'Numerical Methods', 31, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(56, 'Optimization', 31, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(57, 'Legal Principles', 32, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(58, 'Constitutional Studies', 32, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(59, 'Pedagogy', 33, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(60, 'Instructional Design', 33, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(61, 'Crop Science', 34, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(62, 'Soil Management', 34, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(63, 'General Engineering', 10, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(64, 'Engineering Ethics', 10, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(65, 'Healthcare Management', 1, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(66, 'Policy Studies', 1, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(67, 'Public Health', 4, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(68, 'Disease Prevention', 4, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(69, 'Social Theory', 35, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(70, 'Methodology', 35, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(71, 'Science Foundations', 36, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(72, 'Research Techniques', 36, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(73, 'General Studies', 37, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56'),
(74, 'Special Topics', 37, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_courses`
--

CREATE TABLE `teacher_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `list_no` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student','registrar') NOT NULL DEFAULT 'student',
  `department` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `list_no`, `first_name`, `last_name`, `email`, `password`, `role`, `department`, `year`, `profile_image`, `remember_token`, `created_at`, `updated_at`, `department_id`) VALUES
(1, 'ADM2024001', 'System', 'Admin', 'admin@example.com', '$2y$12$.w9tGTTG4NP7Wf5d4dt.uuFPKKFE7F9ZgVfDQ7aLPyMVZnNRpDZD.', 'admin', 'Administration', NULL, NULL, NULL, '2026-06-08 00:52:56', '2026-06-08 00:52:56', 37),
(4, 'REG2024001', 'Mary', 'Johnson', 'registrar@example.com', '$2y$12$H2wXp6W05d2Oj0Mmmo6uyOhe/7dZhw/pqfv1gQ6QKlATeTJ7sxbCK', 'registrar', 'Registrar Office', NULL, NULL, NULL, '2026-06-08 00:52:57', '2026-06-08 00:52:57', 37),
(6, 'TEA20260001', 'Selemon', 'Bogale', 'SB@example.com', '$2y$12$NjyVzhd/qH0WgOj0GXYEG.n/Q2Xr8kFHWeEObDCgThmizRs0VPiPe', 'teacher', 'Mechanical Engineering', NULL, NULL, NULL, '2026-06-08 01:05:15', '2026-06-08 01:05:15', NULL),
(7, 'TEA20260002', 'Degu', 'Debebe', 'DD@example.com', '$2y$12$WEvxOcFTkuQR7pXe3SiXmuixZHw3f6T2FuX65KpE.ThWfhTI1n5ku', 'teacher', 'Civil Engineering', NULL, NULL, NULL, '2026-06-08 01:06:40', '2026-06-08 01:06:40', NULL),
(8, 'TEA20260003', 'Selam', 'Metiku', 'SM@example.com', '$2y$12$kh58w7cfUtg7oUB0Lw.FxOHsMfyk41eWJkHoTvuopeaGBai4EhkY2', 'teacher', 'Psychology', NULL, NULL, NULL, '2026-06-08 01:07:36', '2026-06-08 01:07:36', NULL),
(9, 'TEA20260004', 'Derartu', 'Lema', 'DL@example.com', '$2y$12$xajOqu0Xuo98emorc/Yax..fe5V3jx6432nCGluMYdHDwGpgXUmCC', 'teacher', 'Computer Science', NULL, NULL, NULL, '2026-06-08 01:09:08', '2026-06-08 01:09:08', NULL),
(13, 'STU20260002', 'selam', 'Alemu', 'group-freshman-STU20260002@local.test', '$2y$12$o.CGeSYE6OicK6xhrKjKX.2GIzlC/RPOVBFDEWq8.TuhxTTOS3Ju2', 'student', 'Natural Science', 1, 'student_images/vLFP4E2P5DXkl13nuAo1i5wCGPiyZ66eKxQ364bB.jpg', NULL, '2026-06-13 18:50:50', '2026-06-13 18:50:50', NULL),
(14, 'STU20260003', 'bereket', 'selemon', 'group-freshman-STU20260003@local.test', '$2y$12$bnLx5rwtrKbNQj0tUoRrluCm5YtqP.UyabjXgT0W5JqbxNRojiO3a', 'student', 'Natural Science', 1, 'student_images/ZnH8JBt0cHBsYOBbb7krnY1RwbGzwIXH3eVlSRf7.jpg', NULL, '2026-06-13 20:01:45', '2026-06-13 20:01:45', NULL),
(15, 'STU20260004', 'Selam', 'Salemon', 'SS@example.com', '$2y$12$l91tRyCUhYLij4b23mBUpOdoOBjZul.SX1ArbgzjwcoHR1qBNR9Gy', 'student', 'Business', 2, 'student_images/4NlTJkKAQu45so0jJi44JzErJPR9b0CxPoHhyiUP.jpg', NULL, '2026-06-18 05:56:41', '2026-06-18 05:56:41', NULL),
(16, 'STU20260005', 'abel', 'degu', 'group-freshman-STU20260005@local.test', '$2y$12$mSxnYrITFgvbWznsTQ4/UOJMoVPQwTJpxZC/rlQJaTHaxVOiBKqaS', 'student', 'Natural Science', 1, 'student_images/xp0ZDk1frjx4P8vtrht7qBRB4YZffItMIg7nX6Oe.jpg', NULL, '2026-06-20 05:10:10', '2026-06-20 05:10:10', NULL),
(17, 'STU20260006', 'lemi', 'mamo', 'group-remedial-STU20260006@local.test', '$2y$12$fljjM2BuKpk2B0.Y9yO29e1yosZYjFRvne2Hnv05TxW089W0GiUcu', 'student', 'Remedial', 2, 'student_images/fdf9aqwpenkw6AOKQjxVOUYDVD50qfGVGeg2XUsf.jpg', NULL, '2026-06-20 05:11:15', '2026-06-20 05:11:15', NULL),
(18, 'STU20260007', 'degu', 'temam', 'group-remedial-STU20260007@local.test', '$2y$12$bUrPGlcKEXwSYebOWpshb.RD2fRUUD4CRRJbpLYUyTdyOIAJCb/BG', 'student', 'Remedial', 2, 'student_images/gY4uHFIPJg3UT5BvfokzcpjU8cQkh9nRom1Kh0z7.jpg', NULL, '2026-06-20 05:14:22', '2026-06-20 05:14:22', NULL),
(19, 'TEA20260005', 'Tesema', 'Boku', 'TB@example.com', '$2y$12$.k1KEQayH2g1Sek4T92Ju.1z7pZLVBQ1GecXelORGO66bKcSkP0XG', 'teacher', 'Law', NULL, NULL, NULL, '2026-06-20 05:20:51', '2026-06-20 05:20:51', NULL),
(20, 'TEA20260006', 'BETI', 'Kebede', 'BK@example.com', '$2y$12$SCKwbg6JHAbMG1XylodrS.RgSfbfUnXp13DeiZOGCkryrJoOMLZL2', 'teacher', 'Agriculture', NULL, NULL, NULL, '2026-06-20 05:21:55', '2026-06-20 05:21:55', NULL),
(21, 'TEA20260007', 'Kemal', 'Gemal', 'KG@example.com', '$2y$12$ZNvU5Aql48D/NoqMkkBPlujNMob0xBaIzKRl6xhDfic/FWsZ0yNha', 'teacher', 'Chemistry', NULL, NULL, NULL, '2026-06-20 05:23:04', '2026-06-20 05:23:04', NULL),
(22, 'TEA20260008', 'chulo', 'chamsa', 'CC@example.com', '$2y$12$yRbcqIIi1nAIoJOuTXAy6.hG0yKmzXKmwozMoDEeVb1WVIKJBUlhy', 'teacher', 'Public Health', NULL, NULL, NULL, '2026-06-20 05:24:24', '2026-06-20 05:24:24', NULL),
(23, 'TEA20260009', 'redi', 'dagos', 'RD@example.com', '$2y$12$DOpcmRZ.rvv/Sn4pNIsHheZKsIURsLSqS3FR4EtH1oXTth1Xsrv5O', 'teacher', 'Law', NULL, NULL, NULL, '2026-06-20 05:25:14', '2026-06-20 05:25:14', NULL),
(24, 'TEA20260010', 'debele', 'chamso', 'DC@example.com', '$2y$12$uUr1zcis4PZSNF5iJo.NR.0ZdWdPMiLBRPcsu4oQk/wM22C785uEy', 'teacher', 'Electrical Engineering', NULL, NULL, NULL, '2026-06-20 05:26:29', '2026-06-20 05:26:29', NULL),
(25, 'TEA20260011', 'kefe', 'dubale', 'KD@example.com', '$2y$12$StEJG8MpqUR0zk26yBF6KegqVM81vkvV/KJoFXhNbYcTluxg1.6ci', 'teacher', 'Philosophy', NULL, NULL, NULL, '2026-06-20 05:28:01', '2026-06-20 05:28:01', NULL),
(26, 'TEA20260012', 'biruk', 'kedir', 'BiK@example.com', '$2y$12$WNEQ5Mf9vovj8ViSdpLZVuGMmMNASnOcYEss8AyfCRPbk1uGNXUwK', 'teacher', 'Accounting', NULL, NULL, NULL, '2026-06-20 05:29:39', '2026-06-20 05:29:39', NULL),
(27, 'STU20260008', 'biniyam', 'kasu', 'Bek@example.com', '$2y$12$lo4zVViYpvzTDwlizuVvfugohXWhFet1XPU.KKlX9DSLnbh5GCmpi', 'student', 'Law', 2, 'student_images/KcnMjEKIW2fjMkBelcAqZSF46f96YIe3vBX3YKEU.jpg', NULL, '2026-06-20 05:34:08', '2026-06-20 05:34:08', NULL),
(28, 'STU20260009', 'fenet', 'germa', 'FG@example.com', '$2y$12$m7gCgohNhfSxARhfywNNceAWQB2WOhhr2Rt9tmK0.XEKgVIqYZQHO', 'student', 'Philosophy', 3, 'student_images/gC7qEAvNvHRuLSQGFScfF88JgpR6Y1nV2Magc5cn.jpg', NULL, '2026-06-20 05:37:29', '2026-06-20 05:37:29', NULL),
(29, 'STU20260010', 'kaleb', 'belay', 'KB@example.com', '$2y$12$H3/pOIWG/Pjl8Q.qu3a8bOAQSfXdlV5D0/IEcTJKTaKNilpiDkZwS', 'student', 'Computer Science', 2, 'student_images/kA1EeEoBiHCAThgKIdRMBNcsEHJN3ewPyfH5dX9u.jpg', NULL, '2026-06-20 06:12:42', '2026-06-20 06:12:42', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_periods`
--
ALTER TABLE `academic_periods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `academic_periods_semester_academic_year_unique` (`semester`,`academic_year`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_student_id_foreign` (`student_id`),
  ADD KEY `attendances_course_id_foreign` (`course_id`),
  ADD KEY `attendances_teacher_id_foreign` (`teacher_id`),
  ADD KEY `attendances_academic_period_id_foreign` (`academic_period_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_course_code_unique` (`course_code`),
  ADD KEY `courses_sub_field_id_foreign` (`sub_field_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`),
  ADD UNIQUE KEY `departments_department_code_unique` (`department_code`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollments_student_id_course_id_semester_academic_year_unique` (`student_id`,`course_id`,`semester`,`academic_year`),
  ADD KEY `enrollments_course_id_foreign` (`course_id`),
  ADD KEY `enrollments_academic_period_id_foreign` (`academic_period_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_student_id_foreign` (`student_id`),
  ADD KEY `grades_course_id_foreign` (`course_id`),
  ADD KEY `grades_teacher_id_foreign` (`teacher_id`),
  ADD KEY `grades_academic_period_id_foreign` (`academic_period_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_teacher_assignments`
--
ALTER TABLE `student_teacher_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_teacher_assignments_student_id_teacher_id_unique` (`student_id`,`teacher_id`),
  ADD KEY `student_teacher_assignments_teacher_id_foreign` (`teacher_id`),
  ADD KEY `student_teacher_assignments_assigned_by_foreign` (`assigned_by`);

--
-- Indexes for table `sub_fields`
--
ALTER TABLE `sub_fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_fields_name_department_id_unique` (`name`,`department_id`),
  ADD KEY `sub_fields_department_id_foreign` (`department_id`);

--
-- Indexes for table `teacher_courses`
--
ALTER TABLE `teacher_courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_courses_teacher_id_course_id_unique` (`teacher_id`,`course_id`),
  ADD KEY `teacher_courses_course_id_foreign` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_list_no_unique` (`list_no`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_department_id_foreign` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_periods`
--
ALTER TABLE `academic_periods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `student_teacher_assignments`
--
ALTER TABLE `student_teacher_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sub_fields`
--
ALTER TABLE `sub_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `teacher_courses`
--
ALTER TABLE `teacher_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_academic_period_id_foreign` FOREIGN KEY (`academic_period_id`) REFERENCES `academic_periods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `attendances_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_sub_field_id_foreign` FOREIGN KEY (`sub_field_id`) REFERENCES `sub_fields` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_academic_period_id_foreign` FOREIGN KEY (`academic_period_id`) REFERENCES `academic_periods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_academic_period_id_foreign` FOREIGN KEY (`academic_period_id`) REFERENCES `academic_periods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `grades_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_teacher_assignments`
--
ALTER TABLE `student_teacher_assignments`
  ADD CONSTRAINT `student_teacher_assignments_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_teacher_assignments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_teacher_assignments_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_fields`
--
ALTER TABLE `sub_fields`
  ADD CONSTRAINT `sub_fields_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_courses`
--
ALTER TABLE `teacher_courses`
  ADD CONSTRAINT `teacher_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_courses_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
