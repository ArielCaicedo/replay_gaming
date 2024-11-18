<?php
// Cargar la configuración y la conexión a la base de datos.
require_once "../config/config.php";
require_once "../conexion_pdo.php";

// Verificar si se ha enviado una acción desde el formulario o petición.
if (isset($_POST['action'])) {// Capturar la acción a realizar (agregar o eliminar).
    $action = $_POST['action'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if ($action == 'agregar') {// Acción para agregar productos al carrito.
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = agregar($id, $cantidad);

        // Verificar si la operación fue exitosa.
        if ($respuesta > 0) {
            $datos['ok'] = true;
        } else {
            $datos['ok'] = false;
        }
        // Calcular y devolver el subtotal en formato moneda.
        $datos['sub'] = MONEDA . ' ' . number_format($respuesta, 2, '.', ',');
    } else if ($action == 'eliminar') {
        $datos['ok'] = eliminar($id);
    } else {
        $datos['ok'] = false;
    }
} else {
    $datos['ok'] = false;
}

// Devolver la respuesta en formato JSON.
echo json_encode($datos);

// Función para agregar productos al carrito.
function agregar($id, $cantidad)
{
    $res = 0;
     // Validar que los parámetros sean válidos.
    if ($id > 0 && $cantidad > 0 && is_numeric(($cantidad))) {
        if (isset($_SESSION['carrito']['productos'][$id])) {
            // Actualizar la cantidad del producto en el carrito.
            $_SESSION['carrito']['productos'][$id] = $cantidad;

            $dbConnection = new ConectaBD();
            $pdo = $dbConnection->getConBD();

            // Consultar el precio y descuento del producto.
            $query = "SELECT precio, descuento FROM productos WHERE id_producto = ? LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Calcular el precio con descuento.
            $precio = $resultado['precio'];
            $descuento = $resultado['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
             // Calcular el subtotal.
            $res = $cantidad * $precio_desc;
            return $res;
        }
    } else {
        return $res;
    }
}

// Función para eliminar productos del carrito.
function eliminar($id)
{
    if ($id > 0) {
        if (isset($_SESSION['carrito']['productos'][$id])) {
            unset($_SESSION['carrito']['productos'][$id]);
            return true;
        }
    } else {
        return false;
    }
}
