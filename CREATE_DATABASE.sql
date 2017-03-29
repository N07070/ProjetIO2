-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 29, 2017 at 09:16 AM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projetIO2`
--
CREATE DATABASE IF NOT EXISTS `projetIO2` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `projetIO2`;

-- --------------------------------------------------------

--
-- Table structure for table `commentaires`
--

CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` text NOT NULL,
  `project` text NOT NULL,
  `commentaire` text NOT NULL,
  `user` text NOT NULL,
  `date_send` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commentaires`
--

INSERT INTO `commentaires` (`id`, `uuid`, `project`, `commentaire`, `user`, `date_send`) VALUES
(1, '5af1837a-2e36-4dc4-a7f2-c7a28629f665', '835b0e98-8760-458b-99bf-3274cfe4afce', 'Cool project bro', 'd91a54be-632f-41aa-b196-a7334b936c40', '2017-03-27 10:05:15');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from` text NOT NULL,
  `user_to` text NOT NULL,
  `date_send` datetime NOT NULL,
  `text_message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_from`, `user_to`, `date_send`, `text_message`) VALUES
(1, '083aaeec-db00-4e77-ab7b-b345849a6cbf', 'd91a54be-632f-41aa-b196-a7334b936c40', '2017-03-27 00:00:00', 'Hello World');

-- --------------------------------------------------------

--
-- Table structure for table `projets`
--

CREATE TABLE IF NOT EXISTS `projets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` text NOT NULL,
  `owner` text NOT NULL,
  `nbr_upvote` bigint(20) NOT NULL,
  `nbr_downvote` bigint(20) NOT NULL,
  `participants` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `is_featured` int(11) NOT NULL,
  `title` text NOT NULL,
  `tags` text NOT NULL,
  `status` int(11) NOT NULL,
  `limit_date` datetime NOT NULL,
  `pictures` text NOT NULL,
  `resume` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projets`
--

INSERT INTO `projets` (`id`, `uuid`, `owner`, `nbr_upvote`, `nbr_downvote`, `participants`, `creation_date`, `is_featured`, `title`, `tags`, `status`, `limit_date`, `pictures`, `resume`, `description`) VALUES
(1, '835b0e98-8760-458b-99bf-3274cfe4afce', '083aaeec-db00-4e77-ab7b-b345849a6cbf', 1, 0, 'derp,', '2017-03-27 11:58:00', 0, 'Default Project', 'test,project,', 1, '2017-04-27 00:00:00', '835b0e98-8760-458b-99bf-3274cfe4afce.jpg', 'Projet d\'Internet et Outils de première année.\r\n', '# Project\r\n\r\n*Projet d\'Internet et Outil du deuxième semestre de la fac Paris 7*\r\n\r\n## Présentation\r\n\r\n**Abstract**\r\n\r\nTanlax est un site web qui permet aux étudiant.es de la fac de Paris Diderot de déposer et chercher des projets qu\'ils cherchent à réaliser avec d\'autres étudiant.es. Les projets sont triés selon leur popularité et peuvent être haut-voté ou bas-voté\r\n\r\nL\'expérience utilisateur typique commence quand on arrive sur la page d\'acceuil ou des projets sont mit en avant en fonction de leur popularité ou si ils viennent d\'être posté.\r\n\r\nLe site se compose des pages suivantes :\r\n- Un profil utilisateur\r\n    - Page de login + signup\r\n    - Page de préférence du compte\r\n        - Photo de profil\r\n        - Infor perso\r\n        - changement de mot de passe\r\n        - thème\r\n        - Accessibilité\r\n        - Désincription / suppression de compte\r\n- Page d\'acceuil\r\n    - Page spécifique à un message\r\n        - Commentaires\r\n        - Vote\r\n- Page de recherche / tags\r\n- Page de post de message\r\n- Page de messagerie entre utilisateurs\r\n- Page d\'erreurs\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `username` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `profile_picture` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `biography` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `is_admin` int(11) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_premium` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `uuid`, `username`, `email`, `password`, `profile_picture`, `biography`, `is_admin`, `date_creation`, `is_premium`) VALUES
(1, '083aaeec-db00-4e77-ab7b-b345849a6cbf', 'derp', 'derp@derp.com', '123', '083aaeec-db00-4e77-ab7b-b345849a6cbf.jpg', 'A testing user', 1, '2017-03-27 10:00:41', 1),
(2, 'd91a54be-632f-41aa-b196-a7334b936c40', 'swan', 'swan@derp.com', '123', 'd91a54be-632f-41aa-b196-a7334b936c40.jpg', 'Swan is a test user', 1, '2017-03-27 10:01:29', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
