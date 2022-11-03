<?php

include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("editar.tpl");
$content=str_replace("_idItem_",$id,$content);
$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"SELECT AND FILL");
if($result->num_rows!=0) {
    while ($row = $result->fetch_assoc()) {

        /**Preenchimento dos itens do formulário **/

        include "_criar_editar_detalhes.php";

        /**FIM Preenchimento dos itens do formulário **/

        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);
    }

    /**Preenchimento dos itens do formulário **/

    $sql="select * from grupos_modulos_funcionalidades WHERE id_grupo='$id'";
    $result=runQ($sql,$db,"FILL ACESSOS");
    while ($row = $result->fetch_assoc()) {
        $content=str_replace('value="'.$row['id_modulo'].'|'.$row['id_funcionalidade'].'"','value="'.$row['id_modulo'].'|'.$row['id_funcionalidade'].'" checked',$content);
    }

    $sql="select * from grupos_mensagens WHERE id_grupo='$id'";
    $result=runQ($sql,$db,"FILL grupos");
    while ($row = $result->fetch_assoc()) {
        $content=str_replace("class='grupos' value='".$row['comunica_com']."'","class='grupos' value='".$row['comunica_com']."' selected",$content);
    }

    /**FIM Preenchimento dos itens do formulário **/

    if (isset($_POST['submit'])) {
        $return=colunas_valores_editar($_POST,$db,$itensIgnorar,$itensObrigatorios);
        $colunas_e_valores=$return['colunas_e_valores'];
        $erros=$return['erros'];

        /**Validação de itens adicionais**/

        //

        /**FIM validação de itens adicionais**/

        if ($erros == "") {
            $sql = "update $nomeTabela set $colunas_e_valores,updated_at='" . current_timestamp . "',id_editou='" . $_SESSION['id_utilizador'] . "' where id_$nomeColuna=$id";
            $result = runQ($sql, $db, "UPDATE");
            $sql = "select * from $nomeTabela where id_$nomeColuna = $id";

            /**Operações adicionais que necessitem do $id **/

            $sql="delete from grupos_modulos_funcionalidades where id_grupo='$id'";
            $result=runQ($sql,$db,"DELETE ACESSOS");
            foreach ($_POST['funcionalidades'] as $funcionalidade){
                $funcionalidade=explode("|",$funcionalidade);
                $id_modulo=$funcionalidade[0];
                $id_funcionalidade=$funcionalidade[1];
                $sql="insert into grupos_modulos_funcionalidades (id_grupo, id_funcionalidade, id_modulo) VALUES ('$id','$id_funcionalidade','$id_modulo')";
                $result=runQ($sql,$db,"ACESSOS");
            }

            $sql="delete from grupos_mensagens where id_grupo='$id'";
            $result=runQ($sql,$db,"DELETE GRUPOS MENSAGENS");
            foreach ($_POST['grupos'] as $cominica_com){
                $sql="insert into grupos_mensagens (id_grupo, comunica_com) VALUES ('$id','$cominica_com')";
                $result=runQ($sql,$db,"GRUPOS MENSAGENS");
            }

            /**FIM perações adicionais que necessitem do $id **/

            unset($_SESSION['modulos']);

            selectForLog($db,$nomeTabela,$nomeColuna,$id);
            $location = "editar.php$addUrl&cod=1";
        } else {
            $erros .= " Falta de dados para processar pedido.";
            $location = "editar.php$addUrl&cod=2&erro=$erros";
        }
        header("location: $location");
    }

    $pageScript = '<script src="editar.js"></script>';
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include('../_autoData.php');

