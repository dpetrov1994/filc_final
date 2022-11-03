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


        // TIPO DE PAGAMENTO (DINHEIRO OU TRANSFERENCIA)
        $content = str_replace('class="tipo_pagamento_restante" value="'.$row['tipo_pagamento_restante'].'"', 'class="tipo_pagamento_restante" selected value="'.$row['tipo_pagamento_restante'].'"',$content);


        include ("_criar_editar_detalhes.php");

        /**FIM Preenchimento dos itens do formulário **/

        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);
    }

    /**Preenchimento dos itens do formulário **/

    //

    /**FIM Preenchimento dos itens do formulário **/

    if (isset($_POST['submit'])) {
        $return=colunas_valores_editar($_POST,$db,$itensIgnorar,$itensObrigatorios);
        $colunas_e_valores=$return['colunas_e_valores'];
        $erros=$return['erros'];

        /**Validação de itens adicionais**/

        //

        /**FIM validação de itens adicionais**/

        if ($erros == "") {
            $sql = "update $nomeTabela set $colunas_e_valores,updated_at='" . current_timestamp . "',id_editou='" . $_SESSION['id_utilizador'] . "' where id_$nomeColuna=$id";
            $result = runQ($sql, $db, "UPDATE");
            $insert_id=$id;
            /**Operações adicionais que necessitem do $id **/

            $dir="../_contents/$nomeTabela";
            if(!is_dir($dir)){
                mkdir($dir);
            }
            $dir="../_contents/$nomeTabela/$id";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            if(isset($_POST['eliminar'])){
                foreach ($_POST['eliminar'] as $e) {
                    @unlink("$dir/$e");
                }
            }

            moverFicheiros("../.tmp/".$_SESSION['id_utilizador'],$dir);

            $sql="delete from orcamentos_linhas where id_orcamento='$id'";
            $result=runQ($sql,$db,"eliminar linhas do orcamento");
            if(isset($_POST['nome_produto'])){
                if(is_array($_POST['nome_produto'])){
                    foreach ($_POST['nome_produto'] as $key => $value){

                        if($_POST['nome_produto'][$key]!=""){
                            $e=array();

                            $e['nome_produto']=$db->escape_string($_POST['nome_produto'][$key]);
                            $e['quantidade']=$db->escape_string($_POST['quantidade'][$key]);
                            $e['preco_sem_iva']=$db->escape_string($_POST['preco_sem_iva'][$key]);
                            $e['percentagem_iva']=$db->escape_string($_POST['percentagem_iva'][$key]);
                            $e['valor_iva']=$db->escape_string($_POST['valor_iva'][$key]);
                            $e['valor_liquido']=$db->escape_string($_POST['valor_liquido'][$key]);
                            $e['desconto']=$db->escape_string($_POST['desconto'][$key]);


                          /*  $insert_cols="";
                            $insert_vals="";
                            foreach ($e as $col=>$val){
                                $insert_cols.="$col,";
                                $insert_vals.="'$val',";
                            }
                            $insert_cols=substr($insert_cols, 0, -1);
                            $insert_vals=substr($insert_vals, 0, -1);

                            $sql="select * from produtos where nome_produto='".$e['nome_produto']."'";
                            $result=runQ($sql,$db,"verificar se o produto existe");
                            if($result->num_rows==0){
                                $sql="insert into produtos ($insert_cols) values ($insert_vals)";
                                $result=runQ($sql,$db,"inserir o produto");
                                $e['id_produto']=$db->insert_id;
                            }else{
                                while ($row = $result->fetch_assoc()) {
                                    $e['id_produto']=$row['id_produto'];
                                }
                            }*/

                            $sql="select * from produtos where nome_produto='".$e['nome_produto']."'";
                            $result=runQ($sql,$db,"verificar se o produto existe");
                            if($result->num_rows>0){
                                while ($row = $result->fetch_assoc()) {
                                    $e['id_produto']=$row['id_produto'];
                                }
                            }

                            $e['id_orcamento']=$insert_id;

                            $insert_cols="";
                            $insert_vals="";
                            foreach ($e as $col=>$val){
                                $insert_cols.="$col,";
                                $insert_vals.="'$val',";
                            }
                            $insert_cols=substr($insert_cols, 0, -1);
                            $insert_vals=substr($insert_vals, 0, -1);

                            $sql="insert into orcamentos_linhas ($insert_cols) values ($insert_vals)";
                            $result=runQ($sql,$db,"inserir as linhas do orçamento");
                        }


                    }
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

