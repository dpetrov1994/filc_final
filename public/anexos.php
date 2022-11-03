<?php

include "../_funcoes.php";

if(isset($_GET['a'])){
    $anexo=decryptData($_GET['a']);
    if(is_file($anexo)){
        header("location: $anexo");
    }

}