<?php
include ("_funcoes.php");
include ("conf/dados_plataforma.php");
include ("login/valida.php");
if (isset($_GET['id_distrito'])) {
    $concelhos=json_decode(file_get_contents("assets/dados_json/concelhos.json"),true);
    $ops="<option></option>";
    foreach ($concelhos as $concelho){
        if($concelho['cod_distrito']==$_GET['id_distrito']){
            $id_concelho=$concelho['cod_concelho'];
            $nome_concelho=$concelho['nome_concelho'];
            $ops.="<option value='$id_concelho'>$nome_concelho</option>";
        }
    }
    print $ops;
}