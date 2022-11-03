<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

$id="";
$add_sql="";
if(isset($_GET['idCliente']) && $_GET['idCliente']!=0){
    $id=$db->escape_string($_GET['idCliente']);
    $nif="";
    $nif_ela="";
    $nif_iberia="";
    $sql="select * from srv_clientes where CustomerID='$id'";
    $result=runQ($sql,$db,1);
    while ($row = $result->fetch_assoc()) {
        $nif=$row['FederalTaxID'];
    }

    $add_sql=" and t1.nif ='$nif'";
}


$markers=[];

$count=0;
$sql="select t1.latitude,t1.longitude,alfabetico,alfabetico,t1.id_cliente,nome_geo,id_utilizador from srv_clientes_geo as t1 inner join srv_clientes_informacao on srv_clientes_informacao.FederalTaxID=t1.nif where t1.latitude!=0 and t1.longitude!=0 $add_sql group by id_geo";
$result=runQ($sql,$db,1);
while ($row = $result->fetch_assoc()) {
    $e=array();
    $e['latitude']=$row['latitude'];
    $e['longitude']=$row['longitude'];
    $nome_utilizador="";
    $sql2="select nome_utilizador from utilizadores where id_utilizador='".$row['id_utilizador']."'";
    $result2=runQ($sql2,$db,1);
    while ($row2 = $result2->fetch_assoc()) {
        $nome_utilizador=$row2['nome_utilizador'];
    }

    $e['popup']="
    Cliente: <a href='../mod_srvcliente/detalhes.php?id=".$row['id_cliente']."'>".$row['id_cliente']." ".$row['alfabetico']."</a><br>
    <p class='text-center'>
        <b>".$row['nome_geo']."</b><br>
        <a target=\"_blank\" href=\"geo:".$row['latitude'].",".$row['longitude']."?q=".$row['latitude'].",".$row['longitude']."\"> Abrir no: <img src=\"maps.png\" style=\"width: 30px\"></a>
    </p>
    <small>Inserido por: $nome_utilizador</small>
";
    $e['open']=0;
    array_push($markers,$e);
}
print json_encode($markers);



$db->close();