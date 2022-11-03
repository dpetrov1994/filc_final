<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$value=$db->escape_string($_GET['estrela']);
$id=$db->escape_string($_GET['id']);

$sql="update utilizadores_mensagens set estrela='$value' where id_utilizador_mensagem='$id'";
$result=runQ($sql,$db,1);

print $sql;

$db->close();