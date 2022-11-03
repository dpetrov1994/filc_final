<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");


$id=$db->escape_string($_GET['idCliente']);


$sql ="insert into srv_clientes_notas (FederalTaxID,cor,id_criou,created_at,mostrar_funcionarios,notificar_administradores) values ('$id','#FEFF9C',".$_SESSION['id_utilizador'].",'".current_timestamp."','checked','')";
$result=runQ($sql,$db,2);
$id_nota=$db->insert_id;

$nota=$tpl_nota;
$nota=str_replace("_id_nota_",$id_nota,$nota);
$nota=str_replace("_nota_","",$nota);
$nota=str_replace('id="mostrarfuncionariosnota'.$id_nota.'"','id="mostrarfuncionariosnota'.$id_nota.'" checked="checked"',$nota);

$notas=str_replace("_cor_",'#FEFF9C',$notas);
$nota=str_replace("_dataCriado_",date("d/m/Y H:s",strtotime(current_timestamp)),$nota);
$nota=str_replace("_nomeCriou_",$_SESSION['nome_utilizador'],$nota);
print $nota;

$db->close();
