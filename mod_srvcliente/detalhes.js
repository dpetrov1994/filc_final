//$('.todas-notas-parent').scrollTop($('.todas-notas-parent')[0].scrollHeight);

let arrDivs = [];
let i =0;







$('.arrow-down-trigger').click(function (){
    //$(this).prev().toggle('slow');

    if($(this).hasClass('div-expanded')){
        $(this).css('transform','rotate(0deg)')
        $(this).removeClass('div-expanded');
    }else{
        $(this).css('transform','rotate(180deg)')
        $(this).addClass('div-expanded');

    }

})


if($('.my-gallery .csscheckbox')[0] == undefined){
    $('.eliminar-documentos').remove();
    $('.dropzoneDocumentos').css('width','100%');

}


function ajaxAlfabetico(idCliente){
    var alfaberico=document.getElementById("alfabetico").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText!=0){
                growlNot("warning","<i class='fa fa-warning'></i> Erro ao gravar alteração.");
                //console.log(this.responseText);
            }
        }
    };
    xmlhttp.open("GET", "../mod_srvcliente/_saveAlfabetico.php?idCliente=" + idCliente+"&alfabetico="+alfaberico, true);
    xmlhttp.send();
}


function ajaxTempo(idCliente){
    var tempo=document.getElementById("tempo").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.responseText!=0){
            growlNot("warning","<i class='fa fa-warning'></i> Erro ao gravar alteração.");
            //console.log(this.responseText);
        }else{
            growlNot("success","<i class='fa fa-check'></i>");
        }
    };
    xmlhttp.open("GET", "../mod_srvcliente/_saveTempo.php?idCliente=" + idCliente+"&tempo="+tempo, true);
    xmlhttp.send();
}
function ajaxKms(idCliente){
    var kms=document.getElementById("kms").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText!=0){
                growlNot("warning","<i class='fa fa-warning'></i> Erro ao gravar alteração.");
                console.log(this.responseText);
            }else{
                growlNot("success","<i class='fa fa-check'></i>");
            }
        }
    };
    xmlhttp.open("GET", "../mod_srvcliente/_saveKms.php?idCliente=" + idCliente+"&kms="+kms, true);
    xmlhttp.send();
}

function ajaxGrupo(idCliente){
    var grupo=document.getElementById("grupo").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText!=0){
                growlNot("warning","<i class='fa fa-warning'></i> Erro ao gravar alteração.");
                //console.log(this.responseText);
            }
        }
    };
    xmlhttp.open("GET", "../mod_srvcliente/_saveGrupo.php?idCliente=" + idCliente+"&grupo="+grupo, true);
    xmlhttp.send();
}


function mudarCorNota(id,cor) {
    $("#nota"+id).css("background-color",cor).attr("data-cor",cor);
}

function criarNota(idCliente){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $("#notas").prepend(this.responseText);
        }
    };
    xmlhttp.open("GET", "../mod_srvcliente/_criarNota.php?idCliente=" + idCliente, true);
    xmlhttp.send();
}

function editarNota(id){
    var cor=$("#nota"+id).attr("data-cor");
    var descricao=$("#descricaonota"+id).val();
    var data_lembrete=$("#datalembretenota"+id).val();
    var notificar_administradores=$("#notificaradminsnota"+id).prop("checked");
    var mostrar_funcionarios=$("#mostrarfuncionariosnota"+id).prop("checked");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if(this.responseText!=0){
                growlNot("warning","<i class='fa fa-warning'></i> Erro ao gravar alteração.");
            }
        }
    };
    xmlhttp.open("GET", "../mod_srvcliente/_editarNota.php?id=" + id+"&cor="+encodeURIComponent(cor)+"&descricao="+encodeURIComponent(descricao)+"&data_lembrete="+data_lembrete+"&notificar_administradores="+notificar_administradores+"&mostrar_funcionarios="+mostrar_funcionarios, true);
    xmlhttp.send();
}

function editarComentario(id, elem){

    let input =$(elem).parent().parent().find('.input-for-nota-editavel');
    var descricao = input.val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText!=0){
              alert('Erro ao gravar');
            }else{
                input.css('border-color','green');
                $("#descricaonota"+id).val(descricao);
            }
        }
    };
    xmlhttp.open("GET", "../mod_srvcliente/_editarComentario.php?id=" + id+"&descricao="+encodeURIComponent(descricao), true);
    xmlhttp.send();
}

