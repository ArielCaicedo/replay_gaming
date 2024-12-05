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
    <title>Términos y Condiciones - Replay Gaming</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <!-- Terms Section Start -->
    <div class="py-4 bg-dark">
        <div class="container">
            <div class="content-section">
                <!-- Title and Lead -->
                <h1 class="text-center mb-4 text-white fs-3">Términos y Condiciones</h1>
                <p class="lead text-white fs-6">Bienvenido/a a Replay Gaming. Al utilizar nuestro sitio web, aceptas los siguientes términos y condiciones. Si no estás de acuerdo, por favor no utilices nuestro sitio.</p>

                <!-- Information Section -->
                <h2 class="mt-4 text-primary fs-5">1. Información del propietario</h2>
                <p class="text-white fs-6"><strong>Propietario:</strong> Replay Gaming S.L.<br>
                    <strong>Dirección:</strong> Calle Gran Vía, 123, Madrid, España<br>
                    <strong>NIF:</strong> B12345678<br>
                    <strong>Correo electrónico:</strong> <a href="mailto:contacto@replaygaming.com" class="text-decoration-none text-white">contacto@replaygaming.com</a>
                </p>

                <!-- Terms Section -->
                <h2 class="mt-4 text-primary fs-5">2. Uso del sitio web</h2>
                <p class="text-white fs-6">Este sitio web está destinado a la venta de videojuegos de segunda mano. No puedes usar el sitio para fines ilegales ni violar derechos de terceros.</p>

                <h2 class="mt-4 text-primary fs-5">3. Productos y precios</h2>
                <p class="text-white fs-6">Todos los productos están sujetos a disponibilidad. Nos reservamos el derecho de modificar precios sin previo aviso.</p>

                <h2 class="mt-4 text-primary fs-5">4. Compras y devoluciones</h2>
                <ul class="text-white fs-6">
                    <li>Los usuarios deben registrarse para realizar compras.</li>
                    <li>Ofrecemos una garantía de 14 días para devoluciones, siempre que el producto esté en su estado original.</li>
                    <li>Los gastos de envío no son reembolsables.</li>
                </ul>

                <h2 class="mt-4 text-primary fs-5">5. Propiedad intelectual</h2>
                <p class="text-white fs-6">Todo el contenido del sitio web (imágenes, texto, logotipos, etc.) es propiedad de Replay Gaming y está protegido por las leyes de derechos de autor.</p>

                <h2 class="mt-4 text-primary fs-5">6. Limitación de responsabilidad</h2>
                <p class="text-white fs-6">Replay Gaming no será responsable de daños derivados del uso del sitio, incluidos errores técnicos, interrupciones del servicio o virus informáticos.</p>

                <h2 class="mt-4 text-primary fs-5">7. Ley aplicable</h2>
                <p class="text-white fs-6">Estos términos se rigen por la legislación española. Cualquier disputa se resolverá en los tribunales de Madrid.</p>

                <h2 class="mt-4 text-primary fs-5">8. Cambios en los términos</h2>
                <p class="text-white fs-6">Nos reservamos el derecho de actualizar estos términos en cualquier momento. Las actualizaciones serán publicadas en esta página.</p>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
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