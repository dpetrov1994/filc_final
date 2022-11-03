<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");
$db=ligarBD(1);

$id="";
if(isset($_GET['id'])){
    $id=$db->escape_string($_GET['id']);
}else{
    $erro="Grupo inválido.";
}

$sql="select * from utilizadores
      inner join grupos_utilizadores on grupos_utilizadores.id_utilizador=utilizadores.id_utilizador
      where ativo=1 and id_grupo=$id and utilizadores.id_utilizador!=".$_SESSION['id_utilizador']." order by nome_utilizador asc";
$result=runQ($sql,$db,2);
$ops="";
while ($row = $result->fetch_assoc()) {
    $ops.="<option selected value='".$row['id_utilizador']."'> ".removerHTML(cortaNome($row['nome_utilizador']))." [U#".$row['id_utilizador']."]</option>";
}
$db->close();

print $ops;
