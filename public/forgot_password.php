<!DOCTYPE html>
<html>
    <?php include 'header.php'; ?>

    <body>
        <div class="main-wrapper">
            <?php include 'navbar.php'; ?>

            <div class="site-centered-form">
                <form class="input-form" id="forgot-pass-form">
                    <div class="login-alert w3-panel native-alert" style="display: none;">
                    </div> 

                    <h1 style="margin-top: 0px;">Recuperar cuenta</h1>

                    <p style="margin-bottom: 20px;">
                        Te enviaremos un correo electrónico para que puedas cambiar tu contraseña.
                    </p>

                    <div>
                        <div class="input-container">
                            <input name="username" type="text" placeholder="Nombre de usuario o email">
                        </div>
                        <input type="submit" value="Continuar" class="button" style="margin-top: 20px; margin-bottom: 10px;">
                    </div>
                </form>
            </div>
        </div>

    </body>
</html>
