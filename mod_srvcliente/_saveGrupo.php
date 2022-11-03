<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$value=$db->escape_string($_GET['grupo']);
$id=$db->escape_string($_GET['idCliente']);

$isolado=0;
if($value!=""){
    $isolado=1;
}

$sql ="update srv_clientes_informacao set grupo='$value',isolado='$isolado' WHERE FederalTaxID='$id'";
$result=runQ($sql,$db,2);

$db->close();
print 0;