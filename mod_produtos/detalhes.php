<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("detalhes.tpl");

$content=str_replace("_idItem_",$id,$content);

$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {/**Preenchimento dos itens do formulário*/

        include ("_criar_editar_detalhes.php");

        /**FIM Preenchimento dos itens do formulário*/
        $foto="../_contents/produtos/".$id."/".$row['foto'];
        if(!is_file($foto)){
            $foto="../assets/layout/img/placeholder.png";
        }
        $f=$row['foto'];
        $content=str_replace("_foto_",$foto,$content);


        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);
    }

    /**Preenchimento dos itens do formulário*/

    //

    /**FIM Preenchimento dos itens do formulário*/


    $pageScript='<script src="detalhes.js"></script>';
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include ('../_autoData.php');