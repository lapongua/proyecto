-- phpMyAdmin SQL Dump
-- version 4.1.14.1
-- http://www.phpmyadmin.net
--
-- Servidor: infongd13461:3316
-- Tiempo de generación: 10-07-2014 a las 22:09:16
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

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `visible`, `imagen`) VALUES
(1, 1, ''),
(2, 1, ''),
(3, 1, ''),
(4, 1, ''),
(20, 1, '');

--
-- Volcado de datos para la tabla `categoria_idioma`
--

INSERT INTO `categoria_idioma` (`fk_categoria`, `fk_idioma`, `nombre`, `descripcion`) VALUES
(1, 1, 'Boxeo', 'Gran variedad de ropa, accesorios y guantes de boxeo en tu tienda online de artes marciales al mejor precio de las marcas TOP TEN y HAYASHI.'),
(1, 2, 'Boxeo', 'Wide range of clothing, accessories and boxing gloves on your online store at the best price martial TOP TEN of the arts and HAYASHI brands.'),
(1, 3, 'Boxeo', 'Große Auswahl an Kleidung, Accessoires und Boxhandschuhen auf Ihrem Online-Shop zum besten Preis Kampf TOP TEN der Künste und HAYASHI Marken.'),
(2, 1, 'Kickboxing', 'Tienda online de kickboxing Top Ten y Hayashi, todos los accesorios, material, guantes y ropa de kickboing de mejor calidad al mejor precio en España.'),
(2, 2, 'Kickboxing', 'Shop online and kickboxing Top Ten Hayashi, all accessories, equipment, gloves and kickboing best quality at the best price in Spain.'),
(2, 3, 'Kickboxing', 'Online-Shop und Kickboxen Top Ten Hayashi, alle Zubehörteile, Ausrüstung, Handschuhe und kickboing beste Qualität zum besten Preis in Spanien.'),
(3, 1, 'Karate', 'Tienda online de karate. Judogi, complementos, kimonos, tatamis, cinturones y protecciones. Toda la ropa de entrenamiento y material necesario para practicar karate. '),
(3, 2, 'Karate', 'Shop online karate. Gi, accessories, kimonos, tatami mats, belts and protections. All clothing and training necessary to practice karate material.'),
(3, 3, 'Karate', 'Online-Shop Karate. Gi, Zubehör, Kimonos, Tatami-Matten, Gurte und Schutzmaßnahmen. Alle Kleidungsstücke und Schulung notwendig, Karate Material zu üben.'),
(4, 1, 'Taekwon-do', 'En nuestra tienda online de taekwondo podrás encontrar unifomes y kimonos de taekwondo al mejor precio. Así como todo el material y accesorios necesarios para el taekwon-do.'),
(4, 2, 'Taekwon-do', 'In our online shop you can find Taekwondo Uniforms and kimonos taekwondo at the best price. And all material and accessories needed for taekwon-do./'),
(20, 1, 'Pilates', 'deporte para hacer abdominales');

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id`, `visible`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1);

--
-- Volcado de datos para la tabla `colores_idioma`
--

INSERT INTO `colores_idioma` (`fk_color`, `fk_idioma`, `nombre`) VALUES
(1, 1, 'Blanco'),
(1, 2, 'White'),
(2, 1, 'Rojo'),
(2, 2, 'Red'),
(3, 1, 'Verde'),
(3, 2, 'Green'),
(4, 1, 'Azul'),
(4, 2, 'Blue'),
(5, 1, 'Amarillo'),
(6, 1, 'Naranja'),
(7, 1, 'Negro'),
(8, 1, 'Rosa');

--
-- Volcado de datos para la tabla `idiomas`
--

INSERT INTO `idiomas` (`id`, `nombre`, `short`) VALUES
(1, 'Español', 'es'),
(2, 'Inglés', 'en'),
(3, 'Alemán', 'de');

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `sku`, `precio`, `fk_categoria`) VALUES
(1, '2066', 53.7, 1),
(2, '1955', 20.65, 2),
(4, 'P-123', 15, 20),
(12, '22', 55.3, 1),
(13, '1703-9', 47.93, 1);

--
-- Volcado de datos para la tabla `productos_colores`
--

INSERT INTO `productos_colores` (`fk_producto`, `fk_color`) VALUES
(2, 1),
(13, 1),
(1, 2),
(2, 2),
(4, 2),
(4, 3),
(12, 3),
(1, 4),
(4, 4),
(1, 7),
(13, 7);

--
-- Volcado de datos para la tabla `productos_idioma`
--

INSERT INTO `productos_idioma` (`fk_producto`, `fk_idioma`, `nombre`, `descripcion`) VALUES
(1, 1, 'Guantes de boxeo PPS Top Ten', 'Guante de mismas caraterísticas que modelo AIBA fabricado en Piel y palma con rexion-piel artificial de alta duración.'),
(2, 1, 'Camiseta de kickboxing V Neck Top Ten', 'Camisetas Kickboxing de manga corta V-Fighting hechas de material ligero y cómodo.'),
(4, 1, 'Bola de pilates', 'Bola de pilates de 60cm para hacer ejercicio y moldear tu cuerpo.'),
(4, 2, 'Pilates Ball', 'Ball for exercices of pilates... 60cm of diametre.'),
(12, 1, 'Guantes de Boxeo', 'Guantes de boxeo con un diseño especial para profesionales.'),
(13, 1, 'Botas de boxeo New Hight Top Ten', 'Estas botas de boxeo cuentan con una suela especial de reciente desarrollo, que asegura un mejor agarre, y permite el movimiento más rápido y más fácil de pivote.');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `contrasenya`, `rol`) VALUES
(1, 'admin', 'nitsnets', 'admin@admin.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'administrador');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
