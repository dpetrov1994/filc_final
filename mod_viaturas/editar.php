<?php

include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("editar.tpl");
$content=str_replace("_idItem_",$id,$content);
$sql="select * from $nomeTabela $innerjoin where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"SELECT AND FILL");
if($result->num_rows!=0) {
    while ($row = $result->fetch_assoc()) {

        /**Preenchimento dos itens do formulário **/

        include ("_criar_editar_detalhes.php");

        /**FIM Preenchimento dos itens do formulário **/

        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);
    }

    /**Preenchimento dos itens do formulário **/

    //

    /**FIM Preenchimento dos itens do formulário **/

    if (isset($_POST['submit'])) {

        $id_estado = $db->escape_string($_POST['id_estado_viatura']);
        unset($_POST['id_estado_viatura']);

        $return=colunas_valores_editar($_POST,$db,$itensIgnorar,$itensObrigatorios);
        $colunas_e_valores=$return['colunas_e_valores'];
        $erros=$return['erros'];

        /**Validação de itens adicionais**/

        //

        /**FIM validação de itens adicionais**/

        if ($erros == "") {

            $info_viatura_atual = getInfoTabela('viaturas', 'and id_viatura="'.$id.'"');

            $sql = "update $nomeTabela set $colunas_e_valores,updated_at='" . current_timestamp . "',id_editou='" . $_SESSION['id_utilizador'] . "' where id_$nomeColuna=$id";
            $result = runQ($sql, $db, "UPDATE");

            /**Operações adicionais que necessitem do $id **/

            $sql = "delete from estados_viaturas_linhas where id_viatura=$id";
            $result = runQ($sql, $db, "delete");

            $sql="insert into estados_viaturas_linhas (id_estado, id_viatura) values ($id_estado,$id)";
            $result=runQ($sql,$db,"INSERT");

            if($info_viatura_atual[0]['id_tecnico']!=$_POST['id_tecnico']){
                UpdateTabela('viaturas_tecnicos_historico','data_fim="'.current_timestamp.'"'," and id_viatura='$id'  ORDER BY id_historico DESC LIMIT 1");
                insertIntoTabela('viaturas_tecnicos_historico','id_viatura, de_tecnico, para_tecnico, created_at',"'$id', '".$info_viatura_atual[0]['id_tecnico']."', '".$db->escape_string($_POST['id_tecnico'])."', '".current_timestamp."'");
            }

            /**FIM perações adicionais que necessitem do $id **/

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

