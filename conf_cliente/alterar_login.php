<?php
include ('../_template.php');
$content=file_get_contents("alterar_login.tpl");

$status = "";
if (isset($_POST['submit'])) {
    $erros = 0;
    $erro = "";

    $fileName = $_FILES["foto"]["name"];
    $fileTmpLoc = $_FILES["foto"]["tmp_name"];
    $fileType = $_FILES["foto"]["type"];
    $fileSize = $_FILES["foto"]["size"];
    $fileErrorMsg = $_FILES["foto"]["error"];
    $kaboom = explode(".", $fileName);
    $fileExt = end($kaboom);

    if (!$fileTmpLoc) {
        $erro .= " SEM FICHEIRO -";
        $erros++;
    } else if($fileSize > ($cfg_tamanhoMaxUpload*1000*100)) { // if file size is larger than default alowed size
        $erro .= " TAMANHO max($cfg_tamanhoMaxUpload)-";
        $erros++;
        @unlink($fileTmpLoc);
    } else if (!preg_match("/.(gif|jpg|jpeg|png)$/i", $fileName) ) {
        $erro .= " TIPO DE FICHEIRO NÃO É IMAGEM -";
        $erros++;
        @unlink($fileTmpLoc);
    } else if ($fileErrorMsg == 1) {
        $erro .= " ERRO AO PROCESSAR FICHEIRO-";
        $erros++;
    }

    $tmp_dir="../.tmp/".$_SESSION['id_utilizador'];
    if(!is_dir($tmp_dir)){
        mkdir($tmp_dir);
    }

    $imagem = "login.$fileExt";
    $moveResult = move_uploaded_file($fileTmpLoc, "$tmp_dir/$fileName");
    if ($moveResult != true) {
        $erro .= " O FICHEIRO NAO FOI CARREGADO PARA O SERVIDOR-";
        $erros++;
    }else{
        img_resize("$tmp_dir/$fileName","$layoutDirectory/img/$imagem",800,600,$fileExt);
        unlink("$layoutDirectory/img/login.png");
        rename("$layoutDirectory/img/$imagem","$layoutDirectory/img/login.png");
        unlink("$tmp_dir/$fileName");
    }


    if ($erros == 0) {
        criarLog($db,"_conf_cliente","id_conf",$id,"Alterou imagem de fundo do login.",null);
        $location = "alterar_login.php?cod=1&";
    } else {
        $erro .= " Falta de dados para processar pedido.";
        $location = "alterar_login.php?cod=2&erro=$erro";
    }
    header("location: $location");
}
$content = str_replace('_status_', $status, $content);
include "../_autoData.php";