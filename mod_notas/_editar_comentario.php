<?php

if(isset($_POST['id'])){

    $_GET['id']=$_POST['id'];

    $descricao=($_POST['content']);
    $pings=($_POST['pings']);
    $modulo=($_POST['modulo']);
    $id_item=($_POST['id_item']);
    $anexos_para_apagar=($_POST['anexos_para_apagar']);

    if(!isset($_POST['parent'])){
        $_POST['parent']=null;
    }

    $parent=($_POST['parent']);

    $_POST=[];
    $_POST['submit']="";
    $_POST['descricao']=$descricao;
    $_POST['pings']=$pings;
    $_POST['modulo']=$modulo;
    $_POST['id_item']=$id_item;
    $_POST['anexos_para_apagar']=$anexos_para_apagar;
    $_POST['parent']=$parent;
    $_POST['return_comentario']=1;



    include "editar.php";

}