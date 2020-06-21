-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 18 juin 2020 à 16:04
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `catId` int(11) NOT NULL,
  `nomCat` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`catId`, `nomCat`) VALUES
(1, 'KPOP'),
(2, 'Vaporwave'),
(3, 'Divers');

-- --------------------------------------------------------

--
-- Structure de la table `dislikes`
--

CREATE TABLE `dislikes` (
  `id` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(250) CHARACTER SET utf8 NOT NULL,
  `mail` varchar(250) CHARACTER SET utf8 NOT NULL,
  `motdepasse` text CHARACTER SET utf8 NOT NULL,
  `type` text CHARACTER SET utf8 NOT NULL,
  `photoprofil` varchar(250) CHARACTER SET utf8 NOT NULL,
  `loginTime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id`, `pseudo`, `mail`, `motdepasse`, `type`, `photoprofil`, `loginTime`) VALUES
(0, 'Zenâš¡Ikram', 'ikram@mint.com', 'd8786167d633c68c7d9be744496b157a4f0f8190', 'admin', 'https://media.giphy.com/media/VEzYdo930nTiTuVeMU/giphy.gif', '2020-04-30 06:42:48'),
(1, 'Mohamad', 'mohamad@mint.com', 'f7a93b87cdf8f45dea6ed1e489b7e386776c4a65', 'admin', 'https://media.giphy.com/media/XtfYIuXRuPzMnh4GwK/giphy.gif', '2020-04-30 06:31:37'),
(2, 'M.prof', 'm.prof@mint.com', '8f044084a568e7f22a5a3c599a8e85d2587fff47', 'admin', 'https://media3.giphy.com/media/ZBKJ1VGLhubqPSZNUx/giphy.gif?cid=ecf05e47f88cb640fb3d0ac74b24180587c0a3f4799c0945&rid=giphy.gif', '2020-04-30 04:20:59'),
(3, 'Mina', 'mina@gmail.com', '733797d4e9201e0cc791cb93ac19992631802ed3', 'user', 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Flag_of_Spain.svg/1200px-Flag_of_Spain.svg.png', '2020-04-30 06:09:29'),
(4, 'Kinslay', 'kinslay@gmail.com', '3cb5c01c560c9d9a652357c5aefb1ab0ce56203c', 'user', 'https://i.pinimg.com/736x/1e/3f/9e/1e3f9e246238237d5998feb97991d477.jpg', '2020-04-30 04:21:11'),
(5, 'yota', 'yotafootball69@gmail.com', '3d3863df20e37feb7dc523c8c53977e6e27666cc', 'user', 'https://i.giphy.com/media/gzROsII7swwrm/giphy.webp', '2020-06-11 01:09:39'),
(6, 'jul', 'jul@gmail.com', '3d3863df20e37feb7dc523c8c53977e6e27666cc', 'user', 'https://i.giphy.com/media/gzROsII7swwrm/giphy.webp', '2020-06-11 22:27:48');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `photoId` int(11) NOT NULL,
  `nomFich` varchar(250) CHARACTER SET utf8 NOT NULL,
  `description` varchar(250) CHARACTER SET utf8 NOT NULL,
  `catId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `isShown` tinyint(1) NOT NULL,
  `aime` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`photoId`, `nomFich`, `description`, `catId`, `userId`, `isShown`, `aime`) VALUES
(42, 'IMG_0660_Original.JPG', 'g', 3, 5, 1, 0),
(49, 'IMG_2398.JPG', 'jjj', 3, 5, 1, 0),
(51, 'IMG_1208.JPG', 'nn', 3, 5, 1, 0),
(54, 'IMG_2125.JPG', 'zzzz', 3, 5, 1, 0),
(55, 'IMG_2127.JPG', 'eee', 3, 5, 1, 0),
(58, 'IMG_2126.JPG', 'hhhhh', 3, 6, 1, 0),
(60, 'IMG_2208.JPG', 'la zuppp', 3, 6, 1, 0),
(63, 'IMG_2124.JPG', 'hhdsjsqhjqsfs', 3, 6, 1, 0),
(64, 'IMG_2275.JPG', 'jean-mi', 3, 6, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `rating`
--

CREATE TABLE `rating` (
  `like` int(255) NOT NULL,
  `aime` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`catId`);

--
-- Index pour la table `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`photoId`),
  ADD KEY `date_creation` (`catId`),
  ADD KEY `date_creation_2` (`catId`),
  ADD KEY `#catId` (`catId`),
  ADD KEY `#catId_2` (`catId`),
  ADD KEY `#catId_3` (`catId`);

--
-- Index pour la table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`like`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `dislikes`
--
ALTER TABLE `dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `photoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `rating`
--
ALTER TABLE `rating`
  MODIFY `like` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
