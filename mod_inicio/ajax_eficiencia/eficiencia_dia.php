<?php
include ("../../_funcoes.php");
include ("../../conf/dados_plataforma.php");
include ("../../login/valida.php");

$db=ligarBD("mysql");

$result="";
if(isset($_GET['inicio']) && isset($_GET['fim'])){

    $inicio=data_portuguesa($_GET['inicio']);
    $fim=data_portuguesa($_GET['fim']);

    $horas_eficiencia = getInfoTabela('_conf_assists');
    $horas_eficiencia = $horas_eficiencia[0]['horas_grafico_eficiencia'];

    $linhas="";

    $users=getInfoTabela("utilizadores", "and ativo=1 and mostrar_no_dashboard=1");


    $header="";
    $first=0;

    $data=$inicio;
    while(strtotime($data)<=strtotime($fim)){
        $cols="<td>".date("d/m/Y",strtotime($data))."</td>";
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

            $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and (data_inicio like "'.$data.'%") and id_utilizador = '.$user['id_utilizador']);
            $horas = 0;
            $seconds = 0;
            foreach ($assistencias_clientes_terminadas as $as){
                $seconds += $as['tempo_assistencia'] + $as['tempo_viagem'] - $as['segundos_pausa'];
            }

            $horas += ($seconds / 60 / 60);
            $valorPerc = round(($horas * 100) / $horas_eficiencia); // PERCENTAGEM DO VALOR

            $class = "";
            if($valorPerc < 80) {
                $class = "progress-bar-danger";
            } elseif($valorPerc >= 80) {
                $class = "progress-bar-success";
            }

            if($valorPerc > 100) {
                $class = "progress-bar-warning";
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

            $progressBar = '<a target="_blank" href="../mod_assistencias_clientes/index.php?id_utilizador='.$user['id_utilizador'].'&data_inicio='.urlencode(date("d/m/Y",strtotime($data))).'&data_fim='.urlencode(date("d/m/Y",strtotime($data))).'"><div class="bars-container" style="margin-left: 5px;margin-right:5px ">
                        <div class="progress" style="margin-bottom: 0px!important;">
                            <div class="progress-bar ' . $class . '" role="progressbar" 
                            aria-valuenow="' . $valorPerc . '%" aria-valuemin="0" aria-valuemax="100" 
                            style="width:' . $valorPerc . '%;">&nbsp;' . $valorPercTemp . '% </div>
                        </div>
                  </div></a>';

            if($valorPerc==0){
                $progressBar="";
            }
            $cols.="<td>$progressBar</td>";

            if($first==0){
                $header.="
                <th style='width: 80px;text-align: center'><img  src='../../_contents/fotos_utilizadores/".$user['foto']."' style='background: ".$user['cor'].";width: 100%;height: auto' class='img-circle img-thumbnail img-thumbnail-avatar'><br>".$user['nome_utilizador']."</th>
            ";
            }
        }
        $first++;


        $linhas.="<tr>$cols</tr>";

        $data=date('Y-m-d', strtotime($data. ' + 1 days'));
    }



    if($linhas!=""){
        $result="
<div class='table-responsive'>
        <table class='table table-bordered table-vcenter table-striped'>
        <thead><tr><td style='width: 50px'>Data</td>$header</tr></thead>
        <tbody>
        $linhas
</tbody>
        
        </table>
        </div>
        ";
    }

}


print $result;


$db->close();