<?php
require_once "conexion_pdo.php";
require_once "config/config.php";
require_once "clases/funciones_cliente.php";
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = trim(htmlspecialchars($_POST['nombre']));
    $apellidos = trim(htmlspecialchars($_POST['apellidos']));
    $email = trim(htmlspecialchars($_POST['email']));
    $telefono = trim(htmlspecialchars($_POST['telefono']));
    $dni = trim(htmlspecialchars($_POST['dni']));
    $usuario = trim(htmlspecialchars($_POST['usuario']));
    $password = trim(htmlspecialchars($_POST['password']));
    $rep_password = trim(htmlspecialchars($_POST['rep_password']));

    // Verificar que los datos no son nulos o vacíos
    if (esNulo([$nombre, $apellidos, $email, $telefono, $dni, $usuario, $password, $rep_password])) {
        $errores[] = "Todos los campos son obligatorios y no pueden estar vacios.";
    }
    if (!esEmail($email)) {
        $errores[] = "La direccion de correo no es valida.";
    }
    if (!validaPassword($password, $rep_password)) {
        $errores[] = "Las contraseñas no coinciden.";
    }
    if (usuarioExiste($usuario, $pdo)) {
        $errores[] = "El nombre de usuario $usuario ya existe.";
    }
    if (emailExiste($email, $pdo)) {
        $errores[] = "El correo electronico $email ya existe.";
    }
    /*  if (empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) || empty($dni)) {
        $errores[] = "Todos los campos son obligatorios y no pueden ser nulos.";
    }
 */
    // Depuración: Imprimir los valores capturados
    /* echo "Nombre: $nombre<br>";
    echo "Apellidos: $apellidos<br>";
    echo "Email: $email<br>";
    echo "Teléfono: $telefono<br>";
    echo "DNI: $dni<br>"; */

    if (empty($errores)) {
        $id = registrarCliente([
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'email' => $email,
            'telefono' => $telefono,
            'dni' => $dni
        ], $pdo);

        if ($id > 0) {

            require 'clases/Mailer.php';
            $mailer = new Mailer();
            $token = generaToken();

            $pass_hash = password_hash($password, PASSWORD_DEFAULT);

            $id_usuario = registrarUsuario([
                'usuario' => $usuario,
                'password' => $pass_hash,
                'token' => $token,
                'id_cliente' => $id
            ], $pdo);
            if ($id_usuario > 0) {
                $url = SITE_URL . '/activa_cliente.php?id=' . $id_usuario . '&token=' . $token;
                $asunto = "Activar cuenta - Tienda online";
                $cuerpo = "Estimado $nombre: <br>Para continuar con el proceso de registro es indispensable de click
                en la siguiente liga<a href='$url'> Activar cuenta.</a>";
                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    echo "Para terminar el proceso de registro siga las instrucciones que le hemos enviado
                    a la direccion de correo electronico $email";
                    exit;
                }
            } else {
                $errores[] = "Error al registrar usuario.";
            }
        } else {
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
    <title>Tienda de juegos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header Area Start -->

    <!--Contenido-->
    <main>
        <div class="container">
            <h2>Datos de cliente</h2>
            <?php mostrarMensajes($errores); ?>
            <form class="row g-3 " method="POST" autocomplete="off" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" class="form-control" placeholder="Ej. Juan" requireda>
                </div>
                <div class="col-md-6">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" name="apellidos" id="apellidos" class="form-control" placeholder="Ej. López" requireda>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" name="email" id="email" class="form-control" placeholder="Ej. juanperez@example.com" requireda>
                    <span id="validaEmail" class="text-danger"></span>
                </div>
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" name="telefono" id="telefono" class="form-control" placeholder="Ej. 1234567890">
                </div>
                <div class="col-md-6">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control" name="dni" id="dni" class="form-control" placeholder="3-10 caracteres alfanuméricos" requireda>
                </div>
                <div class="col-md-6">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="usuario" id="usuario" class="form-control" pattern="[a-zA-Z0-9]{3,10}" placeholder="3-10 caracteres alfanuméricos" requireda>
                    <span id="validaUsuario" class="text-danger"></span>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" class="form-control" placeholder="Crea una contraseña" requireda>
                </div>
                <div class="col-md-6">
                    <label for="rep_password" class="form-label">Repetir Contraseña</label>
                    <input type="password" class="form-control" name="rep_password" id="rep_password" class="form-control" placeholder="Repite la contraseña" requireda>
                </div>
                <i><b>Nota:</b>Todos los campos son obligatorios</i>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        let txtUsuario = document.getElementById('usuario');
        txtUsuario.addEventListener('blur', function() {
            existeUsuario(txtUsuario.value);
        }, false);

        let txtEmail = document.getElementById('email');
        txtEmail.addEventListener('blur', function() { // Cambiado de txtUsuario a txtEmail
            existeEmail(txtEmail.value);
        }, false);

        function existeUsuario(usuario) {
            let url = "clases/cliente_ajax.php";
            let formData = new FormData();
            formData.append("action", "existeUsuario");
            formData.append("usuario", usuario);

            console.log("Enviando solicitud para verificar usuario:", usuario);

            fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta recibida:", data);
                    if (data.ok) {
                        document.getElementById('usuario').value = '';
                        document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible';
                    } else {
                        document.getElementById('validaUsuario').innerHTML = '';
                    }
                })
                .catch(error => {
                    console.error("Error al verificar usuario:", error);
                });
        }

        function existeEmail(email) {
            let url = "clases/cliente_ajax.php";
            let formData = new FormData();
            formData.append("action", "existeEmail");
            formData.append("email", email);

            console.log("Enviando solicitud para verificar email:", email);

            fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta recibida:", data);
                    if (data.ok) {
                        document.getElementById('email').value = '';
                        document.getElementById('validaEmail').innerHTML = 'Email no disponible';
                    } else {
                        document.getElementById('validaEmail').innerHTML = '';
                    }
                })
                .catch(error => {
                    console.error("Error al verificar email:", error);
                });
        }
    </script>
</body>

</html>