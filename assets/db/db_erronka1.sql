-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-11-2023 a las 08:07:44
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_erronka1`
--
CREATE DATABASE IF NOT EXISTS `db_erronka1` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `db_erronka1`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `argazkiak`
--

CREATE TABLE `argazkiak` (
  `id_argazkia` int(11) NOT NULL,
  `id_iragarkia` int(11) NOT NULL,
  `extensioa` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `argazkiak`
--

INSERT INTO `argazkiak` (`id_argazkia`, `id_iragarkia`, `extensioa`) VALUES
(1, 1, 'png'),
(2, 1, 'png'),
(3, 1, 'png'),
(4, 2, 'png'),
(5, 2, 'png'),
(6, 3, 'png'),
(7, 4, 'png'),
(8, 4, 'png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `erabiltzaileak`
--

CREATE TABLE `erabiltzaileak` (
  `id_erabiltzailea` int(11) NOT NULL,
  `erabiltzailea` varchar(50) NOT NULL,
  `posta_elektronikoa` varchar(50) NOT NULL,
  `pasahitza` varchar(160) NOT NULL,
  `izena` varchar(20) NOT NULL,
  `abizena` varchar(50) NOT NULL,
  `nan` varchar(9) NOT NULL,
  `adina` int(11) NOT NULL,
  `extensioa` varchar(4) DEFAULT NULL,
  `deskribapena` varchar(200) DEFAULT NULL,
  `telefonoa` int(9) DEFAULT NULL,
  `kokapena` varchar(100) DEFAULT NULL,
  `rol` int(11) NOT NULL COMMENT '0 admin, 1 erabiltzaile normala',
  `egiaztatua` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `erabiltzaileak`
--

INSERT INTO `erabiltzaileak` (`id_erabiltzailea`, `erabiltzailea`, `posta_elektronikoa`, `pasahitza`, `izena`, `abizena`, `nan`, `adina`, `extensioa`, `deskribapena`, `telefonoa`, `kokapena`, `rol`, `egiaztatua`) VALUES
(3, 'aritzadmin', 'aritz3040@gmail.com', 'd9e6762dd1c8eaf6d61b3c6192fc408d4d6d5f1176d0c29169bc24e71c3f274ad27fcd5811b313d681f7e55ec02d73d499c95455b6b5bb503acf574fba8ffe85', 'Admin Aritz', 'Garcia', '16108792Y', 20, 'png', NULL, NULL, NULL, 0, 1),
(4, 'garcia', 'garcia@gmail.com', 'd9e6762dd1c8eaf6d61b3c6192fc408d4d6d5f1176d0c29169bc24e71c3f274ad27fcd5811b313d681f7e55ec02d73d499c95455b6b5bb503acf574fba8ffe85', 'Aritz', 'Garcia', '16108792Y', 20, 'png', NULL, NULL, NULL, 1, 1),
(6, 'aritz', 'aritz1@gmail.com', 'd9e6762dd1c8eaf6d61b3c6192fc408d4d6d5f1176d0c29169bc24e71c3f274ad27fcd5811b313d681f7e55ec02d73d499c95455b6b5bb503acf574fba8ffe85', 'Aritz', 'Garcia Barañano', '16108792Y', 21, 'png', NULL, NULL, NULL, 1, 0),
(7, 'proba', 'gmail@gmail.com', 'd9e6762dd1c8eaf6d61b3c6192fc408d4d6d5f1176d0c29169bc24e71c3f274ad27fcd5811b313d681f7e55ec02d73d499c95455b6b5bb503acf574fba8ffe85', 'Aritz', 'Proba', '12345678Z', 16, 'png', 'kjyf7b', 123456789, NULL, 1, 1),
(10, 'proba1', 'aritz.garciaba.txurdi@gmail.com', 'f81766f1648b877ba7224fe9d4b004d5d8a0445ad26f13e4501a21c613a3329331404cb5e7e51fd089975e7106361a7dc43143138021e50b5ab6a2e7679f74be', 'proba', 'proba', '12345678z', 16, '', '', 0, '', 1, 0),
(11, 'probak', 'aritz.garciaba@elorrieta-errekamari.com', 'f81766f1648b877ba7224fe9d4b004d5d8a0445ad26f13e4501a21c613a3329331404cb5e7e51fd089975e7106361a7dc43143138021e50b5ab6a2e7679f74be', 'aritz', 'garcia', '12345678z', 16, '', '', 0, '', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gogokoak`
--

