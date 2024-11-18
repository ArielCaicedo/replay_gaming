<?php
require_once "conexion_pdo.php";
require_once "config/config.php";
require_once "clases/funciones_cliente.php";
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

//print_r($_SESSION);
$token = generaToken();
$_SESSION['token'] = $token;
$id_cliente = $_SESSION['id_cliente'];


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
            <h4>Mis compras</h4>
            <hr>
            <?php while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>

                <div class="card mb-3 border-primary">
                    <div class="card-header">
                        <?php echo $row['fecha']; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Folio: <?php echo $row['id_transaccion']; ?></h5>
                        <p class="card-text">Total: <?php echo $row['total']; ?></p>
                        <a href="detalle_compra.php?orden=<?php echo $row['id_transaccion']; ?>&token=<?php echo
                          $token; ?>" class="btn btn-primary">Ver compra</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>