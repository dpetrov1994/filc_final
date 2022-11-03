function marcarVista(id_mensagem){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //alert(this.responseText);
        }
    };
    xmlhttp.open("GET", "marcarVista.php?id="+id_mensagem, true);
    xmlhttp.send();
}
