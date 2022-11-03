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
    $sql = "select distinct(id_cliente) from assistencias_clientes where 1 and ativo=1 and assinado = 1  and (data_inicio >= '".$inicio." 00:00:00' and data_inicio <= '".$fim." 23:59:59')";
    $result = runQ($sql, $db, 4);
    while ($row = $result->fetch_assoc()) {
        $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$row['id_cliente'].'"');
        $nome_cliente = "";
        if(isset($cliente[0])){
            $nome_cliente= ($cliente[0]['OrganizationName']);
        }

        $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and id_cliente="'.$row['id_cliente'].'" and (data_inicio >= "'.$inicio.' 00:00:00" and data_inicio <= "'.$fim.' 23:59:59")');
        $seconds = 0;
        foreach ($assistencias_clientes_terminadas as $as){
            $seconds += $as['tempo_assistencia'] + $as['tempo_viagem'] - $as['segundos_pausa'];
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
        $valorPerc=0;
        if($cliente['seconds']>0){
            $valorPerc=$cliente['seconds']*100/$total;
        }
        $valorTmp=number_format($valorPerc,2,",","");
        $valorPerc=round($valorPerc);

        $cor="";
        if($valorPerc<10){
            $cor="color:black";
        }

        $progressBar = '<div class="bars-container" style="margin-left: 5px;margin-right:5px ">
                        <div class="progress" style="margin-bottom: 0px!important;">
                            <div class="progress-bar progress-bar-info" role="progressbar" 
                            aria-valuenow="' . $valorPerc . '%" aria-valuemin="0" aria-valuemax="100" 
                            style="width:' . $valorPerc . '%;'.$cor.'">&nbsp;' . $valorTmp . '% </div>
                        </div>
                  </div>';
        $linhas.="<tr><td>".$cliente['OrganizationName']."</td><td>$progressBar</td></tr>";
    }


    if($linhas!=""){
        $res="
<div class='table-responsive'>
        <table class='table table-bordered table-vcenter table-striped'>
        <thead><tr><th>Cliente</th><th style='width: 50%'>Total</th></tr></thead>
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