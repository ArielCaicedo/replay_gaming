-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2024 a las 13:35:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_juegos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Acción y Aventura', 'Juegos que combinan desafíos físicos y narrativos, exploración y combate.'),
(2, 'Rol', 'Juegos donde los jugadores asumen el papel de personajes en un mundo ficticio.'),
(3, 'Terror', 'Juegos diseñados para asustar e inquietar a los jugadores a través de la atmósfera, la trama y los personajes.'),
(4, 'Deportes', 'Juegos que simulan la práctica de deportes.'),
(5, 'Carreras', 'Juegos centrados en la conducción de vehículos y la competición en carreras.'),
(6, 'Simulación', 'Juegos que simulan aspectos de la vida real o ficticia.'),
(7, 'Estrategia', 'Juegos que se centran en la planificación y el pensamiento táctico.'),
(8, 'Puzzles y Plataformas', 'Juegos que desafían la habilidad mental y la coordinación del jugador.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apellidos` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `estatus` varchar(20) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id_detcompra` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL CHECK (`precio` >= 0),
  `descuento` tinyint(3) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL CHECK (`stock` >= 0),
  `fecha_agregado` datetime DEFAULT current_timestamp(),
  `id_categoria` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `popularidad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `descuento`, `stock`, `fecha_agregado`, `id_categoria`, `activo`, `imagen`, `popularidad`) VALUES
(1, 'EA Sports FC 25', 'EA SPORTS FC™ 25 es la última entrega de la serie de simuladores de fútbol de Electronic Arts, lanzada el 27 de septiembre de 2024. Este título introduce mejoras como el modo Rush 5v5 para partidas rápidas, el sistema de inteligencia artificial FC IQ para un control táctico avanzado y la integración de datos reales de partidos para mayor realismo. También se han ajustado la física del balón y el rendimiento de los porteros.\nDisponible en PlayStation 5, Xbox Series X|S y PC, el juego ha sido bien recibido por sus innovaciones, aunque mantiene una esencia familiar para los seguidores de la franquicia. EA SPORTS FC™ 25 se consolida como un referente en simuladores de fútbol.\n', 19.99, 10, 10, '2024-10-16 17:16:41', 4, 1, 'EA Sports FC 25.jpeg', 'tendencia'),
(2, 'Mario Kart 8 Deluxe', 'Mario Kart 8 Deluxe es la versión definitiva del exitoso juego de carreras de Nintendo, optimizada para Nintendo Switch. Incluye todos los circuitos y personajes del título original de Wii U y sus DLC, junto con nuevos pilotos como Inkling Girl, King Boo y Dry Bones. El modo batalla, rediseñado, presenta opciones como Balloon Battle y Renegade Roundup, aumentando la diversión multijugador. Permite competir con hasta 8 jugadores localmente o 12 en línea, con soporte para pantalla dividida. Gracias a la conducción asistida, es accesible para jugadores de todas las edades. Con gráficos vibrantes, pistas creativas y mecánicas equilibradas, es una experiencia ideal para fans de las carreras y el multijugador.', 14.99, 0, 5, '2024-10-16 17:16:41', 5, 1, 'Mario Kart 8 Deluxe.jpeg', 'tendencia'),
(3, 'God Of War Ragnarok', 'God of War Ragnarök es la continuación de la exitosa saga de acción y aventura protagonizada por Kratos y su hijo Atreus. Ambientado en la mitología nórdica, el juego explora los eventos del Ragnarök, la guerra apocalíptica entre los dioses y los gigantes. Kratos, ahora más maduro, debe lidiar con sus conflictos internos mientras enfrenta a dioses y criaturas mitológicas. El juego ofrece un mundo abierto, combates mejorados y una narrativa profunda que profundiza en la relación padre-hijo. Con gráficos impresionantes, nuevos personajes y mecánicas innovadoras, Ragnarök eleva la serie a nuevas alturas, combinando acción intensa con una historia emocionalmente impactante.', 24.99, 10, 7, '2024-10-16 17:16:41', 1, 1, 'God Of War Ragnarok.jpeg', 'tendencia'),
(4, 'Mortal Kombat 1', 'Mortal Kombat 1 es una reinvención de la clásica saga de lucha, ofreciendo una nueva narrativa y personajes, mientras mantiene la brutalidad y los combates icónicos de la franquicia. El juego introduce un sistema de combate renovado, con movimientos especiales, fatalities y nuevos luchadores que enfrentan a sus rivales en escenarios llenos de detalles. La historia sigue la lucha entre los reinos y presenta a los héroes y villanos más emblemáticos de la serie. Con gráficos mejorados y modos de juego innovadores, Mortal Kombat 1 mantiene su esencia mientras ofrece una experiencia fresca para los fanáticos.', 17.99, 0, 8, '2024-10-16 17:16:41', 1, 1, 'Mortal Kombat 1.jpeg', 'tendencia'),
(5, 'Dragon Ball Sparking Zero', 'Entra en el universo de Dragon Ball con Dragon Ball Sparking Zero, un juego de lucha lleno de acción inspirado en la emblemática serie. Experimenta batallas épicas con un vasto elenco de personajes icónicos, cada uno con movimientos característicos y transformaciones legendarias. El título cuenta con escenarios destructibles y un sistema de combate fluido que captura la intensidad de la serie. Sumérgete en modos de juego como peleas individuales, torneos y un modo historia lleno de nostalgia. Los gráficos vibrantes y el diseño fiel al anime aseguran una experiencia auténtica para los fans. Ideal para disfrutar en solitario o en intensos enfrentamientos multijugador. ¡Desata tu ki y vive la emoción de Dragon Ball!', 89.99, 10, 6, '2024-10-16 17:16:41', 1, 1, 'Dragon Ball Sparking Zero.jpeg', 'mas jugados'),
(6, 'Killer Klowns From Outer Space', 'Basado en la película de culto de los años 80, Killer Klowns From Outer Space es un juego multijugador de terror y comedia que enfrenta a humanos contra los excéntricos y letales payasos alienígenas. Con un estilo visual único y humor oscuro, los jugadores pueden elegir entre ser un humano luchando por sobrevivir o un Killer Klown desplegando ingeniosas armas y trampas. Cada Klown tiene habilidades especiales, mientras que los humanos deben colaborar para escapar o detener la invasión. Escenarios interactivos, mecánicas de sigilo y un diseño fiel al filme hacen de este juego una experiencia entretenida y aterradoramente divertida.', 29.99, 0, 4, '2024-10-16 17:16:41', 3, 1, 'Killer Klowns From Outer Space.jpeg', 'mas jugados'),
(7, 'Ghost Of Tsushima Director\'s Cut', 'Sumérgete en el Japón feudal con esta versión definitiva de Ghost of Tsushima, que incluye la aclamada historia original y el nuevo contenido de la expansión Iki Island. Acompaña a Jin Sakai en su viaje como un samurái que debe adaptarse para liberar Tsushima de la invasión mongola. Explora paisajes deslumbrantes, desde densos bosques hasta playas doradas, mientras dominas un sistema de combate preciso con katana y habilidades sigilosas. La edición Director\'s Cut mejora los gráficos, añade soporte para DualSense en PS5 y ofrece nuevas misiones, enemigos y habilidades. Una obra maestra que combina acción, narrativa y una ambientación inolvidable.', 15.99, 10, 9, '2024-10-16 17:16:41', 6, 1, 'Ghost Of Tsushima Directors Cut.jpeg', 'mas jugados'),
(8, 'Call Of Duty Black Ops 6', 'Regresa al emocionante mundo de operaciones encubiertas con Black Ops 6, una experiencia cargada de adrenalina. Este capítulo lleva la acción a un nuevo nivel con una campaña inmersiva que mezcla espionaje y combates explosivos en escenarios globales. El multijugador incluye mapas dinámicos, armas personalizables y modos clásicos junto a innovadores. La experiencia Zombies vuelve con una narrativa envolvente y hordas de no-muertos más desafiantes. Gráficos impresionantes, físicas realistas y una banda sonora épica completan este título que redefine los estándares de los shooters modernos. ¡Prepárate para la batalla definitiva!', 39.99, 0, 3, '2024-10-16 17:16:41', 1, 1, 'Call Of Duty Black Ops 6.jpeg', 'mas jugados'),
(9, 'Luigis Mansion 3', 'Únete a Luigi en su aventura más escalofriantemente divertida en Luigi\'s Mansion 3. Invitado a un lujoso hotel, Luigi pronto descubre que el lugar está embrujado y debe rescatar a Mario y sus amigos capturando fantasmas. Equipado con el potente Poltergust G-00, Luigi puede aspirar enemigos, resolver ingeniosos rompecabezas y explorar pisos temáticos únicos, desde una pirámide desértica hasta un castillo medieval. Presenta gráficos vibrantes, humor encantador y mecánicas cooperativas con Gooigi, su gelatinoso clon. Este juego combina acción y comedia en una experiencia inolvidable para todas las edades.', 14.99, 15, 10, '2024-10-16 17:16:41', 8, 1, 'Luigis Mansion 3.jpeg', 'mas jugados'),
(10, 'Resident Evil Village', 'Adéntrate en el terror y la supervivencia con Resident Evil Village, la inquietante secuela de la aclamada saga. En esta entrega, Ethan Winters, tras los eventos de Resident Evil 7, se enfrenta a horrores inimaginables en un misterioso pueblo europeo dominado por criaturas grotescas y la imponente Lady Dimitrescu. Explora un entorno sombrío lleno de secretos, puzzles desafiantes y combates intensos contra enemigos aterradores. Con gráficos impresionantes y una narrativa cautivadora, este juego combina acción y horror psicológico, llevando la experiencia de survival horror a nuevas alturas. Un imperdible para los amantes del género.', 19.99, 0, 5, '2024-10-16 17:16:41', 3, 1, 'Resident Evil Village.jpeg', 'mas jugados'),
(11, 'Naruto Shippuden Ultimate Ninja Storm 4', 'Revive las épicas batallas de Naruto Shippuden en la entrega más completa de la saga Ultimate Ninja Storm. Experimenta el desenlace de la historia con combates dinámicos y fieles al anime, enfrentando a personajes icónicos como Naruto, Sasuke, Madara y Kaguya. Este juego ofrece un impresionante apartado visual que recrea con detalle las técnicas ninja y poderes más emblemáticos. Con un extenso elenco de personajes jugables, modos multijugador y una narrativa emocionante, es una experiencia perfecta para los fans del universo Naruto. Domina el arte del Ninjutsu y libra intensas batallas en este juego lleno de acción y nostalgia.', 35.99, 10, 10, '2024-10-18 13:30:00', 1, 1, 'Naruto Shippuden Ultimate Ninja Storm 4.jpeg', 'tendencia'),
(12, 'Grand Theft Auto V', 'Embárcate en una aventura épica en Los Santos, una metrópolis vibrante llena de oportunidades y peligros, en Grand Theft Auto V. Sigue las historias interconectadas de Michael, Franklin y Trevor mientras se sumergen en un mundo de crimen, ambición y traición. Explora un entorno masivo de mundo abierto con actividades diversas, desde robos audaces hasta deportes extremos. Con gráficos impresionantes, una narrativa envolvente y un multijugador en línea robusto, GTA V redefine los juegos sandbox. Personaliza vehículos, adquiere propiedades y crea caos o persigue riqueza en esta experiencia inmersiva y llena de posibilidades.', 29.50, 0, 10, '2024-05-15 10:45:00', 2, 1, 'Grand Theft Auto V.jpeg', 'tendencia'),
(13, 'Dead By Daylight', 'Adéntrate en el aterrador mundo de Dead by Daylight, un juego multijugador asimétrico de supervivencia y horror. Cuatro sobrevivientes deben unirse para reparar generadores y escapar de un asesino implacable antes de ser capturados y sacrificados. Elige jugar como un sobreviviente estratégico o un asesino con habilidades únicas, inspirado en icónicos villanos del terror. Con mapas sombríos, partidas cargadas de tensión y eventos regulares, cada sesión ofrece nuevos desafíos y estrategias. Personaliza personajes, desbloquea habilidades y experimenta la emoción del gato y el ratón en un escenario donde el miedo nunca termina.', 27.99, 12, 8, '2024-06-25 16:00:00', 3, 1, 'Dead By Daylight.jpeg', 'tendencia'),
(14, 'WWE 2K24', 'WWE 2K24 lleva la experiencia de lucha libre a un nuevo nivel con gráficos mejorados, jugabilidad fluida y una selección impresionante de superestrellas. El juego ofrece un modo carrera más inmersivo, permitiendo a los jugadores crear su propio luchador y vivir su camino hacia la gloria en la WWE. Además, los fans de la lucha libre podrán disfrutar de combates épicos con su roster favorito, que incluye a leyendas y luchadores actuales. Las mecánicas de lucha se han refinado, ofreciendo un control más preciso y movimientos más realistas. Con nuevos modos de juego y un sistema de personalización más robusto, WWE 2K24 es el título definitivo para los aficionados de la WWE.', 31.25, 0, 9, '2024-03-10 14:00:00', 6, 1, 'WWE 2K24.jpeg', 'tendencia'),
(15, 'Need For Speed Unbound', 'Need for Speed Unbound ofrece una experiencia de carreras de alto octanaje con una estética única que combina gráficos realistas con un estilo artístico vibrante y de cómic. En este juego, los jugadores se sumergen en un mundo abierto lleno de desafíos, persecuciones policiales y competiciones callejeras. Con un enfoque en la personalización de vehículos, NFS Unbound permite a los jugadores modificar sus autos para maximizar el rendimiento y el estilo. El juego presenta una historia dinámica que involucra robos, rivalidades y la búsqueda de la gloria en las carreras ilegales. Con controles precisos y una banda sonora energética, Need for Speed Unbound es una experiencia de carreras intensa y emocionante.', 23.99, 6, 7, '2024-08-20 18:30:00', 5, 1, 'Need For Speed Unbound.jpeg', 'tendencia'),
(16, 'The Legend Of Zelda', 'Sumérgete en el épico mundo de The Legend of Zelda, donde el destino de Hyrule está en tus manos. Asume el papel de Link, un valiente héroe en una misión para rescatar a la Princesa Zelda y derrotar al malvado Ganon. Explora vastos paisajes llenos de misteriosos templos, desafiantes acertijos y criaturas temibles. Con gráficos impresionantes, una historia cautivadora y una jugabilidad única que combina aventura, acción y estrategia, The Legend of Zelda es mucho más que un juego: es una experiencia inolvidable. Desbloquea secretos, mejora tus habilidades y vive la aventura definitiva que ha cautivado a generaciones. No te pierdas la oportunidad de ser parte de esta legendaria saga y adéntrate en una de las mejores historias de todos los tiempos. ¡El reino de Hyrule te espera!', 26.75, 0, 10, '2024-04-10 11:00:00', 7, 1, 'The Legend Of Zelda.jpeg', 'tendencia'),
(17, 'single-game', 'Juego de disparos en primera persona lleno de acción intensa y combates rápidos.', 22.99, 12, 10, '2024-07-05 20:30:00', 5, 0, 'single-game.jpeg', 'por defecto'),
(18, 'Silent Hill 2', 'Adéntrate en el aterrador y misterioso mundo de Silent Hill 2, un juego de terror psicológico que te mantendrá al borde de tu asiento. En este clásico, controlas a James Sunderland, quien recibe una carta de su difunta esposa, Mary, invitándolo a reunirse en el espeluznante pueblo de Silent Hill. A medida que exploras la ciudad desolada, descubrirás oscuros secretos y enfrentarás criaturas grotescas mientras luchas por la verdad detrás de su trágica historia. Con una atmósfera tensa, gráficos inquietantes y una narrativa profunda que aborda el dolor, la culpa y la redención, Silent Hill 2 es una experiencia que define el género de terror. Si eres amante del suspense y las historias perturbadoras, no puedes dejar pasar este título. Atrévete a enfrentar tus miedos en uno de los juegos de terror más influyentes de todos los tiempos. ¡El terror nunca ha sido tan real!', 19.99, 0, 10, '2024-06-12 09:15:00', 3, 1, 'Silent Hill 2.jpeg', 'tendencia'),
(19, 'Red Dead Redemption', 'Embárcate en un viaje épico por el salvaje oeste en Red Dead Redemption, un juego de acción y aventura de mundo abierto que te sumergirá en una de las historias más cautivadoras de la historia de los videojuegos. Juegas como John Marston, un exforajido que busca redención y tiene que enfrentarse a su pasado oscuro para salvar a su familia. Enfrenta desafíos mientras exploras paisajes impresionantes, desde vastos desiertos hasta montañas cubiertas de nieve. Lucha, caza, y vive la vida en la frontera mientras tomas decisiones que afectarán el curso de tu historia. Con mecánicas de disparos realistas, una narrativa profunda y un mundo abierto lleno de vida, Red Dead Redemption te ofrece una experiencia inmersiva y auténtica. Si eres fanático del oeste y las historias épicas, ¡este juego no te puede faltar!', 32.50, 8, 6, '2024-02-17 15:30:00', 1, 1, 'Red Dead Redemption.jpeg', 'tendencia'),
(20, 'Donkey Kong Country Tropical Freeze', '¡Únete a Donkey Kong y su familia en una aventura llena de acción en Donkey Kong Country: Tropical Freeze! Este juego de plataformas clásico regresa con gráficos vibrantes y niveles desafiantes que te mantendrán al borde de tu asiento. Enfréntate a los temibles enemigos de los vikingos del hielo que han congelado la isla de Donkey Kong. Atraviesa junglas, montañas y mares helados mientras rescatas a tus amigos y restauras el equilibrio en tu hogar. Con un estilo de juego clásico, pero con nuevas mecánicas y personajes jugables, como Diddy Kong, Dixie Kong y Cranky Kong, Tropical Freeze ofrece horas de diversión en solitario o cooperativo. Si eres fan de los juegos de plataformas y las aventuras retro, este juego es una elección perfecta. ¡Prepara tus habilidades para saltar, correr y desafiar a los peligros del frío!', 28.99, 0, 5, '2024-09-10 12:00:00', 8, 1, 'Donkey Kong Country Tropical Freeze.jpeg', 'tendencia'),
(21, 'Assassins Creed Shadows', 'En Assassin\'s Creed Shadows, embárcate en una oscura y épica aventura como un asesino secreto en las sombras de una ciudad antigua. Viaja a través de impresionantes paisajes urbanos y misteriosos parajes mientras luchas contra poderosas facciones y desvelas una trama llena de secretos y traiciones. La jugabilidad combina sigilo, combate acrobático y resolución de acertijos, todo mientras te sumerges en un mundo abierto repleto de misiones secundarias y desafíos. Explora con libertad absoluta, salta de tejado en tejado, y utiliza el sigilo para eliminar a tus enemigos sin dejar rastro. Cada elección que hagas tendrá consecuencias, lo que hace que tu viaje sea único. Si eres fan de la franquicia Assassin\'s Creed, este título te sumergirá en una historia fascinante y llena de acción que no querrás dejar de jugar. ¡Desata la oscuridad y conviértete en el maestro de las sombras!', 59.99, 0, 8, '2024-11-25 23:01:20', 7, 1, 'Assassins Creed Shadows.jpeg', 'tendencia'),
(22, 'FIFA 23', '¡Vive la emoción del fútbol como nunca antes con FIFA 23! Experimenta una jugabilidad más realista y dinámica con la última edición de la icónica saga de videojuegos. Juega con tus equipos y jugadores favoritos, ya sea en el modo carrera, partidos rápidos o el adictivo Ultimate Team. FIFA 23 presenta mejoras en la inteligencia artificial, el control de balón y el sistema de físicas, haciendo que cada partido sea único. La experiencia visual se eleva con gráficos impresionantes y animaciones realistas que te sumergen completamente en la acción. Además, disfruta de las licencias oficiales de los clubes y ligas más grandes del mundo, incluyendo la nueva integración de la Copa del Mundo. Si eres un fanático del fútbol, FIFA 23 es el título perfecto para ti, ¡prepárate para desafiar a tus amigos y llevar a tu equipo a la gloria!', 49.99, 0, 6, '2024-11-25 23:07:19', 4, 1, 'FIFA 23.jpeg', 'tendencia'),
(26, 'dbz', 'carrusel', 9.99, 0, 1, '2024-11-25 23:27:47', 8, 0, 'dbz.jpeg', 'carrusel'),
(27, 'mk8', 'carrusel', 9.99, 0, 1, '2024-11-25 23:27:47', 8, 0, 'mk8.jpeg', 'carrusel'),
(28, 'fc25', 'carrusel', 9.99, 0, 1, '2024-11-25 23:27:47', 8, 0, 'fc25.jpeg', 'carrusel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`, `descripcion`, `fecha_creacion`) VALUES
(1, 'Administrador', 'Rol con acceso total a todas las funcionalidades del sistema', '2024-10-16 16:58:33'),
(2, 'Usuario', 'Rol con acceso limitado a las funcionalidades del sistema', '2024-10-16 16:58:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `token` varchar(40) NOT NULL,
  `token_password` varchar(40) DEFAULT NULL,
  `password_request` int(11) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id_detcompra`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id_detcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
