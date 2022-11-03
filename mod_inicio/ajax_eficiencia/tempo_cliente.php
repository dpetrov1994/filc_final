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

    $clientes=[];
    $sql = "select distinct(id_cliente) from assistencias_clientes where 1 and ativo=1 and assinado = 1  and (data_inicio >= '".$inicio." 00:00:00' and data_inicio <= '".$fim." 23:59:59')";
    $result = runQ($sql, $db, 4);
    while ($row = $result->fetch_assoc()) {
        $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$row['id_cliente'].'"');
        $nome_cliente = "";
        if(isset($cliente[0])){
            $nome_cliente= ($cliente[0]['OrganizationName']);
        }
        $clientes[]=[
            'id_cliente'=>$row['id_cliente'],
            'OrganizationName'=>$nome_cliente,
        ];
    }


    foreach ($clientes as $cliente){
        $cols="<td style='width: 300px'>".$cliente['OrganizationName']."</td>";
        $total_cat=0;
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

            $soma_cats=0;

            $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and id_cliente="'.$cliente['id_cliente'].'" and id_utilizador = '.$user['id_utilizador'].' and (data_inicio >= "'.$inicio.' 00:00:00" and data_inicio <= "'.$fim.' 23:59:59")');
            $horas = 0;
            $seconds = 0;
            foreach ($assistencias_clientes_terminadas as $as){
                $seconds += $as['tempo_assistencia'] + $as['tempo_viagem'] - $as['segundos_pausa'];
            }
            $total_cat+=$seconds;
            $tempo=secondsToTime($seconds,false);
            if($seconds==0){
                $tempo="";
            }
            $tempo='<a target="_blank" href="../mod_assistencias_clientes/index.php?id_utilizador='.$user['id_utilizador'].'&id_cliente='.$cliente['id_cliente'].'&data_inicio='.urlencode(date("d/m/Y",strtotime($inicio))).'&data_fim='.urlencode(date("d/m/Y",strtotime($fim))).'">'.$tempo.'</a>';
            $cols.="<td style='text-align: right'><b>$tempo</b></td>";

            if($first==0){
                $header.="<th style='width: 80px;text-align: center'><img  src='../../_contents/fotos_utilizadores/".$user['foto']."' style='background: ".$user['cor'].";width: 100%;height: auto' class='img-circle img-thumbnail img-thumbnail-avatar'><br>".$user['nome_utilizador']."</th>";
            }
        }
        $first++;

        $cols.="<td style='text-align: right'><b>".secondsToTime($total_cat,false)."</b></td>";



        $linhas.="<tr>$cols</tr>";


    }

    $total_tecnico=[];
    $total_geral=0;
    $totais="<td>Total</td>";
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

        $total=0;
        $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and id_utilizador = '.$user['id_utilizador'].' and (data_inicio >= "'.$inicio.' 00:00:00" and data_inicio <= "'.$fim.' 23:59:59")');
        foreach ($assistencias_clientes_terminadas as $as){
            $total += $as['tempo_assistencia'] + $as['tempo_viagem'] - $as['segundos_pausa'];
        }
        $total_geral+=$total;
        $totais.="<td style='text-align: right'><b>".secondsToTime($total,false)."<b></td>";
    }
    $totais.="<td style='text-align: right'><b>".secondsToTime($total_geral,false)."<b></td>";

    if($linhas!=""){
        $result="
<div class='table-responsive'>
        <table class='table table-bordered table-vcenter table-striped'>
        <thead><tr><th>Cliente</th>$header<th style='width: 80px'>Total</th></tr></thead>
        <tbody>
        $linhas
        <tr>$totais</tr>
</tbody>
        
        </table>
        </div>
        ";
    }

}


print $result;


$db->close();