<?php
include ('../_template.php');

if(in_array('5', $_SESSION['grupos']) || $_SESSION['comercial']==1){ // REDIRECIONAR OS TECNICOS PARA O DASHBOARD DELES
    header("location: dashboard.php");
    die;
}

$content=file_get_contents("clientes.tpl");


/** TOTAL PENDENTES */
$linhas="";

$rows = getInfoTabela('srv_clientes', ' and ativo=1 ');
$pendentes=[];
$credito=[];
foreach ($rows as $row){
    $row['pendente']=$row['pendente']*1;
    if($row['pendente']>0){
        $pendentes[]=[
            'id_cliente'=>$row['id_cliente'],
            'OrganizationName'=>$row['OrganizationName'],
            'seconds'=>$row['pendente'],
        ];
    }
    if($row['pendente']<0){
        $row['pendente']=$row['pendente']*-1;
        $credito[]=[
            'id_cliente'=>$row['id_cliente'],
            'OrganizationName'=>$row['OrganizationName'],
            'seconds'=>$row['pendente'],
        ];
    }
}

// Sort the array seconds_compare() está no _functions.php
usort($pendentes, 'seconds_compare');
$total=0;
$c=0;
foreach ($pendentes as $cliente){
    $total+=$cliente['seconds'];
    $valor=number_format($cliente['seconds'],"2","."," ");
    $linhas.="<tr><td>".$cliente['OrganizationName']."</td><td style='text-align: right'><b>$valor €</b></td></tr>";
    $c++;
    if($c==10){
        break;
    }

}
//$total=number_format($total,"2","."," ");
//$linhas.="<tr><th>Total</th><td style='text-align: right'><b>$total €</b></td></tr>";

    $res="
<div class='table-responsive'>
        <table class='table table-bordered table-vcenter table-striped'>
        <thead><tr><th>Cliente</th><th style='width: 50%;text-align: right'>Total</th></tr></thead>
        <tbody>
        $linhas

</tbody>
        
        </table>
        </div>
        ";
$content=str_replace("_totalPendentes_",$res,$content);



// Sort the array seconds_compare() está no _functions.php
usort($credito, 'seconds_compare');
$total=0;
$linhas="";
$c=0;
foreach ($credito as $cliente){
    $total+=$cliente['seconds'];
    $valor=number_format($cliente['seconds'],"2","."," ");
    $linhas.="<tr><td>".$cliente['OrganizationName']."</td><td style='text-align: right'><b>$valor €</b></td></tr>";
    $c++;
    if($c==10){
        break;
    }
}
//$total=number_format($total,"2","."," ");
//$linhas.="<tr><th>Total</th><td style='text-align: right'><b>$total €</b></td></tr>";

    $res="
<div class='table-responsive'>
        <table class='table table-bordered table-vcenter table-striped'>
        <thead><tr><th>Cliente</th><th style='width: 50%;text-align: right'>Total</th></tr></thead>
        <tbody>
        $linhas

</tbody>
        
        </table>
        </div>
        ";
$content=str_replace("_totalCredito_",$res,$content);

/** TOTAL PENDENTES */

$pageScript="<script src='clientes.js'></script>";
include ('../_autoData.php');