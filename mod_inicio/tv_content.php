<?php

include "../_funcoes.php";
include "../conf/dados_plataforma.php";

$db=ligarBD();
$content=file_get_contents("../mod_inicio/tv_content.tpl");

$linhas_tecnicos="";

$tecnicos=getInfoTabela("utilizadores"," and ativo=1 and mostrar_no_dashboard=1 order by nome_utilizador asc");
foreach ($tecnicos as $tecnico){

    $grupos=getInfoTabela("grupos_utilizadores"," and id_utilizador='".$tecnico['id_utilizador']."'");
    if($grupos[0]['id_grupo']==5){


        //estado atual do técnico
        $estado='<div><b class="text-muted" style="font-size:20px;"><small>Sem informação</small></b></div><br>';
        $assistencias=getInfoTabela("assistencias_clientes"," and id_utilizador='".$tecnico['id_utilizador']."' and ativo=1 and assinado=0");
        if(count($assistencias)>0){
            $estado="";
        }



        foreach ($assistencias as $as){

            $segundos_decorrer=strtotime(current_timestamp)-strtotime($as['data_inicio']);

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
                <div class="block" style="padding-right: 0px;padding-left: 0px"> 
                
                    <div style="padding-right: 20px;padding-left: 20px">
                        <table class="table table-borderless table-vcenter" style="margin-bottom: 0px;">
                            <tr>
                                <td style="width: 80px">
                                        <img style="width: 80px;height: 80px;object-fit: cover" src="../_contents/fotos_utilizadores/'.$tecnico['foto'].'" alt="avatar" class="pie-avatar img-circle">
                                </td>
                                <td class="text-right">
                                    <h3 style="margin: 0px;font-size: 20px"><strong>'.$tecnico['nome_utilizador'].'</strong> <b style="color:'.$cor.'">'.$perc_txt.'%</b></h3>
                                    '.$estado.'
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="height: 5px;width: '.$valorPerc.'%;background: '.$cor.'"></div>
                    
                </div>
            </div>
            
       
        
    ';
    }
}
$content=str_replace('[TECNICOS]',$linhas_tecnicos,$content);


$pendentes="";
$assistencias=getInfoTabela("assistencias"," and ativo=1 and  (id_utilizador=0 or data_inicio='0000-00-00 00:00:00') order by data_inicio asc");
foreach ($assistencias as $as){



    $tipo_assistencia = "<small class='label label-default'><i class='fa fa-truck'></i> Externa</small>";
    if($as['externa'] == "0"){
        $tipo_assistencia = "<small class='label label-danger'><i class='fa fa-home'></i> Interna</small>";
    }

    $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$as['id_cliente'].'"');
    $nome_cliente = "";
    if(isset($cliente[0])){
        $nome_cliente= ($cliente[0]['OrganizationName']);
    }

    $categoria = getInfoTabela('assistencias_categorias', ' and id_categoria = "'.$as['id_categoria'].'"');
    $nome_categoria="<small class='label' style='background: black'>Sem categoria</small>";
    if(isset($categoria[0])){
        $nome_categoria="<small class='label' style='background: ".$categoria[0]['cor_cat']."'>".$categoria[0]['nome_categoria']."</small>";
    }



    $data_inicio="";

    if($as['data_inicio']!="0000-00-00 00:00:00"){
        if(date("d/m/Y", strtotime($as['data_inicio']))==date("d/m/Y", strtotime(current_timestamp))){
            $data_inicio = "Hoje às ".date("H:i", strtotime($as['data_inicio']));
        }elseif(date("d/m/Y", strtotime($as['data_inicio']))==date("d/m/Y", strtotime(current_timestamp. ' + 1 days'))){
            $data_inicio = "Amanhã às ".date("H:i", strtotime($as['data_inicio']));
        }else{
            $data_inicio = $cfg_diasdasemana[date("w", strtotime($as['data_inicio']))]."/".date("d, H:i", strtotime($as['data_inicio']));
        }
    }
    $datas="";
    if($data_inicio!=""){
        $data_inicio="<b class=''>".$data_inicio."</b>";
    }else{
        $data_inicio="<b class='text-warning'>Sem data</b>";
    }

    $tecnico="";
    if($as['id_utilizador']!=0){
        $tecnico = getInfoTabela('utilizadores', ' and id_utilizador="'.$as['id_utilizador'].'"');
        $nome_tecnico = $tecnico[0]['nome_utilizador'];
        $tecnico="<b class=''>".$nome_tecnico."</b>";
    }else{
        $tecnico="<b class='text-warning'>Sem técnico</b>";
    }

    $pendentes.='
    <div class="col-lg-2">
    <div class="block" style="padding-bottom: 10px">
        <i class="fa fa-calendar"></i> '.$data_inicio.' <i class="fa fa-user"></i>'.$tecnico.' <br>
        <b >'.cortaStr($nome_cliente,28).'</b>  <br>
        '.$tipo_assistencia.' '.$nome_categoria.'
</div>
</div> 
            ';

}

$content=str_replace('[MARCACOES-PENDENTES]',$pendentes,$content);

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

$db->close();
print $content;
