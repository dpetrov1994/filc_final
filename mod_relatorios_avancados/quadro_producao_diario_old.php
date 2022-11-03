<?php

include "../login/valida.php";

if($admin==0){
    die();
}

include "../conf/dados_plataforma.php";
include "../_funcoes.php";
$db=ligarBD();

if(isset($_GET['get_form'])){


    $form = '
    <form action="quadro_producao_diario.php">
                        <div class="form-group">
                            <label class="col-form-label">Valor dia do chefe equipa.</label>
                            <input class="form-control" name="valor_dia_chefe" value="0" type="number">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Valor dia do Aprendiz</label>
                            <input class="form-control" name="valor_dia_aprendiz" value="0" type="number">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Valor da viatura equipa</label>
                            <input class="form-control" name="valor_dia_viatura" value="0" type="number">
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                            <span>Entre datas</span>
                            <div class="input-group input-group-xs" style="width: 100%">
                                <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                                    <input id="data_inicio" name="data_inicio" value="" class="form-control" placeholder="Data início" type="text">
                                    <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                    <input id="data_fim" name="data_fim" value="" class="form-control" placeholder="Data fim" type="text">
                                    <span class="input-group-btn">
                                    <button type="submit" class="btn btn-effect-ripple btn-primary btn-sm" style="overflow: hidden; position: relative;"><i class="fa fa-search"></i> <span class="hidden-xs"></span></button>
                                </span>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Estado da produção</label>
                            <select id="estado" name="estado"  class="select-select2 input-sm" style="width: 100%;" data-placeholder="Selecione..">
                                <option value="todos">Todos</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                _estado_
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Estado pagamento</label>
                            <select id="pago" name="pago"  class="select-select2 input-sm" style="width: 100%;" >
                                <option value="">Todos</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                _pago_
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Estado enviado</label>
                            <select id="enviado" name="enviado"  class="select-select2 input-sm" style="width: 100%;" >
                                <option value="">Todos</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                _enviado_
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-success"> Gerar Relatório</button>
                        </div>
    </form>
    ';

    $ops="";
    $estados=[
        "Preenchido",
        "Pre-aprovado",
        "Rejeitado",
        "Impedimento",
        "Aprovado (admin)",
        "Rejeitado (admin)",
    ];
    foreach ($estados as $val){
        $ops.="<option value='".$val."'>".$val."</option>";
    }
    $form=str_replace("_estado_",$ops,$form);


    $estado_pago=[
        "0"=>"Não pago",
        "1"=>"Pago"
    ];
    $ops="";
    foreach ($estado_pago as $key=>$val){
        $ops.="<option value='".$key."'>".$val."</option>";
    }
    $form=str_replace("_pago_",$ops,$form);

    $estado_enviado=[
        "0"=>"Não enviado",
        "1"=>"Enviado"
    ];
    $ops="";
    foreach ($estado_enviado as $key=>$val){
        $ops.="<option value='".$key."'>".$val."</option>";
    }
    $form=str_replace("_enviado_",$ops,$form);

    print $form;
    die();
}




//print_r($_GET);

$data_inicio=data_portuguesa($_GET['data_inicio']);
$data_inicio=date("Y-m-d",strtotime($data_inicio));
$data_fim=data_portuguesa($_GET['data_fim']);

/*
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
//header("Content-Disposition: attachment; filename=producao, despesas e KMs.xls");
header("Content-Disposition: attachment; filename=\""."quando_producao_diario (".normalizeString($data_inicio)." até ".normalizeString($data_fim).").xls"."\"");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
*/
$data_fim=date("Y-m-d",strtotime($data_fim." + 1 day"));

$data_gerado=current_timestamp;






$period = new DatePeriod(
    new DateTime($data_inicio),
    new DateInterval('P1D'),
    new DateTime($data_fim)
);
$days=[];
foreach ($period as $key => $value) {
    $value=$value->format('Y-m-d')      ;
    $days[]=$value;
}


$add_sql="";

