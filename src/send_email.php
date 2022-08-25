<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../lib/PHPMailer/src/Exception.php';
require '../lib/PHPMailer/src/PHPMailer.php';
require '../lib/PHPMailer/src/SMTP.php';

function send_email (string $to, string $subject, string $msg) {
    $ini_array = parse_ini_file('../creds.ini');
    $smtp_mail = $ini_array['smtp_mail'];
    $smtp_password = $ini_array['smtp_password'];

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0; // 2 for debug, 0 for production
    $mail->CharSet = "UTF-8";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = $smtp_mail;
    $mail->Password = $smtp_password;
    $mail->setFrom($smtp_mail, "Jamco");
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->msgHTML($msg);

    return $mail->send(); 
}

?>
