<?php

include_once("../_funcoes.php");
include_once("../conf/dados_plataforma.php");

$cfg_nome_funcionalidade="Marcar um serviço";
$layoutDirectory="../assets/layout/";
$layout=file_get_contents("$layoutDirectory/public.tpl");

if(isset($_GET['hash'])){
    $db=ligarBD();



    $content=file_get_contents("marcacao.tpl");

    $id_cliente=decryptData($_GET['hash']);

    //guardar feedback
    if(isset($_POST['submit'])){

        $_POST['descricao'].="\r\n(Submetido por cliente)";

        $return=colunas_valores_criar($_POST,$db,['submit'],[],0,"",0);
        $erros=$return['erros'];
        $colunas=$return['colunas'];
        $valores=$return['valores'];

        $nomeTabela="assistencias";
        $nomeColuna="assistencia";

        $sql="insert into $nomeTabela ($colunas,id_criou,created_at) values ($valores,'0','".current_timestamp."')";
        $result=runQ($sql,$db,"INSERT");
        $insert_id=$db->insert_id;

        $sql="select * from $nomeTabela where id_$nomeColuna = $insert_id";
        $result=runQ($sql,$db,"SELECT INSERTED");
        while ($row = $result->fetch_assoc()) {
            $array_log=json_encode($row);
            criarLog($db,$nomeTabela,"id_$nomeColuna",$insert_id,"Marcação submetido por cliente",$array_log);
        }

        header("location: ?obrigado");
    }


    $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$id_cliente.'"');
    if(isset($cliente[0])){
        $content=str_replace("_id_cliente_",$id_cliente,$content);
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