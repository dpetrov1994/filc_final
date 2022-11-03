<?php
include_once("../_funcoes.php");
include_once("../conf/dados_plataforma.php");
if(isset($_POST['submit'])){
    print "Aguarde...";

    $erros=0;
    $erro="";
    if(isset($_POST['nome_utilizador']) && $_POST['nome_utilizador']!=""){
        $nome_utilizador=$db->escape_string($_POST['nome_utilizador']);
    }else{
        $erro.=" nome_utilizador -";
        $erros++;
    }
    if(isset($_POST['id_utilizador']) && $_POST['id_utilizador']!=""){
        $id_utilizador=$db->escape_string($_POST['id_utilizador']);
    }else{
        $erro.=" id_utilizador -";
        $erros++;
    }
    if(isset($_POST['nome_empresa']) && $_POST['nome_empresa']!=""){
        $nome_empresa=$db->escape_string($_POST['nome_empresa']);
    }else{
        $erro.=" nome_empresa -";
        $erros++;
    }
    if(isset($_POST['nome_plataforma']) && $_POST['nome_plataforma']!=""){
        $nome_plataforma=$db->escape_string($_POST['nome_plataforma']);
    }else{
        $erro.=" nome_plataforma -";
        $erros++;
    }
    if(isset($_POST['dominio']) && $_POST['dominio']!=""){
        $dominio=$db->escape_string($_POST['dominio']);
    }else{
        $erro.=" dominio -";
        $erros++;
    }
    if(isset($_POST['sugestao']) && $_POST['sugestao']!=""){
        $sugestao=$db->escape_string($_POST['sugestao']);
    }else{
        $erro.=" sugestao -";
        $erros++;
    }

    if($erros==0){

        $sql="insert into sugestoes 
              (id_criou,nome_criou,nome_empresa,nome_plataforma,dominio,sugestao,created_at) 
              values 
              (i$id_utilizadord_utilizador,'$nome_utilizador','$nome_empresa','$nome_plataforma','$dominio','$sugestao','".current_timestamp."')";
        $result=runQ($sql,$db,4);

        $sql="select max(id_sugestao) from sugestoes where id_criou='".$_SESSION['id_utilizador']."'";
        $result=runQ($sql,$db,5);
        while ($row = $result->fetch_assoc()) {
            $id_sugestao=$row['max(id_sugestao)'];
        }
        //logs
        $textoLog="Enviou uma sugestão/correção.<br>
                   ID: $id_sugestao<br>
                   NAME: $nome<br>
                   IP: ".$_SERVER['REMOTE_ADDR']."<br>";
        $textoLog=$db->escape_string($textoLog);

        $sql = "INSERT INTO utilizadores_logs (data_log,texto,id_utilizador) VALUES ('".current_timestamp."','$textoLog','" .$_SESSION['id_utilizador']."')";
        $result=runQ($sql,$db,6);

        $location="$dominio?&cod=1";

    }else{
        $erro.=" Falta de dados para processar pedido.";
        $location="$dominio?&cod=2";
    }


    header("location: $location");
    die();
}
$nomePagina="Enviar uma sugestão";

include_once("../login/valida.php");

$cfg_nome_funcionalidade="Enviar uma sugestão";
$layoutDirectory="../assets/layout/";
$layout=file_get_contents("$layoutDirectory/login.tpl");

$content=file_get_contents("sugestoes.tpl");
$content=str_replace("_servidorSugestoes_",$cfg_servidorSugestoes,$content);

$msgSucesso = '
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><strong>Sucesso.</strong></h4>
            <p>_msg_</p>
            <p><a href="../index.php" class="alert-link">Voltare</a></p>
        </div>
        ';
$msgErro='
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><strong>Erro.</strong></h4>
    <p>Ocorreu um erro ao inserir o registo. Tente novamente mais tarde.</p>
    <p>Se isto continuar a acontecer entre em contracto com o administrador.</p>
    <p><code>_erro_</code></p>
</div>
';

$status="";
if(isset($_GET['cod'])){
    if($_GET['cod']==1){
        $id="";
        if(isset($_GET['id'])){
            $id=$_GET['id'];
        }
        $msg="A sua mensagem foi enviada com sucesso. Agradecemos a sua colaboração. <br>";
        $msgSucesso = str_replace("_id_", $id, $msgSucesso);
        $msgSucesso = str_replace("_msg_", $msg, $msgSucesso);
        $status=$msgSucesso;
    }elseif($_GET['cod']==2){
        $erro="";
        if(isset($_GET['erro'])){
            $erro=$_GET['erro'];
        }
        $msgErro=str_replace("_erro_",$erro,$msgErro);
        $status=$msgErro;
    }
}
$content=str_replace('_status_',$status,$content);

$pageScript='        <!-- Load and execute javascript code used only in this page -->
        <script src="user_form.js"></script>
        <script>$(function(){ ValidarFormulario.init(); });</script>';

include ('../_autoData.php');