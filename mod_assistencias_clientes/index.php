<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

if(isset($assinado)){
    $add_sql.=" and assinado= $assinado";
}

if(isset($aprovado)){
    $add_sql.=" and aprovado= $aprovado";
}

if(isset($faturado)){
    $add_sql.=" and faturado= $faturado";
}

/**  FILTROS ADICIONAIS */

$data_inicio="";
$data_fim="";
if((isset($_GET['data_inicio']) and ($_GET['data_inicio']!="" and isset($_GET['data_fim'])) )){

    $data_inicio=($_GET['data_inicio']);
    $data_inicio_sql=data_portuguesa($_GET['data_inicio']);
    $data_fim=($_GET['data_fim']);
    $data_fim_sql=data_portuguesa($_GET['data_fim']);
    $add_sql.=" and ($nomeTabela.data_inicio>='$data_inicio_sql 00:00:00' and $nomeTabela.data_inicio<='$data_fim_sql 23:59:00') ";

}

$content=str_replace("_data_inicio_",$data_inicio,$content);
$content=str_replace("_data_fim_",$data_fim,$content);

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


        /**colunas personalizadas **/

        $html=gerarBlocoAssistencia($row);

        $filhos_arr=getInfoTabela($nomeTabela," and ativo=1 and id_pai='".$row['id_assistencia_cliente']."' order by id_assistencia_cliente asc");
        $children="";
        if(count($filhos_arr)>0){
            foreach ($filhos_arr as $filho){
                $children.=gerarBlocoAssistencia($filho);
            }
            $children="<div class='assists-filhos' style='margin-left: 10px; padding-left: 10px;margin-right: 10px;padding-top: 10px;padding-bottom: 10px;margin-bottom: 10px;border-left: 2px solid #8CC8FB;border-bottom: 2px solid #8CC8FB;'>$children</div>";
        }

        $row['dados']="
<div>
$html
$children
</div>";


        $tbody.=$linhaTD;

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






