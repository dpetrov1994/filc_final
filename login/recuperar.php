<?php
include_once("../_funcoes.php");
include_once("../conf/dados_plataforma.php");

$cfg_nome_funcionalidade="Recuperar palavra-passe";
$layoutDirectory="../assets/layout/";
$layout=file_get_contents("$layoutDirectory/login.tpl");
$content=file_get_contents("recuperar.tpl");

if(isset($_POST['recuperar']) && isset($_POST['reminder-email'])){
    include_once ("recuperar_email.php");
}

//mensagens de erro e redirecionamentos
if(isset($_GET['cod'])){
    $cod=$_GET['cod'];
    if($cod==1){
        //utilizador não verificado
        $email="";
        if(isset($_GET['email'])){
            $email=$_GET['email'];
        }
        $naoVerificado=file_get_contents("msg_naoVerificado.tpl");
        $naoVerificado=str_replace("_email_",$email,$naoVerificado);
        $content=str_replace("_status_",$naoVerificado,$content);;
    }elseif($cod==2){
        //utilziador desativo
        $desativo=file_get_contents("msg_desativo.tpl");
        $content=str_replace("_status_",$desativo,$content);
    }elseif($cod==3 || $cod==4){
        //utilizador não encontrado
        $dadosIncorretos=file_get_contents("msg_dadosIncorretos.tpl");
        $content=str_replace("_status_",$dadosIncorretos,$content);
    }elseif($cod==5){
        //utilziador desativo
        $msg=file_get_contents("msg_sucesso.tpl");
        $content=$msg;
    }
}
$content=str_replace("_status_","",$content);
$pageScript='        <!-- Load and execute javascript code used only in this page -->
        <script src="readyReminder.js"></script>
        <script>$(function(){ ReadyReminder.init(); });</script>';
$menu="";
$contentSidebar="";
$historicoPaginas="";
$userDropdown="";

include_once ("../_footer.php");
include_once ("../_autoData.php");