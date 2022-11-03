<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$id=$db->escape_string($_POST['id_cliente']);
$latitude=$db->escape_string($_POST['latitude']);
$nome=$db->escape_string($_POST['nome']);
$longitude=$db->escape_string($_POST['longitude']);

$nif="";
$nif_ela="";
$nif_iberia="";
$sql="select * from srv_clientes where CustomerID='$id'";
$result=runQ($sql,$db,1);
while ($row = $result->fetch_assoc()) {
    $nif=$row['FederalTaxID'];
}

if(isset($_POST['criar'])){
    $sql="insert into srv_clientes_geo (id_cliente,nif,id_utilizador,latitude,longitude,nome_geo) values ('".$id."','".$nif."','".$_SESSION['id_utilizador']."','".$latitude."','".$longitude."','".$nome."')";
    $result=runQ($sql,$db,1);
}elseif(isset($_POST['editar'])){
    $id_geo=$db->escape_string($_POST['id_geo']);
    $sql="update srv_clientes_geo set latitude='$latitude',longitude='$longitude',nome_geo='$nome',id_utilizador='".$_SESSION['id_utilizador']."' where id_geo='$id_geo'";
    $result=runQ($sql,$db,1);
}



$db->close();

header("location:detalhes.php?id=$id&cod=1");