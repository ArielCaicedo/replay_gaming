<?php
require_once "conexion_pdo.php";
require_once "config/config.php";
require_once "clases/funciones_cliente.php";
$dbConnection = new ConectaBD();
$pdo = $dbConnection->getConBD();

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $email = trim(htmlspecialchars($_POST['email']));



    if (esNulo([$email])) {
        $errores[] = "Todos los campos son obligatorios y no pueden estar vacios.";
    }
    if (!esEmail($email)) {
        $errores[] = "La direccion de correo no es valida.";
    }


    if (empty($errores)) {

        if (emailExiste($email, $pdo)) {
            $sql = $pdo->prepare("SELECT usuarios.id_usuario,clientes.nombre FROM usuarios 
            INNER JOIN clientes ON usuarios.id_cliente = clientes.id_cliente
            WHERE clientes.email LIKE ? LIMIT 1");
            $sql->execute([$email]);
            $row = $sql->fetcH(PDO::FETCH_ASSOC);
            $id_user = $row['id_usuario'];
            $nombre = $row['nombre'];

            $token = solicitaPass($id_user, $pdo);

            if ($token !== null) {
                require 'clases/Mailer.php';
                $mailer = new Mailer();
                $url = SITE_URL . '/restablecer_contraseña.php?id=' . $id_user . '&token=' . $token;

                $asunto = "Recuperar contraseña - Tienda online";
                $cuerpo = "Estimado $nombre: <br>Si has solicitado el cambio de tu contraseña da clic en el
                siguiente link <a href='$url'>$url</a>.";
                $cuerpo .= "<br>Si no hiciste esta solicitud puedes ignorar este correo.";

                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    echo "<p><b>Correo enviado</b></p>";
                    echo "<p>Hemos enviado un correo electronico a la direccion $email
                    para restablecer la contraseña.</p>";
                    exit;
                }
            }
        } else {
            $errores[] = "No hay ningún usuario registrado con la dirección de correo";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Ariel_Caicedo">
    <title>Tienda de juegos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header Area Start -->
    
    <!--Contenido-->
    <main class="form-login m-auto pt-4">
        <h3>Recuperar contraseña</h3>
        <?php mostrarMensajes($errores) ?>
        <form class="row g-3" action="recupera_clave.php" method="post" autocomplete="off">
            <div class="form-floating">
                <input type="email" class="form-control" name="email" id="email" placeholder="Correo electronico" require>
                <label for="email">Correo electronico</label>
            </div>
            <div class="d-grid gap-3 col-12">
                <button type="submit" class="btn btn-primary">Solicitar</button>
            </div>
            <hr>
            <div class="col-12">
                ¿No tienes una cuenta? <a href="registrarse.php">Regístrate aquí</a>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>