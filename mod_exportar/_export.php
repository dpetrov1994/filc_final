<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 06/07/2018
 * Time: 14:58
 */

include("../login/valida.php");
include("../conf/mysql.php");
include("../_funcoes.php");

$db=ligarBD("export");
if(isset($_POST['tabela'])&&isset($_POST['formato'])){

    $tabela=$db->escape_string($_POST['tabela']);
    $delimitador=$db->escape_string($_POST['delimitador']);
    $formato=$db->escape_string($_POST['formato']);

    if($formato=="csv"){
        include "_export_csv.php";
    }elseif ($formato="excel"){
        include "_export_excel.php";
    }
}



$db->close();