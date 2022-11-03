<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("criar.tpl");
$content=str_replace("_descricao_","",$content);

/**Preenchimento dos itens do formulário **/

include "_criar_editar_detalhes.php";

/**FIM Preenchimento dos itens do formulário **/


if(isset($_POST['submit'])){
    $erros="";
    $colunas="";
    $valores="";
    $scripts="";

    if(isset($_FILES['file'])) {
        $_POST['foto'] = carregar_foto($_FILES['file'], $cfg_tamanhoMaxUpload);
    }

    $return=colunas_valores_criar($_POST,$db,$itensIgnorar,$itensObrigatorios,$subModulo,$colunaParent,$idParent);
    $erros=$return['erros'];
    $colunas=$return['colunas'];
    $valores=$return['valores'];

    /**Validação de itens adicionais**/



    /**FIM validação de itens adicionais**/

    if($erros==""){
        $sql="insert into $nomeTabela ($colunas,id_criou,created_at) values ($valores,'".$_SESSION['id_utilizador']."','".current_timestamp."')";
        $result=runQ($sql,$db,"INSERT");
        $insert_id=$db->insert_id;

        /**Operações adicionais que necessitem do $insert_id **/

        foreach ($_POST['funcionalidades'] as $funcionalidade){
            $funcionalidade=explode("|",$funcionalidade);
            $id_modulo=$funcionalidade[0];
            $id_funcionalidade=$funcionalidade[1];
            $sql="insert into grupos_modulos_funcionalidades (id_grupo, id_funcionalidade, id_modulo) VALUES ('$insert_id','$id_funcionalidade','$id_modulo')";
            $result=runQ($sql,$db,"ACESSOS");
        }

        foreach ($_POST['grupos'] as $cominica_com){
            $sql="insert into grupos_mensagens (id_grupo, comunica_com) VALUES ('$insert_id','$cominica_com')";
            $result=runQ($sql,$db,"GRUPOS MENSAGENS");
        }

        /**FIM perações adicionais que necessitem do $insert_id **/

        $sql="select * from $nomeTabela where id_$nomeColuna = $insert_id";
        $result=runQ($sql,$db,"SELECT INSERTED");
        while ($row = $result->fetch_assoc()) {
            $array_log=json_encode($row);
            criarLog($db,$nomeTabela,"id_$nomeColuna",$insert_id,"Criar",$array_log);
        }

        $location="editar.php?$addUrl&cod=3";
        if($subModulo==0){
            $location.="&id=$insert_id";
        }else{
            $location.="&subItemID=$insert_id";
        }


    }else{
        $erros.=" Falta de dados para processar pedido.";
        $location="criar.php$addUrl&cod=2&erro=$erros";
    }
    header("location: $location");
}
$pageScript='<script src="criar.js"></script>';
include ('../_autoData.php');