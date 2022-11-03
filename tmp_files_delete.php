<?php
include ("_funcoes.php");
include ("conf/dados_plataforma.php");
include ("login/valida.php");
print_r($_GET);
if (isset($_GET['nome'])) {

        $ds = DIRECTORY_SEPARATOR;

        $storeFolder = ".tmp/".$_SESSION['id_utilizador'];

        if (!is_dir($storeFolder)) {
            mkdir($storeFolder);
        }

        $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;  //4

        $targetFile = $targetPath . normalizeString(tirarAcentos($_GET['nome']));  //5

        unlink($targetFile); //6
}