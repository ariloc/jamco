var usr_chars_cond = false, usr_typchars_cond = false, usr_stndchars_cond = false;
function username_field_ev (username_field, username_tooltip) {
    username_field.focus(function() {
        username_tooltip.show(150,"linear");
        $(this).css('background-color', '');
    });
    username_field.blur(function() {
        username_tooltip.hide(150,"linear");
        if (!usr_chars_cond || !usr_typchars_cond || !usr_stndchars_cond)
            $(this).css('background-color', '#ff7961');
    });
    username_field.on('keyup input', function() {
        if ($(this).val().length >= 6 && $(this).val().length <= 32) {
            username_tooltip.children('#chars').css('text-decoration','none');
            usr_chars_cond = true;
        }
        else {
            username_tooltip.children('#chars').css('text-decoration','underline');
            usr_chars_cond = false;
        }

        if ($(this).val().match(/^[a-zA-Z0-9_]+$/)) {
            username_tooltip.children('#typchars').css('text-decoration','none');
            usr_typchars_cond = true;
        }
        else {
            username_tooltip.children('#typchars').css('text-decoration','underline');
            usr_typchars_cond = false;
        }

        if ($(this).val().match(/^[a-zA-Z].*[a-zA-Z]$/)) {
            username_tooltip.children('#stndchars').css('text-decoration','none');
            usr_stndchars_cond = true;
        }
        else {
            username_tooltip.children('#stndchars').css('text-decoration','underline');
            usr_stndchars_cond = false;
        }
    });
}

var email_cond = false;
function email_field_ev (email_field, email_tooltip) {
    email_field.focus(function() {
        $(this).css('background-color','');
        if (!email_cond)
            email_tooltip.show(150,"linear");
    });
    email_field.blur(function() {
        email_tooltip.hide(150,"linear");
        if (!email_cond)
            $(this).css('background-color','#ff7961');
    });
    email_field.on('keyup input', function() {
        if ($(this).val().match(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/)) {
            email_tooltip.hide(150,"linear");
            email_cond = true;
        }
        else {
            email_tooltip.show(150,"linear");
            email_cond = false;
        }
    });
}

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

function register_validation() {
    var form = $('#register-form');

    $('#register-form input').on('keyup input', function() {
        var register_button = $('#register-form input[type="submit"]');

        if (usr_chars_cond && usr_typchars_cond && usr_stndchars_cond && 
            email_cond && pass_min_chars_cond && pass_letter_check_cond &&
            pass_num_check_cond && confirm_pass_cond) {
            
            register_button.prop("disabled", false);
        }
        else
            register_button.prop("disabled", true);
    });

    var username_tooltip = form.find('#reg-usr-tooltip');
    var username_field = form.find('input[name="username"]');
    username_field_ev(username_field, username_tooltip);

    var email_tooltip = form.find('#reg-email-tooltip');
    var email_field = form.find('input[name="email"]');
    email_field_ev(email_field, email_tooltip);

    var pass_tooltip = form.find('#reg-pass-tooltip');
    var pass_field = form.find('#password');
    pass_field_ev(pass_field, pass_tooltip);

    var confirm_pass_tooltip = form.find('#reg-confirm-pass-tooltip');
    var confirm_pass_field = form.find('#confirm-password');
    confirm_pass_field_ev(pass_field, confirm_pass_field, confirm_pass_tooltip);
}

$(document).ready(function(){

    $("#register-lnk").click(function(){
        $(".login-alert").hide();
        $("#login-form").hide();
        $("#register-form").show(200);
    });

    $("#login-lnk").click(function(){
        $(".login-alert").hide();
        $("#register-form").hide();
        $("#login-form").show(200);
    });

    register_validation();

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
                url: 'handler_login.php',
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
                url: 'handler_login.php',
                data: serializedData + "&form=login",
                error: function(xhr, ajaxOptions, thrownError) {
                    isError = 1;
                    switch (xhr.status) {
                        case 400:
                            message = "Uno o más argumentos no fueron enviados o son inválidos. Intente la solicitud nuevamente.";
                            break;

                        case 401:
                            message = "El usuario y la contraseña ingresados no coinciden.";
                            break;

                        case 403:
                            message = "Su cuenta se encuentra deshabilitada. Verifique su correo electrónico si no lo ha hecho, o contáctese con el administrador.";
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
                    window.location.replace(window.location.href); // redirect to profile page on success (session should redirect)
                },
                complete: function() {ajax_complete(form, message, isError);}
            });
        }
    });

});
