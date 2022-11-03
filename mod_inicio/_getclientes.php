<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

// DESCREVER O SRV_CLIENTES
$Colunas=[];
$sql = "describe srv_clientes";
$result=runQ($sql,$db,"");
while($return = $result -> fetch_assoc()){
    $columns[]=$return['Field'];
}


$value = $db->escape_string($_GET['like']);
$i=0;
foreach($columns as $column){
    if($i==0){
        $addsql.=" $column like '%$value%'";
    }else{
        $addsql.=" or $column like '%$value%'";
    }
    $i++;
}

$clientes = getInfoTabela('srv_clientes', " and ($addsql) and ativo=1");

$ops="";
if(isset($clientes[0])){

    foreach($clientes as $cliente){

        $text = $cliente['OrganizationName'];
        $data[]=array('id'=>$cliente['FederalTaxID'], 'text'=> $text);
        //$ops.="<option value='".$cliente['FederalTaxID']."'>".$cliente['OrganizationName']."</option>";
    }
}else{
    $data[]=array('id'=>0, 'text'=>'Nenhum cliente encontrado');
}
/*
$li='<li class="select2-results__option select2-results__option--highlighted"
    id="select2-clientes-result-7e7i-B11560232" role="treeitem"
    aria-selected="true">Compañia de Viñedos Iberian, S.L.</li>';*/


echo json_encode($data);

$db->close();