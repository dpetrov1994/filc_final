

$("#iniciar").click(function () {
    if($("#info").text()=="Iniciado"){
        $("#info").text("Parado");
        $(this).text("Iniciar");
    }else{
        $("#info").text("Iniciado");
        $(this).text("Parar");
        enviar_emails();
    }
});

function enviar_emails() {
    var intervalo=$("#intervalo").val();
    var qnt=$("#qnt").val();
    if($("#info").text()=="Iniciado"){

        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                $("#log").prepend(this.responseText+"<hr>");
                $("#processados").val($("#processados").val()*1+1);

                setTimeout(function () {
                    enviar_emails();
                },intervalo*1000);

            }

        };

        xmlhttp.open("GET", "criar.php?newsletter_qnt="+qnt, true);

        xmlhttp.send();

    }
}