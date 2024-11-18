<?php
require_once "../config/config.php";

// Verificar si se recibió el ID del producto a través de la solicitud POST.
if (isset($_POST['id'])) {
    $id = $_POST['id']; // Capturar el ID del producto.
    $token = $_POST['token']; // Capturar el token de seguridad.

    // Generar un token temporal para verificar la validez de la solicitud.
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    // Comparar el token recibido con el generado para evitar manipulaciones.
    if ($token == $token_tmp) {
        if (isset($_SESSION['carrito']['productos'][$id])) { // Verificar si el producto ya está en el carrito.
            $_SESSION['carrito']['productos'][$id] += 1;
        } else {
            $_SESSION['carrito']['productos'][$id] = 1; // Si el producto no existe en el carrito, agregarlo con cantidad inicial 1.
        } // Contar el número total de productos diferentes en el carrito.
        $datos['numero'] = count($_SESSION['carrito']['productos']);
        $datos['ok'] = true;
    } else {
        $datos['ok'] = false;
    }
} else {
    $datos['ok'] = false;
}

// Codificar los datos en formato JSON y devolverlos como respuesta.
echo json_encode($datos);
