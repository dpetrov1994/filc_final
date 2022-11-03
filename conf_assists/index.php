<?php

include ('../_template.php');
$content=file_get_contents("index.tpl");

$sql_preencher="select * from utilizadores where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {

    $ops.="<option class='id_utilizador_notificar' value='".$row_preencher["id_utilizador"]."'>".$row_preencher["nome_utilizador"]."</option>";
}
$content=str_replace("_id_utilizador_notificar_",$ops,$content);

$sql_preencher="SELECT distinct(TransDocument) as tipo FROM srv_clientes_saletransaction WHERE 1 order by TransDocument asc ";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {

    $ops.="<option class='documentos_fac' value='".$row_preencher["tipo"]."'>".$row_preencher["tipo"]."</option>";
}
$content=str_replace("_documentos_fac_",$ops,$content);

$sql_preencher="SELECT distinct(TransDocument) as tipo FROM srv_clientes_saletransaction WHERE 1 order by TransDocument asc ";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {

    $ops.="<option class='documentos_nc' value='".$row_preencher["tipo"]."'>".$row_preencher["tipo"]."</option>";
}
$content=str_replace("_documentos_nc_",$ops,$content);


$ops="";
foreach ($cfg_diasdasemana as $cod=>$value){
    $ops.="<option class='_dia_semana_viaturas_' value='".$cod."'>".$value."</option>";
}
$content=str_replace("_dia_semana_viaturas_",$ops,$content);

$id=1;
$nomeTabela="_conf_assists";
$nomeColuna="conf";
$content=str_replace("_idItem_",$id,$content);
$sql="select * from _conf_assists where id_conf='$id'";
$result=runQ($sql,$db,"SELECT AND FILL");
if($result->num_rows!=0) {
    while ($row = $result->fetch_assoc()) {

        $row['documentos_fac']=json_decode($row['documentos_fac']);
        $row['documentos_nc']=json_decode($row['documentos_nc']);
        if(is_array($row['documentos_fac'])){
            foreach ($row['documentos_fac'] as $doc){
                $content = str_replace("class='documentos_fac' value='" . $doc . "'", "class='documentos_fac' value='" . $doc . "' selected", $content);
            }
        }
        if(is_array($row['documentos_nc'])){
            foreach ($row['documentos_nc'] as $doc){
                $content = str_replace("class='documentos_nc' value='" . $doc . "'", "class='documentos_nc' value='" . $doc . "' selected", $content);
            }
        }



        foreach($row as $key => $value){
            if(!is_array($value)) {

                $arr = json_decode($value, true);
                if(is_array($arr) && count($arr) > 0) {
                    foreach($arr as $val) {

                        $val = str_replace('"', "&quot;", $val);
                        $val = str_replace("'", "&apos;", $val);
                        $content = str_replace("name='" . $key . "[]' value='" . $val . "'", "name='" . $key . "[]' value='" . $val . "' checked", $content);
                        $content = str_replace("class='" . $key . "' value='" . $val . "'", "class='" . $key . "' value='" . $val . "' selected", $content);
                    }
                }
                $value = str_replace('"', "&quot;", $value);
                $value = str_replace("'", "&apos;", $value);


                if($value == 1) { // para itens com cheked [ATENCAO: O NOME tem de vir antes do ID]
                    $content = str_replace('name="' . $key . '" id="' . $key . '"', 'name="' . $key . '" id="' . $key . '" checked=""', $content);
                }

                // PREENCHER OS CAMPOS NORMAILS [ATENCAO: O ID tem de vir antes do NOME]
                $content = str_replace('id="' . $key . '" name="' . $key . '"', 'id="' . $key . '" name="' . $key . '" value="' . $value . '"', $content);

                // PREENCHER OS SELECTS AUTOMATICOS
                $content = str_replace("class='" . $key . "' value='" . $value . "'", "class='" . $key . "' value='" . $value . "' selected", $content);

                $content = str_replace("_" . $key . "_", $value, $content);
            }
        }

        $content=str_replace('_descricao_', "",$content);

    }

    /**Preenchimento dos itens do formulário **/

    //

    /**FIM Preenchimento dos itens do formulário **/

    if (isset($_POST['submit'])) {


        unset($_POST['submit']);

        $_POST['documentos_fac']=json_encode($_POST['documentos_fac']);
        $_POST['documentos_nc']=json_encode($_POST['documentos_nc']);

        $itensIgnorar=[];
        $itensObrigatorios=[];
        $return=colunas_valores_editar($_POST,$db,$itensIgnorar,$itensObrigatorios);
        $colunas_e_valores=$return['colunas_e_valores'];
        $erros=$return['erros'];

        /**Validação de itens adicionais**/

        //

        /**FIM validação de itens adicionais**/

        if ($erros == "") {
            $sql = "update $nomeTabela set $colunas_e_valores,updated_at='" . current_timestamp . "',id_editou='" . $_SESSION['id_utilizador'] . "' where id_$nomeColuna=$id";

            $result = runQ($sql, $db, "UPDATE");

            selectForLog($db,$nomeTabela,$nomeColuna,$id);
            $location = "index.php$addUrl&cod=1";
        } else {
            $erros .= " Falta de dados para processar pedido.";
            $location = "index.php$addUrl&cod=2&erro=$erros";
        }
        header("location: $location");
    }

    $pageScript = '';
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include('../_autoData.php');

