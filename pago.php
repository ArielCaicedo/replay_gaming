<?php
require_once "config/conexion_pdo.php";
require_once "config/config.php";
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

/* print_r($_SESSION); */
$lista_carrito = array();
if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $query = "SELECT id_producto, nombre, descripcion, precio, descuento,$cantidad AS cantidad
            FROM productos
            WHERE id_producto = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$clave]);
        $lista_carrito[] = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("Location: index.php");
    exit;
}
// Consulta para obtener las ultimas 4 categorías con su imagen asociada
$query = "SELECT c.id_categoria, c.nombre, c.descripcion, p.imagen 
          FROM categorias c
          LEFT JOIN productos p ON c.id_categoria = p.id_categoria
          GROUP BY c.id_categoria
          ORDER BY c.id_categoria DESC
          LIMIT 4";
$stmt = $pdo->prepare($query);
$stmt->execute();
$resultadosCategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

//session_destroy();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Ariel_Caicedo">
    <title>Pago</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>
</head>

<body>
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <main>
        <div class="container my-5">
            <div class="row g-4 align-items-start">
                <!-- Caja de detalles de pago -->
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card shadow-lg rounded-3 p-4 h-100">
                        <h4 class="mb-4 text-center">Método de pago</h4>
                        <div id="paypal-button-container" class="d-flex justify-content-center"></div>
                    </div>
                </div>

                <!-- Caja de productos -->
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <div class="table-responsive h-100">
                        <table class="table table-striped table-hover table-bordered rounded-3">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th class="text-center">Producto</th>
                                    <th class="text-center">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($lista_carrito == null) { ?>
                                    <tr>
                                        <td colspan="2" class="text-center"><b>No hay productos en el carrito</b></td>
                                    </tr>
                                    <?php } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $producto) {
                                        $id = $producto['id_producto'];
                                        $nombre = $producto['nombre'];
                                        $descuento = $producto['descuento'];
                                        $precio = $producto['precio'];
                                        $cantidad = $producto['cantidad'];
                                        $precio_desc = $precio - (($precio * $descuento) / 100);
                                        $subtotal = $cantidad * $precio_desc;
                                        $total += $subtotal;
                                    ?>
                                        <tr>
                                            <td class="align-middle text-center"><?php echo $producto['nombre']; ?></td>
                                            <td class="align-middle text-center">
                                                <?php echo $cantidad . ' x ' . MONEDA . ' ' . '<b>' . number_format($subtotal, 2, '.', ',') . '</b>'; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <!-- Fila de Total -->
                                    <tr class="bg-dark text-white">
                                        <td class="text-end align-middle"><strong>Total</strong></td>
                                        <td class="text-end align-middle">
                                            <p class="h4 mb-0" id="total"><?php echo MONEDA . ' ' . number_format($total, 2, '.', ','); ?></p>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Categorías Principales -->
        <div class="container my-5">
            <div class="row mb-4 text-center">
                <div class="col">
                    <h6 class="text-uppercase text-warning">Categorías</h6>
                    <h2 class="fw-bold">Recomendados</h2>
                </div>
            </div>
            <!-- Cards de categorías -->
            <div class="row g-4">
                <?php foreach ($resultadosCategorias as $categoria): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card border-0 shadow h-100 position-relative">
                            <!-- Enlace a la categoría -->
                            <a href="busqueda.php?categoria=<?php echo $categoria['id_categoria']; ?>" class="d-block">
                                <!-- Imagen de la categoría -->
                                <?php
                                $imagen = "img/" . htmlspecialchars($categoria['imagen'], ENT_QUOTES, 'UTF-8');
                                if (!file_exists($imagen)) {
                                    $imagen = "img/single-game.png"; // Imagen por defecto
                                }
                                ?>
                                <img src="<?php echo $imagen; ?>"
                                    class="card-img-top rounded"
                                    alt="<?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?>"
                                    
                                    loading="lazy">
                            </a>
                            <!-- Título dinámico de la categoría -->
                            <div class="position-absolute top-0 start-0 w-100 bg-primary text-white text-center py-2 opacity-75">
                                <h5 class="mb-0">
                                    <?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </main>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
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

        // Funciones para mostrar y ocultar el spinner
        function showSpinner() {
            document.getElementById("spinner").style.display = "flex";
        }

        function hideSpinner() {
            document.getElementById("spinner").style.display = "none";
        }

        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: "<?php echo number_format($total, 2, '.', ','); ?>"
                        },
                        description: 'Compra tienda RP'
                    }]
                });
            },
            onApprove: function(data, actions) {
                showSpinner(); // Mostrar spinner al iniciar el proceso de aprobación
                let url = 'clases/captura.php';
                actions.order.capture().then(function(detalles) {
                    console.log(detalles);
                    let trans = detalles.purchase_units[0].payments.captures[0].id;
                    return fetch(url, {
                        method: 'POST',
                        mode: 'cors',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            detalles: detalles
                        })
                    }).then(function(response) {
                        hideSpinner(); // Ocultar spinner cuando se complete la transacción
                        window.location.href = "completado.php?key=" + trans;
                    }).catch(function(error) {
                        console.error('Error:', error);
                        hideSpinner(); // Asegúrate de ocultar el spinner incluso si hay un error
                        alert("Ocurrió un error al procesar el pago.");
                    });
                });
            },
            onCancel: function(data) {
                hideSpinner(); // Asegúrate de ocultar el spinner si el usuario cancela
                alert("Pago cancelado");
                console.log(data);
            },
            onError: function(err) {
                hideSpinner(); // Asegúrate de ocultar el spinner en caso de error
                console.error(err);
                alert("Error al procesar el pago");
            }
        }).render('#paypal-button-container');
    </script>

    <div id="spinner" class="spinner-overlay" style="display: none;">
        <div class="spinner-wrapper">
            <i class="fas fa-cog fa-spin fa-3x" style="color: #ffffff;"></i>
            <p class="spinner-text">Procesando tu pago...</p>
        </div>
    </div>

</body>

</html>