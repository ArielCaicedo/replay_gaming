<?php
require_once "conexion_pdo.php";
require_once "config/config.php";
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

//print_r($_SESSION);
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

    <!-- Contenido -->
    <main>
        <div class="section trending py-5 bg-light">
            <div class="container">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($lista_carrito == null) {
                                echo '<tr><td colspan="5" class="text-center">No hay productos en el carrito</td></tr>';
                            } else {
                                $total = 0;
                                foreach ($lista_carrito as $producto) {
                                    $id = $producto['id_producto'];
                                    $nombre = $producto['nombre'];
                                    $precio = $producto['precio'];
                                    $descuento = $producto['descuento'];
                                    $cantidad = $producto['cantidad'];
                                    $precio_desc = $precio - (($precio * $descuento) / 100);
                                    $subtotal = $cantidad * $precio_desc;
                                    $total += $subtotal;
                            ?>
                                    <tr>
                                        <td><?php echo $nombre; ?></td>
                                        <td><?php echo MONEDA . ' ' . number_format($precio_desc, 2, '.', ','); ?></td>
                                        <td>
                                            <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad; ?>"
                                                size="5" id="cantidad<?php echo $id; ?>" onchange="actualizaCantidad(this.value, <?php echo $id; ?>)">
                                        </td>
                                        <td>
                                            <div id="subtotal<?php echo $id; ?>" name="subtotal[]">
                                                <?php echo MONEDA . ' ' . number_format($subtotal, 2, '.', ','); ?> </div>

                                        </td>
                                        <td><a id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo
                                                                                                        $id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a></td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">
                                        <p class="h3" id="total"><?php echo MONEDA . ' ' . number_format($total, 2, '.', ','); ?></p>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!--<div class="row justify-content-end">-->
                <?php if ($lista_carrito != null) { ?>
                    <div class="row">
                        <div class="col-md-5 offset-md-7 d-grid gap-2">
                            <?php if (isset($_SESSION['id_cliente'])) { ?>
                                <a href="pago.php" class="btn btn-primary btn-lg">Pagar</a>
                            <?php } else { ?>
                                <a href="login.php?pago" class="btn btn-primary btn-lg">Pagar</a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar el producto de la lista?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
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
        let eliminaModal = document.getElementById("eliminaModal")
        eliminaModal.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
        })

        function actualizaCantidad(cantidad, id) {
            let url = 'clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action', 'agregar')
            formData.append('id', id)
            formData.append('cantidad', cantidad)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let divsubtotal = document.getElementById('subtotal' + id)
                        divsubtotal.innerHTML = data.sub

                        let total = 0.00
                        let list = document.getElementsByName('subtotal[]')
                        for (var i = 0; i < list.length; ++i) {
                            total += parseFloat(list[i].innerHTML.replace(/[<?php echo MONEDA ?>,]/g, ''))
                        }
                        total = new Intl.NumberFormat('es-ES', {
                            currency: 'EUR',
                            minimumFractionDigits: 2
                        }).format(total)
                        document.getElementById('total').innerHTML = '<?php echo MONEDA ?>' + total
                    }
                })
        }

        function eliminar() {
            let botonElimina = document.getElementById('btn-elimina')
            let id = botonElimina.value

            let url = 'clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action', 'eliminar')
            formData.append('id', id)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        location.reload()
                    }
                })
        }
    </script>
</body>

</html>