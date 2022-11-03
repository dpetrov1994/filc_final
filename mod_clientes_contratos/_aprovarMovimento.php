<?php
include "../login/valida.php";
include "../_funcoes.php";
include "../conf/dados_plataforma.php";

$db=ligarBD();

if(isset($_GET['id_carregamento'])){
    $id_carregamento=$db->escape_string($_GET['id_carregamento']);
    UpdateTabela("clientes_contratos_carregamentos","validado=1"," and id_carregamento='$id_carregamento'");
}


$db->close();