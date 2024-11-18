<?php
require 'config/config.php';

// Eliminar la sesión del usuario logueado para cerrar la sesión correctamente.
// Esto asegura que las variables de sesión sensibles sean eliminadas.
unset($_SESSION['id_usuario']);
unset($_SESSION['usuario']);
unset($_SESSION['id_cliente']);

// Redirigir al usuario a la página principal después de cerrar la sesión.
// Esto asegura una experiencia de usuario fluida después de desconectarse.
header("Location: index.php");
