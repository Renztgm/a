-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 07:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `d`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `width` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `background_color` varchar(20) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `text_align` varchar(20) DEFAULT NULL,
  `font_size` varchar(20) DEFAULT NULL,
  `font_style` varchar(20) DEFAULT NULL,
  `padding` varchar(50) DEFAULT NULL,
  `margin` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `created_at`, `project_id`) VALUES
(1, '', '', '\r\n    <h1 id=\"liveTitle\">Page Title Preview</h1>\r\n  <div class=\"section\" contenteditable=\"true\"><p>New text section...asdasdasd</p><div class=\"tools\">\r\n        <button onclick=\"this.parentElement.parentElement.hidden = !this.parentElement.parentElement.hidden\">👁️</button>\r\n        <button onclick=\"this.parentElement.parentElement.remove()\">❌</button>\r\n      </div></div>', '2025-04-11 21:29:06', 7);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `name`, `description`, `logo`, `created_at`) VALUES
(12, ' website', 'university', 'uploads/67fa1007f387b_67f47d492c3df_asdasda.png', '2025-04-12 15:02:32'),
(13, 'qweqwe', 'weqw', 'uploads/681ee39a7187d_495073040_2197303414074012_8272612189865387795_n.png', '2025-05-10 13:26:50');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `page_id` int(11) DEFAULT NULL,
  `section_name` varchar(100) NOT NULL,
  `width` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `background_color` varchar(20) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `text_align` varchar(20) DEFAULT NULL,
  `font_size` varchar(20) DEFAULT NULL,
  `font_style` varchar(20) DEFAULT NULL,
  `padding` varchar(50) DEFAULT NULL,
  `margin` varchar(50) DEFAULT NULL,
  `image_path` varchar(100) DEFAULT NULL,
  `section_template` varchar(100) DEFAULT NULL,
  `content` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `page_id`, `section_name`, `width`, `height`, `background_color`, `color`, `text_align`, `font_size`, `font_style`, `padding`, `margin`, `image_path`, `section_template`, `content`) VALUES
(15, 0, 'shane', '100%', '100%', '#942fca', '#000000', 'center', '16px', 'Georgia', '0', '0', NULL, 'text', 'laure');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `blocks_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
