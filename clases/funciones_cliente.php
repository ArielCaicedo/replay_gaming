<?php
// Verifica si algún campo en un array es nulo o vacío.
function esNulo(array $parametros)
{
    foreach ($parametros as $parametro) {
        if (strlen(trim($parametro)) === 0) {
            return true;
        }
    }
    return false;
}

// Valida si un email tiene el formato correcto.
function esEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

// Compara dos contraseñas para verificar si son iguales.
function validaPassword($password, $rep_password)
{
    if (strcmp($password, $rep_password) === 0) {
        return true;
    }
    return false;
}

// Genera un token único basado en un hash MD5.
function generaToken()
{
    return md5(uniqid(mt_rand(), false));
}

// Registra un nuevo cliente en la base de datos.
function registrarCliente(array $datos, $pdo)
{
    try { // Inserta un cliente con estatus activo.
        $sql = $pdo->prepare("INSERT INTO clientes (nombre, apellidos, email, telefono, dni, estatus, fecha_alta) VALUES (:nombre, :apellidos, :email, :telefono, :dni, 1, now())");
        $sql->bindParam(':nombre', $datos['nombre']);
        $sql->bindParam(':apellidos', $datos['apellidos']);
        $sql->bindParam(':email', $datos['email']);
        $sql->bindParam(':telefono', $datos['telefono']);
        $sql->bindParam(':dni', $datos['dni']);

        if ($sql->execute()) {
            return $pdo->lastInsertId(); // Retorna el ID del cliente recién insertado.
        }
        return 0;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    }
}

// Registra un nuevo usuario asociado a un cliente.
function registrarUsuario(array $datos, $pdo)
{
    try {
        // Asegúrate de que el id_rol tiene un valor predeterminado de 2
        $sql = $pdo->prepare("INSERT INTO usuarios (usuario, password, token, id_cliente, id_rol) VALUES (:usuario, :password, :token, :id_cliente, :id_rol)");
        $sql->bindParam(':usuario', $datos['usuario']);
        $sql->bindParam(':password', $datos['password']);
        $sql->bindParam(':token', $datos['token']);
        $sql->bindParam(':id_cliente', $datos['id_cliente']);

        // Utiliza el id_rol predeterminado de 2
        $id_rol = 2;
        $sql->bindParam(':id_rol', $id_rol);

        if ($sql->execute()) {
            return $pdo->lastInsertId(); // Retorna el ID del usuario recién creado.
        }
        return 0;
    } catch (PDOException $e) {
        // Manejar cualquier error que ocurra
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Verifica si un nombre de usuario ya existe en la base de datos.
function usuarioExiste($usuario, $pdo)
{

    $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}

// Verifica si un correo electrónico ya está registrado.
function emailExiste($email, $pdo)
{

    $sql = $pdo->prepare("SELECT id_cliente FROM clientes WHERE email LIKE ? LIMIT 1");
    $sql->execute([$email]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}

// Muestra mensajes de error en un formato de alerta Bootstrap.
function mostrarMensajes(array $errores)
{
    if (count($errores) > 0) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><ul>';
        foreach ($errores as $error) {
            echo '<li>' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</li>';
        }
        echo '</ul>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
}

// Valida un token de activación y activa el usuario si es válido.
function validaToken($id, $token, $pdo)
{
    $mensaje = "";
    $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario =? AND token LIKE ? LIMIT 1");
    $sql->execute([$id, $token]);
    $resultado = $sql->fetchColumn();

    // Depuración: Verificar el valor de $resultado
    //var_dump($resultado);

    if ($resultado) {
        if (activarUsuario($id, $pdo)) {
            $mensaje = "Cuenta activada.";
        } else {
            $mensaje = "Error al activar cuenta.";
        }
    } else {
        $mensaje = "No existe el registro de la cuenta.";
    }

    // Depuración: Ver el mensaje
    //echo $mensaje;
    return $mensaje;
}

// Activa la cuenta de un usuario.
function activarUsuario($id, $pdo)
{
    $sql = $pdo->prepare("UPDATE usuarios SET activacion = 1, token = '' WHERE id_usuario = ?");
    $resultado = $sql->execute([$id]);

    return $resultado;
}

// Maneja el inicio de sesión del usuario.
function login($usuario, $password, $pdo, $proceso)
{
    $sql = $pdo->prepare("SELECT id_usuario,usuario,password, id_cliente FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if (esActivo($usuario, $pdo)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['id_usuario'] = $row['id_usuario'];
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['id_cliente'] = $row['id_cliente'];
                if ($proceso == 'pago') {
                    header("Location: checkout.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            }
        } else {
            return 'El usuario no ha sido activado.';
        }
    }
    return 'El usuario y/o contraseña son incorrectos';
}

// Verifica si un usuario está activo.
function esActivo($usuario, $pdo)
{
    $sql = $pdo->prepare("SELECT activacion FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row['activacion'] == 1) {
        return true;
    }
    return false;
}

// Genera un token para solicitar cambio de contraseña.
function solicitaPass($id_user, $pdo)
{
    $token =  generaToken();
    $sql = $pdo->prepare("UPDATE usuarios SET token_password=?, password_request=1 WHERE id_usuario =?");
    if ($sql->execute([$token, $id_user])) {
        return $token;
    }
    return null;
}

// Verifica un token para cambio de contraseña.
function verificaTokenRequest($id_user, $token, $pdo)
{
    $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario = ? AND token_password LIKE ? AND
    password_request= 1 LIMIT 1");
    $sql->execute([$id_user, $token]);
    if ($sql->fetchColumn() > 0) {
        return true;
    }
    return false;
}

// Actualiza la contraseña del usuario.
function actualizaPassword($id_user, $password, $pdo)
{
    $sql = $pdo->prepare("UPDATE usuarios SET password=?, token_password = '', password_request=0 
    WHERE id_usuario = ?");
    if ($sql->execute([$password, $id_user])) {
        return true;
    }
    return false;
}
