

var ValidarFormulario = function() {

    return {
        init: function() {
            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

            /* Login form - Initialize Validation */
            $('#form-para-validar').validate({
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
                    'nome_plataforma': {
                        required: true,
                        maxlength:21
                    },
                    'nome_empresa': {
                        required: true,
                        maxlength:250
                    },
                    'url': {
                        required: true,
                        url:true,
                        maxlength:250
                    }
                },
                messages: {
                }
            });
        }
    };
}();