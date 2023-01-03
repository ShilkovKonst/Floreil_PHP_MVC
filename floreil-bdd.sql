-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 03 jan. 2023 à 15:40
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
-- Base de données : `floreil-bdd`
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
  `nom_Categorie` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `resistanceFroid_Categorie` tinyint(1) DEFAULT NULL,
  `resistanceFroidBas_Categorie` int(3) DEFAULT NULL,
  `resistanceFroidHaut_Categorie` int(3) DEFAULT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `nom_Categorie`, `resistanceFroid_Categorie`, `resistanceFroidBas_Categorie`, `resistanceFroidHaut_Categorie`) VALUES
(1, 'exterieur', 1, -20, -15);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `idCommande` int(10) NOT NULL AUTO_INCREMENT,
  `numero_Commande` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `linkAgenceLivraison_Commande` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `numeroExtLivraison_Commande` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
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
  `numero_Facture` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `montantPanier_Facture` float DEFAULT NULL,
  `date_Facture` datetime DEFAULT CURRENT_TIMESTAMP,
  `document_Facture` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `idUtilisateur` int(10) DEFAULT NULL,
  PRIMARY KEY (`idFacture`),
  KEY `FK_Facture_idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plante`
--

DROP TABLE IF EXISTS `plante`;
CREATE TABLE IF NOT EXISTS `plante` (
  `idPlante` int(10) NOT NULL AUTO_INCREMENT,
  `createdDate_Plante` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title_Plante` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `description_Plante` text COLLATE latin1_general_ci,
  `image_Plante` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `prix_Plante` float DEFAULT NULL,
  `qnty_Plante` int(5) DEFAULT NULL,
  `nomCommun_Plante` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `genrePlante` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `espece_Plante` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `variete_Plante` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `famille_Plante` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `hauteurCM_Plante` int(5) DEFAULT NULL,
  `feillage_Plante` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `arrosage_Plante` text COLLATE latin1_general_ci,
  `floraison_Plante` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `floraisonParfumee_Plante` tinyint(1) DEFAULT NULL,
  `modeVie_Plante` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `idCategorie` int(10) DEFAULT NULL,
  PRIMARY KEY (`idPlante`),
  KEY `FK_Plante_idCategorie` (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Déchargement des données de la table `plante`
--

INSERT INTO `plante` (`idPlante`, `createdDate_Plante`, `title_Plante`, `description_Plante`, `image_Plante`, `prix_Plante`, `qnty_Plante`, `nomCommun_Plante`, `genrePlante`, `espece_Plante`, `variete_Plante`, `famille_Plante`, `hauteurCM_Plante`, `feillage_Plante`, `arrosage_Plante`, `floraison_Plante`, `floraisonParfumee_Plante`, `modeVie_Plante`, `idCategorie`) VALUES
(1, '2023-01-03 15:36:53', 'Cupressocyparis Leylandii', NULL, 'cupressocyparis-leylandii.jpg', 149, 23, 'Cypres de Leyland dore', 'X Cupressocyparis', 'Leylandii', 'Castlewellan Gold', 'Cupressacees', 150, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `idUtilisateur` int(10) NOT NULL AUTO_INCREMENT,
  `nom_Utilisateur` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `prenom_Utilisateur` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `email_Utilisateur` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `telMob_Utilisateur` int(20) DEFAULT NULL,
  `username_Utilisateur` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `password_Utilisateur` varchar(15) COLLATE latin1_general_ci NOT NULL COMMENT 'encryption sha1',
  `role_Utilisateur` tinyint(1) NOT NULL COMMENT 'user, admin etc',
  `datePanier_Utilisateur` datetime DEFAULT CURRENT_TIMESTAMP,
  `batimentAdresse_Utilisateur` int(5) DEFAULT NULL,
  `rueAdresse_Utilisateur` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `codePostaleAdresse_Utilisateur` int(6) DEFAULT NULL,
  `villeAdresse_Utilisateur` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `paysAdresse_Utilisateur` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ajouter_au_panier`
--
ALTER TABLE `ajouter_au_panier`
  ADD CONSTRAINT `FK_ajouter_au_panier_idPlante` FOREIGN KEY (`idPlante`) REFERENCES `plante` (`idPlante`),
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
-- Contraintes pour la table `plante`
--
ALTER TABLE `plante`
  ADD CONSTRAINT `FK_Plante_idCategorie` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
