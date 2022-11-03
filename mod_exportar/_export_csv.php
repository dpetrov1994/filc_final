<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 06/07/2018
 * Time: 14:57
 */

// create var to be filled with export data
$csv_export = '';

if(!isset($delimitador)){
    $delimitador=";";
}
if($delimitador==""){
    $delimitador=";";
}

// query to get data from database
$sql="DESCRIBE $tabela ";
$result=runQ($sql,$db,"export");
while ($row = $result->fetch_assoc()) {
    $csv_export.=$row['Field'].$delimitador;
}

$csv_export=substr($csv_export, 0, strlen($delimitador)*-1);
// newline (seems to work both on Linux & Windows servers)
$csv_export.= '
';
$sql="select * from $tabela ";
$result=runQ($sql,$db,"export");
while ($row = $result->fetch_assoc()) {
    foreach ($row as $coluna=>$valor){
        $valor=nl2br($valor);
        $valor = str_replace(array("\r", "\n"), '', $valor);
        $csv_export .= utf8_decode($valor) . $delimitador;
    }
    $csv_export=substr($csv_export, 0, strlen($delimitador)*-1);
    $csv_export.= '
';
}

// Export the data and prompt a csv file for download
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$tabela."_".date("dmYHi").".csv");
echo($csv_export);