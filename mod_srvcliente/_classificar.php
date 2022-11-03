<?php
include ("../_funcoes.php");
include ("../conf/dados_plataforma.php");
include ("../login/valida.php");

$db=ligarBD("mysql");


if(isset($_GET['id_cliente']) && isset($_GET['classificacao'])){
    $id_cliente=$db->escape_string($_GET['id_cliente']);
    $classificacao=$db->escape_string($_GET['classificacao']);
    $sql="select * from srv_clientes_informacao where FederalTaxID='".$id_cliente."'";
    $result=runQ($sql,$db,"ver se tem classificacao");
    if($result->num_rows>0){
        while ($row = $result->fetch_assoc()) {
            if($row['classificacao']==$classificacao){
                $classificacao=0;
            }
        }
        $sql="update srv_clientes_informacao set classificacao='$classificacao' where FederalTaxID='$id_cliente'";
    }else{
        $sql="insert into srv_clientes_informacao (id_cliente,classificacao) values ('$id_cliente','$classificacao')";
    }
    $result=runQ($sql,$db,"update/insert classificacao");

    $response="";
    for($i=1;$i<=5;$i++){
        $estrela="";
        if($i<=$classificacao){
            $estrela="<i class='fa fa-star'></i>";
        }else{
            $estrela="<i class='fa fa-star-o'></i>";
        }
        $response.="<a href='javascript:void(0)' onclick='classificarCliente(".$id_cliente.",$i,this)'>$estrela</a>";
    }

    print $response;
}




$db->close();