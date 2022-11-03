<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

/**  FILTROS ADICIONAIS */

$familiaa="";
if(isset($_GET['familia']) && $_GET['familia']!=""){
    $familiaa=$db->escape_string($_GET['familia']);
    $add_sql.=" and produtos.familia='$familiaa'";
    $content = str_replace('class="familia" value="'.$familiaa.'"', 'class="familia" selected value="'.$familiaa.'"',$content);
}

$familias = getInfoTabela('produtos', " and familia <> ''", ''
,'','',"distinct(familia) as familia");

$ops="";
foreach($familias as $familia){
    $selected="";

    if($familia['familia'] == $familiaa){
        $selected="selected";
    }

    $ops.="<option $selected class='familia' value='".$familia["familia"]."'>".$familia["familia"]."</option>";
}

$content=str_replace('_familias_',$ops,$content);

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

        $foto="../_contents/produtos/".$row['id_produto']."/".$row['foto'];
        if(!is_file($foto)){
            $foto="../assets/layout/img/placeholder.png";
        }
        $row['foto']="<img src='$foto' style='width: 150px;object-fit: contain'>";

        $row['preco_compra'] = number_format($row['preco_compra'], 2,'.', ' ').' €';
        $row['preco_sem_iva'] = number_format($row['preco_sem_iva'], 2,'.', ' ');

        $row['preco_sem_iva'] = str_replace(',','.',$row['preco_sem_iva']);
        $row['preco_sem_iva'] = number_format( $row['preco_sem_iva'], 2, '.', ',');
        $row['preco_sem_iva'].=" €";

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