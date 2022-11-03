<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");


if(isset($_GET['id_assistencia_cliente'])){
    $id_assistencia_cliente=$db->escape_string($_GET['id_assistencia_cliente']);
    $assistencia=getInfoTabela("assistencias_clientes"," and id_assistencia_cliente=$id_assistencia_cliente");
    $assistencia=$assistencia[0];
    if($assistencia['inicio_pausa']=="0000-00-00 00:00:00"){//iniciar pausa
        print "em-pausa";
        UpdateTabela("assistencias_clientes","inicio_pausa='".current_timestamp."'"," and id_assistencia_cliente=$id_assistencia_cliente ");
    }else{//terminar pausa
        print "em-curso";
        $segundos_pausa=strtotime(current_timestamp)-strtotime($assistencia['inicio_pausa']);
        $segundos_pausa=$assistencia['segundos_pausa']+$segundos_pausa;
        UpdateTabela("assistencias_clientes","inicio_pausa='0000-00-00 00:00:00', segundos_pausa='$segundos_pausa'"," and id_assistencia_cliente=$id_assistencia_cliente ");
    }
}





$db->close();