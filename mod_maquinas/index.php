<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

/**  FILTROS ADICIONAIS */

// ENTIDADES

$id_cliente="";
if(isset($_GET['id_cliente']) && $_GET['id_cliente']!=""){
    $id_cliente=$db->escape_string($_GET['id_cliente']);
    $add_sql.=" and srv_clientes.id_cliente='$id_cliente'";
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
    $sql="SELECT * FROM $nomeTabela $innerjoin  WHERE 1 $add_sql";
    $result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
    while ($row = $result->fetch_assoc()) {
        $tbody.=$linhaTD;

        /**colunas personalizadas **/


        $assistencias = getInfoTabela('assistencias_clientes_maquinas', " and id_maquina='".$row['id_maquina']."'",
        '','','','count(id_maquina) as maquina_counter');
        $row['count_assistencias'] = $assistencias[0]['maquina_counter'];

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