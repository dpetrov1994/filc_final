<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");


if(isset($_GET['id_assistencia_cliente'])){
    $id_assistencia_cliente=$db->escape_string($_GET['id_assistencia_cliente']);
    $assistencia=getInfoTabela("assistencias_clientes"," and id_assistencia_cliente=$id_assistencia_cliente");
    $assistencia=$assistencia[0];
    print $assistencia['obs_faturar'];
}



$db->close();