-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-11-2024 a las 03:52:49
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nicolas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncio`
--

CREATE TABLE `anuncio` (
  `id` int(11) NOT NULL,
  `imagen` varchar(120) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL,
  `enlace` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `fecha` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `anuncio`
--

INSERT INTO `anuncio` (`id`, `imagen`, `titulo`, `descripcion`, `estado`, `enlace`, `id_user`, `fecha`) VALUES
(1, 'IMGWSR20240329123108.png', 'PRUEBA DE ANUNCIO', 'holaaaaaaaaaaaaaaaaaa', 0, 'asd', 5, '2024-03-29'),
(2, 'IMGWSR20240329123134.png', 'anuncio de prueba', '1asdasdasdasd', 0, '[object Object]', 5, '2024-03-29'),
(3, 'IMGWSR20240329123408.png', 'asdasdasdasd', 'asdasdasd', 0, '[object Object]', 5, '2024-03-29'),
(4, '', 'Último anuncio', 'asdasdasd asdasdasd asdasdasd asdasdasd asdasdasd', 1, 'https://www.youtube.com/watch?v=SJYhhHk-wS0', 5, '2024-03-29'),
(5, '', 'video de priueba', 'asdasdasd asdasdasd asdasdasd asdasdasd asdasdasd', 0, 'https://www.youtube.com/watch?v=SJYhhHk-wS0', 5, '2024-03-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `completed`
--

CREATE TABLE `completed` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `completed`
--

INSERT INTO `completed` (`id`, `id_curso`, `id_usuario`) VALUES
(13, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `titulo_curso` varchar(120) NOT NULL,
  `imagen_curso` varchar(120) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `duracion` varchar(20) NOT NULL,
  `id_instructor` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `is_free` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `titulo_curso`, `imagen_curso`, `descripcion`, `duracion`, `id_instructor`, `fecha_creacion`, `activo`, `is_free`) VALUES
(1, 'PRIMER CURSO', 'IMGWSR20240321214008.png', 'DESCRIPCION DEL CURSO', '', 5, '2024-03-02', 1, 0),
(2, 'PRIMER CURSO CORREGIDO', 'IMGWSR20240321214141.png', 'CURSO HECHO POR MI', '1:50', 5, '2024-03-02', 1, 1),
(3, 'CURSO DE PRUEBA', 'IMGWSR20240321230410.png', '', '', 5, '2024-03-21', 0, 0),
(4, 'CUARTO CURSO DE PRUEBA', 'IMGWSR20240321230447.png', '', '', 5, '2024-03-21', 0, 0),
(5, 'QUINTO CURSO DE PRUEBA', 'IMGWSR20240321230530.png', '', '', 5, '2024-03-21', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `ultima_leccion_vista_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `user_id`, `course_id`, `ultima_leccion_vista_id`) VALUES
(32, 5, 1, 1),
(33, 5, 1, 11),
(34, 5, 1, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fav`
--

CREATE TABLE `fav` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `fav`
--

INSERT INTO `fav` (`id`, `id_curso`, `id_usuario`) VALUES
(65, 2, 13),
(73, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lecciones`
--

CREATE TABLE `lecciones` (
  `id_leccion` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `descripción` varchar(255) NOT NULL,
  `contenido` varchar(150) NOT NULL,
  `video_url` text NOT NULL,
  `orden` int(11) NOT NULL,
  `duracion` varchar(150) NOT NULL,
  `is_completed` tinyint(1) NOT NULL,
  `active` int(11) NOT NULL,
  `img_leccion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `lecciones`
--

INSERT INTO `lecciones` (`id_leccion`, `id_curso`, `titulo`, `descripción`, `contenido`, `video_url`, `orden`, `duracion`, `is_completed`, `active`, `img_leccion`) VALUES
(1, 1, 'Leccion 1', 'Este es el curso', 'Holaaa', 'https://player.vimeo.com/video/809604660?h=5bfbb7ddd6', 1, '1', 0, 1, 'IMGWSR20240326001710.png'),
(11, 1, 'leccion 2 del curso', '', '', 'https://player.vimeo.com/video/809604660?h=5bfbb7ddd6', 2, '', 0, 0, 'IMGWSR20240326035256.png'),
(12, 1, 'leccion 3 del curso', '', '', 'https://player.vimeo.com/video/809604660?h=5bfbb7ddd6', 4, '', 0, 1, 'IMGWSR20240326035306.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `imagen_profile` varchar(120) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telf` varchar(20) NOT NULL,
  `password` varchar(250) NOT NULL,
  `repeat_password` varchar(250) NOT NULL,
  `is_premium` int(11) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `sexo` int(11) NOT NULL,
  `fecha` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `imagen_profile`, `nombre`, `apellido`, `email`, `telf`, `password`, `repeat_password`, `is_premium`, `is_admin`, `sexo`, `fecha`) VALUES
(5, 'IMGWSR20240328224602.png', 'Efrael', 'Efrael', 'efrael2001@gmail.com', '123123123', '$2y$10$jEbHKwBCxS6Tgctnm6KVze0JzIsa0xQ67H0Dm3qIRY8WSpBcQWSHq', '$2y$10$VaL9s3jNZdh6lFjfEdT0B.zQkkaRf5TCuq7i6TSY91CSXoAB3yyPe', 1, 1, 0, '28 Mar 2024'),
(13, '', 'USUARIO ', 'DE PRUEBA', 'usuario@gmail.com', '', '$2y$10$pUh6QiJHagyA6KjTKXaPtu8preXMG0D2e9m9CiuJU2J9daoHq2Yd.', '$2y$10$/VHr.NdJPvG6qhrjt8EUn.IeYnoHFfukQPBG1CgxHhBZJ3TU0ph2S', 1, 0, 0, '17 Apr 2024');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `completed`
--
ALTER TABLE `completed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso_usuario` (`id_instructor`);

--
-- Indices de la tabla `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `ultima_leccion_vista_id` (`ultima_leccion_vista_id`);

--
-- Indices de la tabla `fav`
--
ALTER TABLE `fav`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `lecciones`
--
ALTER TABLE `lecciones`
  ADD PRIMARY KEY (`id_leccion`),
  ADD KEY `fk_leccion_curso` (`id_curso`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `completed`
--
ALTER TABLE `completed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `fav`
--
ALTER TABLE `fav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `lecciones`
--
ALTER TABLE `lecciones`
  MODIFY `id_leccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD CONSTRAINT `fk_user_anuncio` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `completed`
--
ALTER TABLE `completed`
  ADD CONSTRAINT `completed_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `completed_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `cursos` (`id`);

--
-- Filtros para la tabla `fav`
--
ALTER TABLE `fav`
  ADD CONSTRAINT `fav_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fav_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lecciones`
--
ALTER TABLE `lecciones`
  ADD CONSTRAINT `fk_leccion_curso` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
