<?php
if(isset($_GET['check'])){
    @session_start();
    if(!isset($_SESSION['email_sessao'])){
        echo 1;
        die;
    }
    echo 0;
    die;
}