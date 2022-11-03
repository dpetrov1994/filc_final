<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 27/03/2018
 * Time: 16:54
 */

ini_set('max_execution_time', 1800); //30min
set_time_limit(1800);
ignore_user_abort(true);

session_start();
include ("_funcoes.php");
include ("conf/dados_plataforma.php");


$db=ligarBD("NOTIFICACAOES");

$nome_notificacao=$db->escape_string($_SERVER['argv'][1]);
$nome_tabela=$db->escape_string($_SERVER['argv'][2]);
$nome_coluna=$db->escape_string($_SERVER['argv'][3]);
$id_item=$db->escape_string($_SERVER['argv'][4]);
$url_destino=$db->escape_string($_SERVER['argv'][5]);
$destinatarios=json_decode($_SERVER['argv'][6]);
$destinatarios_sms=json_decode($_SERVER['argv'][7]);
$destinatarios_email=json_decode($_SERVER['argv'][8]);
$current_timestamp=$db->escape_string($_SERVER['argv'][9]);
$session_id_utilizador=$db->escape_string($_SERVER['argv'][10]);
$texto_sms=$db->escape_string($_SERVER['argv'][11]);
$texto_email=$db->escape_string($_SERVER['argv'][12]);
$texto_email_natural=($_SERVER['argv'][12]);
$anexos=json_decode($_SERVER['argv'][13]);

print "-> ".$current_timestamp."\r\n";

print_r($_SERVER['argv']);

$sql_notificacao = "insert into notificacoes 
            (nome_notificacao, nome_tabela, nome_coluna, id_item, url, id_criou, created_at)
            VALUES 
            ('$nome_notificacao','$nome_tabela','$nome_coluna','$id_item','$url_destino','$session_id_utilizador','".$current_timestamp."')";
$result_notificacao = runQ($sql_notificacao, $db, "INSERIR NOTIFICACAO");
$id_notificacao=$db->insert_id;

if(isset($destinatarios) && is_array($destinatarios) && count($destinatarios)>0){
    foreach ($destinatarios as $destinatario){
        $sql_notificacao="insert into utilizadores_notificacoes (id_utilizador, id_notificacao) values ('$destinatario','$id_notificacao')";
        $result_notificacao = runQ($sql_notificacao, $db, "INSERIR NOTIFICACAO_UTILIZADOR");
    }
}
if(isset($destinatarios_sms) && is_array($destinatarios_sms) && count($destinatarios_sms)>0){
    $add_sql="";
    foreach ($destinatarios_sms as $destinatario){
        $add_sql.=" id_utilizador='$destinatario' or ";
    }
    $add_sql.="|";
    $add_sql=str_replace("or |","",$add_sql);

    $sql_notificacao="select contacto from utilizadores where 1 and ($add_sql)";
    $result_notificacao = runQ($sql_notificacao, $db, "SELECT CONTACTOS");
    $contactos=array();
    while ($row = $result_notificacao->fetch_assoc()) {
        array_push($contactos,$row['contacto']);
    }
    enviarEmailSms($contactos,$texto_sms);
}
if(isset($destinatarios_email) && is_array($destinatarios_email) && count($destinatarios_email)>0){
    /*
    $add_sql="";

    foreach ($destinatarios_email as $destinatario){
        $add_sql.=" id_utilizador='$destinatario' or ";
    }

    $add_sql.="|";
    $add_sql=str_replace("or |","",$add_sql);

    $sql_notificacao="select email from utilizadores where 1 and ($add_sql)";
    $result_notificacao = runQ($sql_notificacao, $db, "SELECT EMAILS");
    $emails=array();
    while ($row = $result_notificacao->fetch_assoc()) {
        array_push($emails,$row['email']);
    }
    */

    $emailTpl=file_get_contents("../assets/email/email.tpl");
    $emailTpl=str_replace("_conteudo_",str_replace('\r\n',"",$texto_email_natural),$emailTpl);
    $emailTpl=str_replace("_nomeEmpresa_",$cfg_nomeEmpresa,$emailTpl);
    $emailTpl=str_replace("_moradaEmpresa_",$cfg_moradaEmpresa,$emailTpl);
    $emailTpl=str_replace("_siteEmpresa_",$cfg_siteEmpresa,$emailTpl);
    $emailTpl=str_replace("_copyPlataforma_",$cfg_copyPlataforma,$emailTpl);
    $emailTpl=str_replace("_copyAno_",date("Y"),$emailTpl);
    $emailTpl=str_replace("_copySite_",$cfg_copySite,$emailTpl);
    $emailTpl=str_replace("_nomePlataforma_",$cfg_nomePlataforma,$emailTpl);

    enviarEmail($anexos,"Notificações - ".$_SESSION['cfg']['nomePlataforma'],$emailTpl,$destinatarios_email);
}
$db->close();
print "##################################################\r\n";
