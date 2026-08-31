
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


-- new questions
INSERT INTO `questions` (`id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(1, 'What is the name of Elon Musks neurotechnology company working on implantable brain-computer interfaces (BCIs)?', 'Brainlink', 'The Boring Company', 'Hyperloop', 'Neuralink', 'D'),
(2, 'YouTube was originally conceived as a platform for sharing which type of content, before evolving into the massive video platform it is today?', 'Video dating profiles', 'Online gaming streams', 'Video sharing', 'Music downloads', 'A'),
(3, 'Which entertainment property is recognized as the single highest-grossing multimedia and gaming franchise of all time?', 'Super Mario', 'Grand Theft Auto', 'Pokémon', 'Star Wars', 'C'),
(4, 'Which company created the PostScript page description language and later became famous for PDF technology?', 'Adobe', 'Autodesk', 'Corel', 'Xerox', 'A'),
(5, 'Unlike SCUBA and CAPTCHA, which became everyday words after being created from longer technical phrases, which term originated as a military technology for detecting the presence, distance, and direction of distant objects using radio waves?', 'SONAR', 'RADAR', 'LIDAR', 'SODAR', 'B'),
(6, 'Which game launched in 2016 quickly became one of the most downloaded mobile games in history, attracting tens of millions of players shortly after launch. Which game was responsible for this unprecedented surge in popularity?', 'Clash Royale', 'Among Us', 'Pokemon Go', 'Super Mario Run', 'C'),
(7, 'A retail store uses smart security cameras powered by Computer Vision to monitor shelves. When an item runs out, the system automatically alerts the manager to restock it. What is this automated operational process called?', 'On-Shelf Availability Tracking', 'Real-Time Stocktaking', 'Inventory Management', 'Just-in-Time Logistics', 'A'),
(8, 'Which programming language is primarily used as the backbone for high-performance game engines like Unreal Engine, driving AAA titles such as PUBG and Grand Theft Auto?', 'Java', 'JavaScript', 'C++', 'Python', 'C'),
(9, 'Researchers in Japan recently set a world record for data transmission speed. Which of the following correctly identifies the maximum speed achieved by them?', '1.02 TeraBytes per second', '1.02 Terabits per second', '1.02 PetaBytes per second', '1.02 Petabits per second', 'D'),
(10, 'Which deep-tech startup launched the indigenous iron-air battery pilot project at NTPC Simhadri Thermal Power Station?', 'Amara Raja Energy', 'Exide Energy', 'Meine Electric', 'Tata Power', 'C'),
(11, 'Andy Rubin is known as one of the three principal visionaries who co-founded _______ back in October 2003.', 'PalmOS', 'Android', 'WebOS', 'BlackBerry OS', 'B'),
(12, 'For Cyber Monday in the US in 2019, Google "baked" Pixel 4 phones inside the pizza boxes of what fast food chain as a limited promotion?', 'Dominos', 'Pizza Hut', 'Papa Johns', 'Panera Bread (Baked goods and bread)', 'A'),
(13, 'Which science-fiction film is widely regarded as one of the earliest movies to use computer-generated imagery, using digital effects to depict a robotic characters point of view?', 'Tron', 'Westworld', 'Star Wars', 'Avatar', 'B'),
(14, 'Which NASA space telescope uses a large segmented primary mirror and was designed primarily to observe the universe in infrared wavelengths?', 'Hubble Space Telescope', 'James Webb Space Telescope', 'Chandra X-ray Observatory', 'Spitzer Space Telescope', 'B'),
(15, 'Which company owns the Steam gaming platform?', 'Epic Games', 'Valve', 'Microsoft', 'Tencent', 'B'),
(16, 'Which company created the CUDA parallel computing platform?', 'AMD', 'Intel', 'NVIDIA', 'ARM', 'C'),
(17, 'Which architectural technology/algorithm do massive mapping systems like Google Maps primarily rely on to execute sub-second route calculation and live dynamic rerouting across global-scale road networks?', 'Bellman-Ford algorithm enhanced with spatial hashing and dynamic programming table', 'Contraction Hierarchies combined with heuristic search (such as A*)', 'Bi-directional Breadth-First Search (BFS) paired with real-time Euclidean bounding-box pruning', 'Floyd-Warshall algorithm accelerated via massively parallelized GPU matrix tensor multiplications', 'B'),
(18, 'Six students — A, B, C, D, E and F — are sitting around a circular table, all facing the centre The following conditions apply:
A is sitting immediately to the left of B.
C is sitting exactly opposite A.
D is not sitting next to C.
E is sitting immediately to the right of F.
B is not sitting opposite D.
If A is fixed at the top position of the table, who must be sitting opposite E?
', 'B', 'C', 'D', 'F', 'A'),
(19, 'A processors performance is affected by cache hierarchy, memory latency, and instruction execution. Which cache level is typically the fastest and smallest, located closest to the CPU execution units?', 'L1 Cache', 'L2 Cache', 'L3 Cache', 'DRAM', 'A'),
(20, 'In a moderately skewed distribution, which of the following correctly expresses the empirical relationship among the mean, median, and mode?', 'Mode= 2 Mean - 3Median', 'Mode= 3 Mean - 2Median', 'Mode= 3 Median - 2 Mean', 'Mode= 2 Median - 3 Mean', 'C'),
(21, 'Which AI model has highest Intelligence in agentic index in current time?', 'Fable 5 (max)', 'GPT 5.6 Sol (max)', 'GLM 5.3 (max)', 'Opus 5 (max)', 'D'),
(22, 'Which company made Elon Musk a millionaire?', 'PayPal', 'Zip2', 'Tesla', 'Neuralink Corporation', 'B'),
(23, 'Which company was the worlds undisputed largest mobile phone manufacturer until 2012, but catastrophically missed the shift to app-store software ecosystems and touchscreens?', 'Blackberry', 'Micromax', 'Nokia', 'Motorola', 'C'),
(24, 'Before becoming a standalone company, Android Inc. was acquired by:', 'Apple', 'Microsoft', 'Google', 'Samsung', 'C'),
(25, 'Which company acquired GitHub in 2018?', 'Google', 'Amazon', 'Microsoft', 'IBM', 'C');



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
(1, 'Which company developed the Java programming language originally?', 'IBM', 'Sun Microsystems', 'Microsoft', 'Oracle', 'B'),
(2, 'Which Microsoft device, first introduced in 2012, combines the portability of a tablet with the functionality of a computer?', 'Microsoft Surface', 'Microsoft Studio', 'Microsoft Lumia', 'Microsoft Windows', 'A'),
(3, 'In modern out-of-order superscalar processors, which structure primarily helps track the status and dependencies of in-flight instructions so operands can be supplied when they become available?', 'Reorder Buffer', 'Reservation Station', 'Branch Target Buffer', 'Translation Lookaside Buffer', 'B'),
(4, 'Which famous fictional AI system from 2001: A Space Odyssey became one of the most recognizable representations of artificial intelligence in cinema?', 'JARVIS', 'HAL 9000', 'Skynet', 'Mother (MU-TH-UR 6000)', 'B'),
(5, 'A web server supports TLS 1.3. During a normal authenticated HTTPS connection, which property does the servers digital certificate primarily help the client establish?', 'The servers available RAM capacity', 'The servers claimed identity', 'The clients CPU speed', 'The exact physical route of every packet', 'B');


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