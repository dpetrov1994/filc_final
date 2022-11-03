<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 26/03/2018
 * Time: 19:07
 */

$sql_preencher="Select nome_utilizador,utilizadores.id_utilizador,email from utilizadores
      inner join grupos_utilizadores on grupos_utilizadores.id_utilizador=utilizadores.id_utilizador
      inner join grupos_mensagens on grupos_mensagens.id_grupo=grupos_utilizadores.id_grupo 
      where ativo=1 and utilizadores.id_utilizador<>'".$_SESSION['id_utilizador']."' group by utilizadores.id_utilizador order by nome_utilizador asc";
$result_preencher=runQ($sql_preencher,$db,"preenchimento de formulario");
$ops="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $ops.="<option class='utilizadores' value='".$row_preencher["id_utilizador"]."'>".$row_preencher["nome_utilizador"]." [#u".$row_preencher["id_utilizador"]."] </option>";
}
$content=str_replace("_utilizadores_",$ops,$content);

//para mesnagem avancada

$sqlGrupos=" and (";
$last="";
$new="";
$innerJoin="inner join grupos_mensagens on grupos_mensagens.comunica_com=grupos.id_grupo";
foreach ($_SESSION['grupos'] as $grupo){
    if($grupo==1){
        $sqlGrupos="";
        $innerJoin="";
        break;
    }elseif ($grupo==2) {
        $sqlGrupos=" and id_grupo<>1 ";
        $innerJoin="";
        break;
    }else{
        $sqlGrupos.=" grupos_mensagens.id_grupo=$grupo or ";
        $last=" grupos_mensagens.id_grupo=$grupo or ";
        $new=" grupos_mensagens.id_grupo=$grupo)";
    }
}
$sqlGrupos=str_replace($last,$new,$sqlGrupos);

$sql_preencher="select * from grupos 
      $innerJoin
      where ativo=1 $sqlGrupos group by grupos.id_grupo order by nome_grupo asc";
$result_preencher=runQ($sql_preencher,$db,"1");
$grupos="";
while ($row_preencher = $result_preencher->fetch_assoc()) {
    $grupos.="<option class='grupos' value='".$row_preencher['id_grupo']."'>".$row_preencher['nome_grupo']."</option>";
}
$content=str_replace("_grupos_",$grupos,$content);