if(isset($_GET['estado']) && $_GET['estado']!="" && $_GET['estado']!="todos"){
    $estado=$db->escape_string($_GET['estado']);
    if($estado=="Preenchido"){
        $add_sql.=" and (aprovado is null and preaprovado is null) ";
    }elseif($estado=="Pre-aprovado"){
        $add_sql.=" and preaprovado=1 and (aprovado is null || aprovado=0)";
    }elseif($estado=="Rejeitado"){
        $add_sql.=" and preaprovado=0 and (aprovado is null || aprovado=0)";
    }elseif($estado=="Impedimento"){
        $add_sql.=" and preaprovado=2 and (aprovado is null || aprovado=0)";
    }elseif($estado=="Aprovado (admin)"){
        $add_sql.=" and aprovado=1";
    }elseif($estado=="Rejeitado (admin)"){
        $add_sql.=" and aprovado=0";
    }
}

if(isset($_GET['pago']) && $_GET['pago']!=""){
    $pago=$db->escape_string($_GET['pago']);
    $add_sql.=" and pago='$pago' ";
}

if(isset($_GET['enviado']) && $_GET['enviado']!=""){
    $enviado=$db->escape_string($_GET['enviado']);
    $add_sql.=" and enviado='$enviado' ";
}


$equipas=[];
$sql="select distinct(id_equipa) as id_equipa from producao where data_inicio>='$data_inicio 00:00:00' and data_fim<='$data_fim 23:59:59' and ativo=1 $add_sql";
$result=runQ($sql,$db,"equipas");
while($row = $result->fetch_assoc()){
    $id_equipa=$row['id_equipa'];
    $sql2="select * from utilizadores where id_utilizador='$id_equipa'";
    $result2=runQ($sql2,$db,"dados equipas");
    while($row2 = $result2->fetch_assoc()){
        $equipas[]=$row2;
    }
}



$head_days="";
foreach ($days as $day){
    $data_str=$cfg_diasdasemana[date('w', strtotime($day))]."<br> ".date("d",strtotime($day))."/".$cfg_meses_abr[date("m",strtotime($day))*1]." <br> ".date("Y",strtotime($day));
    $head_days.="<th style='_style".$day."_'>$data_str</th>";

    if(!isset($totais_dia[$day])){
        $totais_dia[$day]=0;
    }
}//for each dias

$totais_producao_todas_equipas=0;
$totais_despesas_todas_equipas=0;
$totais_pago_todas_equipas=0;
$totais_registos=0;

