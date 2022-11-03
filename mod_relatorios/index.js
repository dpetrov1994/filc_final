

let tamanhoTabelas = [];
let i =0;

let tamanhoTabelasRelacoes = [];
let i2 =0;


$('.tabela-relacoes').each(function (){
    i++;
    tamanhoTabelas[i]= $(this).height() + 20;
})


$('.tabela-relacoes').css("height", "0");


function removerGrupo(elem){
    $(elem).parent().parent().parent().remove();
}


function removerLinhaSubgrupo(elem){

    $(elem).parent().parent().parent().remove();

}



$('.add-condicao').click(function () {


    $('#linhas').append($(".condicao").html());
    $('#linhas .grupo-condicao-pai .group-and-or').first().hide(); //  $('#linhas .grupo-condicao-pai .group-and-or').first().parent().hide();
    if($('#linhas .grupo-condicao-pai .group-and-or.ignore')[0] == undefined){
        $('#linhas .grupo-condicao-pai .group-and-or').first().addClass('ignore');
    }


})


$('.add-coluna').click(function () {


    $('#linhas_aritmeticas').append($(".coluna_aritmetica").html());


})


function atualizar_contagem() {


    $("#only_count").val("1");
    var action=($("#form_gerar_relatorio").attr("action"));
    var data=$("#form_gerar_relatorio").serialize();

    $.ajax({
        type: "POST",
        url: action,
        data: data,
        success: function(response) {
            $("#only_count").val("0");
            var text="";
            var cor="success";
            if(response*1>200000){
                cor="warning";
            }
            $("#botao-gerar-relatorio").show();
            if(response*1>500000){
                cor="danger";
            }
            if(response*1>2000000){
                $("#botao-gerar-relatorio").hide();
                cor="danger";
            }
            $("#msg_relatorio").html("O relatório vai gerar <b class='text-"+cor+"'>"+response+"</b> registos.");
        }
    });
    $("#only_count").val("0");

}

function mostrarColunasDisponiveis() {
    var colunas="";

    $(".tabela-selecionada-principal").each(function () {
        if($(this).prop("checked")==true){
            var nome_tabela=$(this).val();

            var parent=$(this).parent().parent().parent();
            $(parent).find(".parent-of-tabela-relacoes").each(function () {
                var nome_coluna=$(this).find("input").val();
                colunas+="<li><b>"+nome_tabela+"</b>.<span style='color:black'>"+nome_coluna+"</span> </li> ";
            });
        }
    });

    $(".tabela-selecionada").each(function () {
        if($(this).prop("checked")==true){
            var nome_tabela=$(this).val();
            var parent=$(this).parent().parent();
            $(parent).find(".checkboxes_colunas").each(function () {
                var nome_coluna=$(this).find("input").val();
                colunas+="<li><b>"+nome_tabela+"</b>.<span style='color:black'>"+nome_coluna+"</span> </li> ";
            });
        }
    });

    $("#colunas_selecionadas").html("<ul style='column-count: 4;'>"+colunas+"</ul>");

}


function addSubgrupo(elem){
    $($('.subgrupo-condicao-temp').html()).insertBefore($(elem));
}

$('.tabela-selecionada-principal').click(function (){
    $('#relacoes .col-lg-12').remove();
});

function obter_tabelas_relacoes(elem,pai=false){

    if(pai==true){
        $("#containter_relacoes").html("");
    }

    $("#overlay-layer").show();

    var i=0;
    var i2=0;

    let willReturn = 0;

    if($(elem).prop('checked') == false){
        willReturn = 1;
    }

    let value = elem.value;

    let selecionadas = "";
    let query = "";

    let tabelaSelecionadaAtual = value;

    let opsTabelasCondicoes="<option></option>";

    $('.tabela-selecionada-principal').each(function (){
        i++;
        if($(this).prop('checked') == true){
            selecionadas = selecionadas+$(this).val()+',';
            query = query+$(this).val()+',';

            let tabelatxt = $(this).val();
            tabelatxt = tabelatxt.replace('_', ' ');
            tabelatxt  = tabelatxt.substr(0,1).toUpperCase()+tabelatxt.substr(1);

            opsTabelasCondicoes+="<option value='"+$(this).val()+"'>"+tabelatxt+"</option>";

            $(this).parent().parent().next().animate({height: tamanhoTabelas[i]}, 0);
        }else{
            $(this).parent().parent().next().animate({height: "0"}, 0);
        }
    });


    $('.tabela-selecionada').each(function (){


        if($(this).prop('checked') == true){
            selecionadas = selecionadas+$(this).val()+',';
            query = query+$(this).attr('data-ligacoes')+',';

            let tabelatxt = $(this).val();
            tabelatxt = tabelatxt.replace('_', ' ');
            tabelatxt  = tabelatxt.substr(0,1).toUpperCase()+tabelatxt.substr(1);
            opsTabelasCondicoes+="<option value='"+$(this).val()+"'>"+tabelatxt+"</option>";
        }

    });

    /* CONDICOES  - SELECTS */
    $('.tabela-grupo-condicao').html(opsTabelasCondicoes);

    $('.coluna-grupo-condicao').html("");


    if(willReturn == 1){
        $(elem).parent().next().animate({height: "0"}, 500);
        //return;
    }

    build_json_com_colunas_selecionadas();
    var json_com_colunas_selecionadas=$("#json_com_colunas_selecionadas").val();

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            $("#containter_relacoes").html(this.responseText);
            $("#overlay-layer").hide();

        }
    };


    xmlhttp.open("GET", "criar.php?get_relacoes_da_tabela=" +value+"&selecionadas="+selecionadas+"&json_com_colunas_selecionadas="+json_com_colunas_selecionadas+"&selecionadaAtual="+tabelaSelecionadaAtual+"&queryBuilder="+query, true);
    xmlhttp.send();

}


