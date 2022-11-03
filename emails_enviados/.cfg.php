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

$nomeTabela="_emails_enviados";
$nomeColuna="email";
$innerjoin=" ";

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
 * if::x=>text(x),a=>text(a),ELSE=>x     ->  onde se usa o IF
 *
 **/
$colunasParaMostrarNaTabela=[
    //"checkbox" => "checkbox",
    //"id_$nomeColuna" => "link|text::#|class::text-center",
    "created_at" => "value::_created_at_ atrás|func::humanTiming|text::<i class='fa fa-history'></i>|class::text-center",
    "nome_utilizador" => "text::Utilizador",
    "assunto" => "link|text::Assunto",
    "destinatario" => "text::Destinatario|link::index.php_addUrl_&destinatario=_destinatario_",
    "estado" => "text::Estado|if::0=><span class='label label-success'>Enviado</span>,,ELSE=><small class='text-danger'>_estado_</small>",
    ///////////////////////////////////////////////
    //"funcionalidades"=>"funcionalidades", // apagar esta linha se não quiser mostrar
];

$ordenarPorDefeito="$nomeTabela.created_at desc";
$opcoesOrdenar=[
    "$nomeTabela.created_at asc"=>"Data ASC",
    "$nomeTabela.created_at desc"=>"Data DESC",
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