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
    // Recoger los datos del formulario y limpiarlos
    $nombre = trim(htmlspecialchars($_POST['nombre']));
    $apellidos = trim(htmlspecialchars($_POST['apellidos']));
    $email = trim(htmlspecialchars($_POST['email']));
    $telefono = trim(htmlspecialchars($_POST['telefono']));
    $dni = trim(htmlspecialchars($_POST['dni']));
    $usuario = trim(htmlspecialchars($_POST['usuario']));
    $password = trim(htmlspecialchars($_POST['password']));
    $rep_password = trim(htmlspecialchars($_POST['rep_password']));

    // Verificar que los datos no sean nulos o vacíos
    if (esNulo([$nombre, $apellidos, $email, $telefono, $dni, $usuario, $password, $rep_password])) {
        $errores[] = "Todos los campos son obligatorios y no pueden estar vacíos.";
    }

    // Validar el formato del correo electrónico
    if (!esEmail($email)) {
        $errores[] = "La dirección de correo no es válida.";
    }

    // Validar que las contraseñas coincidan
    if (!validaPassword($password, $rep_password)) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // Validar el nombre de usuario (con la nueva función validarUsuario)
    if (!validarUsuario($usuario)) {
        $errores[] = "El nombre de usuario no es válido. Debe tener entre 3 y 10 caracteres alfanuméricos.";
    }

    // Verificar si el nombre de usuario ya existe en la base de datos
    if (usuarioExiste($usuario, $pdo)) {
        $errores[] = "El nombre de usuario $usuario ya existe.";
    }

    // Verificar si el correo electrónico ya existe en la base de datos
    if (emailExiste($email, $pdo)) {
        $errores[] = "El correo electrónico $email ya existe.";
    }

    // Validar el número de teléfono
    if (!validarTelefono($telefono)) {
        $errores[] = "El número de teléfono no es válido. Debe tener 9 dígitos.";
    }

    // Validar el DNI
    if (!validarDNI($dni)) {
        $errores[] = "El DNI no es válido. Debe tener 8 dígitos seguidos de una letra.";
    }

    // Si no hay errores, proceder con el registro
    if (empty($errores)) {
        // Registrar al cliente en la base de datos
        $id = registrarCliente([
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'email' => $email,
            'telefono' => $telefono,
            'dni' => $dni
        ], $pdo);

        if ($id > 0) {
            // Si el cliente se registra correctamente, generar el token de activación
            require 'clases/Mailer.php';
            $mailer = new Mailer();
            $token = generaToken();

            // Cifrar la contraseña del usuario antes de almacenarla
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);

            // Registrar al usuario en la base de datos
            $id_usuario = registrarUsuario([
                'usuario' => $usuario,
                'password' => $pass_hash,
                'token' => $token,
                'id_cliente' => $id
            ], $pdo);

            // Si el usuario se registra correctamente
            if ($id_usuario > 0) {
                // Generar el enlace para activar la cuenta
                $url = SITE_URL . '/activa_cliente.php?id=' . $id_usuario . '&token=' . $token;
                $asunto = "Activar cuenta - Tienda online";
                $cuerpo = "Estimado $nombre: <br>Para continuar con el proceso de registro es indispensable que haga click
                en el siguiente enlace <a href='$url'>Activar cuenta.</a>";

                // Enviar el correo de activación al usuario
                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    // Mostrar un mensaje de éxito
                    echo "Para terminar el proceso de registro, siga las instrucciones que le hemos enviado
                    a la dirección de correo electrónico $email.";
                    exit;
                }
            } else {
                // Si no se pudo registrar el usuario, agregar el error
                $errores[] = "Error al registrar usuario.";
            }
        } else {
            // Si no se pudo registrar el cliente, agregar el error
            $errores[] = "Error al registrar cliente.";
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
    <title>Registro de cliente</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style_login.css">

</head>

<body>
    <main>
        <!-- Logotipo -->
        <div class="logo-container mb-3 text-center text-md-start py-4">
            <a href="index.php" class="navbar-brand">
                <img src="img/logotipo/logotipo.png" alt="Replaygaming" id="site-logo">
            </a>
        </div>
        <div class="container-fluid">
            <div class="row min-vh-100">
                <!-- Columna del formulario de Registro -->
                <div class="col-lg-6 col-12 d-flex justify-content-center align-items-center text-light">
                    <!-- Formulario de registro -->
                    <div class="login-container p-4 rounded bg-dark w-100">
                        <h2 class="text-center mb-4">Registrarse</h2>
                        <?php mostrarMensajes($errores); ?>
                        <form class="row g-3 form-login fs-6" method="post" autocomplete="off" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                            <div class="form-floating col-6 fs-6">
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ej. Juan" value="<?= isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" require>
                                <label for="nombre" class="form-label text-dark">Nombre</label>
                            </div>
                            <div class="form-floating col-6 fs-6">
                                <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ej. López" value="<?= isset($_POST['apellidos']) ? $_POST['apellidos'] : ''; ?>" require>
                                <label for="apellidos" class="form-label text-dark">Apellidos</label>
                            </div>
                            <div class="form-floating col-6 fs-6">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Ej. juanperez@example.com" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>" require>
                                <label for="email" class="form-label text-dark">Tu email</label>
                                <span id="validaEmail" class="text-danger"></span>
                            </div>
                            <div class="form-floating col-6 fs-6">
                                <input type="tel" class="form-control" name="telefono" id="telefono" placeholder="Ej. 1234567890" value="<?= isset($_POST['telefono']) ? $_POST['telefono'] : ''; ?>" require>
                                <label for="telefono" class="form-label text-dark">Teléfono</label>
                            </div>
                            <div class="form-floating col-6 fs-6">
                                <input type="text" class="form-control" name="dni" id="dni" placeholder="3-10 caracteres alfanuméricos" value="<?= isset($_POST['dni']) ? $_POST['dni'] : ''; ?>" require>
                                <label for="dni" class="form-label text-dark">DNI</label>
                            </div>
                            <div class="form-floating col-6 fs-6">
                                <input type="text" class="form-control" name="usuario" id="usuario" pattern="[a-zA-Z0-9]{3,10}" placeholder="3-10 caracteres alfanuméricos" value="<?= isset($_POST['usuario']) ? $_POST['usuario'] : ''; ?>" require>
                                <label for="usuario" class="form-label text-dark">Usuario</label>
                                <span id="validaUsuario" class="text-danger"></span>
                            </div>
                            <div class="form-floating col-6 fs-6">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Crea una contraseña" require>
                                <label for="password" class="form-label text-dark">Contraseña</label>
                            </div>
                            <div class="form-floating col-6 fs-6">
                                <input type="password" class="form-control" name="rep_password" id="rep_password" placeholder="Repite la contraseña" require>
                                <label for="rep_password" class="form-label text-dark">Repetir Contraseña</label>
                            </div>
                            <i><b>Nota:</b> Todos los campos son obligatorios</i>
                            <div class="col-12">
                                <button type="submit" class="btn btn-warning w-100">Registrarse</button>
                            </div>
                            <div class="col-12 mt-3 text-center">
                                <a href="login.php" class="btn btn-outline-danger w-100">Volver atras</a>
                            </div>
                        </form>
                    </div>

                </div>

                <!-- Imagen de fondo a la derecha en pantallas grandes -->
                <div class="col-lg-6 d-none d-lg-block p-0">
                    <img src="img/fondo_login/login.png" alt="Imagen de registro" class="login-image">
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="js/validacion_registro.js">
    </script>
</body>

</html>