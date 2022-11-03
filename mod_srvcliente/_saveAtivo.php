<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$value=$db->escape_string($_GET['ativo']);
$id=$db->escape_string($_GET['idCliente']);


$sql ="update srv_clientes_informacao set ativo='$value' WHERE FederalTaxID='$id'";

$result=runQ($sql,$db,2);

$db->close();
print 0;