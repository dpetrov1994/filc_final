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
            $faturado=$row['faturado'];
        }
        if($faturado==0){
            $faturado=1;
            $txt="Faturado";
            $data=current_timestamp;
        }else{
            $faturado=0;
            $txt="Cancelar faturado";
            $data="0000-00-00 00:00:00";
        }

        $aprovao="";
        if(isset($_GET['force'])){
            $faturado=1;
            $txt="Faturado";
            $aprovao=" ,aprovado=1";
        }


        $sql="update $nomeTabela set faturado=$faturado,data_faturado='$data' $aprovao where id_$nomeColuna='$id'";
        $result=runQ($sql,$db,"RECICLAR UM");
        criarLog($db,"$nomeTabela","id_$nomeColuna",$id,$txt,null);
        if(isset($_GET['from'])){
            header("location: ".$_GET['from']);
        }
    }
}
$db->close();
