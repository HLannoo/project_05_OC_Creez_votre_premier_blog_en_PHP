-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le : mer. 23 mars 2022 à 12:28
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
  `ft_image` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `chapo` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `slug`, `ft_image`, `title`, `content`, `created_at`, `published`, `chapo`) VALUES
(17, 1, 'Wordpress', '1646829145.JPG', 'IntÃ©grez un thÃ¨me Wordpress pour un client', '\"Cette agence possÃ¨de une quinzaine de chalets de luxe Ã  la vente et une vingtaine en location.\r\n\r\nCependant, elle ne possÃ¨de pas encore de site web pour promouvoir la vente et la location de ses chalets. Câ€™est pour cette raison quâ€™elle fait appel Ã  vous.\r\n\r\nLors dâ€™une premiÃ¨re rÃ©union, vous rencontrez Marie, la directrice de lâ€™agence.  Voici lâ€™Ã©change de mails que vous recevez suite Ã  cette rÃ©union.\r\n\r\n \r\n\r\nDe : Marie D.\r\n\r\nÃ€ : Moi\r\n\r\n--------------------------------------------------------------------------------------------------------\r\n\r\nBonjour,\r\n\r\nJe suis ravie de savoir que le projet te plaise. Comme nous en avons discutÃ©, je souhaite crÃ©er un site web pour notre agence â€œChalets et caviarâ€. Jâ€™aimerais que mon Ã©quipe et moi puissions mettre Ã  jour le site rÃ©guliÃ¨rement, sans passer par un prestataire.\r\n\r\nAs-tu une recommandation Ã  me faire pour que les mises Ã  jour soient le plus simple possible ?\r\n\r\nCordialement, \r\n\r\nMarie Dubois\r\n\r\nDirectrice de lâ€™agence Chalets et caviar\r\n\r\n--------------------------------------------------------------------------------------------------------\r\n\r\nDe : moi\r\n\r\nÃ€ : Marie\r\n\r\n------------------------------------------------------------------------------------------------------\r\n\r\nBonjour Marie,\r\n\r\nPour que vous puissiez mettre Ã  jour votre site facilement, sans passer par un prestataire externe, je vous recommande un site Wordpress.\r\n\r\nPeux-tu me donner plus de dÃ©tails sur le design du site que tu recherches ? Cela me permettra de te proposer le thÃ¨me Wordpress le plus adaptÃ© Ã  tes besoins.\r\n\r\nMerci.\r\n\r\n-------------------------------------------------------------------------------------------------------\r\n\r\nDe : Marie \r\n\r\nÃ€ : Moi\r\n\r\n-------------------------------------------------------------------------------------------------------\r\n\r\nBonjour,\r\n\r\nJe souhaite un design clair et Ã©purÃ©, qui montre la ligne luxe de lâ€™agence. Jâ€™aimerais que tu me prÃ©sentes la premiÃ¨re version en ligne du site avec les Ã©lÃ©ments suivants : \r\n\r\nune section avec 5 chalets Ã  louer ;\r\nune section avec 5 chalets Ã  vendre ;\r\nune page de contact avec les coordonnÃ©es de lâ€™agence et un formulaire de contact fonctionnel.\r\n \r\n\r\nPour que ce soit plus facile pour nous de collaborer sur les diffÃ©rentes offres, pourras-tu tâ€™assurer de bien utiliser des catÃ©gories sÃ©parÃ©es pour que chacun retrouve ses petits ?\r\n\r\nTu trouveras en piÃ¨ce jointe un dossier contenant les visuels de nos chalets ainsi quâ€™un document avec leurs caractÃ©ristiques.\r\n\r\n \r\n\r\nMerci, \r\n\r\nMarie Dubois\r\n\r\nDirectrice de lâ€™agence Chalets et caviar\r\n\r\n--------------------------------------------------------------------------------------------------------\r\n\r\nDe : Moi\r\n\r\nÃ€ : Marie Dubois\r\n\r\n--------------------------------------------------------------------------------------------------------\r\n\r\nBonjour Marie,\r\n\r\nMerci, jâ€™ai bien pris en note toutes les informations. Je te prÃ©parerai un document prÃ©sentant le thÃ¨me wordpress et montrant que cela correspond bien Ã  tes attentes en termes de design.\r\n\r\nY a-t-il dâ€™autres Ã©lÃ©ments que je dois prendre en compte pour la crÃ©ation du site ?\r\n\r\n--------------------------------------------------------------------------------------------------------\r\n\r\nDe : Marie \r\n\r\nÃ€ : Moi\r\n\r\n--------------------------------------------------------------------------------------------------------\r\n\r\nOui, tout d\'abord, il faut que l\'ont puisse Ã©diter plusieurs articles en mÃªme temps pour faciliter la mise Ã  jour du site par lâ€™Ã©quipe (ajout, suppression et modification de chalets). De plus, pourrais-tu ajouter des droits dâ€™administrateur selon les rÃ¨gles suivantes : \r\n\r\nun compte administrateur pour la directrice de l\'agence ;\r\nun compte administrateur pour le dÃ©veloppeur (toi) s\'il n\'existe pas dÃ©jÃ  ;\r\ndes comptes Ã©diteurs pour les 2 autres collaborateurs de l\'agence ?\r\nPourrais-tu Ã©galement me fournir un document contenant les instructions de mise Ã  jour ? 3 Ã  5 pages devraient suffire. Nâ€™oublie pas quâ€™on ne connaÃ®t rien au dÃ©veloppement, donc je veux bien toutes les Ã©tapes dÃ©taillÃ©es, si possible avec des captures dâ€™Ã©cran !\r\n\r\n\r\nMerci,\r\n\r\nMarie Dubois\r\n\r\nDirectrice de lâ€™agence Chalets et caviar\r\n\r\nVous avez tous les Ã©lÃ©ments pour vous lancer dans cette missionâ€¦ Câ€™est parti !\r\n\r\nLivrables\r\nPour ce projet, vous fournirez un dossier compressÃ© en ZIP, contenant :\r\n\r\nle code HTML / CSS / PHP complet du site web Wordpress ;\r\nlâ€™URL du site hÃ©bergÃ© en ligne ;\r\nla documentation PDF d\'utilisation du site Wordpress pour l\'agence ;\r\nun fichier prÃ©sentant le thÃ¨me choisi et expliquant pourquoi il a Ã©tÃ© choisi.\"', '2022-03-09 12:32:25', 1, '\"RÃ©diger une documentation Ã  l\'intention d\'utilisateurs non spÃ©cialistes SÃ©lectionner un thÃ¨me Wordpress adaptÃ© aux besoins du client Adapter un thÃ¨me Wordpress pour respecter les exigences du client\"'),
(18, 1, 'HTML & CSS', '1647037453.JPG', 'Analysez les besoins de votre client pour son festival de films', '\"Son association vient juste d\'Ãªtre crÃ©Ã©e et elle dispose d\'un budget limitÃ©. Elle a besoin de communiquer en ligne sur son festival, d\'annoncer les films projetÃ©s et de recueillir les rÃ©servations.\r\n\r\nVoici ce qu\'elle vous dit :\r\n\r\nMon association \"\"Les Films de Plein Air\"\" vient d\'obtenir l\'autorisation de projeter au parc Monceau cette annÃ©e, chaque soir du 5 au 8 aoÃ»t, de 18 heures Ã  minuit. Je souhaite ainsi faire dÃ©couvrir des films d\'auteur au grand public.\r\n\r\nJ\'ai besoin de communiquer sur le festival en amont et j\'ai besoin pour cela d\'une prÃ©sence en ligne avec un site web. Sur ce site, pour lequel il faudra dÃ©finir une charte graphique, j\'ai besoin notamment de prÃ©senter le festival, la liste des films et de communiquer rÃ©guliÃ¨rement sur les derniÃ¨res actualitÃ©s du festival.\r\n\r\nL\'accÃ¨s aux projections sera gratuit et ouvert Ã  tous mais je souhaite que le public puisse se prÃ©inscrire pour estimer le nombre de personnes prÃ©sentes chaque soir.\r\n\r\nJe souhaite avoir une adresse professionnelle en .com ou en .org : je suis preneuse de conseils sur le meilleur choix pour l\'adresse et je ne souhaite pas m\'occuper de l\'hÃ©bergement.\r\n\r\nEn tant que dÃ©veloppeur, on vous demande de lister les fonctionnalitÃ©s dont a besoin la cliente et de proposer une solution technique adaptÃ©e. Vous devez donc sÃ©lectionner la solution qui vous semble la plus Ã  mÃªme de rÃ©pondre Ã  son besoin : quels outils utiliser, Ã©ventuellement un CMS, etc.\r\n\r\nVous devrez ensuite rÃ©aliser une premiÃ¨re maquette de ce site correspondant Ã  ses attentes, en utilisant uniquement HTML et CSS.\r\n\r\nLivrables\r\nCahier des charges du projet (PDF)\r\nCode source complet du projet (HTML/CSS et autres fichiers nÃ©cessaires, zippÃ©s)\"', '2022-03-11 22:24:12', 1, '\"Lister les fonctionnalitÃ©s demandÃ©es par un client Analyser un cahier des charges RÃ©diger les spÃ©cifications deÌtailleÌes du projet Choisir une solution technique adapteÌe parmi les solutions existantes si cela est pertinent\"'),
(24, 1, 'uml', '1647383620.JPG', 'Concevez la solution technique d\'une application de restauration en ligne, ExpressFood', '\"Chaque jour, ExpressFood prÃ©pare 2 plats et 2 desserts Ã  son QG en collaboration avec des chefs expÃ©rimentÃ©s. Ces plats sont conditionnÃ©s Ã  froid puis transmis Ã  des livreurs Ã  domicile qui \"\"maraudent\"\" ensuite dans les rues en attendant une livraison. DÃ¨s qu\'un client a commandÃ©, l\'un des livreurs (qui possÃ¨de dÃ©jÃ  les plats dans un sac) est missionnÃ© pour livrer en moins de 20 minutes.\r\n\r\nSur son application, ExpressFood propose Ã  ses clients de commander un ou plusieurs plats et desserts. Les frais de livraison sont gratuits. Les plats changent chaque jour.\r\n\r\nUne fois la commande passÃ©e, le client a accÃ¨s Ã  une page lui indiquant si un livreur a pris sa commande et le temps estimÃ© avant livraison.\r\n\r\nExpressFood a besoin que vous conceviez sa base de donnÃ©es. Il s\'agit de stocker notamment :\r\n\r\nLa liste des clients\r\nLa liste des diffÃ©rents plats du jour\r\nLa liste des livreurs, avec leur statut (libre, en cours de livraison) et leur position\r\nLa liste des commandes passÃ©es\r\n...\r\nPour structurer votre rÃ©flexion, vous utiliserez UML et construirez une suite de diagrammes afin de modÃ©liser les besoins de lâ€™application et le diagramme de classe pour modÃ©liser les entitÃ©s de l\'application. Une fois que les diagrammes vous satisferont, vous rÃ©aliserez le schÃ©ma de base de donnÃ©es MySQL correspondant, puis vous remplirez la base avec des premiÃ¨res valeurs fictives.\r\n\r\nVous veillerez Ã  produire des schÃ©mas UML cohÃ©rents par rapport au cahier des charges et respectant les standards UML. Vous concevrez ensuite un schÃ©ma de base de donnÃ©es SQL adÃ©quat.\r\n\r\nSchÃ©mas demandÃ©s :\r\n\r\nDiagrammes de cas dâ€™utilisation (crÃ©ation dâ€™une commande, ajout dâ€™un plat du jour, livraison dâ€™une commande)\r\nModÃ¨le de donnÃ©es\r\nDiagramme de classes\r\nDiagrammes de sÃ©quences (crÃ©ation dâ€™une commande, ajout dâ€™un plat du jour, livraison dâ€™une commande)\r\n \r\nLivrables \r\nPour ce projet, vous fournirez un dossier .zip contenant :\r\n\r\nSchÃ©ma UML\r\nBase de donnÃ©es MySQL avec un jeu de donnÃ©es de dÃ©mo\"', '2022-03-15 22:33:39', 1, 'Concevoir lâ€™architecture technique dâ€™une application Ã  lâ€™aide de diagrammes UML ImplÃ©menter le schÃ©ma de donnÃ©es dans la base.');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `pseudo` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` char(255) NOT NULL,
  `ft_image` varchar(255) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `ft_image`, `email`, `role`, `created_at`) VALUES
(1, 'hedi', '6d5be11f', 'hedi_image.jpg', 'hedilannoo@gmail.com', 2, '2022-01-11 16:36:11');

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
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
