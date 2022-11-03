<?php
include "../_funcoes.php";
$db=ligarBD();
include "../login/valida.php";
include "../conf/dados_plataforma.php";
include ".cfg.php";

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
        if($ativo==0){
            $ativo=1;
            $txt="Restaurar";
        }else{
            $ativo=0;
            $txt="Eliminar";
        }
        $sql="update $nomeTabela set ativo=$ativo where id_$nomeColuna='$id'";
        $result=runQ($sql,$db,"RECICLAR UM");
        criarLog($db,"$nomeTabela","id_$nomeColuna",$id,$txt,null);
        if(isset($_GET['from'])){
            header("location: ".$_GET['from']);
        }
    }
}
$db->close();