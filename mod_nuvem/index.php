<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

/**  FILTROS ADICIONAIS */
$id_pasta=0;

if(isset($_GET['id_pasta_parent'])){
    $id_pasta=$_GET['id_pasta_parent'];
}
$reciclagem=0;
if(isset($formAction) && $formAction=="reciclagem.php"){
    $menuSecundario=str_replace("reciclagem.php_addUrl_","reciclagem.php",$menuSecundario);
    $reciclagem=1;
}



$linhas=listarFicheirosDaNuvem($layoutDirectory,$db,$id_pasta,$reciclagem);

$content=str_replace("_pastas_",$linhas,$content);
$pageScript="";
include ('../_autoData.php');