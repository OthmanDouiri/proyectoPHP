-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2025 a las 15:12:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `auth_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id`, `nombre`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'Xiaomi'),
(4, 'Google');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phone`
--

CREATE TABLE `phone` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `phone`
--

INSERT INTO `phone` (`id`, `name`, `price`, `marca_id`, `image_url`) VALUES
(390, 'Apple iPhone 13 128GB - Verdes', '679€', 1, 'https://m.media-amazon.com/images/I/61LLhELDAbL._AC_UL320_.jpg'),
(391, 'Apple iPhone 13 128GB - Azul (Reacondicionado)', '379€', 1, 'https://m.media-amazon.com/images/I/71b+DwdvTrL._AC_UL320_.jpg'),
(393, 'Apple iPhone 13, 128GB, Rosa - (Reacondicionado) test', '379€', 1, 'https://m.media-amazon.com/images/I/61CGRxr55fL._AC_UL320_.jpg'),
(395, 'Xiaomi C51 Telefonos Moviles Libres - 18GB RAM + 128GB ROM/SD 1TB, 6.8\" Pantalla HD+ 90Hz Telefono Movil, Batería 5150mAh, Cámara 13MP Android 13 Smartphone, 4G Dual SIM, Face ID/Fingerprint, Azul', '126€', 3, 'https://m.media-amazon.com/images/I/91VxM0e9zVL._AC_UL320_.jpg'),
(396, 'Xiaomi Smartphone,Moviles Android 14,6.75\" Pantalla HD+90Hz Teléfono Móvil Libres,8GB+128GB/1TB, Batería 5000mAh 13MP+8MP,Telefonos Moviles Dual Sim,Face ID/Fingerprint/OTG/GPS,2.4G/5G WIFI Verde', '124€', 3, 'https://m.media-amazon.com/images/I/6142buHFecL._AC_UL320_.jpg'),
(397, 'Google Pixel 8a - Smartphone Android Libre con Cámara Pixel Avanzada, batería de 24 Horas de duración y potentes Funciones de Seguridad - Celeste, 128GB', '399€', 4, 'https://m.media-amazon.com/images/I/71Kb1+U1zwL._AC_UL320_.jpg'),
(398, 'Apple iPhone 15 (128 GB) - Azul', '789€', 1, 'https://m.media-amazon.com/images/I/71vKy5OHuPL._AC_UL320_.jpg'),
(399, 'Apple iPhone 16 de 128 GB: Smartphone 5G con Control de Cámara, Chip A18 y un subidón en autonomía. Compatible con los AirPods; Negro', '887€', 1, 'https://m.media-amazon.com/images/I/619HAuZ95QL._AC_UL320_.jpg'),
(400, 'Apple iPhone 13 (128 GB) - en Blanco Estrella', '529€', 1, 'https://m.media-amazon.com/images/I/61HNv77Xe4L._AC_UL320_.jpg'),
(401, 'Apple iPhone 15 128 GB - Negro (Reacondicionado)', '679€', 1, 'https://m.media-amazon.com/images/I/61eEYLATF9L._AC_UL320_.jpg'),
(415, 'Xiaomi 14T', '500$', 3, 'https://m.media-amazon.com/images/I/51TrHRBPCKL._AC_SX522_.jpg'),
(416, 'Samsung SM-A057 Galaxy A05s Dual SIM 4GB RAM 128GB Silver EU', '138€', 2, 'https://m.media-amazon.com/images/I/51Ft1ATlvjL._AC_SL1200_.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `token`, `created_at`, `role`) VALUES
(1, 'rusben', 'rusben@elpuig.xeill.net', '$2y$10$aDrd9uFrnJgyDBwoTtUqZOl0v/t8jWNP4D2.nzauiwDldKUAPAZxe', '', '2024-10-29 15:48:50', 'user'),
(2, 'othman', 'enamhto@sdf.com', '$2y$10$vGCMNeV6qJNqiz1ojf2UeO4P2TSAAQmB03D0jPLd8jKCxNBruxyPO', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJwcm95ZWN0b3BocC5sb2NhbCIsImlhdCI6MTc0MjE1NDM2MiwiZXhwIjoxNzQyNzU5MTYyLCJ1c2VySWQiOjIsInVzZXJuYW1lIjoib3RobWFuIiwicm9sZSI6InVzZXIifQ.F6QnxCy3r-jc9i8sWhc8gIQS1uA0p9gP-TSHRy8Ngdk', '2024-11-01 15:56:34', 'user'),
(3, 'oth', 'jksnfjskdf@gmail.com', '$2y$10$DYsbMrVjrHxGpWSMFi4Na.aFs6l9DV12rgHn0MB9XJuszCVjdP2Z.', '', '2024-11-01 16:01:36', 'user'),
(4, 'ruben', 'othman@gmail.com', '$2y$10$lZIjAHhXXLBFOx48dLKaeOHsK9GY9lYW9I7We2wstHJebZYrOCTiG', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJwcm95ZWN0b3BocC5sb2NhbCIsImlhdCI6MTczODA4NTY2NiwiZXhwIjoxNzM4NjkwNDY2LCJ1c2VySWQiOjQsInVzZXJuYW1lIjoicnViZW4iLCJyb2xlIjoidXNlciJ9.PBN9rIFGjtq0TlCb6eOJTqXoM1l1uSSifTrMI2GbKEg', '2024-11-01 23:00:37', 'user'),
(6, 'admin', 'admin@gmail.com', '$2y$10$/hx5wiUEpj64xgmjhdhHyO6q/H8uj5phm9X1R9fG3/02Y2XDKaG7q', '', '2024-11-11 16:01:00', 'user'),
(7, 'ahmed', 'ahmed@gmail.com', '$2y$10$k1ORZqgOeKXGmFDaDSxMF.FH1kBghCzv578Wp7Fv47Pt0r4YnTGDm', '4ef4a7a0abfaa255b69bc948da5d5b95', '2024-11-12 21:26:00', 'user'),
(8, 'teest', 'teest@gmail.com', '$2y$10$XmwA/PNglLQUSMeFUFyerekwLeZBf0/oqKKv.sFBHk8pQVTq5RnT.', 'bc53e98e3e1344eac419c054630374d1', '2024-11-24 16:46:06', 'user'),
(9, 'test', 'tes@gmail.com', '$2y$10$u..nX3LJPQHqYVshNPAZKel35fjezQ7Nwup5O9SpxLClTftEjAlyS', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJwcm95ZWN0b3BocC5sb2NhbCIsImlhdCI6MTc0MjA5Njk5MiwiZXhwIjoxNzQyNzAxNzkyLCJ1c2VySWQiOjksInVzZXJuYW1lIjoidGVzdCIsInJvbGUiOiJ1c2VyIn0.zmH4wfyA8_bpOCfd_EL2BHZSBLMASlj9W8T3317EzlY', '2024-12-09 14:57:53', 'user'),
(10, 'othman2', 'othman2@gmail.com', '$2y$10$1nh4nB8quzrfy3zwIOQFJ.4fIfjYxgp0nn0oS/dzEkoBDevmLDjnS', '9606408a11ef58d5bfc2ed70d3534d60', '2025-01-09 15:55:48', 'user'),
(11, 'testachraf', 'testachraf@gmail.com', '$2y$10$h.nj9bZbbiembebdBCp9e.GNyJoGotnJ304hJyqxMxAMAFB6yvEBW', '', '2025-01-16 15:17:00', 'user'),
(12, 'ok', 'ok@gmail.com', '$2y$10$oitVBB1LXiWQu2rHuiWF3uD9IeZBtYVyOL3VoV16shStIMnNDIWb2', '', '2025-01-18 00:06:55', 'user'),
(13, 'test12', 'test1212@gmail.com', '$2y$10$/SKRodh/J7H3b.d7cnBTgOvfEnejCMbW3dv2NlQx2VL3waS83Vz5.', '', '2025-01-18 00:08:37', 'user'),
(14, 'levi', 'levi@gmail.com', '$2y$10$kGII3keWADJoVlGiye0qReJPmw9UfS.R6Bb6cP/4IbI7V.wuBdzDe', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhdXRoLmxvY2FsIiwiaWF0IjoxNzM3NDgxNjAwLCJleHAiOjE3MzgwODY0MDAsInVzZXJJZCI6MTQsInVzZXJuYW1lIjoibGV2aSIsInJvbGUiOiJ1c2VyIn0.SDukPLFZW3x-UHBw0TmWAcSBbZot2Zf72DK6Do5nHsU', '2025-01-21 17:46:17', 'user'),
(33, 'sergio1', 'sergio@gmail.com', '$2y$10$1GkcvWcqTSHPlJB3XOBbAu6avBqM8rEqGDu4AgsvFBhWEXVqVzBqa', '', '2025-01-27 14:56:58', 'user'),
(35, 'asdas', 'dasdasd@gmail.com', '$2y$10$9quYGguBBj6ePFn6zIft/uO4tb.VY8xRfaW6odP9hAcbLbBytoRe.', '', '2025-01-27 15:03:06', 'user'),
(40, 'odouiriss', 'odouiriss@gmail.com', '$2y$10$csNM3KDDx0x4RTxUn4JlhOtjGbJyuezJZtf6SRC0nlCQiGjWJT43.', '', '2025-01-27 15:09:47', 'user'),
(41, 'leviaa', 'leviaa@gmail.com', '$2y$10$pe6VkCj1Vt8wgXI8x1EMe.cIunPB3T86S4ZRuSSG4bwMzwLFCp14y', '', '2025-01-27 15:14:34', 'user'),
(43, 'othman', 'othman.douiri1@gasdasdasdmail.com', '$2y$10$a3jqTfWNC/92cVUUj1HGluINVzYIgSk2SKsrwSPrZyBBLcOgAmUVy', '', '2025-01-27 15:18:26', 'user'),
(44, 'othman', 'othman.douiri1@gmail.com', '$2y$10$Y0clyq2T02TRzDn7ouQK.Oh73s/NTJbbLoSPNDKhd1OtjbTrn/i/W', '', '2025-01-27 15:20:44', 'user'),
(45, 'othman', 'othman.douiri1@gmassil.com', '$2y$10$4QtBt5zfnaLWYaLGXRV5ae9ZSpvDySt1UIbL5d1eBswju36QI0z0y', '', '2025-01-27 15:21:54', 'user'),
(46, 'othman', 'othman.douiri1@gsmail.com', '$2y$10$NOhdTIAzGR2j.LOtyC2Iz.cxYv81rBek/VpagoD7891X8sSTzEI9i', '', '2025-01-27 15:28:47', 'user'),
(47, 'othman', 'othman.douiri1@gssssssssmail.com', '$2y$10$Rbr38usS93luoxdcQ/mehetFurHVC.jvsP.mM6v4u.ZOkkUoHVajW', '', '2025-01-27 15:30:15', 'user'),
(48, 'othman', 'othman.douiri1@gafasfadmail.com', '$2y$10$6iNycyrClnGHcoPKMLmGM.4CQYqcWUY9oDr/2tEiBLxqjBWehcoDO', '', '2025-01-27 15:31:07', 'user'),
(49, 'mouad', 'mouad@gmail.com', '$2y$10$MYwhDnQBBrcBXUKDy1MCnuCy9Nhf5bhCHVwGFnAJTerUAfMujvK3i', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJwcm95ZWN0b3BocC5sb2NhbCIsImlhdCI6MTc0MTgwNDA4NSwiZXhwIjoxNzQyNDA4ODg1LCJ1c2VySWQiOjQ5LCJ1c2VybmFtZSI6Im1vdWFkIiwicm9sZSI6InVzZXIifQ.sOcV5HuVUIrKki_ER0kYy3QS0FkT4pvuqGMxBD2wCJ0', '2025-03-12 17:39:04', 'user'),
(50, 'test', 'test@sdjfsjdf.com', '$2y$10$hwalxfrpRzw/r5NhBNvH1.h.AnfFHwgA9f7iRJnkhOKBgadjrOPX6', '', '2025-03-16 03:49:35', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_phone_marca` (`marca_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `phone`
--
ALTER TABLE `phone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=440;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `phone`
--
ALTER TABLE `phone`
  ADD CONSTRAINT `fk_phone_marca` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
