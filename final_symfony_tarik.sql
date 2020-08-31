-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 31 août 2020 à 16:46
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `final_symfony_tarik`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `journalist_id` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `journalist_id`, `titre`, `content`, `picture`) VALUES
(18, NULL, 'mon super article', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur consequuntur ducimus eaque facilis iste labore magni obcaecati perspiciatis porro, praesentium recusandae similique voluptate voluptatem. Debitis dolor doloremque ex qui reprehenderit.', 'image1.jpg'),
(19, NULL, 'un deuxième article top', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur consequuntur ducimus eaque facilis iste labore magni obcaecati perspiciatis porro, praesentium recusandae similique voluptate voluptatem. Debitis dolor doloremque ex qui reprehenderit.', 'image2.jpg'),
(20, NULL, 'un article passable', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur consequuntur ducimus eaque facilis iste labore magni obcaecati perspiciatis porro, praesentium recusandae similique voluptate voluptatem. Debitis dolor doloremque ex qui reprehenderit.', 'image3.jpg'),
(21, NULL, 'test', 'zekltj ryljrl erlyjl erlyj', 'frise-5f4ce3cd8e3b9.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`) VALUES
(42, 'polo@dailyTown.com', '[\"ROLE_USER\"]', '$2y$13$d2FGGRw3FdT9cYJnmyBw9OMKrC2x1pHh7JSFLjDDyrwQeYM3Gcf/.', 'polo', 'kulu'),
(43, 'pete@dailyTown.com', '[\"ROLE_USER\"]', '$2y$13$Lw7l70awi14m2q6aF5tCv.IkE6dHa1HTWDU2KNqa69oanquJCJX8C', 'pete', 'gaga'),
(44, 'joni@dailyTown.com', '[\"ROLE_USER\"]', '$2y$13$tPPlF9hb97.IVFT7H085l.dOEBknJEGSNA1mMEQIRC0MjlP8PI52e', 'joni', 'miam'),
(45, 'joey@dailyTown.fr', '[\"ROLE_USER\"]', '$2y$13$pSbEXyx.8uuRK7E0Z8myLuSOR2ipfAgSfjEq.RI..pLboDFBVItzW', 'joey', 'army'),
(46, 'tarik@dailyTown.com', '[\"ROLE_ADMIN\"]', '$2y$13$JaMLaQlEVi8t2PmAQo1wGOYlla66RKril8sB.oxb73z95Rac6Jn3C', 'tarik', 'admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BFDD316834F59171` (`journalist_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `FK_BFDD316834F59171` FOREIGN KEY (`journalist_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
