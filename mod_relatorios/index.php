<?php
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("index.tpl");

if(isset($_GET['gerar_relatorio'])){

    $filtros="";
    foreach ($_POST['operador'] as $key=>$op){
        $val=$_POST['valor'][$key];
        $col=$_POST['coluna'][$key];
        if($op!='none'){
            if($op =='like'){
                $val="%$val%";
            }
            $filtros.= " and ($col $op '$val') ";
        }
    }

    $colunas_mostrar=json_decode($_POST['colunas_mostrar'],true);
    $ordem_colunas="";
    if(is_array($colunas_mostrar)){
        foreach ($colunas_mostrar as $colunas){
            $col=$colunas['id'];
            $ordem_colunas.="$col,";
        }
    }


    $id=$db->escape_string($_GET['gerar_relatorio']);
    $sql="select * from relatorios where id_relatorio='$id'";
    $result = runQ($sql, $db, "SELCET rel");
    while ($row = $result->fetch_assoc()) {
        $query=base64_decode($row['query']);

        if($ordem_colunas!=""){
            $row['colunas']=$ordem_colunas;
        }

        if($row['condicoes']==""){
            $row['condicoes']= " 1 ";
        }

        $_POST['nome_relatorio']=$row['nome_relatorio'];
        $_POST['colunas']=$row['colunas'];
        $_POST['condicoes']=$row['condicoes']." $filtros";
        $_POST['tabelas']=$row['tabelas'];
        $_POST['guardar']=0;

        if($_POST['only_count']==1){
            $_GET['count']=1;
        }

        include "gerar_relatorio.php";

    }
}

$operadores=[
    'none' => 'Não filtrar',
    'like' => 'Contém',
    '=' => 'Igual (=)',
    '!=' => 'Diferente (!=)',
];
$ops="";
foreach ($operadores as $op=>$name){
    $ops.="<option value='$op'>$name</option>";
}
if(isset($_GET['id_relatorio'])){

    $filtros="";
    $ordem="";

    $id=$db->escape_string($_GET['id_relatorio']);
    $sql="select * from relatorios where id_relatorio='$id'";
    $result = runQ($sql, $db, "SELCET rel");
    while ($row = $result->fetch_assoc()) {
        $row['colunas'] = substr($row['colunas'], 0, -1);
        $colunas=explode(",",$row['colunas']);


        $colunas_ordenadas="";
        foreach ($colunas as $coluna){

            $nome_coluna="<b>".$coluna;
            $nome_coluna=str_replace("_"," ",$nome_coluna);
            $nome_coluna=str_replace(".","</b><br>",$nome_coluna);
            $nome_coluna=strtoupper($nome_coluna);

            $colunas_ordenadas.='<li class="dd-item" data-id="'.$coluna.'">
                                    <div class="dd-handle">'.$nome_coluna.'</div>
                                </li>';

            $filtros.="
            <tr>
                <td style='display: none'><input name='coluna[]' value='$coluna' type='hidden'></td>
                <td style='width: 100px;'><small>$nome_coluna</small></td>
                <td><select name='operador[]'>$ops</select></td>
                <td><input name='valor[]' type='text'></td>

            </tr>";
        }

        $_POST['nome_relatorio']=$row['nome_relatorio'];
        $_POST['colunas']=$row['colunas'];
        $_POST['condicoes']=$row['condicoes']." $filtros";
        $_POST['tabelas']=$row['tabelas'];
        $_POST['guardar']=0;
        $_GET['count']=0;

        include "gerar_relatorio.php";

        $cor="success";
        if($count>200000){
            $cor="warning";
        }
        $hide_btn="";
        if($count>500000){
            $cor="danger";
        }
        if($count>2000000){
            $cor="danger";
            $hide_btn="display:none";
        }
        $count=number_format($count,0,","," ");

        $filtros="
<form action='index.php?gerar_relatorio=$id' id='form_gerar_relatorio' method='post'>

<div class='row'>
<div class='col-sm-6'>
    <h4 class=\"sub-header\"><i class=\"fa fa-filter\"></i> Filtros</h4>
    <table class='table table-vcenter'>$filtros</table>
</div>


    
    <input type='hidden' id='only_count' name='only_count' value='0'>
    <div class=\"col-sm-3\">
        <h4 class=\"sub-header\"><i class=\"fa fa-eye\"></i> Colunas a mostrar</h4>
        <div id=\"nestable1\" class=\"dd\">
            <ol class=\"dd-list\">
            $colunas_ordenadas
            </ol>
        </div>
        <textarea style='display: none' id=\"nestable1-output\" name='colunas_mostrar'></textarea>
    </div>
    <div class=\"col-sm-3\">
        <h4 class=\"sub-header\"><i class=\"fa fa-eye-slash\"></i> Colunas a esconder</h4>
        <div id=\"nestable2\" class=\"dd dd-inverse\">
            <ol class=\" dd-empty \">

            </ol>
        </div>
        <textarea style='display: none' id=\"nestable2-output\"></textarea>
    </div>

    <div class=\"col-sm-12\">
        <div class='text-center' id='msg_relatorio'>O relatório sem filtros vai ter <b class='text-$cor'>$count</b> linhas.</div>
        <div class='text-center'><a href='javascript:void(0)' onclick='atualizar_contagem()' class='btn btn-default btn-xs'>Atualizar contagem</a></div>
        <div><br><br></div>
        <button id='botao-gerar-relatorio' class='btn btn-primary btn-lg btn-block ' style='$hide_btn'><i class='fa fa-download'></i> Gerar Relatório</button>
    </div>
    
</div>



</form>

";

    }

    print $filtros;
    $db->close();
    die();

}

$relatorios="";
$sql="select distinct(categoria) as cat from relatorios where ativo=1";
$result = runQ($sql, $db, "SELCET categorias");
while ($row = $result->fetch_assoc()) {

    $rel="";
    $sql2="select * from relatorios where ativo=1 and categoria='".$row['cat']."'";
    $result2 = runQ($sql2, $db, "SELCET relatorios");
    while ($row2 = $result2->fetch_assoc()) {
        $rel.='<div class="col-lg-12"><a onclick="getFiltrosRelatorio(this,'.$row2['id_relatorio'].')" href="javascript:void(0)" ><i class="fa fa-file-text-o"></i> '.$row2['nome_relatorio'].'</a></div>';
    }

    $relatorios.='<div class="col-lg-4">
        <div class="block">
            <div class="block-title"><h4>'.$row['cat'].'</h4></div>
            <div class="block-section row">
            '.$rel.'
            </div>
            <br>
        </div>
    </div>';
}
$content=str_replace("_relatorios_",$relatorios,$content);


/** fFIM FILTROS ADICIONAIS */

$pageScript="
<script> 

 
</script>
<script src='index.js'></script>";
include ('../_autoData.php');