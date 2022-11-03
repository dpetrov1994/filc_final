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
        $result=runQ($sql,$db,"CHECK RECICLAR MULTIPLOS");
        if($result->num_rows!=0){
            while ($row = $result->fetch_assoc()) {
                $ativo=$row['ativo'];
            }
            if($ativo==1){
                $ativo=0;
                $txt="Mover para a Reciclagem";
            }else{
                $ativo=1;
                $txt="Recuperar da Reciclagem";
            }

            $sql="update $nomeTabela set ativo=$ativo where id_$nomeColuna='$id'";
            $result=runQ($sql,$db,"RECICLAR MULTIPLOS");
            criarLog($db,"$nomeTabela","id_$nomeColuna",$id,$txt,null);
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
    $result=runQ($sql,$db,"CHECK RECICLAR UM");
    if($result->num_rows!=0){
        while ($row = $result->fetch_assoc()) {
            $ativo=$row['ativo'];
        }
        if($ativo==1){
            $ativo=0;
            $txt="Mover para a Reciclagem";
        }else{
            $ativo=1;
            $txt="Recuperar da Reciclagem";
        }
        $sql="update $nomeTabela set ativo=$ativo where id_$nomeColuna='$id'";
        $result=runQ($sql,$db,"RECICLAR UM");
        criarLog($db,"$nomeTabela","id_$nomeColuna",$id,$txt,null);
    }
}
include('../_autoData.php');
print "<script>window.history.back();</script>";