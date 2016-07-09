-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 06, 2016 at 01:50 PM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `training_center`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `name`) VALUES
(3, 'Information System Management[FP]'),
(4, 'Information System Management[SP]'),
(1, 'Software Engineering[FP]'),
(2, 'Software Engineering[SP]'),
(5, 'Software Security[FP]'),
(6, 'Software Security[SP]');

-- --------------------------------------------------------

--
-- Table structure for table `class_member`
--

CREATE TABLE `class_member` (
  `person_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class_member`
--

INSERT INTO `class_member` (`person_id`, `class_id`) VALUES
(6, 3),
(7, 3),
(8, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3);

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `document_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `location` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `zip_code` varchar(5) NOT NULL,
  `town` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `mobile_phone` varchar(10) NOT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `is_trainer` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(45) NOT NULL,
  `picture_location` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(45) DEFAULT NULL,
  `renew_password_token` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `first_name`, `last_name`, `address`, `zip_code`, `town`, `email`, `mobile_phone`, `phone`, `is_trainer`, `is_admin`, `password`, `picture_location`, `created_at`, `confirmed_at`, `confirmation_token`, `renew_password_token`) VALUES
(6, 'Samved', 'Vajpeyi', '25 Rue Rosa Luxemburg \n ', '94800', 'Villejuif', 'samvedvajpeyi2@gmail.com', '677506702', '', 1, 1, '2fe6bd8891e08966df366a998d09b8c0', NULL, '2016-07-01 04:12:27', NULL, 'vvo6xXxFUOlz', 'SVSb8JuAxDPl'),
(7, 'Abhijeet', 'Pandey', '25 Rue Rosa Luxemburg \n ', '94800', 'Villejuif', 'samvedvajpeyi@gmail.com', '677506702', '0677506702', 0, 0, '83bb954275029d2a7849fb24e549643f', NULL, '2016-07-01 21:42:01', NULL, 'IgerYXZUCOwE', 'R5meOSa4Mz4K'),
(8, 'Vaibhav', 'Goel', '25 Rue Rosa Luxemburg \n ', '94800', 'Villejuif', 'vaibhav30789@gmail.com', '677506702', '0677506702', 0, 0, '74b87337454200d4d33f80c4663dc5e5', NULL, '2016-07-01 23:00:45', NULL, 'qxyu2Ewzledg', 'w9V01nWamJxs'),
(13, 'Albert', 'David', '34 Judh KUrte \n some more', '9283', 'London', 'albert@david.com', '9283747748', '', 1, 0, '2fe6bd8891e08966df366a998d09b8c0', NULL, '2016-07-06 10:21:43', NULL, 'HvWAqmQVS6kq', 'Tn7ONA7z9WEs'),
(14, 'Necro', 'Mancer', 'Somwhere in Villejuif \n ', '98374', 'Paris', 'necromancer@gmail.com', '983784758', '', 0, 0, '2fe6bd8891e08966df366a998d09b8c0', NULL, '2016-07-06 10:22:31', NULL, 'MK5x6BcPVI2n', 'Np2hYTDJkY7c'),
(15, 'Prachi', 'Tripathi', '78 Rue Voltaire \n Bd Maxime', '92838', 'Brussels', 'prachiyadav@necro.com', '28384948', '', 0, 0, '2fe6bd8891e08966df366a998d09b8c0', NULL, '2016-07-06 10:23:20', NULL, 'wC9Z0Gc9Lzp8', 'HHNHikYbe1px'),
(16, 'Pedro', 'Rakhi', 'Some address \n here also', '2839', 'Mycity', 'email@mymail.com', '338485983', '48482928', 1, 0, '2fe6bd8891e08966df366a998d09b8c0', NULL, '2016-07-06 10:24:06', NULL, 'PSlaXdUS5r8S', 'A5hgIZ2MFytP');

--
-- Triggers `person`
--
DELIMITER $$
CREATE TRIGGER `DeleteFromClass` BEFORE DELETE ON `person`
 FOR EACH ROW DELETE FROM `class_member` WHERE (`person_id` = OLD.`person_id`)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `deadline` datetime NOT NULL,
  `subject` varchar(1024) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `owner_id`, `class_id`, `title`, `created_at`, `deadline`, `subject`) VALUES
(13, 6, 1, 'Android Development & Research', '2016-07-06 03:42:34', '2016-07-28 00:00:00', 'New Corporate Finance'),
(14, 6, 3, 'Advanecd Project Management', '2016-07-06 09:44:31', '2016-07-28 00:00:00', 'PRI module'),
(15, 6, 3, 'IT Strategy And Design', '2016-07-06 10:25:46', '2016-07-20 00:00:00', 'Fundamentals IT'),
(16, 6, 3, 'Advanced JAVA Something', '2016-07-06 10:26:31', '2016-08-17 00:00:00', '.Net & C#'),
(17, 6, 3, 'Testing Functionalities', '2016-07-06 11:24:10', '2016-07-10 00:00:00', 'And bugs'),
(18, 6, 3, 'Neatbeans and JAVA Something', '2016-07-06 12:50:31', '2016-08-20 00:00:00', 'Jo Bhi Hai'),
(19, 6, 3, 'Some New Project', '2016-07-06 13:17:18', '2016-07-07 00:00:00', 'And a new class');

--
-- Triggers `project`
--
DELIMITER $$
CREATE TRIGGER `CreatedAt` BEFORE INSERT ON `project`
 FOR EACH ROW SET new.`created_at` = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `summary` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_id`, `project_id`, `owner_id`, `created_at`, `summary`) VALUES
