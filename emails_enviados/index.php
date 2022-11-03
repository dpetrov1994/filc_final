<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

/**  FILTROS ADICIONAIS */

if(isset($_GET['destinatario'])){
    $destinatario=$db->escape_string($_GET['destinatario']);
    $add_sql.=" and $nomeTabela.destinatario='$destinatario'";
}
if(isset($_GET['id_criou'])){
    $id_criou=$db->escape_string($_GET['id_criou']);
    $add_sql.=" and $nomeTabela.id_criou='$id_criou'";
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

    $add_sql.=" LIMIT ".(($pn-1)*$pr)." , $pr";
    $sql="SELECT * FROM $nomeTabela $innerjoin  WHERE 1 $add_sql";
    $result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
    while ($row = $result->fetch_assoc()) {
        $tbody.=$linhaTD;

        /**colunas personalizadas **/

        //

        /** FIM colunas personalizadas**/
        foreach ($rules_for_rows as $rule){
            foreach ($row as $coluna=>$valor){
                if($coluna==$rule['coluna']){
                    switch ($rule['regra']) {
                        case "value":
                            $tbody=str_replace("_".$coluna."_",$rule['valor'],$tbody);
                            break;
                        case "link":
                            $tbody=str_replace("_".$coluna."_","<a href='_link_'><strong>_".$coluna."_</strong></a>",$tbody);
                            if(isset($rule['valor']) && $rule['valor']!=""){
                                $tbody=str_replace("_link_",$rule['valor'],$tbody);
                            }
                            break;
                        case "func":
                            $tbody=str_replace("_".$coluna."_",$rule['valor']($valor),$tbody);
                            break;
                        case "cortaStr":
                            $tbody=str_replace("_".$coluna."_",cortaStr($valor,$rule['valor']),$tbody);
                            break;
                        case "date":
                            $tbody=str_replace("_".$coluna."_",strftime($rule['valor'], strtotime($valor)),$tbody);
                            break;
                        case "if":
                            $condicoes=explode(",,",$rule['valor']);
                            foreach ($condicoes as $condicao){
                                $explode=explode("=>",$condicao);
                                $condicao=$explode[0];
                                $resultado=$explode[1];
                                if($valor==$condicao){
                                    $tbody=str_replace("_".$coluna."_",$resultado,$tbody);
                                }else{
                                    if($condicao=="ELSE"){
                                        $tbody=str_replace("_".$coluna."_",$resultado,$tbody);
                                    }
                                }
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
            $tbody=str_replace("_link_",$linkDasTabelas,$tbody);
        }


        /** OUTRAS colunas personalizadas **/

        $sql2="select * from utilizadores where id_criou='".$row['id_criou']."'";
        $result2=runQ($sql2,$db,"SELECT UTILIZADOR");
        while ($row2 = $result2->fetch_assoc()) {
            $tbody=str_replace("_nome_utilizador_","<a href='index.php_addUrl_&id_criou=".$row['id_criou']."'>".$row2['nome_utilizador']."</a>",$tbody);
        }
        $tbody=str_replace("_nome_utilizador_","<a href='index.php_addUrl_&id_criou=".$row['id_criou']."'>[AUTO]</a>",$tbody);

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