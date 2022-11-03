<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 12/04/2018
 * Time: 10:41
 */

include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

if(isset($_POST['id_pasta_ficheiro']) && isset($_POST['tipo']) & isset($_POST['nome_pasta_ficheiro'])){
    $db=ligarBD("ajax");

    $nome_pasta_ficheiro=$db->escape_string($_POST['nome_pasta_ficheiro']);
    $id_pasta_ficheiro=$db->escape_string($_POST['id_pasta_ficheiro']);
    $tipo=$db->escape_string($_POST['tipo']);

    if($tipo=='pasta'){
        $tabela="pastas";
        $coluna="pasta";
    }else{
        $tabela="pastas_ficheiros";
        $coluna="ficheiro";
    }

    $ok=0;
    while($ok==0){
        $sql="select nome_$coluna from $tabela where nome_$coluna='$nome_pasta_ficheiro'";
        $result=runQ($sql,$db,"renomear");
        if($result->num_rows==0){
            $ok=1;
        }else{
            while ($row = $result->fetch_assoc()) {
                $nome_pasta_ficheiro.=" (Cópia)";
            }
        }
    }

    if(strlen($nome_pasta)>200){
        $nome_pasta=substr($nome_pasta, 0, 200)."_RAND".rand(1,1000);
    }

    $sql="update $tabela set nome_$coluna='$nome_pasta_ficheiro' where id_$coluna='$id_pasta_ficheiro'";
    $result=runQ($sql,$db,0);
    $db->close();

    print 0;
}