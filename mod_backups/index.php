<?php
include('../_template.php');
include('../assets/dumper.php');

$content=file_get_contents("index.tpl");
$tabelas=0;
$registos=0;
$tamanho=0;
$sql="show table status";
$result=runQ($sql,$db,"table status ");
while ($row = $result->fetch_assoc()) {
    $tabelas++;
    $registos+=$row['Rows'];
    $tamanho+=$row['Data_length'];
}

$decimals = 2;
$mbytes = number_format($tamanho/(1024*1024),$decimals);

$content=str_replace("_tabelas_",$tabelas,$content);
$content=str_replace("_registos_",$registos,$content);
$content=str_replace("_tamanho_","<b class='text-danger'>$mbytes</b> mb",$content);

$diretorios=(espacoDisco($cfg_espacoDisco,$cfg_espacoReservadoSys));

$linhas="";
$linha="<tr><td>_pasta_</td><td class='text-right'>_tamanho_</td><td class='text-right'>_percentagem_%</td></tr>";
foreach ($diretorios as $diretorio){
    $linhas.=$linha;
    $linhas=str_replace("_pasta_",$diretorio['nome'],$linhas);
    $linhas=str_replace("_tamanho_",$diretorio['tamanhoHumano'],$linhas);
    $linhas=str_replace("_percentagem_",$diretorio['percentagem'],$linhas);
}
$content=str_replace("_linhas_",$linhas,$content);

$pageScript= '<script src="index.js"></script>';
include('../_autoData.php');