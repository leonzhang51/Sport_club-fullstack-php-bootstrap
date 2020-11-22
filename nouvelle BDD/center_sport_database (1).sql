-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 21, 2019 at 05:16 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activites`
--

INSERT INTO `activites` (`id_activite`, `nom_activite`, `categorie_activite`, `nombre_place_activite`, `gestions_idgestions`) VALUES
(1, 'Yoga traditionnel', 'yoga', 1, 2),
(2, 'Hatha Yoga', 'yoga', 12, 2),
(3, 'Iyengar yoga', 'yoga', 17, 2),
(4, 'Ashtanga yoga', 'yoga', 14, 2),
(5, 'Vinyasa yoga', 'yoga', 17, 2),
(6, 'Bikram yoga', 'yoga', 18, 2),
(7, 'Yin yoga', 'yoga', 4, 2),
(8, 'Restorative yoga', 'yoga', 5, 2),
(9, 'Anusara yoga', 'yoga', 6, 2),
(10, 'Prenatal yoga', 'yoga', 14, 2),
(11, 'Jivamukti yoga', 'yoga', 8, 2);

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
  `mot_de_passe` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`idgestions`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gestions`
--

INSERT INTO `gestions` (`idgestions`, `nom`, `prenom`, `courriel`, `mot_de_passe`, `type`) VALUES
(1, 'admin', 'sport', 'admin@test.com', 'admin', 'administrator'),
(2, 'animateur1', 'yoga', 'animateur@test.com', 'animateur', 'animateur'),
(3, 'animateur2', 'gymnastique', 'animateur@test.com', 'animateur', 'animateur'),
(4, 'animateur3', 'natation', 'animateur@test.com', 'animateur', 'animateur'),
(5, 'animateur4', 'tennis', 'animateur@test.com', 'animateur', 'animateur'),
(6, 'animateur5', 'soccer', 'animateur@test.com', 'animateur', 'animateur'),
(7, 'animateur6', 'badminton', 'animateur@test.com', 'animateur', 'animateur');

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inscriptions`
--

INSERT INTO `inscriptions` (`id_inscription`, `utilisateurs_id_utilisateur`, `activites_id_activite`, `date_paiement_inscription`, `statut_inscription`) VALUES
(1, 1, 1, '2019-01-01', 'pay'),
(2, 2, 1, '2019-01-01', 'pay'),
(3, 3, 1, '2019-01-01', 'pay'),
(4, 4, 1, '2019-01-01', 'pending'),
(5, 5, 1, '2019-01-01', 'pending'),
(6, 6, 2, '2019-01-02', 'pay'),
(7, 7, 2, '2019-01-02', 'pending'),
(8, 8, 2, '2019-01-02', 'pending'),
(9, 9, 3, '2019-01-03', 'pay'),
(10, 10, 3, '2019-01-03', 'pending'),
(11, 11, 3, '2019-01-03', 'pending'),
(12, 12, 4, '2019-01-04', 'pay'),
(13, 13, 4, '2019-01-04', 'pending'),
(14, 14, 4, '2019-01-04', 'pending'),
(15, 15, 5, '2019-01-05', 'pay'),
(16, 16, 5, '2019-01-05', 'pending'),
(17, 17, 5, '2019-01-05', 'pending'),
(18, 18, 6, '2019-01-06', 'pay');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(45) NOT NULL,
  `prenom_utilisateur` varchar(45) NOT NULL,
  `courriel_utilisateur` varchar(45) NOT NULL,
  `mot_de_pass` varchar(45) NOT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom_utilisateur`, `prenom_utilisateur`, `courriel_utilisateur`, `mot_de_pass`) VALUES
(1, 'user1', 'sport', 'user1@test.com', 'user1'),
(2, 'user2', 'sport', 'user2@test.com', 'user2'),
(3, 'user3', 'sport', 'user3@test.com', 'user3'),
(4, 'user4', 'sport', 'user4@test.com', 'user4'),
(5, 'user5', 'sport', 'user5@test.com', 'user5'),
(6, 'user6', 'sport', 'user6@test.com', 'user6'),
(7, 'user7', 'sport', 'user7@test.com', 'user7'),
(8, 'user8', 'sport', 'user8@test.com', 'user8'),
(9, 'user9', 'sport', 'user9@test.com', 'user9'),
(10, 'user10', 'sport', 'user10@test.com', 'user10'),
(11, 'user11', 'sport', 'user11@test.com', 'user11'),
(12, 'user12', 'sport', 'user12@test.com', 'user12'),
(13, 'user13', 'sport', 'user13@test.com', 'user13'),
(14, 'user14', 'sport', 'user14@test.com', 'user14'),
(15, 'user15', 'sport', 'user15@test.com', 'user15'),
(16, 'user16', 'sport', 'user16@test.com', 'user16'),
(17, 'user17', 'sport', 'user17@test.com', 'user17'),
(18, 'user18', 'sport', 'user18@test.com', 'user18'),
(19, 'user19', 'sport', 'user19@test.com', 'user19'),
(20, 'user20', 'sport', 'user20@test.com', 'user20');

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
