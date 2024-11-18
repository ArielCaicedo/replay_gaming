<?php
require_once "conexion_pdo.php";
require_once "config/config.php";
require_once "clases/funciones_cliente.php";
$id_user = $_GET['id'] ?? $_POST['id_usuario'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if ($id_user == '' || $token == '') {
    header("Location: index.php");
    exit;
}

$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

$errores = [];

if (!verificaTokenRequest($id_user, $token, $pdo)) {
    echo "No se pudo verificar la informacion.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //var_dump($_POST);
    // Recoger los datos del formulario
    $password = trim(htmlspecialchars($_POST['password']));
    $rep_password = trim(htmlspecialchars($_POST['rep_password']));

    // Verificar que los datos no son nulos o vacíos
    if (esNulo([$id_user, $token, $password, $rep_password])) {
        $errores[] = "Llena todos los campos.";
    }
    if (!validaPassword($password, $rep_password)) {
        $errores[] = "Las contraseñas no coinciden.";
    }


    if (empty($errores)) {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        if (actualizaPassword($id_user, $pass_hash, $pdo)) {
            echo "Contraseña modificada.<br><a href='login.php'>Inicia sesion</a>";
            exit;
        } else {
            $errores[] = "Error al actualizar la contraseña.";
        }
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
        <h3>Cambiar contraseña</h3>
        <?php mostrarMensajes($errores) ?>
        <form class="row g-3" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" autocomplete="off">
            <input type="hidden" name="id_usuario" id="id_usuario" value="<?= htmlspecialchars($id_user); ?>" />
            <input type="hidden" name="token" id="token" value="<?= htmlspecialchars($token); ?>" />

            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="password" placeholder="Nueva contraseña" require>
                <label for="password">Nueva contraseña</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="rep_password" id="rep_password" placeholder="Confirmar contraseña" require>
                <label for="rep_password">Confirmar contraseña</label>
            </div>
            <div class="d-grid gap-3 col-12">
                <button type="submit" class="btn btn-primary">Solicitar</button>
            </div>
            <hr>
            <div class="col-12">
                <a href="login.php">Inicia sesión</a>
            </div>
        </form>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>