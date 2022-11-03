<?php

include_once("../_funcoes.php");
include_once("../conf/dados_plataforma.php");

$cfg_nome_funcionalidade="Formulário de satisfação";
$layoutDirectory="../assets/layout/";
$layout=file_get_contents("$layoutDirectory/public.tpl");

if(isset($_GET['hash'])){
    $db=ligarBD();



    $content=file_get_contents("feedback.tpl");

    $id_assistencia_cliente=decryptData($_GET['hash']);

    $sat = getInfoTabela('assistencias_clientes_satisfacao', ' and id_assistencia_cliente = "'.$id_assistencia_cliente.'"');
    if(count($sat)>0 ){
        $content=file_get_contents("feedback_ja_tem.tpl");
    }

    //guardar feedback
    if(isset($_POST['submit'])){

        $return=colunas_valores_criar($_POST,$db,['submit'],[],0,"",0);
        $erros=$return['erros'];
        $colunas=$return['colunas'];
        $valores=$return['valores'];

        $nomeTabela="assistencias_clientes_satisfacao";
        $nomeColuna="satisfacao";

        $sql="insert into $nomeTabela ($colunas,id_criou,created_at) values ($valores,'0','".current_timestamp."')";
        $result=runQ($sql,$db,"INSERT");
        $insert_id=$db->insert_id;

        $sql="select * from $nomeTabela where id_$nomeColuna = $insert_id";
        $result=runQ($sql,$db,"SELECT INSERTED");
        while ($row = $result->fetch_assoc()) {
            $array_log=json_encode($row);
            criarLog($db,$nomeTabela,"id_$nomeColuna",$insert_id,"Feedback submetido por cliente",$array_log);
        }

        header("location: ?obrigado");
    }

    $as = getInfoTabela('assistencias_clientes', ' and id_assistencia_cliente = "'.$id_assistencia_cliente.'"');
    if(isset($as[0])){
        $as=$as[0];
        $id_cliente=$as['id_cliente'];
        $id_utilizador=$as['id_utilizador'];

        $content=str_replace("_id_cliente_",$id_cliente,$content);
        $content=str_replace("_id_utilizador_",$id_utilizador,$content);
        $content=str_replace("_id_assistencia_cliente_",$id_assistencia_cliente,$content);
        $content=str_replace("_hash_",$_GET['hash'],$content);

    }else{
        header("location: https://filc.pt/");
        die();
    }

    $db->close();
}else{

    if(isset($_GET['obrigado'])){
        $content=file_get_contents("feedback_sucesso.tpl");
    }else{
        header("location: https://filc.pt/");
        die();
    }


}



$pageScript='        <!-- Load and execute javascript code used only in this page -->
        <script src="../assets/layout/js/geral.js"></script>
        ';

include ('../_autoData.php');