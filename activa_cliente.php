<?php
require_once "conexion_pdo.php";
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
validaToken($id, $token,$pdo);
