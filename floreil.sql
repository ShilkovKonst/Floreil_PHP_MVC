-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 09 2023 г., 23:03
-- Версия сервера: 5.7.36
-- Версия PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `floreil`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ajouter_au_panier`
--

DROP TABLE IF EXISTS `ajouter_au_panier`;
CREATE TABLE IF NOT EXISTS `ajouter_au_panier` (
  `idPlante` int(10) NOT NULL AUTO_INCREMENT,
  `idUtilisateur` int(10) NOT NULL,
  `title_PlantePanier` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `image_PlantePanier` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `qnty_plantePanier` int(5) DEFAULT NULL,
  `qnty_planteStock` int(11) NOT NULL,
  `prixPourQnty_plante` float DEFAULT NULL,
  PRIMARY KEY (`idPlante`,`idUtilisateur`),
  KEY `FK_ajouter_au_panier_idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Дамп данных таблицы `ajouter_au_panier`
--

INSERT INTO `ajouter_au_panier` (`idPlante`, `idUtilisateur`, `title_PlantePanier`, `image_PlantePanier`, `qnty_plantePanier`, `qnty_planteStock`, `prixPourQnty_plante`) VALUES
(2, 4, 'Monstera Deliciosa : D.24cm', 'monstera-deliciosa.jpg', 2, 96, 98);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `idCategorie` int(10) NOT NULL AUTO_INCREMENT,
  `nom_Categorie` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `body_Categorie` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `image_Categorie` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`idCategorie`, `nom_Categorie`, `body_Categorie`, `image_Categorie`) VALUES
