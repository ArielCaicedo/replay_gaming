<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

require '../phpMailer/src/PHPMailer.php';
require '../phpMailer/src/SMTP.php';
require '../phpMailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor para Gmail
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                  // Mostrar salida de depuración
    $mail->isSMTP();                                     // Usar SMTP
    $mail->Host       = MAIL_HOST;                       // Configurar el servidor SMTP para enviar a través de Gmail
    $mail->SMTPAuth   = true;                            // Habilitar autenticación SMTP
    $mail->Username   = MAIL_USERNAME;                   // Tu correo de Gmail
    $mail->Password   = MAIL_PASSWORD;                   // Tu contraseña o contraseña específica para la aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;     // Habilitar encriptación TLS
    $mail->Port       = MAIL_PORT;                       // Puerto TCP para conexión TLS

    // Remitente y destinatario
    $mail->setFrom(MAIL_USERNAME, 'TIENDA JP');
    $mail->addAddress('fabricioar_1991@outlook.com', 'Fabricio'); // Correo y nombre del destinatario
    $mail->addReplyTo('fabricioar_1991@outlook.com');

    // Contenido del correo
    $mail->isHTML(true);                                          // Establecer formato de correo a HTML
    $mail->Subject = 'Detalles de su compra';

    $cuerpo = '<h4>Gracias por su compra</h4>';
    $cuerpo .= '<p>El Id de su compra es: <b>' . $id_transaccion . '</b></p>';

    // Cuerpo del correo
    $mail->Body    = $cuerpo;
    $mail->AltBody = 'Le enviamos el detalle de su compra';

    $mail->setLanguage('es', '../phpMailer/language/phpmailer.lang-es.php');

    // Enviar correo
    $mail->send();
    echo 'El correo ha sido enviado desde Gmail a Outlook';
} catch (Exception $e) {
    echo "Error al enviar el correo electrónico de la compra: {$mail->ErrorInfo}";
}
