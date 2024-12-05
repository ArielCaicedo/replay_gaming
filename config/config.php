<?php
// Datos de Conexión a BBDD
define("BBDD_HOST", "localhost");
define("BBDD_NAME", "tienda_juegos");
define("BBDD_USER", "root");
define("BBDD_PASSWORD", "");


// Configuracion del sistema
define("SITE_URL", "http://localhost/arielcaicedo/tienda_juegos");
define("KEY_TOKEN", "APR.wqc-354");
define("MONEDA", "€");

// Datos de paypal
define("CLIENT_ID", "AX0wfYdR17NLUAMz4rgU4ThxEdR4w5I6atdpnSz5Rh8B3TbG6UCr9Af83-n7KQGWAvRl_4C3c87Ln7ze");
define("CURRENCY", "EUR");

// Datos para envio de correo electronico
define("MAIL_HOST", "smtp.gmail.com");
define("MAIL_USERNAME", "caicedoariel67@gmail.com");
define("MAIL_PASSWORD", "rvdjrdqsjwnpyntr");
define("MAIL_PORT", 465);

session_start();

$num_cart = 0;
if (isset($_SESSION['carrito']['productos'])) {
    $num_cart = count($_SESSION['carrito']['productos']);
}

