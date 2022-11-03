<?php
include ("../../_funcoes.php");
include ("../../conf/dados_plataforma.php");

if(isset($_GET['email'])){
    $db=ligarBD("ajax");

    $email=$db->escape_string($_GET['email']);
    $codigo=rand(1111,9999);

    enviarEmail($anexos=[],$_SESSION['cfg']['copyPlataforma']." - Código de verificação - Marcações ","Este é o seu código de virificação: $codigo<br>Se não pediu o código de verificação ignore esta mensagem.",$destinatarios=[$email]);

    print $codigo*2;
    $db->close();

}