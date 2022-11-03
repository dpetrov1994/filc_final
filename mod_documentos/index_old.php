<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");
$menuSecundarioIndividual="";


// ADICIONAR FILTROS NAS TABELA (NOS TH'S)
$FilterInTable=1;

/**  FILTROS ADICIONAIS */

$arrayEmpresas = getInfoTabela('srv_clientes', ' and ativo = 1');

$PartyID=$arrayEmpresas[0]['PartyID'];
if(isset($_GET['PartyID'])){
    $PartyID=$db->escape_string($_GET['PartyID']);
}

$ano_pdf=0;
$nome_pdf=0;

$contribuinte="";
$sql="select * from srv_clientes where PartyID='$PartyID'";
$result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
while ($row = $result->fetch_assoc()) {
    $contribuinte=$row['FederalTaxID'];

    if($row['empresa'] == "ELAData.dbo."){
        $database = "ELA";
    }else{
        $database = "ELAIBERIA";
    }

    $content=str_replace("_FederalTaxID_",$row['FederalTaxID'],$content);
    $content=str_replace("_empresa_",$database,$content);
    $nome_pdf=$row['OrganizationName'];
}

$alfabetico="";
$sql="select * from srv_clientes_informacao where FederalTaxID='$contribuinte'";
$result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
while ($row = $result->fetch_assoc()) {
    $content=str_replace("_alfabetico_",$row['alfabetico'],$content);
}

$registosCliente = getInfoTabela("srv_clientes", " and ativo=1 and FederalTaxID = '".$contribuinte."'  order by empresa asc");

$nomes_das_empresas="";
foreach ($registosCliente as $c) {
    if ($c['empresa'] == "ELAData.dbo.") {
        $database = "ELA";
    } else {
        $database = "ELAIBERIA";
    }

    $sql2 = "select * from srv_clientes where PartyID='" . $c['PartyID'] . "'";
    $result2 = runQ($sql2, $db, "nomes do cliente");
    while ($row2 = $result2->fetch_assoc()) {
        $nomes_das_empresas .= "<small><span class='text-primary'>$database:</span> " . $row2['OrganizationName'] . "</small><br>";
    }

}
$content=str_replace("_NomesDasEmpresas_",$nomes_das_empresas,$content);

if(!isset($_GET['ano'])){
    $_GET['ano']=2017;
}
$content=str_replace("_ano_",$_GET['ano'],$content);
/*else{
    $add_sql.=" and PartyID='$PartyID'";
}elseif(!isset($_GET['PartyID'])){
    header("location: ../index.php");
    die();
}*/

$add_sql.=" and PartyID='$PartyID'";

$ops="";
foreach($arrayEmpresas as $e){
    $selected="";
    if($PartyID==$e['PartyID']){
        $selected="selected";
    }
    $ops .= '<option '.$selected.' value="'.$e['PartyID'].'">'.$e['OrganizationName'].'</option>';
}
$content = str_replace('_clientes_', $ops, $content);

$content=str_replace("_PartyID_",$PartyID,$content);



// GET tipos documentos
$tipos_doc = getInfoTabela('srv_clientes_saletransaction',
    ' ORDER BY TransDocument asc', '', '', '', 'TransDocument', '1', '1');
$ops="";
$doc_selected="";
if(isset($_GET['tipo_doc']) && $_GET['tipo_doc']!="todos"){
    $doc_selected=$db->escape_string($_GET['tipo_doc']);
    $add_sql.=" and TransDocument='$doc_selected'";
}
foreach($tipos_doc as $doc){
    $selected="";
    if($doc_selected==$doc){
        $selected="selected";
    }
    $ops .= '<option '.$selected.' value="'.$doc.'">'.$doc.'</option>';
}
$content = str_replace('_documentos_', $ops, $content);
// END GET tipos documentos


// GET ANOS
$arrayEmpresasAnos = getInfoTabela('srv_clientes_saletransaction',
    ' ORDER BY CreateDate desc', '', '', '', 'DATE_FORMAT(CreateDate, "%Y")', '1', '1');
$ops="";
$ano_selected="";
if(isset($_GET['ano']) && $_GET['ano']!="todos"){
    $ano_selected=$db->escape_string($_GET['ano']);
    $add_sql.=" and YEAR(CreateDate)='$ano_selected'";
}
foreach($arrayEmpresasAnos as $ano){
    $selected="";
    if($ano_selected==$ano){
        $selected="selected";
    }
    $ops .= '<option '.$selected.' value="'.$ano.'">'.$ano.'</option>';
}
$content = str_replace('_anos_', $ops, $content);
// END GET ANOS

/** fFIM FILTROS ADICIONAIS */

