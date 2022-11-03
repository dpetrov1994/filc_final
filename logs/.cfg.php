<?php
/**
 * Created by PhpStorm.
 * User:: Denis
 * Date:: 09/03/2018
 * Time:: 18::56
 */

//se for um módulo parent
$subModulo=0;
$tabelaParent="";
$colunaParent="";
//dados do módulo na BD

$nomeTabela="utilizadores_logs";

$nomeColuna="utilizador_log";

$innerjoin=" ";
if($_SESSION['system']!=1){
    $add_sql.=" and id_utilizador!=1";
}


$itensIgnorar = [ // são os itens que vêm do POST que não sao para inserir na BD
    'submit',
    '',
];
$itensObrigatorios = [ //intes que são obrigatórios
    'nome_'.$nomeColuna,
];

/**
 *           LISTA DE FUNCOES E REGRAS PARA MOSTRAR NA TABELA
 *
 * checkbox                                 -> aparecer os checkboxes para selecionar vários
 * link::x                                   -> cria link (x) para abrir o registo na página "abrir","detalhes",editar. <- esta é a ordem se nao existir x
 * cortaNome                                -> é um nome, portanto so mostra o primeiro e o último
 * text::x                                   -> o nome da coluna que aparece assim:: <th>x</th>
 * cortaStr::x                               -> cortaStr(x) x->tamanho
 * class::x                                  -> adiciona a class x
 * style::x                                  -> adiciona estilo css
 * date::x                                  -> data onde x -> %d/%m/%Y %H:%M:%S
 * func::x                                  -> data onde x é a nome da funcção sem () ex:cortaNome
 * if::x=>text(x),a=>text(a),b=>text(b)      ->  onde se usa o IF
 *
 **/
$colunasParaMostrarNaTabela=[
    //"checkbox" => "checkbox",
    //"id_$nomeColuna" => "link|text::#|class::text-center",
    "data_log" => "value::_data_log_ atrás|func::humanTiming|text::<i class='fa fa-history'></i>|class::text-center",
    "nome_utilizador" => "text::Utilizador",
    "texto" => "text::Ação|link",
    "nome_tabela" => "text::Tabela afectada|value::\"_nome_tabela_\"|link::index.php_addUrl_&nome_tabela=_nome_tabela_",
    "id_item" => "text::Registo afectado|value::#_id_item_|link::index.php_addUrl_&id_item=_id_item_",
    //"ativo" => "text::Estado|if::1=><span class='label label-success'>Ativo</span>,,0=><span class='label label-warning'>Desativo</span>",
    ///////////////////////////////////////////////
    //"funcionalidades"=>"funcionalidades", // apagar esta linha se não quiser mostrar
];

$ordenarPorDefeito="$nomeTabela.data_log desc";
$opcoesOrdenar=[
    "$nomeTabela.data_log asc"=>"Data ASC",
    "$nomeTabela.data_log desc"=>"Data DESC",
];

$colunas=Array(); // colunas nnas quais se pesquisa

/** Tirar comentário se exisitr outra tabela na qual pode-se fazer pesquisa */

/*
$sql="SHOW COLUMNS FROM utilizadores";
$result=runQ($sql,$db,"colunas");
while ($row = $result->fetch_assoc()) {
    array_push($colunas,"utilizadores.".$row['Field']);
}
*/

//elementos da reciclagem
if(isset($ativo) && $ativo==0){
    $add_sql.=" and $nomeTabela.ativo=0";
}else{
    $add_sql.=" and $nomeTabela.ativo=1";
}


//SE FORM UM SUBMODULO
if($subModulo==1){
    if(isset($_GET['id'])){
        $idParent=$db->escape_string($_GET['id']);
    }else{
        $idParent=0;
    }

    $sql="select * from $tabelaParent where id_$colunaParent='$idParent' limit 0,1";
    $result = runQ($sql, $db, "CONTAR");
    if($result->num_rows==0){
        exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod. 1","Não foi encontrado nenhum registo com o ID:$idParent",""));
    }

    if(isset($_GET['subItemID'])){
        $id=$db->escape_string($_GET['subItemID']);
    }else{
        $id="0";
    }
    $add_sql.=" and id_$colunaParent = '$idParent'";
}else{
    if(isset($_GET['id'])){
        $id=$db->escape_string($_GET['id']);
    }else{
        $id=0;
    }
}