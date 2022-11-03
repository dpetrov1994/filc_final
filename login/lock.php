<?php
if(isset($_GET['teste'])){
    die();
}
session_start();
if(isset($_SESSION['nome_utilizador']) && isset($_SESSION['email_sessao'])){
    $_SESSION['lock']=1;
}else{
    include('valida.php');
}

include_once("../_funcoes.php");
include_once("../conf/dados_plataforma.php");

$nomePagina="Entrar";
$layoutDirectory="../assets/layout/";
$layout=file_get_contents("$layoutDirectory/login.tpl");
$content=file_get_contents("lock.tpl");

$content=str_replace("_tipoUtilizador_","Bloqueado",$content);
if(isset($_POST['lock']) && isset($_POST['lock-password'])){

    $db=ligarBD(1);

    $email=$_SESSION['email_sessao'];
    $pass=$_POST['lock-password'];

    $sql ="SELECT * FROM utilizadores WHERE email='$email'";
    $result=runQ($sql,$db,1);
    if($result->num_rows==1) {
        while ($row = $result->fetch_assoc()) {
            if(password_verify($pass,$row['pass'])){
                $_SESSION['lock'] = 0;
                $location="../index.php"; // sucesso
            }
        }
    }else{
        $location="lock.php?cod=1"; // erro
    }
    $db->close();
    header("Location: $location");
    exit;
}

//mensagens de erro e redirecionamentos
if(isset($_GET['cod'])){
    $cod=$_GET['cod'];
    if($cod==1){
        //dados incorretos
        $msg=file_get_contents("msg_dadosIncorretos.tpl");
        $content=str_replace("_status_",$msg,$content);
    }
}
$content=str_replace("_status_","",$content);

$pageScript='<!-- Load and execute javascript code used only in this page -->
<script src="'.$layoutDirectory.'/js/pages/readyLogin.js"></script>
<script>$(function(){ ReadyLogin.init(); });</script>';
$layout=str_replace("_pageScript_",$pageScript,$layout);

$menu="";
$contentSidebar="";
$historicoPaginas="";
$userDropdown="";
include_once ("../_footer.php");
include_once ("../_autoData.php");
