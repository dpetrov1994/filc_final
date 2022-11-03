
<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

if(isset($_GET['data'])){
    $db=ligarBD("ajax");

    $data=$db->escape_string($_GET['data']);
    $sql="delete from _conf_assists_datas_bloqueadas where data = '$data'";
    $result=runQ($sql,$db,"delete data");

    $db->close();
}