-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 28, 2019 at 07:02 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `center_sport`
--

-- --------------------------------------------------------

--
-- Table structure for table `activites`
--

DROP TABLE IF EXISTS `activites`;
CREATE TABLE IF NOT EXISTS `activites` (
  `id_activite` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_activite` varchar(45) NOT NULL,
  `categorie_activite` varchar(45) NOT NULL,
  `nombre_place_activite` int(10) UNSIGNED NOT NULL,
  `gestions_idgestions` int(11) NOT NULL,
  PRIMARY KEY (`id_activite`,`gestions_idgestions`),
  KEY `fk_activites_gestions1_idx` (`gestions_idgestions`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activites`
--

INSERT INTO `activites` (`id_activite`, `nom_activite`, `categorie_activite`, `nombre_place_activite`, `gestions_idgestions`) VALUES
(1, 'activitie1', 'yoga', 20, 2),
(2, 'activitie2', 'gymnastique', 20, 3),
(3, 'activitie3', 'natation', 20, 6),
(4, 'activitie4', 'tennis', 20, 5),
(5, 'activitie5', 'soccer', 20, 11),
(7, 'act11', 'table_tennis', 30, 12),
(8, 'act1299', 'yogaooooo', 300, 7);

-- --------------------------------------------------------

--
-- Table structure for table `gestions`
--

DROP TABLE IF EXISTS `gestions`;
CREATE TABLE IF NOT EXISTS `gestions` (
  `idgestions` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `courriel` varchar(45) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`idgestions`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gestions`
--

INSERT INTO `gestions` (`idgestions`, `nom`, `prenom`, `courriel`, `mot_de_passe`, `type`) VALUES
(1, 'admin', 'sport', 'admin@test.com', 'admin', 'administrator'),
(2, 'animateur1', 'yoga', 'animateur@test.com', 'animateur', 'animateur'),
(5, 'animateur4', 'tennis', 'animateur@test.com', 'animateur', 'animateur'),
(6, 'animateur5', 'soccer', 'animateur@test.com', 'animateur', 'animateur'),
(7, 'animateur6', 'badminton', 'animateur@test.com', 'animateur', 'animateur'),
(11, 'lie', 'z111', 'animateur@test.com', 'animateur', 'animateur'),
(12, 'user12', 'test12', 'animateur@test.com', 'animateur', 'animateur'),
(13, 'animateur13', 'test13', 'animateur@test.com', 'animateur', 'animateur'),
(14, 'animateur14', 'test14', 'animateur@test.com', 'animateur', 'animateur'),
(15, 'act11', 'animateur15', 'animateur@test.com', 'animateur', 'animateur'),
(16, 'jorge', 'test', 'animateur@test.com', 'animateur', 'animateur');

-- --------------------------------------------------------

--
-- Table structure for table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id_inscription` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `utilisateurs_id_utilisateur` int(10) UNSIGNED NOT NULL,
  `activites_id_activite` int(10) UNSIGNED NOT NULL,
  `date_paiement_inscription` date DEFAULT NULL,
  `statut_inscription` varchar(45) NOT NULL,
  PRIMARY KEY (`id_inscription`),
  KEY `fk_utilisateurs_has_activites_activites1_idx` (`activites_id_activite`),
  KEY `fk_utilisateurs_has_activites_utilisateurs1_idx` (`utilisateurs_id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inscriptions`
--

INSERT INTO `inscriptions` (`id_inscription`, `utilisateurs_id_utilisateur`, `activites_id_activite`, `date_paiement_inscription`, `statut_inscription`) VALUES
(6, 6, 2, '2019-01-02', 'pay'),
(12, 12, 4, '2019-01-04', 'pay'),
(15, 15, 5, '2019-01-05', 'pay'),
(18, 18, 2, '2019-01-06', 'pay'),
(21, 12, 8, '2019-01-01', 'pay'),
(24, 3, 3, '2019-01-01', 'pending'),
(25, 4, 4, '2019-01-01', 'pending'),
(26, 5, 5, '2019-01-01', 'pending'),
(27, 6, 7, '2019-01-01', 'pending'),
(28, 7, 8, '2019-01-01', 'pending'),
(29, 8, 1, '2019-01-01', 'pay'),
(30, 9, 2, '2019-01-01', 'pending'),
(31, 10, 3, '2019-01-01', 'pending'),
(32, 11, 4, '2019-01-01', 'pending'),
(33, 12, 5, '2019-01-01', 'pending'),
(34, 13, 7, '2019-01-01', 'pending'),
(35, 14, 8, '2019-01-01', 'pending'),
(36, 15, 1, '2019-01-01', 'pending'),
(37, 16, 2, '2019-01-01', 'pending'),
(38, 17, 3, '2019-01-01', 'pending'),
(39, 18, 4, '2019-01-01', 'pending'),
(40, 19, 5, '2019-01-01', 'pending'),
(41, 20, 7, '2019-01-01', 'pending'),
(42, 1, 8, '2019-01-01', 'pending'),
(43, 2, 1, '2019-01-01', 'pending'),
(44, 3, 2, '2019-01-01', 'pending'),
(45, 4, 3, '2019-01-01', 'pending'),
(46, 5, 4, '2019-01-01', 'pending'),
(47, 6, 5, '2019-01-01', 'pending'),
(48, 7, 7, '2019-01-01', 'pending'),
(49, 8, 8, '2019-01-01', 'pending'),
(50, 9, 1, '2019-01-01', 'pending'),
(51, 10, 2, '2019-01-01', 'pending'),
(52, 11, 3, '2019-01-01', 'pending'),
(53, 12, 4, '2019-01-01', 'pending'),
(54, 13, 5, '2019-01-01', 'pending'),
(55, 14, 7, '2019-01-01', 'pending'),
(57, 16, 1, '2019-01-01', 'pending'),
(58, 17, 2, '2019-01-01', 'pending'),
(59, 18, 8, '2019-01-01', 'pending'),
(60, 3, 1, '2019-01-16', 'pending'),
(61, 1, 1, '2019-01-16', 'pending'),
(62, 4, 1, '2019-01-16', 'pay'),
(63, 5, 1, '2019-01-16', 'pending'),
(64, 6, 1, '2019-01-16', 'pay'),
(65, 7, 1, '2019-01-16', 'pending'),
(66, 8, 1, '2019-01-16', 'pay'),
(67, 10, 1, '2019-01-16', 'pending'),
(68, 11, 1, '2019-01-16', 'pay'),
(69, 12, 1, '2019-01-16', 'pending'),
(70, 13, 1, '2019-01-16', 'pay'),
(71, 14, 1, '2019-01-16', 'pending'),
(72, 17, 1, '2019-01-16', 'pay'),
(73, 18, 1, '2019-01-16', 'pending'),
(74, 19, 1, '2019-01-16', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(45) NOT NULL,
  `prenom_utilisateur` varchar(45) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `province` varchar(25) NOT NULL,
  `code_postal` varchar(25) NOT NULL,
  `courriel_utilisateur` varchar(45) NOT NULL,
  `mot_de_pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom_utilisateur`, `prenom_utilisateur`, `adresse`, `ville`, `province`, `code_postal`, `courriel_utilisateur`, `mot_de_pass`) VALUES
(1, 'user1', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(2, 'user2', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(3, 'user3', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(4, 'user4', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(5, 'user5', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(6, 'user6', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(7, 'user7', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(8, 'user8', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(9, 'user9', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(10, 'user10', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(11, 'user11', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(12, 'user12', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(13, 'user13', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(14, 'user14', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(15, 'user15', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(16, 'user16', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(17, 'user17', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(18, 'user18', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(19, 'user19', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user'),
(20, 'user20', 'sport', '123 main st', 'Montréal', 'Quebec', 'H2W 1H3', 'user@test.com', 'user');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activites`
--
ALTER TABLE `activites`
  ADD CONSTRAINT `fk_activites_gestions1` FOREIGN KEY (`gestions_idgestions`) REFERENCES `gestions` (`idgestions`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `fk_utilisateurs_has_activites_activites1` FOREIGN KEY (`activites_id_activite`) REFERENCES `activites` (`id_activite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_utilisateurs_has_activites_utilisateurs1` FOREIGN KEY (`utilisateurs_id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
