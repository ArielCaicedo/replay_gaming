<?php
// Incluir los archivos de configuración y las funciones necesarias
require_once "config/conexion_pdo.php";
require_once "config/config.php";
require_once "clases/funciones_cliente.php";

// Establecer la conexión con la base de datos usando PDO
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger el email del formulario y limpiarlo
    $email = trim(htmlspecialchars($_POST['email']));

    // Verificar que el email no esté vacío
    if (esNulo([$email])) {
        $errores[] = "Todos los campos son obligatorios y no pueden estar vacíos.";
    }

    // Validar el formato del email
    if (!esEmail($email)) {
        $errores[] = "La dirección de correo no es válida.";
    }

    // Si no hay errores, proceder con la verificación del email
    if (empty($errores)) {

        // Verificar si el email está registrado en la base de datos
        if (emailExiste($email, $pdo)) {

            // Si el email existe, recuperar el id del usuario y nombre
            $sql = $pdo->prepare("SELECT usuarios.id_usuario, clientes.nombre 
                                  FROM usuarios 
                                  INNER JOIN clientes ON usuarios.id_cliente = clientes.id_cliente 
                                  WHERE clientes.email LIKE ? LIMIT 1");
            $sql->execute([$email]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $id_user = $row['id_usuario'];
            $nombre = $row['nombre'];

            // Solicitar un token de cambio de contraseña para el usuario
            $token = solicitaPass($id_user, $pdo);

            // Si se genera un token, enviar el email para restablecer la contraseña
            if ($token !== null) {
                require 'clases/Mailer.php';  // Incluir la clase Mailer para enviar emails
                $mailer = new Mailer();
                $url = SITE_URL . '/restablecer_contraseña.php?id=' . $id_user . '&token=' . $token;

                // Configuración del correo de recuperación de contraseña
                $asunto = "Recuperar contraseña - Tienda online";
                $cuerpo = "Estimado $nombre: <br>Si has solicitado el cambio de tu contraseña da clic en el
                siguiente link <a href='$url'>$url</a>.";
                $cuerpo .= "<br>Si no hiciste esta solicitud puedes ignorar este correo.";

                // Enviar el correo con el enlace de restablecimiento
                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    // Mensaje de éxito al usuario
                    echo "
                    <div class='alert alert-success' role='alert'>
                        <h4 class='alert-heading'><strong>¡Correo enviado!</strong></h4>
                        <p>Hemos enviado un correo electrónico a la dirección <strong>$email</strong> para restablecer tu contraseña.</p>
                        <hr>
                        <p class='mb-0'>Por favor, revisa tu bandeja de entrada y sigue las instrucciones para recuperar tu contraseña.</p>
                    </div>";
                    exit;
                }
            }
        } else {
            // Si no se encuentra el email en la base de datos
            $errores[] = "No hay ningún usuario registrado con la dirección de correo";
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
    <title>Recuperar contraseña</title>
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
        </div>

        <div class="container-fluid">
            <div class="row min-vh-100">
                <!-- Formulario de Recuperación de Contraseña (Mitad Izquierda) -->
                <div class="col-lg-6 col-12 d-flex justify-content-center align-items-center text-light">

                    <div class="login-container p-4 rounded bg-dark">
                        <h2 class="text-center mb-4">Recuperar Contraseña</h2>
                        <?php mostrarMensajes($errores) ?>
                        <form class="row g-3" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" autocomplete="off">
                            <div class="form-floating col-12 fs-6">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Correo electronico" required>
                                <label for="email" class="form-label text-dark">Correo electronico</label>
                            </div>
                            <div class="d-grid gap-3 col-12">
                                <button type="submit" class="btn btn-warning">Solicitar</button>
                            </div>
                            <hr>
                            <div class="col-12 text-center">
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

</body>

</html>