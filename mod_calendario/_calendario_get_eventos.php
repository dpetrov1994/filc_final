<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");
$db=ligarBD("ajax");
$events = array();
$start=$_GET['start']." 00:00:00";
$end=$_GET['end']." 23:59:00";
$add_sql="";

if($_SESSION['tecnico']==1){
    $add_sql=" and id_utilizador='".$_SESSION['id_utilizador']."'";
}

$add_sql2="";
$add_sql3="";


/**
 * GET agendas
 */

// TECNICOS VE AS DELES

$sql = "
select *
from assistencias 
where assistencias.ativo=1 and (data_inicio BETWEEN '$start' AND '$end') $add_sql";
$result = runQ($sql, $db, "agendas");
while ($row = $result->fetch_assoc()) {
    $e = array();
    $e['id'] = $row['id_assistencia'];
    $e['tipo'] = "marcacao";

    $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$row['id_cliente'].'"');
    $nome_cliente = "";
    if(isset($cliente[0])){
        $nome_cliente=($cliente[0]['OrganizationName']);
    }

    $e['title'] = "$nome_cliente";
    $e['start'] = $row['data_inicio'];
    $e['end'] = $row['data_inicio'];

    $e['color']="#3EA4FC";
    if($_SESSION['tecnico']==0) {
        $sql2 = "select * from utilizadores where id_utilizador='" . $row['id_utilizador'] . "'";
        $result2 = runQ($sql2, $db, "utilizadores");
        while ($row2 = $result2->fetch_assoc()) {
            $e['color'] = $row2['cor'];
        }
    }


    //$e['url'] = "../mod_testes/detalhes.php?id=".$row['id_teste'];
    $e['allDay'] = false;
    array_push($events, $e);
}

$sql = "
select *
from assistencias_clientes
where ativo=1 and (data_inicio BETWEEN '$start' AND '$end') $add_sql";
$result = runQ($sql, $db, "agendas");
while ($row = $result->fetch_assoc()) {
    $e = array();
    $e['id'] = $row['id_assistencia_cliente'];
    $e['tipo'] = "assistencia_cliente";

    $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$row['id_cliente'].'"');
    $nome_cliente = "";
    if(isset($cliente[0])){
        $nome_cliente=cortaStr($cliente[0]['OrganizationName'],20);
    }

    $e['title'] = $row['nome_assistencia_cliente']."\r\n$nome_cliente";
    $e['start'] = $row['data_inicio'];
    $e['end'] = $row['data_fim'];



    if($_SESSION['tecnico']==0) {
        $sql2 = "select * from utilizadores where id_utilizador='" . $row['id_utilizador'] . "'";
        $result2 = runQ($sql2, $db, "utilizadores");
        while ($row2 = $result2->fetch_assoc()) {
            $e['color'] = $row2['cor'];
        }
    }


    //$e['url'] = "../mod_testes/detalhes.php?id=".$row['id_teste'];
    $e['allDay'] = false;
    array_push($events, $e);
}



/**
 * FIM GET agendas
 */

/*


$tabelas=[
  "juntas"=>"junta",
  "cabos"=>"cabo",
  "ensaios"=>"ensaio",
  "wos"=>"wo",
];
foreach ($tabelas as $tabela=>$coluna){
    $sql = "
select *
from $tabela
inner join utilizadores on utilizadores.id_utilizador=$tabela.id_equipa
where (data_inicio BETWEEN '$start' AND '$end') $add_sql3";
    $result = runQ($sql, $db, "tarefas");
    while ($row = $result->fetch_assoc()) {
        $e = array();
        $e['id'] = $row['id_'.$coluna];
        $e['tipo'] = $tabela;
        $e['title'] = "[E".$row["numero_equipa"]."][".strtoupper($tabela)."] ".$row["elemento"]." - ".$row["numero"];
        $e['start'] = $row['data_inicio'];
        $e['end'] = $row['data_fim'];
        $e['color'] = $row['cor_agenda'];
        //$e['url'] = "../mod_testes/detalhes.php?id=".$row['id_teste'];
        $e['allDay'] = false;
        array_push($events, $e);
    }
}


$events=super_unique($events,"id");

 */


echo json_encode($events);
$db->close();