foreach ($equipas as $eqipa){
    $body_days="";
    $evolucao=0;
    $pago=0;
    $total_despesas=0;
    $qnt_registos=0;
    foreach ($days as $day){

        //verificar se a equipa tem ajudantes
        $membros_equipa=[];
        $membros_equipa[]=$eqipa['id_utilizador'];
        $sql="select * from fichas_ponto where id_chefe_equipa='".$eqipa['id_utilizador']."' and data_inicio like '$day%' and ativo=1";
        $result=runQ($sql,$db,"fichas de ponto do dia $day da equipa ".$eqipa['id_utilizador']);
        while($row = $result->fetch_assoc()){
            $membros_equipa[]=$row['id_utilizador'];
        }


        /**cáclculo producao*/

        $valor_producao=0;
        $registos_hoje=0;

        foreach ($membros_equipa as $membro){

        }
        $sql="select * from producao where data_inicio like '$day%' and id_equipa='".$eqipa['id_utilizador']."' and ativo=1 $add_sql";
        $result=runQ($sql,$db,"producao do dia da equipa");
        $registos_hoje+=$result->num_rows;
        $qnt_registos+=$registos_hoje;
        $totais_registos+=$result->num_rows;
        while($row = $result->fetch_assoc()){


            $projeto=[];
            $sql2="select * from projetos where id_projeto='".$row['id_projeto']."'";
            $result2=runQ($sql2,$db,"dados do projeto");
            while($row2 = $result2->fetch_assoc()){
                $projeto=$row2;
            }

            $elemento=[];
            $sql2="select * from elementos where id_elemento='".$row['id_elemento']."'";
            $result2=runQ($sql2,$db,"dados do elemento");
            while($row2 = $result2->fetch_assoc()){
                $elemento=$row2;
            }

            if($projeto['modo']!="or" && $projeto['modo']!="ua"){
                $projeto['modo']="or";
            }


            $projeto['modo']="or"; // -> forçar por tarefa, pedido por email FW: RELATÓRIO | Quadro Diário de Produção Por Equipa -> Aug 2, 2022, 5:12 PM
            if($projeto['modo']=="ua"){
                //se for um projeto à UA
                if($eqipa['tipo_funcionario']=='SE'){
                    if(!is_numeric($projeto['preco_ua_se'])){
                        $projeto['preco_ua_se']=0;
                    }
                    $valor_producao+=($elemento['ua']*$projeto['preco_ua_se']);
                }else{
                    if(!is_numeric($projeto['preco_ua'])){
                        $projeto['preco_ua']=0;
                    }
                    $valor_producao+=($elemento['ua']*$projeto['preco_ua']);
                }

            }else{


                //se for à tarefa

                $sql2="select * from producao_tarefas where id_producao='".$row['id_producao']."'";
                $result2=runQ($sql2,$db,"tarefas feitas na producao");
                while($row2 = $result2->fetch_assoc()){
                    $sql3="select * from tarefas where id_tarefa='".$row2['id_tarefa']."'";
                    $result3=runQ($sql3,$db,"dados dads tarefas da producao");
                    while($row3 = $result3->fetch_assoc()){
                        if(!is_numeric($row2['qnt'])){
                            $row2['qnt']=1;
                        }
                        $qnt=$row2['qnt'];

                        $coluna_valor="";
                        if($eqipa['tipo_funcionario']=='SE'){
                            $coluna_valor='valorse';
                        }else{
                            $coluna_valor='valor';
                        }

                        if(!is_numeric($row3[$coluna_valor])){
                            $row3[$coluna_valor]=0;
                        }
                        $valor_tarefa=$row3[$coluna_valor];

                        if($row3['multiplicar']==1){
                            $valor_tarefa=$valor_tarefa*$qnt;
                        }

                        if($row3['tarefa_or']==1){
                            if(!is_numeric($elemento['valor_or'])){
                                $elemento['valor_or']=0;
                            }
                            $valor_tarefa=$elemento['valor_or'];
                        }

                        $valor_producao+=$valor_tarefa;

                    }//dados da tarefa

                }//todas tarefas da producao

            }//se for à tarefa

            $evolucao+=$valor_producao;

            if($row['pago']==1){
                $pago+=$valor_producao;
                $totais_pago_todas_equipas+=$valor_producao;
            }

        } //select producao do dia


        /**cáclculo despesas */
        $total_despesas_do_dia=0;
        if($registos_hoje>0){

            $despesas=0;
            $sql="select * from fichas_ponto_despesas where id_utilizador='".$eqipa['id_utilizador']."' and data_despesa like '$day%' and ativo=1";
            $result=runQ($sql,$db,"despesas do dia $day da equipa ".$eqipa['id_utilizador']);
            while($row = $result->fetch_assoc()){
                if(is_numeric($row['valor'])){
                    $despesas+=$row['valor']*1;
                }
            }

            $despesas_kms=0;
            $viaturas_kms=[];
            $sql="select * from fichas_ponto where id_utilizador='".$eqipa['id_utilizador']."' and data_inicio like '$day%' and ativo=1";
            $result=runQ($sql,$db,"fichas de ponto do dia $day da equipa ".$eqipa['id_utilizador']);
            while($row = $result->fetch_assoc()){
                $diff_kms=0;
                if(is_numeric($row['km_inicio']) && is_numeric($row['km_fim'])){
                    $diff_kms=$row['km_fim']-$row['km_inicio'];
                }
                $id_viatura=$row['id_viatura'];
                $sql2="select * from viaturas where id_viatura='$id_viatura'";
                $result2=runQ($sql2,$db,"dados equipas");
                while($row2 = $result2->fetch_assoc()){
                    if(!isset($viaturas_kms[$id_viatura])){
                        $row2['total_kms']=0;
                        $viaturas_kms[$id_viatura]=$row2;
                    }
                }
                $viaturas_kms[$id_viatura]['total_kms']+=$diff_kms;
            }

            foreach ($viaturas_kms as $viatura){
                if(is_numeric($viatura['preco_km'])){
                    $despesas_kms+=$viatura['total_kms']*$viatura['preco_km'];
                }
            }

            $despesas_custo_equipa=0;
            if(is_numeric($eqipa['custo_por_dia'])){
                $despesas_custo_equipa=$eqipa['custo_por_dia'];
            }


            /*
            $valor_dia=0;
            if($eqipa['tipo_funcionario']=='Chefe de equipa'){
                if(is_numeric($_GET['valor_dia_chefe'])){
                    $valor_dia=$_GET['valor_dia_chefe'];
                }
            }

            $valor_dia_viatura=0;
            if(is_numeric($_GET['valor_dia_viatura'])){
                $valor_dia_viatura=$_GET['valor_dia_viatura'];
            }

            if($eqipa['tipo_funcionario']=='Aprendiz'){
                if(is_numeric($_GET['valor_dia_aprendiz'])){
                    $valor_dia=$_GET['valor_dia_aprendiz'];
                    $despesas_kms=0;
                    $valor_dia_viatura=0;
                }
            }

            if($valor_dia!=0){
                $despesas_custo_equipa=$valor_dia;
                $despesas=0;
            }
            if($valor_dia_viatura!=0){
                $despesas_custo_equipa+=$valor_dia_viatura;
                $despesas_kms=0;
            }
            */

            $total_despesas_do_dia=$despesas_custo_equipa+$despesas+$despesas_kms;

        }
        $total_despesas+=$total_despesas_do_dia;
        /**FIM cáclculo despesas */

        $totais_dia[$day]+=$valor_producao;

        if($registos_hoje==0){
            $body_days.="<td style='text-align: right;background:#5F86CC;_style".$day."_'></td>";
        }else{

            $cor_despesas="lightgreen";
            if($valor_producao-$total_despesas_do_dia<0){
                $cor_despesas="yellow";
            }
            if($valor_producao==0){
                $cor_despesas="orange";
            }

            $body_days.="<td style='text-align: right;background: $cor_despesas;_style".$day."_'>".number_format($valor_producao,2,".","")."</td>";
        }




        /**FIM cáclculo producao*/


    }//for each dias

    $totais_producao_todas_equipas+=$evolucao;
    $totais_despesas_todas_equipas+=$total_despesas;

    $cor_despesas="lightgreen";
    if($evolucao-$total_despesas<0){
        $cor_despesas="yellow";
    }

    $cor_pago="lightblue";
    if($pago==0){
        $cor_pago="lightcyan";
    }

    $cor_pagar="lightcyan";
    if($evolucao-$pago>0){
        $cor_pagar="lightblue";
    }



    $tr.="<tr>
<td style='text-align: right'>".number_format($evolucao,2,".","")."</td>
<td>Como calcular objetivo?</td>
<td>".$eqipa['nome_utilizador']."</td>
<td>".$eqipa['tipo_funcionario']."</td>
<td>".$ajudantes."</td>
$body_days
<td style='text-align: right;background: lightgrey'>".number_format($qnt_registos,0,".","")."</td>
<td style='text-align: right;background: yellow'>".number_format($total_despesas,2,".","")."</td>
<td style='text-align: right;background: lightgreen'>".number_format($evolucao,2,".","")."</td>
<td style='text-align: right;background: $cor_despesas'>".number_format($evolucao-$total_despesas,2,".","")."</td>
<td style='text-align: right;background: $cor_pago'>".number_format($pago,2,".","")."</td>
<td style='text-align: right;background: $cor_pagar'>".number_format($evolucao-$pago,2,".","")."</td>
</tr>";

}//for each eaquipas


