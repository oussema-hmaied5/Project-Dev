-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 10 mars 2022 à 00:23
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pidev1`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualite`
--

CREATE TABLE `actualite` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `actualite_categorie`
--

CREATE TABLE `actualite_categorie` (
  `actualite_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `titre`, `description`) VALUES
(1, 'FPS', 'Tir 1ère personne'),
(2, 'MMO', 'massively multiplayer online role-playing'),
(3, 'Survival', 'Le jeu de survie est un sous-genre du jeu d\'action où généralement le joueur démarre avec un minimum de ressources dans un monde ouvert hostile, et a pour mission de collecter des ressources, fabriquer des outils, des armes, s\'abriter, afin de survivre le plus longtemps possible.'),
(4, 'Arcade', 'Rocket League est un jeu vidéo développé et édité par Psyonix. Il sort en juillet 2015 sur Windows et sur PlayStation 4, en février 2016 sur Xbox One, en septembre 2016 sur Linux et Mac et en novembre 2017 sur Nintendo Switch');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `actualites_id` int(11) NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `actif` tinyint(1) NOT NULL,
  `rgpd` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220216211153', '2022-02-16 21:12:12', 168),
('DoctrineMigrations\\Version20220217221951', '2022-02-17 22:23:34', 447),
('DoctrineMigrations\\Version20220223215039', '2022-02-23 21:55:31', 67),
('DoctrineMigrations\\Version20220223223458', '2022-02-23 22:35:14', 165),
('DoctrineMigrations\\Version20220303223303', '2022-03-03 22:33:39', 1961),
('DoctrineMigrations\\Version20220307230028', '2022-03-07 23:00:40', 213);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `id` int(11) NOT NULL,
  `nom_equipe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbr_joueurs` int(11) NOT NULL,
  `nom_joueurs` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `equipe`
--

INSERT INTO `equipe` (`id`, `nom_equipe`, `nbr_joueurs`, `nom_joueurs`) VALUES
(1, 'xxx', 3, 'baha, leith,flora'),
(2, 'aaaa', 4, 'xfjd, xfjd; fdj'),
(3, 'kawafel', 5, 'mbappe, boh,hass,neymar,messi'),
(4, 'Uno', 5, 'baha, leith,flora,oussama,omar');

-- --------------------------------------------------------

--
-- Structure de la table `jeu`
--

CREATE TABLE `jeu` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entreprise` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `jeu`
--

INSERT INTO `jeu` (`id`, `nom`, `entreprise`, `type`, `genre`, `category_id`) VALUES
(6, 'valorant', 'riot games', 'Online', 'Multiplayer', 1),
(7, 'League of legends', 'riot games', 'Online', 'Solo', 2),
(8, 'cs go', 'valve', 'Online', 'Multiplayer', 1),
(9, 'Rocket league', 'Psyonix', 'Online', 'Multiplayer', 4);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `description`, `created_at`) VALUES
(15, 'aaaaaaaaaa', '2022-03-09 23:01:11'),
(16, 'aaaaa', '2022-03-09 23:02:40');

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE `publication` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `views` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`id`, `description`, `created_at`, `views`, `titre`) VALUES
(25, 'halelelelele', '2022-03-07 22:50:23', 2, 'lalalalalalalalal'),
(26, 'ghjkk', '2022-03-07 22:56:14', 0, 'kkkkkk'),
(27, 'heeeelp', '2022-03-07 23:03:47', 0, 'game of thrones');

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) NOT NULL,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num` int(11) NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sujet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reclamation`
--

INSERT INTO `reclamation` (`id`, `service`, `num`, `mail`, `sujet`, `user_id`, `statut`) VALUES
(20, 'Jeux', 11223344, 'Oussama.hamaied@hotmail.fr', 'beug Jeux', 56, 'Encours'),
(21, 'Jeux', 11223344, 'Oussama.hamaied@hotmail.fr', 'gta', 56, 'Encours'),
(23, 'ijide', 11223344, 'yasmine.layes@esprit.tn', 'ijdzi', 56, 'Encours'),
(24, 'jsnfsj', 11223344, 'yasmine.layes@esprit.tn', 'bbsnfns', 56, 'Encours'),
(25, 'Jeuxvideo', 11223366, 'Oussema.hmaied1@esprit.tn', 'je veux avoir 16 en project ! Merci Mr', 59, 'Encours');

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) NOT NULL,
  `hashed_token` varchar(100) NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reset_password_request`
--

INSERT INTO `reset_password_request` (`id`, `user_id`, `selector`, `hashed_token`, `requested_at`, `expires_at`) VALUES
(23, 54, 'tcXydUcw0gIrCx6wT5Uj', 'yOcowxHUnmdjSyDssszh2PlxqfwRWXg/8dIRAOSwXrE=', '2022-03-07 23:48:20', '2022-03-08 00:48:20'),
(24, 54, 'aZ5NKf3VP3FU3LNBOQfg', 'aqcW4z35QPupzE7LS+eEX/1vmlVMozTrgzaknlH2nLU=', '2022-03-09 04:40:49', '2022-03-09 05:40:49'),
(25, 59, '3RVLY6dDUtWVKQ3loIQ1', 'QSC9VScEluosAKMWWU8tdc5ZSmShqjiK7vIj4MezaZc=', '2022-03-09 05:21:05', '2022-03-09 06:21:05'),
(26, 54, 'GITakEPcZl6afdScAKLr', 'Wf+dWPISIVdCfX7my42QsM9555dcjowjfrxsQaLZDqM=', '2022-03-09 06:17:15', '2022-03-09 07:17:15'),
(27, 54, 'TT62JcrzLUQzqqbbpVFW', '1UcSUtprloq8oIvC2SJJHSjNbVcjrQrlfEgMa835kmc=', '2022-03-09 07:23:27', '2022-03-09 08:23:27'),
(28, 54, 'H4OQck9eZZWODa69LL8A', 'wzr/NuEmj9tXpioUIq7d9gGxfi3NOHhIXLq8Oa0gh+o=', '2022-03-09 11:20:23', '2022-03-09 12:20:23');

-- --------------------------------------------------------

--
-- Structure de la table `tournois`
--

CREATE TABLE `tournois` (
  `id` int(11) NOT NULL,
  `id_jeu_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `prize` int(11) NOT NULL,
  `max_equipes` int(11) NOT NULL,
  `lieu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tournois`