(1, 'Plantes d\'interieur', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat a lorem at pretium. Integer euismod est lectus, non mattis ipsum efficitur sed. Suspendisse consequat erat risus, vitae semper mi volutpat sed.', 'section-plantes-interieur.jpeg'),
(2, 'Plantes d\'exterieur', 'Cras vulputate felis enim, rhoncus blandit mauris feugiat et. Nullam ligula purus, cursus sit amet laoreet quis, commodo et tortor. In hac habitasse platea dictumst. Phasellus rutrum est vitae est semper porta. Morbi posuere commodo nibh nec convallis.', 'section-plantes-exterieur.jpeg');

-- --------------------------------------------------------

--
-- Структура таблицы `commande`
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
-- Структура таблицы `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `idFacture` int(10) NOT NULL AUTO_INCREMENT,
  `numero_Facture` int(100) DEFAULT NULL,
  `montantPanier_Facture` float DEFAULT NULL,
  `date_Facture` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `document_Facture` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `idUtilisateur` int(10) DEFAULT NULL,
  PRIMARY KEY (`idFacture`),
  KEY `FK_Facture_idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Дамп данных таблицы `facture`
--

INSERT INTO `facture` (`idFacture`, `numero_Facture`, `montantPanier_Facture`, `date_Facture`, `document_Facture`, `idUtilisateur`) VALUES
(2, 4463, 463, '2023-01-09 20:37:35', '4463', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `plantes`
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
  `feuillage_Plante` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `arrosage_Plante` text COLLATE latin1_general_ci,
  `floraison_Plante` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `modeVie_Plante` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `resistanceFroid_Plante` tinyint(1) DEFAULT NULL,
  `resistanceFroidBas_Plante` int(3) DEFAULT NULL,
  `resistanceFroidHaut_Plante` int(3) DEFAULT NULL,
  `idCategorie` int(10) DEFAULT NULL,
  PRIMARY KEY (`idPlante`),
  KEY `FK_Plante_idCategorie` (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Дамп данных таблицы `plantes`
--

INSERT INTO `plantes` (`idPlante`, `createdDate_Plante`, `title_Plante`, `description_Plante`, `image_Plante`, `prix_Plante`, `qnty_Plante`, `nomCommun_Plante`, `hauteurCM_Plante`, `feuillage_Plante`, `arrosage_Plante`, `floraison_Plante`, `modeVie_Plante`, `resistanceFroid_Plante`, `resistanceFroidBas_Plante`, `resistanceFroidHaut_Plante`, `idCategorie`) VALUES
(1, '2023-01-05 22:43:22', 'Cupressocyparis Leylandii', 'Identique au cypres de Leyland type, de forme reguliere et conique, cette variete s\'en distingue par son tres joli feuillage nimbe d\'or. Tres dores au printemps, les rameaux se teintent legerement de vert bronze en automne. Ce qui le rend aussi decoratif plante dans la haie qu\'en isole. Se prêtant facilement a la taille, il est utilise en topiaire sous differentes formes: spirales, boules, ou encore pompons.', 'cupressocyparis-leylandii-castlewellan-gol.jpg', 89, 197, 'Cypres de Leyland dore', 150, 'Persistant', 'Arrosez de façon suivie pendant les deux ans qui suivent la plantation. Au-dela intervenez lors d\'episodes de chaleur prolongee, en apportant l\'eau au pied des arbres et non par aspersion. Veillez a ce qu\'un paillage recouvre toujours le sol au pied', 'de Mai a Juin', 'Vivace', 1, -20, -15, 2),
(2, '2023-01-05 22:43:22', 'Monstera Deliciosa : D.24cm', 'Le Monstera Deliciosa est une vigoureuse vivace de type liane, de la famille des Aracees. C\'est un faux philodendron, le nom vernaculaire Philodendron etant largement utilise pour designer les individus commercialises comme plante ornementale d\'appartement. Le Monstera deliciosa est une plante a la croissance rapide largement utilisee comme plante ornementale dans les regions tropicales et subtropicales.', 'monstera-deliciosa.jpg', 49, 96, 'Faux-Philodendron', 100, 'Persistant', 'Arrosez de façon suivie pendant les deux ans qui suivent la plantation. Au-dela intervenez lors d\'episodes de chaleur prolongee, en apportant l\'eau au pied des arbres et non par aspersion. Veillez a ce qu\'un paillage recouvre toujours le sol au pied', 'de Mai a Juin', 'Vivace', 0, 0, 0, 1),
(18, '2023-01-07 05:43:43', 'Hibiscus syriacus : conteneur 7,5 litres', '<p>sgsgsgdsg</p>', 'hibiscus-syriacus-woodbridge.jpg', 49, 167, 'Althea \' Woodbridge \'', 25, 'Caduc', 'sdsdgsg', 'de Mai a Juin', 'Vivace', 1, -20, -15, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `poster_comment`
--

DROP TABLE IF EXISTS `poster_comment`;
CREATE TABLE IF NOT EXISTS `poster_comment` (
  `idUtilisateur` int(10) NOT NULL AUTO_INCREMENT,
  `idPlante` int(10) NOT NULL,
  `title_Comment` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `body_Comment` text COLLATE latin1_general_ci,
  `date_Comment` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idUtilisateur`,`idPlante`),
  KEY `FK_poster_comment_idPlante` (`idPlante`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Дамп данных таблицы `poster_comment`
--

INSERT INTO `poster_comment` (`idUtilisateur`, `idPlante`, `title_Comment`, `body_Comment`, `date_Comment`) VALUES
(1, 1, 'Great plant!', 'I\'m very happy with it', '2023-01-06 18:42:59'),
(1, 2, 'fkygul', 'ulyllyi', '2023-01-06 22:37:00'),
(3, 1, 'Not bad', 'It\'s ok...', '2023-01-06 21:16:22'),
(4, 2, 'sdghhh', 'gtergerhert', '2023-01-09 18:47:29');

-- --------------------------------------------------------

--
-- Структура таблицы `utilisateurs`
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Дамп данных таблицы `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `isAdmin_Utilisateur`, `nom_Utilisateur`, `prenom_Utilisateur`, `email_Utilisateur`, `telMob_Utilisateur`, `username_Utilisateur`, `password_Utilisateur`, `datePanier_Utilisateur`, `batimentAdresse_Utilisateur`, `rueAdresse_Utilisateur`, `codePostaleAdresse_Utilisateur`, `villeAdresse_Utilisateur`, `paysAdresse_Utilisateur`) VALUES
(1, 0, 'Admin', 'Admin', 'admin@admin.admin', 123456789, 'Admin', '4e7afebcfbae000b22c7c85e5560f89a2a0280b4', NULL, 123, 'Admin', 123456, 'Admin', 'Admin'),
(3, NULL, 'User', 'User', 'User@User.User', 123456789, 'User', '9f8a2389a20ca0752aa9e95093515517e90e194c', NULL, 123, 'User', 123, 'User', 'User'),
(4, NULL, 'Nom_User', 'Prenom_User', 'User1@User1.User1', 123456789, 'Pseudo_User', '4146594c9c6ac5407a3123560401170c2756a342', NULL, 123, 'Rue_User', 123, 'Ville_User', 'Pays_User');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ajouter_au_panier`
--
ALTER TABLE `ajouter_au_panier`
  ADD CONSTRAINT `FK_ajouter_au_panier_idPlante` FOREIGN KEY (`idPlante`) REFERENCES `plantes` (`idPlante`),
  ADD CONSTRAINT `FK_ajouter_au_panier_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Ограничения внешнего ключа таблицы `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_Commande_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Ограничения внешнего ключа таблицы `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `FK_Facture_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Ограничения внешнего ключа таблицы `plantes`
--
ALTER TABLE `plantes`
  ADD CONSTRAINT `FK_Plante_idCategorie` FOREIGN KEY (`idCategorie`) REFERENCES `categories` (`idCategorie`);

--
-- Ограничения внешнего ключа таблицы `poster_comment`
--
ALTER TABLE `poster_comment`
  ADD CONSTRAINT `FK_poster_comment_idPlante` FOREIGN KEY (`idPlante`) REFERENCES `plantes` (`idPlante`),
  ADD CONSTRAINT `FK_poster_comment_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
