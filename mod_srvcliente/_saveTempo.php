<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$value=$db->escape_string($_GET['tempo']);
$id=$db->escape_string($_GET['idCliente']);

$segundos_viagem=0;
if($value!=""){
    $tempo_viagem = explode(':',$value);

    $segundos_viagem = ($tempo_viagem[0] * 60) * 60; // HORAS EM SEGUNDOS
    $segundos_viagem += ($tempo_viagem[1] * 60); // MINUTOS EM SEGUNDOS
}


$sql ="update srv_clientes set tempo_viagem='$segundos_viagem' WHERE id_cliente='$id'";
$result=runQ($sql,$db,2);

$db->close();
print 0;