<?php
/*
include ('_template.php');

$sql = "SELECT distinct TABLE_NAME FROM Information_schema.columns where TABLE_SCHEMA = 'srvpt_filc' ORDER BY table_name  ASC";
$offset = 10000;
$result=runQ($sql,$db,"");
while ($row = $result->fetch_assoc()) {
$tableName = $row['TABLE_NAME'];
$count = 0;
echo '------------------- INIT ' . $tableName . ' TABLE ---------------' . PHP_EOL;
do {
    $sql = "SELECT * FROM " . $tableName . " limit " . $count * $offset . ", $offset";
    $tableQuery=runQ($sql,$db,"");
    while ($tableRow = $tableQuery->fetch_assoc()) {

        echo('(' . $count . ') ' . $tableName . ': ');
        echo implode(',', $tableRow);
        echo PHP_EOL;

    }
    $count++;
} while(mysqli_num_rows($tableQuery));
echo '------------------- END  ' . $tableName . '  TABLE ---------------' . PHP_EOL;
}

die;*/
