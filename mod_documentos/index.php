<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

/**  FILTROS ADICIONAIS */

/* ANOS */
$ano_get="";
if(isset($_GET['ano']) && $_GET['ano']!=""){
    $ano_get=$db->escape_string($_GET['ano']);
    $add_sql.=" and  $nomeTabela.ano='$ano_get'";
    $content = str_replace('class="ano" value="'.$ano_get.'"', 'class="ano" selected value="'.$ano_get.'"',$content);
}


$anos = getInfoTabela('srv_clientes_saletransaction', '',''
    ,'','','distinct(ano) as ano');
$ops="";
foreach($anos as $ano){
    $selected="";
    if($ano['ano']==$ano_get){
        $selected="selected";
    }
    $ops.="<option $selected class='TransDocument' value='".$ano["ano"]."'>".$ano["ano"]."</option>";
}
$content=str_replace('_anos_',$ops,$content);
/* END ANOS */


// TIPO DOCUMENTOS
$tipo_documento="";
if(isset($_GET['TransDocument']) && $_GET['TransDocument']!=""){
    $tipo_documento=$db->escape_string($_GET['TransDocument']);
    $add_sql.=" and  $nomeTabela.TransDocument='$tipo_documento'";
    $content = str_replace('class="TransDocument" value="'.$tipo_documento.'"', 'class="TransDocument" selected value="'.$tipo_documento.'"',$content);
}


$tipo_documentos = getInfoTabela('srv_clientes_saletransaction', '',''
,'','','distinct(TransDocument)');
$ops="";
foreach($tipo_documentos as $tipo){

    $selected="";
    if($tipo['TransDocument']==$tipo_documento){
        $selected="selected";
    }
    $ops.="<option $selected class='TransDocument' value='".$tipo["TransDocument"]."'>".$tipo["TransDocument"]."</option>";
}

$content=str_replace('_tipoDoc_',$ops,$content);

// END TIPO DOCUMENTOS

// ENTIDADES

$id_cliente="";
if(isset($_GET['id_cliente']) && $_GET['id_cliente']!=""){
    $id_cliente=$db->escape_string($_GET['id_cliente']);
    $add_sql.=" and PartyID='$id_cliente'";
    $content = str_replace('class="id_cliente" value="'.$id_cliente.'"', 'class="id_cliente" selected value="'.$id_cliente.'"',$content);
}

$entidades = getInfoTabela("srv_clientes", "and ativo = 1 and srv_clientes.PartyID != '' order by OrganizationName asc");

$ops="";
foreach($entidades as $entidade){
    $selected="";

    if($entidade['id_cliente'] == $id_cliente){
        $selected="selected";
    }

    $ops.="<option $selected class='id_cliente' value='".$entidade["id_cliente"]."'>".$entidade["OrganizationName"]."</option>";
}

$content=str_replace('_clientes_',$ops,$content);
// FIM ENTIDADES


// SERIES DOCUMENTO
$serie_doc="";
if(isset($_GET['TransSerial']) && $_GET['TransSerial']!=""){
    $serie_doc=$db->escape_string($_GET['TransSerial']);
    $add_sql.=" and  $nomeTabela.TransSerial='$serie_doc'";
    $content = str_replace('class="TransSerial" value="'.$serie_doc.'"', 'class="TransSerial" selected value="'.$serie_doc.'"',$content);
}

$tipo_documentos_series = getInfoTabela('srv_clientes_saletransaction', ' and ativo=1 order by TransSerial*1 desc',''
    ,'','','distinct(TransSerial)');

$ops="";
foreach($tipo_documentos_series as $tipo){

    $selected="";
    if($tipo['TransSerial']==$serie_doc){
        $selected="selected";
    }
    $ops.="<option $selected class='TransSerial' value='".$tipo["TransSerial"]."'>".$tipo["TransSerial"]."</option>";
}

$content=str_replace('_serieDoc_',$ops,$content);
// FIM SERIES DOCUMENTO

// DATA INICIO

$data_inicio="";
$data_fim="";
if((isset($_GET['data_inicio']) and isset($_GET['data_fim'])) and ($_GET['data_inicio']!="" and  $_GET['data_fim']!="")){
    $data_inicio=($_GET['data_inicio']);
    $data_fim=($_GET['data_fim']);

    $data_inicio_sql=data_portuguesa($_GET['data_inicio']);
    $data_fim_sql=data_portuguesa($_GET['data_fim']);
    $add_sql.=" and ($nomeTabela.CreateDate>='$data_inicio_sql 00:00:00' and $nomeTabela.CreateDate<='$data_fim_sql 23:59:59') ";


}
$content=str_replace("_data_inicio_",$data_inicio,$content);
$content=str_replace("_data_fim_",$data_fim,$content);

// DATA FIM

/** fFIM FILTROS ADICIONAIS */

include ("../_igualEmTodasTabelas.php");
$tr=0;
$sql="SELECT count(".$nomeTabela.".id_".$nomeColuna.") FROM ".$nomeTabela." $innerjoin WHERE 1 $add_sql";

$result=runQ($sql,$db,"CONTAR RESULTADOS");
while ($row = $result->fetch_assoc()) {
    $tr=$row['count('.$nomeTabela.'.id_'.$nomeColuna.')']; // total rows
}
if($tr>0){
    include "../_paginacao.php";

    if($subModulo==0){
        include "../_funcionalidades.php";
    }else{
        include "../_funcionalidadesSubModulos.php";
    }


    $tbody="";

    $add_sql=str_replace("order by"," group by $nomeTabela.id_$nomeColuna order by",$add_sql);
    $add_sql.=" LIMIT ".(($pn-1)*$pr)." , $pr";
    $sql="SELECT *, $nomeTabela.CreateDate as CreationDate1 FROM $nomeTabela $innerjoin  WHERE 1 $add_sql";
    $result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
    while ($row = $result->fetch_assoc()) {
        $tbody.=$linhaTD;

        /**colunas personalizadas **/

        $cliente = getInfoTabela('srv_clientes', ' and PartyID = "'.$row['PartyID'].'"');
        $nome_cliente = "";
        if(isset($cliente[0])){
            $nome_cliente= ($cliente[0]['OrganizationName']);
        }
        $row['nome_cliente']=$nome_cliente;


        $row['dia']=date("d",strtotime($row['CreationDate1']));
        $row['mes']=date("m",strtotime($row['CreationDate1']));
        $row['mes']=$cfg_meses_abr[$row['mes']*1];
        $row['ano']=date("Y",strtotime($row['CreationDate1']));

        $row['dia1']=date("d",strtotime($row['data_vencimento']));
        $row['mes1']=date("m",strtotime($row['data_vencimento']));
        $row['mes1']=$cfg_meses_abr[$row['mes1']*1];
        $row['ano1']=date("Y",strtotime($row['data_vencimento']));

        $row['TotalAmount'] = number_format($row['TotalAmount'], '2', '.', ' ').' €';

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