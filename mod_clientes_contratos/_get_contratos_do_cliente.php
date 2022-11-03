<?php

include "../login/valida.php";
include "../_funcoes.php";

$db=ligarBD();
$id_cliente=0;
if(isset($_GET['id_cliente'])){
    $id_cliente=$db->escape_string($_GET['id_cliente']);
}

$ops="<option>Selecione...</option>";
$sql="select * from clientes_contratos where id_cliente='$id_cliente'";
$result=runQ($sql,$db,"ajax contratos");
while ($row = $result->fetch_assoc()) {
    $ops.="<option class='id_contrato' value='".$row["id_contrato"]."'>".$row["nome_contrato"]."</option>";
}
print $ops;


$db->close();