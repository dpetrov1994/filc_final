

$('.eliminar-linha-orcamento').remove();

CalcLinhas();

desativarInputs();

$("input[type=checkbox]").prop("disabled", false);


function FuncaoFiltrarProduto() {
    // Declare variables

    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("input")[2];
        console.log(td);
        if (td) {
            txtValue = td.textContent || td.value;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}



$('.linhasProd').width($('.form-control.nome_produto').width());
$('body').click(function (){
    $('.linhasProd').hide();
})

function pesquisaprof(elem){
    $('.linha-temporaria').remove();
    $('.linhasProd').empty();
    var linhas =  $('.linhasProd').clone();
    $(linhas).addClass('linha-temporaria');
    $('.linhasProd').hide();
    var textEnviado = $(elem).val();
    if(textEnviado.length > 5){
        $(".linha-produtos").each(function () {

            var nome=$(this).text();
            var preco_sem_iva = $(this).attr('data-preco-sem-iva');
            var percentagem_iva = $(this).attr('data-percentagem-iva');
            var img = $(this).attr('data-img');
            var valor_iva = $(this).attr('data-valor-iva');
            if(nome.toLowerCase().includes(textEnviado.toLowerCase())){

                $(linhas).show();
                //$('.linhasProd').show();
                $(linhas).append('<div data-preco-sem-iva="'+preco_sem_iva+'" data-img="'+img+'"' +
                    ' data-percentagem-iva="'+percentagem_iva+'" data-valor-iva="'+valor_iva+'" ' +
                    'class="linha-pesquisa" style="cursor: pointer; padding:5px" onclick="copyText(this)">'+nome+'<div>');
                $(linhas).insertAfter(elem);

            }
        });
        $("<hr>").insertAfter('.linha-pesquisa');
    }else{
        $('.linha-temporaria').remove();
    }

}



function copyText(elem){
    $(elem).parent().parent().find('.form-control.nome_produto').val($(elem).text());

    var preco_sem_iva = $(elem).attr('data-preco-sem-iva');
    var percentagem_iva = $(elem).attr('data-percentagem-iva');
    var valor_iva = $(elem).attr('data-valor-iva');
    var img = $(elem).attr('data-img');


    // var qnt = $('.form-control.quantidade').val();

    $(elem).parent().parent().parent().find('.form-control.preco_sem_iva').val(preco_sem_iva);
    $(elem).parent().parent().parent().find('.form-control.percentagem_iva').val(percentagem_iva);
    $(elem).parent().parent().parent().find('.form-control.valor_iva').val(valor_iva);
    $(elem).parent().parent().parent().find('.linha-imagem').attr("src",img);

    calcular_iva( $(elem).parent().parent().parent().find('.form-control.preco_sem_iva'));
    $('.linha-temporaria').remove();
}
