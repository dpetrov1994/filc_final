<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("criar.tpl");

//Preenchimento dos itens do formulário

$sql="select * from grupos where 1 and ativo=1 order by nome_grupo asc";
$result=runQ($sql,$db,"preenchimento de formulario");
$ops="";
while ($row = $result->fetch_assoc()) {
    $ops.="<option value='".$row['id_grupo']."'>".$row['nome_grupo']."</option>";
}
$content=str_replace("_grupos_",$ops,$content);

//FIM Preenchimento dos itens do formulário


if(isset($_POST['submit'])){
    $erros="";
    $colunas="";
    $valores="";
    $scripts="";
    foreach($_POST as $coluna =>$valor){
        if(!is_array($valor)){
            if(!in_array($coluna, $itensIgnorar)) {
                if(in_array($coluna, $itensObrigatorios) && $valor=="") {
                    $erros.=" Falta $coluna,";
                }else{
                    if(is_data_portuguesa($valor)){
                        $valor=data_portuguesa($valor);
                    }
                    $valor=$db->escape_string($valor);
                    $colunas.="$coluna,";
                    $valores.="'$valor',";
                }
            }
        }
    }

    if($subModulo==1){
        $colunas.="id_$colunaParent,";
        $valores.="$idParent,";
    }

    $colunas=substr($colunas, 0, -1)."";
    $valores=substr($valores, 0, -1)."";

    //Validação de itens adicionais



    //FIM validação de itens adicionais

    if($erros==""){
        $sql="insert into $nomeTabela ($colunas,id_criou,created_at) values ($valores,'".$_SESSION['id_utilizador']."','".current_timestamp."')";
        $result=runQ($sql,$db,"INSERT");
        $insert_id=$db->insert_id;

        //Operações adicionais que necessitem do $insert_id

        foreach ($_POST['grupos'] as $id_grupo){
            $sql="insert into grupos_modulos_funcionalidades (id_grupo, id_funcionalidade, id_modulo) values ('$id_grupo','$insert_id',$id)";
            $result=runQ($sql,$db,"INSERT N-N");
        }

        //FIM perações adicionais que necessitem do $insert_id

        $sql="select * from $nomeTabela where id_$nomeColuna = $insert_id";
        $result=runQ($sql,$db,"SELECT INSERTED");
        while ($row = $result->fetch_assoc()) {
            $array_log=json_encode($row);
            criarLog($db,$nomeTabela,"id_$nomeColuna",$insert_id,"Criar",$array_log);
        }

        $location="editar.php?$addUrl&cod=3";
        if($subModulo==0){
            $location.="&id=$insert_id";
        }else{
            $location.="&subItemID=$insert_id";
        }
        unset($_SESSION['modulos']);

    }else{
        $erros.=" Falta de dados para processar pedido.";
        $location="criar.php$addUrl&cod=2&erro=$erros";
    }
    header("location: $location");
}
$pageScript='<script src="criar.js"></script>';
include ('../_autoData.php');