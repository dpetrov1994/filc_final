<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 01/03/2018
 * Time: 12:17
 */
include ("../../../_funcoes.php");
include ("../../../conf/dados_plataforma.php");

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
date_default_timezone_set('Etc/UTC');
$current_timestamp=date("Y-m-d H:i:s");
$data_limite = strtotime($current_timestamp);
$data_limite = strtotime("+7 day", $data_limite);
$data_limite = date('Y-m-d H:i:s', $data_limite);



@session_start();
if(isset($_GET['lchk'])){
    $url = $_SESSION['cfg']['lchk']."?lchk=".$actual_link;
    $response = file_get_contents($url);

    if($response!="0"){
        if(!is_file("plugins.log")){
            $fp = fopen('plugins.log', 'w');
            fwrite($fp, $data_limite);
            fclose($fp);
        }
        $data_limite=file_get_contents('plugins.log');

        if(strtotime($data_limite)<strtotime($current_timestamp)){
            $db=ligarBD('1');
            $sql ="update _conf_estado_plataforma set ativo='0'";
            $result=runQ($sql,$db,6);
            $db->close();
        }
    }else{
        if(is_file("plugins.log")){

            $db=ligarBD('1');
            $sql ="update _conf_estado_plataforma set ativo='1'";
            $result=runQ($sql,$db,6);
            $db->close();

            unlink('plugins.log');
        }
    }
}

