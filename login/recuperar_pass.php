<?php
include_once("../_funcoes.php");
include_once("../conf/dados_plataforma.php");

$nomePagina="Nova palavra-passe";
$layoutDirectory="../assets/layout/";
$layout=file_get_contents("$layoutDirectory/login.tpl");
$content=file_get_contents("recuperar_pass.tpl");

//alterar pass
if(isset($_POST['recuperar']) && isset($_POST['login-password']) && isset($_POST['login-email'])){
    $db=ligarBD("recuperar");
    $pass=encriptarPW($_POST['login-password']);
    $id_utilizador=$db->escape_string($_POST['login-email']);

    $sql="update utilizadores_recuperacao set ativo=0 where id_utilizador=i$id_utilizadord_utilizador and  ativo=1";
    $result=runQ($sql,$db,1);

    $sql="update utilizadores set pass='$pass' where id_utilizador='$id_utilizador'";
    $result=runQ($sql,$db,1);

    criarLog($db,"utilizadores","id_utilizador",$id_utilizador,"Alterou Palavra-passe.",null);

    $db->close();
    header("location: recuperar_pass.php?cod=2");
    exit;
}
//mensagens de erro e redirecionamentos
if(isset($_GET['cod'])){
    $cod=$_GET['cod'];
    if($cod==1){
        // não encontrou pedido de recuperação com os dados e a data correspondnte
        $msg=file_get_contents("msg_erroRecuperar.tpl");
        $content=$msg;
    }elseif($cod==2){
        //sucesso
        $msg=file_get_contents("msg_recuperarSucesso.tpl");
        $content=$msg;
    }
}else{//mostrar erro!!
    if(isset($_GET['utilizador']) && isset($_GET['token'])){
        $db=ligarBD("recuperar&subItemID&token");

        $id_utilizador=$db->escape_string($_GET['utilizador']);
        $token=$db->escape_string($_GET['token']);

        $sql="select data_expira from utilizadores_recuperacao where id_utilizador='$id_utilizador' and token='$token' and data_expira>'".current_timestamp."' and ativo=1";
        $result=runQ($sql,$db,1);
        if($result->num_rows==0){
            header("location: recuperar_pass.php?cod=1"); // não encontrou pedido de recuperação com os dados e a data correspondnte
        }
        $db->close();
        $content=str_replace("_idUtilizador_",$id_utilizador,$content);
    }else{
        header("location: recuperar_pass.php?cod=1"); // não encontrou pedido de recuperação com os dados e a data correspondnte
        exit;
    }
}
$content=str_replace("_status_","",$content);
$pageScript='<!-- Load and execute javascript code used only in this page -->
<script src="readyRecovery.js"></script>
<script>$(function(){ ReadyRecovery.init(); });</script>';
$layout=str_replace("_pageScript_",$pageScript,$layout);

$menu="";
$contentSidebar="";
$historicoPaginas="";
$userDropdown="";
include_once ("../_footer.php");
include_once ("../_autoData.php");
