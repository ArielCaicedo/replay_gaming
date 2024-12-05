<?php
require_once "config/conexion_pdo.php";
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
    <title>Detalle de Compra</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <!--Contenido-->
    <main>
        <div class="container my-5">
            <!-- Título principal -->
            <h2 class="text-center mb-4">Detalle de tu Compra</h2>
            <hr class="mb-4" />

            <div class="row">
                <!-- Información de la compra -->
                <div class="col-12 col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <strong><i class="fas fa-shopping-cart"></i> Información de la Compra</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>Fecha:</strong> <?php echo $fecha; ?></p>
                            <p><strong>Orden:</strong> <?php echo $rowCompra['id_transaccion']; ?></p>
                            <p><strong>Total:</strong> <?php echo MONEDA . ' ' . number_format($rowCompra['total'], 2, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Tabla de productos -->
                <div class="col-12 col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-secondary text-white">
                            <strong><i class="fas fa-box"></i> Productos Comprados</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            <th class="text-start">Producto</th>
                                            <th class="text-start">Precio</th>
                                            <th>Cantidad</th>
                                            <th class="text-start">Subtotal</th>
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
                                                <!-- Columna de Precio con alineación correcta -->
                                                <td class="text-start">
                                                    <span class="d-flex align-items-baseline">
                                                        <span><?php echo MONEDA; ?></span>
                                                        <span><?php echo number_format($precio, 2, ',', '.'); ?></span>
                                                    </span>
                                                </td>
                                                <td class="text-center"><?php echo $cantidad; ?></td>
                                                <!-- Columna de Subtotal con el mismo formato -->
                                                <td class="text-start">
                                                    <span class="d-flex align-items-baseline">
                                                        <span><?php echo MONEDA; ?></span>
                                                        <span><?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón de acción -->
            <!-- Botón para generar PDF -->
            <div class="text-center mt-4">
                <a href="generar_pdf.php?orden=<?php echo $orden; ?>&token=<?php echo $token; ?>" class="btn btn-success">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>
                <a href="compras.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver a Mis Compras</a>
            </div>

        </div>
    </main>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>