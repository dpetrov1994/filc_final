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

$nomeTabela="srv_clientes_saletransaction";
$nomeColuna="sale";
$innerjoin="";
$add_sql.=" ";

$itensIgnorar = [ // são os itens que vêm do POST que não sao para inserir na BD
    'submit',
];
$itensObrigatorios = [ //intes que são obrigatórios
    'nome_'.$nomeColuna,
    
];

/**
 *   LISTA DE FUNCOES E REGRAS PARA MOSTRAR NA TABELA
 *
 * checkbox                                 -> aparecer os checkboxes para selecionar vários
 * link::x                                   -> cria link (x) para abrir o registo na página "abrir","detalhes",editar. <- esta é a ordem se nao existir x
 * value::x                                   -> X é o conteudo personalizado dentro da coluna
 * cortaNome                                   -> é um nome, portanto so mostra o primeiro e o último
 * text::x                                   -> o nome da coluna que aparece assim:: <th>x</th>
 * cortaStr::x                               -> cortaStr(x) x->tamanho
 * class::x                                  -> adiciona a class x
 * style::x                                  -> adiciona estilo css
 * date::x                                  -> data onde x -> %d/%m/%Y %H:%M:%S
 * func::x                                  -> onde x é o nome da fiuncçaõ sem (), ex:strtoupper #funciona apenas para funcçoes com 1 ou menos paramentros
 * if::x=>text(x),a=>text(a),ELSE=>text(b)      ->  onde se usa o IF
 *
 **/

$colunasParaMostrarNaTabela=[
    "CreationDate1" => "style::width:20px|class::text-center|text::Criado|value::<div style='width: 30px;border: 1px solid gray'><div style='background: #fff;text-align: center'><b style='font-size: 11px' class='text-danger'>_mes_</b></div><div style='height: 20px;text-align: center;font-size: 15px'>_dia_</div><div style='height: 14px;text-align: center;font-size: 10px;color:#dc358c;'>_ano_</div></div>",
    "data_vencimento" => "style::width:20px|text::Vence|value::<div style='width: 30px;border: 1px solid gray'><div style='background: #fff;text-align: center'><b style='font-size: 11px' class='text-danger'>_mes1_</b></div><div style='height: 20px;text-align: center;font-size: 15px'>_dia1_</div><div style='height: 14px;text-align: center;font-size: 10px;color:#dc358c;'>_ano1_</div></div>",
    "id_sale" => "style::width:200px|class::text-center|link::detalhes.php?id=_idItem_|text::#|value::_TransDocument_ #_TransSerial_/_TransDocNumber_",

    //"ativo" => "text::Estado|if::1=><span class='label label-success'>Ativo</span>,,0=><span class='label label-warning'>Desativo</span>",
    ///////////////////////////////////////////////
    // "funcionalidades"=>"funcionalidades", // apagar esta linha se não quiser mostrar
    "nome_cliente" => "text::Cliente",
    "TotalAmount" => "text::Total|class::text-right|value::<b>_TotalAmount_</b>",
];

$ordenarPorDefeito="$nomeTabela.CreateDate desc";
$opcoesOrdenar=[
    "$nomeTabela.CreateDate desc"=>"Mais recentes",
    "$nomeTabela.CreateDate asc"=>"Mais antigos"
];

$colunas=Array(); // colunas nnas quais se pesquisa

/** Tirar comentário se exisitr outra tabela na qual pode-se fazer pesquisa */

/*
$sql="SHOW COLUMNS FROM nome_tabela";
$result=runQ($sql,$db,"colunas");
while ($row = $result->fetch_assoc()) {
    array_push($colunas,"$nomeTabela.".$row['Field']);
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