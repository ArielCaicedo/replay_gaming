<?php
require_once "config/conexion_pdo.php";
require_once "config/config.php";
require_once "clases/funciones_cliente.php";

// Captura los valores de 'id' y 'token' de la solicitud.
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';

// Si no hay valores válidos, redirige a la página principal.
if ($id == '' || $token == '') {
    header("Location: index.php");
    exit;
}

$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

// Llama a la función 'validaToken'
// Llama a la función 'validaToken' y verifica si es válido
if (validaToken($id, $token, $pdo)) {
    echo "<h1>¡Cuenta activada correctamente!</h1>";
    echo "<p>Ahora puedes iniciar sesión.</p>";
    echo '<a href="login.php" style="text-decoration: none; color: #007bff; font-weight: bold;">Iniciar sesión</a>';
} else {
    echo "<h1>Error al activar la cuenta</h1>";
    echo "<p>El token proporcionado no es válido o ya expiró.</p>";
    echo '<a href="index.php" style="text-decoration: none; color: #007bff; font-weight: bold;">Volver al inicio</a>';
}
