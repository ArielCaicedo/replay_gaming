<?php
require_once "config/conexion_pdo.php";
require_once "config/config.php";
require_once "clases/funciones_cliente.php";
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

// Token de seguridad
$token = generaToken();
$_SESSION['token'] = $token;
$id_cliente = $_SESSION['id_cliente'];

// Obtener historial de compras
$sql = $pdo->prepare("SELECT id_transaccion, fecha, estatus, total, metodo_pago FROM compra
    WHERE id_cliente = ? ORDER BY DATE(fecha) DESC");
$sql->execute([$id_cliente]);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Ariel_Caicedo">
    <title>Mis Compras</title>
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
            <h4 class="text-center mb-4">Mis Compras</h4>
            <hr>

            <!-- Sección de tarjetas para cada compra -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="col">
                        <div class="card shadow-lg border-primary">
                            <div class="card-header text-white bg-primary">
                                <h5 class="card-title mb-0"><?php echo $row['fecha']; ?></h5>
                            </div>
                            <div class="card-body">
                                <h6 class="card-subtitle mb-3 text-muted">Folio: <?php echo $row['id_transaccion']; ?></h6>
                                <p class="card-text"><strong>Total:</strong> <?php echo MONEDA . ' ' . number_format($row['total'], 2, ',', '.'); ?></p>
                                <p class="card-text"><strong>Método de Pago:</strong> <?php echo $row['metodo_pago']; ?></p>

                                <!-- Estado de la compra -->
                                <p class="card-text">
                                    <strong>Estado:</strong>
                                    <span class="badge <?php echo ($row['estatus'] == 'COMPLETED') ? 'bg-success' : 'bg-warning'; ?>">
                                        <?php echo $row['estatus']; ?>
                                    </span>
                                </p>
                                
                                <!-- Botón para ver la compra -->
                                <a href="detalle_compra.php?orden=<?php echo $row['id_transaccion']; ?>&token=<?php echo $token; ?>" class="btn btn-primary w-100">Ver Compra</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        // JavaScript para cambiar el fondo del navbar cuando se hace scroll
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled'); // Aplica la clase cuando se hace scroll
            } else {
                navbar.classList.remove('scrolled'); // Elimina la clase cuando se vuelve a la parte superior
            }
        });
    </script>
</body>

</html>
