-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-12-2021 a las 07:27:54
-- Versión del servidor: 8.0.26
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `catalogo2020`
--
CREATE DATABASE IF NOT EXISTS `catalogo2020` DEFAULT CHARACTER SET utf8mb4;
USE `catalogo2020`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `idCategoria` tinyint UNSIGNED NOT NULL,
  `catNombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `catNombre`) VALUES
(1, 'Smartphone'),
(2, 'Cámaras mirorless'),
(3, 'Lentes'),
(4, 'Parlantes bluetooth'),
(5, 'Smart TV'),
(6, 'Consolas'),
(7, 'Tablets');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

DROP TABLE IF EXISTS `marcas`;
CREATE TABLE `marcas` (
  `idMarca` tinyint UNSIGNED NOT NULL,
  `mkNombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`idMarca`, `mkNombre`) VALUES
(1, 'Nikon'),
(2, 'Apple'),
(3, 'Audiotechnica'),
(4, 'Marshall'),
(5, 'Samsung'),
(6, 'Huawei');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `idProducto` mediumint UNSIGNED NOT NULL,
  `prdNombre` varchar(75) NOT NULL,
  `prdPrecio` double(8,2) NOT NULL,
  `idMarca` tinyint UNSIGNED NOT NULL,
  `idCategoria` tinyint UNSIGNED NOT NULL,
  `prdDescripcion` text NOT NULL,
  `prdImagen` varchar(45) NOT NULL,
  `prdActivo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `prdNombre`, `prdPrecio`, `idMarca`, `idCategoria`, `prdDescripcion`, `prdImagen`, `prdActivo`) VALUES
(1, 'Nikon Z6', 1650.00, 1, 2, 'Cuerpo de cámara sin espejo formato full frame. Resolución 24.5 MPX. Bluetooth, Wi-Fi, GPS. ISO 100-51200', 'nikon-z6.jpg', 1),
(2, 'iPhone 12 Pro (256GB) gold', 1200.00, 2, 1, 'Apple iPhone 12 Pro de 256GB color dorado, libre de carrier.', 'iphone-12-pro-gold.png', 1),
(3, 'Marshall Acton II', 300.00, 4, 4, 'Altavoz inalámbrico Marshall Acton II. Wi-Fi y Bluetooth multihabitación color negro.', 'marshall-acton.jpg', 1),
(4, 'Homepod Mini', 99.00, 2, 4, 'Altavoz inteligente inalámbrico. Compatible con Siri. Wifi, Bluetooth. Compatible con multihabitación.', 'homepod-mini.jpg', 1),
(5, 'Samsung Class QLED Q80T Series', 1200.00, 5, 5, 'Smart TV Samsung Class QLED Q80T Series, 65\", 4K, UHD', 'Q80T.jpg', 1),
(6, 'P40 Pro Plus 512GB', 1250.00, 6, 1, 'Smartphone Huawei P40 Pro Plus 5G 512GB', 'P40-pro-plus.jpg', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`idMarca`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `productos_idmarca_foreign` (`idMarca`),
  ADD KEY `productos_idcategoria_foreign` (`idCategoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `idMarca` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` mediumint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_idcategoria_foreign` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idCategoria`),
  ADD CONSTRAINT `productos_idmarca_foreign` FOREIGN KEY (`idMarca`) REFERENCES `marcas` (`idMarca`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
