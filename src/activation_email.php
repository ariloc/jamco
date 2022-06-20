<?php

include_once 'send_email.php';

function send_activation_email (int $id, string $to, string $token) {
    $url = 'https://' . $_SERVER['SERVER_NAME'] . URL_ROOT . '/activate?user_id=' . $id . '&token=' . $token;
    $subject = 'Activación de cuenta';
    $msg = '
    <html>
    <body>
        <p>
            Verifique su registro en Jamco ingresando al siguiente link: <a href="' . $url . '">' . $url . '</a><br>
            <b>El enlace expirará en 2 horas.</b>
        </p>
    </body>
    </html>
    ';

    return send_email($to, $subject, $msg);
}

?>
