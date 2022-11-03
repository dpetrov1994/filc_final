/*
 *  Document   : compCalendar.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Calendar page
 */


function ocupacao_maquina() {
    $('#ocupacao_maquina').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_ocupacao_maquina").val();
    var fim=$("#fim_ocupacao_maquina").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#ocupacao_maquina').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_maquinas/ocupacao_maquina.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}


function servicos_maquina() {
    $('#servicos_maquina').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_servicos_maquina").val();
    var fim=$("#fim_servicos_maquina").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#servicos_maquina').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_maquinas/servicos_maquina.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}



function percentagem_faturacao_maquina() {
    $('#percentagem_faturacao_maquina').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_percentagem_faturacao_maquina").val();
    var fim=$("#fim_percentagem_faturacao_maquina").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#percentagem_faturacao_maquina').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_maquinas/percentagem_faturacao_maquina.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}


function faturacao_maquina() {
    $('#faturacao_maquina').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_faturacao_maquina").val();
    var fim=$("#fim_faturacao_maquina").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#faturacao_maquina').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_maquinas/faturacao_maquina.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}

