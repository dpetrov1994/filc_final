function downloadZip(){
    console.log("click");
    $('#grupoProgress').removeClass('hidden');
    $.ajax({
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                console.log(evt.lengthComputable); // false
                if (evt.lengthComputable) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        console.log(percentComplete);

                        $('#Eprogressbar').css({
                            width: percentComplete * 100 + '%'
                        });
                        if (percentComplete === 1) {
                            $('#Eprogressbar').css({
                                width: 1+ '%'
                            });
                        }

                    }
                }
            }, false);

            xhr.addEventListener("progress", function (evt) {
                console.log(evt.lengthComputable); // false
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    console.log(percentComplete);
                    $('#Eprogressbar').css({
                        width: percentComplete * 100 + '%'
                    });
                }
            }, false);

            return xhr;
        },
        type: 'GET',
        url: "_download_zip.php",
        success: function (data) {
            $('#grupoProgress').addClass('hidden');
            window.location=data;
        }
    });
}

function downloadBD(){
    console.log("click");
    $('#grupoProgress2').removeClass('hidden');
    $.ajax({
        type: 'GET',
        url: "_dump_mysql.php",
        success: function (data) {
            $('#grupoProgress2').addClass('hidden');
            window.location=data;
        }
    });
}

function criar_backup(){
    window.onbeforeunload = function() {
        return "Tem a certeza que deseja sair da página?";
    };
    $('#grupoProgress3').removeClass('hidden');
    $('#progresso').html("1/2 - A preparar a base de dados...");
    $.ajax({
        type: 'GET',
        url: "_dump_mysql.php?mover",
        success: function (data) {
            repetir(1);
            $.ajax({
                type: 'GET',
                url: "_download_zip.php?completo=&ficheiro="+data,
                success: function (data) {
                    $('#grupoProgress3').addClass('hidden');
                    window.onbeforeunload = null;
                    window.location=data;
                }
            });

        }
    });
}
function repetir(msg){
    if(msg==1){
        $('#progresso').html("2/2 - A comprimir ficheiros...");
        msg=2;
    }else if (msg==2){
        $('#progresso').html("2/2 - Este processo pode demorar alguns minutos...");
        msg=3;
    }else{
        $('#progresso').html("2/2 - Aguarde mais algum tempo...");
        msg=1;
    }
    setTimeout(function(){ repetir(msg) }, 5000);
}

function confirmar_restauro(){
    $("#modal-restauro").modal("toggle");
}

function sim(){
    $("#modal-restauro").modal("toggle");

    $('#progress_restauro').removeClass('hidden');
    $('#progresso2').html("1/2 - A criar ponto de restauro...");
    $.ajax({
        type: 'GET',
        url: "_dump_mysql.php?mover",
        success: function (data) {
            repetir(1);
            $.ajax({
                type: 'GET',
                url: "_download_zip.php?completo=&ficheiro="+data+"&restauro=",
                success: function (data) {
                    document.getElementById('restaurar').click();
                    window.onbeforeunload = function() {
                        return "Tem a certeza que deseja sair da página?";
                    };
                }
            });
        }
    });
}

$("#form-para-validar").data("validator").settings.submitHandler = function (form) {
    repetir2(1);
    $.ajax({
        type: form.method,
        url: form.action,
        data: $(form).serializefiles(),
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            window.onbeforeunload = null;
            $('#progress_restauro').addClass('hidden');
        }
    });
    return false; // required to block normal submit since you used ajax
};

function repetir2(msg){
    if(msg==1){
        $('#progresso2').html("2/2 - A restaurar ficheiros...");
        msg=2;
    }else if (msg==2){
        $('#progresso2').html("2/2 - Este processo pode demorar alguns minutos...");
        msg=3;
    }else{
        $('#progresso2').html("2/2 - Aguarde mais alguns instantes...");
        msg=1;
    }
    setTimeout(function(){ repetir2(msg) }, 5000);
}
