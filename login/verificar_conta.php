<?php
include_once("../_funcoes.php");
include_once("../conf/dados_plataforma.php");

$nomePagina="Nova palavra-passe";
$layoutDirectory="../assets/layout/";
$layout=file_get_contents("$layoutDirectory/login.tpl");
//mensagens de erro e redirecionamentos
if(isset($_GET['token'])){
    $db=ligarBD("Verifica Conta");
    $token=$db->escape_string($_GET['token']);

    $sql="select id_utilizador from utilizadores where verification_token='$token'";
    $result=runQ($sql,$db,1);
    if($result->num_rows==0){
        $content=file_get_contents("msg_ativarErro.tpl");
    }else{
        while($row = $result->fetch_assoc()){
            $id_utilizador=$row['id_utilizador'];
        }

        $sql="update utilizadores set verificado=1, data_verificado='".current_timestamp."' where verification_token='$token'";
        $result=runQ($sql,$db,1);

        criarLog($db,"utilizadores","id_utilizador",$id_utilizador,"Email verificado.",null);
    }
    $db->close();
    $content=file_get_contents("msg_ativarSucesso.tpl");
    $content=str_replace("_token_",$_GET['token'],$content);
}else{
    $content=file_get_contents("msg_ativarErro.tpl");
}
$content=str_replace("_status_","",$content);
$layout=str_replace("_pageScript_","",$layout);

$menu="";
$contentSidebar="";
$historicoPaginas="";
$userDropdown="";
include_once ("../_footer.php");
include_once ("../_autoData.php");
