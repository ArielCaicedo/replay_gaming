<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <title>tienda de juegos</title>
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
  <!-- Preloader End -->

  <!-- Header Area Start -->
  <header class="header-area header-sticky">
    <div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark align-items-center">
        <a href="index.html" class="navbar-brand">
        <img src="img/logotipo.jpeg" alt="Replaygaming" style="height: 50px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.html">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.html">Nuestra tienda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="product-details.html">Detalles del producto</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contáctanos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Iniciar Sesión</a>
            </li>
          </ul>
          <div class="cart ml-auto">
            <p><i class="fas fa-shopping-cart"></i> <sup>0</sup> &#36; 0.00</p>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <!-- Header Area End -->

  <div class="main-banner">
    <div class="container d-flex justify-content-between"> <!-- Ajuste para distribución -->
      <div class="col-lg-6 d-flex flex-column justify-content-center">
        <div class="caption header-text" style="margin-left: -20px;">
          <h6>Bienvenido A Replaygaming</h6>
          <h2>TU DESTINO NÚMERO UNO PARA JUEGOS INCREÍBLES!</h2>
          <p>En este sitio web encontrarás Juegos de Segunda Mano en Perfecto Estado.</p>
          <div class="search-input">
            <form id="search" action="#" class="d-flex">
              <input type="text" class="form-control me-2" placeholder="Escriba aquí" id='searchText'
                name="searchKeyword" />
              <button class="btn btn-primary" type="button">Buscar</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6 d-flex justify-content-center" style="margin-left: 20px;">

        <!-- Carousel -->
        <div id="gameCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/top-game-01.jpg" class="d-block" alt="Juego 1">
            </div>
            <div class="carousel-item">
              <img src="img/top-game-02.jpg" class="d-block" alt="Juego 2">
            </div>
            <div class="carousel-item">
              <img src="img/top-game-03.jpg" class="d-block" alt="Juego 3">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#gameCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#gameCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>
        </div>
        <!-- End of Carousel -->
      </div>
    </div>
  </div>

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

        <div class="section trending">
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="section-heading">
                  <h6>Popular</h6>
                  <h2>Juegos en Tendencia</h2>
                </div>
              </div>
              <div class="col-lg-6 text-lg-end">
                <div class="main-button">
                  <a href="shop.html" class="btn btn-primary">Ver Todos</a>
                </div>
              </div>
              <div class="row">
                <!-- Juego 1 -->
                <div class="col-lg-3 col-md-6">
                  <div class="item">
                    <div class="thumb">
                      <a href="product-details.html"><img src="img/trending-01.jpg" alt=""></a>
                      <span class="price"><em>$28</em>$20</span>
                    </div>
                    <div class="down-content text-center">
                      <span class="category">Acción</span>
                      <h4>Assassin Creed</h4>
                      <a href="product-details.html" class="btn btn-outline-primary"><i
                          class="fa fa-shopping-bag"></i></a>
                    </div>
                  </div>
                </div>
                <!-- Juego 2 -->
                <div class="col-lg-3 col-md-6">
                  <div class="item">
                    <div class="thumb">
                      <a href="product-details.html"><img src="img/trending-02.jpg" alt=""></a>
                      <span class="price">$44</span>
                    </div>
                    <div class="down-content text-center">
                      <span class="category">Acción</span>
                      <h4>Assassin Creed</h4>
                      <a href="product-details.html" class="btn btn-outline-primary"><i
                          class="fa fa-shopping-bag"></i></a>
                    </div>
                  </div>
                </div>
                <!-- Juego 3 -->
                <div class="col-lg-3 col-md-6">
                  <div class="item">
                    <div class="thumb">
                      <a href="product-details.html"><img src="img/trending-03.jpg" alt=""></a>
                      <span class="price"><em>$64</em>$44</span>
                    </div>
                    <div class="down-content text-center">
                      <span class="category">Acción</span>
                      <h4>Assassin Creed</h4>
                      <a href="product-details.html" class="btn btn-outline-primary"><i
                          class="fa fa-shopping-bag"></i></a>
                    </div>
                  </div>
                </div>
                <!-- Juego 4 -->
                <div class="col-lg-3 col-md-6">
                  <div class="item">
                    <div class="thumb">
                      <a href="product-details.html"><img src="img/trending-04.jpg" alt=""></a>
                      <span class="price"><em>$28</em>$20</span>
                    </div>
                    <div class="down-content text-center">
                      <span class="category">Acción</span>
                      <h4>Assassin Creed</h4>
                      <a href="product-details.html" class="btn btn-outline-primary"><i
                          class="fa fa-shopping-bag"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sección de Juegos Más Jugados -->
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
                    <a href="product-details.html"><img src="img/top-game-01.jpg" alt=""></a>
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

        <!-- Sección de Categorías -->
        <div class="section categories">
          <div class="container">
            <div class="row">
              <div class="col-lg-12 text-center">
                <div class="section-heading">
                  <h6>Categorías</h6>
                  <h2>Categorías Principales</h2>
                </div>
              </div>
              <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                  <h4>Acción</h4>
                  <div class="thumb">
                    <a href="product-details.html"><img src="img/categories-01.jpg" alt=""></a>
                  </div>
                </div>
              </div>
              <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                  <h4>Aventura</h4>
                  <div class="thumb">
                    <a href="product-details.html"><img src="img/categories-05.jpg" alt=""></a>
                  </div>
                </div>
              </div>
              <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                  <h4>RPG</h4>
                  <div class="thumb">
                    <a href="product-details.html"><img src="img/categories-03.jpg" alt=""></a>
                  </div>
                </div>
              </div>
              <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                  <h4>Deportes</h4>
                  <div class="thumb">
                    <a href="product-details.html"><img src="img/categories-04.jpg" alt=""></a>
                  </div>
                </div>
              </div>
              <div class="col-lg col-sm-6 col-xs-12">
                <div class="item">
                  <h4>Simulación</h4>
                  <div class="thumb">
                    <a href="product-details.html"><img src="img/categories-05.jpg" alt=""></a>
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


        <footer class="bg-dark text-white pt-5 pb-3">
          <div class="container">
            <div class="row">
              <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-uppercase">Gaming Shop</h5>
                <p>Tu destino número uno para juegos increíbles. Encuentra juegos de segunda mano en perfecto estado.
                </p>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-uppercase">Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                  <li><a href="index.html" class="text-white">Inicio</a></li>
                  <li><a href="shop.html" class="text-white">Nuestra Tienda</a></li>
                  <li><a href="contact.html" class="text-white">Contáctanos</a></li>
                  <li><a href="about.html" class="text-white">Acerca de</a></li>
                </ul>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-uppercase">Síguenos</h5>
                <div class="social">
                  <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                  <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
              </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
              <p class="mb-0">&copy; 2024 Realizado por Ariel Caicedo.</p>
            </div>
          </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>

</html>