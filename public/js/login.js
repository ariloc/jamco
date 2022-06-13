$(document).ready(function(){

    $("#register-lnk").click(function(){
        $(".login-alert").hide();
        $("#login-form").hide();
        $("#register-form").show(200);
    });

    $('#register #password, #register #confirm-password').on('keyup input', function() {
        if ($('#register #password').val() == $('#register #confirm-password').val()) {
           // TODO: Format when passwords don't match 
        }
        else {
            
        }
    });

    $('#login-form, #register-form').submit(function(e) {
        e.preventDefault();

        var form = $(this);

        var inputs = form.find("input, button");
        var serializedData = form.serialize();

        inputs.prop("disabled", true); // disable input while ajax request is being processed

        function ajax_complete(form, message, isError) {
            if (message == '') return;
            
            var formAlert = form.find('.login-alert.native-alert');
            var alertClass = isError ? 'w3-pale-red' : 'w3-pale-green';
            formAlert.removeClass(['w3-pale-green','w3-pale-red']);
            formAlert.addClass(alertClass).html(message).slideDown(250);

            inputs.prop("disabled", false);
        }

        var message = "";
        var isError = 0;
        if (form.attr('id') === 'register-form') {
            $.ajax({
                method: "POST",
                url: '/handler_login.php',
                data: serializedData + "&form=register",
                error: function(xhr, ajaxOptions, thrownError) {
                    isError = 1;
                    switch (xhr.status) {
                        case 400:
                            message = "Uno o más argumentos no fueron enviados o son inválidos. Intente la solicitud nuevamente.";
                            break;

                        case 409:
                            message = "El nombre de usuario y/o el correo electrónico ingresados ya existen."
                            break;

                        default:
                            message = "Se ha producido un error desconocido. Inténtelo nuevamente.";
                    }
                },
                success: function(data, textStatus, xhr) {
                    isError = 0;
                    message = "Se ha enviado un correo electrónico a " + form.find('input[name="email"]').val() + " con un link para que pueda activar su cuenta.";
                },
                complete: function() {ajax_complete(form, message, isError);}
            });
        }
        else {
            $.ajax({
                method: "POST",
                url: '/handler_login.php',
                data: serializedData + "&form=login",
                error: function(xhr, ajaxOptions, thrownError) {
                    isError = 1;
                    switch (xhr.status) {
                        case 400:
                            message = "Uno o más argumentos no fueron enviados o son inválidos. Intente la solicitud nuevamente.";
                            break;

                        case 403:
                            message = "El usuario y la contraseña ingresados no coinciden.";
                            break;

                        case 404:
                            message = "El usuario ingresado no existe.";
                            break;

                        default:
                            message = "Se ha producido un error desconocido. Inténtelo nuevamente.";
                    }
                },
                success: function(data, textStatus, xhr) {
                    isError = 0;
                    message = '';
                    window.location.replace('/'); // redirect to main page on success
                },
                complete: function() {ajax_complete(form, message, isError);}
            });
        }
    });

});
