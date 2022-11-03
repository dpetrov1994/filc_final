<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");


/**  FILTROS ADICIONAIS */
$arrayUtilizadores = getInfoTabela('utilizadores', ' and ativo = 1', '', 'id_utilizador');
$grupoUtilizadores = getInfoTabela('grupos_utilizadores','', '', 'id_utilizador');



// END FILTRO FUNCIONARIOS


// FILTRO POR CLIENTE
$id_cliente="todos";
if(isset($_GET['cliente']) && $_GET['cliente']!="todos"){
    $id_cliente=$db->escape_string($_GET['cliente']);
    $add_sql.=" and $nomeTabela.id_cliente='$id_cliente'";

}

$ops="";
$clientes = getInfoTabela('srv_clientes', ' and srv_clientes.PartyID != "" and ativo = "1" order by OrganizationName asc','get clientes');
foreach($clientes as $cliente){
    $selected="";
    if($cliente['FederalTaxID']==$id_cliente){
        $selected="selected";
    }
    $ops.="<option $selected value='".$cliente["FederalTaxID"]."'>".$cliente["OrganizationName"]."</option>";
}

$content=str_replace("_clientes_",$ops,$content);
// END FILTRO POR CLIENTE


// FILTRO POR DATA
$data_inicio="";
$data_fim="";
if((isset($_GET['data_inicio']) and isset($_GET['data_fim'])) and ($_GET['data_inicio']!="" and  $_GET['data_fim']!="")){
    $data_inicio=($_GET['data_inicio']);
    $data_fim=($_GET['data_fim']);

    $data_inicio_sql=data_portuguesa($_GET['data_inicio']);
    $data_fim_sql=data_portuguesa($_GET['data_fim']);
    $add_sql.=" and ($nomeTabela.created_at>='$data_inicio_sql 00:00:00' and $nomeTabela.created_at<='$data_fim_sql 23:59:00') ";
}
$content=str_replace("_data_inicio_",$data_inicio,$content);
$content=str_replace("_data_fim_",$data_fim,$content);
// END FILTRO POR DATA


/** fFIM FILTROS ADICIONAIS */

include ("../_igualEmTodasTabelas.php");
$tr=0;
$sql="SELECT count(".$nomeTabela.".id_".$nomeColuna.") FROM ".$nomeTabela." $innerjoin WHERE 1 $add_sql2 $add_sql ";
/*if($_SESSION['id_utilizador'] == 1){
    print_r($sql);
    die;
}*/
 $result=runQ($sql,$db,"CONTAR RESULTADOS");
