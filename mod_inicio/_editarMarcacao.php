<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");

/**editar marcacao**/

$content="";
if(isset($_GET['editar_marcacao']) && $_GET['editar_marcacao']!=""){
    include "../mod_assistencias/.cfg.php";
    $content=file_get_contents("../mod_assistencias/editar.tpl");
    $content=str_replace("_idItem_",$id,$content);
    $id=$db->escape_string($_GET['editar_marcacao']);
    $sql="select * from $nomeTabela where id_$nomeColuna='$id'";
    $result=runQ($sql,$db,"SELECT AND FILL");
    if($result->num_rows!=0) {
        while ($row = $result->fetch_assoc()) {

            /**Preenchimento dos itens do formulário **/

            include("../mod_assistencias/_criar_editar_detalhes.php");

            /**FIM Preenchimento dos itens do formulário **/
            $content = str_replace("name='id_categoria' id='id_categoria' value='" . $row['id_categoria'] . "'", "name='id_categoria' id='id_categoria' checked value='" . $row['id_categoria'] . "'", $content);
            $content = str_replace('name="externa" value="' . $row['externa'] . '"', 'name="externa" checked value="' . $row['externa'] . '"', $content);

            $content=str_replace("editar.php_addUrl_","../mod_assistencias/editar.php?id=$id&to_dahsboard",$content);
            $content = replaces_no_formulario($content, $row, $nomeTabela, $nomeColuna, $db);
        }
    }
}

/**fim editar marcacao  */
echo $content;


$db->close();