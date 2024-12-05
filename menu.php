<header class="header-area">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-2 navbar-custom">
        <div class="container-fluid">
            <!-- Logotipo -->
            <a href="index.php" class="navbar-brand">
                <img src="img/logotipo/logotipo.png" alt="Replaygaming" class="img-fluid" id="site-logo">
            </a>

            <!-- Menú de navegación centrado -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0"> <!-- Centrado con mx-auto -->
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link active" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link" href="busqueda.php">Catálogo</a>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link" href="contacto.php">Contáctanos</a>
                    </li>
                </ul>
            </div>

            <!-- Contenedor de iconos y botones -->
            <div class="d-flex align-items-center">
                <!-- Carrito de compras con la clase "cart" -->
                <a href="checkout.php" class="btn btn-sm me-2 cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="num_cart" class="badge bg-danger"><?php echo $num_cart; ?></span>
                </a>

                <?php if (isset($_SESSION['id_usuario'])) { ?>
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle text-success" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i> &nbsp; <?php echo $_SESSION['usuario']; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btn_session">
                            <li><a class="dropdown-item" href="compras.php">Mis compras</a></li>
                            <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar sesión</a></li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-user"></i> Iniciar sesión
                    </a>
                <?php } ?>
            </div>
        </div>
    </nav>
</header>