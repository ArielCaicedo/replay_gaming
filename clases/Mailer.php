<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

class Mailer
{
    function enviarEmail($email, $asunto, $cuerpo)
    {
        require_once __DIR__ . '/../config/config.php';
        require __DIR__ . '/../phpMailer/src/PHPMailer.php';
        require __DIR__ . '/../phpMailer/src/SMTP.php';
        require __DIR__ . '/../phpMailer/src/Exception.php';
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor para Gmail
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                     // Mostrar salida de depuración
            $mail->isSMTP();                                        // Usar SMTP
            $mail->Host       = MAIL_HOST;                          // Configurar el servidor SMTP para enviar a través de Gmail
            $mail->SMTPAuth   = true;                               // Habilitar autenticación SMTP
            $mail->Username   = MAIL_USERNAME;                      // Tu correo de Gmail
            $mail->Password   = MAIL_PASSWORD;                      // Tu contraseña o contraseña específica para la aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        // Habilitar encriptación TLS
            $mail->Port       = MAIL_PORT;                          // Puerto TCP para conexión TLS

            // Remitente y destinatario
            $mail->setFrom(MAIL_USERNAME, 'TIENDA JP');
            $mail->addAddress($email); // Correo y nombre del destinatario

            // Contenido del correo
            $mail->isHTML(true);                                    // Establecer formato de correo a HTML
            $mail->Subject = $asunto;

            $mail->Body    = $cuerpo;
            $mail->setLanguage('es', '../phpMailer/language/phpmailer.lang-es.php');

            // Enviar el correo
            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error al enviar el correo electrónico de la compra: {$mail->ErrorInfo}";
            return false;
        }
    }
}
