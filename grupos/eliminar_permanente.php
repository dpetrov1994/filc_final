<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents($layoutDirectory."/loading.tpl");
/**
 * acao vários itens
 */
if(isset($_POST['checkboxes'])) {
    $checkboxes=($_POST['checkboxes']);
    foreach ($checkboxes as $checkbox){
        $id=$db->escape_string($checkbox);
        $sql="select * from $nomeTabela where id_$nomeColuna='$id'";
        $result=runQ($sql,$db,"CHECK ELIMINAR VARIOS");
        if($result->num_rows!=0){
            if($id!="1" && $id!="2") {
                $sql = "delete from $nomeTabela where id_$nomeColuna='$id'";
                $result = runQ($sql, $db, "ELIMINAR VARIOS");
            }
            //apagar fichieros e limpar outras tabelas relacionadas



            //apagar fichieros e limpar outras tabelas relacionadas

            criarLog($db,"$nomeTabela","id_$nomeColuna",$id,"Eliminar Permanente",null);
        }
    }
    include('../_autoData.php');
    print "<script>window.history.back();</script>";
    die();
}

/**
 * acao iten único
 */
if(isset($id)) {
    $sql="select * from $nomeTabela where id_$nomeColuna='$id'";
    $result=runQ($sql,$db," CHECK ELIMINAR UM");
    if($result->num_rows!=0){
        if($id!="1" && $id!="2") {
            $sql = "delete from $nomeTabela where id_$nomeColuna='$id'";
            $result = runQ($sql, $db, "ELIMINAR UM");
        }

        //apagar fichieros e limpar outras tabelas relacionadas



        //apagar fichieros e limpar outras tabelas relacionadas

        criarLog($db,"$nomeTabela","id_$nomeColuna",$id,"Eliminar Permanente",null);
    }
}
include('../_autoData.php');
print "<script>window.history.back();</script>";