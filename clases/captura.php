<?php
require_once "../conexion_pdo.php";
require_once "../config/config.php";

$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

// Leer los datos JSON enviados al servidor.
$json = file_get_contents('php://input'); // Captura todo el contenido enviado en la petición.
$datos = json_decode($json, true);// Decodificar el JSON a un array PHP.

// Verificar que los datos decodificados sean válidos.
if (is_array($datos)) {
    $id_cliente = $_SESSION['id_cliente'];
    $query = "SELECT email FROM clientes WHERE id_cliente = ? AND estatus = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_cliente]);
    $row_cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    // Extraer los detalles de la transacción desde los datos recibidos.
    $estatus = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    //$correo = $datos['detalles']['payer']['email_address'];
    $correo = $row_cliente['email'];
    //$id_cliente = $datos['detalles']['payer']['payer_id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $id_transaccion = $datos['detalles']['purchase_units'][0]['payments']['captures'][0]['id'];

    try {
        // Insertar la transacción en la tabla `compra`.
        $consulta = "INSERT INTO compra (id_transaccion, fecha, estatus, correo, id_cliente, total, metodo_pago) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($consulta);
        $stmt->execute([$id_transaccion, $fecha_nueva, $estatus, $correo, $id_cliente, $total, 'paypal']);
        $id = $pdo->lastInsertId();

        if ($id > 0) {
            // Obtener los productos del carrito almacenado en la sesión.
            $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
            if ($productos != null) {
                 // Iterar por cada producto en el carrito para guardarlo en `detalle_compra`.
                foreach ($productos as $clave => $cantidad) {
                    $query = "SELECT id_producto, nombre, precio, descuento FROM productos WHERE id_producto = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$clave]);
                    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

                    $precio = $producto['precio'];
                    $descuento = $producto['descuento'];
                    $precio_desc = $precio - (($precio * $descuento) / 100);

                    $query_insert = "INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES (?, ?, ?, ?, ?)";
                    $stmt_insert = $pdo->prepare($query_insert);
                    $stmt_insert->execute([$id, $producto['id_producto'], $producto['nombre'], $precio_desc, $cantidad]);
                }
                require 'Mailer.php'; // Envía el correo

                $asunto = "Detalles de su pedido";
                $cuerpo = '<h4>Gracias por su compra</h4>';
                $cuerpo .= '<p>El Id de su compra es: <b>' . $id_transaccion . '</b></p>';
                
                $mailer = new Mailer();// Instanciar el objeto para envío de correos.
                $mailer->enviarEmail($correo, $asunto, $cuerpo);
            }
            unset($_SESSION['carrito']); // Vaciar el carrito después de registrar la compra.
        } else {
            throw new Exception('Error al insertar en la tabla compra.');
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    } catch (Exception $e) {
        echo "Error general: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
} else {
    echo "Error: Datos no válidos.";
}
