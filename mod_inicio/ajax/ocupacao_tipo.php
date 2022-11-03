<?php
include ("../../_funcoes.php");
include ("../../conf/dados_plataforma.php");
include ("../../login/valida.php");

$db=ligarBD("mysql");

$result="";
if(isset($_GET['inicio']) && isset($_GET['fim'])){

    $inicio=data_portuguesa($_GET['inicio']);
    $fim=data_portuguesa($_GET['fim']);

    $linhas="";

    $users=getInfoTabela("utilizadores", "and ativo=1 and mostrar_no_dashboard=1");


    $header="";
    $first=0;


    $externas=[
        [
            'externa'=>0,
            'nome_externa'=>"Interna"
        ],
        [
            'externa'=>1,
            'nome_externa'=>"Externa"
        ],
    ];

    $total_tecnico=[];
    foreach ($users as $user){
        $total=0;
        $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and id_utilizador = '.$user['id_utilizador'].' and (data_inicio >= "'.$inicio.' 00:00:00" and data_inicio <= "'.$fim.' 23:59:59")');
        foreach ($assistencias_clientes_terminadas as $as){
            $total += $as['tempo_assistencia'] + $as['tempo_viagem'] - $as['segundos_pausa'];
        }
        $total_tecnico[$user['id_utilizador']]=$total;
    }

    foreach ($externas as $externa){
        $cols="<td>".$externa['nome_externa']."</td>";
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




            $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and externa="'.$externa['externa'].'" and id_utilizador = '.$user['id_utilizador'].' and (data_inicio >= "'.$inicio.' 00:00:00" and data_inicio <= "'.$fim.' 23:59:59")');
            $horas = 0;
            $seconds = 0;
            foreach ($assistencias_clientes_terminadas as $as){
                $seconds += $as['tempo_assistencia'] + $as['tempo_viagem'] - $as['segundos_pausa'];
            }
            $valorPerc=0;
            if($seconds>0){
                $valorPerc=$seconds*100/$total_tecnico[$user['id_utilizador']];
            }
            $valorPerc=round($valorPerc);

            $progressBar = '<div class="bars-container" style="margin-left: 5px;margin-right:5px ">
                        <div class="progress" style="margin-bottom: 0px!important;">
                            <div class="progress-bar progress-bar-info" role="progressbar" 
                            aria-valuenow="' . $valorPerc . '%" aria-valuemin="0" aria-valuemax="100" 
                            style="width:' . $valorPerc . '%;">&nbsp;' . $valorPerc . '% </div>
                        </div>
                  </div>';
            $cols.="<td>$progressBar</td>";

            if($first==0){
                $header.="<td style='width: 80px;text-align: center'><img  src='../../_contents/fotos_utilizadores/".$user['foto']."' style='background: ".$user['cor'].";width: 100%;height: auto' class='img-circle img-thumbnail img-thumbnail-avatar'><br>".$user['nome_utilizador']."</td>";
            }
        }
        $first++;

        $linhas.="<tr>$cols</tr>";


    }




    if($linhas!=""){
        $result="
        <table class='table table-bordered table-vcenter table-striped'>
        <thead><tr><th style='width: 50px'>Tipo</th>$header</tr></thead>
        <tbody>
        $linhas
</tbody>
        
        </table>
        ";
    }

}


print $result;


$db->close();