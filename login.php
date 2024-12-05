<?php
require_once "config/conexion_pdo.php";
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

    // Validar el token de reCAPTCHA
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
    $secretKey = '6LdKSospAAAAAO2OadDVNj5n3Nka7ByyBaEQwNz6';
    $recaptchaURL = 'https://www.google.com/recaptcha/api/siteverify';

    if (!empty($recaptchaResponse)) {
        // Enviar solicitud a la API de Google reCAPTCHA
        $response = file_get_contents($recaptchaURL . '?secret=' . $secretKey . '&response=' . $recaptchaResponse . '&remoteip=' . $_SERVER['REMOTE_ADDR']);
        $responseKeys = json_decode($response, true);

        // Verificar si la validación fue exitosa
        if (!$responseKeys["success"]) {
            $errores[] = "Error en Google reCAPTCHA. Intenta nuevamente.";
        }
    } else {
        $errores[] = "Por favor, completa el reCAPTCHA.";
    }

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
    <title>Acceso</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style_login.css">
</head>

<body>
    <main>
        <!-- Logotipo en la parte superior izquierda -->
        <div class="row">
            <div class="col-12 text-start py-4">
                <a href="index.php" class="navbar-brand">
                    <img src="img/logotipo/logotipo.png" alt="Replaygaming" class="img-fluid" id="site-logo">
                </a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row min-vh-100">
                <!-- Formulario de Login (Mitad Izquierda) -->
                <div class="col-lg-6 col-12 d-flex justify-content-center align-items-center text-light">
                    <div class="login-container p-4 rounded bg-dark">
                        <h2 class="text-center mb-4">Iniciar Sesión</h2>
                        <?php mostrarMensajes($errores) ?>
                        <form class="row g-3 form-login" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" autocomplete="off">
                            <input type="hidden" name="proceso" value="<?php echo $proceso; ?>">
                            <div class="form-floating fs-6">
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" required>
                                <label class="text-dark" for="usuario">Usuario</label>
                            </div>
                            <div class="form-floating fs-6">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                                <label class="text-dark" for="contraseña">Contraseña</label>
                            </div>
                            <div class="col-12">
                                <a href="recupera_clave.php">¿Olvidaste tu contraseña?</a>
                            </div>
                            <!-- Agregamos el reCAPTCHA -->
                            <div class="g-recaptcha" data-sitekey="6LdKSospAAAAAKogyHN1ajUw1o_gCWG5pfHHbsYD"></div>
                            <br>
                            <div class="d-grid gap-3 col-12">
                                <button type="submit" class="btn btn-warning">Inicia sesión</button>
                            </div>
                            <hr>
                            <div class="col-12">
                                ¿No tienes una cuenta? <a href="registrarse.php">Regístrate aquí</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Imagen a la derecha (Mitad derecha) -->
                <div class="col-lg-6 d-none d-lg-block p-0">
                    <img src="img/fondo_login/login.png" alt="Imagen de login" class="login-image object-cover">
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- Cargar script de Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>