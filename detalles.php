<?php
require_once "conexion_pdo.php";
require_once "config/config.php";
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

// Obtener el parámetro 'id' y 'token' de la URL, si no están presentes asignarles un valor vacío.
$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

// Verificar que los parámetros 'id' y 'token' hayan sido proporcionados en la URL.
if ($id == '' || $token == '') {
    echo "Error al procesar la petición";
    exit;
} else {

    // Si los parámetros están presentes, generar un token temporal utilizando el 'id' y una clave secreta 'KEY_TOKEN'.
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    // Comparar el token recibido con el token generado. Si coinciden, continuar con la lógica.
    if ($token == $token_tmp) {
        $query = "SELECT count(id_producto) as count FROM productos WHERE id_producto = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        // Si el producto existe (count > 0), proceder a obtener más detalles del producto.
        if ($count > 0) {
            $query = "SELECT nombre, descripcion, precio, descuento, imagen FROM productos WHERE id_producto = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Asignar los detalles del producto a variables individuales.
            $nombre = $resultado['nombre'];
            $descripcion = $resultado['descripcion'];
            $precio = $resultado['precio'];
            $descuento = $resultado['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $imagen_principal = "img/" . htmlspecialchars($resultado['imagen'], ENT_QUOTES, 'UTF-8');
             // Verificar si la imagen principal existe, de lo contrario asignar una imagen predeterminada.
            if (!file_exists($imagen_principal)) {
                $imagen_principal = "img/single-game.jpg";
            }
            $imgs = array();
            $dir = 'img/';
            // Verificar si el directorio 'img' existe y es un directorio válido.
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {// Abrir el directorio para leer su contenido.
                    while (($archivo = readdir($dh)) !== false) {
                        // Verificar que el archivo sea una imagen (jpg o png) y que no sea la imagen principal.
                        if (is_file($dir . $archivo) && $archivo != $resultado['imagen'] && (strpos($archivo, '.jpg') !== false || strpos($archivo, '.png') !== false)) {
                            $imgs[] = $dir . $archivo;
                        }
                    }
                    closedir($dh);
                }
            }
        } else {
            echo "Producto no encontrado";
            exit;
        }
    } else {
        echo "Error al procesar la petición";
        exit;
    }
}
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

    <!-- Header Area Start -->
    <?php include 'menu.php'; ?>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $imagen_principal; ?>" alt="<?php echo $nombre; ?>" class="d-block w-100">
                            </div>
                            <?php foreach ($imgs as $img): ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $img; ?>" alt="<?php echo $nombre; ?>" class="d-block w-100">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 order-md-2">
                    <h2><?php echo $nombre; ?></h2>

                    <?php if ($descuento > 0) { ?>
                        <p><del><?php echo MONEDA . ' ' . number_format($precio, 2, ',', '.'); ?></del></p>
                        <h2>
                            <?php echo MONEDA . ' ' . number_format($precio_desc, 2, ',', '.'); ?>
                            <small class="text-success"> <?php echo $descuento; ?>% descuento</small>
                        </h2>
                    <?php } else { ?>

                        <h2><?php echo MONEDA . ' ' . number_format($precio, 2, ',', '.'); ?></h2>
                    <?php } ?>
                    <p class="lead">
                        <?php echo $descripcion; ?>
                    </p>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button">Comprar ahora</button>
                        <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- footer -->
    <footer class="bg-dark text-light py-5 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="text-uppercase">Gaming Shop</h5>
                    <p>Tu destino número uno para juegos increíbles. Encuentra juegos de segunda mano en perfecto estado.</p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="text-uppercase">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.html" class="text-white text-decoration-none">Inicio</a></li>
                        <li><a href="shop.html" class="text-white text-decoration-none">Nuestra Tienda</a></li>
                        <li><a href="contact.html" class="text-white text-decoration-none">Contáctanos</a></li>
                        <li><a href="about.html" class="text-white text-decoration-none">Acerca de</a></li>
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