<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */



$sql_preencher="select * from estados_viatura where ativo=1";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {

    $selected = "";


    if(isset($row['id_estado']) && $row['id_estado'] == $row_preencher['id_estado_viatura']){
        $selected="selected";
    }

    $ops.="<option $selected class='id_estado' value='".$row_preencher["id_estado_viatura"]."'>".$row_preencher["nome_estado_viatura"]."</option>";
}
$content=str_replace("_estadosviaturas_",$ops,$content);


/* GET TECNICOS */
$addd_sql="";
if(isset($row)){
    $addd_sql = 'and id_tecnico <> "'.$row['id_tecnico'].'"';
}
$ops="";
$utilizadores = getInfoTabela('utilizadores ',
    ' and ativo = 1 and id_utilizador not in (select id_tecnico from viaturas where ativo=1 '.$addd_sql.') ');
foreach($utilizadores as $utilizador){

    $selected="";
    if(isset($row) && $row['id_tecnico'] == $utilizador['id_utilizador']){
        $selected = "selected";
    }

    $ops.="<option $selected value='".$utilizador['id_utilizador']."'>".$utilizador['nome_utilizador']."</option>";

}


$content=str_replace('_tecnicos_', $ops, $content);