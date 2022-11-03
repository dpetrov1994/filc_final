<?php
include("login/valida.php");

$indexUrl="/mod_inicio/index.php";
/*
if(isset($_SESSION['indexUrl'])){
    if(is_file( "../".$_SESSION['indexUrl'])){
        $indexUrl= "../".$_SESSION['indexUrl'];
    }else{
        $indexUrl=$_SESSION['indexUrl'];
    }

    if(isset($_SESSION['url_inicial']) && $_SESSION['url_inicial']!="" && $actual_link!=$_SESSION['url_inicial']){

        $pagina=explode("?",$_SESSION['url_inicial']);
        $pagina=explode("/",$pagina[0]);
        $modulo_url=$pagina[count($pagina)-2];
        $pagina_url=end($pagina);
        $existe=0;
        foreach ($_SESSION['modulos'] as $modulo){
            if($modulo_url==$modulo['url']){
                foreach ($modulo['funcionalidades'] as $funcionalidade){
                    if($pagina_url==$funcionalidade['url']){
                        $existe=1;
                    }
                }
            }
        }



        if($existe==1){
            $indexUrl=$_SESSION['url_inicial'];
        }else{
            $indexUrl="/mod_inicio/index.php";
        }
        $_SESSION['url_inicial']="";
        unset($_SESSION['url_inicial']);
    }
}
*/
if($_SESSION['pass_inicial']!=""){
    $indexUrl="mod_perfil/alterar_pass.php?primeiro_login";
}

if(isset($_GET['cod'])){
    $indexUrl.="?cod=".$_GET['cod'];
}

header("location:".$indexUrl);
?>
