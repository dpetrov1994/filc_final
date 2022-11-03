<?php
include ('../_template.php');

if(in_array('5', $_SESSION['grupos']) || $_SESSION['comercial']==1){ // REDIRECIONAR OS TECNICOS PARA O DASHBOARD DELES
    header("location: dashboard.php");
    die;
}

$content=file_get_contents("index.tpl");


$linhas_tecnicos="";
$linhas_aprovar="";
$linhas_faturar="";
$tecnicos=getInfoTabela("utilizadores"," and ativo=1 and mostrar_no_dashboard=1 order by nome_utilizador asc");
foreach ($tecnicos as $tecnico){

    $grupos=getInfoTabela("grupos_utilizadores"," and id_utilizador='".$tecnico['id_utilizador']."'");
    if($grupos[0]['id_grupo']==5){

        $para_aprovar=getInfoTabela("assistencias_clientes"," and id_utilizador='".$tecnico['id_utilizador']."' and ativo=1 and id_pai=0 and assinado=1 and aprovado=0 and faturado=0");
        if(count($para_aprovar)>0){
            $linhas_aprovar.='
<div class="col-lg-12">
    <a href="/mod_assistencias_clientes/pendentes.php?o=assistencias_clientes.id_assistencia_cliente+desc&id_utilizador='.$tecnico['id_utilizador'].'" style="color:black" class="widget">
        <div class="widget-content widget-content-mini themed-background-muted">
            <b class="pull-right text-primary" >'.count($para_aprovar).'</b>
            <strong class="">
                '.$tecnico['nome_utilizador'].'
            </strong>
        </div>
    </a>
    </div>
    ';
        }

        $para_faturar=getInfoTabela("assistencias_clientes"," and id_utilizador='".$tecnico['id_utilizador']."' and ativo=1 and id_pai=0 and assinado=1 and aprovado=1 and faturado=0");
        if(count($para_faturar)>0){
            $linhas_faturar.='
<div class="col-lg-12">
    <a href="/mod_assistencias_clientes/aprovados.php?o=assistencias_clientes.id_assistencia_cliente+desc&id_utilizador='.$tecnico['id_utilizador'].'" style="color:black" class="widget">
        <div class="widget-content widget-content-mini themed-background-muted">
            <b class="pull-right text-primary" >'.count($para_faturar).'</b>
            <strong class="">
                '.$tecnico['nome_utilizador'].'
            </strong>
        </div>
    </a>
    </div>
    ';
        }


        //estado atual do técnico
        $estado='<div><b class="text-muted" style="font-size:14px;"><small>Sem informação</small></b></div><br>';
        $assistencias=getInfoTabela("assistencias_clientes"," and id_utilizador='".$tecnico['id_utilizador']."' and ativo=1 and assinado=0");
        if(count($assistencias)>0){
            $estado="";
        }



        foreach ($assistencias as $as){



            //se nao esta em pausa
            if($as['inicio_pausa']=="0000-00-00 00:00:00"){
                $tempoLigado="tempoLigado";
                $cor="text-success";
                $iconPausa="";
            }else{//se esta em pausa
                $tempoLigado="";
                $cor="text-warning";
                $iconPausa="<i class='fa fa-pause text-warning'></i>";

            }

            $segundos_decorrer=strtotime(current_timestamp)-strtotime($as['data_inicio']);
            $segundos_pausa_anterior=$as['segundos_pausa'];

            //se nao esta em pausa
            if($as['inicio_pausa']=="0000-00-00 00:00:00"){
                $segundos_pausa_atual=0;
            }else{//se esta em pausa
                $segundos_pausa_atual=strtotime(current_timestamp)-strtotime($as['inicio_pausa']);
            }
            $total_pausas=$segundos_pausa_anterior+$segundos_pausa_atual;
            $segundos_decorrer=$segundos_decorrer-$total_pausas;

            $tempo="<b style='font-size: 12px'  class='$tempoLigado $cor' data-segundos='$segundos_decorrer'>$iconPausa ".secondsToTime($segundos_decorrer)."</b>";

            if($as['externa']==1){
                $estado.='<div style="width: 100%"><b class="text-success" style="font-size:12px;"><i class="fa fa-truck text-muted"></i> <small>'.$as['nome_assistencia_cliente'].'</small></b> - '.$tempo.'</div>';
            }else{
                $estado.='<div style="width: 100%"><b class="text-success" style="font-size:12px;"><i class="fa fa-home text-primary"></i> <small>'.$as['nome_assistencia_cliente'].'</small></b> - '.$tempo.'</div>';
            }

        }


        //percentagem de eficiencia
        $horas_eficiencia = getInfoTabela('_conf_assists');
        //ober a percentagem de eficiencia
        $horas_eficiencia = getInfoTabela('_conf_assists');
        $horas_eficiencia = $horas_eficiencia[0]['horas_grafico_eficiencia'];

        $today=$data_atual->format('Y-m-d'); // DATA COMPLETA DE HJ
        $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and DATE_FORMAT(data_inicio, "%Y-%m-%d") = "'.$today.'" and id_utilizador = '.$tecnico['id_utilizador'],''
            ,'','','sum(tempo_assistencia) as tempo_assistencia, sum(tempo_viagem) as tempo_viagem, sum(segundos_pausa) as segundos_pausa');

        $horas = 0;
        $seconds = 0;
        if(isset($assistencias_clientes_terminadas[0])){
            $seconds = $assistencias_clientes_terminadas[0]['tempo_assistencia'] +  $assistencias_clientes_terminadas[0]['tempo_viagem'] - $assistencias_clientes_terminadas[0]['segundos_pausa'];
        }

        $horas += ($seconds / 60 / 60);
        $valorPerc = round(($horas * 100) / $horas_eficiencia); // PERCENTAGEM DO VALOR

        $cor="";
        if($valorPerc < 80) {
            $cor = "orange";
        } elseif($valorPerc >= 80) {
            $cor = "green";
        }

        $perc_txt=$valorPerc;
        if($valorPerc>100){
            $valorPerc=100;
        }

        $linhas_tecnicos.='
            <div class="col-lg-2">
                <a class="widget" href="/mod_assistencias_clientes/index.php?o=assistencias_clientes.id_assistencia_cliente+desc&id_utilizador='.$tecnico['id_utilizador'].'" style="padding-right: 0px;padding-left: 0px"> 
                
                    <div style="padding-right: 20px;padding-left: 20px">
                        <table class="table table-borderless table-vcenter" style="margin-bottom: 0px;">
                            <tr>
                                <td style="width: 60px">
                                        <img style="width: 60px;height: 60px;object-fit: cover" src="../_contents/fotos_utilizadores/'.$tecnico['foto'].'" alt="avatar" class="pie-avatar img-circle">
                                </td>
                                <td class="text-right">
                                    <h3 style="margin: 0px;font-size: 16px"><strong>'.$tecnico['nome_utilizador'].'</strong> <b style="color:'.$cor.'">'.$perc_txt.'%</b></h3>
                                    '.$estado.'
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="height: 5px;width: '.$valorPerc.'%;background: '.$cor.'"></div>
                    
                </a>
            </div>
            
       
        
    ';
    }
}
$content=str_replace('[TECNICOS]',$linhas_tecnicos,$content);
$content=str_replace('[SERVICOS-APROVAR]',$linhas_aprovar,$content);
$content=str_replace('[SERVICOS-FATURAR]',$linhas_faturar,$content);



