<?php
session_start();
$errores = array();
require_once "validacion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim(htmlspecialchars($_POST['user']));
    $pass = trim(htmlspecialchars($_POST['pass']));

    // Validación del usuario
    if (empty($user)) {
        $errores[] = "El campo de usuario está vacío.";
    } elseif (!validarUsuario($user)) {
        $errores[] = "Nombre de usuario no es válido. Debe tener entre 3 y 10 caracteres, y solo contener números y letras.";
    }

    // Validación de la contraseña
    if (empty($pass)) {
        $errores[] = "El campo de contraseña está vacío.";
    } elseif (strlen($pass) !== 5) { // Asegúrate de que la longitud de la contraseña sea la correcta
        $errores[] = "La contraseña debe tener 5 caracteres.";
    }

    if (empty($errores)) {
        require_once("config.php");
        try {
            $pdo = new PDO("mysql:host=" . BBDD_HOST . ";dbname=" . BBDD_NAME, BBDD_USER, BBDD_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT u.id_usuario, u.nombre, u.email, u.contrasena, u.id_rol, r.descripcion 
                      FROM usuarios u
                      JOIN roles r ON u.id_rol = r.id_rol
                      WHERE u.nombre = :user";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $fila = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($pass, $fila['contrasena'])) {
                    $_SESSION['id_usuario'] = $fila["id_usuario"];
                    $_SESSION['nombre'] =  $fila["nombre"];
                    $_SESSION['id_rol'] = $fila['id_rol'];
                    $_SESSION['descripcion'] = $fila['descripcion'];

                    // Registro de log
                    registrar_log($fila['id_usuario'], "Inicio de sesión exitoso.", "El usuario " . $fila['nombre'] . " ha iniciado sesión correctamente.");
                    header("Location: index.php");
                    exit;
                } else {
                    $errores[] = "Usuario o contraseña inválidos. Vuelva a intentarlo.";
                }
            } else {
                $errores[] = "Usuario o contraseña inválidos. Vuelva a intentarlo.";
            }
        } catch (PDOException $e) {
            printf("Conexión fallida: %s\n", $e->getMessage());
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .error {
            list-style-type: none;
            padding: 0;
        }
        .error li {
            color: red;
        }
    </style>
</head>
<body class="login-page">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-container">
            <h1 class="text-center">Iniciar Sesión</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <div class="form-group">
                    <label for="user">Usuario</label>
                    <input type="text" class="form-control" name="user" id="user" required>
                </div>
                <div class="form-group">
                    <label for="pass">Contraseña</label>
                    <input type="password" class="form-control" name="pass" id="pass" required>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary btn-block" value="Iniciar Sesión">
                </div>
            </form>
            <div class="text-center mt-3">
                <p>¿No tienes una cuenta? <a href="registro/registrarse.php">Regístrate aquí</a></p>
            </div>
            <ul class="error mt-3">
                <?php
                if (!empty($errores)) {
                    foreach ($errores as $error) {
                        echo "<li class='text-danger'>$error</li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