function selecionar_checkbox(elem) {
    $(elem).find("input").click();
}


function get_array_colunas_por_tabela() {
    var colunas_por_tabela=[];
    $('.tabela-selecionada-principal').each(function (){
        if($(this).prop('checked') == true){
            var colunas=[];
            $(this).parent().parent().parent().find(".coluna_da_tabela_pai").each(function (index,elem) {
                if($(elem).prop('checked') == true){
                    colunas.push($(elem).val());
                }
            });
            colunas_por_tabela.push({tabela:$(this).val(),colunas:colunas});
        }
    });


    $('.tabela-selecionada').each(function (){
        if($(this).prop('checked') == true){
            var colunas=[];
            $(this).parent().parent().find(".colunas_da_tabela_secundaria").each(function (index,elem) {
                if($(elem).prop('checked') == true){
                    colunas.push($(elem).val());
                }
            });
            colunas_por_tabela.push({tabela:$(this).val(),colunas:colunas});
        }
    });

    return colunas_por_tabela;
}

function build_json_com_colunas_selecionadas() {
    var colunas_por_tabela=get_array_colunas_por_tabela();
    $("#json_com_colunas_selecionadas").val(JSON.stringify(colunas_por_tabela));
}


function expandir_tabela(elem) {
    $(elem).parent().parent().find(".colunas_escondidas").toggle();
}


