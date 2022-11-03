<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

// REMOVER FUNCIONALIDADES MULTIPLOS
$ignorarFuncionalidadesMultiplos=1;

// ADICIONAR FILTROS NAS TABELA (NOS TH'S)
$FilterInTable=1;

/*
$sql="select * from observacoes";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0) {
    while ($row = $result->fetch_assoc()) {
        $sql2="insert into srv_clientes_notas (descricao,id_criou, created_at, FederalTaxID) values ('".$db->escape_string($row['descricao'])."','".$db->escape_string($row['id_criou'])."','".$db->escape_string($row['created_at'])."','".$db->escape_string($row['nif'])."')";
        $result2=runQ($sql2,$db,"VERIFICAR EXISTENTE");

    }
}
die();
*/

/**  FILTROS ADICIONAIS */
/*
$campos=[
'alfabetico',
'grupo',
'isolado',
'comentarios',
'corrigido',
'data_correcao',
'zonagem',
'zonagem2',
'id_utilizador_localizacao',
'FederalTaxID',
'classificacao',
'longitude',
'latitude',
];

$sql="select * from srv_clientes2 group by FederalTaxID,FederalTaxID";
$result=runQ($sql,$db,"CONTAR RESULTADOS");
while ($row = $result->fetch_assoc()) {

    $colunas="";
    $valores="";
    foreach ($campos as $campo){
        $colunas.="$campo,";
        $valores.="'".$db->escape_string($row[$campo])."',";
    }
    $colunas=substr($colunas, 0, -1);
    $valores=substr($valores, 0, -1);

    $sql2="insert into srv_clientes_informacao ($colunas) values ($valores)";
    $result2=runQ($sql2,$db,"CONTAR RESULTADOS");

}
die();

*/





$paises=[
    'PRT'=>'Portugal',
    'ESP'=>'Espanha',
    //'nenhum'=>'Sem País'
];
$pais="";
if(isset($_GET['pais']) && $_GET['pais']!="todos"){
    $pais=$db->escape_string($_GET['pais']);

    if($pais=="nenhum"){
        $add_sql=" and pais = '' ";
    }else{
        if($pais=='ESP'){
            $add_sql=" and (pais like '%ESP%') ";
        }else{
            $add_sql=" and (pais like '%PRT%') ";
        }

    }
}

$ops="";
foreach ($paises as $val => $text){
    $selected="";
    if($pais==$val){
        $selected="selected";
    }
    $ops.="<option $selected value='$val'>$text</option>";
}
$content=str_replace("_paises_",$ops,$content);

$pendentes=[
    'sim'=>'SIM',
    'nao'=>'NÃO'
];

$pendente="";
if(isset($_GET['pendente']) && $_GET['pendente']!="todos"){
    $pendente=$db->escape_string($_GET['pendente']);

    if($pendente=="sim"){
        $add_sql.=" and ( pendente <> '.0000' )";
    }else{
        $add_sql.=" and (pendente = '0' and  pendente ='' or pendente = '.0000' ) ";
    }
}

$ops="";
foreach ($pendentes as $val => $text){
    $selected="";
    if($pendente==$val){
        $selected="selected";
    }
    $ops.="<option $selected value='$val'>$text</option>";
}
$content=str_replace("_pendente_",$ops,$content);


// CLASSIFICACAO

$classificacoes = '
<option class="classificacao" value="0">Sem classificação</option>
<option class="classificacao" value="1">1 Estrela</option>
<option class="classificacao" value="2">2 Estrelas</option>
<option class="classificacao" value="3">3 Estrelas</option>
<option class="classificacao" value="4">4 Estrelas</option>
<option class="classificacao" value="5">5 Estrelas</option>
';
$content=str_replace("_classificacaoFiltro_",$classificacoes,$content);


