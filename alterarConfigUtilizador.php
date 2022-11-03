<?php
if(isset($_GET['teste'])){
    die;
}
include ("_funcoes.php");
include ("login/valida.php");$db=ligarBD('1');
$coluna=$db->escape_string($_GET['id']);
$checked=$_GET['checked'];$sql="select * from utilizadores_conf where id_utilizador='".$_SESSION['id_utilizador']."'";
$result=runQ($sql,$db,"1");
if($result->num_rows!=0){
    $sql="update utilizadores_conf set $coluna = '$checked' where id_utilizador='".$_SESSION['id_utilizador']."'";
    $result=runQ($sql,$db,"2");
}
//vamos buscar as configurações do utilizador
$sql="select * from utilizadores_conf where id_utilizador='".$_SESSION['id_utilizador']."'";
$result = runQ($sql, $db, 4);
while ($row = $result->fetch_assoc()) {
    $_SESSION['cfg_tempo_lock']=removerHTML($row['tempo_lock']);
    $_SESSION['receber_not_email']=($row['receber_not_email']);
    $_SESSION['receber_not_sms']=$row['receber_not_sms'];
    $_SESSION['mostrar_contacto']=$row['mostrar_contacto'];
    $_SESSION['mostrar_email']=$row['mostrar_email'];
    $_SESSION['mostrar_morada']=$row['mostrar_morada'];
}$db->close();
