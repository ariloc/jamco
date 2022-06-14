<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../lib/PHPMailer/src/Exception.php';
require '../lib/PHPMailer/src/PHPMailer.php';
require '../lib/PHPMailer/src/SMTP.php';

function send_activation_email (int $id, string $to, string $token) {
    $ini_array = parse_ini_file('../creds.ini');
    $smtp_mail = $ini_array['smtp_mail'];
    $smtp_password = $ini_array['smtp_password'];

    $url = $_SERVER['SERVER_NAME'] . URL_ROOT . '/activate?user_id=' . $id . '&token=' . $token;

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->CharSet = "UTF-8";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = $smtp_mail;
    $mail->Password = $smtp_password;
    $mail->setFrom($smtp_mail, "Jamco");
    $mail->addAddress($to);
    $mail->Subject = 'Activación de cuenta';
    $mail->msgHTML('
    <html>
    <body>
        Verifique su registro en Jamco ingresando al siguiente link: <a href="' . $url . '">' . $url . '</a> 
    </body>
    </html>
    ');

    return $mail->send(); 
}

?>