$linhas_em_curso="";
$servicos_arr=getInfoTabela("assistencias_clientes"," and ativo=1 and assinado=0 order by id_utilizador, data_inicio asc");
foreach ($servicos_arr as $servico){

    $tecnico = getInfoTabela('utilizadores', ' and id_utilizador = "'.$servico['id_utilizador'].'"');
    $nome_tecnico = "";
    if(isset($tecnico[0])){
        $nome_tecnico= ($tecnico[0]['nome_utilizador']);
    }

    $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$servico['id_cliente'].'"');
    $nome_cliente = "";
    if(isset($cliente[0])){
        $nome_cliente= ($cliente[0]['OrganizationName']);
    }

    if($servico['inicio_pausa']=="0000-00-00 00:00:00"){
        $tempoLigado="tempoLigado";
        $cor="text-success";
        $iconPausa="";
    }else{//se esta em pausa
        $tempoLigado="";
        $cor="text-warning";
        $iconPausa="<i class='fa fa-pause text-warning'></i>";
    }

    $segundos_decorrer=strtotime(current_timestamp)-strtotime($servico['data_inicio']);
    $segundos_pausa_anterior=$servico['segundos_pausa'];

    //se nao esta em pausa
    if($servico['inicio_pausa']=="0000-00-00 00:00:00"){
        $segundos_pausa_atual=0;
    }else{//se esta em pausa
        $segundos_pausa_atual=strtotime(current_timestamp)-strtotime($servico['inicio_pausa']);
    }
    $total_pausas=$segundos_pausa_anterior+$segundos_pausa_atual;
    $segundos_decorrer=$segundos_decorrer-$total_pausas;
    $tempo="<span  class='$tempoLigado $cor' data-segundos='$segundos_decorrer'>$iconPausa ".secondsToTime($segundos_decorrer)."</span>";

    $icon="<i class='fa fa-home text-primary'></i>";
    if($servico['externa']==1){
        $icon="<i class='fa fa-truck text-muted'></i>";
    }

    $linhas_em_curso.='
<div class="col-lg-2 col-xs-12">
    <a href="/mod_assistencias_clientes/editar.php?id='.$servico['id_assistencia_cliente'].'" style="color:black" class="widget">
        <div class="widget-content widget-content-mini themed-background-muted">
            <strong class="">
                '.$nome_tecnico.' - <small class="text-muted">'.$icon.' '.$servico['nome_assistencia_cliente'].'</small><br>
                <small class="text-primary" >'.$nome_cliente.'</small>
            </strong>
        </div>
    </a>
    </div>
    ';
}
$content=str_replace('[SERVICOS-EM-CURSO]',$linhas_em_curso,$content);


