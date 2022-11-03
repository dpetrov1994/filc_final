<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/03/2018
 * Time: 03:10
 */
//se existir $formAction em reciclagem.php
if(!isset($formAction)){
    $formAction="index.php";
}
$content=str_replace("_formAction_",$formAction,$content);

$thead="";
$linhaTD="";
$rules_for_rows=array();
$c=0;
foreach ($colunasParaMostrarNaTabela as $coluna => $regras){
    if($regras=='checkbox'){
        $thead.='<th style="width: 35px;" class="text-center"><label class="csscheckbox csscheckbox-primary"><input type="checkbox"><span></span></label></th>';
        if($subModulo==0){
            $linhaTD.='<td class="text-center"><label class="csscheckbox csscheckbox-primary"><input name="checkboxes[]" value="_idItem_" type="checkbox"><span></span></label></td>';
        }else{
            $linhaTD.='<td class="text-center"><label class="csscheckbox csscheckbox-primary"><input name="checkboxes[]" value="_subItemID_" type="checkbox"><span></span></label></td>';
        }

    }elseif($regras=='funcionalidades'){
        $thead.='<th style="width: 50px;" class="text-center"><i class="fa fa-flash"></i></th>';
        $linhaTD.='<td class="text-center">_funcionalidades_</td>';
    }else{

        if(!isset($ColunasaIgnorarNoFiltroDasTabelas)){
            $ColunasaIgnorarNoFiltroDasTabelas=[];
        }

        if(isset($FilterInTable) && $FilterInTable==1 && !in_array($coluna, $ColunasaIgnorarNoFiltroDasTabelas)){

            if(isset($ColunasNumericas) && in_array($coluna, $ColunasNumericas) || $coluna == "pendente"){
                $thead.="<th style='_style_' class='_class_'><a href='?o=$coluna*1+_order_'>_text_</a></th>";
            }else{
                $thead.="<th style='_style_' class='_class_'><a href='?o=$coluna+_order_'>_text_</a></th>";
            }

        }else{
            $thead.="<th style='_style_' class='_class_'>_text_</th>";
        }

        $linhaTD.="<td style='_style_' class='_class_'>_".$coluna."_</td>";
        $regras=explode("|",$regras);
        foreach ($regras as $regra){
            $explode=explode("::",$regra);
            $regra=$explode[0];
            if(isset($explode[1])){
                $valor=$explode[1];
            }else{
                $valor="";
            }
            $thead=str_replace("_"."$regra"."_","$valor",$thead);
            $linhaTD=str_replace("_"."$regra"."_","$valor",$linhaTD);
            if($regra!="text"){
                $rules_for_rows[$c]['coluna']=$coluna;
                $rules_for_rows[$c]['regra']=$regra;
                $rules_for_rows[$c]['valor']=$valor;
                $c++;
            }
        }
        $thead=str_replace("_class_","",$thead);
        $thead=str_replace("_style_","",$thead);
        $linhaTD=str_replace("_class_","",$linhaTD);
        $linhaTD=str_replace("_style_","",$linhaTD);

    }
}



$tplTabela=str_replace("_thead_",$thead,$tplTabela);
$linhaTD='<tr>'.$linhaTD.'</tr>';

$p="";// string de pesquisa
if(isset($_GET['p'])){
    $p=$db->escape_string($_GET['p']);


}
$content=str_replace("_p_",$p,$content);
$pesquisa=str_replace("  ","",$p);
if($pesquisa!="" and $pesquisa!=" "){
    $palavras=str_replace(" ","+",$pesquisa);
    $palavras=explode("+",(($palavras)));
    $add_sql.="";

    if(isset($_GET['cols'])){

        if(is_array($_GET['cols'])){
            foreach($_GET['cols'] as $col){
                $col=$db->escape_string($col);
                $sql="SHOW COLUMNS FROM $col";
                $result=runQ($sql,$db,"colunas");
                while ($row = $result->fetch_assoc()) {
                    array_push($colunas,"$col.".$row['Field']);
                }
            }
        }else{
            $col=$db->escape_string($_GET['cols']);
            $sql="SHOW COLUMNS FROM $col";
            $result=runQ($sql,$db,"colunas");
            while ($row = $result->fetch_assoc()) {
                array_push($colunas,"$col.".$row['Field']);
            }
        }


    }

    $sql="SHOW COLUMNS FROM $nomeTabela";
    $result=runQ($sql,$db,"colunas");
    while ($row = $result->fetch_assoc()) {
        array_push($colunas,"$nomeTabela.".$row['Field']);
    }

    foreach ($palavras as $palavra){
        if($palavra!=""){
            $add_sql.=" and ( ";
            foreach ($colunas as $coluna){
                $add_sql.=" $coluna like '%$palavra%' or";
            }
            $add_sql.=")";
        }
    }
    $add_sql=str_replace("or)",")",$add_sql);
}

$o=$ordenarPorDefeito; //fichiero .cfg


$opsOrdenar="";
foreach ($opcoesOrdenar as $key=>$value){ //ficheiro .cfg
    $selected="";
    if($o==$key){
        $selected="selected";
        if(isset($_GET['o']) && ($_GET['o'])!=""){
            $o=$db->escape_string($_GET['o']);
        }
    }
    $opsOrdenar.="<option $selected value='$key'>$value</option>";
}
$add_sql.=" order by $o"; //este add_sql é para o count

$pr=20;
if(isset($_GET['pr'])){
    $pr=$db->escape_string($_GET['pr']);
}
$prs=[
    5,10,20,30,40,50,75,100
];
$opsPrs="";
foreach ($prs as $e){
    $selected="";
    if($pr==$e){
        $selected="selected";
    }
    $opsPrs.="<option $selected value='$e'>$e</option>";
}
$pn=1; //número de página
if(isset($_GET['pn'])){
    $pn=$db->escape_string($_GET['pn']);
    $pn=preg_replace('#[^0-9]#', '', $pn);
}

if(isset($_GET['nomeTabela']) && $_GET['nomeTabela']!=$nomeTabela){
    $pn=1;
}
