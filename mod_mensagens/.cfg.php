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

$nomeTabela="mensagens";
$nomeColuna="mensagem";
$innerjoin=" inner join utilizadores on utilizadores.id_utilizador=$nomeTabela.id_criou 
            inner join utilizadores_mensagens on utilizadores_mensagens.id_mensagem=$nomeTabela.id_$nomeColuna";
$add_sql.="";

$itensIgnorar = [ // são os itens que vêm do POST que não sao para inserir na BD
    'submit',
];
$itensObrigatorios = [ //intes que são obrigatórios
    'nome_'.$nomeColuna,
    'utilizadores',
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
    //"checkbox" => "checkbox",
    "estrela" => "text::|style::width:40px|class::text-right|if::1=><i id='estrela_idUtilizadorMensagem_' class=' fa fa-2x fa-star text-warning' onclick='marcarEstrela(_idUtilizadorMensagem_)'></i>,,0=><span onclick='marcarEstrela(_idUtilizadorMensagem_)' id='estrela_idUtilizadorMensagem_' class='fa fa-2x fa-star-o text-warning'></span>",
    "nome_utilizador" => "><br><small>_nome_utilizador_</small>|func::cortaNome",
    "nome_mensagem" => "link::abrir.php?id=_id_mensagem_&u=_id_utilizador_|text::|value::_estado_ <h4><strong>_nome_mensagem_</strong></h4><span class=\"text-muted\">_descricaoMensagem_</span>|cortaStr::50",
    "descricaoMensagem" => "class::hidden|cortaStr::100",
    "anexos" => "style::width: 20px;|text::|class::hidden-xs text-right",
    "created_atMensagem" => "style::width: 150px;padding-right:20px|class::hidden-xs text-right|text::|value::_created_atMensagem_ atrás<br> _dataMensagem_ |func::humanTiming|class::text-center",
    ///////////////////////////////////////////////
    "funcionalidades"=>"funcionalidades", // apagar esta linha se não quiser mostrar
];

$ordenarPorDefeito="$nomeTabela.created_at desc";
$opcoesOrdenar=[
    "$nomeTabela.id_$nomeColuna desc"=>"ID ASC",
    "$nomeTabela.id_$nomeColuna desc"=>"ID DESC",
    "$nomeTabela.nome_$nomeColuna asc"=>"Nome ASC",
    "$nomeTabela.nome_$nomeColuna desc"=>"Nome DESC",
    "$nomeTabela.created_at desc"=>"Data ASC",
    "$nomeTabela.created_at desc"=>"Data DESC"
];

$colunas=Array(); // colunas nnas quais se pesquisa

/** Tirar comentário se exisitr outra tabela na qual pode-se fazer pesquisa */

$sql="SHOW COLUMNS FROM utilizadores";
$result=runQ($sql,$db,"colunas");
while ($row = $result->fetch_assoc()) {
    array_push($colunas,"utilizadores.".$row['Field']);
}

//elementos da reciclagem
if(isset($ativo) && $ativo==0){
    $add_sql.=" and utilizadores_mensagens.ativo=0";
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