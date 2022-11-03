function aprovarMovimento(id_carregamento) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            $(".aprovar-carregamento-"+id_carregamento).remove();
        }
    };

    xmlhttp.open("GET", "_aprovarMovimento.php?id_carregamento="+id_carregamento, true);
    xmlhttp.send();

}