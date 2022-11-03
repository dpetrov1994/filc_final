<?php
include ("../_funcoes.php");
$db=ligarBD("_*.php");
$request = $db->escape_string($_GET['email']);

$return='true';

$sql="select * from utilizadores where email='$request'";
$result=runQ($sql,$db,1);
if($result->num_rows>0) {
    while ($row = $result->fetch_assoc()) {
        $return = $row['id_utilizador'];
    }
}else{
    $return = 0;
}

echo $return;

$db->close();

?>