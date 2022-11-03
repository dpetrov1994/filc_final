<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");

$db=ligarBD("ajax");

$hoje=date('Y-m-d', strtotime(current_timestamp));

$sql="select * from assistencias where data_inicio like '$hoje%' and ativo=1";
print $sql;
$result=runQ($sql,$db,"select lembretes");
while ($row = $result->fetch_assoc()) {

    print_r($row);

    $destinatarios=[$row['id_utilizador']];

    $id_cliente="";
    $nome_cliente="";
    $sql2="select * from srv_clientes where id_cliente='".$row['id_cliente']."'";
    $result2=runQ($sql2,$db,"select todos admins");
    while ($row2 = $result2->fetch_assoc()) {
        $id_cliente=$row2['PartyID'];
        $nome_cliente=$row2['OrganizationName'];
    }

    $data_inicio = $cfg_diasdasemana[date("w", strtotime($row['data_inicio']))]."/".date("d, H:i", strtotime($row['data_inicio']));
    $nome_notificacao="$data_inicio ".$nome_cliente;

    notificar($db,"$nome_notificacao","assistencias","assistencia",$row['id_assistencia'],"/mod_assistencias/detalhes.php?id=".$row['id_assistencia'],$destinatarios);
}

$db->close();

