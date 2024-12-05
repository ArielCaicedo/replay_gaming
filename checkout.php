<?php
require_once "config/conexion_pdo.php";
require_once "config/config.php";
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();
if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $query = "SELECT id_producto, nombre, descripcion, precio, descuento, $cantidad AS cantidad
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
    <title>Detalles de Pago</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <!-- Contenido -->
    <main>
        <div class="section trending py-5 bg-light">
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
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
                                                size="5" class="form-control form-control-sm text-center" id="cantidad<?php echo $id; ?>" onchange="actualizaCantidad(this.value, <?php echo $id; ?>)">
                                        </td>
                                        <td>
                                            <div id="subtotal<?php echo $id; ?>" name="subtotal[]">
                                                <?php echo MONEDA . ' ' . number_format($subtotal, 2, '.', ','); ?>
                                            </div>
                                        </td>
                                        <td><button id="eliminar" class="btn btn-danger btn-sm" data-bs-id="<?php echo $id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal"><i class="fa fa-trash"></i> Eliminar</button></td>
                                    </tr>
                                <?php } ?>

                                <tr class="table-active">
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td colspan="2">
                                        <p class="h4 mb-0 text-end" id="total"><?php echo MONEDA . ' ' . number_format($total, 2, '.', ','); ?></p>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($lista_carrito != null) { ?>
                    <div class="row mt-3">
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
    <div class="modal fade text-dark" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
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
    </div>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <!-- Scripts -->
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


        // Función para actualizar la cantidad y subtotal mediante AJAX
        function actualizaCantidad(cantidad, id) {
            let url = 'clases/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('action', 'agregar');
            formData.append('id', id);
            formData.append('cantidad', cantidad);

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let divsubtotal = document.getElementById('subtotal' + id);
                        divsubtotal.innerHTML = data.sub;

                        let total = 0.00;
                        let list = document.getElementsByName('subtotal[]');
                        for (var i = 0; i < list.length; ++i) {
                            total += parseFloat(list[i].innerHTML.replace(/[<?php echo MONEDA ?>,]/g, ''));
                        }
                        total = new Intl.NumberFormat('es-ES', {
                            currency: 'EUR',
                            minimumFractionDigits: 2
                        }).format(total);
                        document.getElementById('total').innerHTML = '<?php echo MONEDA ?>' + total;
                    }
                });
        }

        // Función para eliminar un producto del carrito
        function eliminar() {
            // Aquí cambiamos `botonElimina.value` por `botonElimina.getAttribute('data-bs-id')`
            let botonElimina = document.getElementById('btn-elimina');
            let id = botonElimina.getAttribute('data-bs-id'); 

            let url = 'clases/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('action', 'eliminar');
            formData.append('id', id); // El id correcto es el obtenido del data-bs-id

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        location.reload(); // Recargar la página si la eliminación fue exitosa
                    }
                });
        }
        // Abre el modal con el id correcto del producto
        const eliminarBtns = document.querySelectorAll('[data-bs-toggle="modal"]');
        eliminarBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const idProducto = btn.getAttribute('data-bs-id');
                document.getElementById('btn-elimina').setAttribute('data-bs-id', idProducto);
            });
        });
    </script>
</body>

</html>