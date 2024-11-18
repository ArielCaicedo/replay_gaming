<?php
require_once "../conexion_pdo.php";
require_once "../config/config.php";
require_once "funciones_cliente.php";

// Inicializar el array de respuesta.
$datos = [];

// Verificar si se envió una acción a través de la solicitud POST.
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $dbConnection = new ConectaBD();
    $pdo = $dbConnection->getConBD();

    // Validar la acción recibida.
    if ($action == 'existeUsuario') {
        $datos['ok'] = usuarioExiste($_POST['usuario'], $pdo);
    } elseif ($action == 'existeEmail') { // Verificar si el correo electrónico existe en la base de datos.
        $datos['ok'] = emailExiste($_POST['email'], $pdo);
    }
}

// Devolver los datos en formato JSON como respuesta.
echo json_encode($datos);
