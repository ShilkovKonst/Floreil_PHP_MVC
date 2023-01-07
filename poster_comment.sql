-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 07 2023 г., 01:02
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
-- Структура таблицы `poster_comment`
--

DROP TABLE IF EXISTS `poster_comment`;
CREATE TABLE IF NOT EXISTS `poster_comment` (
  `idUtilisateur` int(10) NOT NULL AUTO_INCREMENT,
  `idPlante` int(10) NOT NULL,
  `title_Comment` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `body_Comment` text COLLATE latin1_general_ci,
  `date_Comment` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
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
(4, 2, '55', '99', '2023-01-06 23:19:37');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

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
