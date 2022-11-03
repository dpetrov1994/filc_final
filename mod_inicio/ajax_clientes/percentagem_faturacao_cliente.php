<?php
include ("../../_funcoes.php");
include ("../../conf/dados_plataforma.php");
include ("../../login/valida.php");

$db=ligarBD("mysql");

$result="";
if(isset($_GET['inicio']) && isset($_GET['fim'])){

    $inicio=data_portuguesa($_GET['inicio']);
    $fim=data_portuguesa($_GET['fim']);

    $documentos_positivo=[];
    $documentos_negativo=[];
    $sql2="select * from _conf_assists";
    $result2=runQ($sql2,$db,"get emails dos admins");
    while ($row2 = $result2->fetch_assoc()) {
        $documentos_positivo=json_decode($row2['documentos_fac'],true);
        $documentos_negativo=json_decode($row2['documentos_nc'],true);
    }

    $clientes=[];
    $total=0;
    $sql = "select distinct(PartyID) from srv_clientes_saletransaction where ativo=1 and (CreateDate >= '".$inicio." 00:00:00' and CreateDate <= '".$fim." 23:59:59')";
    $result = runQ($sql, $db, 4);
    while ($row = $result->fetch_assoc()) {
        $cliente = getInfoTabela('srv_clientes', ' and PartyID = "'.$row['PartyID'].'"');
        $nome_cliente = "";
        if(isset($cliente[0])){
            $nome_cliente= ($cliente[0]['OrganizationName']);
        }

        $docs = getInfoTabela('srv_clientes_saletransaction', ' and ativo=1 and PartyID="'.$row['PartyID'].'" and (CreateDate >= "'.$inicio.' 00:00:00" and CreateDate <= "'.$fim.' 23:59:59")');
        $faturado = 0;
        foreach ($docs as $doc){
            if(in_array($doc['TransDocument'],$documentos_negativo)){
                $faturado -= $doc['TotalAmount']*1;
            }elseif(in_array($doc['TransDocument'],$documentos_positivo)){
                $faturado += $doc['TotalAmount']*1;
            }
        }
        if($faturado>0){
            $total+=$faturado;
            $clientes[]=[
                'PartyID'=>$row['PartyID'],
                'OrganizationName'=>$nome_cliente,
                'seconds'=>$faturado,
            ];
        }
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
                            <div class="progress-bar progress-bar-info"  role="progressbar" 
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