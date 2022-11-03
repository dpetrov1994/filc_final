<?php
include ("../../_funcoes.php");
include ("../../conf/dados_plataforma.php");
include ("../../login/valida.php");

$db=ligarBD("mysql");

$result="";
if(isset($_GET['inicio']) && isset($_GET['fim'])){

    $inicio=data_portuguesa($_GET['inicio']);
    $fim=data_portuguesa($_GET['fim']);


    $maquinas=[];
    $total=0;
    $sql = "select * from assistencias_clientes where 1 and ativo=1 and assinado = 1  and (data_inicio >= '".$inicio." 00:00:00' and data_inicio <= '".$fim." 23:59:59')";
    $result = runQ($sql, $db, 4);
    while ($row = $result->fetch_assoc()) {

        $sql2 = "select distinct(id_maquina) from assistencias_clientes_maquinas where 1 and ativo=1 and id_assistencia_cliente='".$row['id_assistencia_cliente']."'";
        $result2 = runQ($sql2, $db, 4);
        while ($row2 = $result2->fetch_assoc()) {

            $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$row['id_cliente'].'"');
            $nome_cliente = "";
            if(isset($cliente[0])){
                $nome_cliente= ($cliente[0]['OrganizationName']);
            }

            $maquina = getInfoTabela('maquinas', ' and id_maquina = "'.$row2['id_maquina'].'"');
            $nome_maquina = "";
            $ativo = "";
            if(isset($maquina[0])){
                $nome_maquina= ($maquina[0]['nome_maquina']);
                $ref= ($maquina[0]['ref']);
            }

            if(!isset($maquinas[$row2['id_maquina']])){
                $maquinas[$row2['id_maquina']]=[
                    'id_cliente'=>$row['id_cliente'],
                    'OrganizationName'=>$nome_cliente,
                    'id_maquina'=>$row2['id_maquina'],
                    'nome_maquina'=>$nome_maquina,
                    'ref'=>$ref,
                    'seconds'=>0,
                ];
            }
            //tempo por máquina

            $seconds=$row['tempo_assistencia'] + $row['tempo_viagem'] - $row['segundos_pausa'];
            $maquinas[$row2['id_maquina']]['seconds'] += $seconds;
            $total+=$seconds;
        }
    }



    // Sort the array seconds_compare() está no _functions.php
    usort($maquinas, 'seconds_compare');

    $linhas="";
    foreach ($maquinas as $maquina){
        $valorPerc=0;
        if($maquina['seconds']>0){
            $valorPerc=$maquina['seconds']*100/$total;
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
        $linhas.="<tr><td>".$maquina['nome_maquina']."</td><td>".$maquina['ref']."</td><td>".$maquina['OrganizationName']."</td><td style='text-align: right'><b>$progressBar</b></td></tr>";
    }

    if($linhas!=""){
        $res="
<div class='table-responsive'>
        <table class='table table-bordered table-vcenter table-striped'>
        <thead><tr><th>Maquina</th><th>Ref</th><th>Cliente</th><th >Ocupação</th></tr></thead>
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