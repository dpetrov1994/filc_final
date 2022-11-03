<?php
$pagina= '<style>
    page{
        font-size: 11px;
    }
    
     td{
        font-size: 12px;
    }
    
    .tabela_castanha{
        width: 100%;
        border: 2px solid #000;
        border-collapse: collapse;
    }
    
    .tabela_castanha tr{
        border: 1px solid gray;
        border-collapse: collapse;
    }
    
    .tabela_castanha td{
        border: 1px solid gray;
        padding: 5px;
        border-collapse: collapse;
    }
    
</style>

<page backtop="2mm" backbottom="2mm" backleft="2mm" backright="2mm">
   
    <div style="width: 100%; font-size: 10px;margin-top: 0px">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;text-align: left"><img style="height: 75px" src="../assets/layout/img/logo.png"></td>
                <td style="width: 50%">
                <table class="tabela_castanha" style="width: 100%">
                    <tr>
                        <td style="background:#de4b39;color:#fff; width:50%"><b>Proposta</b></td>
                         <td style="background: #de4b39;COLOR:#fff;  width:50%"><b style="font-size:16px;"> #_ref_ </b> </td>
                    </tr>
                    <tr>
                         <td><b style="color: #000; text-transform: uppercase">Data</b></td>
                        <td><b style="color: #000"></b> _data_</td>
                    </tr>
                    
                </table>
                </td>
            </tr>
        </table>
        <br>
       <table class="tabela_castanha" style="width: 100%">
                    <tr>
                        <td style="width: 50%"><b style="color: #000">Nome do Cliente:</b> _OrganizationName_</td>
                          <td style="width: 50%"><b style="color: #000">NIF:</b> _FederalTaxID_</td>
                    </tr>
        </table>
         <br>
        
         <br>
                <table class="tabela_castanha" style="width: 100%;">
                    <tr>
        <td colspan="2"><b>Modelo: </b> _nome_produto_</td>
    </tr>
    <tr>
        <td style="width: 40%"><img src="_fotoproduto_" style="width: 100%;height: auto"></td>
        <td style="width: 60%;font-size: 12px" >_desc_</td>
    </tr>
    <tr>
    <td colspan="2">
        <table style="width: 100%">
            <tr>
            <td style="width: 60%;border:none;text-align: right">Quantidade</td>
            <td style="width: 15%;border:none;text-align: right">Preço Un.</td>
            <td style="width: 10%;border:none;text-align: right">Desconto</td>
            <td style="width: 15%;border:none;text-align: right">Valor final</td>
</tr>
            <tr>
            <td style="border:none;text-align: right"><b>_quantidade_</b></td>
            <td style="border:none;text-align: right"><b>_preco_sem_iva_ €</b></td>
            <td style="border:none;text-align: right"><b>_desconto_ €</b></td>
            <td style="border:none;text-align: right"><b>_valor_final_ €</b></td>
</tr>
</table>
</td>
    </tr>
                </table>
                <br>
               
                
               
    </div>
    <page_footer>

        <table style="width: 100%;">
        <!--
            <tr>
                        <td style="width: 50%">
                            <table class="tabela_castanha" style="width: 100%">
                                <tr>
                                    <td style="width: 100%;height: 55px; color: #000"><b style="color: #000">Observações:</b><br>_descricaoP_</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 50%">
                            <table class="tabela_castanha" style="width: 100%; ">
                               <tr>
                                    <td style="background: #fff;width: 50%;"><b style="color:#000;font-size: 16px">TOTAL S/ IVA:</b></td>
                                    <td style="background: #fff;width: 50%;text-align: right"><b style="color:#000;font-size: 16px">_totalSiva_ €</b></td>
                                </tr>
                                <tr>
                                    <td style="background: #fff;width: 50%;"><b style="color:#000;font-size: 16px">IVA</b></td>
                                    <td style="background: #fff;width: 50%;text-align: right"><b style="color:#000;font-size: 16px">_totalIva_ €</b></td>
                                </tr>
                                 <tr>
                                    <td style="background: #fff;width: 50%;"><b style="color:#000;font-size: 16px">DESCONTOS: </b></td>
                                    <td style="background: #fff;width: 50%;text-align: right"><b style="color:#000;font-size: 16px">_totalDescontos_ €</b></td>
                                </tr>
                            </table><br>
                            <table class="tabela_castanha" style="width: 100%">
                                <tr>
                                    <td style="background: #fff;width: 50%;"><b style="color:#000;font-size: 20px">TOTAL:</b></td>
                                    <td style="background: #fff;width: 50%;text-align: right"><b style="color:#000;font-size: 20px">_totalTotal_ €</b></td>
                                </tr>
                            </table>
