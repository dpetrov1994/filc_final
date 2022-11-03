<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 01/03/2018
 * Time: 12:17
 */
include ("_funcoes.php");
include ("conf/dados_plataforma.php");
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
date_default_timezone_set('Etc/UTC');
$current_timestamp=date("Y-m-d H:i:s");$db=ligarBD("_*.php");
@session_start();
/**
 * limpar a pasta temporária
 */
$storeFolder = ".tmp/".$_SESSION['id_utilizador']."/";
$ficheiros=mostraFicheiros($storeFolder);
if(is_array($ficheiros)){
    foreach ($ficheiros as $ficheiro){
        unlink("$storeFolder/$ficheiro");
    }
}/**
 * Atualizar data para dizer que o utilizador está online
 */
$ip=$_SERVER['REMOTE_ADDR'];
$sql="update  utilizadores set last_seen='".current_timestamp."',ip_acesso='$ip' where id_utilizador=".$_SESSION['id_utilizador'];
$result=runQ($sql,$db,6);
/**
 * METER NOTIFICACAO COMO VISTA
 */
if(isset($_GET['url'])){
    $url=$db->escape_string($_GET['url']);
    $sql="select id_notificacao from notificacoes where url='$url'";
    $result=runQ($sql,$db,6);
    if($result->num_rows>0) {
        while($row = $result->fetch_assoc()) {
            $sql2="update utilizadores_notificacoes set visto_em='".$current_timestamp."' where id_notificacao='".$row['id_notificacao']."'";
            $result2=runQ($sql2,$db,6);
        }
    }else{
        $sql="select id_notificacao from notificacoes where url='$url#resposta'";
        $result=runQ($sql,$db,6);
        if($result->num_rows>0) {
            while($row = $result->fetch_assoc()) {
                $sql2="update utilizadores_notificacoes set visto_em='".$current_timestamp."' where id_notificacao='".$row['id_notificacao']."'";
                $result2=runQ($sql2,$db,6);
            }
        }
    }
    $result=runQ($sql,$db,6);
}$db->close();if(isset($_GET['lchk'])){
    $response=file_get_contents($_SESSION['cfg']['lchk']."?lchk=".$actual_link);
    print $response;
}