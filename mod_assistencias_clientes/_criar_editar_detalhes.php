<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */


$sql_preencher="select * from srv_clientes where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<option class='id_cliente' value='".$row_preencher["id_cliente"]."'>".$row_preencher["OrganizationName"]."</option>";
}
$content=str_replace("_id_cliente_",$ops,$content);

$sql_preencher="select * from utilizadores where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<option class='id_utilizador' value='".$row_preencher["id_utilizador"]."'>".$row_preencher["nome_utilizador"]."</option>";
}
$content=str_replace("_id_utilizador_",$ops,$content);

$sql_preencher="select * from assistencias_categorias where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<option class='id_categoria' value='".$row_preencher["id_categoria"]."'>".$row_preencher["nome_categoria"]."</option>";
}
$content=str_replace("_id_categoria_",$ops,$content);

$id_cliente=0;
$add_sql_cliente="";
if(isset($row['id_cliente'])){
    $id_cliente=$row['id_cliente'];
    $add_sql_cliente=" and id_cliente='$id_cliente'";
}

$sql_preencher="select * from clientes_contratos where ativo=1 $add_sql_cliente";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<option class='id_contrato' value='".$row_preencher["id_contrato"]."'>".$row_preencher["nome_contrato"]."</option>";
}
$content=str_replace("_id_contrato_",$ops,$content);


$linhas_maquinas="";
$id_assistencia_cliente="";
if(isset($row['id_assistencia_cliente'])){
    $id_assistencia_cliente=$db->escape_string($row['id_assistencia_cliente']);
    $linhas_maquinas=getListaMaquinasAssistencia($id_assistencia_cliente);
}
$content=str_replace("_maquinasassistencia_",$linhas_maquinas,$content);
$content=str_replace("_id_assistencia_cliente_",$id_assistencia_cliente,$content);
