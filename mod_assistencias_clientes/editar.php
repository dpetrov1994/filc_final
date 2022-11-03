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
        $row['idCliente']=$row['id_cliente'];

        $row['tempoServico']=date("H:i",($row['tempo_assistencia']));
        $row['tempoOferta']=date("H:i",($row['tempo_oferta']));
        $row['tempoViagem']=date("H:i",($row['tempo_viagem']));
        $row['tempoPausa']=date("H:i",($row['segundos_pausa']));
        $row['tempoContabilizar']=date("H:i",($row['tempo_contabilizar']));

        $pdf="";
        if(is_dir('../_contents/assistencias_clientes_pdfs/'.$id)){
            $pdf = array_diff(scandir('../_contents/assistencias_clientes_pdfs/'.$id, 1), array('..', '.'));
        }

        if(file_exists('../_contents/assistencias_clientes_pdfs/'.$id.'/'.$pdf[0])){
            $content=str_replace('_nomepdf_',$pdf[0],$content);
        }

        if($row['latitude']==""){
            $row['latitude']=0;
        }
        if($row['longitude']==""){
            $row['longitude']=0;
        }

        $script='
        <script>
                var markers=[
                    {latitude:'.$row['latitude'].', longitude:'.$row['longitude'].', popup:"Assinado neste local.",open:0}
                ];
            
                var options={
                    zoom:14,
                    center: {latitude:'.$row['latitude'].', longitude:'.$row['longitude'].'}
                };
                initMap(markers,options,true);
            </script>
        ';

        $content=str_replace('_datainicio_',$row['data_inicio'],$content);
        $content=str_replace('_datafim_',$row['data_fim'],$content);

        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);
    }

    /**Preenchimento dos itens do formulário **/

    //

    /**FIM Preenchimento dos itens do formulário **/



    if (isset($_POST['submit'])) {

        $_POST['tempo_assistencia']=strtotime($_POST['data_fim'])-strtotime($_POST['data_inicio']);
        $_POST['tempo_viagem']=timeToSeconts($_POST['tempo_viagem']);
        $_POST['segundos_pausa']=timeToSeconts($_POST['segundos_pausa']);
        $_POST['tempo_contabilizar']=incrementarTempo($_POST['tempo_assistencia']+$_POST['tempo_viagem']-$_POST['segundos_pausa']);


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

            GerarPdfAssistencia($id);

            /**FIM perações adicionais que necessitem do $id **/

            selectForLog($db,$nomeTabela,$nomeColuna,$id);
            $location = "editar.php$addUrl&cod=1";
        } else {
            $erros .= " Falta de dados para processar pedido.";
            $location = "editar.php$addUrl&cod=2&erro=$erros";
        }
        header("location: $location");
    }

    $pageScript = '<script src="editar.js"></script>'.$script;
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include('../_autoData.php');