// TABELAS A SEREM IGNORADAS NOS FILTROS DE TABELAS
$ColunasaIgnorarNoFiltroDasTabelas=['descricao', 'TotalGlobalDiscountAmount','total'];


// SE FOR PARA ALTERAR DE FORMA NUMERICA // EDITAR PARA CAST($nomeColuna) ANTES DE IR PARA IGUAL TODAS TABELAS
$ColunasNumericas = ['TransDocNumber', 'TotalGlobalDiscountAmount', 'total'];
//$ColunasNumericas = ['TransDocNumber', 'TotalGlobalDiscountAmount'];

include ("../_igualEmTodasTabelas.php");

if(isset($_GET['PartyID']) && $_GET['PartyID'] != "") {

    if($ano_selected != ""){
        $tplTabela=str_replace('_order_', '_order_&PartyID='.$PartyID.'&ano='.$ano_selected,$tplTabela);
    }else{
        $tplTabela=str_replace('_order_', '_order_&PartyID='.$PartyID,$tplTabela);
    }



}



$tr=0;


$results=[];

$sql="SELECT * FROM $nomeTabela $innerjoin  WHERE 1 $add_sql";
$result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
while ($row = $result->fetch_assoc()) {

    if($row['PartyFederalTaxID']=='502995572' && ($row['TransDocNumber']=='385' ||  $row['TransDocNumber']=='386')){
        // nao inserir
    }else{
        array_push($results,$row);
    }
}

$rows = [];
for ($i = 0; $i < count($results); $i++) {
    if ($results[$i]['TransDocument'] != "NC") {
        array_push($rows, $results[$i]);
        $TransDocument = $results[$i]['TransDocument'];
        $TransDocNumber = $results[$i]['TransDocNumber'];
        $TransSerial = $results[$i]['TransSerial'];
        $OriginatingON = "$TransDocument $TransSerial/$TransDocNumber";

        $sql2 = "SELECT * FROM srv_clientes_saletransaction  where PartyID='" . $PartyID . "' and OriginatingON='$OriginatingON'";
        $result2=runQ($sql2,$db,"srv_clientes_saletransaction 2 ");
        while($row2 = $result2->fetch_assoc()){
            array_push($rows, $row2);
        }
    }
}
$results = $rows;



