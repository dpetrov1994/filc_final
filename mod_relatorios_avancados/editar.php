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

        include ("_criar_editar_detalhes.php");

        /**FIM Preenchimento dos itens do formulário **/

        foreach ($row as $key => $value) {
            if(!is_array($value)){
                if (is_date($value)) {
                    $value=strftime("%Y-%m-%d", strtotime($value));
                }

                if ($value == 1) { // para itens com cheked [ATENCAO: O NOME tem de vir antes do ID]
                    $content = str_replace('name="' . $key . '" id="' . $key . '"', 'name="' . $key . '" id="' . $key . '" checked=""', $content);
                }

                // PREENCHER OS CAMPOS NORMAILS [ATENCAO: O ID tem de vir antes do NOME]
                $content = str_replace('id="' . $key . '" name="' . $key . '"', 'id="' . $key . '" name="' . $key . '" value="' . $value . '"', $content);

                // PREENCHER OS SELECTS AUTOMATICOS
                $content=str_replace("class='".$key."' value='".$value."'","class='".$key."' value='".$value."' selected",$content);

            }
        }
        $content = str_replace("_descricao_", $row['descricao'], $content);
    }

    /**Preenchimento dos itens do formulário **/

    //

    /**FIM Preenchimento dos itens do formulário **/

    if (isset($_POST['submit'])) {
        $erros = "";
        $colunas_e_valores = "";
        foreach ($_POST as $coluna => $valor) {
            if (!in_array($coluna, $itensIgnorar)) {
                if (in_array($coluna, $itensObrigatorios) && $valor == "") {
                    $erros .= " Falta $coluna,";
                } else {
                    if (!is_array($valor)) {
                        if (is_data_portuguesa($valor)) {

                            $valor = data_portuguesa($valor);
                        }
                        $valor = $db->escape_string($valor);
                        $colunas_e_valores .= "$coluna='$valor',";
                    }
                }
            }
        }
        $colunas_e_valores = substr($colunas_e_valores, 0, -1) . "";

        /**Validação de itens adicionais**/

        //

        /**FIM validação de itens adicionais**/

        if ($erros == "") {
            $sql = "update $nomeTabela set $colunas_e_valores,updated_at='" . current_timestamp . "',id_editou='" . $_SESSION['id_utilizador'] . "' where id_$nomeColuna=$id";
            $result = runQ($sql, $db, "UPDATE");

            /**Operações adicionais que necessitem do $id **/

            //

            /**FIM perações adicionais que necessitem do $id **/

            $sql="select * from $nomeTabela where id_$nomeColuna = $id";
            $result = runQ($sql, $db, "SELECT UPDATED");
            while ($row = $result->fetch_assoc()) {
                $row['POST']=serialize($_POST);
                $array_log = json_encode($row);
                criarLog($db, $nomeTabela, "id_$nomeColuna", $id, "Editar", $array_log);
            }
            $location = "index.php$addUrl&cod=1";//em todos editar sair para a tabela
        } else {
            $erros .= "<br>Por favor verifique.";
            $location = "editar.php$addUrl&cod=2&erro=$erros";
        }
        header("location: $location");
    }

    $pageScript = '<script src="editar.js"></script>';
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include('../_autoData.php');