function gerarBlocoAssistencia($row){

    global $cfg_diasdasemana;

    $tipo_assistencia = "<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
    if($row['externa'] == "0"){
        $tipo_assistencia = "<small class='label label-danger'><i class='fa fa-home'></i> Interna</small>";
    }

    $row['externa']=$tipo_assistencia;

    $tecnico = getInfoTabela('utilizadores', ' and id_utilizador = "'.$row['id_utilizador'].'"');
    $nome_tecnico = "";
    if(isset($tecnico[0])){
        $nome_tecnico= ($tecnico[0]['nome_utilizador']);
    }
    $row['nome_utilizador']=$nome_tecnico;

    $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$row['id_cliente'].'"');
    $nome_cliente = "";
    if(isset($cliente[0])){
        $nome_cliente= ($cliente[0]['OrganizationName']);
    }
    $row['nome_cliente']=$nome_cliente;

    $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$row['id_categoria'].'"');
    $nome_categoria = "<span class='label ' style='background: black'>Sem categoria</span>";
    if(isset($categoria[0])){
        $nome_categoria= "<span class='label ' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</span>";
    }
    $row['nome_categoria']=$nome_categoria;

    $row['NumServico']=$row['nome_assistencia_cliente'];


    if(nl2br($row['descricao'])!=""){
        $descricao_mobile="<tr>
                <td colspan='2' style='text-align: center'><i class='fa fa-comment'></i> Comentários<br>  <i class='text-info'>".nl2br($row['descricao'])."</i></td>
            </tr>";
        $descricao_pc="
                <td colspan='2' style='text-align: center'><i class='fa fa-comment'></i> Comentários<br>  <i class='text-info'>".nl2br($row['descricao'])."</i></td>
            ";
    }else{
        $descricao_pc="
                <td colspan='2' style='text-align: center'></td>
            ";
    }


    $maquinas="";
    $maquinas_assistencia=getInfoTabela('assistencias_clientes_maquinas', ' and ativo=1 and id_assistencia_cliente = "'.$row['id_assistencia_cliente'].'"');
    foreach ($maquinas_assistencia as $ma){
        $maquina=getInfoTabela('maquinas', ' and id_maquina= "'.$ma['id_maquina'].'"');
        $maquina=$maquina[0];

        $garantia="";
        if($ma['garantia']==1){
            $garantia="<small class='text-warning garantia-info'><i class='fa fa-warning'></i> Garantia</small><br>";
        }

        $concluido="";
        if($ma['concluido']==0){
            $concluido="<small class='text-danger garantia-info'><i class='fa fa-warning'></i> Não Concluído</small><br>";
        }

        $revisao="";
        if($ma['revisao_periodica']==1){
            $revisao="<small class='text-info garantia-info'><i class='fa fa-info-circle'></i> Revisão: ".number_format($ma['horas_revisao'],0,"",".")."h </small><br>";
        }
        $maquinas.="<tr class='border-bottom'>
                        <td>
                            <b>".$maquina['nome_maquina']." (".$maquina['ref'].") </b>
                        </td>
                        <td>
                            $concluido $garantia $revisao
                        </td>
                    </tr>";
    }
    if($maquinas!=""){
        $maquinas_mobile="
            <tr>
                <td colspan='2'><div class='text-center'><b>Lista de máquinas</b></div><table class='table table-borderless table-vcenter'>$maquinas</table></td>
            </tr>
";
        $maquinas_pc="
            <tr>
                <td colspan='4'><div class='text-center'><b>Lista de máquinas</b></div><table class='table table-borderless table-vcenter'>$maquinas</table></td>
            </tr>
";
    }else{
        $maquinas_mobile="<tr>
                            <td colspan='2' class='text-center'> <i class='text-muted'>Sem máquinas</i> </td>
                        </tr>";
        $maquinas_pc="<tr>
                            <td colspan='4' class='text-center'> <i class='text-muted'>Sem máquinas</i> </td>
                        </tr>";
    }

    $por_terminar="";
    $por_terminar_bg="";
    if($row['por_terminar']==1){
        $por_terminar="<span class='text-danger '><i class='fa fa-warning'></i> Por terminar </span>";
        $por_terminar_bg="bg-danger";
    }

    $data_inicio="";
    if($row['data_inicio']!="0000-00-00 00:00:00"){
        if(date("d/m/Y", strtotime($row['data_inicio']))==date("d/m/Y", strtotime(current_timestamp))){
            $data_inicio = "".date("H:i", strtotime($row['data_inicio']));
        }elseif(date("d/m/Y", strtotime($row['data_inicio']))==date("d/m/Y", strtotime(current_timestamp. ' -1 days'))){
            $data_inicio = "Ontem às ".date("H:i", strtotime($row['data_inicio']));
        }else{
            $data_inicio = $cfg_diasdasemana[date("w", strtotime($row['data_inicio']))]."/".date("d, H:i", strtotime($row['data_inicio']));
        }

        $data_inicio="$data_inicio";
    }



    $data_fim="";
    if($row['data_fim']!="0000-00-00 00:00:00"){
        if(date("d/m/Y", strtotime($row['data_fim']))==date("d/m/Y", strtotime(current_timestamp))){
            $data_fim = "".date("H:i", strtotime($row['data_fim']));
        }elseif(date("d/m/Y", strtotime($row['data_fim']))==date("d/m/Y", strtotime(current_timestamp. ' -1 days'))){
            $data_fim = "Ontem às ".date("H:i", strtotime($row['data_fim']));
        }else{
            $data_fim = $cfg_diasdasemana[date("w", strtotime($row['data_fim']))]."/".date("d, H:i", strtotime($row['data_fim']));
        }

        $data_fim="$data_fim";
    }

    //$segundos_decorrer=strtotime(current_timestamp)-strtotime($row['data_inicio']);

    $emails=json_decode($row['emails']);
    $email_enviado="<span class='text-danger'><i class='fa fa-info-circle'></i> Relatório não enviado</span>";
    if($row['email_enviado']==1 && is_array($emails)){
        $email_enviado="<span class='text-success '><i class='fa fa-paper-plane'></i> Relatório enviado</span>";
    }

    $contrato = getInfoTabela('clientes_contratos', ' and id_contrato = "'.$row['id_contrato'].'"');
    $nome_contrato="<span class='text-danger' ><i class='fa fa-file-text-o'></i> Sem contrato</span>";
    if(isset($contrato[0])){
        $nome_contrato="<small class='text-info'><i class='fa fa-file-text-o'></i> ".$contrato[0]['nome_contrato']."</small>";
    }

    $data_aprovado="";
    if($row['data_aprovado']!="0000-00-00 00:00:00"){
        $data_aprovado="<small>Aprovado em:".date("d/m/Y H:i",strtotime($row['data_aprovado']))."</small>";
    }

    $obs_faturar_mobile="";
    if($row['obs_faturar']!=""){
        $obs_faturar_mobile="<tr>
                <td colspan='2' style='text-align: center'><i class='fa fa-info-circle'></i> Info para fatura ($data_aprovado):<br>  <i class='text-primary'>".nl2br($row['obs_faturar'])."</i></td>
            </tr>";
        $obs_faturar_pc="
                <td colspan='2' style='text-align: center'><i class='fa fa-info-circle'></i> Info para fatura ($data_aprovado):<br>  <i class='text-primary'>".nl2br($row['obs_faturar'])."</i></td>
            ";
    }else{
        $obs_faturar_pc="<td colspan='2' style='text-align: center'></td>";
    }
    $currentPage= $_SERVER['SCRIPT_NAME'];


    $botoes="";
    if($row['assinado']==0){
        $cod_estado=0;
        $estado="<b style='font-size:20px;' class=''><i class='fa fa-play text-danger'></i> Em curso</b>";
        $botoes="
                <tr>
                    <td style='width: 100%'>
                        <a href='editar.php?id=".$row['id_assistencia_cliente']."' class='btn bg-info btn-block btn-xs'><i class='fa fa-edit'></i> Editar</a>
                    </td>
                </tr>";
    }elseif ($row['aprovado']==0){
        $cod_estado=1;
        $estado="<b style='font-size:20px;' class=''><i class='fa fa-clock-o text-warning'></i> Para aprovar</b>";
        $botoes="
                <tr>
                    <td style='width: 25%'>
                        <a class='btn bg-danger text-dark btn-block btn-xs' onclick='confirmaModal(\"reciclar.php?id=".$row['id_assistencia_cliente']."&from=$currentPage".urlencode($addUrl)."\")'><i class='fa fa-trash-o'></i> Eliminar</a>
                    </td>
                    <td style='width: 25%'>
                        <a href='editar.php?id=".$row['id_assistencia_cliente']."' class='btn bg-info text-dark btn-block btn-xs'><i class='fa fa-edit'></i> Editar</a>
                    </td>
                    <td style='width: 25%'>
                        <a class='btn btn-default btn-block btn-xs' onclick='confirmaModal(\"faturar.php?id=".$row['id_assistencia_cliente']."&force=1&from=$currentPage".urlencode($addUrl)."\")'><i class='fa fa-inbox'></i> Finalizar</a>
                    </td>
                    <td style='width: 25%'>
                        <a class='btn btn-success btn-block btn-xs' onclick='modal_para_faturar(\"".$row['id_assistencia_cliente']."\",\"".urlencode($addUrl)."\")'> Para faturar <i class='fa fa-angle-right'></i></a>
                    </td>
                </tr>";
    }elseif ($row['aprovado']==1 && $row['faturado']==0){
        $cod_estado=2;
        $estado="<b style='font-size:20px;' class=''><i class='fa fa-check text-info'></i> Para faturar</b>";
        $botoes="
                <tr>
                    <td style='width: 33.33%'>
                        <a class='btn btn-default btn-block btn-xs' onclick='confirmaModal(\"aprovar.php?id=".$row['id_assistencia_cliente']."&from=$currentPage".urlencode($addUrl)."\")'><i class='fa fa-angle-left'></i> Para Aprovar</a>
                    </td>
                    <td style='width: 33.33%'>
                        <a href='editar.php?id=".$row['id_assistencia_cliente']."' class='btn bg-info text-dark btn-block btn-xs'><i class='fa fa-edit'></i> Editar</a>
                    </td>
                    <td style='width: 33.33%'>
                        <a class='btn btn-success btn-block btn-xs' onclick='confirmaModal(\"faturar.php?id=".$row['id_assistencia_cliente']."&from=$currentPage".urlencode($addUrl)."\")'><i class='fa fa-inbox'></i> Finalizar/Faturar</a>
                    </td>
                </tr>";



    }elseif ($row['aprovado']==1 && $row['faturado']==1){
        $cod_estado=3;
        $estado="<b style='font-size:20px;' class=''><i class='fa fa-money text-success'></i> Finalizado/Faturado</b>";
        $botoes="
                <tr>
                    <td style='width: 50%'>
                        <a class='btn btn-default btn-block btn-xs' onclick='confirmaModal(\"faturar.php?id=".$row['id_assistencia_cliente']."&from=$currentPage".urlencode($addUrl)."\")'><i class='fa fa-angle-left'></i> Para Faturar</a>
                    </td>
                    <td style='width: 50%'>
                        <a href='editar.php?id=".$row['id_assistencia_cliente']."' class='btn bg-info text-dark btn-block btn-xs'><i class='fa fa-edit'></i> Editar</a>
                    </td>
                </tr>";
    }

    if($_SESSION['tecnico']==1){
        $botoes="";
    }else{
        $nome_cliente="<a href='../mod_srvcliente/detalhes.php?id=".$row['id_cliente']."'>".$row['nome_cliente']."</a>";
    }

    if(!is_numeric($row['preco_km']) || $row['preco_km']==""){
        $row['preco_km']=0;
    }

    $id=$row['id_assistencia_cliente'];
    $pdf="";
    if(is_dir('../_contents/assistencias_clientes_pdfs/'.$id)){
        $pdf = array_diff(scandir('../_contents/assistencias_clientes_pdfs/'.$id, 1), array('..', '.'));
    }

    if(file_exists('../_contents/assistencias_clientes_pdfs/'.$id.'/'.$pdf[0])){
        $row['dados']=str_replace('_nomepdf_',$pdf[0],$row['dados']);
    }

    $border_color="";
    $filhos_arr=getInfoTabela("assistencias_clientes"," and ativo=1 and id_pai='".$row['id_assistencia_cliente']."'");
    if(count($filhos_arr)>0){
        $border_color="border: 2px solid #8CC8FB !important;";
    }


    $hmtl="
    <div class='well well-sm $por_terminar_bg' style='margin-bottom:2px;$border_color'>
        <div class='hidden-lg'> <!-- para telemovel -->
            <table class='table table-bordered table-vcenter' style='background: transparent;margin-bottom: 0px'>
                    <tr>
                        <td colspan='2' class='text-center'>$estado<br>$data_aprovado</td>
                    </tr>
                    <tr>
                        <td colspan='2' class='text-center'><i class='fa fa-hashtag'></i> <b>".$row['nome_assistencia_cliente']."</b><br> <b>$nome_cliente</b></td>
                    </tr>
                    <tr>
                        <td style='width: 50%' class='text-center'>$tipo_assistencia</td>
                        <td style='width: 50%' class='text-center'>$nome_categoria</td>
                    </tr>
                    <tr>
                        <td style='width: 50%' class='text-center'>I: $data_inicio</td>
                        <td style='width: 50%' class='text-center'>F: $data_fim<br>$por_terminar</td>
                    </tr>
                    <tr>
                        <td class='text-center'><i class='fa fa-user'></i>$nome_tecnico<br>
                           <i class='fa fa-truck text-muted'></i> ".secondsToTime($row['tempo_viagem'])."<br>
                            <b class='text-success'>".round($row['kilometros']*$row['preco_km'],2)." €</b>  <small class='text-muted'>".($row['kilometros'])."km X ".$row['preco_km']."€</small><br>
                        </td>
                        <td class='text-center'>
                            <i class='fa fa-clock-o text-muted'></i> ".secondsToTime($row['tempo_assistencia']+$row['tempo_viagem']-$row['segundos_pausa'])."<br>
                            <i class='fa fa-money text-success'></i> ".secondsToTime($row['tempo_contabilizar'])."
                        </td>
                    </tr>
                    <tr>
                        <td class='text-center'>$email_enviado<br><a class=''  href='../_contents/assistencias_clientes_pdfs/".$row['id_assistencia_cliente']."/".$pdf[0]."'><i class='fa fa-download'></i> <small>Descarregar Relatório</small></a></td>
                        <td class='text-center'>$nome_contrato</td>
                    </tr>
                    
                    $obs_faturar_mobile
                    $descricao_mobile
                    $maquinas_mobile
                    
                    
                </table>
                <table class='table table-bordered table-vcenter' style='margin-bottom: 0px'>
                    $botoes
                </table>
        </div>
        
        <div class='hidden-xs'> <!-- para PC -->
            <table class='table table-bordered table-vcenter' style='background: transparent;margin-bottom: 0px'>
                    <tr>
                        <td colspan='2' class='text-center'>$estado<br>$data_aprovado</td>
                        <td  colspan='2' class='text-center'><i class='fa fa-hashtag'></i> <b>".$row['nome_assistencia_cliente']."</b><br> <b>$nome_cliente</b></td>
                    </tr>
                    <tr>
                        <td style='width: 25%' class='text-center'><i class='fa fa-clock-o text-muted'></i> $data_inicio - $data_fim<br>$por_terminar</td>
                        <td style='width: 25%' class='text-center'>$nome_contrato</td>
                        
                        <td style='width: 25%' class='text-center'>$tipo_assistencia</td>
                        <td style='width: 25%' class='text-center'>$nome_categoria</td>
                    </tr>
                    <tr>
                        <td style='width: 25%' class='text-center'>
                            <i class='fa fa-clock-o text-muted'></i> ".secondsToTime($row['tempo_assistencia']+$row['tempo_viagem']-$row['segundos_pausa'])."<br>
                            <i class='fa fa-money text-success'></i> ".secondsToTime($row['tempo_contabilizar'])."
                        </td>
                        <td style='width: 25%' class='text-center'>
                            <i class='fa fa-truck text-muted'></i> ".secondsToTime($row['tempo_viagem'])."<br>
                            <b class='text-success'>".round($row['kilometros']*$row['preco_km'],2)." €</b>  <small class='text-muted'>".($row['kilometros'])."km X ".$row['preco_km']."€</small><br>
                        </td>
                        <td style='width: 25%' class='text-center'><i class='fa fa-user'></i>$nome_tecnico</td>
                        <td style='width: 25%' class='text-center'>$email_enviado <br><a class=''  href='../_contents/assistencias_clientes_pdfs/".$row['id_assistencia_cliente']."/".$pdf[0]."'><i class='fa fa-download'></i> <small>Descarregar Relatório</small></a></td>
                    </tr>    
                    <tr>
                    $obs_faturar_pc
                    $descricao_pc
                    </tr>
                    $maquinas_pc
                </table>
                <table class='table table-bordered table-vcenter' style='margin-bottom: 0px'>
                    $botoes
                </table>
        </div>
    </div>
        ";


    return $hmtl;
}









$pageScript="";
include ('../_autoData.php');