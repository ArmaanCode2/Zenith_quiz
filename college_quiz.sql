-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2026 at 04:00 PM
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
-- Database: `college_quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(1, 'Which type of hazard occurs due to hardware resource conflict?', 'Data hazard', 'Control hazard', 'Structural hazard', 'Logical hazard', 'C'),
(2, 'The speed of a CPU is measured in:', 'Bytes', 'MIPS', 'Hertz', 'RPM', 'C'),
(3, 'Which of the following memories is fastest?', 'RAM', 'Cache', 'Register', 'Secondary memory', 'C'),
(4, 'Which method is used to access an element by its ID?', 'getElement()', 'getElementById()', 'getIdElement()', 'fetchElementById()', 'B'),
(5, 'Which JavaScript function is used to delay execution of code?', 'delay()', 'wait()', 'setTimeout()', 'pause()', 'C'),
(6, 'Which NVIDIA product is best suited for IoT and embedded systems?', 'Quadro RTX', 'NVIDIA Jetson', 'NVIDIA Tesla', 'GeForce GTX', 'B'),
(7, 'Arrange the generations of computers in the correct order.', 'Transistor → Vacuum Tube → IC → Microprocessor → AI', 'Vacuum Tube → Transistor → IC → Microprocessor → AI', 'IC → Transistor → Vacuum Tube → Microprocessor → AI', 'Vacuum Tube → IC → Transistor → Microprocessor → AI', 'B'),
(8, 'Which shortcut key opens File Explorer?', 'Ctrl + E', 'Alt + E', 'Windows + E', 'Ctrl + F', 'C'),
(9, 'Which memory stores the booting instructions?', 'RAM', 'Cache', 'Hard Disk', 'ROM', 'D'),
(10, 'What does DTP stand for?', 'Data Transfer Process', 'Desktop Text Program', 'Desktop Publishing', 'Digital Text Processing', 'C'),
(11, 'Which is an example of On-Page SEO?', 'Backlinks', 'Social media sharing', 'Keyword optimization', 'Guest posting', 'C'),
(12, 'CTR stands for:', 'Click Through Rate', 'Click-Through Run', 'Cost To Run', 'Campaign Traffic Ratio', 'B'),
(13, 'In hexadecimal number system, letters A–F represent:', '1–6', '5–10', '10–15', '11–16', 'C'),
(14, 'A bulb glows if the binary representation of its number contains an even number of 1s. How many bulbs glow from 1 to 7?', '2', '3', '4', '5', 'B'),
(15, 'Man-in-the-middle attack occurs when:', 'Attacker intercepts communication', 'System crashes', 'Network overloads', 'Password is guessed', 'A'),
(16, 'Which port is commonly used for HTTP traffic?', '21', '22', '80', '443', 'C'),
(17, 'Bluetooth operates in which frequency range?', '2.4 GHz – 2.485 GHz', '5 GHz – 5.5 GHz', '2.402 GHz – 2.48 GHz', '1.8 GHz – 2.2 GHz', 'C'),
(18, 'Which Wi-Fi standard introduced MU-MIMO?', '802.11n', '802.11ac', '802.11b', '802.11ax', 'D'),
(19, 'The mean of 6 numbers is 12. If one number is removed, the mean becomes 10. Find the removed number.', '8', '20', '22', '24', 'C'),
(20, 'Which of the following is a major feature of Web3?', 'Centralized servers', 'Decentralization using blockchain', 'HTTP-only websites', 'Cloud storage only', 'B'),
(21, 'Which of the following is a trending low-code/no-code platform?', 'TensorFlow', 'Bubble', 'Docker', 'GitHub', 'B'),
(22, 'Which company unveiled a space-based, quantum-resistant cryptocurrency system at Davos 2026?', 'IBM', 'Google', 'WISeKey', 'Microsoft', 'C'),
(23, 'At CES 2026, which sector was identified as seeing rapid AI adoption?', 'Food delivery', 'Manufacturing', 'Content creation, marketing, and media', 'Agriculture only', 'C'),
(24, 'A “content audit” is performed to:', 'Create new content', 'Analyze existing content for performance and gaps', 'Remove all old content', 'Increase ad spending', 'B'),
(25, "If in a certain code '268' means 'equality and prosperity', '839' means 'prosperity nasty position' and '361' means ' Equality respected position' , then for which word the digit '2' is used?", 'Respected', 'And', 'Prosperity', 'Equality', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `selected_option` char(1) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`id`, `user_name`, `question_id`, `selected_option`, `timestamp`, `is_correct`) VALUES
(1, 'Demo', 5, 'B', '2026-01-26 19:32:00', 0),
(2, 'Demo', 7, 'B', '2026-01-26 19:32:00', 1),
(3, 'Demo', 6, 'C', '2026-01-26 19:32:00', 0),
(4, 'Demo', 4, 'C', '2026-01-26 19:32:00', 0),
(5, 'Demo', 3, 'C', '2026-01-26 19:32:00', 1),
(6, 'Demo', 2, 'B', '2026-01-26 19:32:00', 0),
(7, 'DEMOOO', 1, 'A', '2026-01-26 19:43:34', 0),
(8, 'DEMOOO', 2, 'C', '2026-01-26 19:43:34', 1),
(9, 'DEMOOO', 3, 'C', '2026-01-26 19:43:34', 1),
(10, 'DEMOOO', 6, 'C', '2026-01-26 19:43:34', 0),
(11, 'DEMOOO', 5, 'B', '2026-01-26 19:43:34', 0),
(12, 'DEMOOO', 7, 'A', '2026-01-26 19:43:34', 0),
(13, 'DEMOOO', 4, 'B', '2026-01-26 19:43:34', 1),
(14, 'DEMOOO', 1, 'A', '2026-01-26 19:45:24', 0),
(15, 'DEMOOO', 2, 'C', '2026-01-26 19:45:24', 1),
(16, 'DEMOOO', 3, 'C', '2026-01-26 19:45:24', 1),
(17, 'DEMOOO', 6, 'C', '2026-01-26 19:45:24', 0),
(18, 'DEMOOO', 5, 'B', '2026-01-26 19:45:24', 0),
(19, 'DEMOOO', 7, 'A', '2026-01-26 19:45:24', 0),
(20, 'DEMOOO', 4, 'B', '2026-01-26 19:45:24', 1),
(21, 'DEMOOO', 1, 'A', '2026-01-26 19:45:48', 0),
(22, 'DEMOOO', 2, 'C', '2026-01-26 19:45:48', 1),
(23, 'DEMOOO', 3, 'C', '2026-01-26 19:45:48', 1),
(24, 'DEMOOO', 6, 'C', '2026-01-26 19:45:48', 0),
(25, 'DEMOOO', 5, 'B', '2026-01-26 19:45:48', 0),
(26, 'DEMOOO', 7, 'A', '2026-01-26 19:45:48', 0),
(27, 'DEMOOO', 4, 'B', '2026-01-26 19:45:48', 1),
(28, 'DEMOOO', 1, 'A', '2026-01-26 19:46:05', 0),
(29, 'DEMOOO', 2, 'C', '2026-01-26 19:46:05', 1),
(30, 'DEMOOO', 3, 'C', '2026-01-26 19:46:05', 1),
(31, 'DEMOOO', 6, 'C', '2026-01-26 19:46:05', 0),
(32, 'DEMOOO', 5, 'B', '2026-01-26 19:46:05', 0),
(33, 'DEMOOO', 7, 'A', '2026-01-26 19:46:05', 0),
(34, 'DEMOOO', 4, 'B', '2026-01-26 19:46:05', 1),
(35, '123', 4, 'C', '2026-01-26 19:46:55', 0),
(36, '123', 5, 'C', '2026-01-26 19:46:55', 1),
(37, '123', 1, 'D', '2026-01-26 19:46:55', 0),
(38, '123', 6, 'C', '2026-01-26 19:46:55', 0),
(39, '123', 7, 'D', '2026-01-26 19:46:55', 0),
(40, '123', 3, 'B', '2026-01-26 19:46:55', 0),
(41, '123', 2, 'B', '2026-01-26 19:46:55', 0),
(42, '123', 4, 'C', '2026-01-26 19:47:49', 0),
(43, '123', 5, 'C', '2026-01-26 19:47:49', 1),
(44, '123', 1, 'D', '2026-01-26 19:47:49', 0),
(45, '123', 6, 'C', '2026-01-26 19:47:49', 0),
(46, '123', 7, 'D', '2026-01-26 19:47:49', 0),
(47, '123', 3, 'B', '2026-01-26 19:47:49', 0),
(48, '123', 2, 'B', '2026-01-26 19:47:49', 0),
(49, 'JGHJGH', 1, 'B', '2026-01-26 19:48:18', 0),
(50, 'JGHJGH', 2, 'C', '2026-01-26 19:48:18', 1),
(51, 'JGHJGH', 5, 'A', '2026-01-26 19:48:18', 0),
(52, 'JGHJGH', 4, 'D', '2026-01-26 19:48:18', 0),
(53, 'JGHJGH', 3, 'B', '2026-01-26 19:48:18', 0),
(54, 'JGHJGH', 6, 'C', '2026-01-26 19:48:18', 0),
(55, 'JGHJGH', 7, 'B', '2026-01-26 19:48:18', 1),
(56, 'Demo', 15, 'C', '2026-01-26 20:14:28', 0),
(57, 'Demo', 2, 'D', '2026-01-26 20:14:28', 0),
(58, 'Demo', 21, 'D', '2026-01-26 20:14:28', 0),
(59, 'Demo', 4, 'A', '2026-01-26 20:14:28', 0),
(60, 'Demo', 1, 'A', '2026-01-26 20:14:28', 0),
(61, 'Demo', 13, 'C', '2026-01-26 20:14:28', 1),
(62, 'Demo', 20, 'C', '2026-01-26 20:14:28', 0),
(63, 'Demo', 17, 'A', '2026-01-26 20:14:28', 0),
(64, 'Demo', 25, 'A', '2026-01-26 20:14:28', 0),
(65, 'Demo', 3, 'A', '2026-01-26 20:14:28', 0),
(66, 'Demo', 6, 'C', '2026-01-26 20:14:28', 0),
(67, 'Demo', 18, 'C', '2026-01-26 20:14:28', 0),
(68, 'Demo', 22, 'A', '2026-01-26 20:14:28', 0),
(69, 'Demo', 24, 'C', '2026-01-26 20:14:28', 0),
(70, 'Demo', 10, 'B', '2026-01-26 20:14:28', 0),
(71, 'Demo', 8, 'D', '2026-01-26 20:14:28', 0),
(72, 'Demo', 7, 'D', '2026-01-26 20:14:28', 0),
(73, 'Demo', 11, 'A', '2026-01-26 20:14:28', 0),
(74, 'Demo', 9, 'C', '2026-01-26 20:14:28', 0),
(75, 'Demo', 5, 'D', '2026-01-26 20:14:28', 0),
(76, 'Demo', 19, 'C', '2026-01-26 20:14:28', 1),
(77, 'Demo', 16, 'C', '2026-01-26 20:14:28', 1),
(78, 'Demo', 23, 'B', '2026-01-26 20:14:28', 0),
(79, 'Demo', 14, 'A', '2026-01-26 20:14:28', 0),
(80, 'Demo', 12, 'C', '2026-01-26 20:14:28', 0),
(81, 'demmoooo', 23, 'C', '2026-01-26 20:19:53', 1),
(82, 'demmoooo', 11, 'A', '2026-01-26 20:19:53', 0),
(83, 'demmoooo', 15, 'D', '2026-01-26 20:19:53', 0),
(84, 'demmoooo', 18, 'D', '2026-01-26 20:19:53', 1),
(85, 'demmoooo', 9, 'D', '2026-01-26 20:19:53', 1),
(86, 'demmoooo', 14, 'A', '2026-01-26 20:19:53', 0),
(87, 'demmoooo', 19, 'A', '2026-01-26 20:19:53', 0),
(88, 'demmoooo', 25, 'A', '2026-01-26 20:19:53', 0),
(89, 'demmoooo', 3, 'D', '2026-01-26 20:19:53', 0),
(90, 'demmoooo', 12, 'C', '2026-01-26 20:19:53', 0),
(91, 'demmoooo', 4, 'A', '2026-01-26 20:19:53', 0),
(92, 'demmoooo', 24, 'C', '2026-01-26 20:19:53', 0),
(93, 'demmoooo', 7, 'B', '2026-01-26 20:19:53', 1),
(94, 'demmoooo', 20, 'C', '2026-01-26 20:19:53', 0),
(95, 'demmoooo', 22, 'C', '2026-01-26 20:19:53', 1),
(96, 'demmoooo', 6, 'C', '2026-01-26 20:19:53', 0),
(97, 'demmoooo', 16, 'A', '2026-01-26 20:19:53', 0),
(98, 'demmoooo', 10, 'D', '2026-01-26 20:19:53', 0),
(99, 'demmoooo', 13, 'A', '2026-01-26 20:19:53', 0),
(100, 'demmoooo', 17, 'B', '2026-01-26 20:19:53', 0),
(101, 'demmoooo', 1, 'D', '2026-01-26 20:19:53', 0),
(102, 'demmoooo', 21, 'C', '2026-01-26 20:19:53', 0),
(103, 'demmoooo', 2, 'A', '2026-01-26 20:19:53', 0),
(104, 'demmoooo', 8, 'C', '2026-01-26 20:19:53', 1),
(105, 'demmoooo', 5, 'D', '2026-01-26 20:19:53', 0),
(106, '123465', 19, 'C', '2026-01-26 20:22:20', 1),
(107, '123465', 16, 'D', '2026-01-26 20:22:20', 0),
(108, '123465', 20, 'C', '2026-01-26 20:22:20', 0),
(109, '123465', 5, 'C', '2026-01-26 20:22:20', 1),
(110, '123465', 24, 'D', '2026-01-26 20:22:20', 0),
(111, '123465', 15, 'D', '2026-01-26 20:22:20', 0),
(112, '123465', 21, 'B', '2026-01-26 20:22:20', 1),
(113, '123465', 7, 'B', '2026-01-26 20:22:20', 1),
(114, '123465', 14, 'A', '2026-01-26 20:22:20', 0),
(115, '123465', 3, 'A', '2026-01-26 20:22:20', 0),
(116, '123465', 23, 'A', '2026-01-26 20:22:20', 0),
(117, '123465', 10, 'B', '2026-01-26 20:22:20', 0),
(118, '123465', 17, 'B', '2026-01-26 20:22:20', 0),
(119, '123465', 6, 'C', '2026-01-26 20:22:20', 0),
(120, '123465', 1, 'A', '2026-01-26 20:22:20', 0),
(121, '123465', 4, 'A', '2026-01-26 20:22:20', 0),
(122, '123465', 2, 'C', '2026-01-26 20:22:20', 1),
(123, '123465', 25, 'A', '2026-01-26 20:22:20', 0),
(124, '123465', 11, 'A', '2026-01-26 20:22:20', 0),
(125, '123465', 12, 'C', '2026-01-26 20:22:20', 0),
(126, '123465', 18, 'C', '2026-01-26 20:22:20', 0),
(127, '123465', 13, 'C', '2026-01-26 20:22:20', 1),
(128, '123465', 9, 'A', '2026-01-26 20:22:20', 0),
(129, '123465', 8, 'B', '2026-01-26 20:22:20', 0),
(130, '123465', 22, 'C', '2026-01-26 20:22:20', 1),
(131, 'Test1', 2, 'A', '2026-01-26 20:22:20', 0),
(132, 'Test1', 4, 'B', '2026-01-26 20:22:20', 1),
(133, 'Test1', 10, 'C', '2026-01-26 20:22:20', 1),
(134, 'Test1', 21, 'D', '2026-01-26 20:22:20', 0),
(135, 'Test1', 9, 'D', '2026-01-26 20:22:20', 1),
(136, 'Test1', 24, 'D', '2026-01-26 20:22:20', 0),
(137, 'Test1', 17, 'B', '2026-01-26 20:22:20', 0),
(138, 'Test1', 19, 'A', '2026-01-26 20:22:20', 0),
(139, 'Test1', 12, 'C', '2026-01-26 20:22:20', 0),
(140, 'Test1', 18, 'A', '2026-01-26 20:22:20', 0),
(141, 'Test1', 1, 'D', '2026-01-26 20:22:20', 0),
(142, 'Test1', 13, 'D', '2026-01-26 20:22:20', 0),
(143, 'Test1', 14, 'C', '2026-01-26 20:22:20', 0),
(144, 'Test1', 22, 'D', '2026-01-26 20:22:20', 0),
(145, 'Test1', 15, 'B', '2026-01-26 20:22:20', 0),
(146, 'Test1', 3, 'B', '2026-01-26 20:22:20', 0),
(147, 'Test1', 16, 'C', '2026-01-26 20:22:20', 1),
(148, 'Test1', 8, 'C', '2026-01-26 20:22:20', 1),
(149, 'Test1', 6, 'B', '2026-01-26 20:22:20', 1),
(150, 'Test1', 23, 'A', '2026-01-26 20:22:20', 0),
(151, 'Test1', 25, 'D', '2026-01-26 20:22:20', 0),
(152, 'Test1', 20, 'D', '2026-01-26 20:22:20', 0),
(153, 'Test1', 11, 'A', '2026-01-26 20:22:20', 0),
(154, 'Test1', 7, 'B', '2026-01-26 20:22:20', 1),
(155, 'Test1', 5, 'C', '2026-01-26 20:22:20', 1),
(156, '123465', 19, 'C', '2026-01-26 20:22:28', 1),
(157, '123465', 16, 'D', '2026-01-26 20:22:28', 0),
(158, '123465', 20, 'C', '2026-01-26 20:22:28', 0),
(159, '123465', 5, 'C', '2026-01-26 20:22:28', 1),
(160, '123465', 24, 'D', '2026-01-26 20:22:28', 0),
(161, '123465', 15, 'D', '2026-01-26 20:22:28', 0),
(162, '123465', 21, 'B', '2026-01-26 20:22:28', 1),
(163, '123465', 7, 'B', '2026-01-26 20:22:28', 1),
(164, '123465', 14, 'A', '2026-01-26 20:22:28', 0),
(165, '123465', 3, 'A', '2026-01-26 20:22:28', 0),
(166, '123465', 23, 'A', '2026-01-26 20:22:28', 0),
(167, '123465', 10, 'B', '2026-01-26 20:22:28', 0),
(168, '123465', 17, 'B', '2026-01-26 20:22:28', 0),
(169, '123465', 6, 'C', '2026-01-26 20:22:28', 0),
(170, '123465', 1, 'A', '2026-01-26 20:22:28', 0),
(171, '123465', 4, 'A', '2026-01-26 20:22:28', 0),
(172, '123465', 2, 'C', '2026-01-26 20:22:28', 1),
(173, '123465', 25, 'A', '2026-01-26 20:22:28', 0),
(174, '123465', 11, 'A', '2026-01-26 20:22:28', 0),
(175, '123465', 12, 'C', '2026-01-26 20:22:28', 0),
(176, '123465', 18, 'C', '2026-01-26 20:22:28', 0),
(177, '123465', 13, 'C', '2026-01-26 20:22:28', 1),
(178, '123465', 9, 'A', '2026-01-26 20:22:28', 0),
(179, '123465', 8, 'B', '2026-01-26 20:22:28', 0),
(180, '123465', 22, 'C', '2026-01-26 20:22:28', 1),
(181, 'demmoooo', 23, 'C', '2026-01-26 20:25:50', 1),
(182, 'demmoooo', 11, 'A', '2026-01-26 20:25:50', 0),
(183, 'demmoooo', 15, 'D', '2026-01-26 20:25:50', 0),
(184, 'demmoooo', 18, 'D', '2026-01-26 20:25:50', 1),
(185, 'demmoooo', 9, 'D', '2026-01-26 20:25:50', 1),
(186, 'demmoooo', 14, 'A', '2026-01-26 20:25:50', 0),
(187, 'demmoooo', 19, 'A', '2026-01-26 20:25:50', 0),
(188, 'demmoooo', 25, 'A', '2026-01-26 20:25:50', 0),
(189, 'demmoooo', 3, 'D', '2026-01-26 20:25:50', 0),
(190, 'demmoooo', 12, 'C', '2026-01-26 20:25:50', 0),
(191, 'demmoooo', 4, 'A', '2026-01-26 20:25:50', 0),
(192, 'demmoooo', 24, 'C', '2026-01-26 20:25:50', 0),
(193, 'demmoooo', 7, 'B', '2026-01-26 20:25:50', 1),
(194, 'demmoooo', 20, 'C', '2026-01-26 20:25:50', 0),
(195, 'demmoooo', 22, 'C', '2026-01-26 20:25:50', 1),
(196, 'demmoooo', 6, 'C', '2026-01-26 20:25:50', 0),
(197, 'demmoooo', 16, 'A', '2026-01-26 20:25:50', 0),
(198, 'demmoooo', 10, 'D', '2026-01-26 20:25:50', 0),
(199, 'demmoooo', 13, 'A', '2026-01-26 20:25:50', 0),
(200, 'demmoooo', 17, 'B', '2026-01-26 20:25:50', 0),
(201, 'demmoooo', 1, 'D', '2026-01-26 20:25:50', 0),
(202, 'demmoooo', 21, 'C', '2026-01-26 20:25:50', 0),
(203, 'demmoooo', 2, 'A', '2026-01-26 20:25:50', 0),
(204, 'demmoooo', 8, 'C', '2026-01-26 20:25:50', 1),
(205, 'demmoooo', 5, 'D', '2026-01-26 20:25:50', 0),
(206, 'Arpit', 18, 'D', '2026-01-27 20:12:31', 1),
(207, 'Arpit', 14, 'B', '2026-01-27 20:12:31', 1),
(208, 'Arpit', 7, 'B', '2026-01-27 20:12:31', 1),
(209, 'Arpit', 20, 'C', '2026-01-27 20:12:31', 0),
(210, 'Arpit', 8, 'C', '2026-01-27 20:12:31', 1),
(211, 'Arpit', 2, 'B', '2026-01-27 20:12:31', 0),
(212, 'Arpit', 13, 'A', '2026-01-27 20:12:31', 0),
(213, 'Arpit', 21, 'A', '2026-01-27 20:12:31', 0),
(214, 'Arpit', 19, 'D', '2026-01-27 20:12:31', 0),
(215, 'Arpit', 10, 'C', '2026-01-27 20:12:31', 1),
(216, 'Arpit', 24, 'C', '2026-01-27 20:12:31', 0),
(217, 'Arpit', 11, 'A', '2026-01-27 20:12:31', 0),
(218, 'Arpit', 15, 'B', '2026-01-27 20:12:31', 0),
(219, 'Arpit', 9, 'C', '2026-01-27 20:12:31', 0),
(220, 'Arpit', 12, 'B', '2026-01-27 20:12:31', 1),
(221, 'Arpit', 23, 'C', '2026-01-27 20:12:31', 1),
(222, 'Arpit', 1, 'D', '2026-01-27 20:12:31', 0),
(223, 'Arpit', 25, 'A', '2026-01-27 20:12:31', 0),
(224, 'Arpit', 5, 'B', '2026-01-27 20:12:31', 0),
(225, 'Arpit', 17, 'B', '2026-01-27 20:12:31', 0),
(226, 'Arpit', 3, 'C', '2026-01-27 20:12:31', 1),
(227, 'Arpit', 4, 'B', '2026-01-27 20:12:31', 1),
(228, 'Arpit', 16, 'C', '2026-01-27 20:12:31', 1),
(229, 'Arpit', 6, 'A', '2026-01-27 20:12:31', 0),
(230, 'Arpit', 22, 'C', '2026-01-27 20:12:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `user_name`, `score`, `total_questions`, `timestamp`) VALUES
(1, 'demmoooo', 6, 25, '2026-01-26 20:19:53'),
(2, '123465', 7, 25, '2026-01-26 20:22:20'),
(3, 'Test1', 8, 25, '2026-01-26 20:22:20'),
(4, 'Arpit', 11, 25, '2026-01-27 20:12:31');

-- --------------------------------------------------------

--
-- Table structure for table `tie_questions`
--

CREATE TABLE `tie_questions` (
  `id` int(11) NOT NULL,
  `question_text` text DEFAULT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tie_questions`
