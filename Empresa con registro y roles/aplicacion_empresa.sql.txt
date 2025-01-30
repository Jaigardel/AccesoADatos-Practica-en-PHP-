-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-02-2023 a las 18:11:47
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
-- Base de datos: `dwes_tarde_empresa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `presupuesto` int(11) NOT NULL,
  `sede_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre`, `presupuesto`, `sede_id`) VALUES
(1, 'Financiero', 555, 1),
(2, 'Recursos Humanos', 1200000, 1),
(3, 'Marketing', 625000, 2),
(4, 'Comercial', 450000, 3),
(5, 'Compras', 2350000, 2),
(6, 'Logística y Operaciones', 890000, 3),
(7, 'Control de Gestión', 350000, 1),
(8, 'Calidad', 140000, 2),
(14, 'Comercial-Ventas', 55000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(120) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `salario` float NOT NULL,
  `hijos` int(11) NOT NULL,
  `departamento_id` int(11) NOT NULL,
  `pais_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `email`, `apellidos`, `salario`, `hijos`, `departamento_id`, `pais_id`) VALUES
(1, 'Miguel Ángel', 'maperezes@email.com', 'Pérez Estrada', 25000, 4, 1, 45),
(2, 'Pilar', 'pperezdi@email.com', 'Pérez Díaz', 26000, 1, 1, 45),
(3, 'Silvia', 'sestevezpe@email.com', 'Estévez Pérez', 27000, 0, 1, 45),
(4, 'Teresa', 'tserranoso@email.com', 'Serrano Sosa', 28000, 2, 1, 45),
(5, 'María Ángeles', 'madiazfe@email.com', 'Diez Fernández', 29000, 1, 2, 45),
(6, 'Pablo', 'ptorreses@email.com', 'Torres Espinar', 30000, 1, 2, 45),
(7, 'Manuel', 'msolerame@email.com', 'Solera Mena', 31000, 3, 2, 45),
(8, 'Joaquín', 'jantonvi@email.com', 'Antón Villanueva', 32000, 2, 2, 45),
(9, 'Alberto', 'acarpinterolo@email.com', 'Carpintero López', 18500, 2, 3, 45),
(10, 'Juan', 'jsantiagopi@email.com', 'Santiago Pintos', 19250, 2, 3, 45),
(11, 'Juan José', 'jjfernandezmo@email.com', 'Fernández Moreno', 20000, 3, 3, 45),
(12, 'Pilar', 'pgodoyse@email.com', 'Godoy Serra', 20750, 4, 3, 45),
(13, 'Francisca', 'fgarciava@email.com', 'García Valladares', 21500, 3, 3, 45),
(14, 'María Magdalena', 'mmcastroma@email.com', 'Castro Marín', 22250, 2, 4, 45),
(15, 'Manuel', 'mfernandezfe@email.com', 'Fernández Fernández', 23000, 0, 4, 45),
(16, 'Luis', 'lbarceloga@email.com', 'Barceló García', 23750, 3, 4, 45),
(17, 'Jesús', 'jlopezma@email.com', 'López Matías', 24500, 4, 4, 45),
(18, 'Laura', 'lnavarrofe@email.com', 'Navarro Fernández', 28500, 1, 4, 45),
(19, 'Sara', 'sportillogo@email.com', 'Portillo González', 29500, 1, 4, 45),
(20, 'Juan Manuel', 'jmgallegoor@email.com', 'Gallego Ortiz', 30500, 3, 4, 45),
(21, 'María Ángeles', 'masanchezto@email.com', 'Sánchez Torrejón', 31500, 4, 4, 45),
(22, 'Daniel', 'dhidalgopo@email.com', 'Hidalgo Porras', 32500, 0, 4, 45),
(23, 'María Pilar', 'mpruizro@email.com', 'Ruiz Rodríguez', 33500, 4, 4, 45),
(24, 'Antonio', 'apuigot@email.com', 'Puig Otero', 34500, 4, 4, 45),
(25, 'Manuel', 'msotogo@email.com', 'Soto González', 35500, 1, 4, 45),
(26, 'Rosario', 'rperezlo@email.com', 'Pérez López', 36500, 2, 4, 45),
(27, 'Irene', 'igarciala@email.com', 'García Lastra', 37500, 2, 4, 45),
(28, 'Alicia', 'amarquezma@email.com', 'Márquez Maldonado', 38500, 2, 4, 45),
(29, 'Eduardo', 'egomezal@email.com', 'Gómez Alba', 39500, 3, 4, 45),
(30, 'Eduardo', 'epascualga@email.com', 'Pascual García', 40500, 3, 4, 106),
(31, 'Jorge', 'javilabi@email.com', 'Ávila Bilbao', 41500, 2, 5, 7),
(32, 'José Antonio', 'jaantolinga@email.com', 'Antolín García', 19000, 0, 5, 45),
(33, 'Jorge', 'jmartinsa@email.com', 'Martin Sáez', 20000, 3, 5, 119),
(34, 'Carmen', 'cmaganre@email.com', 'Magán Rey', 21000, 3, 5, 45),
(35, 'Vicente', 'vrodriguezan@email.com', 'Rodríguez Andrés', 22000, 1, 5, 45),
(36, 'Mercedes', 'mzapataro@email.com', 'Zapata Roca', 23000, 1, 5, 45),
(37, 'Enrique', 'edelgadopi@email.com', 'Delgado Pimentel', 24000, 3, 5, 45),
(38, 'Juan', 'jpereafe@email.com', 'Perea Fernández', 25000, 2, 5, 45),
(39, 'José', 'jmorenogu@email.com', 'Moreno Guerrero', 26000, 2, 5, 45),
(40, 'Marc', 'mfuentesve@email.com', 'Fuentes Verdú', 27000, 0, 5, 45),
(41, 'Mireia', 'mramosul@email.com', 'Ramos Ulloa', 28000, 0, 5, 45),
(42, 'Sergio', 'sperezes@email.com', 'Pérez Estévez', 29000, 0, 5, 45),
(43, 'Óscar', 'oreydi@email.com', 'Rey Díaz', 30000, 2, 5, 45),
(44, 'Rafael', 'rgaleanoca@email.com', 'Galeano Camarena', 31000, 3, 5, 45),
(45, 'Fuensanta', 'fgarridogo@email.com', 'Garrido González', 25700, 1, 5, 45),
(46, 'María', 'mgarciaga@email.com', 'García García', 26500, 1, 5, 45),
(47, 'Manuel', 'mfrancoto@email.com', 'Franco Torres', 27300, 2, 6, 45),
(48, 'José', 'jcorralesme@email.com', 'Corrales Mesa', 28100, 4, 6, 45),
(49, 'Carmen', 'cmartinsza@email.com', 'Martins Zabala', 28900, 4, 6, 18),
(50, 'Javier', 'jsosani@email.com', 'Sosa Nieto', 29700, 4, 6, 45),
(51, 'Beatriz', 'bmolinaji@email.com', 'Molina Jiménez', 30500, 0, 6, 45),
(52, 'Alberto', 'agarciasa@email.com', 'García Sáez', 31300, 2, 6, 45),
(53, 'Antonio', 'agonzalezma@email.com', 'González Martínez', 32100, 1, 6, 45),
(54, 'María Pilar', 'mpcascalesar@email.com', 'Cascales Arcos', 32900, 4, 6, 45),
(55, 'María Luisa', 'mlgonzalezsi@email.com', 'González Silvestre', 33700, 2, 6, 45),
(56, 'María', 'mlozanoor@email.com', 'Lozano Ortiz', 34500, 3, 6, 45),
(57, 'María Dolores', 'mdpradara@email.com', 'Prada Ramírez', 35300, 2, 6, 45),
(58, 'Pedro', 'psampedrobo@email.com', 'Sampedro Bohórquez', 36100, 0, 6, 45),
(59, 'Manuel', 'msilvara@email.com', 'Silva Ramiro', 36900, 0, 6, 45),
(60, 'Juan Carlos', 'jcestebandu@email.com', 'Esteban Duran', 37700, 4, 6, 45),
(61, 'María Victoria', 'mmllobetbl@email.com', 'Llobet Blanes', 38500, 1, 7, 45),
(62, 'Alba', 'aasenciopo@email.com', 'Asencio Porto', 39300, 1, 7, 45),
(63, 'José Juan', 'jjsanchosa@email.com', 'Sancho Sánchez', 40100, 4, 7, 45),
(64, 'Javier', 'jpalacioste@email.com', 'Palacios Tenorio', 40900, 1, 7, 45),
(65, 'Cristina', 'clopezve@email.com', 'López Vela', 41700, 3, 7, 45),
(66, 'Antonio', 'aaguilarce@email.com', 'Aguilar Ceballos', 26500, 1, 7, 45),
(67, 'Carlos', 'cchaparrode@email.com', 'Chaparro De la Fuente', 27000, 0, 7, 100),
(68, 'María Ángeles', 'mabanosbu@email.com', 'Baños Bueno', 27500, 4, 7, 73),
(69, 'María Ángeles', 'maromerome@email.com', 'Romero Méndez', 28000, 4, 7, 100),
(70, 'Margarita', 'mmatace@email.com', 'Mata Cea', 28500, 4, 7, 115),
(71, 'Ángeles', 'amendezfe@email.com', 'Méndez Fernández', 29000, 2, 7, 45),
(72, 'Ana María', 'amvaldiviagu@email.com', 'Valdivia Gutiérrez', 29500, 3, 1, 45),
(73, 'Alejandro', 'afernandezdo@email.com', 'Fernández Domínguez', 30000, 2, 1, 45),
(74, 'David', 'dmedinalo@email.com', 'Medina López', 30500, 0, 2, 45),
(75, 'Inmaculada', 'ilopezro@email.com', 'López Rodríguez', 31000, 0, 2, 45),
(76, 'Alex', 'adelri@email.com', 'Del Rio Llamazares', 31500, 1, 3, 45),
(77, 'Andrés', 'adasi@email.com', 'Da Silva Angulo', 32000, 2, 3, 45),
(78, 'David', 'dcaleroco@email.com', 'Calero Collado', 32500, 3, 4, 45),
(79, 'María Teresa', 'mtmorenope@email.com', 'Moreno Pérez', 33000, 1, 4, 44),
(80, 'Juan', 'jvelascoca@email.com', 'Velasco Carballo', 33500, 0, 4, 7),
(81, 'José', 'jromerapa@email.com', 'Romera Parada', 34000, 0, 4, 49),
(82, 'Manuela', 'mdelgadomu@email.com', 'Delgado Muñoz', 34500, 2, 5, 39),
(83, 'Santiago', 'smartinezde@email.com', 'Martínez Delgado', 35000, 2, 5, 45),
(84, 'Raúl', 'rfreiresa@@email.com', 'Freire Saavedra', 35500, 3, 5, 45),
(85, 'Ana Belén', 'abvillanuevaso@email.com', 'Villanueva Soler', 36000, 3, 6, 45),
(86, 'Silvia', 'smoralesru@email.com', 'Morales Rubio', 36500, 4, 6, 45),
(87, 'Pedro', 'pmartingo@email.com', 'Martin González', 37000, 3, 6, 45),
(88, 'Rafael', 'rojedamo@email.com', 'Ojeda Molina', 18000, 1, 7, 45),
(89, 'Enrique', 'ebuenoju@email.com', 'Bueno Juan', 18500, 2, 7, 45),
(90, 'Eduardo', 'elopezva@email.com', 'López Vázquez', 19000, 4, 7, 45),
(91, 'Carmen', 'cmiroar@email.com', 'Miro Ares', 19500, 1, 7, 45),
(92, 'Sergio', 'ssomozaga@email.com', 'Somoza García', 20000, 1, 8, 45),
(93, 'Antonia', 'apenaga@email.com', 'Peña Gallego', 20500, 4, 8, 45),
(94, 'Isabel', 'ilopezra@email.com', 'López Ramos', 21000, 1, 8, 45),
(95, 'Francisco Javier', 'fjrodriguezbe@email.com', 'Rodríguez Beltrán', 21500, 4, 8, 45),
(96, 'Juan', 'jalemanyri@email.com', 'Alemany Rivero', 22000, 3, 8, 45),
(97, 'Felipe', 'ftiradohe@email.com', 'Tirado Hernández', 22500, 3, 1, 45),
(98, 'Antonio', 'agarciaro@email.com', 'García Romero', 23000, 1, 2, 45),
(99, 'Cristina', 'clopezle@email.com', 'López Lechuga', 23500, 0, 3, 149),
(100, 'María Concepción', 'mcestevebe@email.com', 'Esteve Becerra', 24000, 2, 4, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` int(11) NOT NULL,
  `nacionalidad` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `nacionalidad`, `pais`) VALUES
(1, 'Afgana', 'Afganistán'),
(2, 'Albanesa', 'Albania'),
(3, 'Alemana', 'Alemania'),
(4, 'Andorrana', 'Andorra'),
(5, 'Angoleña', 'Angola'),
(6, 'Argelina', 'Argelia'),
(7, 'Argentina', 'Argentina'),
(8, 'Australiana', 'Australia'),
(9, 'Austriaca', 'Austria'),
(10, 'Bahamesa', 'Bahamas'),
(11, 'Bahreina', 'Bahrein'),
(12, 'Bangladesha', 'Bangladesh'),
(13, 'Barbadesa', 'Barbados'),
(14, 'Belga', 'Bélgica'),
(15, 'Beliceña', 'Belice'),
(16, 'Bermudesa', 'Bermudas'),
(17, 'Birmana', 'Birmania'),
(18, 'Boliviana', 'Bolivia'),
(19, 'Botswanesa', 'Botswana'),
(20, 'Brasileña', 'Brasil'),
(21, 'Bulgara', 'Bulgaria'),
(22, 'Burundesa', 'Burundi'),
(23, 'Butana', 'Butan'),
(24, 'Camboyana', 'Rep de Camboya'),
(25, 'Camerunesa', 'Camerún'),
(26, 'Canadiense', 'Canada'),
(27, 'Centroafricana', 'Rep Centroafricana'),
(28, 'Chadeña', 'Chad'),
(29, 'Checoslovaca', 'Republica Checa'),
(30, 'Chilena', 'Chile'),
(31, 'China', 'China'),
(32, 'China', 'Taiwan'),
(33, 'Chipriota', 'Chipre'),
(34, 'Colombiana', 'Colombia'),
(35, 'Congoleña', 'Congo'),
(36, 'Costarricense', 'Costa Rica'),
(37, 'Cubana', 'Cuba'),
(38, 'Danes', 'Dinamarca'),
(39, 'Dominicana', 'Republica Dominicana'),
(40, 'Ecuatoriana', 'Ecuador'),
(41, 'Egipcia', 'Egipto'),
(42, 'Emirata', 'Emiratos Arabes'),
(43, 'Escosesa', 'Escocia'),
(44, 'Eslovaca', 'Rep. Eslovaca'),
(45, 'Española', 'España'),
(46, 'Estona', 'Estonia'),
(47, 'Etiope', 'Etiopia'),
(48, 'Fijena', 'Fiji'),
(49, 'Filipina', 'Filipinas'),
(50, 'Finlandesa', 'Finlandia'),
(51, 'Francesa', 'Francia'),
(52, 'Gabiana', 'Gambia'),
(53, 'Gabona', 'Gabón'),
(54, 'Galesa', 'Gales'),
(55, 'Ghanesa', 'Ghana'),
(56, 'Granadeña', 'Granada'),
(57, 'Griega', 'Grecia'),
(58, 'Guatemalteca', 'Guatemala'),
(59, 'Guinesa Ecuatoriana', 'Guinea Ecuatorial'),
(60, 'Guinesa', 'Guinea'),
(61, 'Guyanesa', 'Guyana'),
(62, 'Haitiana', 'Haiti'),
(63, 'Holandesa', 'Holanda'),
(64, 'Hondureña', 'Honduras'),
(65, 'Hungara', 'Hungria'),
(66, 'India', 'India'),
(67, 'Indonesa', 'Indonesia'),
(68, 'Inglesa', 'Inglaterra'),
(69, 'Iraki', 'Irak'),
(70, 'Irani', 'Iran'),
(71, 'Irlandesa', 'Irlanda'),
(72, 'Islandesa', 'Islandia'),
(73, 'Israeli', 'Israel'),
(74, 'Italiana', 'Italia'),
(75, 'Jamaiquina', 'Jamaica'),
(76, 'Japonesa', 'Japón'),
(77, 'Jordana', 'Jordania'),
(78, 'Katensa', 'Katar'),
(79, 'Keniana', 'Kenia'),
(80, 'Kuwaiti', 'Kwait'),
(81, 'Laosiana', 'Laos'),
(82, 'Leonesa', 'Sierra leona'),
(83, 'Lesothensa', 'Lesotho'),
(84, 'Letonesa', 'Letonia'),
(85, 'Libanesa', 'Libano'),
(86, 'Liberiana', 'Liberia'),
(87, 'Libeña', 'Libia'),
(88, 'Liechtenstein', 'Liechtenstein'),
(89, 'Lituana', 'Lituania'),
(90, 'Luxemburgo', 'Luxemburgo'),
(91, 'Madagascar', 'Madagascar'),
(92, 'Malawi', 'Malawi'),
(93, 'Maldivas', 'Maldivas'),
(94, 'Mali', 'Mali'),
(95, 'Maltesa', 'Malta'),
(96, 'Marfilesa', 'Costa de Marfil'),
(97, 'Marroqui', 'Marruecos'),
(98, 'Mauricio', 'Mauricio'),
(99, 'Mauritana', 'Mauritania'),
(100, 'Mexicana', 'México'),
(101, 'Monaco', 'Monaco'),
(102, 'Mongolesa', 'Mongolia'),
(103, 'Nauru', 'Nauru'),
(104, 'Neozelandesa', 'Nueva Zelandia'),
(105, 'Nepalesa', 'Nepal'),
(106, 'Nicaraguense', 'Nicaragua'),
(107, 'Nigerana', 'Niger'),
(108, 'Nigeriana', 'Nigeria'),
(109, 'Norcoreana', 'Corea del Norte'),
(110, 'Norirlandesa', 'Irlanda del norte'),
(111, 'Norteamericana', 'Estados Unidos'),
(112, 'Noruega', 'Noruega'),
(113, 'Omana', 'Omán'),
(114, 'Pakistani', 'Pakistán'),
(115, 'Panameña', 'Panamá'),
(116, 'Paraguaya', 'Paraguay'),
(117, 'Peruana', 'Perú'),
(118, 'Polaca', 'Polonia'),
(119, 'Portoriqueña', 'Puerto Rico'),
(120, 'Portuguesa', 'Portugal'),
(121, 'Rhodesiana', 'Rhodesia'),
(122, 'Ruanda', 'Ruanda'),
(123, 'Rumana', 'Rumanía'),
(124, 'Rusa', 'Rusia'),
(125, 'Salvadoreña', 'El Salvador'),
(126, 'Samoa Occidental', 'Samoa Occidental'),
(127, 'San marino', 'San Marino'),
(128, 'Saudi', 'Arabia Saudita'),
(129, 'Senegalesa', 'Senegal'),
(130, 'Singapur', 'Singapur'),
(131, 'Siria', 'Siria'),
(132, 'Somalia', 'Somalia'),
(133, 'Sovietica', 'Union Sovietica'),
(134, 'Sri Lanka', 'Sri Lanka (Ceylan)'),
(135, 'Suazilandesa', 'Suazilandia'),
(136, 'Sudafricana', 'Sudafrica'),
(137, 'Sudanesa', 'Sudan'),
(138, 'Sueca', 'Suecia'),
(139, 'Suiza', 'Suiza'),
(140, 'Surcoreana', 'Corea del Sur'),
(141, 'Tailandesa', 'Tailandia'),
(142, 'Tanzana', 'Tanzania'),
(143, 'Tonga', 'Tonga'),
(144, 'Tongo', 'Tongo'),
(145, 'Trinidad y Tobago', 'Trinidad y Tobago'),
(146, 'Tunecina', 'Tunez'),
(147, 'Turca', 'Turquia'),
(148, 'Ugandesa', 'Uganda'),
(149, 'Uruguaya', 'Uruguay'),
(150, 'Vaticano', 'Vaticano'),
(151, 'Venezolana', 'Venezuela'),
(152, 'Vietnamita', 'Vietnam'),
(153, 'Yugoslava', 'Yugoslavia'),
(154, 'Zaire', 'Zaire');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(1) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'ADMIN'),
(2, 'GESTOR'),
(3, 'CONSULTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sedes`
--

INSERT INTO `sedes` (`id`, `nombre`, `direccion`) VALUES
(1, 'SEDE CENTRAL', 'C ATOCHA, 405, MADRID'),
(2, 'SEDE SUR', 'PLAZA NUEVA, 3, SEVILLA'),
(3, 'SEDE NORESTE', 'PASEO DE GRACIA, 15, BARCELONA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `email` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(60) NOT NULL,
  `rol_id` int(10) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`email`, `password`, `activo`, `token`, `rol_id`, `fecha`) VALUES
('consulta@email.com', '$2y$10$.Aiv5VdzMpN3I7x7RxCQT.1YPyD25wslh//IeolO43ShXJ8jME9ru', 1, '37e5469f74951cefd3832285ae3955ca', 3, '2024-01-30 18:39:32'),
('admin@email.com', '$2y$10$.Aiv5VdzMpN3I7x7RxCQT.1YPyD25wslh//IeolO43ShXJ8jME9ru', 1, '68fd71bc7e982bf3945d6a829f238b6d', 1, '2023-01-30 18:33:02'),
('otro@email.com', '$2y$10$.Aiv5VdzMpN3I7x7RxCQT.1YPyD25wslh//IeolO43ShXJ8jME9ru', 1, '4f784489351ce27c1c9662e37a1a0fcf', 2, '2025-04-01 18:38:18'),
('gestor@email.com', '$2y$10$.Aiv5VdzMpN3I7x7RxCQT.1YPyD25wslh//IeolO43ShXJ8jME9ru', 1, '1c2e8dc38aabde47144ecd02a7e9cb0c', 2, '2024-04-30 18:39:06');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `centro` (`sede_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departamento` (`departamento_id`),
  ADD KEY `nacionalidad` (`pais_id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`email`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sedes`
--
ALTER TABLE `sedes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `departamentos_ibfk_1` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`),
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
