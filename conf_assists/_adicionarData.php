<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

if(isset($_GET['data'])){
    $db=ligarBD("ajax");

    $data=$db->escape_string($_GET['data']);
    $sql="insert into _conf_assists_datas_bloqueadas (data) VALUES ('$data')";
    $result=runQ($sql,$db,"insert data");

    $db->close();
}
