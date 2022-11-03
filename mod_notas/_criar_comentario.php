<?php

if(isset($_POST['id'])){

    $descricao=($_POST['content']);
    $pings=($_POST['pings']);
    $modulo=($_POST['modulo']);
    $id_item=($_POST['id_item']);

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
    $_POST['parent']=$parent;
    $_POST['comentario']=1;
    $_POST['return_comentario']=1;

    include "criar.php";

}