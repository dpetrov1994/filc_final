<?php
if(isset($_GET['teste'])){
    die;
}
    include ("_funcoes.php");
    include ("login/valida.php");
    $db=ligarBD('1');
    $tempo=$db->escape_string($_GET['val']);
    $tempo=$tempo*1000*60;
    $sql="select * from utilizadores_conf where id_utilizador='".$_SESSION['id_utilizador']."'";
    $result=runQ($sql,$db,"1");
    if($result->num_rows!=0){
        $sql="update utilizadores_conf set tempo_lock = '$tempo' where id_utilizador='".$_SESSION['id_utilizador']."'";
        $result=runQ($sql,$db,"2");
        $_SESSION['cfg_tempo_lock']=$tempo;
    }
    $db->close();

