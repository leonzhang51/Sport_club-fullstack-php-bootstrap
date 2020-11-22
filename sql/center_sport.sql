-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 02, 2019 at 08:04 PM
-- Server version: 5.6.38
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `center_sport`
--

-- --------------------------------------------------------

--
-- Table structure for table `activites`
--

CREATE TABLE `activites` (
  `id_activite` int(10) UNSIGNED NOT NULL,
  `nom_activite` varchar(45) NOT NULL,
  `categorie_activite` varchar(255) NOT NULL,
  `nombre_place_activite` int(10) UNSIGNED NOT NULL,
  `gestions_idgestions` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activites`
--

INSERT INTO `activites` (`id_activite`, `nom_activite`, `categorie_activite`, `nombre_place_activite`, `gestions_idgestions`) VALUES
(1, 'Yoga traditionnel', 'yoga', 34, 2),
(2, 'Yoga Hatha', 'yoga', 6, 2),
(3, 'Yoga Lyengar', 'yoga', 9, 2),
(4, 'Yoga Ashtanga', 'yoga', 8, 2),
(5, 'Vinyasa yoga', 'yoga', 13, 2),
(6, 'Bikram yoga', 'yoga', 0, 2),
(7, 'Yoga regenerator', 'yoga', 10, 2),
(8, 'Restorative yoga', 'yoga', 0, 2),
(9, 'Full body', 'musculation', 20, 3),
(10, 'Split body', 'musculation', 15, 3),
(11, 'Cross fit', 'musculation', 25, 3),
(12, 'Méthode Hiit', 'musculation', 30, 3),
(13, 'Méthode Lafay', 'musculation', 10, 3),
(14, 'Muscu TRX', 'musculation', 14, 3),
(15, 'Prise de masse', 'musculation', 14, 3),
(16, 'Méthode VIPR', 'musculation', 10, 3),
(17, 'classe enfants', 'natation', 19, 4),
(18, 'classe adultes', 'natation', 30, 4),
(19, 'classe ados', 'natation', 18, 4),
(20, 'classe Seniors', 'natation', 32, 4),
(21, 'Natation synchronisée', 'natation', 21, 4),
(22, 'Bébés nageurs', 'natation', 10, 4),
(23, 'Femmes enceintes', 'natation', 14, 4),
(24, 'Tennis juniors', 'tennis', 30, 5),
(25, 'Tennis Adultes', 'tennis', 25, 5),
(26, 'Tennis tactique', 'tennis', 20, 5),
(27, 'Tennis en double', 'tennis', 18, 5),
(28, 'Terre battue', 'tennis', 25, 5),
(29, 'Tennis ados', 'tennis', 20, 5),
(30, 'Prépa Compétition', 'tennis', 10, 5),
(31, 'Tennis technique', 'tennis', 10, 5),
(32, 'Parabasket', 'basketball', 25, 6),
(33, 'Basket ados', 'basketball', 15, 6),
(34, 'basket enfants', 'basketball', 20, 6),
(35, 'basket Adultes', 'basketball', 15, 6),
(36, 'Basket Stratégies', 'basketball', 20, 6),
(37, 'basket Ados', 'basketball', 20, 6),
(38, 'Équipe NDG', 'basketball', 20, 6);

-- --------------------------------------------------------

--
-- Table structure for table `gestions`
--

CREATE TABLE `gestions` (
  `idgestions` int(11) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `courriel` varchar(45) NOT NULL,
  `mot_de_passe` varchar(45) NOT NULL,
  `type` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gestions`
--

INSERT INTO `gestions` (`idgestions`, `nom`, `prenom`, `courriel`, `mot_de_passe`, `type`) VALUES
(1, 'Zhang', 'Lie', 'admin1@test.com', 'admin1', 3),
(2, 'Sorel', 'Julien', 'julien2@test.com', 'julien2', 2),
(3, 'Pitt', 'Brad', 'brad3@test.com', 'brad3', 2),
(4, 'Manaudou', 'Laure', 'laure4@test.com', 'laure4', 2),
(5, 'Nadal', 'Raphael', 'raphael5@test.com', 'nadal5', 2),
(6, 'Parker', 'Tony', 'tony6@test.com', 'tony6', 2),
(7, 'Biel', 'Jessica', 'jessica7@test.com', 'jessica7', 2);

-- --------------------------------------------------------

--
-- Table structure for table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id_inscription` int(10) UNSIGNED NOT NULL,
  `utilisateurs_id_utilisateur` int(10) UNSIGNED NOT NULL,
  `activites_id_activite` int(10) UNSIGNED NOT NULL,
  `date_paiement_inscription` date NOT NULL,
  `statut_inscription` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inscriptions`
--

INSERT INTO `inscriptions` (`id_inscription`, `utilisateurs_id_utilisateur`, `activites_id_activite`, `date_paiement_inscription`, `statut_inscription`) VALUES
(1, 1, 1, '2019-01-01', 'pay'),
(2, 2, 1, '2019-01-01', 'pay'),
(3, 3, 1, '2019-01-01', 'pay'),
(4, 4, 1, '2019-01-01', 'pay'),
(5, 5, 1, '2019-01-01', 'pay'),
(6, 6, 2, '2019-01-02', 'pay'),
(7, 7, 2, '2019-01-02', 'pay'),
(9, 9, 3, '2019-01-03', 'pay'),
(10, 10, 3, '2019-01-03', 'pay'),
(11, 11, 3, '2019-01-03', 'pending'),
(12, 12, 4, '2019-01-04', 'pay'),
(13, 13, 4, '2019-01-04', 'pay'),
(14, 14, 4, '2019-01-04', 'pending'),
(16, 16, 5, '2019-01-05', 'pending'),
(17, 17, 5, '2019-01-05', 'pending'),
(19, 1, 7, '0000-00-00', 'pending'),
(20, 1, 8, '2019-01-26', 'pending'),
(62, 64, 1, '2019-01-26', 'pay'),
(63, 64, 2, '2019-01-26', 'pending'),
(64, 64, 3, '2019-01-26', 'pay'),
(65, 64, 8, '2019-01-26', 'pending'),
(66, 64, 5, '2019-01-26', 'pending'),
(67, 66, 8, '2019-01-26', 'pending'),
(68, 64, 10, '2019-01-27', 'pending'),
(69, 64, 4, '2019-01-27', 'pending'),
(70, 66, 1, '2019-01-29', 'pay'),
(71, 66, 5, '2019-01-30', 'pending'),
(72, 66, 4, '2019-01-30', 'pending'),
(73, 66, 2, '2019-01-30', 'pending'),
(74, 66, 3, '2019-01-30', 'pending'),
(75, 66, 7, '2019-01-31', 'pending'),
(76, 67, 1, '2019-01-31', 'pending'),
(77, 66, 17, '2019-02-02', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(10) UNSIGNED NOT NULL,
  `nom_utilisateur` varchar(45) NOT NULL,
  `prenom_utilisateur` varchar(45) NOT NULL,
  `courriel_utilisateur` varchar(45) NOT NULL,
  `mot_de_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(20, 'user20', 'sport', 'user20@test.com', 'user20'),
(21, 'Camus', 'Albert', 'camus1@test.com', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(22, 'Dubois', 'Jean', 'dubois1@test.com', '307743e40cc04bfd44b798ff4e55be5d13309280e17ec'),
(23, 'Dubois', 'Jean', 'dubois1@test.com', '307743e40cc04bfd44b798ff4e55be5d13309280e17ec'),
(24, 'Dubois', 'Jean', 'dubois1@test.com', '307743e40cc04bfd44b798ff4e55be5d13309280e17ec'),
(25, 'Dubois', 'Jean', 'dubois1@test.com', '307743e40cc04bfd44b798ff4e55be5d13309280e17ec'),
(26, 'Dubois', 'Jean', 'dubois1@test.com', '307743e40cc04bfd44b798ff4e55be5d13309280e17ec'),
(27, 'Dubois', 'Jean', 'dubois1@test.com', '307743e40cc04bfd44b798ff4e55be5d13309280e17ec'),
(28, 'Dubois', 'Jean', 'dubois1@test.com', '307743e40cc04bfd44b798ff4e55be5d13309280e17ec'),
(29, 'Dubois', 'Jean', 'dubois1@test.com', '307743e40cc04bfd44b798ff4e55be5d13309280e17ec'),
(30, 'Bernanos', 'Georges', 'srhidichuk@hotmail.com', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(31, 'Vicente', 'Nicolas', 'srhidichuk@hotmail.com', 'a4c399fd11710a3fbf1d8b109b757e70953a29023dcd5'),
(32, 'Vicente', 'Nicolas', 'srhidichuk@hotmail.com', 'a4c399fd11710a3fbf1d8b109b757e70953a29023dcd5'),
(33, 'Vicente', 'Nicolas', 'srhidichuk@hotmail.com', 'a4c399fd11710a3fbf1d8b109b757e70953a29023dcd5'),
(34, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '1b4f0e9851971998e732078544c96b36c3d01cedf7caa'),
(35, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '1b4f0e9851971998e732078544c96b36c3d01cedf7caa'),
(36, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '1b4f0e9851971998e732078544c96b36c3d01cedf7caa'),
(37, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '1b4f0e9851971998e732078544c96b36c3d01cedf7caa'),
(38, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(39, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(40, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(41, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(42, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(43, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(44, 'Oliveira', '12', 'user3@test.com', '307743e40cc04bfd44b798ff4e55be5d13309280e17ec'),
(45, 'oliveira', 'Jorge', 'srhidichuk@hotmail.com', '1b4f0e9851971998e732078544c96b36c3d01cedf7caa'),
(46, 'oliveira', 'Jorge', 'salut1@test.com', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(47, 'oliveira', 'Jorge', 'camus1@salut.com', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(48, 'Latour', 'Jorge', 'srhidichuk@hotmail.org', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(49, 'Latour', 'Jorge', 'srhidichuk@hotmail.ca', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(50, 'Latour', 'Jorge', 'srhidichuk@hotmail.fr', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(51, 'Latour', 'Jorge', 'srhidichuk@hotmail.be', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(52, 'Latour', 'Serge', 'srhidichuk@hotmail.sp', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(53, 'Latour', 'Serge', 'srhidichuk@hotmail.jh', '8705589bfb1e156ce82ffa2cbc9a2199faf7ca38287bc'),
(54, 'Oliveira', 'Jorge', 'jorge1@test.com', '1b4f0e9851971998e732078544c96b36c3d01cedf7caa'),
(55, 'Oliveira', 'Jorge', 'jo1@test.com', '9563cd9a8739ce16fc4b3e87ba85531ebdb5afc81d83d'),
(56, 'essai', 'essai', 'essai1@test.com', 'd653e37e05dbc23db90a44862b845868257d69f50fad0'),
(57, 'essai', 'essai', 'essai2@test.com', 'essai2'),
(58, 'essai', 'essai', 'essai3@test.com', 'essai2'),
(59, 'essai', 'essai', 'essai4@test.com', 'essai2'),
(60, 'essai', 'essai', 'essai5@test.com', 'essai2'),
(61, 'essai', 'essai', 'essai6@test.com', 'essai2'),
(62, 'essai', 'essai', 'essai10@test.com', 'essai9'),
(63, 'essai', 'essai', 'carre1@test.com', '2c931544146694ad403a550a18d0dbc7cd66753207561'),
(64, 'essai', 'essai', 'carre2@test.com', '139274c51484877949636a49ad07ed5c3e1823daee3f27ce780379bb4c4d10a2'),
(65, 'essai', 'essai', 'carre3@test.com', 'c8476ae3ffc66e711426b4d97af78287c5c8f73eeacd87459a7c9fb837cc274b'),
(66, 'Oliveira', 'Jorge', 'jorge.test@test.com', 'db5069f1410794b7942f6c3604a379f24427a651d698dc4dbcfe175f2a573c64'),
(67, 'Hidichuk', 'Terry', 'hidichuk1@hotmail.com', '9a733d49c5df58f3b82810033d2418f67dc49705fb022e1e9f4c5d20937d83d3'),
(68, 'samuel', 'samuel', 'samuel1@test.com', 'f7e5cc70385fc58338bd8328fab5a7257c24ff660c4277d1ef7b7c621468bf1b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activites`
--
ALTER TABLE `activites`
  ADD PRIMARY KEY (`id_activite`,`gestions_idgestions`),
  ADD KEY `fk_activites_gestions1_idx` (`gestions_idgestions`);

--
-- Indexes for table `gestions`
--
ALTER TABLE `gestions`
  ADD PRIMARY KEY (`idgestions`);

--
-- Indexes for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`id_inscription`),
  ADD KEY `fk_utilisateurs_has_activites_activites1_idx` (`activites_id_activite`),
  ADD KEY `fk_utilisateurs_has_activites_utilisateurs1_idx` (`utilisateurs_id_utilisateur`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activites`
--
ALTER TABLE `activites`
  MODIFY `id_activite` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `gestions`
--
ALTER TABLE `gestions`
  MODIFY `idgestions` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `id_inscription` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
