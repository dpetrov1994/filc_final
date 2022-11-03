<?php
include ("../_funcoes.php");
$db=ligarBD("_*.php");
$request = $db->escape_string($_GET['id_utilizador']);

$return='true';

$sql="select nome_utilizador,contacto, contacto_alternativo,email,morada,cod_post,localidade,nif from utilizadores where id_utilizador='$request'";
$result=runQ($sql,$db,1);
if($result->num_rows>0) {
    while ($row = $result->fetch_assoc()) {
        $return = $row;
    }
}else{
    $return = [
        "nome_utilizador"=>"",
"contacto"=>"",
"contacto_alternativo"=>"",
"email"=>"",
"morada"=>"",
"cod_post"=>"",
"localidade"=>"",
"nif"=>"",
    ];
}

echo json_encode($return);

$db->close();

?>