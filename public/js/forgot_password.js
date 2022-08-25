// Copying and pasting from login.js here 
// because native js importing support is "fairly recent"
// TODO: Use require.js??? https://requirejs.org/docs/jquery.html 
var pass_min_chars_cond = false, pass_letter_check_cond = false, pass_num_check_cond = false;
function pass_field_ev (pass_field, pass_tooltip) {
    pass_field.focus(function() {
        pass_tooltip.show(150,"linear");
        $(this).css('background-color','');
    });
    pass_field.blur(function() {
        pass_tooltip.hide(150,"linear");
        if (!pass_min_chars_cond || !pass_letter_check_cond || !pass_num_check_cond)
            $(this).css('background-color','#ff7961');
    })
    pass_field.on('keyup input', function() {
        if ($(this).val().length >= 8) {
            pass_tooltip.children('#min-chars').css('text-decoration', 'none');
            pass_min_chars_cond = true;
        }
        else {
            pass_tooltip.children('#min-chars').css('text-decoration', 'underline');
            pass_min_chars_cond = false;
        }

        if ($(this).val().match(/.*[A-Za-z]+.*/)) {
            pass_tooltip.children('#letter-check').css('text-decoration', 'none');
            pass_letter_check_cond = true;
        }
        else {
            pass_tooltip.children('#letter-check').css('text-decoration', 'underline');
            pass_letter_check_cond = false;
        }
        
        if ($(this).val().match(/.*[0-9]+.*/)) {
            pass_tooltip.children('#num-check').css('text-decoration', 'none');
            pass_num_check_cond = true;
        }
        else {
            pass_tooltip.children('#num-check').css('text-decoration', 'underline');
            pass_num_check_cond = false;
        }
    });
}

var confirm_pass_cond = false;
function confirm_pass_field_ev (pass_field, confirm_pass_field, confirm_pass_tooltip) {
    var confirm_field_focused = false;
    confirm_pass_field.focus(function() {
        if (!confirm_pass_cond)
            confirm_pass_tooltip.show(150,"linear");
        $(this).css('background-color','');
        confirm_field_focused = true;
    });
    confirm_pass_field.blur(function() {
        confirm_pass_tooltip.hide(150,"linear");
        confirm_field_focused = false;
        if (!confirm_pass_cond)
            $(this).css('background-color', '#ff7961');
    });
    pass_field.add(confirm_pass_field).on('keyup input', function() {
        if (pass_field.val() == confirm_pass_field.val()) {
            confirm_pass_field.css('background-color', '');
            confirm_pass_tooltip.hide(150,"linear");
            confirm_pass_cond = true;
        }
        else {
            if (confirm_field_focused)
                confirm_pass_tooltip.show(150,"linear");
            else
                confirm_pass_field.css('background-color', '#ff7961');
            confirm_pass_cond = false;
        }
    });
}

function pass_validate() {
    var form = $('#confirm-pass-form');

    $('#confirm-pass-form input').on('keyup input', function() {
        var continue_button = form.find('input[type="submit"]');
        
        if (pass_min_chars_cond && pass_letter_check_cond &&
            pass_num_check_cond && confirm_pass_cond) {

            continue_button.prop("disabled", false);
        }
        else
            continue_button.prop("disabled", true);
    });

    var pass_tooltip = form.find('#reg-pass-tooltip');
    var pass_field = form.find('#password');
    pass_field_ev(pass_field, pass_tooltip);

    var confirm_pass_tooltip = form.find('#reg-confirm-pass-tooltip');
    var confirm_pass_field = form.find('#confirm-password');
    confirm_pass_field_ev(pass_field, confirm_pass_field, confirm_pass_tooltip);
}

$(document).ready(function() {
    pass_validate();

    $('#forgot-pass-form, #confirm-pass-form').submit(function(e) {
        e.preventDefault();

        var form = $(this);

        var input_fields = form.find("input").not(':input[type=submit]');
        var inputs = form.find("input");
        var serializedData = form.serialize();

        inputs.prop("disabled", true);

        // Parse URL GET parameters
        // https://stackoverflow.com/questions/19491336/how-to-get-url-parameter-using-jquery-or-plain-javascript
        $.urlParam = function(name){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results == null) {
                return null;
            }
            return decodeURI(results[1]) || 0;
        }

        var message = '';
        var isError = 0;
        if (form.attr('id') == 'forgot-pass-form') {
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
        }
        else {
            $.ajax({
                method: "POST",
                url: 'handler_forgot_password.php',
                data: serializedData + '&user_id=' + $.urlParam('user_id') + '&token=' + $.urlParam('token') + '&form=confirm',
                error: function(xhr, ajaxOptions, thrownError) {
                    isError = 1;
                    switch(xhr.status) {
                        case 400:
                            message = "Uno o más argumentos no fueron enviados o son inválidos. Intente la solicitud nuevamente.";
                        break;

                        case 401:
                            message = "El enlace de cambio de contraseña utilizado es inválido o ha expirado. Intente solicitar uno nuevo."
                        break;

                        default:
                            message = "Se ha producido un error desconocido. Inténtelo nuevamente.";
                    }
                },
                success: function(data, textStatus, xhr) {
                    message = "Se ha cambiado su contraseña correctamente. Ahora puede iniciar sesión."
                },
                complete: function() {
                    window.location.replace('login?msg_iserror=' + isError + '&message=' + message);
                }
            });
        }
    })
});
