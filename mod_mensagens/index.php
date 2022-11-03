<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

if(isset($enviadas) && $enviadas==1){

    $innerjoin=" 
            inner join utilizadores_mensagens on utilizadores_mensagens.id_mensagem=$nomeTabela.id_$nomeColuna
            inner join utilizadores on utilizadores.id_utilizador=utilizadores_mensagens.id_utilizador 
            ";

    $add_sql.=" and $nomeTabela.id_criou=".$_SESSION['id_utilizador'];
}else{
    $add_sql.=" and utilizadores_mensagens.id_utilizador=".$_SESSION['id_utilizador'];
}


/**  FILTROS ADICIONAIS */

//

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

    $add_sql=str_replace("order by","  order by",$add_sql);
    $add_sql.=" LIMIT ".(($pn-1)*$pr)." , $pr";
    $sql="SELECT *,mensagens.created_at as created_atMensagem,mensagens.descricao as descricaoMensagem  FROM $nomeTabela $innerjoin  WHERE 1 $add_sql";
    $result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
    while ($row = $result->fetch_assoc()) {
        $tbody.=$linhaTD;

        /**colunas personalizadas **/

        if(isset($enviadas) && $enviadas==1){
            $tbody=str_replace("_estrela_","",$tbody);
        }

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

        $tbody=str_replace("_dataMensagem_",strftime("%d/%m/%Y %H:%M", strtotime($row['created_atMensagem'])),$tbody);
        $tbody=str_replace("_idUtilizadorMensagem_",($row['id_utilizador_mensagem']),$tbody);

        if(!isset($enviadas) && is_null($row['visto_em'])){
            $tbody=str_replace("_estado_","<span class='label label-info'>Nova!</span>",$tbody);
        }
        $tbody=str_replace("_estado_","",$tbody);

        $dir="docs/".$row['id_mensagem'];
        if(is_dir($dir)){
            $tbody=str_replace("_anexos_","<i class=\"fa fa-paperclip fa-2x text-muted\"></i>",$tbody);
        }
        $tbody=str_replace("_anexos_","",$tbody);

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