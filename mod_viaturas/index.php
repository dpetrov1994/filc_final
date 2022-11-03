<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

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

    $add_sql=str_replace("order by"," group by $nomeTabela.id_$nomeColuna order by",$add_sql);
    $add_sql.=" LIMIT ".(($pn-1)*$pr)." , $pr";
    $sql="SELECT $nomeTabela.* FROM $nomeTabela $innerjoin  WHERE 1 $add_sql";
    $result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
    while ($row = $result->fetch_assoc()) {
        $tbody.=$linhaTD;

        $kms_assistencias = getInfoTabela('assistencias',
            ' and id_viatura="'.$row['id_viatura'].'" and terminada = "1" and externa="1" order by id_assistencia desc limit 1',''
            ,'','','assistencias.kilometros');


        $kms_atuais = $row['kms_inicio'];
        if(isset($kms_assistencias[0])){
            $kms_atuais=$kms_assistencias[0]['kilometros'];
        }
        $row['kms'] = number_format($kms_atuais, 0,'',' ').' KM';

        /**colunas personalizadas **/

        // SEGURO
        $dia=date("d",strtotime($row['data_seguro']));
        $mes=date("m",strtotime($row['data_seguro']));
        $mes=$cfg_meses_abr[$mes*1];
        $ano=date("Y",strtotime($row['data_seguro']));

        $row['data_seguro1']="
    <div style='width: 30px;margin-left: 30px;border: 1px solid gray'>
        <div style='background: #eee;text-align: center'>
            <b style='font-size: 11px' class='text-danger'>_mes_</b>
        </div>
        <div style='height: 20px;text-align: center;font-size: 15px'>_dia_</div>
        <div style='height: 14px;text-align: center;font-size: 10px;color: blue'>_ano_</div>    
    </div>";

        $row['data_seguro1'] = str_replace('_ano_', $ano, $row['data_seguro1']);
        $row['data_seguro1'] = str_replace('_mes_', $mes, $row['data_seguro1']);
        $row['data_seguro1'] = str_replace('_dia_', $dia, $row['data_seguro1']);

        // INSPECAO
        $dia=date("d",strtotime($row['data_inspecao']));
        $mes=date("m",strtotime($row['data_inspecao']));
        $mes=$cfg_meses_abr[$mes*1];
        $ano=date("Y",strtotime($row['data_inspecao']));

        $row['data_inspecao1']="
    <div style='width: 30px;    margin-left: 30px;border: 1px solid gray'>
        <div style='background: #eee;text-align: center'>
            <b style='font-size: 11px' class='text-danger'>_mes_</b>
        </div>
        <div style='height: 20px;text-align: center;font-size: 15px'>_dia_</div>
        <div style='height: 14px;text-align: center;font-size: 10px;color: blue'>_ano_</div>    
    </div>";

        $row['data_inspecao1'] = str_replace('_ano_', $ano, $row['data_inspecao1']);
        $row['data_inspecao1'] = str_replace('_mes_', $mes, $row['data_inspecao1']);
        $row['data_inspecao1'] = str_replace('_dia_', $dia, $row['data_inspecao1']);

        // DATA LAVAGEM
        $dia=date("d",strtotime($row['data_lavagem']));
        $mes=date("m",strtotime($row['data_lavagem']));
        $mes=$cfg_meses_abr[$mes*1];
        $ano=date("Y",strtotime($row['data_lavagem']));

        $row['data_lavagem1']="
    <div style='width: 30px;margin-left: 30px;border: 1px solid gray'>
        <div style='background: #eee;text-align: center'>
            <b style='font-size: 11px' class='text-danger'>_mes_</b>
        </div>
        <div style='height: 20px;text-align: center;font-size: 15px'>_dia_</div>
        <div style='height: 14px;text-align: center;font-size: 10px;color: blue'>_ano_</div>    
    </div>";

        $row['data_lavagem1'] = str_replace('_ano_', $ano, $row['data_lavagem1']);
        $row['data_lavagem1'] = str_replace('_mes_', $mes, $row['data_lavagem1']);
        $row['data_lavagem1'] = str_replace('_dia_', $dia, $row['data_lavagem1']);


        $tecnico = getInfoTabela('utilizadores', ' and id_utilizador = "'.$row['id_tecnico'].'"');
        $nome_tecnico = "";
        if(isset($tecnico[0])){
            $nome_tecnico= ($tecnico[0]['nome_utilizador']);
        }
        $row['nome_utilizador']=$nome_tecnico;

        if($row['nome_utilizador'] == ""){
            $row['responsavel'] = "<span class='text-danger'>Sem responsável</span>";
        }else{
            $row['responsavel'] = "<span class=''><i class='fa fa-user'></i>".$row['nome_utilizador']."</span>";
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