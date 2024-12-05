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
    <title>Contáctanos</title>
    <link rel="icon" href="img/icono/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <!-- Contact Page -->
    <div class="contact-page py-5">
        <div class="container">
            <div class="row">
                <!-- Contact Info on the Left -->
                <div class="col-lg-4 mb-4">
                    <div class="p-4 bg-dark rounded shadow">
                        <h6 class="text-uppercase text-warning">Contáctanos</h6>
                        <h2>Hola!</h2>
                        <p>Replay Gaming es tu destino confiable para videojuegos de segunda mano. ¡Déjanos tus dudas o comentarios!</p>
                        <ul class="list-unstyled">
                            <li><strong>Dirección:</strong> Gran Vía, 29, 28013 Madrid</li>
                            <li><strong>Teléfono:</strong> +34 911 793 463</li>
                            <li><strong>Email:</strong> contacto@replaygaming.com</li>
                        </ul>
                    </div>
                </div>

                <!-- Map and Form on the Right -->
                <div class="col-lg-8">
                    <div class="row">
                        <!-- Map -->
                        <div class="col-lg-12 mb-4">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3037.4984849136054!2d-3.7058597234578405!3d40.419959655442014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd42287d85dd4b4f%3A0xac4019c2bdfeb452!2sGran%20V%C3%ADa%2C%2029%2C%20Centro%2C%2028013%20Madrid!5e0!3m2!1ses!2ses!4v1733065980191!5m2!1ses!2ses"
                                width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        </div>
                        <!-- Form -->
                        <div class="col-lg-12 section cta">
                            <form id="contact-form" action="" method="post" class="p-4 bg-light rounded shadow bg-dark">
                                <div class="mb-3">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Tu Nombre..." required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Tu Correo..." required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Asunto...">
                                </div>
                                <div class="mb-3">
                                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Tu Mensaje..."></textarea>
                                </div>
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="En desarrollo, próximamente disponible.">
                                    <!-- Botón con popover para mostrar el mensaje cuando se pase el cursor -->
                                    <button type="submit" class="btn px-4 color text-end" disabled>
                                        Enviar Mensaje
                                    </button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
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

        // Inicializar los popovers de los botones de esta sección
        document.addEventListener('DOMContentLoaded', function() {
            const popoverButtons = document.querySelectorAll('.section.cta [data-bs-toggle="popover"]');
            popoverButtons.forEach(function(button) {
                new bootstrap.Popover(button);
            });
        });
    </script>
</body>

</html>