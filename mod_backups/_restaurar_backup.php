<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 06/07/2018
 * Time: 10:45
 */

include("../login/valida.php");
include("../conf/mysql.php");
include("../_funcoes.php");

if(isset($_FILES['file']['tmp_name'])){

    set_time_limit(0);
    ini_set('memory_limit', '1024M');

    //print_r($_FILES);
    //print_r($_POST);

    $tmp="../.tmp";
    $tmp_loc=$_FILES['file']['tmp_name'];
    $file_name=$_FILES['file']['name'];
    $ext=explode(".",$file_name);
    $ext=$ext[1];
    if($ext=="bak"){
        $file_name=str_replace(".bak",".zip",$file_name);
    }
    move_uploaded_file($_FILES['file']['tmp_name'],$tmp."/".$file_name);
    //print "ficheiro movido\r\n";

    if(!is_dir("$tmp/restauro")){
        mkdir("$tmp/restauro");
    }

    //print "criado dir para extrarir (\"$tmp/restauro\")\r\n";

    $zip = new ZipArchive;
    if ($zip->open($tmp."/".$file_name) === TRUE) {
        $zip->extractTo("$tmp/restauro");
        $zip->close();
    } else {
        echo 'failed';
    }

    //print "extraido\r\n";

    if(is_file("$tmp/restauro/_backup_bd/_backup_BD.sql")){

        //print "os ficheiros $tmp/restauro/_backup_bd/chave_encriptacao.txt e $tmp/restauro/_backup_bd/_backup_BD.sql existem\r\n";

        $db=ligarBD("restauro");

        /**
         * desincriptar BD
         */
        $decryptedData=(file_get_contents("$tmp/restauro/_backup_bd/_backup_BD.sql"));
        $handle = fopen("$tmp/restauro/_backup_bd/_backup_BD.sql", "w");
        fwrite($handle, $decryptedData);
        fclose($handle);
        //print "BD desincriptada\r\n";

        /**
         * eliminar tabelas
         */
        $sql="SELECT TABLE_NAME
        FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = '$myBD'";
        $result=runQ($sql,$db,"lista de tabelas");
        while ($row = $result->fetch_assoc()) {
            $sql2="drop table ".$row['TABLE_NAME'];
            $result2=runQ($sql2,$db,"eliminar tabelas - $sql2");
        }
        //print "eliminadas as tabelas da BD\r\n";


        /**
         * importar .sql
         */
        $templine="";
        // Read in entire file
        $fp = fopen("$tmp/restauro/_backup_bd/_backup_BD.sql", 'r');
        // Loop through each line
        while (($line = fgets($fp)) !== false) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                $result=runQ($templine,$db,"$templine\r\n");
                // Reset temp variable to empty
                $templine = '';
            }
        }
        fclose($fp);
        echo "Database imported successfully";

        /**
         * eliminar todos os conteúdos da pasta _contens e compiar os novos
         */
        rrmdir("../_contents/");
        //print "limpar _contents\r\n";

        if(!is_dir("../_contents")){
            mkdir("../_contents");
        }
        recursive_copy("$tmp/restauro/","../_contents/");
        //print "restaurar _contents\r\n";
        rrmdir("$tmp/restauro/");
        //print "eliminar restauro\r\n";
        unlink($tmp."/".$file_name);
        //print "eliminar zip\r\n";
        $db->close();
        header("location: index.php?cod=1");
    }else{
        header("location: index.php?cod=2&erro=Erro");
    }
}