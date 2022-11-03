<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents($layoutDirectory."/loading.tpl");


/**
 * acao iten único
 */
if(isset($id) && $id != 0 || isset($_POST['id']) && $_POST['id'] != "") {


    if(isset($_POST['id']) && $_POST['id'] != ""){
        $id = $db->escape_string($_POST['id']);
    }

    $id_loja = $_SESSION['id_utilizador'];
    if(isset($_POST['loja']) && $_POST['loja']!= ""){
        $id_loja = $db->escape_string($_POST['loja']);
    }


    // GET INFO UTILIZADOR QUE FECHOU O DIARIO
    $arrayOrcamento = getInfoTabela('orcamentos', 'and id_orcamento = '.$id);

    $arrayOrcamento = $arrayOrcamento[0];

    $arrayLinhas = getInfoTabela('orcamentos_linhas', " and id_orcamento = $id");

    // ORGANIZAR DADOS DO ORÇAMENTO PARA INSERIR NAS VENDAS

     // INSERIR NA TABELA VENDAS . GET LAST ID FOR FAC . CASO NAO EXISTA, COMEÇA DE NOVO
    // VERIFICAR SE JA EXISTE VENDAS
    $ArrayVendas = getInfoTabela('vendas', ' order by id_venda desc limit 1 ');
    $refVenda = $anoAtual.'/1';


    // SE EXISTIR VENDA
    if($ArrayVendas[0]){  // EXEMPLO - 2021/01

        $dataDocumento = explode('/', $ArrayVendas[0]['ref']); // $dataDocumento[0] é o ano e $dataDocumento[1] é o counter

        // SE O ANO ATUAL FOR IGUAL AO ANO DO DOCUMENTO

        if($anoAtual == $dataDocumento[0]){
            $refVenda = $anoAtual.'/'.($dataDocumento[1]+1);
        }

    }

    // Inserir na BD (tabela, cols, vals)


    $inserted_id = insertIntoTabela('vendas', "id_criou_loja, ref ,id_cliente,
     id_criou, desconto, adiantamento, id_orc, orc_ref, tipo_pagamento_restante, color, tirador, cristales, madera, created_at",
        "'$id_loja','$refVenda',".$arrayOrcamento['id_cliente'].",
         '".$_SESSION['id_utilizador']."','".$arrayOrcamento['desconto']."',
         '".$arrayOrcamento['adiantamento']."', $id,'".$arrayOrcamento['ref']."',
          '".$arrayOrcamento['tipo_pagamento_restante']."', '".$arrayOrcamento['color']."',
           '".$arrayOrcamento['tirador']."', '".$arrayOrcamento['cristales']."', '".$arrayOrcamento['madera']."', '".current_timestamp."'");




    $extraColumns = ["id_venda" => $inserted_id];

    $colunsToIgnore = 'id_orcamento, id_orcamento_linha';
    foreach($arrayLinhas as $linha){

        $organizedInserts=organizeDataInserts($linha, $colunsToIgnore, $extraColumns);
        insertIntoTabela('vendas_linhas', $organizedInserts[0], $organizedInserts[1]);

    }


    // END INSERIR NA TABELA DE VENDAS


    // UPDATE TABELA
    UpdateTabela($nomeTabela, " id_fac = $inserted_id, fac_ref = '$refVenda' ", " and id_$nomeColuna='$id'");

    // CRIAR LOG
    criarLog($db,"$nomeTabela","id_$nomeColuna",$id,"convertido para fatura",null);


    header("location: ../mod_vendas/index.php?p=$refVenda&cod=1");
    die;
}
header("location: ../mod_orcamentos/index.php?cod=2");
die;