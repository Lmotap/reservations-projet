-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 07 jan. 2025 à 11:29
-- Version du serveur : 8.0.35
-- Version de PHP : 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reservations_projets`
--

-- --------------------------------------------------------

--
-- Structure de la table `activities`
--

CREATE TABLE `activities` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type_id` int NOT NULL,
  `places_disponibles` int NOT NULL,
  `description` text,
  `image_url` varchar(255) DEFAULT NULL,
  `datetime_debut` datetime NOT NULL,
  `duree` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `activities`
--

INSERT INTO `activities` (`id`, `nom`, `type_id`, `places_disponibles`, `description`, `image_url`, `datetime_debut`, `duree`) VALUES
(1, 'Course d\'orientation', 1, 28, 'Une aventure en pleine nature avec des défis de navigation.', 'https://images.pexels.com/photos/9144231/pexels-photo-9144231.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2', '2025-01-15 10:00:00', 120),
(2, 'Atelier de poterie', 2, 15, 'Découverte et création d\'objets en argile.', 'https://images.pexels.com/photos/13554735/pexels-photo-13554735.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2', '2025-01-16 14:00:00', 90),
(3, 'Accrobranche nocturne', 3, 20, 'Parcours d\'accrobranche avec des lampes frontales.', 'https://images.unsplash.com/photo-1648718470490-805afbfa8081?q=80&w=3087&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '2025-01-17 18:30:00', 150),
(4, 'Yoga en plein air', 4, 25, 'Séance de yoga pour tous niveaux dans un cadre apaisant.', 'https://images.unsplash.com/photo-1694114935810-7714b7dc5db6?q=80&w=2186&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '2025-01-18 08:00:00', 60),
(5, 'Atelier cuisine bio', 5, 12, 'Apprenez à préparer des plats sains et gourmands.', 'https://images.pexels.com/photos/3379322/pexels-photo-3379322.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2', '2025-01-19 11:00:00', 180);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `activite_id` int NOT NULL,
  `date_reservation` datetime DEFAULT CURRENT_TIMESTAMP,
  `etat` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `activite_id`, `date_reservation`, `etat`) VALUES
(22, 7, 1, '2025-01-07 09:45:12', 0),
(23, 6, 1, '2025-01-07 10:28:50', 1),
(24, 7, 5, '2025-01-07 11:05:30', 0),
(25, 7, 1, '2025-01-07 11:08:15', 0),
(26, 7, 1, '2025-01-07 11:08:34', 0),
(27, 7, 1, '2025-01-07 11:08:57', 1);

-- --------------------------------------------------------

--
-- Structure de la table `type_activite`
--

CREATE TABLE `type_activite` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `type_activite`
--

INSERT INTO `type_activite` (`id`, `nom`) VALUES
(4, 'Bien-être'),
(2, 'Créativité et artisanat'),
(5, 'Gastronomie'),
(1, 'Nature et aventure'),
(3, 'Sport et adrénaline');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'participant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `prenom`, `nom`, `email`, `motdepasse`, `role`) VALUES
(6, 'Jean', 'Luc', 'xarexir223@cashbn.com', '$2y$10$b/2St2yC.qmf1X0LePwn9e1MyB54GRXHQRsM76RM16FU4n3Rn2AKy', 'user'),
(7, 'Admin', 'System', 'admin@example.com', '$2y$10$4VfrV1507K8EEgCP9zKL0exiGq2Ea1PoCK8Ep46TMJskbg1/8N3MC', 'admin'),
(8, 'Jean', 'aze', 'mkkm@ezt.fr', '$2y$10$Bl8Zulv6hnNQDxvjMimunOg7OjnQUGTk.BkhA4C0wGflg1pKhHIh6', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `activite_id` (`activite_id`);

--
-- Index pour la table `type_activite`
--
ALTER TABLE `type_activite`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `type_activite`
--
ALTER TABLE `type_activite`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type_activite` (`id`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`activite_id`) REFERENCES `activities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
