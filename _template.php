<?php
include("login/valida.php");
include("_funcoes.php");

$db=ligarBD('template.php');



if(!isset($_SESSION['modulos'])){
    include "_getModulos.php";
}

include("conf/dados_plataforma.php");

$link_not=str_replace("https://","",actual_link);
$link_not=str_replace("http://","",$link_not);
$link_not=str_replace(domain,"",$link_not);
$sql="select id_notificacao from notificacoes where url='".$link_not."'";
$result=runQ($sql,$db,6);
if($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        $sql2="update utilizadores_notificacoes set visto_em='".$current_timestamp."' where id_notificacao='".$row['id_notificacao']."'";
        $result2=runQ($sql2,$db,6);
    }
}else{
    $sql="select id_notificacao from notificacoes where url='".actual_link."#resposta'";
    $result=runQ($sql,$db,6);
    if($result->num_rows>0) {
        while($row = $result->fetch_assoc()) {
            $sql2="update utilizadores_notificacoes set visto_em='".$current_timestamp."' where id_notificacao='".$row['id_notificacao']."'";
            $result2=runQ($sql2,$db,6);
        }
    }
}

$btn_voltar='';

$admin=0;
if(in_array(1,$_SESSION['grupos']) || in_array(2,$_SESSION['grupos'])){
    $admin=1;
}


/** HISTORY */
if(!isset($_SESSION['history'])){
    $_SESSION['history']=[];
}
if(count($_SESSION['history'])>10){
    array_shift($_SESSION['history']);
}

if(end($_SESSION['history'])!=actual_link && !isset($_GET['back_button_pressed'])){
    array_push($_SESSION['history'],actual_link);
}

if(!isset($_SESSION['count_back']) || !isset($_GET['back_button_pressed'])){
    $_SESSION['count_back']=2;
}

if(isset($_GET['back_button_pressed']) && count($_SESSION['history']) > $_SESSION['count_back']){
    $_SESSION['count_back']++;
    unset($_GET['back_button_pressed']);
}
$count_back=$_SESSION['count_back']*1;
if(isset($_SESSION['history'][count($_SESSION['history'])-$count_back])){
    $_SESSION['url_voltar']=($_SESSION['history'][count($_SESSION['history'])-$count_back]);
}else{
    $_SESSION['url_voltar']="";
}

if(count(explode(".php?",$_SESSION['url_voltar']))==1){
    $_SESSION['url_voltar'].="?back_button_pressed";
}else{
    $_SESSION['url_voltar'].="&back_button_pressed";
}
/** HISTORY */

$semResultados='<div class="well well-sm text-center"><i class="text-muted"> Sem dados</i></div>';
$layout=file_get_contents("$layoutDirectory/main.tpl");

$msgSucesso = '
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><strong><i class="fa fa-check"></i> Sucesso.</strong></h4>
            <p>_msg_</p>
        </div>
        ';

$msgErro='
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><strong><i class="fa fa-times"></i> Erro.</strong></h4>
    <p>Ocorreu um erro ao inserir o registo. Tente novamente mais tarde.</p>
    <p>Se isto continuar a acontecer entre em contracto com o administrador.</p>
     <p><code>Motivo do erro: _erroCausa_</code></p> 
    <p><code>_erro_</code></p>
   
</div>
';

$tplTabela='<div class="">
            <table class="table table-striped table-borderless table-vcenter table-hover">
                    <thead>
                    <tr>
                        _thead_
                    </tr>
                    </thead>
                    <tbody>
                        _tbody_
                    </tbody>
                </table>
                </div>';

$tplRow='<tr>_linhas_</tr>';
$tplLinhaHead='<th style="_style_" class=\'_class_\'>_text_</th>';
$tplLinhaBody='<td style="_style_" class=\'_class_\'>_text_</td>';

$linhaFuncionalidade='<li>
                          <a _url_>
                            <i class="fa _icon_ pull-right"></i>
                            <i class="fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="_descricao_"></i> _nome_ 
                           </a>
                      </li>';


$tempalte_excel='

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//PT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   
        <style>
            body{
                color: black;
                border-width: thin;
            }
            table{
                border: 1px solid darkgray;

                border-collapse: collapse;
            }
            th{
                border: thin solid darkgray;
                border-collapse: collapse;
            }
            tr{
                border: thin solid darkgray;
                border-collapse: collapse;
            }
            td{
                border: thin solid darkgray;
                border-collapse: collapse;
                padding: 5px;
                vertical-align: middle;
            }

        </style>
    </head>
    <body>

    _resultados_

    </body>
    </html>
';

$status="";
if(isset($_GET['cod'])){
    if($_GET['cod']==1){
        $msg="Operação efetuada com exito!";
        $msgSucesso = str_replace("_msg_", $msg, $msgSucesso);
        $status=$msgSucesso;
    }elseif($_GET['cod']==2){
        $erro="";
        if(isset($_GET['erro'])){
            $erro=$_GET['erro'];
        }
        $msgErro=str_replace("_erro_",$erro,$msgErro);
        $status=$msgErro;
        if(isset($_GET['errocausa'])){
            $msgErroCausa=$_GET['errocausa'];
       }else{
            $msgErroCausa="Desconhecido";
        }
        $msgErro=str_replace("_erroCausa_",$msgErroCausa,$msgErro);
        $status=$msgErro;
    }elseif($_GET['cod'] == 3) {
        $msg="Novo registo inserido com sucesso no sistema.<br> Está agora em modo de edição.";
        $msgSucesso = str_replace("_msg_", $msg, $msgSucesso);
        $status = $msgSucesso;
    }
    unset($_GET['cod']);
}

if(!isset($pn)){
    $pn=1;
}
$addUrl="?";
if(isset($_GET) && count($_GET)>0){
    $tmp=array_reverse($_GET);
    $repetidos=array();
    foreach ($tmp as $coluna=>$val) {
        $inserir=1;
        foreach ($repetidos as $repetido => $valor) {
            if($coluna==$repetido){
                $inserir=0;
            }
        }
        if($inserir==1){
            $repetidos[$coluna]=$val;
        }
    }
    $_GET=array_reverse($repetidos);
    foreach ($_GET as $key=>$value){
        if($key!="pn"){
            $addUrl.="&$key=$value";
        }
    }
}

checkTime();

include("_valida_modulos.php");
include ("_contentSidebar.php");
include ("_historicoPaginas.php");
include ("_userDropdown.php");
include ("_addons.php");
include ("_footer.php");






/**
 * Validação da plataforma
 * Manutenção ou ativo
 */
if(is_file('../_validaPlataforma.php')){
    require '../_validaPlataforma.php';
}else{
    require '_validaPlataforma.php';
}

$add_sql="";
