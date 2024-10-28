<?php
//Conexión a BBDD
const BBDD_HOST = "localhost";
const BBDD_NAME = "tienda_juegos";
const BBDD_USER = "user_tienda";
const BBDD_PASSWORD = "dejvGqje9iEsv@!1";

function getPDOConnection()
{
    $dsn = 'mysql:host=' . BBDD_HOST . ';dbname=' . BBDD_NAME . ';charset=utf8';
    try {
        $pdo = new PDO($dsn, BBDD_USER, BBDD_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Conexión fallida: " . $e->getMessage());
    }
}

//Funcion para registrar logs en la base de datos
function registrar_log($id_usuario, $accion, $detalles = null)
{
    try {
        $pdo = getPDOConnection();
        // fecha y hora actual
        $fecha = date('Y-m-d H:i:s');

        $sql = "INSERT INTO logs (id_usuario, accion, fecha, detalles) VALUES (:id_usuario, :accion, :fecha, :detalles)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':accion', $accion, PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':detalles', $detalles, PDO::PARAM_STR);

        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error al registrar el log: " . $e->getMessage();
        return false;
    }
}
