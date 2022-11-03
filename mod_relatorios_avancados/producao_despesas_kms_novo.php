<?php

include "../login/valida.php";

if($admin==0){
    die();
}

include "../conf/dados_plataforma.php";
include "../_funcoes.php";
$db=ligarBD();

if(isset($_GET['get_form'])){

    $equipas="<option value='0'>Todas</option>";
    $sql="select * from utilizadores where ativo=1 and system=0 order by numero_equipa*1";
    $result= runQ($sql, $db, "obter info ");
    while ($row = $result->fetch_assoc()) {
        $equipas.="<option value='".$row['id_utilizador']."'>E".$row['numero_equipa']." - ".$row['nome_utilizador']."</option>";
    }

    $projetos="";
    $sql="select * from projetos where ativo=1 order by id_projeto desc";
    $result= runQ($sql, $db, "obter info ");
    while ($row = $result->fetch_assoc()) {
        $projetos.="<option value='".$row['id_projeto']."'>".$row['nome_projeto']."</option>";
    }

    print '
    <form action="producao_despesas_kms_novo.php">
                        <div class="form-group">
                            <label class="col-form-label">Projeto</label>
                            <select name="id_projeto" required class="select-select2 form-control" style="width: 100%">'.$projetos.'</select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Equipa</label>
                            <select name="id_equipa" required class="select-select2 form-control" style="width: 100%">'.$equipas.'</select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-success"> Gerar Relatório</button>
                        </div>
    </form>
    ';

    die();
}




$id_projeto=$db->escape_string($_GET['id_projeto']);
$id_equipa=$db->escape_string($_GET['id_equipa']);

$projeto=[];
$sql="select * from projetos where id_projeto='$id_projeto'";
$result= runQ($sql, $db, "obter info ");
while ($row = $result->fetch_assoc()) {
    $nome_projeto=$row['nome_projeto'];
    $preco_ua=$row['preco_ua'];
    $projeto=$row;
}


header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
//header("Content-Disposition: attachment; filename=producao, despesas e KMs.xls");
header("Content-Disposition: attachment; filename=\""."producao vs despesas (".normalizeString($nome_projeto).").xls"."\"");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");


$data_gerado=current_timestamp;


$linhas="";

if($id_equipa!=0){
    $id_equipa=" and id_utilizador='$id_equipa'";
}else{
    $id_equipa="";
}
$cor_linha = '#a6dbff';
$sql="select * from utilizadores where 1 and system=0 and ativo=1 $id_equipa";
$result= runQ($sql, $db, "obter info ");
while ($row = $result->fetch_assoc()) {
    $nome_equipa = $row['nome_utilizador'];
    $numero_equipa = $row['numero_equipa'];

    $tipo_funcionario = $row['tipo_funcionario'];
    if ($tipo_funcionario == "SE") {
        $coluna_valor_ua = "preco_ua_se";
        $coluna_valor_tarefa = "valorse";
    } elseif ($tipo_funcionario == "Funcionario") {
        $coluna_valor_ua = "preco_ua";
        $coluna_valor_tarefa = "valor";
    } else {
        $coluna_valor_ua = 'preco_ua';
        $coluna_valor_tarefa = "valor";
    }

    $despesas = 0;
    $sql2 = "select sum(valor) from fichas_ponto_despesas where id_projeto='$id_projeto' and id_utilizador='" . $row['id_utilizador'] . "'";
    $result2 = runQ($sql2, $db, "despesas ");
    while ($row2 = $result2->fetch_assoc()) {
        $despesas += $row2['sum(valor)'];
    }

    $modo = "Desconhecido";
    if ($projeto['modo'] == "or") {
        $modo = "Valor Orçamento";
    } elseif ($projeto['modo'] == "ua") {
        $modo = "Valor UA";
    }

    $producao = "-";
    $diferenca = "-";
    if ($modo != "Desconhecido") {
        $producao = 0;
        $diferenca = 0;


        //ir contar o valor das tarefas

        $sql2 = "select * from producao where id_projeto='$id_projeto' and (aprovado=1 or preaprovado=1) and ativo=1 and id_equipa='" . $row['id_utilizador'] . "'";
        $result2 = runQ($sql2, $db, "producao");
        while ($row2 = $result2->fetch_assoc()) {
            if ($projeto['modo'] == "ua") {
                $sql3 = "select (ua) from elementos where id_elemento='" . $row2['id_elemento'] . "' and ativo=1 ";
                $result3 = runQ($sql3, $db, "uas dos elementos");
                while ($row3 = $result3->fetch_assoc()) {
                    $conta = $row3['ua'] * trim($projeto[$coluna_valor_ua]);
                    $producao += $conta;
                }
            } elseif ($projeto['modo'] == "or") {
                $sql3 = "select * from producao_tarefas inner join tarefas on tarefas.id_tarefa=producao_tarefas.id_tarefa where id_producao='" . $row2['id_producao'] . "' and ativo=1";
                $result3 = runQ($sql3, $db, "SELCET tarefas");
                while ($row3 = $result3->fetch_assoc()) {

                    $valor_tarefa = $row3[$coluna_valor_tarefa];
                    $valor_tarefa=trim($valor_tarefa);

                    if ($row3['tarefa_or'] == 1) {
                        $valor_or_elemento = 0;
                        $sql4 = "select valor_or from elementos where id_elemento='" . $row2['id_elemento'] . "' and ativo=1 ";
                        $result4 = runQ($sql4, $db, "uas dos elementos");
                        while ($row4 = $result4->fetch_assoc()) {
                            $valor_or_elemento = $row4['valor_or'];
                        }
                        $valor_tarefa = $valor_or_elemento;
                    }

                    if(!is_numeric($valor_tarefa)){
                        $valor_tarefa=0;
                    }

                    if ($row3['multiplicar'] == 1) {
                        $valor_tarefa = $valor_tarefa * $row3['qnt'];
                    }

                    $producao += $valor_tarefa;
                }
            }
        }

        $diferenca = $producao - $despesas;

        $despesas=number_format($despesas, 2, ".", "");
        $producao=number_format($producao, 2, ".", "");
        $diferenca=number_format($diferenca, 2, ".", "");
    }

    if ($cor_linha == "#fffffff") {
        $cor_linha = "#a6dbff";
    } else {
        $cor_linha = "#fffffff";
    }

    $linha = '<tr>
                <td style="background: '.$cor_linha.';" >E' . $numero_equipa . ' - ' . $nome_equipa . '</td>
                <td style="background: '.$cor_linha.';" >' . $row['tipo_funcionario'] . '</td>
                <td style="background: '.$cor_linha.';text-align:right" >' . $despesas . '</td>
                <td style="background: '.$cor_linha.';" >' . $modo . '</td>
                <td style="background: '.$cor_linha.';text-align:right" >' . $producao . '</td>
                <td style="background: '.$cor_linha.';text-align:right" >' . $diferenca . '</td>
</tr>';

    $linhas.=$linha;
}

$pagina = '
            <table>
                <thead>
                <tr>
                <th style="background: #00366F;color:white">Equipa</th>
                <th style="background: #00366F;color:white">Tipo</th>
                <th style="background: #00366F;color:white">Despesas registadas</th>
                <th style="background: #00366F;color:white">Modo contabilização do projeto</th>
                <th style="background: #00366F;color:white">Produção</th>
                <th style="background: #00366F;color:white">Diferença</th>
</tr>
</thead>
                <tbody> 
                    '.$linhas.'
                </tbody>
            </table>

    ';




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

