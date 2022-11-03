<?php

include "../_funcoes.php";
include "../conf/dados_plataforma.php";

if(isset($_GET['id'])){

    $db=ligarBD();
    $id=$db->escape_string($_GET['id']);
    unset($_GET['id']);

    $arrayUtilizadores = getInfoTabela('utilizadores', ' and ativo = 1', '', 'id_utilizador');
    $nome_cliente=$_SESSION['cfg']['nomeEmpresa'];
    $sql="select *,orcamentos.descricao as descricaoP, orcamentos.created_at as 'doc_created_at', utilizadores.nome_utilizador as tecnico from orcamentos 
    inner join srv_clientes on srv_clientes.id_cliente=orcamentos.id_cliente
    left join utilizadores on utilizadores.id_utilizador = orcamentos.id_criou
    where id_orcamento='$id'";
    $result=runQ($sql,$db,"selecionar os dados antes de mandar para o layout");
    while ($row = $result->fetch_assoc()) {



        $row['data']=date("d/m/Y",strtotime($row['doc_created_at']));
        $row['loja'] = $arrayUtilizadores[$row['id_criou_loja']]['nome_utilizador'];
        $hora = explode(' ',$row['doc_created_at']);
        $row['hora'] = $hora[1];

       /* $_GET['conf_descricaoproduto'] = $row['conf_descricaoproduto'];
        $_GET['conf_nomeproduto'] = $row['conf_nomeproduto'];
        $_GET['conf_fotoproduto'] = $row['conf_fotoproduto'];*/

        if($row['tipo_pagamento_restante'] == 2){
            $row['tipo_pagamento_restante'] = "Transferência";
        }elseif($row['tipo_pagamento_restante'] == 1){
            $row['tipo_pagamento_restante'] = "Dinheiro";
        }else{
            $row['tipo_pagamento_restante'] = "";
        }
        $row['orcref'] = $row['orc_ref'];

        foreach ($row as $key=>$value){

            if($key == "pais"){
                $value=str_replace('["',"",$value);
                $value=str_replace('"]',"",$value);
            }
            $_GET[$key]=$value;
        }




        $nome=$row['ref'];
    }
    $_GET['linhas']=[];
    $sql="select orcamentos_linhas.*, produtos.descricao as descricaoproduto from orcamentos_linhas left join produtos using(nome_produto) where id_orcamento='$id'  order by id_orcamento_linha asc";
    $result=runQ($sql,$db,"selecionar os dados antes de mandar para o layout");
    while ($row = $result->fetch_assoc()) {



        $img="";
        $desc="";
        $foto="../assets/layout/img/placeholder.png";
        $sql_preencher2="select * from produtos where ativo=1 and id_produto='".$row['id_produto']."'";
        $result_preencher2=runQ($sql_preencher2,$db,"datalist de produtos");
        while ($row_preencher2 = $result_preencher2->fetch_assoc()) {
            $foto="../_contents/produtos/".$row_preencher2['id_produto']."/".$row_preencher2['foto'];
            if(!is_file($foto)){
                $foto="../assets/layout/img/placeholder.png";
            }

            $desc=(($row_preencher2['descricao']));
            $desc=str_replace("<br />","<br>",$desc);
        }


        $row['fotoproduto'] = $foto;
        $row['desc'] = $desc;


        array_push($_GET['linhas'],$row);


    }



    $db->close();

    gerarPDF("gerar_pdf_layout.php",$_GET,"ORC ".(($nome)).".pdf","P");
}