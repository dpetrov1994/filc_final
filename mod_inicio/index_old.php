<?php

include ('../_template.php');

$content=file_get_contents("index.tpl");

if(isset($_GET['like'])) {

    // DESCREVER O SRV_CLIENTES
    $columns = [];
    $sql = "describe srv_clientes";
    $result = runQ($sql, $db, "");
    while($return = $result->fetch_assoc()) {
        $columns[] = "srv_clientes.".$return['Field'];
    }
    $sql = "describe srv_clientes_informacao";
    $result = runQ($sql, $db, "");
    while($return = $result->fetch_assoc()) {
        $columns[] = "srv_clientes_informacao.".$return['Field'];
    }


    $value = $db->escape_string($_GET['like']);
    $search_terms=[$value];
    /*
    $values=explode(" ",$value);
    $search_terms=[];
    $ignorar=["do", "de", "da", "e", "das", "dos", "des", "o"];
    foreach ($values as $val){
        if(!in_array($val, $ignorar)){
            $search_terms[]=$val;
        }
    }
    */

    $search_query="";
    if(is_array($search_terms) && count($search_terms)>0){
        foreach ($search_terms as $s){
            foreach($columns as $column) {
                $search_query.=" $column like '%$s%' or";
            }
        }
        $search_query=substr($search_query, 0, -2);
        $search_query=" and ($search_query)";
    }
    $addSql=$search_query;



    $tplCliente = '

  <div class="col-lg-12 animate__animated  animate__fadeIn">

        <div class="block ">
            <div class="block-title"><a  href="../mod_srvcliente/detalhes.php?id=_PartyID_"><h4 style="color:white"><i class="fa fa-info-user"></i> _OrganizationName_</h4></a></div>
            <div class="row" style="margin-bottom: 20px; display: flex;align-items: center">
                <div class="col-lg-12">
                      <b>Nickname:</b> _alfabetico_ <br>
                      <b>Pais:</b> _pais_ <br>
                      <b>Contribuinte:</b> _FederalTaxID_ <br>
                </div>
               
            </div>
        </div>
 
    </div>
 ';

    $registos_encontrados=0;
    $sql="select count(DISTINCT(srv_clientes.FederalTaxID)) as cnt from srv_clientes join srv_clientes_informacao on srv_clientes_informacao.FederalTaxID=srv_clientes.FederalTaxID where 1 $addSql and ativo=1 and srv_clientes.PartyID != ''";
    $result = runQ($sql, $db, "");
    while($row = $result->fetch_assoc()) {
        $registos_encontrados=$row['cnt'];
    }
    $infoClientes = "<div class='col-lg-12'><table class='table'><tbody><tr><td class='text-left'>$registos_encontrados registos encontrados (<a href='../mod_srvcliente/index.php?p=$value'>ver todos</a>) </td><td class='text-right'><small>Esta pesquisa apresenta 10 registos no máximo</small></td></tr></tbody></table></div>";


    $sql="select * from srv_clientes join srv_clientes_informacao on srv_clientes_informacao.FederalTaxID=srv_clientes.FederalTaxID where 1 $addSql and ativo=1 and srv_clientes.PartyID != '' group by srv_clientes.FederalTaxID limit 0,10";
    $result = runQ($sql, $db, "");
    while($cliente = $result->fetch_assoc()) {
        $infoClientes .= $tplCliente;

        foreach($cliente as $coluna => $valor) {

            if($coluna == "empresa"){
                if($valor == "ELAData.dbo."){
                    $valor = "BD";
                }else{
                    $valor="BD2";
                }
            }

            if($coluna == "pais"){
                $valor=str_replace('["','',$valor);
                $valor=str_replace('"]','',$valor);
            }

            if($valor == "" || $valor==" "){
                $valor="Sem atribuição";
            }


            $infoClientes = str_replace('_' . $coluna . '_', "$valor", $infoClientes);
        }




    }



    print $infoClientes;
    die;
}


            /*
                $id_cliente = $db->escape_string($_GET['id_cliente']);
                $cliente = getInfoTabela('srv_clientes', " and srv_clientes.FederalTaxID='$id_cliente'", '', '',''
                ,'','','','','inner join srv_clientes_informacao on srv_clientes_informacao.FederalTaxID=srv_clientes.FederalTaxID');

                $cliente=$cliente[0];
                $infoCliente =
                    '

            <div class="row">

                <div class="col-lg-12 block-title"> Informação do cliente </div>

                <div class="col-lg-3" style="font-size: 18px;line-height: 19px">
                    <small>_classificacao_</small>
                    <div class="input-group _esconderParaFuncionarios_">
                     </div>
                    <small>_OrganizationName_<small class="text-muted"><br><span id="nif">_FederalTaxID_</span></small></small>

                </div>


                <div class="col-lg-3" style="font-size: 18px">
                    <small class="text-primary" style="padding-left: 11px;"><i class="fa fa-globe"></i> _pais_</small><br>
                    <div class="input-group _esconderParaFuncionarios_">
                        <span class="input-group-btn">
                        <button type="button" class="btn " style="font-size: 14px;background: transparent;border-bottom: 1px solid #303439;"><i class="fa fa-map-pin text-muted"></i></button>
                        </span>
                   </div>
                    <div class="input-group _esconderParaFuncionarios_">
                        <span class="input-group-btn">
                            <button type="button" class="btn " style="font-size: 14px;background: transparent;border-bottom: 1px solid #303439;"><i class="fa fa-map-pin text-muted"></i></button>
                        </span>
                     </div>
                </div>

                <div class="col-lg-3 text-center">
                    <i class="fa fa-money _corDivida_" style="font-size: 20px"></i>
                    <br>
                    Valor pendente c/iva:<br>
                    _Divida_
                </div>


            </div>

                    ';


                foreach($cliente as $coluna => $valor){
                    $infoCliente = str_replace('_'.$coluna.'_',"$valor",$infoCliente);
                }

                print $infoCliente;
                die;

}*/




$pageScript="<script src='inicio.js'></script>";
include ('../_autoData.php');