$tr=count($results);
if($tr>0){

    $len = count($results);
    $i=0;
    $arrayServicos=array();
    foreach ($results as $row) {



        $i++;
        $row['discount'] = "";

        if($row['PaymentDiscountPercent']>0){
            $row['discount'] ='Sim';
        }

        /**colunas personalizadas **/
        $empresa = "";
        if ($row['empresa'] == "ELAData.dbo.") {
            $empresa = "ELA";
        } elseif ($row['empresa'] == "ELAIBERIA.dbo.") {
            $empresa = "ELAIBERIA";
        }



        $registosCliente=[];
        $documentoElaIberia=[];
        $linhasElaIberia=[];

        $documento = getInfoTabela('srv_clientes_saletransaction' , ' and PartyID="'.$row['PartyID'].'" and TransDocNumber="'.$row['TransDocNumber'].'" and TransDocument="'.$row['TransDocument'].'"');
        $row['desconto_global']="Não tem";

        $row['dataCriado']=$documento[0]['CreateDate'];
        if($documento[0]['PaymentDiscountPercent']>0){
            $row['desconto_global']=$documento[0]['PaymentDiscountPercent']."%";
        }



        $servicosBody="";
        $total=0;
        $linhas = getInfoTabela('srv_clientes_saletransactiondetails' , ' and PartyID="'.$row['PartyID'].'" and TransDocNumber="'.$row['TransDocNumber'].'" and TransDocument="'.$row['TransDocument'].'" and CreateDate="'.$row['CreateDate'].'"');



        $servicos = "";
        if ($row['TransDocument'] == "NC") {
            $servicos .= "Proveniente de <b style='color: #ffc107'>" . $row['OriginatingON'] . "</b><br>";
        }
        $servicos.='<table class="table table-bordered" style="margin-top:20px"><thead>
                    <tr>
                        <th style="" class="text-left">Descrição</th>
                        <th style="" class="text-right">Quantidade</th>
                        <th style="" class="text-right">Valor Unitário</th>
                        <th style="" class="text-right">Desconto</th>
                        <th style="" class="text-right">Total s/iva</th>
                        <th style="" class="text-right">Iva</th>
                        <th style="" class="text-right">Total c/iva</th>
                    </tr>
                    </thead>
                    <tbody>_tbody_</tbody>
                    </table>';

        if(isset($linhas[0])){
            $dataBase = $documento[0]['empresa'];

            if($dataBase=="ELAData.dbo."){
                $dataBase="ELA";
            }else{
                $dataBase="ELAIBERIA";
            }
            $servicosBody.="<tr ><td style='padding: 10px 0;' colspan='7' class='text-center'>$dataBase</td></tr>";
        }

        foreach($linhas as $linha){
            if($linha['UnitPrice'] > 0 ){
                $totalComIva = $linha['TotalNetAmount'] + $linha['TotalTaxAmount'];
                $qnt = number_format( $linha['Quantity'], 2, ".", " ");
                $servicosBody .= "
                   
                    <tr>
                       <td >" . $linha['Description'] . "</td>                     
                       <td class='text-right'> " . $qnt . "</td>                     
                       <td class='text-right'>" . number_format($linha['UnitPrice'],2,'.',',') . " €</td>                     
                       <td class='text-right'>" . $linha['DiscountPercent'] . "%</td>                     
                       <td class='text-right'>" .number_format($linha['TotalNetAmount'],2,'.',','). " €</td>                     
                       <td class='text-right'>" .number_format($linha['TotalTaxAmount'],2,'.',','). " €</td>                     
                       <td class='text-right'>" .number_format($totalComIva,2,'.',','). " €</td>                     
                    </tr>";

                $total+=$totalComIva;

            }
        }

        $total_pendente+=$total;

        if($servicosBody != ""){
            $total=number_format($total,2,".",",");
            $servicosBody.=" <tr>
                      <td colspan='7' class='text-right'><b>Valor Total c/iva: $total €</b> </td>  
                    </tr>";
        }

        $servicos=str_replace('_tbody_',$servicosBody,$servicos);



        $row['descricao'] = $servicos;


        $total_doc =0;
        $total =0;

        $total_sem_iva = 0;
        $total_iva = 0;

        foreach ($itens as $item => $nome) {
            if ($row['empresa'] == "ELAIBERIA.dbo.") {
                $item = $itens_iberia[$item];
            }


            $sql3 = "select * from srv_clientes_saletransactiondetails where ItemID='" . $item . "' and PartyID='" . $row['PartyID'] . "' and TransDocNumber='" . $row['TransDocNumber'] . "' and TransDocument='" . $row['TransDocument'] . "' and TransSerial='" . $row['TransSerial'] . "' and CreateDate='" . $row['CreateDate'] . "'";
            $result3 = runQ($sql3, $db, 1);
            while ($row3 = $result3->fetch_assoc()) {

                if ($row['TransDocument'] == "NC" && $row3['DiscountPercent'] >= 90) {
                    $servicos .= "<small style='color: #ffc107'>Com mais de 90% de desconto. Não descontar quantidade.</small><br>";
                } elseif ($row['TransDocument'] == "NC") {
                    $row3['Quantity'] = $row3['Quantity'] * -1;
                    $row3['TotalNetAmount'] = $row3['TotalNetAmount'] * -1;
                    $row3['TotalTaxAmount'] = $row3['TotalTaxAmount'] * -1;
                }

                $img="<img class='fa-bottle' src='wine-bottle.png'>";

                $qntMostrar=$row3['Quantity']*1000;
                $qnt = number_format($qntMostrar, 0, "", " ");
                if ($row['TransDocument'] == "ORC") {
                    $qnt = "";
                    $img = "";
                }

                $servicos .= "<p  style='border-bottom: #999999 1px dashed;height: 25px;margin-bottom: 1px'><small>" . $nome . " ($item): <i class='text-muted'>" . $row3['UnitPrice'] . "€/mil garafas</i></small> <b class='pull-right text-muted'>" . $qnt . " $img</b></p>";
                $total += $row3['Quantity'] * 1;

                $total_sem_iva += $row3['TotalNetAmount'];
                $total_iva += $row3['TotalTaxAmount'];

                if($row3['DiscountPercent'] > 0){
                    $row['discount']="Sim";
                }


                // COLOCAR NO ARRAY DE SERVICOS A QNT E O VALOR

                if ($row['TransDocument'] != "ORC") {
                    if (!isset($arrayServicos[$nome]['qnt'])) {
                        $arrayServicos[$nome]['qnt'] = 0;
                    }

                    if (!isset($arrayServicos[$nome]['total'])) {
                        $arrayServicos[$nome]['total'] = 0;
                    }

                    if ($qnt != 0 || $total != 0) {
                        $arrayServicos[$nome]['qnt'] += $qntMostrar;
                        $arrayServicos[$nome]['total'] += ($row3['TotalNetAmount']+$row3['TotalTaxAmount']);
                    }
                }
            }
        }

        $total_doc=$row['TotalNetAmount']*1+$row['TotalTaxAmount']*1;
        $total_doc = number_format($total_doc, 2, ".", ",") . " €";
        if ($row['TransDocument'] == "ORC") {
            $total_doc="--";
        }
        $row['total']=$total_doc;



        if ($servicos != "") {
            $tbody .= $linhaTD;
            $date = date("d/m/Y", strtotime($row['CreateDate']));
            $row['CreateDate'] = $date . '<br>' . $empresa;

            $cor = "";
            if ($row['TransDocument'] == "FAC") {
                $cor = "text-success";
            } elseif ($row['TransDocument'] == "ORC") {
                $cor = "text-info";
            } elseif ($row['TransDocument'] == "NC") {
                $cor = "text-danger";
            }

            $row['TransDocNumber'] = "<b class='$cor'>" . $row['TransDocument'] . " " . $row['TransSerial'] . "/" . $row['TransDocNumber'] . "</b>";
            //$row['descricao'] = "<div style='border: 1px solid #373737; padding:5px;margin:2px'>$servicos</div><br>";
            //$row['total'] = number_format($total_sem_iva, 2, ",", " ") . ' €';
            $row['TotalNetAmount'] = $total_sem_iva.'€';

            /** FIM colunas personalizadas**/

            $tbody = rules_for_rows($rules_for_rows, $row, $tbody, $linkDasTabelas);


            if($row['discount'] == "Sim"){
                $row['TotalGlobalDiscountAmount']="Sim";
            }else{
                $row['TotalGlobalDiscountAmount']="Não";
            }


            foreach ($row as $coluna => $valor) {
                $tbody = str_replace("_" . $coluna . "_", $valor, $tbody);
            }

            $tbody = str_replace("_funcionalidades_", $funcionalidades, $tbody);
            if ($subModulo == 0) {
                $tbody = str_replace("_idItem_", $row['id_' . $nomeColuna], $tbody);
            } else {
                $tbody = str_replace("_subItemID_", $row['id_' . $nomeColuna], $tbody);
                $tbody = str_replace("_idItem_", $idParent, $tbody);
            }
        }

        foreach ($colunasParaMostrarNaTabela as $coluna => $regras) {
            if(isset($_GET['o']) && strpos($_GET['o'], 'asc') !== false) {
                $tplTabela = str_replace('_order_', 'desc', $tplTabela);
            } else {
                $tplTabela = str_replace('_order_', 'asc', $tplTabela);
            }
        }

        if ($subModulo == 0) {
            $content = str_replace("_id_", $id, $content);
        } else {
            $content = str_replace("_id_", $idParent, $content);
        }

        // ADICIONAR TOTAIS POR SERVICO E TOTAL GLOBAL E NUMERO DE GARRAFAS POR SERVICO
        if ($i === $len) { // SE FOR O ULTIMO ROW
            $totaltotal=0;



            foreach($arrayServicos as $nomeServico => $dadosServico){
                $tbody.="<tr style='border-bottom: #999999 1px dashed;'>
                        <td colspan='5' class='text-right' style='padding-top: 15px;'>
                        
                             <b style='font-size: 14px'>" . $nomeServico . "</b>    
                             <p class='text-muted' style='margin: 0;'>Garrafas: " . number_format($dadosServico['qnt'],0,".",",") . "</p>
                             <p class='text-muted'>Total: ". number_format($dadosServico['total'], 2, ".", ",")." € </p>
                         
                         </td>
                     </tr>";

                $totaltotal +=$dadosServico['total'];
            }

            if($totaltotal>0){
                $tbody.="
<tr>
    <td colspan='5' class='text-right'>
    <b>TOTAL DE SERVIÇOS ACA E ENG: <span style='font-size: 16px'>".number_format($totaltotal, 2, ".", ",")." €</span></b>
    </td>
</tr>";
            }
        }


    }

    $resultados = str_replace("_tbody_", $tbody, $tplTabela);

    if(isset($_GET['pdf'])){

        $styles=file_get_contents("../assets/layout/css/main.css");

        $page="
<style>

table, tr,td,th{
border:1px solid gray;
border-collapse: collapse;
}

</style>
<page backtop=\"15mm\" backbottom=\"15mm\" backleft=\"5mm\" backright=\"5mm\">

    <page_header>
    </page_header>
    <div>$resultados</div>
        
    <page_footer>
    </page_footer>
</page>";
        guardarPDF($page,"Documentos de ".$_GET['ano']." - $nome_pdf.pdf","L");
        die();
    }

    if (isset($_GET['excel'])) {
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Content-Disposition: attachment; filename=" . $nomeTabela . "_" . time() . ".xls");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        $tempalte_excel = str_replace('_resultados_', $resultados, $tempalte_excel);
        print $tempalte_excel;
        die();
    }


}else{
    $resultados="_semResultados_";
}
$pageScript="";
include ('../_autoData.php');