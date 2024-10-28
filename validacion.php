<?php
// funcion para validar usuario
function validarUsuario($user)
{
    if (preg_match('/^[a-zA-Z0-9]{3,10}$/', $user)) {
        return true;
    } else {
        return false;
    }
}
?>