<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

/**  FILTROS ADICIONAIS */

if(isset($id_tecnico_pendente)){
    $add_sql.=" and (id_utilizador='$id_tecnico_pendente' or data_inicio='$data_inicio_pendente')";
}


if(isset($id_tecnico_confirmado)){
    $add_sql.=" and (id_utilizador!='0' or data_inicio!='$data_inicio_confirmado')";
}

$concluido="Todas";
if(isset($_GET['terminada']) && $_GET['terminada']!="Todas"){
    $concluido=$db->escape_string($_GET['terminada']);
    $add_sql.=" and terminada='$concluido'";
}
$content=str_replace('value="'.$concluido.'" class="terminada"','value="'.$concluido.'" selected class="terminada"',$content);


$data_inicio="";
$data_fim="";
if((isset($_GET['data_assistencia_iniciada']) and ($_GET['data_assistencia_iniciada']!="" and isset($_GET['data_assistencia_terminada'])) )){

    $data_inicio=($_GET['data_assistencia_iniciada']);
    $data_inicio_sql=data_portuguesa($_GET['data_assistencia_iniciada']);

    if($_GET['data_assistencia_terminada']!=""){
        $data_fim=($_GET['data_assistencia_terminada']);
        $data_fim_sql=data_portuguesa($_GET['data_assistencia_terminada']);
        $add_sql.=" and ($nomeTabela.data_assistencia_iniciada>='$data_inicio_sql 00:00:00' and $nomeTabela.data_assistencia_terminada<='$data_fim_sql 23:59:00') ";

    }else{
        $add_sql.=" and ($nomeTabela.data_assistencia_iniciada>='$data_inicio_sql 00:00:00') ";
    }

}

$content=str_replace("_data_assistencia_iniciada_",$data_inicio,$content);
$content=str_replace("_data_assistencia_terminada_",$data_fim,$content);


$utilizadores = getInfoTabela('utilizadores', ' and ativo=1');


$ops="";
foreach($utilizadores as $utilizador){
    $ops.='<option value="'.$utilizador['id_utilizador'].'" class="id_utilizador">'.$utilizador['nome_utilizador'].'</option>';
}
$content=str_replace("_utilizadores_",$ops,$content);

$id_utilizador="Todos";
if(isset($_GET['id_utilizador']) && $_GET['id_utilizador']!="Todos"){
    $id_utilizador=$db->escape_string($_GET['id_utilizador']);
    $add_sql.=" and id_utilizador = '$id_utilizador'";
}
$content=str_replace('value="'.$id_utilizador.'" class="id_utilizador"','value="'.$id_utilizador.'" selected class="id_utilizador"',$content);



$clientes = getInfoTabela('srv_clientes', ' and ativo=1');
$ops="";
$id_cliente="Todas";
if(isset($_GET['id_cliente']) && $_GET['id_cliente']!="Todas"){
    $id_cliente=$db->escape_string($_GET['id_cliente']);
    $add_sql.=" and id_cliente = '$id_cliente'";
}
foreach($clientes as $cliente){
    $selected="";
    if($id_cliente==$cliente['id_cliente']){
        $selected="selected";
    }
    $ops.='<option '.$selected.' value="'.$cliente['id_cliente'].'" class="id_cliente">'.$cliente['OrganizationName'].'</option>';
}
$content=str_replace("_id_cliente_",$ops,$content);

$categorias = getInfoTabela('assistencias_categorias', ' and ativo=1');
$ops="";
$id_categoria="Todas";
if(isset($_GET['id_categoria']) && $_GET['id_categoria']!="Todas"){
    $id_categoria=$db->escape_string($_GET['id_categoria']);
    $add_sql.=" and id_categoria = '$id_categoria'";
}
foreach($categorias as $categoria){
    $selected="";
    if($id_categoria==$categoria['id_categoria']){
        $selected="selected";
    }
    $ops.='<option '.$selected.' value="'.$categoria['id_categoria'].'" class="id_categoria">'.$categoria['nome_categoria'].'</option>';
}
$content=str_replace("_id_categoria_",$ops,$content);


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

        if($row['data_inicio2'] != 0){
            $row['data_inicio'] = $row['data_inicio2'];
        }

        if($row['data_inicio']!="0000-00-00 00:00:00"){
            $row['dia']=date("d",strtotime($row['data_inicio']));
            $row['mes']=date("m",strtotime($row['data_inicio']));
            $row['mes']=$cfg_meses_abr[$row['mes']*1];
            $row['ano']=date("Y",strtotime($row['data_inicio']));
            $data_inicio="<div style='width: 30px;border: 1px solid gray'><div style='background: #fff;text-align: center'><b style='font-size: 11px' class='text-danger'>".$row['mes']."</b></div><div style='height: 20px;text-align: center;font-size: 15px'>".$row['dia']."</div><div style='height: 14px;text-align: center;font-size: 10px;color:#dc358c;'>".$row['ano']."</div></div>";
        }else{
            $data_inicio="<i class='fa fa-question-circle-o fa-2x'></i>";
        }
        $row['data_inicio']=$data_inicio;



        $nome_tecnico = "<i class='text-warning'>Não definido</i>";
        if($row['id_utilizador']!=0){
            $tecnico = getInfoTabela('utilizadores', ' and id_utilizador = "'.$row['id_utilizador'].'"');

            if(isset($tecnico[0])){
                $nome_tecnico= ($tecnico[0]['nome_utilizador']);
            }
            $row['nome_utilizador']=$nome_tecnico;
        }

        
        $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$row['id_categoria'].'"');
        $nome_categoria = "";
        if(isset($categoria[0])){
            $nome_categoria= "<span class='label ' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</span>";
        }
        $row['nome_categoria']=$nome_categoria;


        $tipo_assistencia = "<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
        if($row['externa'] == "0"){
            $tipo_assistencia = "<small class='label label-danger'><i class='fa fa-home'></i> Interna</small>";
        }

        $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$row['id_cliente'].'"');
        $nome_cliente = "";
        if(isset($cliente[0])){
            $nome_cliente= ($cliente[0]['OrganizationName']);
        }
        $row['nome_cliente']="<i class='fa fa-user'></i>$nome_tecnico<br> $nome_cliente<br>$tipo_assistencia $nome_categoria<br><div class='well well-sm'>".nl2br($row['descricao'])."</div>";

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
$pageScript='<script src="../assets/layout/js/plugins/signature_pad.min.js"></script>';
include ('../_autoData.php');