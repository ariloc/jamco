<!DOCTYPE html>
<html>
    <?php include "header.php"; ?>

    <body>

        <div class="main-wrapper">
            <?php include "navbar.html"; ?>

            <div class="form_login_register">
                <form class="login">
                    <h1 style="margin-top: 40px; margin-bottom: 0px;">Iniciar sesión</h1>
                    <div class="cosa">
        
                        <div class="input-container">
                            <input type="username" placeholder="Nombre de usuario">
                        </div>
                        
                        <div class="input-container">
                            <input type="password" placeholder="Contraseña">
                        </div>

                        <input type="submit" value="Iniciar sesión" class="button" style="margin-top: 20px;margin-bottom: 20px;">

                        <p>Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
                        <p>
                            ¿No tienes una cuenta?
                            <a class="link">Registrate!</a>
                        </p>
                    </div>
                </form>
                 
                <form class="register">
                    <h1 style="margin-top: 40px; margin-bottom: 0px;">Registro</h1>
                    <div class="cosa">
        
                        <div class="input-container">
                            <input type="username" placeholder="Nombre de usuario">
                        </div>

                        <div class="input-container">
                            <input type="username" placeholder="Correo electrónico">
                        </div>
                        
                        <div class="input-container">
                            <input type="password" placeholder="Contraseña">
                        </div>

                        <div class="input-container">
                            <input type="password" placeholder="Confirmar contraseña">
                        </div>
            
                        <input type="submit" value="Registrarse" class="button" style="margin-top: 20px;margin-bottom: 20px;">
                        <p>Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
                    </div>
                </form>
            </div>
            
        </div>
    </body>
</html>
