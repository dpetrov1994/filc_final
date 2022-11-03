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

$nomeTabela="utilizadores";
$nomeColuna="utilizador";
$innerjoin="inner join grupos_utilizadores on grupos_utilizadores.id_utilizador=$nomeTabela.id_$nomeColuna";

$itensIgnorar = [ // são os itens que vêm do POST que não sao para inserir na BD
    'submit',
    'pass2',
    'notificar',
];
$itensObrigatorios = [ //intes que são obrigatórios
    'nome_'.$nomeColuna,
    'email','pass',
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
 * date::x                                  -> date onde x -> %d/%m/%Y %H:%i:%s
 * if::x=>text(x),a=>text(a),b=>text(b)      ->  onde se usa o IF
 *
 **/


$colunasParaMostrarNaTabela=[
    "checkbox" => "checkbox",
    "nome_$nomeColuna" => "value::<img src='../_contents/fotos_utilizadores/_foto_' style='background: _cor_' class='img-circle img-thumbnail img-thumbnail-avatar'> _nome_utilizador_|link|cortaNome|text::Nome",
    "email" => "link::mailto:_email_|text::Email|class::hidden-xs hidden-sm hidden-md",
    //"obs" => "cortaStr::200|class::hidden-xs hidden-sm hidden-md|text::Observações|",
    "grupos" => "text::Grupos|class::hidden-xs",
    "estado" => "text::Estado|class::hidden-xs",
    ///////////////////////////////////////////////
    "funcionalidades"=>"funcionalidades", // apagar esta linha se não quiser mostrar
];

if(isset($pre_url)){
    $colunasParaMostrarNaTabela=[
        "nome_$nomeColuna" => "link|cortaNome|text::Nome",
        "sexo" => "text::Sexo",
        "data_nascimento" => "text::Data nasc.",
        "valor_extra" => "text::(€) Extra|value::<input id='valorExtra_id_grupo_utilizador_' onblur='atualizarUtilizador(_id_grupo_utilizador_)' style='width: 100px' class='form-control' value='_valor_extra_' type='number' step='0.01'>",
        "paga" => "text::Paga?|class::text-center",
        "pago" => "text::Pago|class::text-right",
        "perfil" => "text::Perfil|class::text-right",
        ///////////////////////////////////////////////
        "funcionalidades"=>"funcionalidades", // apagar esta linha se não quiser mostrar
    ];
}

$ordenarPorDefeito="$nomeTabela.id_$nomeColuna desc";
$opcoesOrdenar=[
    "$nomeTabela.id_$nomeColuna desc"=>"ID ASC",
    "$nomeTabela.id_$nomeColuna desc"=>"ID DESC",
    "$nomeTabela.nome_$nomeColuna asc"=>"Nome ASC",
    "$nomeTabela.nome_$nomeColuna desc"=>"Nome DESC",
    "$nomeTabela.descricao asc"=>"Observações ASC",
    "$nomeTabela.descricao desc"=>"Observações DESC"
];

$colunas=Array(); // colunas nnas quais se pesquisa

/** Tirar comentário se exisitr outra tabela na qual pode-se fazer pesquisa */


$sql="SHOW COLUMNS FROM grupos";
$result=runQ($sql,$db,"colunas");
while ($row = $result->fetch_assoc()) {
    array_push($colunas,"grupos.".$row['Field']);
}

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