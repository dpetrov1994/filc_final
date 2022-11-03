<?php
include "../login/valida.php";
include "../_funcoes.php";
include "../conf/dados_plataforma.php";

if(isset($_GET['nome_produto'])){
    $db=ligarBD();

    $nome_produto=$db->escape_string($_GET['nome_produto']);

    $produto=[];
    $sql="select * from produtos where nome_produto like '%$nome_produto%' limit 0,1";
    $result=runQ($sql,$db,"obter os dados do produto");
    while ($row = $result->fetch_assoc()) {
        $produto=$row;
    }

    if(empty($produto)){
        print 0;
    }else{
        print json_encode($produto);
    }

    $db->close();
}

