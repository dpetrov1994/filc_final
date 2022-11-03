<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */

$adddd_sql="";
$selected="";
if(isset($_GET['id_cliente'])){
    $adddd_sql = " and id_cliente='".$db->escape_string($_GET['id_cliente'])."'";
    $selected="selected";
}

                    $sql_preencher="select * from srv_clientes where 1 $adddd_sql";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {

                        $ops.="<option $selected class='id_cliente' value='".$row_preencher["id_cliente"]."'>".$row_preencher["OrganizationName"]."</option>";
                    }
                    $content=str_replace("_id_cliente_",$ops,$content);