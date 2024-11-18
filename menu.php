<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-2">
        <div class="container-fluid">
            <!-- Logotipo más pequeño -->
            <a href="index.php" class="navbar-brand">
                <img src="img/logotipo.png" alt="Replaygaming" class="img-fluid">
            </a>
            <!-- Botón hamburguesa -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menú de navegación centrado -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0"> <!-- Centrado con mx-auto -->
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Inicio</a>
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
                </ul>
            </div>
            <!-- Iconos y botones -->
            <div class="d-flex align-items-center">
                <a href="checkout.php" class="btn btn-primary btn-sm me-2">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                </a>
                <?php if (isset($_SESSION['id_usuario'])) { ?>
                    <div class="dropdown">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
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