<?php
session_start();
ob_start();
require '../config.php'; // Ajusta el path si es necesario
$pdo = getPDOConnection();
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = trim(htmlspecialchars($_POST['nombre']));
    $apellidos = trim(htmlspecialchars($_POST['apellidos']));
    $email = trim(htmlspecialchars($_POST['email']));
    $usuario = trim(htmlspecialchars($_POST['usuario']));
    $direccion = trim(htmlspecialchars($_POST['direccion']));
    $telefono = trim(htmlspecialchars($_POST['telefono']));
    $password = trim(htmlspecialchars($_POST['password']));
    $confirm_password = trim(htmlspecialchars($_POST['confirm_password']));

    // Verificar si las contraseñas coinciden
    if ($password != $confirm_password) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // Consultar el id del rol de usuario normal en la tabla Roles
    try {
        $sqlRol = "SELECT id_rol FROM Roles WHERE nombre = 'usuario' LIMIT 1";
        $stmtRol = $pdo->prepare($sqlRol);
        $stmtRol->execute();
        $id_rol = $stmtRol->fetchColumn();
        if (!$id_rol) {
            $errores[] = "No se encontró el rol de usuario en la base de datos.";
        }
    } catch (PDOException $e) {
        $errores[] = "Error al obtener el rol de usuario: " . $e->getMessage();
    }

    // Validar que el usuario y el correo no existan
    try {
        $sql = "SELECT COUNT(*) FROM Usuarios WHERE usuario = :usuario OR email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario' => $usuario, ':email' => $email]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            $errores[] = "El nombre de usuario o el correo electrónico ya están en uso.";
        }
    } catch (PDOException $e) {
        $errores[] = "Error al verificar usuario o email: " . $e->getMessage();
    }

    // Encriptar la contraseña antes de guardarla
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (empty($errores)) {
        try {
            // Preparar la consulta de inserción
            $sql = "INSERT INTO Usuarios (nombre, apellidos, email, usuario, direccion, telefono, contrasena, id_rol)
                    VALUES (:nombre, :apellidos, :email, :usuario, :direccion, :telefono, :contrasena, :id_rol)";
            $stmt = $pdo->prepare($sql);
            // Ejecutar la consulta
            $stmt->execute([
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':email' => $email,
                ':usuario' => $usuario,
                ':direccion' => $direccion,
                ':telefono' => $telefono,
                ':contrasena' => $hashed_password,
                ':id_rol' => $id_rol
            ]);
            // Redirigir al login tras el registro exitoso
            header("Location: ../login.php");
            exit;
        } catch (PDOException $e) {
            $errores[] = "Error en el registro: " . $e->getMessage();
        }
    }
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="register-page">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card" style="max-width: 400px; width: 100%;">
            <div class="card-body">
                <h2 class="text-center card-title">Crear una cuenta</h2>
                <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ej. Juan" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ej. López" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Ej. juanperez@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" pattern="[a-zA-Z0-9]{3,10}" placeholder="3-10 caracteres alfanuméricos" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Ej. Calle Falsa 123">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Ej. 1234567890">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Crea una contraseña" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Contraseña</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Repite la contraseña" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <p>¿Ya tienes una cuenta? <a href="../login.php">Inicia Sesión</a></p>
                </div>
                <ul class="error mt-3 list-unstyled">
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
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
