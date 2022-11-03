<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */

if(isset($row)){
    $content=str_replace('id="data_inicio" name="data_inicio"', 'id="data_inicio" 1 name="data_inicio" value="'.date('Y-m-d\TH:i', strtotime($row['data_inicio'])).'"', $content);
    $content=str_replace('id="data_fim" name="data_fim"', 'id="data_fim" 1 name="data_fim" value="'.date('Y-m-d\TH:i', strtotime($row['data_fim'])).'"', $content);


    if($row['externa'] == "0"){
        $content=str_replace('checked name="externa" id="externa"','name="externa" id="externa"', $content);
    }else{
        $content=str_replace('checked name="externa" id="externa"','name="externa" id="externa"', $content);
    }

}

$add_c="";
if($_SESSION['comercial']==1){
    $add_c=" and id_utilizador=".$_SESSION['id_utilizador'];
}
$sql_preencher="select * from utilizadores where ativo=1 $add_c";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {

    $selected="";
    if(!isset($row) && ($_SESSION['tecnico']==1) || $_SESSION['comercial']==1){
        if($row_preencher['id_utilizador'] == $_SESSION['id_utilizador']){
            $selected = "selected";
        }
    }else{
        if($row_preencher['id_utilizador'] == $row['id_utilizador']){
            $selected = "selected";
        }
    }

    $ops.="<option class='id_utilizador' $selected value='".$row_preencher["id_utilizador"]."'>".$row_preencher["nome_utilizador"]."</option>";
}
$content=str_replace("_id_utilizador_",$ops,$content);


$sql_preencher="select * from srv_clientes where ativo=1 and OrganizationName <> ''";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<option class='id_cliente' value='".$row_preencher["id_cliente"]."'>".$row_preencher["OrganizationName"]."</option>";
}
$content=str_replace("_clientes_",$ops,$content);


$add_c="";
if($_SESSION['comercial']==1){
    $add_c=" and comercial=".$_SESSION['comercial'];
}

$sql_preencher="select * from assistencias_categorias where ativo=1 $add_c";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<label  class='csscheckbox csscheckbox-primary'><input type='radio' name='id_categoria' id='id_categoria' value='".$row_preencher["id_categoria"]."'><span></span> <div class='label' style='background: ".$row_preencher["cor_cat"]."'>".$row_preencher["nome_categoria"]."</div></label><br> ";
}
$content=str_replace("_id_categoria_",$ops,$content);


if($_SESSION['tecnico']==1){
    $content=str_replace("[ESCONDER-PARA-TECNICOS]","hidden",$content);
    $content=str_replace("[ESCONDER-PARA-ADMINS]","",$content);
}else{
    $content=str_replace("[ESCONDER-PARA-TECNICOS]","",$content);
    $content=str_replace("[ESCONDER-PARA-ADMINS]","hidden",$content);
}


//enviado pelo geral.js da funcao getHtmlCriarAjax()
if(isset($_GET['tipo_assistencia'])){
    if($_GET['tipo_assistencia']=="externa"){
        $content=str_replace('name="externa" id="externa"','name="externa" checked id="externa"',$content);
    }
}