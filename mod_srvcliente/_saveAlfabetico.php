<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$value=$db->escape_string($_GET['alfabetico']);
$id=$db->escape_string($_GET['idCliente']);


$sql ="update srv_clientes_informacao set alfabetico='$value' WHERE FederalTaxID='$id'";
$result=runQ($sql,$db,2);

$db->close();
print 0;