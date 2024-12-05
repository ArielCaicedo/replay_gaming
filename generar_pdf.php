<?php
require_once 'config/conexion_pdo.php';
require_once 'config/config.php';
require_once 'clases/funciones_cliente.php';
require_once 'tcpdf/tcpdf.php';  // Incluye la librería TCPDF

// Inicia la sesión solo si no está ya iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica si los parámetros de la URL son válidos
$token_session = $_SESSION['token'] ?? null;
$orden = $_GET['orden'] ?? null;
$token = $_GET['token'] ?? null;

// Verificación de seguridad: Si falta algún parámetro o el token no coincide, se redirige al usuario.
if ($orden == null || $token == null || $token != $token_session) {
    header("Location: compras.php");
    exit;
}

$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

// Asegura que las consultas se realicen con la codificación UTF-8
$pdo->exec("SET NAMES 'utf8mb4'");

// Prepara y ejecuta la consulta para obtener los detalles de la compra
$sqlCompra = $pdo->prepare("SELECT id_compra, id_transaccion, fecha, total FROM compra WHERE id_transaccion = ? LIMIT 1");
$sqlCompra->execute([$orden]);
$rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);
if (!$rowCompra) {
    exit; // Detenemos la ejecución si no se encuentra la compra
}

$id_compra = $rowCompra['id_compra'];
$fecha = (new DateTime($rowCompra['fecha']))->format('d/m/Y H:i');

// Prepara y ejecuta la consulta para obtener los detalles de los productos
$sqlDetalle = $pdo->prepare("SELECT id_detcompra, nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
$sqlDetalle->execute([$id_compra]);

// Crear el objeto TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Detalle de tu Compra');
$pdf->SetSubject('Detalle de Compra');

// Configuración básica de la página
$pdf->SetMargins(10, 20, 10); // Márgenes para evitar solapamiento
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('dejavusans', '', 12); // Fuente que soporta UTF-8
$pdf->AddPage();

// Agregar el logo
/* $logoPath = 'img/logotipo.png'; // Cambia esta ruta con la ubicación de tu logo
$pdf->Image($logoPath, 10, 10, 40, 20, 'PNG'); // Cambia las coordenadas y tamaño según sea necesario */

// Título del documento
$pdf->SetFont('dejavusans', 'B', 16);
$pdf->Cell(0, 10, 'Detalle de tu Compra', 0, 1, 'C');
$pdf->Ln(10);

// Información de la compra
$pdf->SetFont('dejavusans', '', 12);
$pdf->Cell(0, 10, 'Fecha: ' . $fecha, 0, 1);
$pdf->Cell(0, 10, 'Orden: ' . $rowCompra['id_transaccion'], 0, 1);
$pdf->Cell(0, 10, 'Total: ' . MONEDA . ' ' . number_format($rowCompra['total'], 2, ',', '.'), 0, 1);
$pdf->Ln(10);

// Detalle de los productos (con mejor formato de tabla)
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->SetFillColor(200, 220, 255); // Color de fondo para la cabecera
$pdf->Cell(90, 10, 'Producto', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Precio', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Subtotal', 1, 1, 'C', 1);

$pdf->SetFont('dejavusans', '', 12);
$pdf->SetFillColor(255, 255, 255); // Color de fondo para las filas
while ($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)) {
    $subtotal = $row['precio'] * $row['cantidad'];
    $pdf->Cell(90, 10, $row['nombre'], 1, 0, 'L', 1);
    $pdf->Cell(30, 10, MONEDA . ' ' . number_format($row['precio'], 2, ',', '.'), 1, 0, 'C', 1);
    $pdf->Cell(30, 10, $row['cantidad'], 1, 0, 'C', 1);
    $pdf->Cell(30, 10, MONEDA . ' ' . number_format($subtotal, 2, ',', '.'), 1, 1, 'C', 1);
}

// Generar el PDF
$pdf->Output('detalle_compra.pdf', 'D');
exit; // Detenemos la ejecución para evitar salida adicional
?>



