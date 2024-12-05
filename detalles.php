<?php
require_once "config/conexion_pdo.php";
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
                $imagen_principal = "img/single-game.jpeg";
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
// Consulta de productos para juegos en tendencia.
$query = "SELECT id_producto, nombre, descripcion, precio, imagen, popularidad
            FROM productos
            WHERE popularidad = 'tendencia'
            ORDER BY id_producto DESC
            LIMIT 4";
$stmt = $pdo->prepare($query);
$stmt->execute();
$resultadosTendencia = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Ariel_Caicedo">
    <title>Detalle del producto</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header -->
    <?php include 'menu.php'; ?>
    <!-- Contenido -->
    <main class="py-5 bg-dark">
        <div class="container">
            <div class="row align-items-center">
                <!-- Columna de la imagen del producto -->
                <div class="col-lg-6">
                    <div class="product-image">
                        <img src="<?php echo $imagen_principal; ?>" alt="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid rounded shadow">
                    </div>
                </div>

                <!-- Columna de la información del producto -->
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?></h2>
                    <?php if ($descuento > 0) { ?>
                        <p class="text-light"><del><?php echo MONEDA . ' ' . number_format($precio, 2, ',', '.'); ?></del></p>
                        <h3 class="text-danger">
                            <?php echo MONEDA . ' ' . number_format($precio_desc, 2, ',', '.'); ?>
                            <small class="text-success"> (<?php echo $descuento; ?>% descuento)</small>
                        </h3>
                    <?php } else { ?>
                        <h3 class="text-primary"><?php echo MONEDA . ' ' . number_format($precio, 2, ',', '.'); ?></h3>
                    <?php } ?>

                    <p class="descripcion-producto"><?php echo nl2br(htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8')); ?></p>

                    <div class="d-grid gap-3 mt-4">
                        <button class="btn btn-outline-primary btn-lg" id="btnAgregar" type="button">
                            <i class="fa fa-shopping-cart"></i> Agregar al carrito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="py-5">
    <div class="container">
        <!-- Encabezado -->
        <div class="row">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h6 class="text-warning">Popular</h6>
                    <h2>Juegos en Tendencia</h2>
                </div>
            </div>
        </div>

        <!-- Fila de productos -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 mt-4 g-4" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="2000">
            <?php foreach ($resultadosTendencia as $producto): ?>
                <div class="col d-flex align-items-stretch">
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
                                <img src="<?php echo htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top rounded" alt="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                            </a>
                            <!-- Precio -->
                            <span class="price position-absolute bottom-0 start-0 p-2 text-white bg-dark bg-opacity-75 rounded">
                                <?php echo MONEDA . ' ' . number_format($producto['precio'], 2, ',', '.'); ?>
                            </span>
                        </div>
                        <!-- Contenido -->
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        </div>
                        <!-- Botón de detalles -->
                        <div class="d-flex justify-content-center mt-auto mb-3">
                            <a href="detalles.php?id=<?php echo $producto['id_producto']; ?>&token=<?php echo hash_hmac('sha1', $producto['id_producto'], KEY_TOKEN); ?>" class="btn btn-outline-warning btn-sm me-2">Detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <script>
        // JavaScript para cambiar el fondo del navbar cuando se hace scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled'); // Aplica la clase cuando se hace scroll
            } else {
                navbar.classList.remove('scrolled'); // Elimina la clase cuando se vuelve a la parte superior
            }
        });
        let btnAgregar = document.getElementById("btnAgregar");
        btnAgregar.onclick = function() {
            addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>');
            triggerConfetti();
        };

        function triggerConfetti() {
            confetti({
                particleCount: 100, // Número de partículas
                startVelocity: 30, // Velocidad inicial
                spread: 360, // Ángulo de dispersión
                origin: {
                    x: 0.9, // Coordenadas relativas del origen (90% a la derecha)
                    y: 0.1 // Coordenadas relativas del origen (10% desde arriba)
                }
            });
        }

        function addProducto(id, token) {
            let url = 'clases/carrito.php';
            let formData = new FormData();
            formData.append('id', id);
            formData.append('token', token);

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        // Actualizar el número del carrito
                        let numCart = document.getElementById("num_cart");
                        numCart.innerHTML = data.numero;

                        // Selecciona el ícono del carrito
                        let carrito = document.querySelector(".cart");

                        // Agregar la clase para animación
                        carrito.classList.add('vibrar');

                        // Eliminar la clase después de la animación
                        setTimeout(() => {
                            carrito.classList.remove('vibrar');
                        }, 800); // Duración total de la animación en milisegundos

                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>