$(document).ready(function() {
    $('#forgot-pass-form').submit(function(e) {
        e.preventDefault();

        var form = $(this);

        var input_fields = form.find("input").not(':input[type=submit]');
        var inputs = form.find("input");
        var serializedData = form.serialize();

        inputs.prop("disabled", true);

        var message = '';
        var isError = 0;
        $.ajax({
            method: "POST",
            url: 'handler_forgot_password.php',
            data: serializedData + '&form=forgot',
            error: function(xhr, ajaxOptions, thrownError) {
                isError = 1;
                switch(xhr.status) {
                    case 404:
                        message = "El usuario o email ingresado no existe o la cuenta asociada se encuentra deshabilitada."
                    break;

                    case 409:
                        message = "El usuario ingresado ya ha solicitado recuperar su cuenta en los últimos 5 minutos. Revise su casilla de correo o inténtelo más tarde.";
                        break;

                    default:
                        message = "Se ha producido un error desconocido. Inténtelo nuevamente.";
                }
            },
            success: function(data, textStatus, xhr) {
                message = "Se ha enviado un correo electrónico a " + data + " para que pueda cambiar su contaseña.";
            },
            complete: function() {
                input_fields.val('');

                var formAlert = form.find('.login-alert.native-alert');
                var alertClass = isError ? 'w3-pale-red' : 'w3-pale-green';
                formAlert.removeClass(['w3-pale-green','w3-pale-red']);
                formAlert.addClass(alertClass).html(message).slideDown(250);

                inputs.prop("disabled", false);
            }
        });
    })
});
