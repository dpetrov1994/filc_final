<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");


if(isset($_GET['id_assistencia_cliente'])){
    $id_assistencia_cliente=$db->escape_string($_GET['id_assistencia_cliente']);
    $assistencia=getInfoTabela("assistencias_clientes"," and id_assistencia_cliente=$id_assistencia_cliente");
    $assistencia=$assistencia[0];
    $tempo_pausa="00:00";
    if($assistencia['segundos_pausa'] > 0){
        $hours = floor($assistencia['segundos_pausa'] / 3600);
        $minutes = floor(($assistencia['segundos_pausa'] / 60) % 60);

        if($hours < 10){
            $hours='0'.$hours;
        }

        if($minutes < 10){
            $minutes='0'.$minutes;
        }

        $tempo_pausa = $hours.':'.$minutes;
    }
    print $tempo_pausa;
}





$db->close();