</td>
                    </tr>
                    -->
            <tr>
                  <td style="text-align: left; vertical-align: bottom; padding-left: 10px;   width: 50%; font-size: 10px">
                  * Aos valores apresentados acresce a taxa do IVA em vigor.
                  
                  </td>
              
            </tr>
            
        </table>

    </page_footer>
</page>

';

$get=$id;


$descricao_produto = "";
$nome_produto_td = "";
$foto_produto_td="";
$nome_produto="";

if($_GET['conf_descricaoproduto'] == "1"){

    $f_size="";
    if($_GET['conf_nomeproduto'] == "1"){
     $f_size="font-size: 10px";
    }

    $descricao_produto = '<p style="'.$f_size.';margin:0;padding:0">_descricaoproduto_</p>';
}

if($_GET['conf_nomeproduto'] == "1"){
    $nome_produto = '_nome_produto_';
}

if($_GET['conf_nomeproduto'] == "1" || $_GET['conf_descricaoproduto'] == "1"){
    $nome_produto_td='<td > '.$nome_produto.' '.$descricao_produto.'</td>';
}


if($_GET['conf_fotoproduto'] == "1"){
    $foto_produto_td='<td>_fotoproduto_</td>';

}







$paginas="";
$ls=$get['linhas'];
$total_s_iva=0;
$total_iva=0;
$total_descontos=0;
$total_geral=0;
foreach ($ls as $l){
    $paginas.=$pagina;

    $desconto = $l['preco_sem_iva']*($l['desconto']/100);
    $total_descontos+=$desconto;

    $valor_com_desconto=($l['preco_sem_iva']-$desconto);
    $total_s_iva+=$valor_com_desconto;

    $valor_iva=$valor_com_desconto*($l['percentagem_iva']/100);
    $total_iva+=$valor_iva;

    $subtotal=($valor_com_desconto+$valor_iva);
    $total=($subtotal)*$l['quantidade'];
    $total_geral+=$total;

    $l['preco_sem_iva']=number_format($l['preco_sem_iva']*1,"2",","," ");
    $l['quantidade']=number_format($l['quantidade']*1,"2",","," ");
    $l['subtotal']=number_format($subtotal*1,"2",","," ");
    $l['valor_final']=number_format($total*1,"2",","," ");
    $l['desconto']=number_format($desconto*1,"2",","," ");

    $l['iva']=number_format($valor_iva*1,"2",","," ");
    foreach ($l as $key => $val){
        $val=wordwrap($val, 85, "<br>",true);
        $paginas=str_replace("_".$key."_",$val,$paginas);
    }
}

//$total2= $total1 + $total3; // ESTE TEM DE SER O TOTAL 1 MENOS O DESCONTO E O ADIANTAMENTO


/*for($i=0;$i<(count($ls));$i++){
    $linhas.=$linha;
    $linhas=str_replace("_nome_produto_","&nbsp;",$linhas);
    $linhas=str_replace("_quantidade_","",$linhas);
    $linhas=str_replace("_preco_sem_iva_ €","",$linhas);
    $linhas=str_replace("_valor_liquido_ €","",$linhas);
} */


$get['totalSiva']=number_format($total_s_iva,2,".",",");
$get['totalIva']=number_format($total_iva,2,".",",");
$get['totalDescontos']=number_format($total_descontos ,2,".",",");
$get['totalTotal']=number_format($total_geral, 2);

foreach ($get as $key=>$value ){
    $paginas=str_replace("_".$key."_",$value,$paginas);
}

$paginas=str_replace('_nomeutilizador_',$get['nome_utilizador'],$paginas);
$paginas=str_replace('_nif_',$get['nif'],$paginas);


print $paginas;
?>