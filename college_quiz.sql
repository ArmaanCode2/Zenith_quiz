
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `selected_option` char(1) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `tie_questions` (
  `id` int(11) NOT NULL,
  `question_text` text DEFAULT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `tie_questions` (`id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(1, 'A dataset contains the following values: 2,4,4,4,5,5,7,9. Compute the variance.', '3', '4', '2.5', '5', 'B'),
(2, 'There are 80 closed doors in a row and 80 people. At the end of the process, how many doors remain open?', '10', '8', '16', '40', 'B'),
(3, 'You have 3 switches controlling 3 bulbs and can enter the room only once. How do you identify which switch controls which bulb?', 'Turn switch 1 on, wait, turn it off, turn switch 2 on, check', 'Turn switch 1 on, turn switch 2 on, check', 'Turn switch 1 on, wait, turn switch 2 on, check', 'Turn all switches on, check', 'A'),
(4, 'A number written as 111 in base xxx equals 31 in decimal. What is the value of xxx?', '2', '3', '5', '6', 'D'),
(5, 'A program spends 40% of its time in a part that can be improved 5×. Overall speedup is:', '1.5×', '1.9×', '2.5×', '3.0×', 'B');


CREATE TABLE `tie_responses` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `selected_option` char(1) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tie_results` (
  `id` int(11) NOT NULL,
  `team_name` varchar(100) DEFAULT NULL,
  `score` int(11) DEFAULT 0,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `tie_results_old` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tie_questions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tie_responses`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tie_results`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tie_results_old`
  ADD PRIMARY KEY (`id`);

ALTER TABLE results
ADD COLUMN submission_token VARCHAR(64) NULL UNIQUE;

ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;


ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `tie_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

  ALTER TABLE tie_results
ADD COLUMN submission_token VARCHAR(64) NULL UNIQUE;

ALTER TABLE `tie_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `tie_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tie_results_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;