(30, 14, 7, '2016-07-06 10:41:14', 'Two member team of SE & ISM experts.'),
(31, 17, 7, '2016-07-06 11:28:49', 'This is a test of functionalities.'),
(32, 17, 7, '2016-07-06 11:34:49', 'Another Test to check member added.'),
(33, 18, 7, '2016-07-06 12:52:13', 'A team summaro for java.'),
(34, 19, 7, '2016-07-06 13:22:41', 'A new summary for team.'),
(35, 14, 7, '2016-07-06 13:29:25', 'jdf siodjf osdjf oidsj o');

--
-- Triggers `team`
--
DELIMITER $$
CREATE TRIGGER `CreationDate` BEFORE INSERT ON `team`
 FOR EACH ROW SET new.`created_at` = NOW()
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `DeleteMember` BEFORE DELETE ON `team`
 FOR EACH ROW DELETE FROM `team_member` WHERE (`team_id` = OLD.`team_id`)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `team_member`
--

CREATE TABLE `team_member` (
  `team_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team_member`
--

INSERT INTO `team_member` (`team_id`, `student_id`) VALUES
(30, 7),
(30, 13),
(30, 15),
(30, 16),
(31, 7),
(32, 6),
(32, 8),
(33, 7),
(33, 8),
(33, 14),
(33, 15),
(34, 6),
(34, 7),
(34, 13),
(35, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD UNIQUE KEY `un_class_name` (`name`);

--
-- Indexes for table `class_member`
--
ALTER TABLE `class_member`
  ADD PRIMARY KEY (`person_id`,`class_id`),
  ADD KEY `fk_class_member_member` (`person_id`),
  ADD KEY `fk_class_member_class` (`class_id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `fk_document_member` (`author_id`),
  ADD KEY `fk_document_team` (`team_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`),
  ADD UNIQUE KEY `un_person_email` (`email`),
  ADD UNIQUE KEY `un_person_contact` (`first_name`,`last_name`,`address`,`zip_code`,`town`,`mobile_phone`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `fk_project_member` (`owner_id`),
  ADD KEY `fk_project_class` (`class_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_id`),
  ADD KEY `fk_team_project` (`project_id`),
  ADD KEY `fk_team_member` (`owner_id`);

--
-- Indexes for table `team_member`
--
ALTER TABLE `team_member`
  ADD PRIMARY KEY (`team_id`,`student_id`),
  ADD KEY `fk_team_member_team` (`team_id`),
  ADD KEY `fk_team_member_person` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_member`
--
ALTER TABLE `class_member`
  ADD CONSTRAINT `fk_class_member_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_class_member_member` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `fk_document_member` FOREIGN KEY (`author_id`) REFERENCES `person` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_document_team` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_project_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_project_member` FOREIGN KEY (`owner_id`) REFERENCES `person` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `fk_team_member` FOREIGN KEY (`owner_id`) REFERENCES `person` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_team_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `team_member`
--
ALTER TABLE `team_member`
  ADD CONSTRAINT `fk_team_member_person` FOREIGN KEY (`student_id`) REFERENCES `person` (`person_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_team_member_team` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
