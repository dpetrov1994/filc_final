function adicionarData() {
    var data =$("#bloquear_data").val();
    if(data!=""){
        var data_mysql=data.split("/");
        data_mysql = data_mysql[2]+"-"+data_mysql[1]+"-"+data_mysql[0];
        var linha='<tr id="'+data_mysql+'">\n' +
            '                                    <td>'+data+'</td>\n' +
            '                                    <td style="width: 10px"><a href="javascript:void(0)" class="btn btn-xs btn-effect-ripple btn-danger" onclick="removerData(\''+data_mysql+'\')" ><i class="fa fa-times"></i></a></td>\n' +
            '                                </tr>';

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $("#datas").prepend(linha);
                $("#bloquear_data").val("");
                growlNot("success","Sucesso!");
            }
        };
        xmlhttp.open("GET", "_adicionarData.php?data=" + data_mysql, true);
        xmlhttp.send();
    }
}

function removerData(data) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $("#"+data).remove();
            growlNot("success","Sucesso!");
        }
    };
    xmlhttp.open("GET", "_removerData.php?data=" + data, true);
    xmlhttp.send();
}