$totais_dia_todas_equipas="";
$dias_esconder=[];//fins de semana a esconder
foreach ($totais_dia as $day => $total_dia){

    $dia_da_semana=date('w', strtotime($day));
    if($dia_da_semana==0 || $dia_da_semana==6){//se é domingo ou sabado
        if($total_dia==0){
            $dias_esconder[]=$day;
        }
    }

    $totais_dia_todas_equipas.="<td style='text-align: right; _style".$day."_'>".number_format($total_dia,2,".","")."</td>";
}

$tr.="<tr style='background: #D9E1F2'>
<td style='text-align: right'></td>
<td></td>
<td></td>
<td></td>
<td>Total geral</td>
$totais_dia_todas_equipas
<td style='text-align: right'>".number_format($totais_registos,0,".","")."</td>
<td style='text-align: right'>".number_format($totais_despesas_todas_equipas,2,".","")."</td>
<td style='text-align: right'>".number_format($totais_producao_todas_equipas,2,".","")."</td>
<td style='text-align: right'>".number_format($totais_producao_todas_equipas-$totais_despesas_todas_equipas,2,".","")."</td>
<td style='text-align: right'>".number_format($totais_pago_todas_equipas,2,".","")."</td>
<td style='text-align: right'>".number_format($totais_producao_todas_equipas-$totais_pago_todas_equipas,2,".","")."</td>
</tr>";

