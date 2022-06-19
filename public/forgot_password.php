<?php

include '../src/load_env.php';
include '../src/forgot_token_valid.php';

$confirm_pass = false;
if (!empty($_GET['user_id']) && !empty($_GET['token'])) {
    if (!forgot_token_valid(intval($_GET['user_id']), $_GET['token'])) {
        $msg = 'El enlace de cambio de contraseña utilizado es inválido o ha expirado. Intente solicitar uno nuevo.';
        header('Location: ' . URL_ROOT . '/login?msg_iserror=1&message=' . $msg);
        exit();
    }
    else $confirm_pass = true;
}

?>

<!DOCTYPE html>
<html>
    <?php include 'header.php'; ?>

    <body>
        <div class="main-wrapper">
            <?php include 'navbar.php'; ?>

            <div class="site-centered-form">
                <?php if (!$confirm_pass): ?>
                <form class="input-form" id="forgot-pass-form">
                    <div class="login-alert w3-panel native-alert" style="display: none;">
                    </div> 

                    <h1 style="margin-top: 0px;">Recuperar cuenta</h1>

                    <p class="form-description">
                        Te enviaremos un correo electrónico para que puedas cambiar tu contraseña
                    </p>

                    <div>
                        <div class="input-container">
                            <input name="username" type="text" placeholder="Nombre de usuario o email">
                        </div>
                        <input type="submit" value="Continuar" class="button" style="margin-top: 20px; margin-bottom: 10px;">
                    </div>
                </form>
                <?php else: ?>
                <form class="input-form" id="confirm-pass-form">
                    <div class="login-alert w3-panel native-alert" style="display: none;">
                    </div> 

                    <h1 style="margin-top: 0px;">Cambiar contraseña</h1>

                    <p class="form-description">
                        Ingrese una nueva contraseña para su cuenta
                    </p>

                    <div>
                        <div class="input-container">
                            <div class="tooltip-top" id="reg-pass-tooltip">
                                <span id="min-chars">8 caracteres mínimo</span>
                                <br>
                                <span id="letter-check">Al menos 1 letra</span>
                                <br>
                                <span id="num-check">Al menos 1 número</span>
                            </div>
                            <input id="password" name="password" type="password" placeholder="Contraseña">
                        </div>

                        <div class="input-container">
                            <div class="tooltip-top" id="reg-confirm-pass-tooltip">
                                Las contaseñas no coinciden
                            </div>
                            <input id="confirm-password" type="password" placeholder="Confirmar contraseña">
                        </div>

                        <input type="submit" value="Continuar" class="button" style="margin-top: 20px; margin-bottom: 10px;">
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>

    </body>
</html>