while ($row = $result->fetch_assoc()) {
    $tr=$row['count('.$nomeTabela.'.id_'.$nomeColuna.')']; // total rows
}
if($tr>0){
    include "../_paginacao.php";
    $no_from=1;
    if($subModulo==0){
        include "../_funcionalidades.php";
    }else{
        include "../_funcionalidadesSubModulos.php";
    }

    $tbody="";

 //   $add_sql=str_replace("order by"," group by $nomeTabela.id_$nomeColuna order by",$add_sql);
    $add_sql.=" LIMIT ".(($pn-1)*$pr)." , $pr";
    $sql="SELECT *,orcamentos.created_at as 'orc_created_at', orcamentos.id_criou as 'criador' FROM $nomeTabela $innerjoin  WHERE 1 $add_sql"; // $add_sql
    $result=runQ($sql,$db,"LOOP PELOS RESULTADOS");
    while ($row = $result->fetch_assoc()) {
        $tbody.=$linhaTD;

        $funcionalidadesTemp=$funcionalidades;

        $row['criador'] = $arrayUtilizadores[$row['id_criou']][0]['nome_utilizador'];

        $cliente = getInfoTabela('srv_clientes', ' and id_cliente = "'.$row['id_cliente'].'"');
        $nome_cliente = "";
        if(isset($cliente[0])){
            $nome_cliente= ($cliente[0]['OrganizationName']);
        }
        $row['OrganizationName']=$nome_cliente;

        /**colunas personalizadas **/
        $row['Tipo'] = "<span class='label label-warning'>Orçamento</span>";


        // SE EXISTIR FATURA - BLOQUEAR ESTE ORCAMENTO, MOSTRAR COMO FECHADO


        // OPEN MODAL
        if(in_array('1',$_SESSION['grupos']) || in_array('2',$_SESSION['grupos'] )) { // CASO SEJA O ADMIN - MOSTRAR CAMPO PARA ATRIBUIR O RECIBO À LOJA
       //     $arrayUtilizadores = getInfoTabela('utilizadores', ' and ativo = 1', '', 'id_utilizador');

            $ops="";
            foreach($arrayUtilizadores as $utilizador) {
                if($grupoUtilizadores[$utilizador['id_utilizador']]['id_grupo'] == 9){ // FUNCIONARIOS
                    $ops.="<option class='id_utilizador' value='".$utilizador["id_utilizador"]."'>".$utilizador["nome_utilizador"]."</option>";
                }
            }
            $content=str_replace("_lojas_",$ops,$content);
            $funcionalidadesTemp = str_replace('href="javascript:void(0)" onclick="confirmaModal(\'orc_to_fac.php?id=_idItem_\')"', 'onclick="getIdDoc(\'_idItem_\')" data-toggle="modal" href="#modal_orc_to_fac"', $funcionalidadesTemp);
        }




        if(isset($ativo) && $ativo == 0){
            $funcionalidadesTemp = removerFuncionalidade('editar', $funcionalidadesTemp);
            $funcionalidadesTemp = removerFuncionalidade('reciclar', $funcionalidadesTemp);
            $funcionalidadesTemp = removerFuncionalidade('converter_para_venda', $funcionalidadesTemp);
        }




        $total_sem_iva=0;
        $total_com_iva=0;
        $sql2="select * from orcamentos_linhas where id_orcamento='".$row['id_orcamento']."'";
        $result2=runQ($sql2,$db,"orcamentos linhas");
        while ($row2 = $result2->fetch_assoc()) {
            $total_com_iva+=$row2['valor_liquido'];
            $total_sem_iva+=($row2['preco_sem_iva']*$row2['quantidade']);
        }
        $total_sem_iva=number_format($total_sem_iva,"2",".",",");
        $total_com_iva=number_format($total_com_iva,"2",".",",");

        $row['totalSemIva']=$total_sem_iva." €";
        $row['totalComIva']=$total_com_iva." €";


        /** FIM colunas personalizadas**/

        $tbody=rules_for_rows($rules_for_rows,$row,$tbody,$linkDasTabelas);


        foreach ($row as $coluna=>$valor){
            $tbody=str_replace("_".$coluna."_",$valor,$tbody);
        }



        $tbody=str_replace("_funcionalidades_",$funcionalidadesTemp,$tbody);
        if($subModulo==0){
            $tbody=str_replace("_idItem_",$row['id_'.$nomeColuna],$tbody);
        }else{
            $tbody=str_replace("_subItemID_",$row['id_'.$nomeColuna],$tbody);
            $tbody=str_replace("_idItem_",$idParent,$tbody);
        }
    }

    if($subModulo==0){
        $content=str_replace("_id_",$id,$content);
    }else{
        $content=str_replace("_id_",$idParent,$content);
    }

    $resultados=str_replace("_tbody_",$tbody,$tplTabela);

    if(isset($_GET['excel'])){
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Content-Disposition: attachment; filename=".$nomeTabela."_".time().".xls");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        $tempalte_excel=str_replace('_resultados_',$resultados,$tempalte_excel);
        print $tempalte_excel;
        die();
    }
}else{
    $resultados="_semResultados_";
}
$pageScript='<script src="index.js"></script>';
include ('../_autoData.php');