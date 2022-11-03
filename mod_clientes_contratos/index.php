<?php
include('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

/**  FILTROS ADICIONAIS */

$id_cliente="";
if(isset($_GET['id_cliente']) && $_GET['id_cliente']!=0){
    $id_cliente=$db->escape_string($_GET['id_cliente']);
    $add_sql.=" and $nomeTabela.id_cliente='$id_cliente'";
}
$sql_preencher="select * from srv_clientes where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="<option value='0'>Todos</option>";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $selected="";
    if($id_cliente==$row_preencher['id_cliente']){
        $selected="selected";
    }
    $ops.="<option $selected class='id_cliente' value='".$row_preencher["id_cliente"]."'>".$row_preencher["OrganizationName"]."</option>";
}
$content=str_replace("_id_cliente_",$ops,$content);

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
    if(!isset($_GET['excel'])){$add_sql.=" LIMIT ".(($pn-1)*$pr)." , $pr";}
    $sql="SELECT * FROM $nomeTabela $innerjoin  WHERE 1 $add_sql";
    $result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
    while ($row = $result->fetch_assoc()) {
        //$tbody.=$linhaTD; -> movido para baixo

        /**colunas personalizadas **/

        $row['nome_cliente']="";
        $sql2 = "select * from srv_clientes where id_cliente='" . $row['id_cliente']."'";
        $result2 = runQ($sql2, $db, 0);
        while ($row2 = $result2->fetch_assoc()) {
            $row['OrganizationName'] = $row2['OrganizationName'];
        }

        $row['segundos_restantes']=secondsToTime($row['segundos_restantes']);



        /** FIM colunas personalizadas**/

        $linhaTmp=$linhaTD;
        $linhaTmp=rules_for_rows($rules_for_rows,$row,$linhaTmp,$linkDasTabelas);

        foreach ($row as $coluna=>$valor){
            $linhaTmp=str_replace("_".$coluna."_",$valor,$linhaTmp);
        }

        $linhaTmp=str_replace("_funcionalidades_",$funcionalidades,$linhaTmp);
        if($subModulo==0){
            $linhaTmp=str_replace("_idItem_",$row['id_'.$nomeColuna],$linhaTmp);
        }else{
            $linhaTmp=str_replace("_subItemID_",$row['id_'.$nomeColuna],$linhaTmp);
            $linhaTmp=str_replace("_idItem_",$idParent,$linhaTmp);
        }

        $tbody.=$linhaTmp;
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