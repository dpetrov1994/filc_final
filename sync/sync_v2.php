<?php

include "../_funcoes.php";
include "../conf/dados_plataforma.php";

//$result=runQSrv("asd");

//set_time_limit ( -1);

$db=ligarBD(1);


$mapa_colunas=[
    'CLIENTES'=>[
        'CODIGO'=>["PartyID","id_cliente"],
        'NUMERO'=>"CustomerID",
        'NOME'=>"OrganizationName",
        'CONTACTO'=>"Telephone1",
        'MORADA'=>"morada",
        'LOCAL'=>"local",
        'CDPOSTAL'=>"cdpostal",
        'TELEF'=>"Telephone2",
        'PAIS'=>"pais",
        'NCONTRIB'=>["KeyFederalTaxID","FederalTaxID"],
        'OBSERV'=>"Comments",
        'EMAIL'=>"EmailAddress",
        'TOTPEND'=>"pendente",
        'INACTIVO'=>"ativo",
        'SITIO'=>"WebAddress",
        'MORADA2'=>"morada2",
    ],
    'DOCGCCAB'=>[
        'TPDOC'=>"TransDocument",
        'NNUMDOC'=>"TransDocNumber",
        'DATA'=>"CreateDate",
        'DATEUPD' => "UpdatedDate",
        'ANO'=>"ano",
        'SERIE'=>"TransSerial",
        'TERCEIRO'=>"PartyID",
        'TOTDOC'=>"TotalAmount",
        'TOTIVA1'=>"totiva1",
        'TOTIVA2'=>"totiva2",
        'TOTIVA3'=>"totiva3",
        'TOTIVA4'=>"totiva4",
        'NCONTRIB'=>"PartyFederalTaxID",
        'TOTDSPAD'=>"TotalNetAmount",
        'DTVENC'=>"data_vencimento",
        'OPERNEW'=>"SalesmanID",
        'NVIAS'=>"ativo",
        'DESCONTO_FINANCEIRO'=>"TotalGlobalDiscountAmount",
    ],
    'DOCGCLIN'=>[
        'TPDOCUM'=>"TransDocument",
        'NNUMDOC'=>"TransDocNumber",
        'NUMLINHA'=>"LineItemID",
        'ARTIGO'=>"ItemID",
        'DESCR'=>"Description",
        'PRUNIT'=>"UnitPrice",
        'QUANT'=>"Quantity",
        'VALOR'=>"TotalNetAmount",
        'VLIVAOR'=>"TotalTaxAmount",
        'DESCONTO'=>"DiscountPercent",
        'DESCVO'=>"valor_desconto",
        'DATA'=>"CreateDate",
        'DATEUPD' => "UpdatedDate",
        'ANO'=>"ano",
        'SERIE'=>"TransSerial"
    ],
    'PENDENTE'=>[
        'TERCEIRO'=>"PartyID",
        'TPDOC'=>"TransDocument",
        'NNUMDOC'=>"TransDocNumber",
        'VLPENDE'=>"TotalPendingAmount",
        'DATAVENC'=>"DeferredPaymentDate",
        'ANO'=>"ano",
    ],
    'ARTIGOS'=>[
        'CODIGO'=>"ref",
        'NUMERO'=>"numero",
        'NOME'=>"nome_produto",
        'FAMILIA'=>"familia",
        'grupo'=>"GRUPO",
        'UNBASE'=>"unidade",
        'PVPSIVA'=>"preco_sem_iva",
        'PCMPSIVA'=>"preco_compra",
        'STDISP'=>"quantidade",
        'IVA'=>"iva",
        'CODBARRA'=>"cod_barras",
    ],
];

$mapa_tabelas=[
    'CLIENTES'=>'srv_clientes',
    'DOCGCCAB'=>'srv_clientes_saletransaction',
    'DOCGCLIN'=>'srv_clientes_saletransactiondetails',
    'PENDENTE'=>'srv_clientes_CustomerLedgerAccount',
    'ARTIGOS'=>'produtos',
];

$mapa_chaves=[
    'ARTIGOS'=>['ref','numero'],
    'CLIENTES'=>['PartyID','CustomerID'],
    'DOCGCCAB'=>['TransDocument','TransDocNumber','ano','TransSerial'],
    'DOCGCLIN'=>['TransDocument','TransDocNumber','ano','TransSerial', 'LineItemID'],
    'PENDENTE'=>['TransDocument','TransDocNumber','ano','PartyID'],

];

if(isset($_GET['max_data'])){
    $table=$mapa_tabelas[$_GET['table']];
    $max_date="";
    $sql="select max(UpdatedDate) as max_date from $table where 1 ";
    $result=runQ($sql,$db,"obter ultimo registo");
    if($result->num_rows>0) {
        while($row = $result->fetch_assoc()) {
            $max_date=($row['max_date']);
        }
    }
    print $max_date;
    $db->close();
    die();
}


