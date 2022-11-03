<?php

include ('../_template.php');
include ".cfg.php";


$sql_preencher="select * from srv_clientes where ativo=1 and srv_clientes.PartyID != '' order by OrganizationName asc";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<option class='id_cliente' value='".$row_preencher["id_cliente"]."'>".$row_preencher["nome_cliente"]."</option>";
}

print $ops;
$db->close();