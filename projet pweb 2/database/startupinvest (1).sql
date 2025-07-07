-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 25 avr. 2024 à 01:14
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `startupinvest`
--

-- --------------------------------------------------------

--
-- Structure de la table `capital_risque`
--

CREATE TABLE `capital_risque` (
  `id_capital_risque` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `CIN` varchar(20) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `pwrd` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `capital_risque`
--

INSERT INTO `capital_risque` (`id_capital_risque`, `nom`, `prenom`, `email`, `CIN`, `pseudo`, `pwrd`) VALUES
(1, 'gadhgadhi', 'mohamed yahya', 'yahyagadh@gmail.com', '13032000', 'yahya', '$2y$10$zP.8FLpPAO89F'),
(2, 'ibn fardj', 'oumaima', 'oumaimaouma@outlook.', '56108115', 'oumaima11', '$2y$10$gCwdUI9o6YoPf'),
(319072, 'bhjkeedcs', 'bhedkjzs', 'ebjkzfhcds@hotmail.c', '98745632', 'samir', '$2y$10$vg1xrD8qLqTEd'),
(514382, 'gadhgadhi', 'mohamed yahya', 'guiedc@gmail.com', '51521235', 'eya', '$2y$10$Z3ioZINGfSi4O');

-- --------------------------------------------------------

--
-- Structure de la table `capital_risque_projet`
--

CREATE TABLE `capital_risque_projet` (
  `id` int(11) NOT NULL,
  `id_projet` int(11) NOT NULL,
  `id_capital_risque` int(11) NOT NULL,
  `nombre_actions_achetees` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id_projet` int(11) NOT NULL,
  `titre` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `nombre_actions_a_vendre` int(11) NOT NULL,
  `nombre_actions_vendues` int(11) NOT NULL,
  `prix_action` float NOT NULL,
  `id_startuper` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id_projet`, `titre`, `description`, `nombre_actions_a_vendre`, `nombre_actions_vendues`, `prix_action`, `id_startuper`) VALUES
(1, 'Projet de développement d\'appl', 'Ce projet vise à développer une application mobile innovante pour faciliter la gestion des tâches quotidiennes. Il inclura des fonctionnalités telles que la gestion des tâches, des rappels personnalis', 100, 0, 10.5, 0),
(2, 'Projet de développement d\'une ', 'Ce projet consiste à créer une plateforme e-commerce robuste et conviviale, offrant une expérience d\'achat en ligne fluide. Il comprendra des fonctionnalités telles que la navigation intuitive, le pai', 150, 0, 12.75, 0),
(3, 'Projet de conception d\'une app', 'Ce projet a pour objectif de développer une application de santé numérique novatrice, permettant aux utilisateurs de suivre leur état de santé, de recevoir des conseils personnalisés et de se connecte', 200, 0, 9.99, 0),
(4, 'Projet de création d\'une plate', 'Ce projet consiste à construire une plateforme de streaming vidéo haut de gamme, offrant une large gamme de contenus en streaming, y compris des films, des séries TV et des documentaires, avec une qua', 120, 0, 15.25, 0),
(5, 'Projet de développement d\'un j', 'Ce projet vise à développer un jeu vidéo immersif en réalité virtuelle, offrant une expérience de jeu innovante et captivante. Il inclura des graphismes de pointe, un gameplay interactif et des mondes', 180, 0, 20, 0),
(6, 'Projet de création d\'une appli', 'Ce projet consiste à créer une application de gestion financière complète, permettant aux utilisateurs de suivre leurs dépenses, de planifier leur budget et d\'optimiser leurs finances personnelles, le', 250, 0, 8.5, 0),
(7, 'Projet de développement d\'une ', 'Ce projet vise à développer une plateforme de formation en ligne interactive, offrant des cours dans divers domaines tels que la technologie, le marketing et les langues étrangères. Il fournira des ou', 150, 0, 11.75, 0),
(8, 'Projet de création d\'une appli', 'Ce projet consiste à créer une application de gestion de projet efficace, permettant aux utilisateurs de planifier, organiser et suivre leurs projets de manière transparente. Il inclura des fonctionna', 200, 0, 13.99, 0);

-- --------------------------------------------------------

--
-- Structure de la table `startuper`
--

CREATE TABLE `startuper` (
  `id_startuper` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `CIN` varchar(10) NOT NULL,
  `email` varchar(20) NOT NULL,
  `nom_entreprise` varchar(30) NOT NULL,
  `adresse_entreprise` varchar(50) NOT NULL,
  `numero_registre_commerce` varchar(20) NOT NULL,
  `photo` longblob NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `pwrd` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `startuper`
--

INSERT INTO `startuper` (`id_startuper`, `nom`, `prenom`, `CIN`, `email`, `nom_entreprise`, `adresse_entreprise`, `numero_registre_commerce`, `photo`, `pseudo`, `pwrd`) VALUES
(0, 'gadhgadhi', 'mohamed yahya', '13032000', 'yahyagadh@gmail.com', 'kalmni', 'tunis', 'A1593574862', '', 'yahya', '$2y$10$xG1h.0fk7pwFT'),
(397110, 'ivfuhdsikcguid', 'regvfyudci', '14785268', 'fuidchskjl@gmail.com', 'hhhhhhh', 'vnerfoibcdvoid', 'Q1478523677', '', 'yahya147', '$2y$10$RkWcCFnwQUrjy'),
(606793, 'touré', 'yaya', '13032000', 'Yahyagadh@gmail.com', 'nigga', 'tunis', 'Z5874963210', '', 'yaya', '$2y$10$u3QWEnHUAHTmd'),
(635736, 'ivfuhdsikcguid', 'regvfyudci', '14785268', 'fuidchskjl@gmail.com', 'hhhhhhh', 'vnerfoibcdvoid', 'Q1478523677', '', 'yahya147', '$2y$10$SnZs863EKQ45N'),
(662997, 'gadhgadhi', 'mohamed yahya', '56108115', 'fzefazqe@gmail.com', 'hefidncj', 'tunis', 'A1593574865', '', 'huvorfeic', '$2y$10$QQWhdCVwkff/j');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `capital_risque`
--
ALTER TABLE `capital_risque`
  ADD PRIMARY KEY (`id_capital_risque`);

--
-- Index pour la table `capital_risque_projet`
--
ALTER TABLE `capital_risque_projet`
  ADD KEY `id_capital_risque` (`id_capital_risque`),
  ADD KEY `id_projet` (`id_projet`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id_projet`),
  ADD KEY `id_startuper` (`id_startuper`);

--
-- Index pour la table `startuper`
--
ALTER TABLE `startuper`
  ADD PRIMARY KEY (`id_startuper`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `capital_risque`
--
ALTER TABLE `capital_risque`
  MODIFY `id_capital_risque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=514383;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `capital_risque_projet`
--
ALTER TABLE `capital_risque_projet`
  ADD CONSTRAINT `capital_risque_projet_ibfk_1` FOREIGN KEY (`id_capital_risque`) REFERENCES `capital_risque` (`id_capital_risque`),
  ADD CONSTRAINT `capital_risque_projet_ibfk_2` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id_projet`);

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`id_startuper`) REFERENCES `startuper` (`id_startuper`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
