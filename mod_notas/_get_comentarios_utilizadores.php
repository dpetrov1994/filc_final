<?php
include "../login/valida.php";
include "../_funcoes.php";

$db=ligarBD();

$search=$db->escape_string($_GET['search']);
$utilizadores=[];
if($search!=""){
    $sql="select * from utilizadores where nome_utilizador like '%".$search."%' and ativo=1";
    $result=runQ($sql,$db,"get utilizadores");
    while ($row = $result->fetch_assoc()) {

        $u=array();
        $u['id']=$row['id_utilizador'];
        $u['fullname']=$row['nome_utilizador'];
        $u['email']=$row['email'];
        $u['profile_picture_url']="https://support.srv01.pt/_contents/fotos_utilizadores/" . $row['foto'];
        $utilizadores[]=$u;
    }
}

print json_encode($utilizadores);

$db->close();