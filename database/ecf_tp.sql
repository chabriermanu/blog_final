-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 16 nov. 2025 à 09:01
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecf_tp`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartenance`
--

DROP TABLE IF EXISTS `appartenance`;
CREATE TABLE IF NOT EXISTS `appartenance` (
  `id_categorie` int NOT NULL,
  `id_article` int NOT NULL,
  PRIMARY KEY (`id_categorie`,`id_article`),
  KEY `fk_idArticle` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id_article` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `date_creation` date NOT NULL,
  `date_parution` date NOT NULL,
  `id_user` int NOT NULL,
  `picture` varchar(255) NOT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id_article`),
  KEY `fk_idUser` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `titre`, `date_creation`, `date_parution`, `id_user`, `picture`, `contenu`) VALUES
(2, 'dragonBall', '2025-11-15', '2025-11-15', 2, 'uploads/articles/article_6918dcd896de97.96230217.webp', '\"Dragon Ball\" est une saga culte de manga et d’animation japonaise créée par Akira Toriyama, qui suit l’évolution du héros Son Goku, de son enfance à ses combats cosmiques.\r\n\r\n🐉 Origines et univers\r\n- Créateur : Akira Toriyama\r\n- Première publication : 1984 dans Weekly Shōnen Jump\r\n- Inspiré de : La Pérégrination vers l’Ouest, un roman chinois classique.\r\nL’histoire débute avec Son Goku, un jeune garçon doté d’une queue de singe et d’une force surhumaine, vivant seul dans les montagnes. Il rencontre Bulma, une adolescente en quête des Dragon Balls, sept boules magiques capables d’exaucer n’importe quel vœu une fois réunies.\r\n'),
(3, 'streethawk', '2025-11-12', '2025-11-15', 2, 'uploads/articles/article_6918e0eace6dd6.27820711.jpg', '🏍️ Street Hawk (Tonnerre Mécanique)\r\n- Année : 1985\r\n- Créateurs : Robert Wolterstorff, Paul M. Belous\r\n- Acteurs principaux : Rex Smith (Jesse Mach), Joe Regalbuto (Norman Tuttle)\r\n- Nombre d’épisodes : 13\r\n- Diffusion en France : La Cinq dès 1986\r\nRésumé :\r\nJesse Mach, ancien policier et cascadeur blessé en service, est recruté par un ingénieur du gouvernement pour piloter une moto ultra-sophistiquée : le Street Hawk. Capable d’atteindre plus de 500 km/h et équipée d’armes high-tech, cette moto est utilisée pour des missions secrètes contre le crime. Jesse mène une double vie : fonctionnaire le jour, justicier masqué la nuit.\r\n\r\n\r\n'),
(4, 'airwolf', '2025-11-15', '2025-11-15', 2, 'uploads/articles/article_6918e1b2181677.48358829.jpg', '🚁 Airwolf (Supercopter)\r\n- Année : 1984–1987\r\n- Créateur : Donald P. Bellisario\r\n- Acteurs principaux : Jan-Michael Vincent (Stringfellow Hawke), Ernest Borgnine (Dominic Santini), Alex Cord (Archangel)\r\n- Nombre d’épisodes : 80 (4 saisons)\r\n- Diffusion en France : La Cinq dès 1986\r\nRésumé :\r\nStringfellow Hawke, pilote solitaire hanté par la disparition de son frère au Vietnam, est recruté par une agence secrète du gouvernement appelée La Firme. Il pilote Airwolf, un hélicoptère de combat supersonique doté de missiles, lasers et dispositifs furtifs. Refusant de rendre l’appareil tant que son frère n’est pas retrouvé, il accepte néanmoins des missions périlleuses pour le gouvernement, accompagné de son ami Santini.\r\n\r\n\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `couleur` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom_categorie`, `description`, `avatar`, `couleur`) VALUES
(2, 'Action', 'Séries dynamiques avec combats, poursuites et cascades', '💥', '#dc3545'),
(3, 'Aventure', 'Exploration, quêtes et découvertes épiques', '🗺️', '#fd7e14'),
(4, 'Comédie', 'Humour, situations comiques et moments légers', '😂', '#ffc107'),
(5, 'Drame', 'Histoires profondes centrées sur les émotions', '🎭', '#6c757d'),
(6, 'Science-Fiction', 'Futur, technologie et mondes imaginaires', '🚀', '#0dcaf0'),
(7, 'Fantastique', 'Magie, créatures mythiques et univers enchantés', '✨', '#9b59b6'),
(8, 'Horreur', 'Suspense, peur et atmosphères terrifiantes', '👻', '#212529'),
(9, 'Thriller', 'Tension, mystère et rebondissements', '🔪', '#6f42c1'),
(10, 'Policier', 'Enquêtes criminelles et résolution d\'énigmes', '🔍', '#495057'),
(11, 'Romance', 'Histoires d\'amour et relations sentimentales', '💕', '#f8a5c2'),
(12, 'Sitcom', 'Comédie de situation avec rires enregistrés', '📺', '#20c997'),
(13, 'Teen Drama', 'Adolescence, lycée et premiers amours', '🎒', '#e83e8c'),
(14, 'Médical', 'Hôpitaux, médecins et urgences médicales', '⚕️', '#198754'),
(15, 'Juridique', 'Tribunaux, avocats et affaires judiciaires', '⚖️', '#0d6efd'),
(16, 'Espionnage', 'Agents secrets, missions et complots', '🕵️', '#343a40'),
(17, 'Western', 'Cowboys, far-west et duels au soleil', '🤠', '#8b4513'),
(18, 'Animation', 'Dessins animés et séries animées variées', '🎨', '#ff6b6b'),
(19, 'Super-héros', 'Héros masqués avec pouvoirs extraordinaires', '🦸', '#0066cc'),
(20, 'Robots/Mecha', 'Robots géants et combats mécaniques', '🤖', '#607d8b'),
(21, 'Magical Girl', 'Jeunes filles aux pouvoirs magiques', '🌟', '#ff69b4'),
(22, 'Enfants', 'Programmes éducatifs et divertissants pour jeunes', '👶', '#ffeb3b'),
(23, 'Space Opera', 'Aventures spatiales et galaxies lointaines', '🌌', '#4a148c'),
(24, 'Surnaturel', 'Phénomènes paranormaux et forces occultes', '👽', '#7e57c2'),
(25, 'Sport', 'Compétitions sportives et dépassement de soi', '⚽', '#ff9800'),
(26, 'Arts Martiaux', 'Combat à mains nues et disciplines orientales', '🥋', '#d32f2f'),
(27, 'Historique', 'Événements et personnages du passé', '📜', '#795548'),
(28, 'Post-Apocalyptique', 'Survie après une catastrophe mondiale', '☢️', '#424242');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `id_article` int NOT NULL,
  `pseudo_visiteur` varchar(100) NOT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_parution` datetime DEFAULT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `fk_user` (`id_user`),
  KEY `fk_id_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `pseudo` varchar(25) NOT NULL,
  `type_user` varchar(30) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `date_inscription` date NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `email`, `password`, `pseudo`, `type_user`, `avatar`, `date_inscription`) VALUES
(2, 'chabrier.emmanuel@hotmail.fr', '$2y$10$UgkzKUAtE8feNceLdTTgIuxDpKbcF0y5Vlo2clJIiurPU1n7nG/fO', 'manuchab', 'auteur', NULL, '2025-11-15');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartenance`
--
ALTER TABLE `appartenance`
  ADD CONSTRAINT `fk_id_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_idArticle` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_idUser` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_id_article` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
