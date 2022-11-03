<?php
include ('../_template.php');
$content=file_get_contents("alterar_favicon.tpl");$status = "";
if (isset($_POST['submit'])) {
    $erros = 0;
    $erro = "";    $fileName = $_FILES["foto"]["name"];
    $fileTmpLoc = $_FILES["foto"]["tmp_name"];
    $fileType = $_FILES["foto"]["type"];
    $fileSize = $_FILES["foto"]["size"];
    $fileErrorMsg = $_FILES["foto"]["error"];
    $kaboom = explode(".", $fileName);
    $fileExt = end($kaboom);    if (!$fileTmpLoc) {
        $erro .= " SEM FICHEIRO -";
        $erros++;
    } else if($fileSize > ($cfg_tamanhoMaxUpload*1000*100)) { // if file size is larger than default alowed size
        $erro .= " TAMANHO max($cfg_tamanhoMaxUpload)-";
        $erros++;
        @unlink($fileTmpLoc);
    } else if (!preg_match("/.(jpg|jpeg|png)$/i", $fileName) ) {
        $erro .= " TIPO DE FICHEIRO INVÁLIDO (jpg|png) -";
        $erros++;
        @unlink($fileTmpLoc);
    } else if ($fileErrorMsg == 1) {
        $erro .= " ERRO AO PROCESSAR FICHEIRO-";
        $erros++;
    }    $imagem = "favicon.png";
    $moveResult = move_uploaded_file($fileTmpLoc, "$layoutDirectory/img/original_$imagem");
    if ($moveResult != true) {
        $erro .= " O FICHEIRO NAO FOI CARREGADO PARA O SERVIDOR-";
        $erros++;
    }    if ($erros == 0) {
        $target_file="$layoutDirectory/img/original_$imagem";
        $resized_file = "$layoutDirectory/img/$imagem";
        $wmax = 32;
        $hmax = 32;
        resizeTransparent($target_file, $resized_file, $wmax, $hmax);        criarLog($db,"_conf_cliente","id_conf",$id,"Alterou favicon.",null);    } else {
        $erro .= " Falta de dados para processar pedido.";
        $location = "alterar_favicon.php?cod=2&erro=$erro";
    }
    header("location: $location");
}$content = str_replace('_status_', $status, $content);
include "../_autoData.php";