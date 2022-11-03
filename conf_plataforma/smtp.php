<?php
include ('../_template.php');
$content=file_get_contents("smtp.tpl");
$db=ligarBD('1');
 include "../conf/smtp.php";
 $content=str_replace("_host_",$smtp_host,$content);
 $content=str_replace("_port_",$smtp_port,$content);
 $content=str_replace("_nomeFrom_",$smtp_userNome,$content);
 $content=str_replace("_user_",$smtp_user,$content);
 $content=str_replace("_pass_",$smtp_pass,$content);
 $content=str_replace("_reply_",$smtp_reply,$content);
 $content=str_replace("_replyNome_",$smtp_replyNome,$content);
$status="";
if(isset($_POST['submit'])){
    $erros=0;
    $erro="";
    $host="";
    if(isset($_POST['host'])){
        $host=$db->escape_string($_POST['host']);
    }
else{
        $erro.=" host -";
        $erros++;
    }
    $port="";
    if(isset($_POST['port'])){
        $port=$db->escape_string($_POST['port']);
    }
else{
        $erro.=" port -";
        $erros++;
    }
    $nome="";
    if(isset($_POST['nome'])){
        $nome=$db->escape_string($_POST['nome']);
    }
else{
        $erro.=" nome -";
        $erros++;
    }
    $user="";
    if(isset($_POST['user'])){
        $user=$db->escape_string($_POST['user']);
    }
else{
        $erro.=" user -";
        $erros++;
    }
    $pass="";
    if(isset($_POST['pass'])){
        $pass=$db->escape_string($_POST['pass']);
    }
else{
        $erro.=" pass -";
        $erros++;
    }
    $reply="";
    if(isset($_POST['reply'])){
        $reply=$db->escape_string($_POST['reply']);
    }
else{
        $erro.=" reply -";
        $erros++;
    }
    $replyNome="";
    if(isset($_POST['replyNome'])){
        $replyNome=$db->escape_string($_POST['replyNome']);
    }
else{
        $erro.=" replyNome -";
        $erros++;
    }
    if($erros==0){
        $template=file_get_contents("smtp.modelo");
        $template=str_replace("_host_",$host,$template);
        $template=str_replace("_port_",$port,$template);
        $template=str_replace("_user_",$user,$template);
        $template=str_replace("_pass_",$pass,$template);
        $template=str_replace("_userNome_",$nome,$template);
        $template=str_replace("_reply_",$reply,$template);
        $template=str_replace("_replyNome_",$replyNome,$template);
        $configFile = fopen("../conf/smtp.php", "w") or die("Unable to open file!");
        fwrite($configFile, $template);
        fclose($configFile);
        criarLog($db,"dir:conf","file:smtp.php","smtp.php","Alterou configuração SMTP",null);
        $result=runQ($sql,$db,6);
        $location="smtp.php?cod=1";
    }
else{
        $erro.=" Falta de dados para processar pedido.";
        $location="smtp.php?cod=2&erro=$erro";
    }
    $db->close();
    header("location: $location");
}
include ('../_autoData.php');
