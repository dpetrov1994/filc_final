<?php
include ("../../_funcoes.php");
include ("../../conf/dados_plataforma.php");

if(isset($_GET['data'])){
    $db=ligarBD("ajax");

    $data=$db->escape_string($_GET['data']);

    $linha='<span class="horas" style="height:40px "><input id="hora_c_" name="bloco_horas" type="radio" value="_val_" _disabled_ required/><label for="hora_c_"><div class="rectangle _disabled_">_val_</div></label></span>';
    $linhas="";
    $c=0;
    foreach ($_SESSION['blocos_marcacoes'] as $bloco){
        $tmp=explode(" - ",$bloco);
        $hora_inicio=$tmp[0];
        $hora_fim=$tmp[1];

        $data_inicio=$data." $hora_inicio:00";
        $data_fim=$data." $hora_fim:00";
        $sql="select * from marcacoes where ativo=1 and confirmado=1 and data_inicio='$data_inicio' and data_fim='$data_fim'";
        $result=runQ($sql,$db,"select atual");
        $disabled="";
        if($result->num_rows>0){
            $disabled="disabled";
        }

        $linhas.=$linha;
        $linhas=str_replace("_val_",$bloco,$linhas);
        $linhas=str_replace("_c_",$c,$linhas);
        $c++;
        $linhas=str_replace("_disabled_",$disabled ,$linhas);
    }


    print $linhas;

    $db->close();

}