CREATE TABLE `gogokoak` (
  `id_gogokoa` int(11) NOT NULL,
  `id_iragarkia` int(11) NOT NULL,
  `id_erabiltzailea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iragarkiak`
--

CREATE TABLE `iragarkiak` (
  `id_iragarkia` int(11) NOT NULL,
  `id_erabiltzailea` int(11) NOT NULL,
  `izena` varchar(50) NOT NULL,
  `deskribapena` varchar(200) DEFAULT NULL,
  `prezioa` float NOT NULL,
  `bidalketa` tinyint(1) NOT NULL,
  `kategoria_id` int(11) NOT NULL,
  `kokapena` varchar(100) DEFAULT NULL,
  `data_hasiera` date DEFAULT NULL,
  `data_bukaera` date DEFAULT NULL,
  `egiaztatua` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `iragarkiak`
--

INSERT INTO `iragarkiak` (`id_iragarkia`, `id_erabiltzailea`, `izena`, `deskribapena`, `prezioa`, `bidalketa`, `kategoria_id`, `kokapena`, `data_hasiera`, `data_bukaera`, `egiaztatua`) VALUES
(1, 3, 'Proba', NULL, 0, 1, 4, NULL, '2023-10-19', '2023-10-26', 1),
(2, 7, 'A', 'Proba bat egiteko', 12, 0, 3, 'Bilbo', '2023-10-19', '2023-10-28', 1),
(3, 3, 'fposdmxzv', NULL, 0, 0, 1, NULL, '2023-10-31', '2023-10-31', 1),
(4, 10, 'Proba gaitzeko', 'Proba gaitzeko deskribapena', 0, 1, 6, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kategoria`
--

CREATE TABLE `kategoria` (
  `id_kategoria` int(11) NOT NULL,
  `izena` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `kategoria`
--

INSERT INTO `kategoria` (`id_kategoria`, `izena`) VALUES
(3, 'arropa'),
(6, 'bildumazaletasun'),
(8, 'ekitaldiak'),
(5, 'etxea'),
(2, 'informatika'),
(4, 'kirolak'),
(1, 'motor'),
(7, 'umeak');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `argazkiak`
--
ALTER TABLE `argazkiak`
  ADD PRIMARY KEY (`id_argazkia`),
  ADD KEY `id_iragarkia` (`id_iragarkia`);

--
-- Indices de la tabla `erabiltzaileak`
--
ALTER TABLE `erabiltzaileak`
  ADD PRIMARY KEY (`id_erabiltzailea`),
  ADD UNIQUE KEY `posta_elektronikoa` (`posta_elektronikoa`),
  ADD UNIQUE KEY `erabiltzailea` (`erabiltzailea`);

--
-- Indices de la tabla `gogokoak`
--
ALTER TABLE `gogokoak`
  ADD PRIMARY KEY (`id_gogokoa`),
  ADD KEY `fk_id_iragarkia_gogokoak` (`id_iragarkia`),
  ADD KEY `fk_id_erabiltzailea_gogokoak` (`id_erabiltzailea`);

--
-- Indices de la tabla `iragarkiak`
--
ALTER TABLE `iragarkiak`
  ADD PRIMARY KEY (`id_iragarkia`),
  ADD KEY `kategoria_id` (`kategoria_id`),
  ADD KEY `posta_elektronikoa` (`id_erabiltzailea`);

--
-- Indices de la tabla `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id_kategoria`),
  ADD UNIQUE KEY `izena` (`izena`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `erabiltzaileak`
--
ALTER TABLE `erabiltzaileak`
  MODIFY `id_erabiltzailea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `gogokoak`
--
ALTER TABLE `gogokoak`
  MODIFY `id_gogokoa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id_kategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `argazkiak`
--
ALTER TABLE `argazkiak`
  ADD CONSTRAINT `argazkiak_ibfk_1` FOREIGN KEY (`id_iragarkia`) REFERENCES `iragarkiak` (`id_iragarkia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gogokoak`
--
ALTER TABLE `gogokoak`
  ADD CONSTRAINT `fk_id_erabiltzailea_gogokoak` FOREIGN KEY (`id_erabiltzailea`) REFERENCES `erabiltzaileak` (`id_erabiltzailea`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_iragarkia_gogokoak` FOREIGN KEY (`id_iragarkia`) REFERENCES `iragarkiak` (`id_iragarkia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `iragarkiak`
--
ALTER TABLE `iragarkiak`
  ADD CONSTRAINT `fk_id_erabiltzailea` FOREIGN KEY (`id_erabiltzailea`) REFERENCES `erabiltzaileak` (`id_erabiltzailea`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `iragarkiak_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`id_kategoria`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
