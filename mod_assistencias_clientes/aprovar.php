<?php
include "../_funcoes.php";
$db=ligarBD();
include "../login/valida.php";
include "../conf/dados_plataforma.php";
include ".cfg.php";

/**
 * acao iten único
 */

if(isset($_POST['id_assistencia_cliente'])){
    $_GET['id']=$_POST['id_assistencia_cliente'];
    $id=$db->escape_string($_POST['id_assistencia_cliente']);
}


if(isset($id)) {
    $sql="select * from $nomeTabela where id_$nomeColuna='$id'";
    $result=runQ($sql,$db,"CHECK RECICLAR UM");
    if($result->num_rows!=0){
        while ($row = $result->fetch_assoc()) {
            $aprovado=$row['aprovado'];
        }

        if($aprovado==0){
            $aprovado=1;
            $txt="Aprovado";
            $data=current_timestamp;
        }else{
            $aprovado=0;
            $txt="Desaprovado";
            $data="0000-00-00 00:00:00";
        }

        $obs="";
        if(isset($_POST['obs_faturar'])){
            $obs=$db->escape_string($_POST['obs_faturar']);
            $obs=",obs_faturar='$obs'";
        }

        $sql="update $nomeTabela set aprovado=$aprovado, data_aprovado='$data' $obs where id_$nomeColuna='$id'";
        $result=runQ($sql,$db,"RECICLAR UM");
        criarLog($db,"$nomeTabela","id_$nomeColuna",$id,$txt,null);
        if(isset($_POST['id_assistencia_cliente'])){
            $db->close();
            die();
        }
        if(isset($_GET['from'])){
            header("location: ".$_GET['from']);
        }
    }
}
$db->close();