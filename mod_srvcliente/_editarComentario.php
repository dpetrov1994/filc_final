<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$id=$db->escape_string($_GET['id']);
$descricao=$db->escape_string($_GET['descricao']);


$sql ="update srv_clientes_notas set descricao='$descricao', id_editou=".$_SESSION['id_utilizador'].", updated_at='".current_timestamp."' where id_nota='$id'";
$result=runQ($sql,$db,2);

print 0;
$db->close();
