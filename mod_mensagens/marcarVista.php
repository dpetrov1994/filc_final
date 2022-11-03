<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$id=$db->escape_string($_GET['id']);
$sql="update utilizadores_mensagens set visto_em='".current_timestamp."' where id_mensagem='$id' and id_utilizador='".$_SESSION['id_utilizador']."'";
//$result=runQ($sql,$db,1); -> temporariamente desativado para demo

$db->close();