$classificacaoFiltro="";
if(isset($_GET['classificacaoFiltro']) && $_GET['classificacaoFiltro']!="todos"){

     $classificacao=$db->escape_string($_GET['classificacaoFiltro']);

     $add_sql.=" and srv_clientes_informacao.classificacao = '$classificacao'";

     $content=str_replace('<option class="classificacao" value="'.$classificacao.'">','<option class="classificacao" selected value="'.$classificacao.'">',$content);

}

// END CLASSIFICACAO


/* FILTRO POR VALOR PENDENTE */


/** fFIM FILTROS ADICIONAIS */

include ("../_igualEmTodasTabelas.php");
/*
if(isset($_GET['o']) && strpos($_GET['o'], 'Divida') !== false) {


    $orderBy = getInfoTabela('srv_clientes_CustomerLedgerAccount', ' and (TransDocument="FAC" or TransDocument="NC")','', '', '', 'PartyID');


    foreach($orderBy as $key => $idDocumento){


        $sum = getInfoTabela('srv_clientes_CustomerLedgerAccount', ' and (TransDocument="FAC" or TransDocument="NC") and PartyID="'.$idDocumento['PartyID'].'"','', '', '', 'sum(TotalPendingAmount) as TotalPendingAmount');

      if($sum[0]['TotalPendingAmount'] != ""){
          $orderBy[$key]['TotalPendingAmount'] = $sum[0]['TotalPendingAmount'];
      }


    }


    usort($orderBy, function($a, $b) {
        return $a['TotalPendingAmount'] - $b['TotalPendingAmount'];
    });




    $orderBy = array_map("unserialize", array_unique(array_map("serialize", $orderBy)));

    $ids = "";
    foreach($orderBy as $doc){
        $ids.="'".$doc['PartyID']."',";
    }


    $ids=substr($ids, 0, -1);

    $add_sql=str_replace('Divida', 'TotalPendingAmount',$add_sql);
    if($ids != ""){
        $add_sql=str_replace('Divida', "FIELD(PartyID,$ids)",$add_sql);
    }

   // $add_sql=str_replace('Divida asc', "FIELD(PartyID,$ids)",$add_sql);

}*/



$tr=0;

$sql="SELECT count(DISTINCT($nomeTabela.FederalTaxID)) as CNT FROM ".$nomeTabela." $innerjoin WHERE 1 $add_sql";

