<?php
@session_start();

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".@$_SERVER['HTTP_HOST'].@$_SERVER['REQUEST_URI'];

if(!isset($_SESSION['url_inicial'])){
    $_SESSION['url_inicial']=$actual_link;
}

//fim validação diretrório
if(isset($_SESSION['lock']) && $_SESSION['lock']==1){
    if(is_file("lock.php")){
        header("Location: lock.php");
    }elseif(is_file("login/lock.php")){
        header("Location: login/lock.php");
    }else{
        header("Location: ../login/lock.php");
    }
}else{

    if(!isset($_SESSION['nome_utilizador']) && !isset($_SESSION['email_sessao'])){

        if(is_file("login/index.php")){
            header("Location: login/index.php");
        }elseif(is_file("../login/index.php")){
            header("Location: ../login/index.php");
        }elseif(is_file("index.php")) {
            header("Location: index.php");
        }
        exit();
    }
}

