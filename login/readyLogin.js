/*
 *  Document   : readyLogin.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Login page
 */

var ReadyLogin = function() {

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
                submitHandler: function(form) {
                    loginAnimation();
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            //alert(response);
                            setTimeout(function(){
                                if(response==0){
                                window.location="../index.php";
                                }else if(response==1){
                                    window.location="index.php?cod=1&email="+$("#login-email").val();
                                }else if(response==2){
                                    window.location="index.php?cod=2";
                                }else if(response==3){
                                    window.location="index.php?cod=3";
                                }else if(response==4){
                                    window.location="index.php?cod=4";
                                }else{
                                    window.location="index.php?cod=5";
                                }
                            }, 1500);
                        }
                    });
                },
                rules: {
                    'login-email': {
                        required: true,
                    },
                    'login-password': {
                        required: true,
                        minlength: 4
                    }
                },
                messages: {
                    'login-email': 'Por favor insira o email da sua conta.',
                    'login-password': {
                        required: 'Não se esqueça de digitar a sua senha.',
                        minlength: 'A senha tem de ter pelo menos 5 caracteres.'
                    }
                }
            });
        }
    };
}();

function loginAnimation(){
    $('<iframe src="../assets/loading-animation/index.php" style="width: 100%; height: 100%; position: fixed; padding: 0px; margin: 0px; top: 0px; left: 0px;border: none" id="loading-animation"></iframe>').appendTo('#login-container');
}

function loginCountdown(){
    var counter = 6;
    var loginCount = setInterval(function() {
        counter--;
        if(counter<10){
            counter="0"+counter;
        }
        //document.getElementById("countdown").innerHTML="<i class='fa fa-lock'></i> A sua sessão vai iniciar em "+counter+" segundos. <a href='index.php?unsetLoginCookie'>Cancelar</a>";
        document.getElementById("countdown").innerHTML='<div class="alert alert-success alert-dismissable"><h4><i class="fa fa-lock"></i> Entrar em: '+counter+' seg.</h4><p><a href="index.php?unsetLoginCookie" class="alert-link">Cancelar</a></p></div>';
        if (counter == 0) {
            // Display a login box
            document.getElementById("bnt_entrar").click();
            clearInterval(loginCount);
        }
    }, 1000);
}

function login(){
    document.getElementById("bnt_entrar").click();
}

