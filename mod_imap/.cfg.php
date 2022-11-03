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

$nomeTabela="imap";
$nomeColuna="imap";
$innerjoin="";
$add_sql.="";

$itensIgnorar = [ // são os itens que vêm do POST que não sao para inserir na BD
    'submit', 'form-ajax','include_from_other_file',
];
$itensObrigatorios = [ //intes que são obrigatórios
    'nome_'.$nomeColuna,
    
];

/**
 *           LISTA DE FUNCOES E REGRAS PARA MOSTRAR NA TABELA
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
    "checkbox" => "checkbox",
    "id_$nomeColuna" => "text::#|class::text-center text-muted |value::_lido_<br>_com_anexos_<br>_spam_<br>_estado_<br>_enviado_",
    "nome_$nomeColuna" => "text::Assunto|value::_nome_imap_ _descricao_",
    "de_nome" => "text::Destinatario|value::<small class='text-muted'>De:<br> <span class='text-info'>_de_nome_ _de_email_</span><br><br>Para<br> <span class='text-success'>_para_nome_ _para_email_</span></small>",
    ///////////////////////////////////////////////
    "funcionalidades"=>"funcionalidades", // apagar esta linha se não quiser mostrar
];

$ordenarPorDefeito="$nomeTabela.id_$nomeColuna desc";
$opcoesOrdenar=[
    "$nomeTabela.id_$nomeColuna asc"=>"Mais antigos",
    "$nomeTabela.id_$nomeColuna desc"=>"Mais Recentes",
];


//colunas para mostrar no excel
if(isset($_GET['excel'])){
    unset($colunasParaMostrarNaTabela['funcionalidades']);
}

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

if(isset($enviado) && $enviado==0){
    $add_sql.=" and $nomeTabela.enviado=0";
}elseif(isset($enviado) && $enviado==1){
    $add_sql.=" and $nomeTabela.enviado=1";
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