<!DOCTYPE html>
<html>
    <?php include "header.php"; ?>

    <body>

        <div class="main-wrapper">
            <?php include "navbar.html"; ?>

            <div class="form_login_register">
                <form id="login-form">
                    <h1 style="margin-top: 40px; margin-bottom: 0px;">Iniciar sesión</h1>
                    <div class="cosa">
        
                        <div class="input-container">
                            <input type="text" placeholder="Nombre de usuario">
                        </div>
                        
                        <div class="input-container">
                            <input type="password" placeholder="Contraseña">
                        </div>

                        <input type="submit" value="Iniciar sesión" class="button" style="margin-top: 20px;margin-bottom: 20px;">

                        <p>Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
                        <p>
                            ¿No tienes una cuenta?
                            <a id="register-lnk">Registrate!</a>
                        </p>
                    </div>
                </form>
                 
                <form id="register-form">
                    <div class="login-alert w3-panel">
                        Hola
                    </div>

                    <h1 style="margin-top: 0px; margin-bottom: 40px;">Registro</h1>
                    <div class="cosa">
        
                        <div class="input-container">
                            <input name="username" type="text" placeholder="Nombre de usuario">
                        </div>

                        <div class="input-container">
                            <input name="email" type="email" placeholder="Correo electrónico">
                        </div>
                        
                        <div class="input-container">
                            <input name="password" id="password" type="password" placeholder="Contraseña">
                        </div>

                        <div class="input-container">
                            <input id="confirm-password" type="password" placeholder="Confirmar contraseña">
                        </div>
            
                        <input type="submit" value="Registrarse" class="button" style="margin: 20px auto;">
                        <p>Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
                    </div>
                </form>
            </div>
            
        </div>
    </body>
</html>
