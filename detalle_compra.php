<?php
require_once "conexion_pdo.php";
require_once "config/config.php";
require_once "clases/funciones_cliente.php";

// Verifica si se han recibido los parámetros necesarios en la URL.
$token_session = $_SESSION['token'];
$orden = $_GET['orden'] ?? null;
$token = $_GET['token'] ?? null;

// Verificación de seguridad: Si falta algún parámetro o el token no coincide, se redirige al usuario.
if ($orden == null || $token == null || $token != $token_session) {
    header("Location: compras.php");
    exit;
}


$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

// Prepara y ejecuta la consulta para obtener los detalles de la compra por el ID de transacción.
$sqlCompra = $pdo->prepare("SELECT id_compra,id_transaccion, fecha, total FROM compra
    WHERE id_transaccion = ? LIMIT 1");
$sqlCompra->execute([$orden]);
$rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);
$id_compra = $rowCompra['id_compra'];

$fecha = new DateTime($rowCompra['fecha']);
$fecha = $fecha->format('d/m/Y H:i');

// Prepara y ejecuta la consulta para obtener los detalles de los productos comprados.
$sqlDetalle = $pdo->prepare("SELECT id_detcompra, nombre, precio, cantidad FROM detalle_compra
    WHERE id_compra = ?");
$sqlDetalle->execute([$id_compra]);

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
    <!--Contenido-->
    <main>
        <div class="container">
            <h2>Datos de cliente</h2>
            <div class="row">
                <div class="col-12 col-md-4"><!--responsivo-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>Detalle de la compra</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>Fecha: </strong> <?php echo $fecha; ?></p>
                            <p><strong>Orden: </strong> <?php echo $rowCompra['id_transaccion']; ?></p>
                            <p><strong>Total: </strong> <?php echo MONEDA . ' ' . number_format($rowCompra['total'], 2, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)) {
                                    $precio = $row['precio'];
                                    $cantidad = $row['cantidad'];
                                    $subtotal = $precio * $cantidad;
                                ?>
                                    <tr>
                                        <td><?php echo $row['nombre']; ?></td>
                                        <td><?php echo MONEDA . ' ' . number_format($precio, 2, ',', '.'); ?></td>
                                        <td><?php echo $cantidad; ?></td>
                                        <td><?php echo MONEDA . ' ' . number_format($subtotal, 2, ',', '.'); ?></td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>