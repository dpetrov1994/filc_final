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

    $categorias = getInfoTabela('assistencias_categorias', ' and ativo=1 and comercial=0');
    $categorias[]=[
        'id_categoria'=>0,
        'nome_categoria'=>"Sem categoria"
    ];


    foreach ($categorias as $categoria){
        $cols="<td>".$categoria['nome_categoria']."</td>";
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

            $assistencias_clientes_terminadas = getInfoTabela('assistencias_clientes', ' and ativo=1 and assinado = 1 and id_categoria="'.$categoria['id_categoria'].'" and id_utilizador = '.$user['id_utilizador'].' and (data_inicio >= "'.$inicio.' 00:00:00" and data_inicio <= "'.$fim.' 23:59:59")');
            $horas = 0;
            $seconds = 0;
            foreach ($assistencias_clientes_terminadas as $as){
                $seconds += $as['tempo_assistencia'] + $as['tempo_viagem'] - $as['segundos_pausa'];
            }
            $total_cat+=$seconds;
            $tempo=secondsToTime($seconds);
            if($seconds==0){
                $tempo="";
            }
            $tempo='<a target="_blank" href="../mod_assistencias_clientes/index.php?id_utilizador='.$user['id_utilizador'].'&id_categoria='.$categoria['id_categoria'].'&data_inicio='.urlencode(date("d/m/Y",strtotime($inicio))).'&data_fim='.urlencode(date("d/m/Y",strtotime($fim))).'">'.$tempo.'</a>';
            $cols.="<td><b>$tempo</b></td>";

            if($first==0){
                $header.="<th style='width: 80px;text-align: center'><img  src='../../_contents/fotos_utilizadores/".$user['foto']."' style='background: ".$user['cor'].";width: 100%;height: auto' class='img-circle img-thumbnail img-thumbnail-avatar'><br>".$user['nome_utilizador']."</th>";
            }
        }
        $first++;

        $cols.="<td><b>".secondsToTime($total_cat)."</b></td>";



        $linhas.="<tr>$cols</tr>";


    }

    $total_geral=0;
    $total_tecnico=[];
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
        $totais.="<td><b>".secondsToTime($total)."<b></td>";
    }
    $totais.="<td><b>".secondsToTime($total_geral)."<b></td>";

    if($linhas!=""){
        $result="
        <table class='table table-bordered table-vcenter table-striped'>
        <thead><tr><th style='width: 50px'>Categoria</th>$header<th style='width: 50px'>Total</th></tr></thead>
        <tbody>
        $linhas
        <tr>$totais</tr>
</tbody>
        
        </table>
        ";
    }

}


print $result;


$db->close();