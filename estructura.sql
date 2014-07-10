-- phpMyAdmin SQL Dump
-- version 4.1.14.1
-- http://www.phpmyadmin.net
--
-- Servidor: infongd13461:3316
-- Tiempo de generación: 10-07-2014 a las 22:09:01
-- Versión del servidor: 5.1.73-1
-- Versión de PHP: 5.4.4-14+deb7u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `db535393172`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visible` tinyint(1) NOT NULL,
  `imagen` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_idioma`
--

CREATE TABLE IF NOT EXISTS `categoria_idioma` (
  `fk_categoria` int(11) NOT NULL,
  `fk_idioma` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`fk_categoria`,`fk_idioma`),
  KEY `fk_idioma` (`fk_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE IF NOT EXISTS `colores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores_idioma`
--

CREATE TABLE IF NOT EXISTS `colores_idioma` (
  `fk_color` int(11) NOT NULL,
  `fk_idioma` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`fk_color`,`fk_idioma`),
  KEY `fk_idioma` (`fk_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE IF NOT EXISTS `fotos` (
  `id` int(11) NOT NULL,
  `fk_producto` int(11) NOT NULL,
  `orden` smallint(5) NOT NULL,
  `path_foto` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto` (`fk_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idiomas`
--

CREATE TABLE IF NOT EXISTS `idiomas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `short` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `precio` float NOT NULL,
  `fk_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria` (`fk_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_colores`
--

CREATE TABLE IF NOT EXISTS `productos_colores` (
  `fk_producto` int(11) NOT NULL,
  `fk_color` int(11) NOT NULL,
  PRIMARY KEY (`fk_producto`,`fk_color`),
  KEY `fk_color` (`fk_color`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_idioma`
--

CREATE TABLE IF NOT EXISTS `productos_idioma` (
  `fk_producto` int(11) NOT NULL,
  `fk_idioma` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`fk_producto`,`fk_idioma`),
  KEY `fk_idioma` (`fk_idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `contrasenya` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `rol` enum('administrador','comprador') COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria_idioma`
--
ALTER TABLE `categoria_idioma`
  ADD CONSTRAINT `categoria_idioma_ibfk_1` FOREIGN KEY (`fk_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categoria_idioma_ibfk_2` FOREIGN KEY (`fk_idioma`) REFERENCES `idiomas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `colores_idioma`
--
ALTER TABLE `colores_idioma`
  ADD CONSTRAINT `colores_idioma_ibfk_2` FOREIGN KEY (`fk_idioma`) REFERENCES `idiomas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `colores_idioma_ibfk_1` FOREIGN KEY (`fk_color`) REFERENCES `colores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`fk_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`fk_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos_colores`
--
ALTER TABLE `productos_colores`
  ADD CONSTRAINT `productos_colores_ibfk_1` FOREIGN KEY (`fk_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_colores_ibfk_2` FOREIGN KEY (`fk_color`) REFERENCES `colores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos_idioma`
--
ALTER TABLE `productos_idioma`
  ADD CONSTRAINT `productos_idioma_ibfk_1` FOREIGN KEY (`fk_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_idioma_ibfk_2` FOREIGN KEY (`fk_idioma`) REFERENCES `idiomas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
