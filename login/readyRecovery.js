/*
 *  Document   : readyLogin.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Login page
 */

var ReadyRecovery = function() {

    return {
        init: function() {
            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

            /* Login form - Initialize Validation */
            $('#form-login').validate({
                errorClass: 'help-block animation-slideUp', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.help-block').remove();
                },
                rules: {
                    'login-password': {
                        required: true,
                        minlength: 5
                    },
                    'login-password2': {
                        required: true,
                        minlength: 4,
                        equalTo: "#login-password"
                    }
                },
                messages: {
                    'login-password': {
                        required: 'Não se esqueça de digitar a sua senha.',
                        minlength: 'A senha tem de ter pelo menos 4 caracteres.'
                    },
                    'login-password2': {
                        required: 'Não se esqueça de digitar a sua senha.',
                        minlength: 'A senha tem de ter pelo menos 4 caracteres.',
                        equalTo: 'Repita a palavra-passe.'
                    }
                }
            });
        }
    };
}();