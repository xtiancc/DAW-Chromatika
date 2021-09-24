-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 25-05-2020 a las 10:45:06
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id12980188_proyecto`
--
CREATE DATABASE IF NOT EXISTS `id12980188_proyecto` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `id12980188_proyecto`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID` int(2) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactar`
--

CREATE TABLE `contactar` (
  `ID` int(10) NOT NULL,
  `nombreE` varchar(20) NOT NULL,
  `nombreR` varchar(20) NOT NULL,
  `mensaje` varchar(500) NOT NULL,
  `fecha` datetime NOT NULL,
  `visualizado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diseno`
--

CREATE TABLE `diseno` (
  `ID` varchar(20) NOT NULL,
  `fuente` char(5) NOT NULL,
  `rID` int(3) NOT NULL,
  `gID` int(3) NOT NULL,
  `bID` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iso_pais`
--

CREATE TABLE `iso_pais` (
  `ID` char(2) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_idioma`
--

CREATE TABLE `nivel_idioma` (
  `ID` char(2) NOT NULL,
  `descr` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_datos`
--

CREATE TABLE `perfil_datos` (
  `ID` int(5) UNSIGNED ZEROFILL NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `direccion` varchar(180) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `ID_pais` char(2) NOT NULL,
  `cod_postal` int(5) NOT NULL,
  `ID_cv` varchar(20) NOT NULL,
  `ID_cat` int(3) NOT NULL,
  `img_perfil` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_experiencia`
--

CREATE TABLE `perfil_experiencia` (
  `ID_perfil` int(5) UNSIGNED ZEROFILL NOT NULL,
  `nombre_esa` varchar(50) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `puesto` varchar(25) NOT NULL,
  `a_inicio` date NOT NULL,
  `a_fin` date DEFAULT NULL,
  `descr` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_formacion`
--

CREATE TABLE `perfil_formacion` (
  `ID_perfil` int(5) UNSIGNED ZEROFILL NOT NULL,
  `a_inicio` date NOT NULL,
  `a_fin` date NOT NULL,
  `titulacion` varchar(90) NOT NULL,
  `escuela` varchar(120) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `descr` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_idioma`
--

CREATE TABLE `perfil_idioma` (
  `ID_perfil` int(5) UNSIGNED ZEROFILL NOT NULL,
  `idioma` varchar(20) NOT NULL,
  `ID_nivel` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario` varchar(20) NOT NULL,
  `email` varchar(320) NOT NULL,
  `contrasena` char(32) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `contactar`
--
ALTER TABLE `contactar`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `nombreE` (`nombreE`),
  ADD KEY `nombreR` (`nombreR`);

--
-- Indices de la tabla `diseno`
--
ALTER TABLE `diseno`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `iso_pais`
--
ALTER TABLE `iso_pais`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `nivel_idioma`
--
ALTER TABLE `nivel_idioma`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `perfil_datos`
--
ALTER TABLE `perfil_datos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_cat` (`ID_cat`),
  ADD KEY `perfil_datos_ibfk_2` (`ID_cv`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `perfil_experiencia`
--
ALTER TABLE `perfil_experiencia`
  ADD PRIMARY KEY (`ID_perfil`,`nombre_esa`,`puesto`);

--
-- Indices de la tabla `perfil_formacion`
--
ALTER TABLE `perfil_formacion`
  ADD PRIMARY KEY (`ID_perfil`,`titulacion`,`escuela`);

--
-- Indices de la tabla `perfil_idioma`
--
ALTER TABLE `perfil_idioma`
  ADD PRIMARY KEY (`ID_perfil`,`idioma`),
  ADD KEY `ID` (`ID_perfil`) USING BTREE,
  ADD KEY `id_nivel` (`ID_nivel`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contactar`
--
ALTER TABLE `contactar`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfil_datos`
--
ALTER TABLE `perfil_datos`
  MODIFY `ID` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfil_experiencia`
--
ALTER TABLE `perfil_experiencia`
  MODIFY `ID_perfil` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfil_formacion`
--
ALTER TABLE `perfil_formacion`
  MODIFY `ID_perfil` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfil_idioma`
--
ALTER TABLE `perfil_idioma`
  MODIFY `ID_perfil` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contactar`
--
ALTER TABLE `contactar`
  ADD CONSTRAINT `contactar_ibfk_1` FOREIGN KEY (`nombreE`) REFERENCES `usuario` (`usuario`),
  ADD CONSTRAINT `contactar_ibfk_2` FOREIGN KEY (`nombreR`) REFERENCES `usuario` (`usuario`);

--
-- Filtros para la tabla `perfil_datos`
--
ALTER TABLE `perfil_datos`
  ADD CONSTRAINT `perfil_datos_ibfk_1` FOREIGN KEY (`ID_cat`) REFERENCES `categoria` (`ID`),
  ADD CONSTRAINT `perfil_datos_ibfk_2` FOREIGN KEY (`ID_cv`) REFERENCES `diseno` (`ID`),
  ADD CONSTRAINT `perfil_datos_ibfk_3` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`usuario`);

--
-- Filtros para la tabla `perfil_experiencia`
--
ALTER TABLE `perfil_experiencia`
  ADD CONSTRAINT `perfil_experiencia_ibfk_1` FOREIGN KEY (`ID_perfil`) REFERENCES `perfil_datos` (`ID`);

--
-- Filtros para la tabla `perfil_formacion`
--
ALTER TABLE `perfil_formacion`
  ADD CONSTRAINT `perfil_formacion_ibfk_1` FOREIGN KEY (`ID_perfil`) REFERENCES `perfil_datos` (`ID`);

--
-- Filtros para la tabla `perfil_idioma`
--
ALTER TABLE `perfil_idioma`
  ADD CONSTRAINT `perfil_idioma_ibfk_1` FOREIGN KEY (`ID_perfil`) REFERENCES `perfil_datos` (`ID`),
  ADD CONSTRAINT `perfil_idioma_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `nivel_idioma` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
