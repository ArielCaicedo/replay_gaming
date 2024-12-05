<?php
require_once "config/conexion_pdo.php";
require_once "config/config.php";
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

// Obtener el ID de transacción desde la URL, con un valor predeterminado de 0 si no está presente
$id_transaccion = isset($_GET['key']) ? $_GET['key'] : 0;

$error = '';

// Verificar si el ID de transacción es válido
if ($id_transaccion == '') {
    $error = 'Error al procesar la petición';
} else {
    $query = "SELECT count(id_compra) as count FROM compra WHERE id_transaccion = ? AND estatus=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_transaccion, 'COMPLETED']);
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Si se encuentra al menos un registro, proceder a obtener los detalles
    if ($count > 0) {
        $query = "SELECT id_compra, fecha, correo, total FROM compra WHERE id_transaccion = ? AND estatus=? LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id_transaccion, 'COMPLETED']);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Extraer los datos de la compra
        $id_compra = $resultado['id_compra'];
        $total = $resultado['total'];
        $fecha = $resultado['fecha'];

        // Obtener los detalles de los productos asociados a la compra
        $sqlDet = $pdo->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
        $sqlDet->execute([$id_compra]);
    } else {
        $error = 'Error al comprobar la compra';
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
    <title>Factura</title>
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
        <div class="container my-5">
            <?php if (strlen($error) > 0) { ?>
                <div class="alert alert-danger text-center">
                    <strong>Error:</strong> <?php echo $error; ?>
                </div>
            <?php } else { ?>
                <!-- Información de la compra -->
                <div class="card shadow-lg mb-4" style="border-radius: 10px; border: 1px solid #dee2e6;">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4" style="font-size: 1.75rem; color: #007bff;">Detalles de la compra</h3>
                        <p class="lead"><strong>Folio de la compra: </strong><?php echo $id_transaccion; ?></p>
                        <p class="lead"><strong>Fecha de compra: </strong><?php echo $fecha; ?></p>
                        <p class="h4 font-weight-bold" style="color: #28a745;"><strong>Total: </strong><?php echo MONEDA . ' ' . number_format($total, 2, ',', '.'); ?></p>
                    </div>
                </div>

                <!-- Tabla de productos -->
                <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #dee2e6;">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4" style="font-size: 1.5rem; color: #007bff;">Productos Comprados</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="text-center">Cantidad</th>
                                        <th>Producto</th>
                                        <th class="text-start">Precio</th>
                                        <th class="text-start">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <?php $importe = $row_det['precio'] * $row_det['cantidad']; ?>
                                        <tr>
                                            <td class="text-center"><?php echo $row_det['cantidad']; ?></td>
                                            <td><?php echo $row_det['nombre']; ?></td>
                                            <td class="text-start">
                                                <!-- Columna de Precio con alineación correcta usando Flexbox -->
                                                <span class="d-flex align-items-baseline">
                                                    <span><?php echo MONEDA; ?></span>
                                                    <span><?php echo number_format($row_det['precio'], 2, ',', '.'); ?></span>
                                                </span>
                                            </td>
                                            <td class="text-start">
                                                <!-- Columna de Subtotal con el mismo formato -->
                                                <span class="d-flex align-items-baseline">
                                                    <span><?php echo MONEDA; ?></span>
                                                    <span><?php echo number_format($importe, 2, ',', '.'); ?></span>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>