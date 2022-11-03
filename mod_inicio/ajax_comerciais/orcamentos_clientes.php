<?php
include ("../../_funcoes.php");
include ("../../conf/dados_plataforma.php");
include ("../../login/valida.php");

$db=ligarBD("mysql");

$result="";
if(isset($_GET['inicio']) && isset($_GET['fim'])){

    $inicio=data_portuguesa($_GET['inicio']);
    $fim=data_portuguesa($_GET['fim']);


    $clientes=[];
    $total=0;
    $sql = "select distinct(id_cliente) from orcamentos where 1 and ativo=1 and fechado = 0 and (created_at >= '".$inicio." 00:00:00' and created_at <= '".$fim." 23:59:59')";
    $result = runQ($sql, $db, 4);
    while ($row = $result->fetch_assoc()) {
        $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$row['id_cliente'].'"');
        $nome_cliente = "";
        if(isset($cliente[0])){
            $nome_cliente= ($cliente[0]['OrganizationName']);
        }

        $assistencias_clientes_terminadas = getInfoTabela('orcamentos', ' and ativo=1 and fechado = 0 and id_cliente="'.$row['id_cliente'].'" and (created_at >= "'.$inicio.' 00:00:00" and created_at <= "'.$fim.' 23:59:59")');
        $seconds = 0;
        foreach ($assistencias_clientes_terminadas as $as){
            $seconds ++;
        }
        $total+=$seconds;
        $clientes[]=[
            'id_cliente'=>$row['id_cliente'],
            'OrganizationName'=>$nome_cliente,
            'seconds'=>$seconds,
        ];
    }

    // Sort the array seconds_compare() está no _functions.php
    usort($clientes, 'seconds_compare');

    $linhas="";
    foreach ($clientes as $cliente){
        $progressBar = $cliente['seconds'];
        $linhas.="<tr><td>".$cliente['OrganizationName']."</td><td style='text-align: right'><b>$progressBar</b></td></tr>";
    }
    $total=($total);
    $linhas.="<tr><th>Total</th><td style='text-align: right'><b>$total</b></td></tr>";

    if($linhas!=""){
        $res="
<div class='table-responsive'>
        <table class='table table-bordered table-vcenter table-striped'>
        <thead><tr><th>Cliente</th><th style='width: 50%'>Orç. Pendentes</th></tr></thead>
        <tbody>
        $linhas

</tbody>
        
        </table>
        </div>
        ";
    }

}


print $res;


$db->close();