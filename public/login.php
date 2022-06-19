<?php

include_once '../src/session.php';
include_once '../src/load_env.php';

list($id, $usr) = retrieve_session();
if ($id > 0) {
    header('Location: ' . URL_ROOT . '/profile');
    exit();    
}

// TODO: Put all the following code inside a function?
$login_display1 = 'block';
$login_display2 = 'none';
$alert1 = '';
$alert2 = '';

if (!empty($_GET['message'])) {
    $alert_color = !empty($_GET['msg_iserror']) && $_GET['msg_iserror'] == '1' ? 'w3-pale-red' : 'w3-pale-green';
    $msg = $_GET['message'];
    $alert_div = " 
        <div class=\"login-alert w3-panel $alert_color\">
            $msg
        </div>
    ";
    $alert1 = $alert_div;
    if (!empty($_GET['register'] && $_GET['register'] == '1')) {
        $login_display1 = 'none'; $alert1 = '';
        $login_display2 = 'block'; $alert2 = $alert_div;
    }
}
?>

<!DOCTYPE html>
<html>
    <?php include "header.php"; ?>

    <body>

        <div class="main-wrapper">
            <?php include "navbar.php"; ?>

            <div class="site-centered-form">
                <form class="input-form" id="login-form" style="display: <?php echo $login_display1 ?>">
                    <?php echo $alert1; ?>

                    <div class="login-alert w3-panel native-alert" style="display: none;">
                    </div>

                    <h1 style="margin-top: 0px; margin-bottom: 40px;">Iniciar sesión</h1>
                    <div>
                        <div class="input-container">
                            <input name="username" type="text" placeholder="Nombre de usuario">
                        </div>
                        
                        <div class="input-container">
                            <input name="password" type="password" placeholder="Contraseña">
                        </div>

                        <input type="submit" value="Iniciar sesión" class="button" style="margin-top: 20px;margin-bottom: 20px;">

                        <p>
                            <a href="forgot_password">¿Olvidaste tu contraseña?</a>
                        </p>
                        <p>
                            ¿No tienes una cuenta?
                            <a class="lnk-pointer" id="register-lnk">Registrate!</a>
                        </p>
                    </div>
                </form>
                 
                <form class="input-form" id="register-form" style="display: <?php echo $login_display2; ?>">
                    <?php echo $alert2; ?>

                    <div class="login-alert w3-panel native-alert" style="display: none;">
                    </div>

                    <h1 style="margin-top: 0px; margin-bottom: 40px;">Registro</h1>
                    <div class="cosa">
        
                        <div class="input-container">
                            <div class="tooltip-top" id="reg-usr-tooltip">
                                <span id="chars">6-32 caracteres</span>
                                <br>
                                <span id="typchars">Alfanuméricos o guiones bajos</span>
                                <br>
                                <span id="stndchars">El primer y último caracter deben ser letras</span>
                            </div>
                            <input name="username" type="text" placeholder="Nombre de usuario" autocomplete="off">
                        </div>

                        <div class="input-container">
                            <div class="tooltip-top" id="reg-email-tooltip">
                                Ingrese un correo electrónico válido
                            </div>
                            <input name="email" type="email" placeholder="Correo electrónico" autocomplete="off">
                        </div>
                        
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
            
                        <input type="submit" value="Registrarse" class="button" disabled="disabled" style="margin: 20px auto;">
                        <p>Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
                        <p>
                            ¿Ya tienes una cuenta?
                            <a class="lnk-pointer" id="login-lnk">Logueate!</a>
                        </p>
                    </div>
                </form>
            </div>
            
        </div>
    </body>
</html>
