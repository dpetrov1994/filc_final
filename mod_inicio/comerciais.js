/*
 *  Document   : compCalendar.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Calendar page
 */


function orcamentos_clientes() {
    $('#orcamentos_clientes').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio_orcamentos_clientes").val();
    var fim=$("#fim_orcamentos_clientes").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#orcamentos_clientes').html(this.responseText);
        }
    };
    xmlhttp.open("GET", "ajax_comerciais/orcamentos_clientes.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}

