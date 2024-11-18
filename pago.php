<?php
require_once "conexion_pdo.php";
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

//session_destroy();

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
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>
    <!-- <link rel="stylesheet" href="css/style.css"> -->
</head>

<body>
    <!-- Header Area Start -->
    <?php include 'menu.php'; ?>

    <!-- Contenido -->
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h4>Detalles de pago</h4>
                    <div class="row">
                        <div class="col-10">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Subtotal</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($lista_carrito == null) {
                                    echo '<tr><td colspan="5" class="text-center"<b>No hay productos en el carrito</b></td></tr>';
                                } else {
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
                                            <td><?php echo $producto['nombre']; ?></td>
                                            <td><?php echo $cantidad . ' x ' . MONEDA . ' ' . '<b>' . number_format($subtotal, 2, '.', ',') . '</b>'; ?></td>
                                        </tr>
                                    <?php } ?>

                                    <tr>
                                        <td colspan="2">
                                            <p class="h3 text-end" id="total"><?php echo MONEDA . ' ' . number_format($total, 2, '.', ','); ?></p>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
            <hr class="bg-secondary">
            <div class="text-center">
                <p class="mb-0">&copy; 2024 Realizado por Ariel Caicedo.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
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
                        window.location.href = "completado.php?key=" + trans;
                    });
                });
            },

            onCancel: function(data) {
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container')
    </script>
</body>

</html>