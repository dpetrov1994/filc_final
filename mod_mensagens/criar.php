<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("criar.tpl");
$content=str_replace("_descricao_","",$content);


if(isset($criar_avancado)){
    $content=str_replace("_para_",$selecionarDestinatarios,$content);
    $content=str_replace("_formAction_","criar_avancado.php",$content);
}else{
    $content=str_replace("_para_","<div class=\"form-group form-group-sm\">
                                                    <div class=\"col-xs-12\">
                                                        <label class=\"col-lg-12\" >Para:</label>
                                                        <div class=\"col-lg-12 input-status\">
                                                            <select id=\"utilizadores\" multiple name=\"utilizadores[]\" required class=\"select-select2\" data-placeholder=\"Selecione..\" style=\"width: 100%;\">
                                                                <option></option>
                                                                _utilizadores_
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>",$content);
    $content=str_replace("_formAction_","criar.php",$content);
}


/**Preenchimento dos itens do formulário **/

include ("_criar_editar_detalhes.php");

/**FIM Preenchimento dos itens do formulário **/


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

    /**Validação de itens adicionais**/


    /**FIM validação de itens adicionais**/

    if($erros==""){
        $sql="insert into $nomeTabela ($colunas,id_criou,created_at) values ($valores,'".$_SESSION['id_utilizador']."','".current_timestamp."')";
        $result=runQ($sql,$db,"INSERT");
        $insert_id=$db->insert_id;

        /**Operações adicionais que necessitem do $insert_id **/

        foreach ($_POST['utilizadores'] as $id_utilizador){
            if($id_utilizador!=$_SESSION['id_utilizador']){
                $sql="insert into utilizadores_mensagens (id_utilizador, id_mensagem)  VALUES ('$id_utilizador','$insert_id')";
                $result=runQ($sql,$db,"INSERT utilizadores_mensagens");
            }
        }

        $de="../.tmp/".$_SESSION['id_utilizador'];
        $para="../_contents/anexos_mensagens";
        if(!is_dir($para)){
            mkdir($para);
        }
        $para.="/$insert_id";
        if(!is_dir($para)){
            mkdir($para);
        }

        moverFicheiros($de,$para);

        //enviar Notificações
        $url_notificacao=str_replace("criar.php","abrir.php?id=$insert_id",urlAtual);
        notificar(
            "Nova mensagem de ".cortaNome($_SESSION['nome_utilizador']),
            "mensagens",
            "mensagem",
            $insert_id, //ID
            $url_notificacao, //URL
            [], //NOTIFICAR UTILIZADORES
            $_POST['utilizadores'], //IDS PARA ENVIAR EMAIL
            "<b>Nova mensagem de ".cortaNome($_SESSION['nome_utilizador']).":</b><br><br>".nl2br($_POST['descricao']). "<br><br>Para ver os <b style='color:#7f0001'>anexos</b> ou <b style='color:#7f0001'>responder</b>, inicie sessão na nossa plataforma ou visite: <a href='$url_notificacao'>$url_notificacao</a>");

        /**FIM perações adicionais que necessitem do $insert_id **/

        $sql="select * from $nomeTabela where id_$nomeColuna = $insert_id";
        $result=runQ($sql,$db,"SELECT INSERTED");
        while ($row = $result->fetch_assoc()) {
            $array_log=json_encode($row);
            criarLog($db,$nomeTabela,"id_$nomeColuna",$insert_id,"Criar",$array_log);
        }


        $location = "enviadas.php?$addUrl&cod=1";

        if($subModulo==0){
            $location.="&id=$insert_id";
        }else{
            $location.="&subItemID=$insert_id";
        }


    }else{
        $erros.=" Falta de dados para processar pedido.";
        $location="criar.php$addUrl&cod=2&erro=$erros";
    }
    header("location: $location");
}
$pageScript='<script src="criar.js"></script>';
include ('../_autoData.php');