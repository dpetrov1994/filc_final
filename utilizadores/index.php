<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");


/**  FILTROS ADICIONAIS */

$sql_preencher="select * from grupos where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<option class='grupos' value='".$row_preencher["id_grupo"]."'>".$row_preencher["nome_grupo"]."</option>";
}
$content=str_replace("_grupos_",$ops,$content);

if(isset($_GET['grupo']) && $_GET['grupo']!=0){
    $content=str_replace("class='grupos' value='".$_GET['grupo']."'","value='".$_GET['grupo']."' selected",$content);
    $id_grupo=$db->escape_string($_GET['grupo']);
    $add_sql .= " and grupos_utilizadores.id_grupo='$id_grupo'  ";
}

if(isset($_GET['estado_email'])){
    $content=str_replace("class='estado_email' value='".$_GET['estado_email']."'","value='".$_GET['estado_email']."' selected",$content);

    if($_GET['estado_email']!=0){
        if($_GET['estado_email']==1){
            $add_sql .= " and verification_token=''";
        }elseif ($_GET['estado_email']==2){
            $add_sql .= " and verificado=2 and verification_token<>''";
        }elseif ($_GET['estado_email']==3){
            $add_sql .= " and verificado=1 and verification_token<>''";
        }
    }
}

/** FIM FILTROS ADICIONAIS */

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

        /** FIM colunas personalizadas**/

        foreach ($rules_for_rows as $rule){
            foreach ($row as $coluna=>$valor){
                if($coluna==$rule['coluna']){
                    switch ($rule['regra']) {
                        case "link":
                            $tbody=str_replace("_".$coluna."_","<a href='_link_'><strong>_".$coluna."_</strong></a>",$tbody);
                            if(isset($rule['valor']) && $rule['valor']!=""){
                                $tbody=str_replace("_link_",$rule['valor'],$tbody);
                            }
                            break;
                        case "cortaNome":
                            $tbody=str_replace("_".$coluna."_",cortaNome($valor),$tbody);
                            break;
                        case "cortaStr":
                            $tbody=str_replace("_".$coluna."_",cortaStr($valor,$rule['valor']),$tbody);
                            break;
                        case "date":
                            $tbody=str_replace("_".$coluna."_",strftime($rule['valor'], strtotime($valor)),$tbody);
                            break;
                        case "value":
                            $tbody=str_replace("_".$coluna."_",$rule['valor'],$tbody);
                            break;
                        case "if":
                            $condicoes=explode(",,",$rule['valor']);
                            foreach ($condicoes as $condicao){
                                $explode=explode("=>",$condicao);
                                $condicao=$explode[0];
                                $resultado=$explode[1];
                                if($valor==$condicao){
                                    $tbody=str_replace("_".$coluna."_",$resultado,$tbody);
                                }
                            }
                            $tbody=str_replace("_".$coluna."_",cortaStr($valor,$rule['valor']),$tbody);
                            break;
                        default:
                            break;
                    }
                }
            }
            $tbody=str_replace("_link_",$linkDasTabelas,$tbody);
        }


        /** OUTRAS colunas personalizadas **/

        $grupos="";
        $sub_sql="select grupos.id_grupo,grupos.nome_grupo from grupos inner join grupos_utilizadores on grupos_utilizadores.id_grupo=grupos.id_grupo where grupos.ativo=1 and id_utilizador=".$row['id_utilizador'];
        $sub_result=runQ($sub_sql,$db,"LOOP PELOS GRUPOS");
        while ($sub_row = $sub_result->fetch_assoc()) {
            $grupos.="<a href='../grupos/detalhes.php?id=".($sub_row['id_grupo'])."' class='label label-primary'>".removerHTML($sub_row['nome_grupo'])." <i class='fa fa-external-link'></i></a> ";
        }
        $tbody=str_replace("_grupos_",$grupos,$tbody);


        if($row['verification_token']==""){
            $estado="<span class='label label-info'>Envio Pendente</span>";
        }elseif($row['verificado']==1){
            $estado="<span class='label label-success'>Verificado</span>";
        }else{
            $estado="<span class='label label-warning'>Verificação Pendente</span>";
        }
        $tbody=str_replace("_estado_",$estado,$tbody);

        /** FIM  OUTRAS colunas personalizadas**/


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