--

INSERT INTO `tie_questions` (`id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(1, 'A dataset contains the following values: 2,4,4,4,5,5,7,9. Compute the variance.', '3', '4', '2.5', '5', 'B'),
(2, 'There are 80 closed doors in a row and 80 people. At the end of the process, how many doors remain open?', '10', '8', '16', '40', 'B'),
(3, 'You have 3 switches controlling 3 bulbs and can enter the room only once. How do you identify which switch controls which bulb?', 'Turn switch 1 on, wait, turn it off, turn switch 2 on, check', 'Turn switch 1 on, turn switch 2 on, check', 'Turn switch 1 on, wait, turn switch 2 on, check', 'Turn all switches on, check', 'A'),
(4, 'A number written as 111 in base xxx equals 31 in decimal. What is the value of xxx?', '2', '3', '5', '6', 'D'),
(5, 'A program spends 40% of its time in a part that can be improved 5×. Overall speedup is:', '1.5×', '1.9×', '2.5×', '3.0×', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `tie_responses`
--

CREATE TABLE `tie_responses` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `selected_option` char(1) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tie_responses`
--

INSERT INTO `tie_responses` (`id`, `user_name`, `question_id`, `selected_option`, `is_correct`, `submitted_at`) VALUES
(1, 'TEAM', 1, 'B', 1, '2026-01-27 14:37:56'),
(2, 'TEAM', 4, 'B', 0, '2026-01-27 14:37:56'),
(3, 'TEAM', 3, 'B', 0, '2026-01-27 14:37:56'),
(4, 'TEAM', 2, 'C', 0, '2026-01-27 14:37:56'),
(5, 'TEAM', 5, 'A', 0, '2026-01-27 14:37:56'),
(6, 'TEAM', 5, 'D', 0, '2026-01-27 14:44:08'),
(7, 'TEAM', 4, 'B', 0, '2026-01-27 14:44:08'),
(8, 'TEAM', 3, 'D', 0, '2026-01-27 14:44:08'),
(9, 'TEAM', 1, 'C', 0, '2026-01-27 14:44:08'),
(10, 'TEAM', 2, 'C', 0, '2026-01-27 14:44:08');

-- --------------------------------------------------------

--
-- Table structure for table `tie_results`
--

CREATE TABLE `tie_results` (
  `id` int(11) NOT NULL,
  `team_name` varchar(100) DEFAULT NULL,
  `score` int(11) DEFAULT 0,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tie_results_old`
--

CREATE TABLE `tie_results_old` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tie_results_old`
--

INSERT INTO `tie_results_old` (`id`, `user_name`, `score`, `total_questions`, `submitted_at`) VALUES
(1, 'TEAM', 1, 5, '2026-01-27 14:37:56'),
(2, 'TEAM', 0, 5, '2026-01-27 14:44:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tie_questions`
--
ALTER TABLE `tie_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tie_responses`
--
ALTER TABLE `tie_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tie_results`
--
ALTER TABLE `tie_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tie_results_old`
--
ALTER TABLE `tie_results_old`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tie_questions`
--
ALTER TABLE `tie_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tie_responses`
--
ALTER TABLE `tie_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tie_results`
--
ALTER TABLE `tie_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tie_results_old`
--
ALTER TABLE `tie_results_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
