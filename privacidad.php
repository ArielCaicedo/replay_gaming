<?php
require_once "config/config.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Ariel_Caicedo">
    <title>Política de Privacidad - Replay Gaming</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <!-- Privacy Policy Section Start -->
    <div class="py-4 bg-dark">
        <div class="container">
            <div class="content-section">
                <!-- Title and Lead -->
                <h1 class="text-center mb-4 fs-3">Política de Privacidad</h1>
                <p class="lead fs-6">En Replay Gaming nos preocupamos por la protección de tus datos personales. Esta política explica cómo recopilamos, usamos y protegemos la información personal que nos proporcionas cuando utilizas nuestro sitio web.</p>

                <!-- Policy Content -->
                <h2 class="mt-4 text-primary fs-5">1. Responsable del Tratamiento</h2>
                <p class="fs-6"><strong>Nombre:</strong> Replay Gaming S.L.<br>
                    <strong>Dirección:</strong> Calle Gran Vía, 123, Madrid, España<br>
                    <strong>Correo electrónico:</strong> <a href="mailto:contacto@replaygaming.com" class="text-decoration-none">privacidad@replaygaming.com</a>
                </p>

                <h2 class="mt-4 text-primary fs-5">2. Datos que Recopilamos</h2>
                <p class="fs-6">Recopilamos los siguientes tipos de datos:</p>
                <ul class="fs-6">
                    <li><strong>Datos de contacto:</strong> nombre, correo electrónico, dirección, teléfono.</li>
                    <li><strong>Datos de navegación:</strong> dirección IP, cookies, historial de navegación en el sitio.</li>
                </ul>

                <h2 class="mt-4 text-primary fs-5">3. Finalidad del Tratamiento</h2>
                <p class="fs-6">Los datos recopilados se utilizan para los siguientes fines:</p>
                <ul class="fs-6">
                    <li>Procesar y gestionar tus compras y envíos.</li>
                    <li>Responder a tus consultas y solicitudes de soporte.</li>
                    <li>Enviar promociones, ofertas y actualizaciones (con tu consentimiento).</li>
                </ul>

                <h2 class="mt-4 text-primary fs-5">4. Compartición de Datos</h2>
                <p class="fs-6">No compartimos tus datos personales con terceros, salvo en los siguientes casos:</p>
                <ul class="fs-6">
                    <li><strong>Proveedores de servicios:</strong> como empresas de mensajería y pago.</li>
                    <li><strong>Cumplimiento legal:</strong> si se requiere por ley o en respuesta a solicitudes de las autoridades competentes.</li>
                </ul>

                <h2 class="mt-4 text-primary fs-5">5. Tus Derechos</h2>
                <p class="fs-6">De acuerdo con la legislación vigente, tienes derecho a:</p>
                <ul class="fs-6">
                    <li>Acceder a tus datos personales y obtener una copia de los mismos.</li>
                    <li>Rectificar datos incorrectos o incompletos.</li>
                    <li>Solicitar la eliminación de tus datos personales, siempre que no exista una obligación legal que lo impida.</li>
                    <li>Oponerte al tratamiento de tus datos o retirar tu consentimiento en cualquier momento.</li>
                </ul>

                <h2 class="mt-4 text-primary fs-5">6. Uso de Cookies</h2>
                <p class="fs-6">Este sitio utiliza cookies para mejorar la experiencia de usuario. Puedes configurar tu navegador para aceptar o rechazar cookies, o bien para recibir una notificación cuando se envíen cookies. Sin embargo, algunas funciones del sitio pueden no funcionar correctamente si desactivas las cookies.</p>

                <h2 class="mt-4 text-primary fs-5">7. Seguridad</h2>
                <p class="fs-6">Implementamos medidas técnicas y organizativas apropiadas para proteger tus datos personales frente a accesos no autorizados, pérdida o destrucción. Sin embargo, debes ser consciente de que ninguna transmisión de datos por Internet es completamente segura.</p>

                <h2 class="mt-4 text-primary fs-5">8. Cambios en esta Política</h2>
                <p class="fs-6">Nos reservamos el derecho de actualizar esta política en cualquier momento. Te notificaremos si realizamos cambios significativos. Te recomendamos revisar esta política periódicamente para estar informado de cómo protegemos tu información.</p>

                <h2 class="mt-4 text-primary fs-5">9. Contacto</h2>
                <p class="fs-6">Si tienes alguna pregunta sobre esta política de privacidad, por favor, no dudes en contactarnos a través de nuestro correo electrónico: <a href="mailto:contacto@replaygaming.com" class="text-decoration-none">privacidad@replaygaming.com</a>.</p>
            </div>
        </div>
    </div>
   

    <!-- footer -->
    <?php include 'footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        // JavaScript para cambiar el fondo del navbar cuando se hace scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled'); // Aplica la clase cuando se hace scroll
            } else {
                navbar.classList.remove('scrolled'); // Elimina la clase cuando se vuelve a la parte superior
            }
        });
    </script>
</body>

</html>