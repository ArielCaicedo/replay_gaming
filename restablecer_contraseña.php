<?php
// Incluir los archivos de configuración y las funciones necesarias
require_once "config/conexion_pdo.php";
require_once "config/config.php";
require_once "clases/funciones_cliente.php";

// Obtener los parámetros id_user y token de la URL o del formulario
$id_user = $_GET['id'] ?? $_POST['id_usuario'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

// Verificar que se han proporcionado tanto el id como el token
if ($id_user == '' || $token == '') {
    // Si no se ha proporcionado el id o token, redirigir a la página principal
    header("Location: index.php");
    exit;
}

// Establecer la conexión con la base de datos usando PDO
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

$errores = [];

// Verificar que el token es válido
if (!verificaTokenRequest($id_user, $token, $pdo)) {
    echo "No se pudo verificar la información.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario y limpiarlos
    $password = trim(htmlspecialchars($_POST['password']));
    $rep_password = trim(htmlspecialchars($_POST['rep_password']));

    // Verificar que los campos no están vacíos
    if (esNulo([$id_user, $token, $password, $rep_password])) {
        $errores[] = "Llena todos los campos.";
    }

    // Verificar que las contraseñas coinciden
    if (!validaPassword($password, $rep_password)) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // Si no hay errores, proceder con la actualización de la contraseña
    if (empty($errores)) {
        // Cifrar la nueva contraseña
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);

        // Intentar actualizar la contraseña en la base de datos
        if (actualizaPassword($id_user, $pass_hash, $pdo)) {
            // Si se actualiza correctamente, mostrar mensaje de éxito
            echo "<div class='alert alert-success text-center' role='alert'>
                    <h4 class='alert-heading'>¡Éxito!</h4>
                    <p>La contraseña se ha modificado correctamente.</p>
                    <hr>
                    <p class='mb-0'>Puedes <a href='login.php' class='btn btn-link'>Iniciar sesión aquí</a></p>
                  </div>";
            exit;
        } else {
            // Si no se pudo actualizar la contraseña, agregar error
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
    <title>Restablecer contraseña</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style_login.css">
</head>

<body>
    <main>
         <!-- Logotipo en la parte superior izquierda -->
         <div class="row">
            <div class="col-12 text-start py-2">
                <a href="index.php" class="navbar-brand">
                    <img src="img/logotipo/logotipo.png" alt="Replaygaming" class="img-fluid" id="site-logo">
                </a>
            </div>

        <div class="container-fluid">
            <div class="row min-vh-100">
                <!-- Formulario de Restablecer Contraseña (Mitad Izquierda) -->
                <div class="col-lg-6 col-12 d-flex justify-content-center align-items-center text-light">
                    <div class="login-container p-4 rounded bg-dark">
                        <h3 class="text-center mb-4">Restablecer contraseña</h3>

                        <!-- Mostrar mensajes de error si los hay -->
                        <?php if (!empty($errores)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php foreach ($errores as $error): ?>
                                    <p><?= $error ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Formulario -->
                        <form class="row g-3" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" autocomplete="off">
                            <input type="hidden" name="id_usuario" id="id_usuario" value="<?= htmlspecialchars($id_user); ?>" />
                            <input type="hidden" name="token" id="token" value="<?= htmlspecialchars($token); ?>" />

                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Nueva contraseña" required>
                                <label for="password">Nueva contraseña</label>
                            </div>

                            <div class="form-floating">
                                <input type="password" class="form-control" name="rep_password" id="rep_password" placeholder="Confirmar contraseña" required>
                                <label for="rep_password">Confirmar contraseña</label>
                            </div>

                            <div class="d-grid gap-3 col-12">
                                <button type="submit" class="btn btn-warning">Actualizar contraseña</button>
                            </div>
                        </form>

                        <!-- Enlace para iniciar sesión -->
                        <div class="text-center mt-3">
                            <hr>
                            <p>¿Ya tienes una cuenta? <a href="login.php" class="btn btn-link">Inicia sesión</a></p>
                        </div>
                    </div>
                </div>

                <!-- Imagen a la derecha (Mitad derecha) -->
                <div class="col-lg-6 d-none d-lg-block p-0">
                    <img src="img/fondo_login/login.png" alt="Imagen de restablecer contraseña" class="login-image object-cover">
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>
