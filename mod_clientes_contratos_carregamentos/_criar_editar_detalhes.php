<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */


if(!isset($id_cliente)){
    $id_cliente=0;
}
if(!isset($id_contrato)){
    $id_contrato=0;
}
                    $sql_preencher="select * from srv_clientes where ativo=1";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {
                        $selected="";
                        if($id_cliente==$row_preencher['id_cliente']){
                            $selected="selected";
                        }
                        $ops.="<option $selected class='id_cliente' value='".$row_preencher["id_cliente"]."'>".$row_preencher["OrganizationName"]."</option>";
                    }
                    $content=str_replace("_id_cliente_",$ops,$content);
                    $sql_preencher="select * from clientes_contratos where ativo=1";
                    $result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
                    $ops="";
                    while ($row_preencher = $result_preencher->fetch_assoc()) {
                        $selected="";
                        if($id_contrato==$row_preencher['id_contrato']){
                            $selected="selected";
                        }
                        $ops.="<option $selected class='id_contrato' value='".$row_preencher["id_contrato"]."'>".$row_preencher["nome_contrato"]."</option>";
                    }
                    $content=str_replace("_id_contrato_",$ops,$content);