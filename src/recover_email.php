<?php

include_once 'send_email.php';

function send_recover_email (int $id, string $to, string $token) {
    $url = 'https://' . $_SERVER['SERVER_NAME'] . URL_ROOT . '/forgot_password?user_id=' . $id . '&token=' . $token;
    $subject = 'Recuperación de cuenta';
    $msg = '
    <html>
    <body>
        <p>
            Hemos recibido una solicitud para reestablecer su contraseña. Si ha sido usted, siga el siguiente enlace para establecer una nueva clave: <a href="' . $url . '">' . $url .  '</a><br>
            <b>El enlace expirará en 20 minutos.</b> <i>En caso de que haya solicitado reenviar este correo, recuerde que únicamente el último de ellos es válido.</i><br>
            Si no ha realizado esta solicitud, ignore este mensaje. Es posible que alguien haya ingresado su correo electrónico o usuario por error.
        </p>
    </body>
    </html>
    ';

    return send_email($to, $subject, $msg);
}

?>
