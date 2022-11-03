<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$id=$db->escape_string($_GET['id']);
$cor=$db->escape_string($_GET['cor']);
$data_lembrete=$db->escape_string($_GET['data_lembrete']);
$descricao=$db->escape_string($_GET['descricao']);
$notificar_administradores=$db->escape_string($_GET['notificar_administradores']);
$mostrar_funcionarios=$db->escape_string($_GET['mostrar_funcionarios']);

if($notificar_administradores=="true"){
    $notificar_administradores="checked";
}else{
    $notificar_administradores="";
}
if($mostrar_funcionarios=="true"){
    $mostrar_funcionarios="checked";
}else{
    $mostrar_funcionarios="";
}


$sql ="update srv_clientes_notas set mostrar_funcionarios='$mostrar_funcionarios',notificar_administradores='$notificar_administradores',cor='$cor',data_lembrete='$data_lembrete', descricao='$descricao', id_editou=".$_SESSION['id_utilizador'].", updated_at='".current_timestamp."' where id_nota='$id'";
$result=runQ($sql,$db,2);

print 0;

$db->close();
