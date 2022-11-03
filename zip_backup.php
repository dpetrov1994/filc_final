<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 05/07/2018
 * Time: 19:43
 */
include("_funcoes.php");
$download = ".tmp/backup.zip";

ini_set('max_execution_time', 600);
ini_set('memory_limit', '1024M');

zipData("_contents/", $download);