-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-01-2025 a las 11:12:09
-- Versión del servidor: 10.6.18-MariaDB-0ubuntu0.22.04.1
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tarea1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `broker_performance`
--

CREATE TABLE `broker_performance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_volume` decimal(10,2) DEFAULT 0.00,
  `broker_volume` decimal(10,2) DEFAULT 0.00,
  `total_volume` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `broker_performance`
--

INSERT INTO `broker_performance` (`id`, `user_id`, `client_volume`, `broker_volume`, `total_volume`) VALUES
(1, 1, 100.00, 500.00, 600.00),
(2, 2, 200.00, 500.00, 700.00),
(3, 3, 50.00, 150.00, 200.00),
(4, 4, 5000.00, 2000.00, 7000.00),
(5, 5, 2000.00, 1000.00, 3000.00),
(6, 6, 7000.00, 4000.00, 11000.00),
(7, 7, 3000.00, 1500.00, 4500.00),
(8, 8, 1000.00, 500.00, 1500.00),
(9, 9, 4000.00, 2500.00, 6500.00),
(10, 10, 5000.00, 3500.00, 8500.00),
(11, 11, 1500.00, 800.00, 2300.00),
(12, 12, 2000.00, 1000.00, 3000.00),
(13, 13, 6000.00, 4000.00, 10000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `purchase_volume` decimal(10,2) DEFAULT 0.00,
  `client_volume` decimal(10,2) DEFAULT 0.00,
  `broker_volume` decimal(10,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `purchase_volume`, `client_volume`, `broker_volume`, `created_at`) VALUES
(1, 1, 500.00, 0.00, 500.00, '2024-12-31 09:41:32'),
(2, 2, 300.00, 100.00, 200.00, '2024-12-31 09:41:32'),
(3, 3, 200.00, 50.00, 150.00, '2024-12-31 09:41:32'),
(4, 4, 150.00, 0.00, 150.00, '2024-12-31 09:41:32'),
(5, 5, 350.00, 100.00, 250.00, '2024-12-31 09:41:32'),
(6, 1, 5000.00, 3000.00, 2000.00, '2024-12-31 10:58:04'),
(7, 2, 300.00, 200.00, 100.00, '2024-12-31 10:58:04'),
(8, 3, 1000.00, 800.00, 200.00, '2024-12-31 10:58:04'),
(9, 4, 1200.00, 1000.00, 200.00, '2024-12-31 10:58:04'),
(10, 5, 1500.00, 1200.00, 300.00, '2024-12-31 10:58:04'),
(11, 6, 2000.00, 1500.00, 500.00, '2024-12-31 10:58:04'),
(12, 7, 2500.00, 2000.00, 500.00, '2024-12-31 10:58:04'),
(13, 8, 1800.00, 1400.00, 400.00, '2024-12-31 10:58:04'),
(14, 9, 2200.00, 1600.00, 600.00, '2024-12-31 10:58:04'),
(15, 10, 2700.00, 2100.00, 600.00, '2024-12-31 10:58:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` enum('broker','user') NOT NULL,
  `registration_date` datetime DEFAULT current_timestamp(),
  `referer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `registration_date`, `referer_id`) VALUES
(1, 'Broker 1', 'broker1@example.com', 'broker', '2024-12-31 09:41:32', NULL),
(2, 'Broker 2', 'broker2@example.com', 'broker', '2024-12-31 09:41:32', NULL),
(3, 'Broker 3', 'broker3@example.com', 'broker', '2024-12-31 09:41:32', NULL),
(4, 'User 1', 'user1@example.com', 'user', '2024-12-31 09:41:32', 1),
(5, 'User 2', 'user2@example.com', 'user', '2024-12-31 09:41:32', 1),
(6, 'User 3', 'user3@example.com', 'user', '2024-12-31 09:41:32', 2),
(7, 'User 4', 'user4@example.com', 'user', '2024-12-31 09:41:32', 2),
(8, 'User 5', 'user5@example.com', 'user', '2024-12-31 09:41:32', 3),
(9, 'Juan Pérez', 'juan@example.com', 'broker', '2024-01-01 00:00:00', NULL),
(10, 'Carlos Sánchez', 'carlos@example.com', 'user', '2024-02-15 00:00:00', 1),
(11, 'Marta Gómez', 'marta@example.com', 'broker', '2024-03-10 00:00:00', 1),
(12, 'Ana Ruiz', 'ana@example.com', 'broker', '2024-04-20 00:00:00', 2),
(13, 'Luis López', 'luis@example.com', 'user', '2024-05-10 00:00:00', 4),
(14, 'Pedro Martínez', 'pedro@example.com', 'user', '2024-06-25 00:00:00', 4),
(15, 'Sofía Díaz', 'sofia@example.com', 'broker', '2024-07-30 00:00:00', 3),
(16, 'Ricardo Morales', 'ricardo@example.com', 'user', '2024-08-20 00:00:00', 7),
(17, 'Laura Hernández', 'laura@example.com', 'user', '2024-09-05 00:00:00', 7),
(18, 'David Fernández', 'david@example.com', 'broker', '2024-10-10 00:00:00', 13);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `broker_performance`
--
ALTER TABLE `broker_performance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `broker_id` (`user_id`);

--
-- Indices de la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `referer_id` (`referer_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `broker_performance`
--
ALTER TABLE `broker_performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `broker_performance`
--
ALTER TABLE `broker_performance`
  ADD CONSTRAINT `broker_performance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`referer_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
