<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");
if (!empty($_FILES) && isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name']!="") {

    $fileSize = $_FILES["file"]["size"];
    if($fileSize<($cfg_tamanhoMaxUpload*1000*100)) {
        $ds = DIRECTORY_SEPARATOR;

        $storeFolder="../_contents/docs/".$_GET['nif'];

        if (!is_dir($storeFolder)) {
            mkdir($storeFolder);
        }

        $tempFile = $_FILES['file']['tmp_name'];          //3
        $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;  //4
        $targetFile = $targetPath . normalizeString(tirarAcentos($_FILES['file']['name']));  //5

        if(move_uploaded_file($tempFile, $targetFile)){
            if(is_image($targetFile)){
                $dadosImagem=getimagesize($targetFile);
                $w=$dadosImagem[0];
                $h=$dadosImagem[1];

                $max_w=1920;
                $max_h=80000;

                if( ($w>$max_w || $w==$max_w)  || ($h>$max_h || $h==$max_h)){
                    $ext=explode(".",$targetFile);
                    $ext=strtolower(end($ext));
                    if($ext=='png'){
                        resizeTransparent("$targetFile","$targetFile",$max_w,$max_h);
                    }else{
                        img_resize("$targetFile","$targetFile",$max_w,$max_h,$ext);
                    }
                }
            }
            @unlink($tempFile);
        }
    }else{
        print "Tamanho do fichiero tem de ser inferior a $cfg_tamanhoMaxUpload MB";
    }
}