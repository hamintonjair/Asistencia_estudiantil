-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 15-07-2024 a las 19:17:24
-- Versión del servidor: 10.5.20-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id21498356_db_asistencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `cedula` varchar(15) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `idMateria` int(11) NOT NULL,
  `semestre` varchar(10) NOT NULL,
  `idDocente` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `aprobado` varchar(10) NOT NULL,
  `idCurso` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `nombre`, `apellidos`, `cedula`, `telefono`, `direccion`, `correo`, `idMateria`, `semestre`, `idDocente`, `estado`, `aprobado`, `idCurso`, `fecha`) VALUES
(1, 'Leison ', 'Palacios', '3232123', '5434444444', 'Barrio centro de Quibdó', 'mafia00796@outlook.com', 1, '6', 6, 1, 'Si', 8, '2023-08-09 20:19:28'),
(2, 'Edward ', 'Gutierrez Mena', '32547325', '8723342245', 'barrio centro', 'mafia00796@hotmail.com', 1, '6', 6, 1, 'Si', 8, '2023-08-09 21:10:41'),
(3, 'Edward', 'Gutierrez', '32547325', '8723342245', 'barrio centro', 'mafia00796@hotmail.com', 1, '6', 7, 1, 'Si', 7, '2023-08-17 21:40:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignar_materias`
--

CREATE TABLE `asignar_materias` (
  `id` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL,
  `idDocente` int(11) NOT NULL,
  `semestre` varchar(15) NOT NULL,
  `estado` varchar(15) NOT NULL DEFAULT 'Asignado',
  `idCurso` int(11) NOT NULL,
  `idJefe` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignar_materias`
--

INSERT INTO `asignar_materias` (`id`, `idMateria`, `idDocente`, `semestre`, `estado`, `idCurso`, `idJefe`, `fecha`) VALUES
(1, 1, 6, '6', 'Asignado', 8, 2, '2023-08-09 19:35:00'),
(2, 1, 7, '6', 'Asignado', 7, 5, '2023-08-16 22:10:16'),
(3, 1, 6, '7', 'Asignado', 4, 2, '2023-11-08 22:15:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `idDocente` int(11) NOT NULL,
  `idAlumno` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL,
  `idCurso` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `asistencia` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `idDocente`, `idAlumno`, `idMateria`, `idCurso`, `semestre`, `fecha_registro`, `asistencia`) VALUES
(7, 6, 1, 1, 8, 6, '2023-08-19 15:17:18', 'ausente'),
(8, 6, 2, 1, 8, 6, '2023-08-19 15:17:18', 'ausente'),
(9, 6, 1, 1, 8, 6, '2023-08-19 15:25:57', 'registrada'),
(10, 6, 1, 1, 8, 6, '2023-08-20 14:38:45', 'ausente'),
(11, 6, 2, 1, 8, 6, '2023-08-20 14:38:45', 'ausente'),
(14, 6, 2, 1, 8, 6, '2023-09-03 20:22:36', 'registrada'),
(15, 6, 1, 1, 8, 6, '2023-09-03 20:24:41', 'ausente'),
(16, 6, 1, 1, 8, 6, '2023-11-08 17:26:21', 'ausente'),
(17, 6, 2, 1, 8, 6, '2023-11-08 17:26:21', 'ausente'),
(18, 6, 1, 1, 8, 6, '2023-11-21 14:21:09', 'ausente'),
(19, 6, 2, 1, 8, 6, '2023-11-21 14:21:09', 'ausente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordenada`
--

CREATE TABLE `coordenada` (
  `id` int(11) NOT NULL,
  `latitud` varchar(50) NOT NULL,
  `longitud` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coordenada`
--

INSERT INTO `coordenada` (`id`, `latitud`, `longitud`) VALUES
(1, '5.6857998', '-76.656115');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `curso` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `curso`, `estado`) VALUES
(1, 'Finanzas', 1),
(2, 'Contabilidad', 1),
(4, 'redes', 1),
(5, 'Matemática discreta', 1),
(6, 'Métodos numéricos', 1),
(7, 'Base de datos', 1),
(8, 'Ingeniería de software I', 1),
(9, 'Ingeniería de software II', 1),
(10, 'Algoritmo', 1),
(11, 'Estructura de datos', 1),
(12, 'Modelo I', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `cedula` varchar(15) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `idMateria` int(11) DEFAULT NULL,
  `idJefe` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `nombre`, `apellidos`, `cedula`, `telefono`, `direccion`, `correo`, `idMateria`, `idJefe`, `estado`, `fecha`) VALUES
(1, 'Haminton ', 'Mena', '80772379', '3124943527', 'Barrio obapo', 'prueba@gmail.com', NULL, NULL, 1, '2023-08-09 16:14:42'),
(2, 'Jilmar', 'Gonzalez', '768578', '5555555555', 'barrio centro', 'jilmar@gmail.com', 1, NULL, 1, '2023-08-09 16:18:50'),
(3, 'Digna LUz ', 'Córdoba Mena', '34235635', '3333333333', 'barrio centro', 'diluzmecor26@hotmail.com', 5, NULL, 1, '2023-08-09 16:20:23'),
(4, 'Yoyler', 'Mosquera', '532673402', '4444444444', 'barrio centro', 'yoiler@gmail.com', 7, NULL, 1, '2023-08-09 16:25:08'),
(5, 'Lesmar edu', 'Copete', '221035324', '6666666666', 'barrio centro', 'lesmar@gmail.com', 8, NULL, 1, '2023-08-09 16:25:55'),
(6, 'Daniel', 'Vivas', '34245643', '3322222222', 'barrio centro', 'daniel@gmail.com', NULL, 2, 1, '2023-08-09 19:19:27'),
(7, 'Johan Ernesto', 'Mena', '278432', '3124943527', 'Calle 46 Barrio Buenos Aires', 'johan@gmail.com', NULL, 5, 1, '2023-08-16 16:46:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilitar`
--

CREATE TABLE `habilitar` (
  `id` int(11) NOT NULL,
  `idDocente` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `idPrograma` int(11) NOT NULL,
  `idCurso` int(11) NOT NULL,
  `estado` varchar(15) NOT NULL DEFAULT 'habilitado',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habilitar`
--

INSERT INTO `habilitar` (`id`, `idDocente`, `semestre`, `idPrograma`, `idCurso`, `estado`, `fecha`) VALUES
(1, 6, 6, 1, 8, 'deshabilitado', '2023-08-09 20:35:12'),
(2, 6, 6, 1, 8, 'deshabilitado', '2023-08-09 21:08:35'),
(3, 6, 6, 1, 8, 'deshabilitado', '2023-08-09 21:52:19'),
(4, 6, 6, 1, 8, 'deshabilitado', '2023-08-10 23:04:19'),
(5, 6, 6, 1, 8, 'deshabilitado', '2023-08-12 21:14:24'),
(6, 6, 6, 1, 8, 'deshabilitado', '2023-08-16 14:10:27'),
(7, 6, 6, 1, 8, 'deshabilitado', '2023-08-16 14:12:15'),
(8, 6, 6, 1, 8, 'deshabilitado', '2023-08-16 14:15:26'),
(9, 6, 6, 1, 8, 'deshabilitado', '2023-08-16 14:36:47'),
(10, 6, 6, 1, 8, 'deshabilitado', '2023-08-16 14:44:03'),
(11, 6, 6, 1, 8, 'deshabilitado', '2023-08-16 14:45:40'),
(12, 6, 6, 1, 8, 'deshabilitado', '2023-08-16 14:46:43'),
(13, 6, 6, 1, 8, 'deshabilitado', '2023-08-16 14:47:50'),
(14, 6, 6, 1, 8, 'deshabilitado', '2023-08-16 14:48:35'),
(15, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 14:25:28'),
(16, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 14:25:55'),
(17, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 14:27:25'),
(18, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 14:39:08'),
(19, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 14:58:30'),
(20, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:03:40'),
(21, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:04:11'),
(22, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:04:50'),
(23, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:07:14'),
(24, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:09:35'),
(25, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:11:02'),
(26, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:11:40'),
(27, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:13:17'),
(28, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:15:07'),
(29, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:19:25'),
(30, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:30:06'),
(31, 6, 6, 1, 8, 'deshabilitado', '2023-08-17 15:31:30'),
(32, 7, 6, 1, 7, 'deshabilitado', '2023-08-17 23:17:07'),
(33, 7, 6, 1, 7, 'deshabilitado', '2023-08-17 23:17:38'),
(34, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 13:11:13'),
(35, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 13:14:24'),
(36, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 13:16:19'),
(37, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 21:53:54'),
(38, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 21:55:30'),
(39, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 23:04:45'),
(40, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 23:08:34'),
(41, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 23:11:21'),
(42, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 23:12:39'),
(43, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 23:44:58'),
(44, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 23:45:52'),
(45, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 23:50:17'),
(46, 6, 6, 1, 8, 'deshabilitado', '2023-08-18 23:51:09'),
(47, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:11:00'),
(48, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:11:32'),
(49, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:12:32'),
(50, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:13:13'),
(51, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:14:07'),
(52, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:16:10'),
(53, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:18:01'),
(54, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:24:24'),
(55, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:27:34'),
(56, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:28:46'),
(57, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:30:13'),
(58, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 00:31:09'),
(59, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 13:33:27'),
(60, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 13:34:11'),
(61, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 13:35:31'),
(62, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 13:52:41'),
(63, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 13:53:59'),
(64, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 13:56:19'),
(65, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 13:59:30'),
(66, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:03:19'),
(67, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:07:50'),
(68, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:10:12'),
(69, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:10:53'),
(70, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:12:11'),
(71, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:15:23'),
(72, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:16:03'),
(73, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:16:52'),
(74, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:20:42'),
(75, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:22:18'),
(76, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:32:34'),
(77, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:35:49'),
(78, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 14:36:31'),
(79, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 15:17:18'),
(80, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 15:20:30'),
(81, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 15:20:53'),
(82, 6, 6, 1, 8, 'deshabilitado', '2023-08-19 15:30:59'),
(83, 6, 6, 1, 8, 'deshabilitado', '2023-08-20 14:38:45'),
(84, 6, 6, 1, 8, 'deshabilitado', '2023-08-20 14:45:31'),
(85, 6, 6, 1, 8, 'deshabilitado', '2023-09-03 18:11:14'),
(86, 6, 6, 1, 8, 'deshabilitado', '2023-09-03 20:24:41'),
(87, 6, 6, 1, 8, 'deshabilitado', '2023-11-08 22:26:21'),
(88, 6, 6, 1, 8, 'deshabilitado', '2023-11-21 19:21:09'),
(89, 6, 7, 1, 4, 'deshabilitado', '2023-12-04 23:06:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `materia` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `materia`, `estado`) VALUES
(1, 'Igeniería de sistemas', 1),
(5, 'Trabajo social', 1),
(6, 'Psicología', 1),
(7, 'Ingeniería civil', 1),
(8, 'ingenieria ambiental', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `idDocente` int(11) DEFAULT NULL,
  `titulo` varchar(50) NOT NULL,
  `contenido` varchar(500) NOT NULL,
  `color` varchar(15) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `idCurso` int(11) DEFAULT NULL,
  `docente` varchar(10) DEFAULT NULL,
  `idAlumno` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id`, `idDocente`, `titulo`, `contenido`, `color`, `tipo`, `idCurso`, `docente`, `idAlumno`, `fecha`) VALUES
(4, NULL, 'leison', 'es mi nota personal', 'maroon', 'personal', 8, NULL, 1, '2023-08-09 21:03:48'),
(16, 1, 'presentación', 'el dia de mañana', 'silver', 'personal', 8, NULL, NULL, '2023-08-10 23:07:30'),
(39, 2, 'para el docente', 'hola: por Jilmar Gonzalez', 'purple', 'publica', NULL, 'Docente', NULL, '2023-08-11 15:12:03'),
(44, NULL, 'para todos', 'hola: por el Estudiante: Edward Gutierrez', 'silver', 'publica', 8, NULL, 2, '2023-08-11 15:17:20'),
(46, 6, 'para el jefe', 'hola: por el Docente Daniel Vivas', 'gold', 'publica', NULL, 'Jefe', NULL, '2023-08-11 15:19:39'),
(47, NULL, 'para mi edward', 'hola', 'gold', 'personal', 8, NULL, 2, '2023-08-11 15:21:31'),
(53, 1, 'me gusta algo', 'ser el administrador', 'blue', 'personal', NULL, NULL, NULL, '2023-08-12 20:42:53'),
(54, 1, 'para el jefe', 'hola: por el Admin Haminton Mena', 'salmon', 'jefe', NULL, 'Jefe_', NULL, '2023-08-12 20:45:46'),
(55, 2, 'para el administrador', 'hola: por el Jefe Jilmar Gonzalez', 'red', 'admin', NULL, 'Admin', NULL, '2023-08-12 20:46:28'),
(57, 6, 'para los estudiantes', 'hola: por el Docente Daniel Vivas', 'green', 'publica', 8, NULL, NULL, '2023-08-12 20:56:08'),
(59, 1, 'para los jefes', 'hola: por el Admin Haminton Mena', 'olive', 'jefe', NULL, 'Jefe_', NULL, '2023-08-20 14:27:41'),
(60, NULL, 'prueba', 'no es tu nota', 'green', 'personal', 8, NULL, 2, '2023-09-03 17:34:17'),
(61, NULL, 'prueba2', 'holaaa: por el Estudiante Edward ', 'yellow', 'publica', 8, NULL, 2, '2023-09-03 17:46:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(200) NOT NULL,
  `rol` varchar(15) NOT NULL,
  `idDocente` int(11) DEFAULT NULL,
  `idAlumno` int(11) DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `clave`, `rol`, `idDocente`, `idAlumno`, `token`) VALUES
(1, 'Haminton Mena', 'prueba@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Admin', 1, NULL, ''),
(2, 'Jilmar', 'jilmar@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Jefe', 2, NULL, NULL),
(3, 'Digna LUz  Córdoba Mena', 'diluzmecor26@hotmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Jefe', 3, NULL, '5bd3298d1f514d066cfa-3f3d909abd3c01a0c662-3feb22afcbbf9b3b6a15-f84877c1d23fe79e1e20'),
(4, 'Yoyler Mosquera', 'yoiler@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Jefe', 4, NULL, NULL),
(5, 'Lesmar edu Copete', 'lesmar@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Jefe', 5, NULL, NULL),
(6, 'Daniel', 'daniel@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Docente', 6, NULL, NULL),
(7, 'Leison ', 'mafia00796@outlook.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Estudiante', NULL, 1, NULL),
(8, 'Edward ', 'mafia00796@hotmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Estudiante', NULL, 2, ''),
(9, 'Johan Ernesto Mena', 'johan@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Docente', 7, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumnos_ibfk_1` (`idDocente`),
  ADD KEY `alumnos_ibfk_2` (`idMateria`),
  ADD KEY `alumnos_ibfk_3` (`idCurso`);

--
-- Indices de la tabla `asignar_materias`
--
ALTER TABLE `asignar_materias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asignar_materias_ibfk_1` (`idDocente`),
  ADD KEY `asignar_materias_ibfk_2` (`idMateria`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asistencias_ibfk_1` (`idAlumno`),
  ADD KEY `asistencias_ibfk_2` (`idMateria`),
  ADD KEY `asistencias_ibfk_3` (`idDocente`);

--
-- Indices de la tabla `coordenada`
--
ALTER TABLE `coordenada`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habilitar`
--
ALTER TABLE `habilitar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habilitar_ibfk_1` (`idDocente`),
  ADD KEY `habilitar_ibfk_2` (`idCurso`),
  ADD KEY `habilitar_ibfk_3` (`idPrograma`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `asignar_materias`
--
ALTER TABLE `asignar_materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `coordenada`
--
ALTER TABLE `coordenada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `habilitar`
--
ALTER TABLE `habilitar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`idDocente`) REFERENCES `docentes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `alumnos_ibfk_2` FOREIGN KEY (`idMateria`) REFERENCES `materias` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `alumnos_ibfk_3` FOREIGN KEY (`idCurso`) REFERENCES `cursos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignar_materias`
--
ALTER TABLE `asignar_materias`
  ADD CONSTRAINT `asignar_materias_ibfk_1` FOREIGN KEY (`idDocente`) REFERENCES `docentes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `asignar_materias_ibfk_2` FOREIGN KEY (`idMateria`) REFERENCES `materias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`idAlumno`) REFERENCES `alumnos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `asistencias_ibfk_2` FOREIGN KEY (`idMateria`) REFERENCES `materias` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `asistencias_ibfk_3` FOREIGN KEY (`idDocente`) REFERENCES `docentes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `habilitar`
--
ALTER TABLE `habilitar`
  ADD CONSTRAINT `habilitar_ibfk_1` FOREIGN KEY (`idDocente`) REFERENCES `docentes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `habilitar_ibfk_2` FOREIGN KEY (`idCurso`) REFERENCES `cursos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `habilitar_ibfk_3` FOREIGN KEY (`idPrograma`) REFERENCES `materias` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
