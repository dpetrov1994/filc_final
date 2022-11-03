<?php

include "../_funcoes.php";
include "../conf/dados_plataforma.php";

//$result=runQSrv("asd");

//set_time_limit ( -1);

$db=ligarBD(1);

$mapa_colunas=[
    'DOCGCCAB'=>[
        'DATEUPD' => "UpdatedDate",
    ],
    'DOCGCLIN'=>[
        'DATEUPD' => "UpdatedDate",
    ]
];

if(isset($_GET['tabela'])){
    if($_GET['tabela']=="DOCGCLIN"){
        $tabela="srv_clientes_saletransactiondetails";
    }else{
        $tabela="srv_clientes_saletransaction";
    }

    $coluna="UpdatedDate";
}



$db->close();