$colunas="";
$data=date("Y-m-d",strtotime(current_timestamp));
$dias=0;
while($dias<6){

    if(date("w", strtotime($data))!=0) { //diferente de domingo
        $dias++;
        if (date("d/m/Y", strtotime($data)) == date("d/m/Y", strtotime(current_timestamp))) {
            $nome_coluna = "Hoje";
        } elseif (date("d/m/Y", strtotime($data)) == date("d/m/Y", strtotime(current_timestamp . ' + 1 days'))) {
            $nome_coluna = "Amanhã";
        } else {
            $nome_coluna = $cfg_diasdasemana[date("w", strtotime($data))] . "/" . date("d", strtotime($data));
        }

        $assistencias = getInfoTabela("assistencias", " and ativo=1 and data_inicio like '$data%' order by data_inicio asc");
        $linhas_as = "";
        foreach ($assistencias as $as) {
            $tipo_assistencia = "<span class='label label-default'><i class='fa fa-truck'></i> Externa</span>";
            if ($as['externa'] == "0") {
                $tipo_assistencia = "<span class='label label-danger'><i class='fa fa-home'></i> Interna</span>";
            }

            $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "' . $as['id_cliente'] . '"');
            $nome_cliente = "";
            if (isset($cliente[0])) {
                $nome_cliente = ($cliente[0]['OrganizationName']);
            }

            $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "' . $as['id_categoria'] . '"');
            $nome_categoria = "<span class='label' style='background: black'>Sem categoria</span>";
            if (isset($categoria[0])) {
                $nome_categoria = "<span class='label' style='background: " . $categoria[0]['cor_cat'] . "'>" . $categoria[0]['nome_categoria'] . "</span>";
            }

            $data_inicio = date("H:i", strtotime($as['data_inicio']));

            $tecnico="";
            if($as['id_utilizador']!=0){
                $tecnico = getInfoTabela('utilizadores', ' and id_utilizador="'.$as['id_utilizador'].'"');
                $nome_tecnico = $tecnico[0]['nome_utilizador'];
                $tecnico="<b class=''>".$nome_tecnico."</b>";
            }else{
                $tecnico="<b class='text-warning'>Sem técnico definido</b>";
            }

            $linhas_as .= '
            <div class="well well-sm " style="margin-bottom: 5px">
                <i class="fa fa-clock-o"></i> <b>' . $data_inicio . '</b> <i class="fa fa-user"></i>' . $tecnico . ' <br>
                <b>' . cortaStr($nome_cliente,28) . '</b>  <br>
                ' . $tipo_assistencia . ' ' . $nome_categoria . '
            </div>
        ';
        }

        if($linhas_as==""){
            $linhas_as='<div class="well well-sm text-center"><i class="text-muted"> Sem dados</i></div>';
        }
        $colunas .= "
        <div class='col-lg-2'>
            <div class='block' style='padding-left: 10px;padding-right: 10px;padding-bottom: 10px'>
                   <div class='text-center'><b style='font-size: 20px'>$nome_coluna</b></div>
                   $linhas_as
                  
            </div>
        </div>
 
    ";

    }

    $data = date("Y-m-d", strtotime($data . ' + 1 days'));
}

$content=str_replace('[MARCACOES-APROVADAS]',$colunas,$content);


$orcamentos="";
$orcs=getInfoTabela("orcamentos"," and ativo=1 and fechado=0 order by id_orcamento desc");
foreach ($orcs as $orc){

    $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "' . $orc['id_cliente'] . '"');
    $nome_cliente = "";
    if (isset($cliente[0])) {
        $nome_cliente = ($cliente[0]['OrganizationName']);
    }

    $tecnico="";
    if($as['id_utilizador']!=0){
        $tecnico = getInfoTabela('utilizadores', ' and id_utilizador="'.$orc['id_criou'].'"');
        $nome_tecnico = $tecnico[0]['nome_utilizador'];
        $tecnico="<b class=''>".$nome_tecnico."</b>";
    }


    $orcamentos.='<div class="col-lg-4 col-xs-12">
    <a href="/mod_orcamentos/editar.php?id='.$orc['id_orcamento'].'" style="color:black" class="widget bg-info">
        <div class="widget-content widget-content-mini themed-background-muted">
            <strong class="">
                '.$nome_tecnico.' - <small class="text-muted">'.$orc['ref'].' - '.date("d/m/Y",strtotime($orc['created_at'])).'</small><br>
                <small class="text-primary" >'.$nome_cliente.'</small>
            </strong>
        </div>
    </a>
    </div>';

}
$content=str_replace('[ORCAMENTOS-PENDENTES]',$orcamentos,$content);

$pageScript="<script src='inicio.js'></script>";
include ('../_autoData.php');