-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  mar. 07 avr. 2020 à 19:10
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `electrorepair`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

DROP TABLE IF EXISTS `annonce`;
CREATE TABLE IF NOT EXISTS `annonce` (
  `IDannonce` int(11) NOT NULL AUTO_INCREMENT,
  `Titre` varchar(50) NOT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `IMAGE1` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'https://www.autronix.fr/_media/img/large/2-electronique-haute-resolution.jpg',
  `IMAGE2` text NOT NULL,
  `IMAGE3` text NOT NULL,
  `CodeCat` int(11) NOT NULL,
  `codeUser` int(11) NOT NULL,
  PRIMARY KEY (`IDannonce`),
  KEY `FK_Annonce_CATEGORIEAnnonce` (`CodeCat`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`IDannonce`, `Titre`, `Description`, `IMAGE1`, `IMAGE2`, `IMAGE3`, `CodeCat`, `codeUser`) VALUES
(53, 'Télémazon', 'Je répare les écrans des téléphones', 'https://blog-content.bilingueanglais.com/uploads/2019/02/regarder-la-tele-en-anglais.jpg', '', '', 5, 20);

-- --------------------------------------------------------

--
-- Structure de la table `categorieannonce`
--

DROP TABLE IF EXISTS `categorieannonce`;
CREATE TABLE IF NOT EXISTS `categorieannonce` (
  `IDCat` int(11) NOT NULL,
  `NomCat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`IDCat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorieannonce`
--

INSERT INTO `categorieannonce` (`IDCat`, `NomCat`) VALUES
(0,'telephoneNeDemarrePas'),
(1,'telephoneNemetPlusDeSons'),
(2,'telephoneNeChargePas'),
(3,'telephoneAVuSesPerformancesDiminuerEstInfecte'),
(4,'telephoneAVuSesPerformancesDiminuerAutre'),
(5,'telephoneNAfficheRienLEcranEstCasse'),
(6,'telephoneNAfficheRienAutre'),
(7,'ordinateurFixeNeDemarrePas'),
(8,'ordinateurFixeNAfficheRien'),
(9,'ordinateurFixeAVuSesPerformancesDiminuerEstInfecte'),
(10,'tabletteNeDemarrePas'),
(11,'tabletteNeChargePas'),
(12,'tabletteNemetPlusDeSons'),
(13,'tabletteNAfficheRienLEcranEstCasse'),
(14,'tabletteNAfficheRienAutre'),
(15,'ordinateurPortableNeDemarrePas'),
(16,'ordinateurPortableNeChargePas'),
(17,'ordinateurPortableNemetPlusDeSons'),
(18,'ordinateurPortableAVuSesPerformancesDiminuerEstInfecte'),
(19,'ordinateurPortableAVuSesPerformancesDiminuerAutre'),
(20,'ordinateurPortableNAfficheRienLEcranEstCasse'),
(21,'ordinateurPortableNAfficheRienAutre');


-- --------------------------------------------------------

--
-- Structure de la table `categorieuser`
--

DROP TABLE IF EXISTS `categorieuser`;
CREATE TABLE IF NOT EXISTS `categorieuser` (
  `IDcat` int(11) NOT NULL,
  `NomCat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`IDcat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorieuser`
--

INSERT INTO `categorieuser` (`IDcat`, `NomCat`) VALUES
(1, 'Professionnel'),
(2, 'Consommateur'),
(3, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `IDuser` int(11) NOT NULL AUTO_INCREMENT,
  `PassWord` varchar(1000) DEFAULT NULL,
  `DateInscription` datetime DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(1000) DEFAULT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Adresse` varchar(1000) NOT NULL,
  `CP` int(11) NOT NULL,
  `Ville` varchar(1000) NOT NULL,
  `Codecat` int(11) DEFAULT NULL,
  `CalendarId` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`IDuser`),
  KEY `FK_USER_CATEGORIEUser` (`Codecat`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`IDuser`, `PassWord`, `DateInscription`, `email`, `Prenom`, `Nom`, `Adresse`, `CP`, `Ville`, `Codecat`, `CalendarId`) VALUES
(1, '$2y$12$tu7EbVtdib22TuT4etiXZ.KBX8IPd1NXoezLBlgs9vDpsEU45E6eG', '2020-03-18 11:02:19', 'gregoire.hage@gmail.com', 'Grégoire', 'Hage', '13 rue du commandant cousteau', 59251, 'Allennes les marais', 2, ''),
(21, '$2y$12$gHb7Sqw5SU9XiR3EYuNPy.R29nSH6.L7kGCJxJdYWGXzVNkuxnPNi', '2020-04-08 11:05:42', 'yohan.widogue@epsi.fr', 'Yohan', 'Widogue', '13 rue de potier', 59000, 'Lille', 1, 'a033v97947ln0vuc6rdsi272uk@group.calendar.google.com');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`CodeCat`) REFERENCES `categorieannonce` (`IDCat`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_USER_CATEGORIEUser` FOREIGN KEY (`Codecat`) REFERENCES `categorieuser` (`IDcat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
