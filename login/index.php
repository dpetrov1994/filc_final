<?php
$nomePagina="Iniciar Sessão";

@session_start();

include_once("../_funcoes.php");

if(isset($_SESSION['nome_utilizador']) && isset($_SESSION['email_sessao'])){
    header("Location: ../index.php");
}

include_once("../conf/dados_plataforma.php");

$cfg_nome_funcionalidade="Iniciar Sessão";
$layout=file_get_contents("$layoutDirectory/login.tpl");
$content=file_get_contents("entrar.tpl");

if(isset($_GET['unsetLoginCookie'])){
    setcookie("lembrar-me", "", time()-3600);
    header("location: index.php");
}

$script="";

if(isset($_COOKIE['user_id'])  && !isset($_SESSION['id_utilizador'])){
    if($_COOKIE['user_id']!=""){
        $db=ligarBD("auto login");
        $email=decryptData($_COOKIE['user_id']);
        $email=$db->escape_string($email);
        $sql="select verification_token from utilizadores where email='$email'";
        $result=runQ($sql,$db,1);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()) {
                $_POST['login-email']=$email;
                $_POST['token']=$row['verification_token'];
                $_POST['login-password']=md5(time());
                $_POST['auto_login']=1;
                include "entrar.php";
            }
        }
    }
}

if(isset($_COOKIE["lembrar-me"])){
    $content=str_replace("_email_",$_COOKIE["lembrar-me"],$content);
    $content=str_replace("_pass_","Assim seria demasiado fácil! :)",$content);
    $content=str_replace("_checked_","checked",$content);
    $script="<script>$( document ).ready(function() {
    login();
});</script>";
}

if(isset($_GET['token'])){
    $db=ligarBD("auto login");
    $token=$db->escape_string($_GET['token']);
    $sql="select email from utilizadores where verification_token='$token'";
    $result=runQ($sql,$db,1);
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            $content=str_replace("_email_",$row['email'],$content);
            $content=str_replace("_token_",$token,$content);
            $content=str_replace("_pass_","Assim seria demasiado fácil! :)",$content);
            $script="<script>$( document ).ready(function() {
                login();
            });</script>";
        }
    }
    $db->close();
}

$content=str_replace("_email_","",$content);
$content=str_replace("_token_","",$content);
$content=str_replace("_pass_","",$content);
$content=str_replace("_checked_","",$content);

//mensagens de erro e redirecionamentos
if(isset($_GET['cod'])){
    $cod=$_GET['cod'];
    if($cod==1){
        //utilizador não verificado
        $email="";
        if(isset($_GET['email'])){
            $email=$_GET['email'];
        }
        $msg=file_get_contents("msg_naoVerificado.tpl");
        $msg=str_replace("_email_",$email,$msg);
        $content=str_replace("_status_",$msg,$content);
    }elseif($cod==2){
        //utilziador desativo
        $msg=file_get_contents("msg_desativo.tpl");
        $content=str_replace("_status_",$msg,$content);
    }elseif($cod==3 || $cod==4){
        //utilizador não encontrado
        $msg=file_get_contents("msg_dadosIncorretos.tpl");
        $content=str_replace("_status_",$msg,$content);
    }elseif($cod==5){
        //erro no script
        $msg=file_get_contents("msg_erroScript.tpl");
        $content=str_replace("_status_",$msg,$content);
    }
}

$pageScript='<!-- Load and execute javascript code used only in this page -->
<script src="readyLogin.js"></script>
<script>$(function(){ ReadyLogin.init(); });</script>
'.$script;
$menu="";
$contentSidebar="";
$historicoPaginas="";
$userDropdown="";
include_once ("../_footer.php");
include_once ("../_autoData.php");
