<?php
include("../_funcoes.php");

ini_set('max_execution_time', 6000);
ini_set('memory_limit', '1024M');

$_GET['dir']="../_contents";

if(isset($_GET['dir'])){
    $ds = DIRECTORY_SEPARATOR;
    $dir=$_GET['dir'];
    $storeFolder = $dir;


    if(isset($_GET['completo'])){
        if(!is_dir("../_backups/")){
            mkdir("../_backups/");
        }
        $download = "../_backups/_backup_completo_".date("Y-m-d_H-i-s").".zip";
        if(isset($_GET['restauro'])){
            $download = "../_backups/_restauro_".date("Y-m-d_H-i-s").".zip";
        }
    }else{
        $download = "../_backups/_backup_contents_".date("Y-m-d_H-i-s").".zip";
    }

    ini_set('max_execution_time', 6000);
    ini_set('memory_limit', '1024M');

    zipData($dir, $download);

    if(is_dir("../_contents/_backup_bd")){
        $ficheiros=mostraFicheiros("../_contents/_backup_bd");
        foreach ($ficheiros as $ficheiro){
            unlink("../_contents/_backup_bd/$ficheiro");
        }
        rrmdir("../_contents/_backup_bd");
    }

    echo $download;
}




