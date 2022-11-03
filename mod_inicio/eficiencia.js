/*
 *  Document   : compCalendar.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Calendar page
 */


function eficiencia_media() {
    $('#eficiencia_media').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_eficiencia").val();
    var fim=$("#fim_eficiencia").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#eficiencia_media').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_eficiencia/eficiencia_media.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}



function eficiencia_dia() {
    $('#eficiencia_dia').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_eficiencia_dia").val();
    var fim=$("#fim_eficiencia_dia").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#eficiencia_dia').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_eficiencia/eficiencia_dia.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}


function tempos_dia() {
    $('#tempos_dia').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_tempos_dia").val();
    var fim=$("#fim_tempos_dia").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#tempos_dia').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_eficiencia/tempos_dia.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}



function ocupacao_categoria() {
    $('#ocupacao_categoria').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_ocupacao_categoria").val();
    var fim=$("#fim_ocupacao_categoria").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#ocupacao_categoria').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_eficiencia/ocupacao_categoria.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}


function tempo_categoria() {
    $('#tempo_categoria').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_tempo_categoria").val();
    var fim=$("#fim_tempo_categoria").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#tempo_categoria').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_eficiencia/tempo_categoria.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}

function ocupacao_tipo() {
    $('#ocupacao_tipo').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_ocupacao_tipo").val();
    var fim=$("#fim_ocupacao_tipo").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#ocupacao_tipo').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_eficiencia/ocupacao_tipo.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}


function tempo_tipo() {
    $('#tempo_tipo').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_tempo_tipo").val();
    var fim=$("#fim_tempo_tipo").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#tempo_tipo').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_eficiencia/tempo_tipo.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}



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
    xmlhttp.open("GET", "ajax_eficiencia/ocupacao_cliente.php?inicio=" + inicio+"&fim="+fim, true);
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
    xmlhttp.open("GET", "ajax_eficiencia/tempo_cliente.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}

