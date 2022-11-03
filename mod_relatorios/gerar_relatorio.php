<?php



if(isset($_POST['colunas'])){

    ini_set('max_execution_time', 0);
    ini_set('memory_limit', -1);
    set_time_limit(0);

    if(!isset($_POST['only_count'])){
        $_POST['only_count']=0;
    }


    $colunas=$db->escape_string($_POST['colunas']);
    $colunas = substr($colunas, 0, -1);
    $colunas=tirarAcentos($colunas);

    if(isset($_GET['count'])){
        $colunas=" count(*) ";
    }


    $th="";
    $th_totais="";
    $tr="";
    $totais=[];
    $explode=explode(",",$colunas);
    foreach ($explode as $c){

        $pos = strpos($c, " as ");
        if ($pos !== false) {
            $nome=explode(" as ",$c);
            $nome_antigo=end($nome);

            $nome_novo=strtolower($nome_antigo);
            $nome_novo=str_replace(" ","",$nome_novo);
            $nome_novo=str_replace("_","",$nome_novo);

            $colunas=str_replace($nome_antigo,$nome_novo,$colunas);

            $th.='<th style="background: #00366F;color:white">'.strtoupper($nome_antigo).'</th>';
            $tr.='<td style="background: _bg_">_'.$nome_novo.'_</td>';
        }else{
            $c=explode(".",$c);
            $c=$c[1];
            $tr.='<td style="background: _bg_">_'.str_replace('_','',strtolower($c)).'_</td>';
            $c=str_replace('_',' ',$c);
            $c=strtoupper($c);
            $th.='<th style="background: #00366F;color:white">'.$c.'</th>';
        }

    }

    $th='<thead><tr>'.$th.'</tr></thead>';
    $tr='<tr style="">'.$tr.'</tr>';

    $condicoes=($_POST['condicoes']);

    $selecionadas=$db->escape_string($_POST['tabelas']);
    $selecionadas=explode(",",$selecionadas);

    if($colunas == ""){
        $colunas = "*";
    }

    $sql = "select ".$colunas." from ".$selecionadas[0]."";

    unset($selecionadas[0]);
    foreach($selecionadas as $selecionada){
        $sql.=" $selecionada";
    }

    if(isset($_GET['count']) && $_POST['only_count']==0){
        $condicoes="";
    }

    if($condicoes!=""){
        $sql.=" where $condicoes ";
    }

    if(isset($_POST['testar']) && $_POST['testar']==1){
        $sql.=" limit 0,1000";
    }



    $sql=strtolower($sql);

    $sql=str_replace('drop','',$sql);
    $sql=str_replace('DROP','',$sql);
    $sql=str_replace('Drop','',$sql);
    $sql=str_replace('delete','',$sql);
    $sql=str_replace('DELETE','',$sql);
    $sql=str_replace('Delete','',$sql);
    $sql=strtolower($sql);
    $sql=str_replace('inner join','left join',$sql);


    if($_POST['guardar']==1){

        if($colunas=="*" || $_POST['tabelas']==""){
            print "erro";
        }else{
            $json_com_colunas_selecionadas = $db->escape_string($_POST['json_com_colunas_selecionadas']);
            $colunas=$db->escape_string($_POST['colunas']);
            $selecionadas=$db->escape_string($_POST['tabelas']);
            $nome_relatorio=$db->escape_string($_POST['nome_relatorio']);
            $categoria=$db->escape_string($_POST['categoria']);
            $condicoes=$db->escape_string($_POST['condicoes']);
            $query=base64_encode($sql);
            $sql="insert into relatorios (nome_relatorio,categoria,colunas,tabelas,condicoes,query,id_criou,created_at,json_com_colunas_selecionadas) values ('$nome_relatorio','$categoria','$colunas','$selecionadas','$condicoes','$query','".$_SESSION['id_utilizador']."','".current_timestamp."','$json_com_colunas_selecionadas')";
            $result = runQ($sql, $db, "guardar relatorio");
            print 0;
            $db->close();
            die();
        }
    }


    $count=0;
    $primeira=0;
    if($_POST['guardar']==0) {
        $result = runQ($sql, $db, "executar query do relatorio");
        // Output each row of the data, format line as csv and write to file pointer
        $linhas = "";
        $totais=[];
        if ($result->num_rows > 0) {
            $cor_linha = '#a6dbff';
            while ($row = $result->fetch_assoc()) {

                if(isset($_GET['count'])){
                    $count=$row['count(*)'];
                    continue;
                }

                $status = ($row['ativo'] == 1) ? 'Ativo' : 'Inativo';

                $linha_tmp=$tr;
                $linha_tmp = str_replace("_bg_", $cor_linha, $linha_tmp);
                if ($cor_linha == "#fffffff") {
                    $cor_linha = "#a6dbff";
                } else {
                    $cor_linha = "#fffffff";
                }
                foreach ($row as $key => $value) {

                    if($primeira==0){
                        $th_totais.='<th style="background: #00366F;color:white;text-align: right">_TOTAIS'.str_replace('_','',$key).'_</th>';
                    }

                    $coord=str_replace('_','',$key);
                    $coord=strtolower($coord);

                    if(!isset($totais[$coord])){
                        $totais[$coord]=[
                            'sum'=>0,
                            'count'=>0,
                        ];
                    }
                    if(is_numeric($value)){
                        $totais[$coord]['sum']+=$value;
                        $value=number_format($value,2,",","");
                    }else{
                        $totais[$coord]['count']++;
                    }
                    $linha_tmp = str_replace('_' . $coord . '_', $value, $linha_tmp);

                }

                $linhas .= $linha_tmp;
                $primeira=1;
            }

        }


        if(isset($_GET['count']) && $_POST['only_count']==1){
            print $count;
            $db->close();
            die;
        }

        $th_totais='<thead><tr>'.$th_totais.'</tr></thead>';
        foreach ($totais as $key => $value){
            $v=$value['count'];
            if($value['sum']!=0){
                $v=$value['sum'];
            }
            $v=number_format($v,2,",","");
            $th_totais=str_replace("_TOTAIS$key"."_",$v,$th_totais);
        }

        $nome_relatorio="relatorio";
        if(isset($_POST['nome_relatorio'])){
            $nome_relatorio=$_POST['nome_relatorio'];
        }

        if((!isset($_POST['testar']) || $_POST['testar']==0) && !isset($_GET['count']) || $_GET['count']==0) {
            header("Content-Type: application/vnd.ms-excel");
            header("Expires: 0");
            header("Content-Disposition: attachment; filename=$nome_relatorio.xls");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        }


        if(!isset($_GET['count'])) {
            print "
                <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//PT\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
                    <html xmlns=\"http://www.w3.org/1999/xchtml\">
                    <head>
                        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                        
                        <style>
                            body{
                                color: black;
                                border-width: thin;
                                font-size: 16px;
                            }
                            table{
                                border: 1px solid darkgray;
                
                                border-collapse: collapse;
                            }
                            th{
                                border: thin solid darkgray;
                                border-collapse: collapse;
                            }
                            tr{
                                border: thin solid darkgray;
                                border-collapse: collapse;
                            }
                            td{
                                border: thin solid darkgray;
                                border-collapse: collapse;
                                padding: 5px;
                                vertical-align: middle;
                            }
                
                        </style>
                        
                    </head>
                    <body>
                <table>
                $th
                <tbody>
                $linhas
                </tbody>
                $th_totais
                
                </table>
                
                    </body>
                    </html>
                ";
        }
    }
    if(!isset($_GET['count'])) {
        $db->close();
        die;
    }
}