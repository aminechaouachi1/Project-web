-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 30 nov. 2023 à 03:09
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ouespi`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL,
  `qty` varchar(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

DROP TABLE IF EXISTS `employes`;
CREATE TABLE IF NOT EXISTS `employes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `matricule` int(11) NOT NULL,
  `depart` varchar(100) NOT NULL,
  `poste` varchar(100) NOT NULL,
  `date_emb` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf32;

--
-- Déchargement des données de la table `employes`
--

INSERT INTO `employes` (`id`, `nom`, `prenom`, `matricule`, `depart`, `poste`, `date_emb`, `statut`) VALUES
(2, 'alami', 'kamal', 55667787, 'Mécanique', 'Mécanicien', '2019-08-30 00:00:00', 1),
(5, 'akram', 'halima', 77889900, 'Administration', 'Sécrétaire', '0000-00-00 00:00:00', 1),
(10, 'alami', 'bachir', 66778878, 'Informatique', 'Technicien', '2019-10-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tbbiodata`
--

DROP TABLE IF EXISTS `tbbiodata`;
CREATE TABLE IF NOT EXISTS `tbbiodata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(128) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `hp` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tbbiodata`
--

INSERT INTO `tbbiodata` (`id`, `nama`, `alamat`, `hp`) VALUES
(2, 'Joni Subarjo', 'Jl. Mawar No. 29', '08767565665'),
(13, 'Malek kadri', 'route gabes ksar', '27414462');

-- --------------------------------------------------------

--
-- Structure de la table `tblogin`
--

DROP TABLE IF EXISTS `tblogin`;
CREATE TABLE IF NOT EXISTS `tblogin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tblogin`
--

INSERT INTO `tblogin` (`id`, `name`, `email`, `password`) VALUES
(7, 'Malek', 'kadrimalek10@gmail.com', ''),
(13, 'Malek', 'Alimohamed@gmail.com', '$2y$10$a5whCIAuWG5BSvpXzytbp.OFqOc8rI86UwYaJUpAJjrQMNjZ6E1kW'),
(15, 'gjfh', 'achref.nefzazoui@gmail.com', '$2y$10$gaKugvfRY4lh.WZwS/OpIufN8I/kwjF06DAQlLmV0cKbemxq4PEMq'),
(17, 'aaaaaaa', 'achref.nefzazoui@gmail.comm', 'Achref1');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
