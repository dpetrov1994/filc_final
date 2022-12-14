<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 06/07/2018
 * Time: 14:57
 */
function cleanData(&$str)
{
    // escape tab characters
    $str = preg_replace("/\t/", "\\t", $str);
    $str=utf8_decode($str);
    // escape new lines
    $str = preg_replace("/\r?\n/", "\\n", $str);

    // convert 't' and 'f' to boolean values
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';

    // force certain number/date formats to be imported as strings
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
        $str = "'$str";
    }

    // escape fields that include double quotes
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// filename for download
$filename = $tabela."_".date("dmYHi").".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;
$data=[];
$sql="SELECT * FROM $tabela ";
$result=runQ($sql,$db,"export");
while ($row = $result->fetch_assoc()) {
    array_push($data,$row);
}
foreach($data as $row) {
    if(!$flag) {
        // display field/column names as first row
        echo implode("\t", array_keys($row)) . "\r\n";
        $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
}
exit;