<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");
$tem_nao_concluidas=0;
if(isset($_GET['id_assistencia_cliente'])){
    $id_assistencia_cliente=$db->escape_string($_GET['id_assistencia_cliente']);
    // GET ID DO CLIENTE
    $maquinas_cliente_linhas = getInfoTabela('assistencias_clientes_maquinas',
        " and id_assistencia_cliente ='$id_assistencia_cliente' and assistencias_clientes_maquinas.ativo=1 ");
    foreach($maquinas_cliente_linhas as $maquina_cliente_linha){
        if($maquina_cliente_linha['concluido']==0){
            $tem_nao_concluidas=1;
        }
    }

}
print $tem_nao_concluidas;

$db->close();