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

        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);
    }

    /**Preenchimento dos itens do formulário **/



    /**FIM Preenchimento dos itens do formulário **/

    if (isset($_POST['submit'])) {

        if($_POST['pings']!=""){
            $pings=json_decode($_POST['pings'],true);
            if(is_array($pings)){
                foreach ($pings as $id_utilizador => $nome_utilizador){
                    $nome_notificacao=$_SESSION['nome_utilizador']." identificou-o num comentário";
                    $nome_tabela="srv_clientes";
                    $nome_coluna="PartyID";
                    $id_item=$db->escape_string($_POST['id_item']);
                    $url_destino="https://$domain/mod_srvcliente/detalhes.php?id=$id_item";
                    $destinatarios=[$id_utilizador];
                    notificar($db,$nome_notificacao,$nome_tabela,$nome_coluna,$id_item,$url_destino,$destinatarios);
                }
            }
        }

        if($_POST['modulo']=='srv_clientes'){
            $id_cliente=$db->escape_string($_POST['id_item']);
            $sql="select FederalTaxID from srv_clientes where PartyID='$id_cliente'";
            $result=runQ($sql,$db,"SELECT INSERTED");
            while ($row = $result->fetch_assoc()) {
                $_POST['id_item']=$row['FederalTaxID'];
                $_POST['FederalTaxID']=$row['FederalTaxID'];
            }
        }

        $return=colunas_valores_editar($_POST,$db,$itensIgnorar,$itensObrigatorios);
        $colunas_e_valores=$return['colunas_e_valores'];
        $erros=$return['erros'];

        /**Validação de itens adicionais**/

        //

        /**FIM validação de itens adicionais**/

        if ($erros == "") {
            $sql = "update $nomeTabela set $colunas_e_valores,updated_at='" . current_timestamp . "',id_editou='" . $_SESSION['id_utilizador'] . "' where id_$nomeColuna=$id";
            $result = runQ($sql, $db, "UPDATE");

            /**Operações adicionais que necessitem do $id **/


            $dir="../_contents/$nomeTabela";
            if(!is_dir($dir)){
                mkdir($dir);
            }
            $dir="../_contents/$nomeTabela/$id";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            $anexos_para_apagar=explode(",",$_POST['anexos_para_apagar']);
            if(is_array($anexos_para_apagar)){
                foreach ($anexos_para_apagar as $anexo){
                    @unlink($dir."/".$anexo);
                }
            }

            moverFicheiros("../.tmp/".$_SESSION['id_utilizador'],$dir);

            /**FIM perações adicionais que necessitem do $id **/

            selectForLog($db,$nomeTabela,$nomeColuna,$id);


            if(isset($_POST['return_comentario'])){

                $comentarios=getComentarios2($_POST['modulo'],$_POST['id_item'],$id);
                $comentario=$comentarios[0];
                $comentario = (object)$comentario;
                print (json_encode($comentario));
                $db->close();
                die();
            }

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

