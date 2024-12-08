<?php
require_once "config/conexion_pdo.php";
require_once "config/config.php";

/* print_r($_SESSION); */

$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();
// Consulta de productos para el carrusel.
$query = "SELECT imagen FROM productos WHERE popularidad = 'carrusel' LIMIT 4";
$stmt = $pdo->prepare($query);
$stmt->execute();
$resultadosCarrusel = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta de productos para juegos en tendencia.
$query = "SELECT id_producto, nombre, descripcion, precio, imagen,popularidad
            FROM productos
            WHERE popularidad = 'tendencia' LIMIT 4";
$stmt = $pdo->prepare($query);
$stmt->execute();
$resultadosTendencia = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta de productos para juegos en Top.
$query = "SELECT id_producto, nombre, descripcion, precio, imagen, popularidad
            FROM productos
            WHERE popularidad = 'mas jugados' LIMIT 6";
$stmt = $pdo->prepare($query);
$stmt->execute();
$resultadosJugados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener las primeras 6 categorías con su imagen asociada
$query = "SELECT c.id_categoria, c.nombre, c.descripcion, p.imagen 
          FROM categorias c
          LEFT JOIN productos p ON c.id_categoria = p.id_categoria
          GROUP BY c.id_categoria
          ORDER BY c.id_categoria ASC
          LIMIT 6";
