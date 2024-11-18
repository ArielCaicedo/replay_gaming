<?php
require_once "conexion_pdo.php";
require_once "config/config.php";
require_once "clases/funciones_cliente.php";
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

// Determinar si el proceso es 'pago' o 'login', dependiendo de la URL.
$proceso = isset($_GET['pago']) ? 'pago' : 'login';

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $usuario = trim(htmlspecialchars($_POST['usuario']));
    $password = trim(htmlspecialchars($_POST['password']));
    $proceso = $_POST['proceso'] ?? 'login';

    // Verificar que los datos no son nulos o vacíos
    if (esNulo([$usuario, $password])) {
        $errores[] = "Llena todos los campos.";
    }
    // Si no hay errores previos, proceder con el proceso de login.
    if (empty($errores)) {
        $errores[] = login($usuario, $password, $pdo, $proceso);
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

    <!--Contenido-->
    <main class="form-login m-auto pt-4">
        <div class="container">
            <div class="container d-flex justify-content-center align-items-center min-vh-100">
                <div class="login-container">
                    <h2 class="text-center mb-4">Iniciar Sesión</h2>
                    <?php mostrarMensajes($errores) ?>
                    <form class="row g-3" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" autocomplete="off">
                        <input type="hidden" name="proceso" value="<?php echo $proceso; ?>">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" require>
                            <label for="usuario">Usuario</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" require>
                            <label for="contraseña">Contraseña</label>
                        </div>
                        <div class="col-12">
                            <a href="recupera_clave.php">¿Olvidaste tu contraseña?</a>
                        </div>
                        <div class="d-grid gap-3 col-12">
                            <button type="submit" class="btn btn-primary">Inicia sesion</button>
                        </div>
                        <hr>
                        <div class="col-12">
                            ¿No tienes una cuenta? <a href="registrarse.php">Regístrate aquí</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>