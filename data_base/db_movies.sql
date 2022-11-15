-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2022 a las 23:00:17
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_movies`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id_genre` int(11) NOT NULL,
  `genreName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id_genre`, `genreName`) VALUES
(26, 'Accion'),
(27, 'Animacion'),
(23, 'Drama'),
(31, 'Familiar'),
(29, 'Humor'),
(28, 'Romance');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id_movie` int(11) NOT NULL,
  `movieName` varchar(100) NOT NULL,
  `movieImage` varchar(200) NOT NULL,
  `movieLength` varchar(10) NOT NULL,
  `director` varchar(200) NOT NULL,
  `fk_genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id_movie`, `movieName`, `movieImage`, `movieLength`, `director`, `fk_genre_id`) VALUES
(36, 'Pokemon', 'imgs/movies/634c2b12a722c.jpg', '2:50', 'Nashimoto kusamano', 27),
(37, 'Mi pobre angelito', 'imgs/movies/634c2b486f551.jpg', '1:30', 'jim carrey', 23),
(38, 'Scary Movie', 'imgs/movies/634c2b8146178.jpg', '1:35', 'ramon valdes', 29),
(39, 'Como salir de bufalo', 'imgs/movies/634c2baa83eaa.jpg', '1:45', 'bob marley', 23),
(40, 'Homebound', 'imgs/movies/634c2bd0233b0.jpg', '1:58', 'Holland ', 23),
(41, 'El señor de los anillos', 'imgs/movies/634c2c2b4031d.jpg', '2:20', 'Bob Smith', 26),
(42, 'Los 800', 'imgs/movies/634c7bcd29e73.jpg', '2:30', 'Mishamoto mushashi', 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenias`
--

CREATE TABLE `resenias` (
  `id_review` int(11) NOT NULL,
  `review` varchar(500) NOT NULL,
  `user` varchar(50) NOT NULL,
  `fk_movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `resenias`
--

INSERT INTO `resenias` (`id_review`, `review`, `user`, `fk_movie_id`) VALUES
(23, 'Probando Probando', 'Nicola Tesla', 37),
(24, 'Probando Probando', 'Nicola Tesla', 37),
(26, 'Probando Probando', 'Nicola Tesla', 37),
(27, 'Modificando review', 'Nicola Tesla', 37),
(28, '1', 'Nicola Tesla', 37),
(29, 'Review modificada otra vez', 'Nicola Tesla', 37),
(30, '3', 'Nicola Tesla', 37),
(31, '4', 'Nicola Tesla', 37),
(32, '5', 'Nicola Tesla', 37),
(33, '5', 'Nicola Tesla', 37),
(34, '5', 'Jess', 37),
(35, 'Before You Go', 'Lewis Capaldi', 37),
(36, 'Hola', 'Pepe', 36),
(37, 'Hola2', 'Pepe', 36),
(38, 'Hola3', 'Pepe', 36),
(39, 'Hola4', 'Pepe', 36),
(40, 'Juan escribio esto', 'Juan', 36),
(41, 'Juan escribio esto', ' ', 36),
(42, 'Juan escribio esto', ' ', 36),
(43, ' ', ' ', 36),
(44, 'Nueva review', 'Jess', 36);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '$2a$12$JqT5OUt3qjQhRkukpWjMTOq2NyKr4QU/vzgt1T/dPx62LK/03whh.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_genre`),
  ADD UNIQUE KEY `genreName` (`genreName`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id_movie`),
  ADD UNIQUE KEY `movieName` (`movieName`),
  ADD KEY `id_genero_fk` (`fk_genre_id`);

--
-- Indices de la tabla `resenias`
--
ALTER TABLE `resenias`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `fk_movie_id` (`fk_movie_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id_movie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `resenias`
--
ALTER TABLE `resenias`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD CONSTRAINT `peliculas_ibfk_1` FOREIGN KEY (`fk_genre_id`) REFERENCES `genero` (`id_genre`);

--
-- Filtros para la tabla `resenias`
--
ALTER TABLE `resenias`
  ADD CONSTRAINT `resenias_ibfk_1` FOREIGN KEY (`fk_movie_id`) REFERENCES `peliculas` (`id_movie`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
