<?php

if(isset($_COOKIE['user_id'])){
    unset($_COOKIE['user_id']);
    setcookie('user_id', null, -1, '/');
}
setcookie("lembrar-me", "", time()-3600);
include_once 'valida.php';
session_destroy();
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("Location: http://$host$uri/");
