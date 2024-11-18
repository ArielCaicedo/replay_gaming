<?php
require_once "conexion_pdo.php";
require_once "config/config.php";

/* print_r($_SESSION); */

$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

$query = "SELECT id_producto, nombre, descripcion, precio, imagen
            FROM productos
            LIMIT 4";
$stmt = $pdo->prepare($query);
$stmt->execute();
$resultados = $stmt->fetchall(PDO::FETCH_ASSOC);

//print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Ariel_Caicedo">
  <title>Tienda de juegos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <!-- Preloader Start -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>

  <!-- Header Area Start -->
  <?php include 'menu.php'; ?>

  <!-- Main Banner -->
  <div class="position-relative bg-light" style="height: 70vh;">
    <!-- Texto sobre el carrusel -->
    <div class="position-absolute top-50 start-0 translate-middle-y text-container text-white p-4" style="z-index: 2;">
      <h6 class="fw-semibold text-warning small">Bienvenido A Replaygaming</h6>
      <h2 class="fs-3">TU DESTINO NÚMERO UNO PARA JUEGOS INCREÍBLES!</h2>
      <p class="small">Encuentra juegos de segunda mano en perfecto estado.</p>
      <form id="search" action="#" class="d-flex mt-3">
        <input type="text" class="form-control form-control-sm me-2" placeholder="Buscar juegos" />
        <button class="btn btn-warning btn-sm" type="submit">Buscar</button>
      </form>
    </div>


    <!-- Carrusel de juegos ocupando toda la sección -->
    <div id="gameCarousel" class="carousel slide carousel-fade h-100" data-bs-ride="carousel" style="position: relative; z-index: 1;">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" data-bs-interval="10000">
          <img src="img/top-game-01.jpeg" class="d-block w-100 h-100" alt="Juego 1" style="object-fit: cover;">
          <div class="container">
          </div>
        </div>
        <div class="carousel-item h-100">
          <img src="img/top-game-02.jpg" class="d-block w-100 h-100" alt="Juego 2" style="object-fit: cover;">
          <div class="container">
          </div>
        </div>
        <div class="carousel-item h-100">
          <img src="img/top-game-03.jpg" class="d-block w-100 h-100" alt="Juego 3" style="object-fit: cover;">
          <div class="container">
          </div>
        </div>
      </div>
      <!-- Botones de navegación del carrusel -->
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

  <!--plataformas de juegos-->
  <div class="features">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <a href="#" class="text-decoration-none">
            <div class="item text-center">
              <div class="image">
                <img src="assets/images/featured-01.png" alt="" style="max-width: 44px;">
              </div>
              <h4>Playstation</h4>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-md-6">
          <a href="#" class="text-decoration-none">
            <div class="item text-center">
              <div class="image">
                <img src="assets/images/featured-02.png" alt="" style="max-width: 44px;">
              </div>
              <h4>Nintendo</h4>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-md-6">
          <a href="#" class="text-decoration-none">
            <div class="item text-center">
              <div class="image">
                <img src="assets/images/featured-03.png" alt="" style="max-width: 44px;">
              </div>
              <h4>Xbox</h4>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- Juegos en Tendencia -->
  <div class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h6 class="text-warning">Popular</h6>
          <h2>Juegos en Tendencia</h2>
        </div>
        <div class="col-md-4 text-md-end"> <a href="shop.html" class="btn btn-warning">Ver Todos</a> </div>
      </div>
      <div class="row mt-4">
        <?php foreach ($resultados as $producto): ?>
          <div class="col-lg col-sm-6 col-xs-12">
            <div class="card shadow-sm border-0">
              <?php
              $imagen = "img/" . htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8');
              if (!file_exists($imagen)) {
                $imagen = "img/single-game.jpg";
              } ?>
              <img src="<?php echo htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>">
              <div class="card-body text-center">
                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></h5>

                <p class="text-warning fw-bold"><?php echo MONEDA . ' ' . number_format($producto['precio'], 2, ',', '.'); ?></p>
                <a href="detalles.php?id=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>" class="btn btn-outline-warning">Detalles</a>
                <button class="btn btn-outline-warning" type="button" onclick="addProducto(<?php echo $producto['id_producto']; ?>, '<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>')"> <i class="fa fa-shopping-bag"></i> Agregar</button>
              </div>
            </div>
          </div> <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Sección de Juegos Más Jugados -->
  <div class="py-5">
    <div class="section most-played">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="section-heading">
              <h6>TOP JUEGOS</h6>
              <h2>Más Jugados</h2>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="main-button">
              <a href="shop.html">Ver Todos</a>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="item">
              <div class="thumb">
                <a href="product-details.html"><img src="img/top-game-01.jpeg" alt=""></a>
              </div>
              <div class="down-content">
                <span class="category">Aventura</span>
                <h4>Assassin Creed</h4>
                <a href="product-details.html">Explorar</a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="item">
              <div class="thumb">
                <a href="product-details.html"><img src="img/top-game-02.jpg" alt=""></a>
              </div>
              <div class="down-content">
                <span class="category">Aventura</span>
                <h4>Assassin Creed</h4>
                <a href="product-details.html">Explorar</a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="item">
              <div class="thumb">
                <a href="product-details.html"><img src="img/top-game-03.jpg" alt=""></a>
              </div>
              <div class="down-content">
                <span class="category">Aventura</span>
                <h4>Assassin Creed</h4>
                <a href="product-details.html">Explorar</a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="item">
              <div class="thumb">
                <a href="product-details.html"><img src="img/top-game-04.jpg" alt=""></a>
              </div>
              <div class="down-content">
                <span class="category">Aventura</span>
                <h4>Assassin Creed</h4>
                <a href="product-details.html">Explorar</a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="item">
              <div class="thumb">
                <a href="product-details.html"><img src="img/top-game-05.jpg" alt=""></a>
              </div>
              <div class="down-content">
                <span class="category">Aventura</span>
                <h4>Assassin Creed</h4>
                <a href="product-details.html">Explorar</a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="item">
              <div class="thumb">
                <a href="product-details.html"><img src="img/top-game-06.jpg" alt=""></a>
              </div>
              <div class="down-content">
                <span class="category">Aventura</span>
                <h4>Assassin Creed</h4>
                <a href="product-details.html">Explorar</a>
              </div>
            </div>
          </div>
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
          <div class="col-lg-6 text-lg-end">
            <div class="main-button">
              <a href="shop.html">Ver Todas</a>
            </div>
          </div>
        </div>
        <!-- Cards de categorías -->
        <div class="row g-4">
          <!-- Card Acción -->
          <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm">
              <div class="position-relative">
                <h4 class="card-title text-center bg-primary text-white bg-opacity-75 py-2 rounded-top position-absolute w-100">
                  Acción
                </h4>
                <a href="product-details.html">
                  <img src="img/categories-01.jpg" class="card-img-top rounded-bottom" alt="Acción" style="object-fit: cover; height: 250px;">
                </a>
              </div>
            </div>
          </div>
          <!-- Card Aventura -->
          <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm">
              <div class="position-relative">
                <h4 class="card-title text-center bg-primary text-white bg-opacity-75 py-2 rounded-top position-absolute w-100">
                  Aventura
                </h4>
                <a href="product-details.html">
                  <img src="img/categories-05.jpg" class="card-img-top rounded-bottom" alt="Aventura" style="object-fit: cover; height: 250px;">
                </a>
              </div>
            </div>
          </div>
          <!-- Card RPG -->
          <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm">
              <div class="position-relative">
                <h4 class="card-title text-center bg-primary text-white bg-opacity-75 py-2 rounded-top position-absolute w-100">
                  RPG
                </h4>
                <a href="product-details.html">
                  <img src="img/categories-03.jpg" class="card-img-top rounded-bottom" alt="RPG" style="object-fit: cover; height: 250px;">
                </a>
              </div>
            </div>
          </div>
          <!-- Card Deportes -->
          <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm">
              <div class="position-relative">
                <h4 class="card-title text-center bg-primary text-white bg-opacity-75 py-2 rounded-top position-absolute w-100">
                  Deportes
                </h4>
                <a href="product-details.html">
                  <img src="img/categories-04.jpg" class="card-img-top rounded-bottom" alt="Deportes" style="object-fit: cover; height: 250px;">
                </a>
              </div>
            </div>
          </div>
          <!-- Card Simulación -->
          <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm">
              <div class="position-relative">
                <h4 class="card-title text-center bg-primary text-white bg-opacity-75 py-2 rounded-top position-absolute w-100">
                  Simulación
                </h4>
                <a href="product-details.html">
                  <img src="img/categories-05.jpg" class="card-img-top rounded-bottom" alt="Simulación" style="object-fit: cover; height: 250px;">
                </a>
              </div>
            </div>
          </div>
          <!-- Card Estrategia -->
          <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm">
              <div class="position-relative">
                <h4 class="card-title text-center bg-primary text-white bg-opacity-75 py-2 rounded-top position-absolute w-100">
                  Estrategia
                </h4>
                <a href="product-details.html">
                  <img src="img/categories-02.jpg" class="card-img-top rounded-bottom" alt="Estrategia" style="object-fit: cover; height: 250px;">
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sección de Llamada a la Acción -->
  <div class="section cta">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="shop">
            <div class="row">
              <div class="col-lg-12">
                <div class="section-heading">
                  <h6>Nuestra Tienda</h6>
                  <h2>Pre-ordena y Obtén los Mejores <em>Precios</em> Para Ti</h2>
                </div>
                <p>Lorem ipsum dolor consectetur adipiscing, sed do eiusmod tempor incididunt.</p>
                <div class="main-button">
                  <a href="shop.html">Comprar Ahora</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 offset-lg-2 align-self-end">
          <div class="subscribe">
            <div class="row">
              <div class="col-lg-12">
                <div class="section-heading">
                  <h6>BOLETÍN DE NOTICIAS</h6>
                  <h2>Obtén Hasta $100 de Descuento Suscribiéndote a Nuestro Boletín</h2>
                </div>
                <div class="search-input">
                  <form id="subscribe" action="#">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                      placeholder="Tu correo...">
                    <button type="submit">Suscribirse</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- footer -->
  <footer class="bg-dark text-light py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <h5 class="text-uppercase">Gaming Shop</h5>
          <p>Tu destino número uno para juegos increíbles. Encuentra juegos de segunda mano en perfecto estado.
          </p>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <h5 class="text-uppercase">Síguenos</h5>
          <div class="social">
            <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
      </div>
      <hr class="bg-secondary">
      <div class="text-center">
        <p class="mb-0">&copy; 2024 Realizado por Ariel Caicedo.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script>
    function addProducto(id, token) {

      let url = 'clases/carrito.php'
      let formData = new FormData()
      formData.append('id', id)
      formData.append('token', token)

      fetch(url, {
          method: 'POST',
          body: formData,
          mode: 'cors'
        }).then(response => response.json())
        .then(data => {
          if (data.ok) {
            let elemento = document.getElementById("num_cart")
            elemento.innerHTML = data.numero
          }
        })
    }
  </script>
</body>

</html>