if(isset($_GET['exec_sync'])){

    $t="";
    if($_GET['exec_sync']!=""){
        $t=$_GET['exec_sync'];
    }

    foreach ($mapa_tabelas as $tabela => $mysql_table){

        if($t!="" && $t!=$tabela){
            continue;
        }

        $contents=file_get_contents("extracted/$tabela.json");
        $new_data=json_decode($contents,true);

        $old_data=[];
        if(is_file("last_updated/$tabela.json")){
            $contents=file_get_contents("last_updated/$tabela.json");
            $old_data=json_decode($contents,true);
        }


        copy("extracted/$tabela.json","last_updated/$tabela.json");


        if($tabela=='DOCGCLIN'){
            $max_date="";
            $sql="select max(UpdatedDate) as max_date from $mysql_table where 1 ";
            $result=runQ($sql,$db,"obter ultimo registo");
            if($result->num_rows>0) {
                while($row = $result->fetch_assoc()) {
                    $max_date=($row['max_date']);
                }
            }
        }

        //só suncronizar os pendentes as 8h, 12h e 18h
        if($tabela=='PENDENTE'){
            if((date("H",strtotime(current_timestamp))==8 || date("H",strtotime(current_timestamp))==13 || date("H",strtotime(current_timestamp))==18)){
                $sql="truncate $mysql_table ";
                $result=runQ($sql,$db,"apagar os pendentes");
            }else{
                continue;
            }
        }

        if(is_array($new_data)){

            foreach ($new_data as $new){

                //validar o que temos em dados antigos e se for igual não fazer nada (só em CLIENTES E ARTIGOS)
                if(in_array($tabela,['ARTIGOS'])){
                    $avancar=1;
                    foreach ($old_data as $old){
                        if($old==$new){
                            $avancar=0;
                        }
                        break;
                    }
                    if($avancar==0){
                        continue;
                    }
                }

                //validar a última data registada, e dar skip até aqui
                if($tabela=='DOCGCLIN'){
                    if($new['DATEUPD']<$max_date){
                        continue;
                    }
                }


                //converter o inativo para o nosso
                if(isset($new['INACTIVO'])){
                    if($new['INACTIVO']==0){
                        $new['INACTIVO']=1;
                    }else{
                        $new['INACTIVO']=0;
                    }
                }
                if(isset($new['NVIAS'])){
                    if($new['NVIAS']<0){
                        $new['NVIAS']=0;
                    }else{
                        $new['NVIAS']=1;
                    }
                }

                //converter o valor de .000 para 0
                foreach ($new as $k=>$v){
                    if($v=='.0000'){
                        $new[$k]=0;
                    }
                }

                $valores_mapeados=[];
                foreach ($mapa_colunas[$tabela] as $origem => $destino){
                    if(is_array($destino)){
                        foreach ($destino as $dest){
                            $valores_mapeados[$dest]=$new[$origem];
                        }
                    }else{
                        $valores_mapeados[$destino]=$new[$origem];
                    }
                }
                $valores_mapeados['empresa']='filc';

                //validar se o registo já existe
                $keys="";
                foreach ($mapa_chaves[$tabela] as $chave){
                    $keys.=" and $chave='".$valores_mapeados[$chave]."' ";
                }

                if($tabela=="DOCGCCAB"){
                    if(!is_numeric($valores_mapeados['totiva4'])){
                        $valores_mapeados['totiva4']=0;
                    }
                    if(!is_numeric($valores_mapeados['totiva3'])){
                        $valores_mapeados['totiva3']=0;
                    }
                    if(!is_numeric($valores_mapeados['totiva2'])){
                        $valores_mapeados['totiva2']=0;
                    }
                    if(!is_numeric($valores_mapeados['totiva1'])){
                        $valores_mapeados['totiva1']=0;
                    }
                    $valores_mapeados['TotalNetAmount']=$valores_mapeados['TotalAmount']*1-$valores_mapeados['totiva4']*1-$valores_mapeados['totiva3']*1-$valores_mapeados['totiva2']*1-$valores_mapeados['totiva1']*1;
                    $valores_mapeados['TotalTaxAmount']=$valores_mapeados['totiva4']*1+$valores_mapeados['totiva3']*1+$valores_mapeados['totiva2']*1+$valores_mapeados['totiva1']*1;

                }elseif ($tabela=="ARTIGOS"){
                    $iva=0;
                    if($valores_mapeados['iva']==2){
                        $iva=6;
                    }elseif($valores_mapeados['iva']==3){
                        $iva=13;
                    }elseif($valores_mapeados['iva']==4){
                        $iva=23;
                    }
                    $valores_mapeados['iva']=$iva;
                }


                // COMPARAR TODOS AS ROWS DO JSON (DATEUPD) com o todas as rows do array do sql (UpdatedDate)



                $action="none";
                $sql="select * from $mysql_table where 1 $keys";
                $result=runQ($sql,$db,"validar");
                if($result->num_rows>0){
                    while ($row = $result->fetch_assoc()) {
                        foreach ($row as $col => $val){
                            if(isset($valores_mapeados[$col])){
                                if($row[$col]!=$valores_mapeados[$col]){
                                    $action="update";
                                }
                            }
                        }
                    }
                }else{
                    $action="create";
                }



                if($action=="create"){

                    $return=colunas_valores_criar($valores_mapeados,$db,[],[],"","",0);
                    $colunas=$return['colunas'];
                    $valores=$return['valores'];

                    $sql="insert into $mysql_table ($colunas) values ($valores)";
                    $result=runQ($sql,$db,"create".$sql);

                }elseif($action=="update"){

                    $return=colunas_valores_editar($valores_mapeados,$db,[],[]);
                    $colunas_e_valores=$return['colunas_e_valores'];

                    $sql = "update $mysql_table set $colunas_e_valores where 1 $keys";
                    $result = runQ($sql, $db, "UPDATE");
                }

            }

        }

    }

}else{
    if(isset($_FILES['file_zip'])){

        if(move_uploaded_file($_FILES['file_zip']['tmp_name'], "recieved/".$_FILES['file_zip']['name'])){
            $zip = new ZipArchive;
            $res = $zip->open("recieved/".$_FILES['file_zip']['name']);
            if ($res === TRUE) {
                $zip->extractTo('extracted/');
                $zip->close();
            }
        }else{
            //erro
        }
    }else{
        print "erro no ficheiro json.";
    }

}


$sql2="update _conf_cliente set data_sync='".current_timestamp."' where id_conf='1'";
$result2 = runQ($sql2, $db, "atualizar data da sync");


print current_timestamp." - Sincronização terminou. Pode fechar esta janela";

$db->close();