--

INSERT INTO `tournois` (`id`, `id_jeu_id`, `date`, `prize`, `max_equipes`, `lieu`, `name`) VALUES
(5, 6, '2022-09-01', 1000, 32, 'Germany', 'RLCS'),
(6, 6, '2025-01-01', 25000, 32, 'Egypt', 'VrlMena'),
(7, 6, '2026-06-06', 984984, 32, 'Tunisia', 'mojkanze'),
(8, 6, '2027-07-19', 56486468, 60, 'Botswana', 'babababa');

-- --------------------------------------------------------

--
-- Structure de la table `tournois_equipe`
--

CREATE TABLE `tournois_equipe` (
  `tournois_id` int(11) NOT NULL,
  `equipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tournois_equipe`
--

INSERT INTO `tournois_equipe` (`tournois_id`, `equipe_id`) VALUES
(5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `adresse`, `num`, `email`, `roles`, `password`, `facebook_id`, `facebook_access_token`) VALUES
(54, 'Hmaied', 'Oussema', 'Marsa', 77441122, 'Oussama.hamaied@hotmail.fr', '[\"ROLE_ADMIN\"]', '1122', NULL, NULL),
(56, 'cycy', 'Oussema', 'Marsa', 11223344, 'yasmine.layes@esprit.tn', '[\"ROLE_ADMIN\"]', '123', NULL, NULL),
(57, 'chikoslovakia', 'aziz', 'manouba', 11223344, 'Oussama.ahamaied@hotmail.fr', '[]', '$argon2id$v=19$m=65536,t=4,p=1$LnlyNFNZT0JjZU9MbkVYUA$NusfyGXdvMVc9SZSuk2rjrprwtyhNp5uv/AKuKdFpnE', NULL, NULL),
(58, 'Hmaied', 'Oussema', 'ariana', 12345678, 'yas.layes@esprit.tn', '[]', '$argon2id$v=19$m=65536,t=4,p=1$d1V2blFSUDJ0YklmL1FVZw$1BhinF9xm9PF35EdsKZGA8TVO4FLQBpzSa5A6v6AhTw', NULL, NULL),
(59, 'Hmaied', 'Oussema', 'ukrania', 11223366, 'Oussema.hmaied1@esprit.tn', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$RDZ0NDA2Z09TLjI1RjNlbw$OVwRJscsrx0rn4HvntYiNy0bAm3M6YXPR/Pb8uOYFOk', NULL, NULL),
(60, 'Hmaied', 'Oussema', 'manouba', 11223344, 'Oussama.hamaied@hotmail.fr', '[\"ROLE_ADMIN\"]', '123', NULL, NULL),
(61, 'baha', 'baha', 'ariana', 54545454, 'baha@gmail.com', '[\"ROLE_ADMIN\"]', '0000', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actualite`
--
ALTER TABLE `actualite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `actualite_categorie`
--
ALTER TABLE `actualite_categorie`
  ADD PRIMARY KEY (`actualite_id`,`categorie_id`),
  ADD KEY `IDX_EC878E9DA2843073` (`actualite_id`),
  ADD KEY `IDX_EC878E9DBCF5E72D` (`categorie_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_67F068BC2EDF1993` (`actualites_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jeu`
--
ALTER TABLE `jeu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_82E48DB512469DE2` (`category_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CE606404A76ED395` (`user_id`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `tournois`
--
ALTER TABLE `tournois`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D7AAF97AAA98CC3` (`id_jeu_id`);

--
-- Index pour la table `tournois_equipe`
--
ALTER TABLE `tournois_equipe`
  ADD PRIMARY KEY (`tournois_id`,`equipe_id`),
  ADD KEY `IDX_5E5796AC752534C` (`tournois_id`),
  ADD KEY `IDX_5E5796AC6D861B89` (`equipe_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `actualite`
--
ALTER TABLE `actualite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `jeu`
--
ALTER TABLE `jeu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `publication`
--
ALTER TABLE `publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `tournois`
--
ALTER TABLE `tournois`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `actualite_categorie`
--
ALTER TABLE `actualite_categorie`
  ADD CONSTRAINT `FK_EC878E9DA2843073` FOREIGN KEY (`actualite_id`) REFERENCES `actualite` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EC878E9DBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BC2EDF1993` FOREIGN KEY (`actualites_id`) REFERENCES `actualite` (`id`);

--
-- Contraintes pour la table `jeu`
--
ALTER TABLE `jeu`
  ADD CONSTRAINT `FK_82E48DB512469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `FK_CE606404A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `tournois`
--
ALTER TABLE `tournois`
  ADD CONSTRAINT `FK_D7AAF97AAA98CC3` FOREIGN KEY (`id_jeu_id`) REFERENCES `jeu` (`id`);

--
-- Contraintes pour la table `tournois_equipe`
--
ALTER TABLE `tournois_equipe`
  ADD CONSTRAINT `FK_5E5796AC6D861B89` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5E5796AC752534C` FOREIGN KEY (`tournois_id`) REFERENCES `tournois` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
