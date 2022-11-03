$('input[name*=nome_mensagem]').rules('add', 'required');
$('input[name*=utilizadores]').rules('add', 'required');


function addDestinatarios(){
    $('#potenciaisDestinatarios option:selected').remove().appendTo('#utilizadores');
}
function removeDestinatarios(){
    $('#utilizadores option:selected').remove().appendTo('#potenciaisDestinatarios');
}

function getUtilizadores(grupo){
    document.getElementById("potenciaisDestinatarios").innerHTML = "<option disabled>Aguarde...</option>";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("potenciaisDestinatarios").innerHTML = this.responseText;
        }

    };
    xmlhttp.open("GET", "_get_utilizadores.php?id=" + grupo, true);
    xmlhttp.send();
}