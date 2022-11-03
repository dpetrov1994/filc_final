<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */

$id_cliente=0;
if(isset($_GET['id_cliente'])){
    $id_cliente=$_GET['id_cliente'];
}
$sql_preencher="select * from srv_clientes where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $selected=0;
    if($id_cliente==$row_preencher["id_cliente"] && $id_cliente!=0){
        $selected="selected";
    }
    $ops.="<option $selected class='id_cliente' value='".$row_preencher["id_cliente"]."'>".$row_preencher["OrganizationName"]."</option>";
}
$content=str_replace("_id_cliente_",$ops,$content);
