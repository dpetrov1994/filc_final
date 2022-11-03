<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("detalhes.tpl");

$content=str_replace("_idItem_",$id,$content);

$content=str_replace("_idencrypted_",base64_encode($id),$content);

$active_item="";
$sql="select *, $nomeTabela.CreateDate as CreateDate1   from $nomeTabela  where id_$nomeColuna='$id'";

$result=runQ($sql,$db,"VERIFICAR EXISTENTE");
if($result->num_rows!=0){
    while ($row = $result->fetch_assoc()) {/**Preenchimento dos itens do formulário*/


        include ("_criar_editar_detalhes.php");

        $row['OrganizationName']="-";
        $row['FederalTaxID']="-";
        $row['morada']="-";
        $row['local']="-";
        $row['cdpostal']="-";
        $row['pais']="-";

        $cliente = getInfoTabela('srv_clientes', ' and PartyID = "'.$row['PartyID'].'"');
        $nome_cliente = "";
        if(isset($cliente[0])){
            foreach ($cliente[0] as $key=>$row2){
                $row[$key]=$row2;
            }
            $nome_cliente= ($cliente[0]['OrganizationName']);
        }
        $row['nome_cliente']=$nome_cliente;

        /**FIM Preenchimento dos itens do formulário*/

        $row['TotalNetAmount']=number_format($row['TotalNetAmount'],2,".","");
        $row['TotalTaxAmount']=number_format($row['TotalTaxAmount'],2,".","");
        $row['TotalGlobalDiscountAmount']=number_format($row['TotalGlobalDiscountAmount'],2,".","");
        $row['TotalAmount']=number_format($row['TotalAmount'],2,".","");


        $row['EntityAddress']=ucwords(strtolower($row['EntityAddress']));
        $row['entitycity']=ucwords(strtolower($row['entitycity']));

        $row['CreateDate'] = date("d/m/Y",strtotime($row['CreateDate1']));

        $content=replaces_no_formulario($content,$row,$nomeTabela,$nomeColuna,$db);

        $linhas="";



        $linha='<tr>
                    <td class="text-left"> <strong>_ItemID_</strong></td>
                    <td>_Description_</td>
                    <td class="text-center"><span class="label label-success"><strong>x_Quantity_</strong></span></td>
                    <td class="text-right">€ _UnitPrice_</td>
                    <td class="text-right">_valor_desconto_</td>
                    <td class="text-right">_TaxValue_</td>
                    <td class="text-right">€ _Total_</td>
                </tr>';


        $sql2="select * from srv_clientes_saletransactiondetails where TransDocNumber='".$row['TransDocNumber']."' and TransDocument='".$row['TransDocument']."' and TransSerial='".$row['TransSerial']."' order by LineItemID asc";
        $result2=runQ($sql2,$db,"linhas do cdocumento");
        while ($row2 = $result2->fetch_assoc()) {


            $linhas.=$linha;

            $valor_linha = $row2['UnitPrice'] * $row2['Quantity'];


            $iva = 0.23;

            $TotalTaxAmount =  ($valor_linha - $row2['valor_desconto']) * ($iva / 100);
            if($row2['TotalTaxAmount'] != $TotalTaxAmount){
                $iva = 0.13;

                $TotalTaxAmount =  ($valor_linha - $row2['valor_desconto']) * ($iva / 100);
                if($row2['TotalTaxAmount'] != $TotalTaxAmount){
                    $iva = 0;

                    $TotalTaxAmount =  ($valor_linha - $row2['valor_desconto']) * ($iva / 100);
                    if($row2['TotalTaxAmount'] != $TotalTaxAmount){
                        $iva = "???";
                    }

                }
            }


            $row2['Quantity']=number_format($row2['Quantity'],"0");
            $row2['UnitPrice']=number_format($row2['UnitPrice'],"2",".","");
            $row2['valor_desconto']=number_format($row2['valor_desconto'],"2",".","");
            $row2['TaxValue']=number_format($row2['TotalTaxAmount'],"2",".","");

            $row2['Total']=number_format((($row2['TotalTaxAmount'] + $valor_linha) - $row2['valor_desconto']),"2",".","");

            foreach ($row2 as $key=>$value){
                $linhas=str_replace("_".$key."_",$value,$linhas);
            }

        }
        $content=str_replace("_linhas_",$linhas,$content);

    }


    /**Preenchimento dos itens do formulário*/



    /**FIM Preenchimento dos itens do formulário*/


    $pageScript='<script src="detalhes.js"></script>';
}else{
    exit(erro($cfg_nomePlataforma,$layoutDirectory,"Cod 2","Não foi encontrado nenhum registo com o ID:".$id,""));
}
include ('../_autoData.php');