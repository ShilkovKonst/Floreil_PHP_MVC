-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 04 jan. 2023 à 16:38
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
-- Base de données : `floreil`
--

-- --------------------------------------------------------

--
-- Structure de la table `ajouter_au_panier`
--

DROP TABLE IF EXISTS `ajouter_au_panier`;
CREATE TABLE IF NOT EXISTS `ajouter_au_panier` (
  `idPlante` int(10) NOT NULL AUTO_INCREMENT,
  `idUtilisateur` int(10) NOT NULL,
  `qnty_plante` int(5) DEFAULT NULL,
  `prixPourQnty_plante` float DEFAULT NULL,
  `prixTotalPlantes` float DEFAULT NULL,
  PRIMARY KEY (`idPlante`,`idUtilisateur`),
  KEY `FK_ajouter_au_panier_idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int(10) NOT NULL AUTO_INCREMENT,
  `nom_Categorie` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `image_Categorie` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `nom_Categorie`, `image_Categorie`) VALUES
(1, 'Interieur', 'section-plantes-interieur.jpeg'),
(2, 'Exterieur', 'section-plantes-exterieur.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `idCommande` int(10) NOT NULL AUTO_INCREMENT,
  `numero_Commande` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `linkAgenceLivraison_Commande` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `numeroExtLivraison_Commande` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `idUtilisateur` int(10) DEFAULT NULL,
  PRIMARY KEY (`idCommande`),
  KEY `FK_Commande_idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `idFacture` int(10) NOT NULL AUTO_INCREMENT,
  `numero_Facture` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `montantPanier_Facture` float DEFAULT NULL,
  `date_Facture` datetime DEFAULT CURRENT_TIMESTAMP,
  `document_Facture` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `idUtilisateur` int(10) DEFAULT NULL,
  PRIMARY KEY (`idFacture`),
  KEY `FK_Facture_idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plantes`
--

DROP TABLE IF EXISTS `plantes`;
CREATE TABLE IF NOT EXISTS `plantes` (
  `idPlante` int(10) NOT NULL AUTO_INCREMENT,
  `createdDate_Plante` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title_Plante` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `description_Plante` text COLLATE latin1_general_ci,
  `image_Plante` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `prix_Plante` float DEFAULT NULL,
  `qnty_Plante` int(5) DEFAULT NULL,
  `nomCommun_Plante` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `hauteurCM_Plante` int(5) DEFAULT NULL,
  `feillage_Plante` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `arrosage_Plante` text COLLATE latin1_general_ci,
  `floraison_Plante` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `floraisonParfumee_Plante` tinyint(1) DEFAULT NULL,
  `modeVie_Plante` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `resistanceFroid_Plante` tinyint(1) DEFAULT NULL,
  `resistanceFroidBas_Plante` int(3) DEFAULT NULL,
  `resistanceFroidHaut_Plante` int(3) DEFAULT NULL,
  `idCategorie` int(10) DEFAULT NULL,
  PRIMARY KEY (`idPlante`),
  KEY `FK_Plante_idCategorie` (`idCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `poster_comment`
--

DROP TABLE IF EXISTS `poster_comment`;
CREATE TABLE IF NOT EXISTS `poster_comment` (
  `idUtilisateur` int(10) NOT NULL AUTO_INCREMENT,
  `idPlante` int(10) NOT NULL,
  `title_Comment` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `body_Comment` text COLLATE latin1_general_ci,
  `date_Comment` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idUtilisateur`,`idPlante`),
  KEY `FK_poster_comment_idPlante` (`idPlante`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `idUtilisateur` int(10) NOT NULL AUTO_INCREMENT,
  `isAdmin_Utilisateur` tinyint(4) DEFAULT NULL,
  `nom_Utilisateur` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `prenom_Utilisateur` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `email_Utilisateur` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `telMob_Utilisateur` int(20) DEFAULT NULL,
  `username_Utilisateur` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `password_Utilisateur` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `datePanier_Utilisateur` datetime DEFAULT NULL,
  `batimentAdresse_Utilisateur` int(5) DEFAULT NULL,
  `rueAdresse_Utilisateur` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `codePostaleAdresse_Utilisateur` int(10) DEFAULT NULL,
  `villeAdresse_Utilisateur` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `paysAdresse_Utilisateur` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `isAdmin_Utilisateur`, `nom_Utilisateur`, `prenom_Utilisateur`, `email_Utilisateur`, `telMob_Utilisateur`, `username_Utilisateur`, `password_Utilisateur`, `datePanier_Utilisateur`, `batimentAdresse_Utilisateur`, `rueAdresse_Utilisateur`, `codePostaleAdresse_Utilisateur`, `villeAdresse_Utilisateur`, `paysAdresse_Utilisateur`) VALUES
(1, NULL, 'Admin', 'Admin', 'admin@admin.admin', 123456789, 'Admin', '4e7afebcfbae000b22c7c85e5560f89a2a0280b4', NULL, 123, 'Admin', 123456, 'Admin', 'Admin');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ajouter_au_panier`
--
ALTER TABLE `ajouter_au_panier`
  ADD CONSTRAINT `FK_ajouter_au_panier_idPlante` FOREIGN KEY (`idPlante`) REFERENCES `plantes` (`idPlante`),
  ADD CONSTRAINT `FK_ajouter_au_panier_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_Commande_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `FK_Facture_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Contraintes pour la table `plantes`
--
ALTER TABLE `plantes`
  ADD CONSTRAINT `FK_Plante_idCategorie` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`);

--
-- Contraintes pour la table `poster_comment`
--
ALTER TABLE `poster_comment`
  ADD CONSTRAINT `FK_poster_comment_idPlante` FOREIGN KEY (`idPlante`) REFERENCES `plantes` (`idPlante`),
  ADD CONSTRAINT `FK_poster_comment_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
