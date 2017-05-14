-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 14, 2017 at 05:29 PM
-- Server version: 5.7.18-0ubuntu0.17.04.1
-- PHP Version: 7.0.15-1ubuntu4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projetIO2`
--

-- --------------------------------------------------------

--
-- Table structure for table `commentaires`
--

CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `project` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `commentaire` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `date_send` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_to` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `date_send` datetime NOT NULL,
  `text_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `projets`
--

CREATE TABLE IF NOT EXISTS `projets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `owner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `nbr_upvote` bigint(20) NOT NULL,
  `nbr_downvote` bigint(20) NOT NULL,
  `participants` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `creation_date` datetime NOT NULL,
  `is_featured` int(11) NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL,
  `limit_date` datetime NOT NULL,
  `pictures` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `resume` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `username` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `profile_picture` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `biography` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `is_admin` int(11) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_premium` int(11) NOT NULL,
  `upvoted_projects` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `downvoted_projects` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
