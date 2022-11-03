<?php

include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("editar.tpl");
$content=str_replace("_idItem_",$id,$content);
$sql="select * from $nomeTabela where id_$nomeColuna='$id'";
$result=runQ($sql,$db,"SELECT AND FILL");
if($result->num_rows!=0) {
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $key => $value) {
            if (is_date($value)) {
                $value = strftime("%d/%m/%Y", strtotime($value));
            }

            if ($value == 1) { // para itens com cheked [ATENCAO: O NOME tem de vir antes do ID]
                $content = str_replace('name="' . $key . '" id="' . $key . '"', 'name="' . $key . '" id="' . $key . '" checked=""', $content);
            }

            // PREENCHER OS CAMPOS NORMAILS [ATENCAO: O ID tem de vir antes do NOME]
            $content = str_replace('id="' . $key . '" name="' . $key . '"', 'id="' . $key . '" name="' . $key . '" value="' . $value . '"', $content);

        }
        $content = str_replace("_descricao_", $row['descricao'], $content);
    }

    //Preenchimento dos itens do formulário

    $sql = "select * from grupos where 1 and ativo=1 order by nome_grupo asc";
    $result = runQ($sql, $db, "preenchimento de formulario");
    $ops = "";
    while ($row = $result->fetch_assoc()) {
        $selected = "";

        $sql0="select * from grupos_modulos_funcionalidades where id_funcionalidade='$id'";
        $result0 = runQ($sql0, $db, "preenchimento de formulario");
        while ($row0 = $result0->fetch_assoc()) {
            if($row0['id_grupo']==$row['id_grupo']){
                $selected="selected";
            }
        }

        $ops .= "<option $selected value='" . $row['id_grupo'] . "'>" . $row['nome_grupo'] . "</option>";
    }
    $content = str_replace("_grupos_", $ops, $content);

    //FIM Preenchimento dos itens do formulário

    if (isset($_POST['submit'])) {
        $return=colunas_valores_editar($_POST,$db,$itensIgnorar,$itensObrigatorios);
        $colunas_e_valores=$return['colunas_e_valores'];
        $erros=$return['erros'];

        if ($erros == "") {
            $sql = "update $nomeTabela set $colunas_e_valores,updated_at='" . current_timestamp . "',id_editou='" . $_SESSION['id_utilizador'] . "' where id_$nomeColuna=$id";
            $result = runQ($sql, $db, "UPDATE");
            $sql = "select * from $nomeTabela where id_$nomeColuna = $id";

            //operaçõies adicionais que requerem o $Id

            $sql="delete from grupos_modulos_funcionalidades where id_funcionalidade =$id";
            $result = runQ($sql, $db, "DELETE N-N");

            foreach ($_POST['grupos'] as $id_grupo){
                $sql="insert into grupos_modulos_funcionalidades (id_grupo, id_funcionalidade, id_modulo) values ('$id_grupo','$id',$idParent)";
                $result=runQ($sql,$db,"INSERT N-N");
            }

            //FIM operaçõies adicionais que requerem o $Id

            selectForLog($db,$nomeTabela,$nomeColuna,$id);
            $location = "editar.php$addUrl&cod=1";

            unset($_SESSION['modulos']);
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

