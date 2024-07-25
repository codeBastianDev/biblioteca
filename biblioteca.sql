

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `actividad` varchar(255) NOT NULL,
  `fecha_actividad` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `editorial` varchar(100) DEFAULT NULL,
  `anio_publicacion` year(4) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `imagen` text NOT NULL,
  `disponibilidad` tinyint(1) DEFAULT 1,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




INSERT INTO `books` (`titulo`, `autor`, `isbn`, `editorial`, `anio_publicacion`, `categoria_id`, `imagen`, `disponibilidad`, `descripcion`) VALUES
('Don Quijote de la Mancha', 'Miguel de Cervantes', '', 'Editorial Espasa', 1605, 1, 'https://th.bing.com/th/id/OIP.p2Qht0iMCaSgQb3wbzHukAHaKN?rs=1&pid=ImgDetMain', 1, 'Una novela clásica de la literatura española.'),
('Cien Años de Soledad', 'Gabriel García Márquez', '', 'Editorial Sudamericana', 1967, 2, 'https://www.mejoreslibros.top/wp-content/uploads/2020/09/Cien-anos-de-Soledad-50-Aniversario-1141x1536.jpg', 1, 'Una novela mágica que explora la historia de la familia Buendía.'),
('El Hobbit', 'J.R.R. Tolkien', '', 'Editorial Minotauro', 1937, 4, 'https://th.bing.com/th/id/OIP.nksa75xXr0kYFDhmsdIZsQHaKu?rs=1&pid=ImgDetMain', 1, 'La historia de Bilbo Baggins en la Tierra Media.'),
('1984', 'George Orwell', '', 'Editorial Secker & Warburg', 1949, 3, 'https://mir-s3-cdn-cf.behance.net/project_modules/1400/b468d093312907.5e6139cf2ab03.png', 1, 'Una distopía sobre un futuro totalitario.'),
('Orgullo y Prejuicio', 'Jane Austen', '', 'Editorial Penguin Classics', 1813, 5, 'https://imagessl2.casadellibro.com/a/l/t0/82/9788415618782.jpg', 1, 'Una novela romántica sobre el amor y el matrimonio en el siglo XIX.'),
('El Código Da Vinci', 'Dan Brown', '', 'Editorial Doubleday', 2003, 6, 'https://th.bing.com/th/id/OIP.lF99qWmC1DvWcfEzCW5uCQHaLR?rs=1&pid=ImgDetMain', 1, 'Un thriller que mezcla religión, arte y misterio.'),
('Los Pilares de la Tierra', 'Ken Follett', '', 'Editorial Penguin', 1989, 7, 'https://th.bing.com/th/id/R.e91a607db73bd01de440109bedf9b097?rik=w44AVk6PaxbfOA&pid=ImgRaw&r=0', 1, 'Una novela histórica sobre la construcción de una catedral en la Edad Media.'),
('El Nombre del Viento', 'Patrick Rothfuss', '', 'Editorial Daw Books', 2007, 4, 'https://www.isliada.org/static/images/2018/07/el-nombre-del-viento.jpg', 1, 'La historia de Kvothe, un joven con habilidades excepcionales.'),
('El Silencio de los Corderos', 'Thomas Harris', '', 'Editorial St. Martin’s Press', 1988, 6, 'https://www.isliada.org/static/images/2022/08/El-silencio-de-los-corderos.jpg', 1, 'Un thriller psicológico con el infame Hannibal Lecter.'),
('Sapiens: De Animales a Dioses', 'Yuval Noah Harari', '', 'Editorial Harper', 2011, 10, 'https://th.bing.com/th/id/OIP.wqcwLECVWVGsIi9O909vowHaLP?rs=1&pid=ImgDetMain', 1, 'Una exploración de la historia de la humanidad desde el inicio hasta el presente.');
























--
-- Volcado de datos para la tabla `books`
--

INSERT INTO `books` (`id`, `titulo`, `autor`, `isbn`, `editorial`, `anio_publicacion`, `categoria_id`, `imagen`, `disponibilidad`, `descripcion`) VALUES
(1, 'Don quijote', 'Un autor', '', 'marino ', '2004', 1, 
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `nombre`) VALUES
(1, 'Accion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `libro_id` int(11) DEFAULT NULL,
  `fecha_prestamo` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_devolucion` date DEFAULT NULL,
  `devuelto` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tipo` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `libro_id` int(11) DEFAULT NULL,
  `fecha_reserva` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_expiracion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellido`, `email`, `contrasena`, `telefono`, `direccion`, `fecha_registro`) VALUES
(1, 'juan', 'perez', 'juan@gmail.com', '1234', NULL, NULL, '2024-07-20 00:48:51');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `loans`
--
ALTER TABLE `loans`	
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