$stmt = $pdo->prepare($query);
$stmt->execute();
$resultadosCategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
//print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Ariel_Caicedo">
  <title>Replay Gaming</title>
  <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style_carrusel.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <!-- Header -->
  <?php include 'menu.php'; ?>

  <!-- Banner -->
  <div class="position-relative carousel-container">
    <!-- Texto sobre el carrusel -->
    <div class="position-absolute bottom-0 start-0 text-container text-white p-2 p-md-4 w-100 w-md-50" style="margin-top: 10vh;" data-aos="fade-down-right" data-aos-duration="2000">
      <div class="container">
        <h3 class="fw-semibold text-warning text-center text-md-start fs-6 fs-md-5">Bienvenido A Replay Gaming</h3>
        <h6 class="fs-6 fs-md-3 text-center text-md-start">TU DESTINO NÚMERO UNO PARA JUEGOS INCREÍBLES!</h6>
        <p class="small text-center text-md-start fs-6 fs-md-5">Encuentra juegos de segunda mano en perfecto estado.</p>

        <!-- Formulario ajustado -->
        <form id="search" action="busqueda.php" class="row g-2 mt-3 justify-content-center justify-content-md-start" method="get" autocomplete="off">
          <div class="col-10 col-sm-8 col-md-6">
            <input type="text" name="query" class="form-control form-control-sm" placeholder="Buscar juegos (e.g. FIFA, Call of Duty)" required />
          </div>
          <div class="col-2 col-sm-4 col-md-2 gx-0">
            <button class="btn btn-warning btn-sm text-truncat" type="submit" id="searchButton">Buscar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Carrusel de juegos ocupando toda la sección -->
    <div id="gameCarousel" class="carousel slide carousel-fade h-100" data-bs-ride="carousel">
      <div class="carousel-inner h-100">
        <!-- PHP para las imágenes -->
        <?php
        if (!empty($resultadosCarrusel)) :
          $active = 'active';
          foreach ($resultadosCarrusel as $producto):
        ?>
            <div class="carousel-item h-100 <?php echo $active; ?>" data-bs-interval="10000">
              <img src="img/carrusel/<?php echo $producto['imagen']; ?>" class="img-fluid rounded d-block w-100 h-100 object-fit-cover" alt="Juego">
            </div>
        <?php
            $active = '';
          endforeach;
        endif;
        ?>
      </div>
      <!-- Botones de navegación -->
      <button class="carousel-control-prev" type="button" data-bs-target="#gameCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#gameCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>
  </div>

  <!-- Juegos en Tendencia -->
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="section-heading">
            <h6 class="text-warning">Popular</h6>
            <h2>Juegos en Tendencia</h2>
          </div>
        </div>
      </div>

      <!-- Fila de productos -->
      <div class="row mt-4 g-4" data-aos="fade-down"
        data-aos-easing="linear"
        data-aos-duration="2000">
        <?php foreach ($resultadosTendencia as $producto): ?>
          <div class="col-lg-3 col-md-4 col-sm-6 d-flex align-items-stretch">
            <div class="card shadow-lg border-0 bg-dark text-white d-flex flex-column">
              <!-- Imagen y precio -->
              <div class="thumb position-relative">
                <a href="detalles.php?id=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>">
                  <?php
                  $imagen = "img/" . htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8');
                  if (!file_exists($imagen)) {
                    $imagen = "img/single-game.jpeg"; // Imagen por defecto si no existe
                  }
                  ?>
                  <img src="<?php echo htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top rounded" alt="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?> " loading="lazy">
                </a>
                <!-- Precio -->
                <span class="price position-absolute bottom-0 start-0 p-2 text-white bg-dark bg-opacity-75 rounded">
                  <?php echo MONEDA . ' ' . number_format($producto['precio'], 2, ',', '.'); ?>
                </span>
              </div>
              <div class="card-body text-center d-flex flex-column justify-content-between">
                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></h5>
              </div>
              <!-- Botones -->
              <div class="d-flex justify-content-center mt-auto mb-3">
                <a href="detalles.php?id=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>" class="btn btn-outline-warning btn-sm me-2">Detalles</a>
                <button class="btn btn-outline-warning btn-sm add-to-cart"
                  data-id="<?php echo $producto['id_producto']; ?>"
                  data-token="<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>">
                  <i class="fa fa-shopping-bag"></i> Agregar
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Sección de Juegos Más Jugados -->
  <div class="py-5 shadow-lg rounded-pill bg-dark text-white">
    <div class="section most-played">
      <div class="container">
        <!-- Encabezado -->
        <div class="row">
          <div class="col-lg-12 text-center">
            <div class="section-heading">
              <h6 class="text-warning">TOP JUEGOS</h6>
              <h2>Más Jugados</h2>
            </div>
          </div>
        </div>

        <!-- Juegos -->
        <div class="row mt-2" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="2000">
          <?php foreach ($resultadosJugados as $producto): ?>
            <div class="col-lg-2 col-md-6 col-sm-6 mb-4">
              <div class="item text-center shadow-sm">
                <div class="thumb position-relative overflow-hidden">
                  <a href="detalles.php?id=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>">
                    <?php
                    $imagen = "img/" . htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8');
                    if (!file_exists($imagen)) {
                      $imagen = "img/single-game.jpeg";
                    }
                    ?>
                    <img src="<?php echo htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8'); ?>"
                      class="img-fluid rounded"
                      alt="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>"
                      loading="lazy">
                  </a>
                </div>
                <div class="down-content">
                  <h4 class="h6 mt-2 text-truncate"><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></h4>
                  <!-- Detalles del producto con token -->
                  <a href="detalles.php?id=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>"
                    class="btn btn-sm btn-outline-warning mt-2">Explorar</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Sección de Categorías Principales -->
  <div class="py-5">
    <div class="section categories">
      <div class="container">
        <!-- Encabezado de la sección -->
        <div class="row mb-4">
          <div class="col-lg-6">
            <div class="section-heading">
              <h6>CATEGORÍAS</h6>
              <h2>Categorías Principales</h2>
            </div>
          </div>
        </div>

        <!-- Cards de categorías -->
        <div class="row g-4" data-aos="fade-down"
          data-aos-easing="linear"
          data-aos-duration="1500">
          <?php foreach ($resultadosCategorias as $categoria): ?>
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
              <div class="card border-0 shadow-sm">
                <div class="position-relative">
                  <!-- Título dinámico de la categoría -->
                  <h4 class="card-title text-center bg-success text-white bg-opacity-75 py-2 rounded-top position-absolute w-100">
                    <?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                  </h4>
                  <!-- Enlace a busqueda.php con la categoría seleccionada -->
                  <a href="busqueda.php?categoria=<?php echo $categoria['id_categoria']; ?>">
                    <!-- Imagen de la categoría -->
                    <?php
                    $imagen = "img/" . htmlspecialchars($categoria['imagen'], ENT_QUOTES, 'UTF-8');
                    if (!file_exists($imagen)) {
                      $imagen = "img/single-game.png"; // Imagen por defecto si no hay imagen asociada
                    }
                    ?>
                    <img src="<?php echo $imagen; ?>"
                      class="card-img-top rounded-bottom"
                      alt="<?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?>"
                      style="object-fit: cover; height: 250px; width: 100%;" loading="lazy">
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Sección de Llamada a la Acción -->
  <div class="section cta bg-dark text-white py-5">
    <div class="container">
      <div class="row align-items-center">
        <!-- Bloque de Tienda -->
        <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
          <div class="shop text-center text-md-start">
            <div class="section-heading">
              <h6 class="text-warning">Nuestra Tienda</h6>
              <h2>Pre-ordena y Obtén los Mejores <em>Precios</em> Para Ti</h2>
            </div>
            <p>Lorem ipsum dolor consectetur adipiscing, sed do eiusmod tempor incididunt.</p>
            <div class="main-button">
              <!-- Botón con popover -->
              <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="En desarrollo, próximamente disponible.">
                <a href="#" class="btn rounded-pill px-4 color">Comprar Ahora</a>
              </span>
            </div>
          </div>
        </div>
        <!-- Bloque de Suscripción -->
        <div class="col-lg-5 col-md-6 offset-lg-2">
          <div class="subscribe text-center text-md-start">
            <div class="section-heading">
              <h6 class="text-warning">BOLETÍN DE NOTICIAS</h6>
              <h2>Obtén Hasta $20 de Descuento Suscribiéndote a Nuestro Boletín</h2>
            </div>
            <form id="subscribe" action="#">
              <div class="input-group">
                <!-- Campo de entrada -->
                <input type="email" class="form-control rounded-start-pill" placeholder="Tu correo..." required>
                <!-- Botón con popover -->
                <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="En desarrollo, próximamente disponible.">
                  <button type="submit" class="btn rounded-end-pill px-4 color" disabled>Suscribirse</button>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- footer -->
  <?php include 'footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
  <script>
    AOS.init();
  </script>
  <script src="js/app_carrito.js"></script>
</body>

</html>
