<?php
include ("../../_funcoes.php");
include ("../../conf/dados_plataforma.php");
include ("../../login/valida.php");

$db=ligarBD("mysql");

$result="";
if(isset($_GET['inicio']) && isset($_GET['fim'])){

    $inicio=data_portuguesa($_GET['inicio']);
    $fim=data_portuguesa($_GET['fim']);

    $diff=strtotime($fim)-strtotime($inicio);
    $dias=$diff/60/60/24;
    $dias++;

    $horas_eficiencia = getInfoTabela('_conf_assists');
    $horas_eficiencia = $horas_eficiencia[0]['horas_grafico_eficiencia']*$dias;

    $td="";
    $tr="";

    $users=getInfoTabela("utilizadores", "and ativo=1 and mostrar_no_dashboard=1");
    foreach ($users as $user){

        $sql = "select grupos_utilizadores.id_grupo from grupos_utilizadores inner join grupos on grupos.id_grupo=grupos_utilizadores.id_grupo where id_utilizador=".$user['id_utilizador']." and grupos.ativo=1";
        $result = runQ($sql, $db, 4);
        $grupos = [];
        $c = 0;
        $tecnico=0;
        while ($row = $result->fetch_assoc()) {
            $grupos[$c] = $row['id_grupo'];
            if($row['id_grupo']==5){
                $tecnico=1;
            }
            $c++;
        }
        if($tecnico!=1){
            continue;
        }

        $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and (data_inicio>="'.$inicio.' 00:00:00" and data_inicio<="'.$fim.' 23:59:59") and id_utilizador = '.$user['id_utilizador']);

        $horas = 0;
        $seconds = 0;
        foreach ($assistencias_clientes_terminadas as $as){
           if(date("w", strtotime($as['data_inicio']))!=0 && date("w", strtotime($as['data_inicio']))!=7 && $as['tempo_assistencia']!=0) { //diferente de domingo e sabado
               $seconds += $as['tempo_assistencia'] + $as['tempo_viagem'] - $as['segundos_pausa'];
           }
        }

        $horas += ($seconds / 60 / 60);
        $valorPerc = round(($horas * 100) / $horas_eficiencia); // PERCENTAGEM DO VALOR


        $class = "";
        if($valorPerc < 80) {
            $class = "progress-bar-danger";
        } elseif($valorPerc >= 80) {
            $class = "progress-bar-success";
        }

        $valorPercTemp = $valorPerc;
        if($valorPerc > 100) {
            $valorPerc = 100;
        }

        if($valorPerc <= 0 || $valorPerc == "nan" || is_nan($valorPerc)){
            $valorPerc = 0;
        }

        if($horas <= 0 || $horas == "nan" || is_nan($horas)){
            $horas = 0;
        }

// FAZER CONTA PARA PERCENTAGEM
        $progressBar = ' <div class="bars-container" style="margin-left: 5px;margin-right:5px ">
                        <div class="progress" style="margin-bottom: 0px!important;">
                            <div class="progress-bar ' . $class . '" role="progressbar" 
                            aria-valuenow="' . $valorPerc . '%" aria-valuemin="0" aria-valuemax="100" 
                            style="width:' . $valorPerc . '%;">&nbsp;' . $valorPercTemp . '% </div>
                        </div>
                        '.$user['nome_utilizador'].'
                  </div>';


        $td.="
  
        <td style='text-align: center'><img data-toggle='tooltip' title='".$user['nome_utilizador']."'  src='../../_contents/fotos_utilizadores/".$user['foto']."' style='background: ".$user['cor']."' class='img-circle img-thumbnail img-thumbnail-avatar'></td>

        ";
        $tr.="
       
        <td>$progressBar</td>

        ";

    }

    if($td!=""){
        $result="
        <table class='table table-borderless table-vcenter table-striped'>
        <tr>$td</tr>
        <tr>$tr</tr>
</table>
        ";
    }

}


print $result;


$db->close();