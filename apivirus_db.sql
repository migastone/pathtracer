-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2020 at 11:55 AM
-- Server version: 5.7.14
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apivirus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `device_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `country` varchar(100) NOT NULL,
  `platform` varchar(200) NOT NULL,
  `uuid` varchar(200) NOT NULL,
  `version` varchar(100) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = Enabled\r\n0 = Disabled',
  `infected_device_id` int(11) NOT NULL DEFAULT '0',
  `infected_device_distance` decimal(8,2) NOT NULL DEFAULT '0.00',
  `infected_device_date` datetime DEFAULT NULL,
  `is_infected` tinyint(4) NOT NULL DEFAULT '0',
  `infected_marked_by` enum('Self','System') NOT NULL,
  `infected_at` datetime DEFAULT NULL,
  `device_infected_at` datetime DEFAULT NULL,
  `last_connection_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `pk_group_id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `group_description` varchar(200) NOT NULL,
  `group_status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`pk_group_id`, `group_name`, `group_description`, `group_status`) VALUES
(1, 'Administrators', 'Administrators will have full access.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

CREATE TABLE `ledgers` (
  `ledger_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL DEFAULT '0',
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `device_timezone` varchar(10) NOT NULL DEFAULT '+01:00',
  `device_created_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `pk_setting_id` int(11) NOT NULL,
  `setting_slug` varchar(100) NOT NULL,
  `setting_data` mediumtext NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `updation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`pk_setting_id`, `setting_slug`, `setting_data`, `created_by`, `creation_date`, `updated_by`, `updation_date`) VALUES
(2, 'smtp_protocol', 'smtp', 1, '2019-12-16 00:00:00', 1, '2020-03-04 08:40:29'),
(3, 'smtp_host', 'your.domain.com', 1, '2019-12-16 00:00:00', 1, '2020-03-04 08:40:29'),
(4, 'smtp_user', 'info@yourdomain.com', 1, '2019-12-16 00:00:00', 1, '2020-03-04 08:40:29'),
(5, 'smtp_password', 'somepassword', 1, '2019-12-16 00:00:00', 1, '2020-03-04 08:40:29'),
(6, 'smtp_mailtype', 'html', 1, '2019-12-16 00:00:00', 1, '2020-03-04 08:40:29'),
(7, 'smtp_charset', 'utf-8', 1, '2019-12-16 00:00:00', 1, '2020-03-04 08:40:29'),
(8, 'smtp_from_email', 'info@yourdomain.com', 1, '2019-12-16 00:00:00', 1, '2020-03-04 08:40:29'),
(9, 'smtp_from_name', 'Virus Path Tracer - Migastone', 1, '2019-12-16 00:00:00', 1, '2020-03-04 08:40:29'),
(10, 'smtp_bcc', 'admin@yourdomain.com', 1, '2019-12-18 00:00:00', 1, '2020-03-04 08:40:29'),
(11, 'registration_is_feature_enabled', '1', 1, '2020-03-04 14:27:46', 1, '2020-03-31 13:40:04'),
(12, 'registration_is_enable_im_infected', '1', 1, '2020-03-04 14:31:48', 1, '2020-03-31 13:40:06'),
(13, 'registration_terms_and_conditions', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam hendrerit nisi sed sollicitudin pellentesque. Nunc posuere purus rhoncus pulvinar aliquam. Ut aliquet tristique nisl vitae volutpat. Nulla aliquet porttitor venenatis. Donec a dui et dui fringilla consectetur id nec massa. Aliquam erat volutpat. Sed ut dui ut lacus dictum fermentum vel tincidunt neque. Sed sed lacinia lectus. Duis sit amet sodales felis. Duis nunc eros, mattis at dui ac, convallis semper risus. In adipiscing ultrices tellus, in suscipit massa vehicula eu.<br />\n<br />\nUt enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur?', 1, '2020-03-04 14:32:54', 1, '2020-03-31 13:40:06'),
(14, 'registration_countries', 'Italy', 1, '2020-03-04 14:35:49', 1, '2020-03-31 13:40:06'),
(15, 'registration_youtube_url', 'https://www.youtube.com/watch?v=cHv0-oyowrk', 1, '2020-03-04 14:38:09', 1, '2020-03-31 13:40:10'),
(16, 'registration_is_video_enabled', '1', 1, '2020-03-04 14:39:14', 1, '2020-03-31 13:40:10'),
(17, 'registration_disabled_reason', 'The app is temporarily disabled, please contact the admin.', 1, '2020-03-10 18:54:36', 1, '2020-03-31 13:40:06'),
(18, 'registration_is_welcome_push_enabled', '1', 1, '2020-03-12 17:33:47', 1, '2020-03-31 13:40:08'),
(19, 'registration_welcome_push_title', 'Welcome to Virus Path Tracer', 1, '2020-03-12 17:34:19', 1, '2020-03-31 13:40:09'),
(20, 'registration_welcome_push_text', 'An app for tracking the coronavirus suspects.', 1, '2020-03-12 17:34:59', 1, '2020-03-31 13:40:09'),
(27, 'registration_distance_warning', '100', 1, '2020-03-19 16:52:13', 1, '2020-03-31 13:40:07'),
(30, 'registration_im_infected_title', 'Report Your Status', 1, '2020-03-23 16:41:45', 0, '0000-00-00 00:00:00'),
(31, 'registration_im_infected_text', 'If you are infected you can declare here by clicking the button below. The self-certified diagnosis is marked as Not Certified and should be verified from a Doctor. We count on your common sense to use this report with care.', 1, '2020-03-23 16:55:53', 0, '0000-00-00 00:00:00'),
(32, 'registration_status_safe_title', 'YOU ARE SAFE', 1, '2020-03-26 21:57:57', 1, '2020-03-31 13:40:07'),
(33, 'registration_status_safe_text', 'From the analysis of our database and @@positions@@ recorded from you, it seems that in the past @@days@@ you weren\'t near an infected person.', 1, '2020-03-26 22:08:37', 1, '2020-03-31 13:40:08'),
(34, 'registration_status_infected_title', 'YOUR ARE INFECTED', 1, '2020-03-26 22:11:36', 1, '2020-03-31 13:40:07'),
(35, 'registration_status_infected_text', '@@infected_marked_by@@ that you are infected on @@date@@ on hour @@time@@. Please go to quarantine.', 1, '2020-03-26 22:13:29', 1, '2020-03-31 13:40:07'),
(36, 'registration_status_warning_title', 'CLOSED TO INFECTED PERSON', 1, '2020-03-26 22:17:51', 1, '2020-03-31 13:40:07'),
(37, 'registration_status_warning_text', 'From the analysis of our database and the @@positions@@ recorded it seems that on @@date@@ during hour @@time@@ you were near a possible infected person. The person was less than @@distance@@ far from you. @@authority@@.', 1, '2020-03-26 22:19:22', 1, '2020-03-31 13:40:07'),
(38, 'registration_distance_warning_minutes', '30', 1, '2020-03-31 17:50:13', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `pk_user_id` int(11) NOT NULL,
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `creation_date` date NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `updation_date` date DEFAULT NULL,
  `fk_group_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`pk_user_id`, `user_first_name`, `user_last_name`, `user_email`, `user_password`, `user_status`, `created_by`, `creation_date`, `updated_by`, `updation_date`, `fk_group_id`) VALUES
(5, 'Demo', 'User', 'demo@domain.com', '62cc2d8b4bf2d8728120d052163a77df', 1, 1, '2020-04-07', 0, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`device_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`pk_group_id`);

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`ledger_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`pk_setting_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`pk_user_id`),
  ADD UNIQUE KEY `userEmail` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `pk_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `ledger_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `pk_setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `pk_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
