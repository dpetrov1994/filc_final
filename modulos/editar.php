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


        $sql_preencher="select * from modulos";
        $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
        $ops="";
        while ($row_preencher = $result_preencher->fetch_assoc()) {
            $ops.="<option class='id_parent' value='".$row_preencher["id_modulo"]."'>".$row_preencher["nome_modulo"]."</option>";
        }
        $content=str_replace("_id_parent_",$ops,$content);

        /**FIM Preenchimento dos itens do formulário **/


        foreach ($row as $key => $value) {
            if (is_date($value)) {
                $value = strftime("%d/%m/%Y", strtotime($value));
            }

            if ($value == 1) { // para itens com cheked [ATENCAO: O NOME tem de vir antes do ID]
                $content = str_replace('name="' . $key . '" id="' . $key . '"', 'name="' . $key . '" id="' . $key . '" checked=""', $content);
            }

            // PREENCHER OS CAMPOS NORMAILS [ATENCAO: O ID tem de vir antes do NOME]
            $content = str_replace('id="' . $key . '" name="' . $key . '"', 'id="' . $key . '" name="' . $key . '" value="' . $value . '"', $content);

            // PREENCHER OS SELECTS AUTOMATICOS
            $content=str_replace("class='".$key."' value='".$value."'","class='".$key."' value='".$value."' selected",$content);

        }
        $content = str_replace("_descricao_", $row['descricao'], $content);
    }

    /**Preenchimento dos itens do formulário **/

    //

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

            //
            unset($_SESSION['modulos']);
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