function adicionarComentario(idCliente){

    var descricao=$('#comentario').val();


    if(descricao != ""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $('#comentario').val("");

                // PARA OS COMMENTS
                $('.todas-notas').append(this.responseText);
                $('.todas-notas-parent').scrollTop($('.todas-notas-parent')[0].scrollHeight);

              /*  let array = $.parseJSON(this.responseText);

                // PARA OS COMMENTS
                $('.todas-notas').append(array['comentario']);
                $('.todas-notas-parent').scrollTop($('.todas-notas-parent')[0].scrollHeight);

                // PARA AS NOTAS
                $("#notas").prepend(array['notas']);
                $('.label.label-primary.nav-users-indicator').text($('.label.label-primary.nav-users-indicator').text()*1 + 1);*/

            }else{
                $('#comentario').css('border-color', 'red');
            }
        }
        xmlhttp.open("GET", "../mod_srvcliente/_adicionarComentario.php?idCliente=" + idCliente+"&descricao="+encodeURIComponent(descricao), true);
        xmlhttp.send();
    }

}


function mostrar_sidebar_notas() {

    if($(".sidebar-notas").hasClass("aberto")){
        $(".sidebar-notas").animate({ right:'-310px' }).removeClass("aberto");
        $(".btn-notas").animate({right: '40px'});
    }else{
        $(".sidebar-notas").show().animate({ right:'0px' }).addClass("aberto");
        $(".btn-notas").animate({right: '320px'});
    }

}


    var myDropzone = new Dropzone("#dropzoneClientes",

        {

            url: "_upload_media.php?nif="+$("#nif").html(),

            init: function () {



                this.on("processing",function () {

                    window.onbeforeunload = function() {

                        return ("Antes de sair confirme se todos os ficheiros foram carregados e de seguida carrege em \"Concluir\".");

                    };

                });

                this.on("success", function (file, response) {

                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

                        console.log(response);

                        growlNot('success',

                            '<h4>Documentos carregados!</h4>');
                        $(".dz-success").remove();
                        $(".dropzoneClientes").html("<i class=\"fa fa-cloud-upload\"  ></i>");

                        get_galeria($("#nif").html());




                        //window.onbeforeunload = null;

                    }

                });

            },

            addRemoveLinks: true,

            removedfile: function (file) {

                var nome = file.name;

                var xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        console.log(this.responseText);

                        var _ref;

                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

                    }

                };

                xmlhttp.open("GET", "../tmp_files_delete.php?nome=" + nome, true);

                xmlhttp.send();

            }

        });



function get_galeria(nif) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log();

            $("#documentos").html(this.responseText);
            $ ( '.photo-gallery' ) . on ( 'click' , '.photo-gallery__figure' , function  ( e )  {
                e . preventDefault ( ) ;
                createPhotoSwipe ( e . currentTarget ) ;
            } ) ;

        }
    };
    xmlhttp.open("GET", "../mod_srvcliente/_getDocumentos.php?nif="+encodeURIComponent(nif), true);
    xmlhttp.send();
}



$( document ).ready(function () {
    if(document.getElementById("form-geolocalizacao")){
        $('#form-geolocalizacao').validate({
            errorClass: 'help-block animation-slideUp', // You can change the animation class for a different entrance animation - check animations page
            errorElement: 'small',
            errorPlacement: function(error, e) {
                e.parent().append(error);
            },
            highlight: function(e) {
                $(e).closest('div').removeClass('has-success has-error').addClass('has-error');
                $(e).closest('.help-block').remove();
            },
            success: function(e) {
                e.closest('div').removeClass('has-success has-error');
                e.closest('.help-block').remove();
            },
            submitHandler: function (form) {
                //alert();
                $("#form-geolocalizacao_btn").button('loading');
                $.ajax({
                    type: form.method,
                    url: form.action,
                    data: $(form).serialize(),
                    success: function(response) {
                        $("#form-geolocalizacao_btn").button('reset');
                        var $_GET = {};
                        if(document.location.toString().indexOf('?') !== -1) {
                            var query = document.location
                                .toString()
                                // get the query string
                                .replace(/^.*?\?/, '')
                                // and remove any existing hash string (thanks, @vrijdenker)
                                .replace(/#.*$/, '')
                                .split('&');

                            for(var i=0, l=query.length; i<l; i++) {
                                var aux = decodeURIComponent(query[i]).split('=');
                                $_GET[aux[0]] = aux[1];
                            }
                        }
                        window.location="../mod_srvcliente/detalhes.php?id="+$_GET['id'];
                        growlNot("success","Dados Atualizados");
                    }
                });
                return false; // required to block normal submit since you used ajax
            }
        });
    }
});

function cancelargeo(id) {
    window.location="../mod_srvcliente/detalhes.php?id="+id;
}

function selecionarLocalizacao(id){
    $("#modal-atualizar-nome").val($("#"+id+" option:selected").text());
}


function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    guardarLocalizacao(position.coords.latitude,position.coords.longitude);
}