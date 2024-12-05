<?php
require_once "config.php";
class conectaBD
{
    protected $db; // Propiedad protegida para almacenar la conexión PDO.
    // Constructor: establece la conexión a la base de datos.
    function __construct()
    {
        $dsn = 'mysql:host=' . BBDD_HOST . ';dbname=' . BBDD_NAME . ';charset=utf8';
        $usuario = BBDD_USER;
        $pass = BBDD_PASSWORD;
        try {
            $this->db = new PDO($dsn, $usuario, $pass);
        } catch (PDOException $e) {
            die("¡Error!: " . $e->getMessage() . "<br/>");
        }
    }
    // Método para obtener la conexión PDO.
    public function getConBD()
    {
        return $this->db;
    }
    // Destructor: libera la conexión a la base de datos.
    public function __destruct() // Cierra conexión asignándole valor null
    {
        $this->db = null;
    }
}
