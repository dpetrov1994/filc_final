<?php
include ('../_template.php');
$content=file_get_contents("manutencao.tpl");
$db=ligarBD('1');
$sql ="select * from _conf_ip_whitelist";
$result=runQ($sql,$db,6);
$ips="";
while($row = $result->fetch_assoc()){
    $ips.=$row['ip']."\n";
}$content=str_replace("_ips_",$ips,$content);
$sql ="select * from _conf_estado_plataforma";
$result=runQ($sql,$db,6);
while($row = $result->fetch_assoc()){
    if($row['manutencao']==1){
        $content=str_replace("_manutencao_","checked=''",$content);
    }else{
        $content=str_replace("_manutencao_","",$content);
    }    if($row['ativo']==1){
        $content=str_replace("_plataforma_","checked=''",$content);
    }else{
        $content=str_replace("_plataforma_","",$content);
    }}$msgSucesso = '        <div class="alert alert-success alert-dismissable">            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>            <h4><strong>Sucesso.</strong></h4>            <p>_msg_</p>        </div>        ';
$msgErro='<div class="alert alert-danger alert-dismissable">    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    <h4><strong>Erro.</strong></h4>    <p>Ocorreu um erro ao inserir o registo. Tente novamente mais tarde.</p>    <p>Se isto continuar a acontecer entre em contracto com o administrador.</p>    <p><code>_erro_</code></p></div>';
$status="";
if(isset($_POST['submit']) && isset($_GET['plataforma'])){
    $erros=0;
    $erro="";
    $manutencao=0;
    if(isset($_POST['manutencao'])){
        $manutencao=1;
    }    $plataforma=0;
    if(isset($_POST['plataforma'])){
        $plataforma=1;
    }    $ips="";
    if(isset($_POST['ips'])){
        $ips=$db->escape_string(trim($_POST['ips']));
        $ips=explode('\r\n', $ips);
    }    if($erros==0){
        $sql ="update _conf_estado_plataforma set manutencao='$manutencao',ativo='$plataforma'";
        $result=runQ($sql,$db,6);
        $sql ="delete from _conf_ip_whitelist";
        $result=runQ($sql,$db,6);
        $naoInserir=0;
        foreach ($ips as $ip){
            $sql="insert into _conf_ip_whitelist (ip) values ('$ip')";
            $result=runQ($sql,$db,6);
            if($ip==$_SERVER['REMOTE_ADDR']){
                $naoInserir=1;
            }        }        if(isset($naoInserir) && $naoInserir==0){
            $sql="insert into _conf_ip_whitelist (ip) values ('".$_SERVER['REMOTE_ADDR']."')";
            $result=runQ($sql,$db,6);
        }        criarLog($db,"_conf_estado_plataforma","id_conf_estado_plataforma",$id,"set manutencao='$manutencao',ativo='$plataforma'",null);
        $result=runQ($sql,$db,6);
        $location="manutencao.php?cod=1";
    }else{
        $erro.=" Falta de dados para processar pedido.";
        $location="smtp.php?cod=2&erro=$erro";
    }    $db->close();
    header("location: $location");
}if(isset($_GET['cod'])){
    if($_GET['cod']==1){
        $id="";
        if(isset($_GET['id'])){
            $id=$_GET['id'];
        }        $msg="Configuração de estado da plataforma alterado com sucesso. <br>";
        $msgSucesso = str_replace("_id_", $id, $msgSucesso);
        $msgSucesso = str_replace("_msg_", $msg, $msgSucesso);
        $status=$msgSucesso;
    }elseif($_GET['cod']==2){
        $erro="";
        if(isset($_GET['erro'])){
            $erro=$_GET['erro'];
        }        $msgErro=str_replace("_erro_",$erro,$msgErro);
        $status=$msgErro;
    }}$content=str_replace('_status_',$status,$content);
$pageScript='        <!-- Load and execute javascript code used only in this page -->        <script src="mod_conf_plataforma_smtp.js"></script>        <script>$(function(){
 ValidarFormulario.init();
 });
</script>';
include ('../_autoData.php');
