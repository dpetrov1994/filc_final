<?php
include ("../_funcoes.php");
$db=ligarBD("_*.php");
$request = $db->escape_string($_REQUEST['email']);
$id = $db->escape_string($_REQUEST['id']);
$sql="select email from utilizadores where email='$request' and id_utilizador<>$id";
$result=runQ($sql,$db,1);
if($result->num_rows>0) {
    echo 'false';
}else{
    echo 'true';
}
$db->close();

?>