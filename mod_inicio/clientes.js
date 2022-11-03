/*
 *  Document   : compCalendar.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Calendar page
 */


function ocupacao_cliente() {
    $('#ocupacao_cliente').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_ocupacao_cliente").val();
    var fim=$("#fim_ocupacao_cliente").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#ocupacao_cliente').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_clientes/ocupacao_cliente.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}


function tempo_cliente() {
    $('#tempo_cliente').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_tempo_cliente").val();
    var fim=$("#fim_tempo_cliente").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#tempo_cliente').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_clientes/tempo_cliente.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}



function percentagem_faturacao_cliente() {
    $('#percentagem_faturacao_cliente').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_percentagem_faturacao_cliente").val();
    var fim=$("#fim_percentagem_faturacao_cliente").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#percentagem_faturacao_cliente').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_clientes/percentagem_faturacao_cliente.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}


function faturacao_cliente() {
    $('#faturacao_cliente').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_faturacao_cliente").val();
    var fim=$("#fim_faturacao_cliente").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#faturacao_cliente').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_clientes/faturacao_cliente.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}

