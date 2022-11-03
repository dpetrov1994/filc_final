<?php

include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("editar.tpl");
$content=str_replace("_idItem_",$id,$content);
$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"SELECT AND FILL");
if($result->num_rows!=0) {
    while ($row = $result->fetch_assoc()) {

        /**Preenchimento dos itens do formulário **/

        include ("_criar_editar_detalhes.php");

        /**FIM Preenchimento dos itens do formulário **/

        $foto="../_contents/produtos/".$id."/".$row['foto'];
        if(!is_file($foto)){
            $foto="../assets/layout/img/placeholder.png";
        }
        $f=$row['foto'];
        $content=str_replace("_foto_",$foto,$content);

        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);
    }

    /**Preenchimento dos itens do formulário **/

    //

    /**FIM Preenchimento dos itens do formulário **/

    if (isset($_POST['submit'])) {

        if(isset($_FILES['file'])) {
            $_POST['foto'] = carregar_foto($_FILES['file'], $cfg_tamanhoMaxUpload);
            if ($_POST['foto'] == "") {
                $_POST['foto'] = $f;
            }
        }

        $return=colunas_valores_editar($_POST,$db,$itensIgnorar,$itensObrigatorios);
        $colunas_e_valores=$return['colunas_e_valores'];
        $erros=$return['erros'];

        /**Validação de itens adicionais**/

        /**FIM validação de itens adicionais**/

        if ($erros == "") {
            $sql = "update $nomeTabela set $colunas_e_valores,updated_at='" . current_timestamp . "',id_editou='" . $_SESSION['id_utilizador'] . "' where id_$nomeColuna=$id";
            $result = runQ($sql, $db, "UPDATE");

            /**Operações adicionais que necessitem do $id **/

            $dir="../_contents/produtos/$id";
            create_dir($dir);

            if($_POST['foto']!="" && $_POST['foto']!=$f){
                copy("../.tmp/".$_SESSION['id_utilizador']."/".$_POST['foto'],"$dir/".$_POST['foto']);
                unlink("../.tmp/".$_SESSION['id_utilizador']."/".$_POST['foto']);

                if($foto!="../assets/layout/img/placeholder.png"){
                    unlink($foto);
                }
            }

            /**FIM perações adicionais que necessitem do $id **/

            selectForLog($db,$nomeTabela,$nomeColuna,$id);
            $location = "editar.php$addUrl&cod=1";
        } else {
            $erros .= " Falta de dados para processar pedido.";
            $location = "editar.php$addUrl&cod=2&erro=$erros";
        }
        header("location: $location");
    }

    $pageScript = '<script src="editar.js"></script>';
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include('../_autoData.php');

