<?php 

namespace Classes;

// PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

        // Crear instancia de PHP Mailer
        $mail = new PHPMailer();
        // Configurar SMTP.
        // Configuración que nos proporciona MailTrap
        $mail->isSMTP(); // Método para indicar que se va utilizar SMTP
        // Información del servidor de correo. Mailtrap
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '56fe52cf3bf3dc';
        $mail->Password = 'd484ae6ee1de7f';
        // Seguridad
        $mail->SMTPSecure = 'tls';

        // Configurar el contenido del email
        // Cabecera del mensaje
        $mail->setFrom('hola@appsalon.com'); // El que envia el email
        $mail->addAddress('contacto@appsalon.com', 'AppSalon.com'); // Email al que va llegar el correo
        $mail->Subject = 'Confirma tu cuenta'; // Sujeto del email

        // Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8'; // Habilitar caracteres especiales

        // Cuerpo del mensaje
        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>" . $this->nombre . "</strong> Has creado tu cuenta en AppSalon.com, sólo debes confirmarla presionando el siguiente enlace: </p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token ."'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->AltBody = 'Esto es texto alternativo sin HTML';

        // Enviar el email
        if($mail->send()) { // $mail->send() retorna un TRUE o FALSE dependiendo si se envió el email
            echo 'Mensaje enviado correctamente';
        } else {
            echo 'El mensaje no se pudo enviar';
        };
    }

    public function enviarRestablecer() {
         // Crear instancia de PHP Mailer
         $mail = new PHPMailer();
         // Configurar SMTP.
         // Configuración que nos proporciona MailTrap
         $mail->isSMTP(); // Método para indicar que se va utilizar SMTP
         // Información del servidor de correo. Mailtrap
         $mail->Host = 'sandbox.smtp.mailtrap.io';
         $mail->SMTPAuth = true;
         $mail->Port = 2525;
         $mail->Username = '56fe52cf3bf3dc';
         $mail->Password = 'd484ae6ee1de7f';
         // Seguridad
         $mail->SMTPSecure = 'tls';
 
         // Configurar el contenido del email
         // Cabecera del mensaje
         $mail->setFrom('hola@appsalon.com'); // El que envia el email
         $mail->addAddress('contacto@appsalon.com', 'AppSalon.com'); // Email al que va llegar el correo
         $mail->Subject = 'Solicitud Restablecer Contraseña'; // Sujeto del email
 
         // Habilitar HTML
         $mail->isHTML(true);
         $mail->CharSet = 'UTF-8'; // Habilitar caracteres especiales
 
         // Cuerpo del mensaje
         $contenido = "<html>";
         $contenido .= "<p>Hola <strong>" . $this->nombre . "</strong> Has solicitado restablecer tu contraseña, sólo debes presionar el siguiente enlace para crear otra contraseña: </p>";
         $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/recuperar-password?token=" . $this->token ."'>Restablecer Contraseña</a></p>";
         $contenido .= "<p>Si tu no solicitaste restablecer la contraseña, puedes ignorar el mensaje</p>";
         $contenido .= "</html>";
 
         $mail->Body = $contenido;
         $mail->AltBody = 'Solicitud restablecer contraseña';
 
         // Enviar el email
         if(!$mail->send()) { // $mail->send() retorna un TRUE o FALSE dependiendo si se envió el email
            echo 'Ocurrió un error al enviar el mensaje: ', $mail->ErrorInfo;  
         };
    }
}