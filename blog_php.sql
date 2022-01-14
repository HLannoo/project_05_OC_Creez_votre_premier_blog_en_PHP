-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le : mar. 11 jan. 2022 à 17:22
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `ft_image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `slug`, `ft_image`, `title`, `content`, `created_at`, `published`) VALUES
(1, 1, 'wordpress', 'http://project5/public/assets/img/chalets_caviar.JPG', 'Intégrez un thème Wordpress pour un client', ' Rédiger une documentation à l\'intention d\'utilisateurs non spécialistes\r\n                                        Sélectionner un thème Wordpress adapté aux besoins du client\r\n                                        Adapter un thème Wordpress pour respecter les exigences du client', '2022-01-11 16:18:19', 1),
(2, 1, 'Festival', 'http://project5/public/assets/img/films_de_plein_air.JPG', 'Analysez les besoins de votre client pour son festival de films', 'Lister les fonctionnalités demandées par un client\r\n                                    Analyser un cahier des charges\r\n                                    \r\nRédiger les spécifications détaillées du projet\r\n                                    \r\nChoisir une solution technique adaptée parmi les solutions existantes si cela est pertinent', '2022-01-11 16:18:36', 1),
(3, 1, 'Expressfood', 'http://project5/public/assets/img/UML.JPG', 'Concevez la solution technique d\'une application de restauration en ligne, ExpressFood', 'Concevoir l’architecture technique d’une application à l’aide de diagrammes UML\r\n                                        Implémenter le schéma de données dans la base\r\n                                        Réaliser un schéma de conception de la base de données de l’application\r\n                                        Réaliser des schémas UML cohérents et en accord avec les besoins énoncés', '2022-01-11 16:18:53', 1);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `pseudo` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` char(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `ft_image` varchar(255) DEFAULT NULL,
  `content` text,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `token` text,
  `role` enum('Inscrit','admin') DEFAULT 'Inscrit',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `slug`, `ft_image`, `content`, `email`, `phone`, `ip`, `token`, `role`, `created_at`) VALUES
(1, 'hedi', '6d5be11f', 'hedi', 'hedi.jpg', 'osef', 'hedilannoo@gmail.com', '0609723400', '127.0.0.1', '1', 'Inscrit', '2022-01-11 16:36:11');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
