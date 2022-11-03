<?php
include ("../_funcoes.php");
$db=ligarBD("_*.php");
$request = $db->escape_string($_POST['email']);

$return='true';

$sql="select email from utilizadores where email='$request'";
$result=runQ($sql,$db,1);
if($result->num_rows>0) {
    $return = 'false';
}else{
    $return = 'true';
}

echo $return;

$db->close();

?>