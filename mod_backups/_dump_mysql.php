<?php
include("../login/valida.php");
include("../conf/mysql.php");
include("../_funcoes.php");
include('../assets/dumper.php');

ini_set('max_execution_time', 6000);
ini_set('memory_limit', '1024M');

try {
    $world_dumper = Shuttle_Dumper::create(array(
        'host' => $mySrv,
        'username' => $myUser,
        'password' => $myPw,
        'db_name' => $myBD,
    ));
    $dir="../_backups/";
    if(!is_dir($dir)){
        mkdir($dir);
    }
    $file_name="_backup_BD_".date("Y-m-d_H-i-s").".sql";
    $world_dumper->dump($dir.$file_name);

    $contents = file_get_contents($dir.$file_name);

    $handle = fopen($dir.$file_name, "w");
    fwrite($handle, $contents);
    fclose($handle);

    if(isset($_GET['mover'])){
        if(!is_dir("../_contents/_backup_bd")){
            mkdir("../_contents/_backup_bd");
        }
        copy($dir.$file_name,"../_contents/_backup_bd/"."_backup_BD.sql");
        unlink($dir.$file_name);

        print "_backup_BD.sql";
    }else{
        print $dir.$file_name;
    }

} catch(Shuttle_Exception $e) {
    echo "Couldn't dump database: " . $e->getMessage();
}