$result=runQ($sql,$db,"CONTAR RESULTADOS");
while ($row = $result->fetch_assoc()) {
    $tr=$row['CNT']; // total rows
}
if($tr>0){
    include "../_paginacao.php";

    if($subModulo==0){
        include "../_funcionalidades.php";
    }else{
        include "../_funcionalidadesSubModulos.php";
    }

    $tbody="";


    $add_sql = str_replace("order by", " group by $nomeTabela.FederalTaxID order by", $add_sql);
    if(!isset($_GET['excel'])) {
        $add_sql .= " LIMIT " . (($pn - 1) * $pr) . " , $pr";
    }

    $sql="SELECT * FROM $nomeTabela $innerjoin  WHERE 1 $add_sql";

    $result=runQ($sql,$db,"LOOP PELOS RESULTADOS");

    while ($row = $result->fetch_assoc()) {
        $tbody.=$linhaTD;


     /*   $row['pais']=json_decode($row['pais']);
        $paises="";
        if(is_array($row['pais'])){
            foreach ($row['pais'] as $pais){
                if($pais=="PRT" || $pais=="PT"){
                    $paises.="Portugal<br>";
                }elseif ($pais=="ESP" || $pais=="ES"){
                    $paises.="Espanha<br>";
                }else{
                    $paises.="$pais<br>";
                }
            }
            $paises=substr($paises, 0, -4);
        }

        $row['pais']=$paises;*/
        /**colunas personalizadas **/


        $registosCliente = getInfoTabela("srv_clientes", " and FederalTaxID = '".$row["FederalTaxID"]."'  order by empresa desc");
        $row['pendente']="";
        $divida_anterior=0;
        $dividaTotal=0;
        $i=0;
 
            foreach($registosCliente as $c){


                $pendente=$c['pendente'];

                $cor="text-success";
                if($pendente<0){
                    $cor="text-danger";

                }

                if($pendente != 0 ){ //&& $pendente != $divida_anterior
                    $i++;
                    $dividaTotal += $pendente;
                    $divida_anterior=$pendente;
                    $row['pendente'] .= "<a href='../mod_documentos_pendentes/index.php?PartyID=".$c['PartyID']."'> <span class='$cor'> ".number_format($pendente, 2,'.',',')." € </span></a><br>";
                }

            }

            if($dividaTotal != 0 && $i > 1){

                $cor="text-success";
                if($dividaTotal<0){
                    $cor="text-warning";

                }

                $row['pendente'] .= "<small class='text-muted'>TOTAL</small><span class='$cor'> ".number_format($dividaTotal, 2, '.',',')." €</span><br>";
            }

            if($row['pendente']==""){
                $row['pendente']="<small class='text-success'>Não tem <i class='fa fa-thumbs-up'></i></small>";
            }


        // ORGANIZAR NOMES
        if($row['alfabetico'] != ""){
            $row['OrganizationName'] =$row['alfabetico'].'<br><span class="text-dark">'.$row['OrganizationName'].'</span><br><small class="text-muted">'.$row['FederalTaxID']."</small>";
        }else{
            $row['OrganizationName'] ='<span class="text-dark">'.$row['OrganizationName'].'</span><br><small class="text-muted">'.$row['FederalTaxID']."</small>";
        }

            if($row['zonagem']!=""){
                $row['zonagem']="<i class='fa fa-map-pin text-muted'></i> ".$row['zonagem'];
            }
            if($row['zonagem2']!=""){
                $row['zonagem']="<br><i class='fa fa-map-pin text-muted'></i> ".$row['zonagem2'];
            }
        $classificacao=$row['classificacao'];
        $row['classificacao']="";
        for($i=1;$i<=5;$i++){
            $estrela="";
            if($i<=$classificacao){
                $estrela="<i class='fa fa-star'></i>";
            }else{
                $estrela="<i class='fa fa-star-o'></i>";
            }
            $row['classificacao'].="<a href='javascript:void(0)' class='text-warning' onclick='classificarCliente(".$row['FederalTaxID'].",$i,this)'>$estrela</a>";
        }

        /** FIM colunas personalizadas**/

        $tbody=rules_for_rows($rules_for_rows,$row,$tbody,$linkDasTabelas);


        foreach ($row as $coluna=>$valor){
            $tbody=str_replace("_".$coluna."_",$valor,$tbody);
        }

        $tbody=str_replace("_funcionalidades_",$funcionalidades,$tbody);
        if($subModulo==0){
            $tbody=str_replace("_idItem_",$row['id_'.$nomeColuna],$tbody);
        }else{
            $tbody=str_replace("_subItemID_",$row['id_'.$nomeColuna],$tbody);
            $tbody=str_replace("_idItem_",$idParent,$tbody);
        }
    }

    foreach ($colunasParaMostrarNaTabela as $coluna => $regras) {
        if(isset($_GET['o']) && strpos($_GET['o'], 'asc') !== false) {
            $tplTabela = str_replace('_order_', 'desc', $tplTabela);
        } else {
            $tplTabela = str_replace('_order_', 'asc', $tplTabela);
        }
    }

    if($subModulo==0){
        $content=str_replace("_id_",$id,$content);
    }else{
        $content=str_replace("_id_",$idParent,$content);
    }

    $resultados=str_replace("_tbody_",$tbody,$tplTabela);

    if(isset($_GET['excel'])){
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Content-Disposition: attachment; filename=".$nomeTabela."_".time().".xls");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        $tempalte_excel=str_replace('_resultados_',$resultados,$tempalte_excel);
        print $tempalte_excel;
        die();
    }
}else{
    $resultados="_semResultados_";
}
$pageScript="";
include ('../_autoData.php');