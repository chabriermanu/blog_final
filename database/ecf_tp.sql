-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 19 nov. 2025 à 19:28
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

--
-- Déchargement des données de la table `appartenance`
--

INSERT INTO `appartenance` (`id_categorie`, `id_article`) VALUES
(2, 2),
(3, 2),
(4, 2),
(7, 2),
(18, 2),
(19, 2),
(26, 2),
(2, 5),
(6, 5),
(10, 5),
(16, 5),
(2, 6),
(6, 6),
(10, 6),
(2, 7),
(3, 7),
(4, 7),
(2, 8),
(3, 8),
(6, 8),
(16, 8),
(2, 9),
(3, 9),
(13, 9),
(18, 9),
(25, 9);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `titre`, `date_creation`, `date_parution`, `id_user`, `picture`, `contenu`) VALUES
(2, 'dragonBall', '2025-11-15', '2025-11-15', 2, 'uploads/articles/article_691ce97a8637c4.75576045.webp', '\"Dragon Ball\" est une saga culte de manga et d’animation japonaise créée par Akira Toriyama, qui suit l’évolution du héros Son Goku, de son enfance à ses combats cosmiques.\r\n\r\n🐉 Origines et univers\r\n- Créateur : Akira Toriyama\r\n- Première publication : 1984 dans Weekly Shōnen Jump\r\n- Inspiré de : La Pérégrination vers l’Ouest, un roman chinois classique.\r\nL’histoire débute avec Son Goku, un jeune garçon doté d’une queue de singe et d’une force surhumaine, vivant seul dans les montagnes. Il rencontre Bulma, une adolescente en quête des Dragon Balls, sept boules magiques capables d’exaucer n’importe quel vœu une fois réunies.\r\n'),
(5, 'streethawk', '2025-11-18', '2025-11-18', 2, 'uploads/articles/article_691ce8fa0aea77.01260983.jpg', '📺 Street Hawk (Tonnerre Mécanique en France)\r\n📝 Résumé :\r\nStreet Hawk est une série télévisée américaine diffusée en 1985 sur ABC, suivant Jesse Mach, un officier de police motard blessé lors d\'une intervention où son partenaire trouve la mort. Recruté pour une mission top secrète du gouvernement américain, Jesse devient le pilote du \"Tonnerre Mécanique\" (Street Hawk), une moto de combat ultra-sophistiquée capable d\'atteindre 480 km/h et équipée d\'un armement complet incluant laser, mitrailleuses et lance-roquettes WikipediaIusedtowatchthis.\r\nLe jour, Jesse travaille comme agent des relations publiques de la police, et la nuit, il combat le crime avec sa moto futuriste, tandis que seul l\'agent fédéral Norman Tuttle connaît sa véritable identité Wikipedia.\r\n📊 Infos clés :\r\n\r\nDiffusion originale : 4 janvier 1985 - 16 mai 1985 (13 épisodes)\r\nEn France : Diffusée à partir d\'avril 1986 sur La Cinq dans l\'émission \"À fond la caisse\"\r\nActeurs principaux : Rex Smith (Jesse Mach), Joe Regalbuto (Norman Tuttle)\r\nMusique : Tangerine Dream (groupe légendaire allemand)'),
(6, ' K2000 (Knight Rider)', '2025-11-18', '2025-11-18', 2, 'uploads/articles/article_691cea8250baa9.23289761.jpg', 'Voici les 3 séries cultes Emmanuel ! 🚗💥🔧\r\n\r\n1️⃣ K2000 (Knight Rider)\r\n📝 Résumé :\r\nK2000 est une série télévisée américaine diffusée de 1982 à 1986 sur NBC (90 épisodes). Le policier Michael Long, laissé pour mort, est sauvé par le milliardaire Wilton Knight qui lui donne un nouveau visage et une nouvelle identité : Michael Knight. Sa mission est de lutter contre le crime en pilotant KITT, une Pontiac Firebird Trans Am noire dotée d\'une intelligence artificielle, quasi indestructible et équipée de technologies révolutionnaires comme le scanner frontal rouge, le blindage moléculaire et le Turbo Boost permettant des sauts spectaculaires WikipediaVoiture de Film.\r\nDiffusion France : À partir du 22 avril 1986 sur La Cinq dans \"À fond la caisse\"'),
(7, 'L\'Agence tous risques (The A-Team)', '2025-11-18', '2025-11-18', 2, 'uploads/articles/article_691ceae7826be9.55486875.webp', 'L\'Agence tous risques (The A-Team)\r\n📝 Résumé :\r\nL\'Agence tous risques est une série américaine créée par Stephen J. Cannell et Frank Lupo, diffusée de 1983 à 1987 sur NBC (98 épisodes). Pendant la guerre du Vietnam, un commando des Forces Spéciales reçoit l\'ordre de voler une banque, mais leur colonel est tué. Accusés à tort du vol, les quatre membres sont condamnés à la prison puis s\'évadent. Désormais mercenaires clandestins dirigés par le Colonel Hannibal Smith, ils aident \"la veuve et l\'orphelin\" en combattant les injustices WikipediaVoiture de Film.\r\nLes 4 membres :\r\n\r\nHannibal Smith (le stratège aux déguisements)\r\nFuté/Barracus (le bricoleur qui a peur de l\'avion)\r\nLooping/Murdock (le pilote fou)\r\nFuté/Face (le charmeur escroc)\r\n\r\nDiffusion France : 1er juillet 1984 sur TF1'),
(8, ' MacGyver', '2025-11-18', '2025-11-18', 2, 'uploads/articles/article_691ceb91496a94.07537080.webp', 'MacGyver est une série américaine créée par Lee David Zlotoff, diffusée de 1985 à 1992 sur ABC (139 épisodes). Angus MacGyver travaille comme agent secret puis pour la Fondation Phoenix, une organisation humanitaire. Sa particularité : il refuse d\'utiliser des armes à feu et résout tous les problèmes grâce à son intelligence, ses connaissances scientifiques et son célèbre couteau suisse. Il crée des gadgets improvisés à partir d\'objets du quotidien pour se sortir de situations impossibles WikipediaMangaseries.\r\nDiffusion France : 4 janvier 1987 sur Antenne 2 dans \"Dimanche Martin\"'),
(9, 'Olive et Tom (Captain Tsubasa)', '2025-11-18', '2025-11-18', 2, 'uploads/articles/article_691cedf2b28581.78192079.webp', 'Olive et Tom (Captain Tsubasa en japonais) est une série d\'animation japonaise en 128 épisodes de 22 minutes, créée en 1983 d\'après le manga de Yōichi Takahashi. La série suit Olivier Atton (Tsubasa Ozora en version originale), un jeune prodige du football qui rêve de devenir le meilleur joueur du monde et de remporter la Coupe du Monde avec l\'équipe du Japon WikipediaWikipedia.\r\nNouveau venu en ville, Olivier rencontre Thomas Price (Genzô Wakabayashi), gardien de but légendaire qui n\'a jamais encaissé de but tiré depuis l\'extérieur de sa surface. D\'abord adversaires, ils deviendront amis et coéquipiers. L\'histoire suit leur parcours depuis les matchs inter-écoles jusqu\'à la Coupe du Monde de Football Juniors, en affrontant des joueurs talentueux comme Marc Landers (Kojirō Hyūga), le buteur explosif animé par une rage de vaincre AlloCinéOlive & Tom.\r\nNote sur les noms : Les noms ont été \"occidentalisés\" pour la version française des années 80. Dans les versions récentes (reboot 2018), les noms japonais originaux sont conservés AlloCiné.\r\n📺 Diffusion :\r\n\r\nJapon : 13 octobre 1983 - 27 mars 1986 sur TV Tokyo\r\nFrance : 5 septembre 1988 sur La Cinq dans \"Youpi ! L\'école est finie\", puis Club Dorothée sur TF1 (1993-1997)\r\nReboot 2018 : Nouvelle adaptation sous le nom \"Captain Tsubasa\" (52 épisodes)\r\n\r\n🎮 Impact culturel :\r\nLa série a inspiré de nombreux footballeurs professionnels dont Kylian Mbappé, et a contribué à populariser le football au Japon, sport alors considéré comme mineur dans les années 80 .');

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
  `pseudo_visiteur` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_parution` datetime DEFAULT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `fk_user` (`id_user`),
  KEY `fk_id_article` (`id_article`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `id_user`, `id_article`, `pseudo_visiteur`, `contenu`, `date_parution`) VALUES
(3, 2, 2, NULL, 'coucou', '2025-11-17 21:07:02'),
(5, 2, 2, NULL, 'c\'est cool ça', '2025-11-17 21:33:02'),
(6, NULL, 2, 'tartampion', 'elle sest ou l\'image ?', '2025-11-18 20:43:23'),
(8, 2, 2, NULL, 'j\'ai pas changé le texte', '2025-11-18 21:40:09');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `email`, `password`, `pseudo`, `type_user`, `avatar`, `date_inscription`) VALUES
(2, 'chabrier.emmanuel@hotmail.fr', '$2y$10$UgkzKUAtE8feNceLdTTgIuxDpKbcF0y5Vlo2clJIiurPU1n7nG/fO', 'manuchab', 'auteur', NULL, '2025-11-15'),
(3, 'chabrier.manu@gmail.com', '$2y$10$0RNdysuVfc48Y/ZoBVBAPuIT1oZt9cDToEkoQNZxqMFdrbvG0PqSa', 'chab', 'membre', NULL, '2025-11-17');

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
