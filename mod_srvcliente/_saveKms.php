<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$value=$db->escape_string($_GET['kms']);
$id=$db->escape_string($_GET['idCliente']);


$sql ="update srv_clientes set kilometros='$value' WHERE id_cliente='$id'";
$result=runQ($sql,$db,2);

$db->close();
print 0;