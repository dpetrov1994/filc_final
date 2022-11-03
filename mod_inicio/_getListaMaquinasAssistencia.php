<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$linhas_maquinas="";
if(isset($_GET['id_assistencia_cliente'])){
    $id_assistencia_cliente=$db->escape_string($_GET['id_assistencia_cliente']);
    $linhas_maquinas=getListaMaquinasAssistencia($id_assistencia_cliente);
}

print $linhas_maquinas;



$db->close();