$pagina = '
            <table>
                <tbody>
                <tr>
                    <td>Gerado em:</td>
                    <td style="text-align: right">'.$data_gerado.'</td>
                </tr>
                <tr>
                    <td>Gerado por:</td>
                    <td style="text-align: right">'.$_SESSION['nome_utilizador'].'</td>
                </tr>
                <tr>
                    <td>Valor dia do chefe equipa</td>
                    <td style="text-align: right">'.$_GET['valor_dia_chefe'].'</td>
                </tr>
                <tr>
                    <td>Valor dia do Aprendiz</td>
                    <td style="text-align: right">'.$_GET['valor_dia_aprendiz'].'</td>
                </tr>
                <tr>
                    <td>Valor da viatura equipa</td>
                    <td style="text-align: right">'.$_GET['valor_dia_viatura'].'</td>
                </tr>
                <tr>
                    <td>Intervalo inicio</td>
                    <td style="text-align: right">'.$_GET['data_inicio'].'</td>
                </tr>
                <tr>
                    <td>Intervalo fim</td>
                    <td style="text-align: right">'.$_GET['data_fim'].'</td>
                </tr>
                </tbody>
            </table>
            
            
            <table>
            <tbody>
            <tr>
            <td></td>
</tr>
</tbody>
</table>
            
            
            <table>
            <thead>
                <tr>
                    <th>Legenda</th>
                    <th>Cor</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>Dia sem produção</td>
                <td style="background:#5F86CC"></td>
            </tr>
            <tr>
                <td>Existe produção lançada, mas o total é 0 (validar configuração do projeto/tarefas)</td>
                <td style="background:orange"></td>
            </tr>
            <tr>
                <td>Valor da produção/Produção maior que as despesas</td>
                <td style="background:lightgreen"></td>
            </tr>
            <tr>
                <td>Valor das despesas/Despesas maior que a produção</td>
                <td style="background:yellow"></td>
            </tr>
            <tr>
                <td>Valor a pagar é 0.00 / Pago é 0.00</td>
                <td style="background:lightcyan"></td>
            </tr>
            <tr>
                <td>Valor a pagar é superior a 0.00 / Valor Pago é superior 0.00</td>
                <td style="background:lightblue"></td>
            </tr>
</tbody>
</table>

            <table>
            <tbody>
            <tr>
            <td></td>
</tr>
</tbody>
</table>
            
            <table>
            <thead>
            <tr style="background: #D9E1F2">
            <th>Evolução até<br> ao momento</th>
            <th>Percentagem até<br> ao objetivo</th>
            <th>Equipas</th>
            <th>Tipo func.</th>
            <th>Ajudantes</th>
            '.$head_days.'
            <th>Qnt<br> Registos</th>
            <th>Total<br> despesas</th>
            <th>Total<br> produção</th>
            <th>Produção <br> vs<br> despesas</th>
            <th>Total<br> pago</th>
            <th>Total<br> a pagar</th>
</tr>
</thead>
<tbody>
'.$tr.'
</tbody>
</table>

    ';

foreach ($dias_esconder as $day){
    $pagina=str_replace("_style".$day."_","display:none",$pagina);
}

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
$pagina
    </body>
    </html>
";

$db->close();
?>