function gerarSqlQuery(btn,testar=0,guardar=0){

    // COLUNAS

    var nome_relatorio="";
    var categoria="";
    if(guardar==1){
        if($("#nome_relatorio").val()==""){
            growlNot("danger","Por favor preencha o nome do relatório.");
            return;
        }
        if($("#categoria").val()==""){
            growlNot("danger","Por favor preencha a categoria do relatório.");
            return;
        }
        nome_relatorio=$("#nome_relatorio").val();
        categoria=$("#categoria").val();
    }

    var text=$(btn).html();
    var click=$(btn).attr("onclick");
    $(btn).html("<i class='fa fa-spin fa-circle-o-notch'></i> A gerar relatório...");
    $(btn).attr("onclick","");

    let selecionadas = "";
    let colunas = "";

    $('.tabela-selecionada-principal').each(function (index_tabela,elem_tabela){

        if($(elem_tabela).prop('checked') == true){


            $(elem_tabela).parent().parent().parent().find('.parent-of-tabela-relacoes').each(function (index_coluna,elem_coluna){
                if($(elem_coluna).find('input').prop('checked') == true){
                    colunas+=$(elem_tabela).val()+"."+$(elem_coluna).find('input').val()+",";
                }
            })
            selecionadas = selecionadas+$(elem_tabela).val()+',';

        }
    })



    $('.tabela-selecionada').each(function (index_tabela,elem_tabela){

        if($(elem_tabela).prop('checked') == true){


            $(elem_tabela).parent().parent().find('.checkboxes_colunas').each(function (index_coluna,elem_coluna){
                if($(elem_coluna).find('input').prop('checked') == true){

                    colunas+=$(elem_tabela).val()+"."+$(elem_coluna).find('input').val()+",";
                }
            })
            selecionadas = selecionadas+$(elem_tabela).attr('data-ligacoes')+',';

        }

    })

    //colunas aritmeticas

    $(".linha_coluna_aritmetica").each(function () {
        if($(this).find(".coluna-aritmetica-valor").val()!="" && $(this).find(".coluna-aritmetica-nome").val()){
            colunas+=$(this).find(".coluna-aritmetica-valor").val()+" as "+$(this).find(".coluna-aritmetica-nome").val()+",";
        }

    });
    //tirar ultimo caracter





    // CONDICOES
    let arrayDados = [];
    let query = "";


    $('.grupo-condicao-pai').each(function (){ // CORRER GRUPO

        let querySubGrupo = "";

        $(this).find('.subgrupo').each(function (){ // CORRER GRUPO

            let tabela = $(this).find('.tabela-grupo-condicao').val();// TABELA
            let coluna = $(this).find('.coluna-grupo-condicao').val(); // Coluna
            let condicao = $(this).find('.grupo-condicao-condicao').val(); // condicao where
            let valor = $(this).find('.valor-condicao').val(); // valor
            let operador = "";

            if(condicao=="like"){
                valor="%"+valor+"%";
            }


            if($(this).next().find('.subgroup-and-or')[0]){
                operador = $(this).next().find('.subgroup-and-or').val(); // condicao and/or
            }

            if(tabela != ""){
                querySubGrupo +=" "+tabela+"."+coluna+" "+condicao+" '"+valor+"'";
                querySubGrupo+=" "+operador+" "
            }


        })

        let operadorPai = "";
        if($(this).find('.group-and-or')[0]){
            if($(this).find('.group-and-or').hasClass('ignore')){
                //nada
            }else{
                operadorPai = $(this).find('.group-and-or').val();  // condicao and/or
            }

        }


        if(querySubGrupo != ""){
            query += " "+operadorPai+" ("+querySubGrupo+")";
        }


    })


    var json_com_colunas_selecionadas=$("#json_com_colunas_selecionadas").val();
    json_com_colunas_selecionadas=JSON.stringify(json_com_colunas_selecionadas);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", 'criar.php?gerarQuery', true);

// Envia a informação do cabeçalho junto com a requisição.
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() { // Chama a função quando o estado mudar.
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {

            //console.log(this.responseText);
            $(btn).html(text);
            $(btn).attr("onclick",click);

            if(guardar==0){
                /*
                          * Make CSV downloadable
                          */
                var downloadLink = document.createElement("a");
                var fileData = ['\ufeff'+this.responseText];

                var blobObject = new Blob(fileData,{
                    type: "application/vnd.ms-excel"
                });

                var url = URL.createObjectURL(blobObject);
                downloadLink.href = url;
                downloadLink.download = "relatorio_teste"+Math.floor(Math.random() * 10)+".xls";

                /*
                 * Actually download CSV
                 */
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            }else{
                if(this.responseText!=0){
                    growlNot("danger","Por favor selecione pelo menos uma tabela e uma coluna");
                }else{
                    growlNot("success","Relatório Criado");
                    window.location="index.php?cod=1";
                }
            }
        }
    };
    xhr.send("colunas="+colunas+"&tabelas="+selecionadas+"&condicoes="+query+"&guardar="+guardar+"&testar="+testar+"&nome_relatorio="+nome_relatorio+"&categoria="+categoria+"&json_com_colunas_selecionadas="+json_com_colunas_selecionadas);




}



function getCamposTabela(elem){

    let value = $(elem).val();

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

            $(elem).parent().parent().find('.coluna-grupo-condicao').html(this.responseText);
            // $('.select-select2').select2();
            $(elem).parent().parent().find('.coluna-grupo-condicao').trigger('change.select2'); // Notify only Select2 of changes
        }
    };

    xmlhttp.open("GET", "criar.php?getCampos=" + value, true);
    xmlhttp.send();

}



function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}




function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

function getFiltrosRelatorio(btn,id_relatorio) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText);
            $("#modal-relatorio-body").html(this.responseText);
            $("#modal-relatorio-title").html($(btn).html());

            $("#modal-relatorio").modal("show");
            CompNestable.init();

        }
    };
    xmlhttp.open("GET", "index.php?id_relatorio="+id_relatorio, true);
    xmlhttp.send();
}


/*
 *  Document   : compNestable.js
 *  Author     : pixelcave
 */
var CompNestable = (function () {
    var t = function (t) {
        var e = t.length ? t : $(t.target),
            a = e.data("output");
        a.val(window.JSON ? window.JSON.stringify(e.nestable("serialize")) : "JSON browser support required!");
    };
    return {
        init: function () {
            var e = $(".dd"),
                a = $("#nestable1"),
                n = $("#nestable2");
            a.nestable({ group: 1,maxDepth:1 }).on("change", t),
                n.nestable({ group: 1,maxDepth:1 }).on("change", t),
                t(a.data("output", $("#nestable1-output"))),
                t(n.data("output", $("#nestable2-output")));

        },
    };
})();


