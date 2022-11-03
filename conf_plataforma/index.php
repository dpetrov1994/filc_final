<?php

include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");
$content=str_replace("_idItem_",$id,$content);
$id=1;
$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"SELECT AND FILL");
if($result->num_rows!=0) {
    while ($row = $result->fetch_assoc()) {

        /**Preenchimento dos itens do formulário **/



        /**FIM Preenchimento dos itens do formulário **/

        
    }

    /**Preenchimento dos itens do formulário **/


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
                         $valor=$db->escape_string($valor);
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
            $sql = "update $nomeTabela set $colunas_e_valores where id_$nomeColuna=$id";
            $result = runQ($sql, $db, "UPDATE");
            $sql = "select * from $nomeTabela where id_$nomeColuna = $id";

            /**Operações adicionais que necessitem do $id **/



            /**FIM perações adicionais que necessitem do $id **/

            $sql="select * from $nomeTabela where id_$nomeColuna = $id";
            $result = runQ($sql, $db, "SELECT UPDATED");
            while ($row = $result->fetch_assoc()) {
                $array_log = json_encode($row);
                criarLog($db, $nomeTabela, "id_$nomeColuna", $id, "Editar", $array_log);
            }
            $location = "index.php$addUrl&cod=1";
        } else {
            $erros .= " Falta de dados para processar pedido.";
            $location = "index.php$addUrl&cod=2&erro=$erros";
        }
        header("location: $location");
    }

    $pageScript = '<script src="editar.js"></script>';
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include('../_autoData.php');

