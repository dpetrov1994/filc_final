<?php
include "../login/valida.php";
include "../_funcoes.php";

$db=ligarBD();

$modulo=$db->escape_string($_GET['modulo']);
$id_item=$db->escape_string($_GET['idItem']);
$comentarios=getComentarios2($modulo,$id_item);
print (json_encode($comentarios));

$db->close();