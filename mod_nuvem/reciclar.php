<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 12/04/2018
 * Time: 10:41
 */
include ('../_template.php');
include ".cfg.php";
$content=file_get_contents($layoutDirectory."/loading.tpl");
$db=ligarBD("ajax");
if(isset($_GET['id_pasta_ficheiro']) && isset($_GET['tipo']) & isset($_GET['nome_pasta_ficheiro'])){


    $nome_pasta_ficheiro=$db->escape_string($_GET['nome_pasta_ficheiro']);
    $id_pasta_ficheiro=$db->escape_string($_GET['id_pasta_ficheiro']);
    $tipo=$db->escape_string($_GET['tipo']);

    if($tipo=='pasta'){
        $tabela="pastas";
        $coluna="pasta";
    }else{
        $tabela="pastas_ficheiros";
        $coluna="ficheiro";
    }

    $sql="select * from $tabela where id_$coluna='$id_pasta_ficheiro'";
    $result=runQ($sql,$db,"CHECK RECICLAR UM");
    if($result->num_rows!=0){
        while ($row = $result->fetch_assoc()) {
            $ativo=$row['ativo'];
            $dir_original=$row['dir'];
            $nome_real=$row['nome_real'];
        }

        if($ativo==1){
            $ativo=0;

            $txt="Recuperar da reciclagem";
            $dir="../_contents";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            $dir.="/nuvem_reciclagem";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            if($tipo=='pasta'){
                recursiveDesativarPasta($db,$id_pasta_ficheiro);
                recursive_copy("$dir_original","$dir/$nome_real");
                rrmdir($dir_original);
            }else{
                $sql="update pastas_ficheiros set ativo=$ativo where id_ficheiro='$id_pasta_ficheiro'";
                $result=runQ($sql,$db,"DESATIVAR FICHEIROS");
                copy("$dir_original/$nome_real","$dir/$nome_real");
                unlink("$dir_original/$nome_real");
            }
        }else{
            $ativo=1;

            $txt="Mover para a reciclagem";
            $dir="../_contents";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            $dir.="/nuvem_reciclagem";
            if(!is_dir($dir)){
                mkdir($dir);
            }

            if($tipo=='pasta') {
                recursiveAtivarPasta($db, $id_pasta_ficheiro);
                recursive_copy("$dir/$nome_real","$dir_original");
                rrmdir("$dir/$nome_real");
            }else{
                $sql="update pastas_ficheiros set ativo=$ativo where id_ficheiro='$id_pasta_ficheiro'";
                $result=runQ($sql,$db,"DESATIVAR FICHEIROS");
                copy("$dir/$nome_real","$dir_original/$nome_real");
                unlink("$dir/$nome_real");

            }

        }

        $sql="update $tabela set ativo=$ativo where id_$coluna='$id_pasta_ficheiro'";
        $result=runQ($sql,$db,"RECICLAR");
        criarLog($db,"$tabela","id_$coluna",$id_pasta_ficheiro,$txt,null);
    }


}elseif(isset($_POST['checkboxes'])){
    foreach ($_POST['checkboxes'] as $id_ficheiro){

        $sql="select * from pastas_ficheiros where pastas_ficheiros.id_ficheiro='$id_ficheiro'";
        $result=runQ($sql,$db,"CHECK RECICLAR UM");
        if($result->num_rows!=0){
            while ($row = $result->fetch_assoc()) {
                $ativo=$row['ativo'];
                $dir_original=$row['dir'];
                $nome_real=$row['nome_real'];
            }

            if($ativo==1){
                $ativo=0;

                $txt="Recuperar da reciclagem";
                $dir="../_contents";
                if(!is_dir($dir)){
                    mkdir($dir);
                }

                $dir.="/nuvem_reciclagem";
                if(!is_dir($dir)){
                    mkdir($dir);
                }

                $sql="update pastas_ficheiros set ativo=$ativo where id_ficheiro='$id_ficheiro'";
                $result=runQ($sql,$db,"DESATIVAR FICHEIROS");
                copy("$dir_original/$nome_real","$dir/$nome_real");
                unlink("$dir_original/$nome_real");

            }else{
                $ativo=1;

                $txt="Mover para a reciclagem";
                $dir="../_contents";
                if(!is_dir($dir)){
                    mkdir($dir);
                }

                $dir.="/nuvem_reciclagem";
                if(!is_dir($dir)){
                    mkdir($dir);
                }


                $sql="update pastas_ficheiros set ativo=$ativo where id_ficheiro='$id_ficheiro'";
                $result=runQ($sql,$db,"DESATIVAR FICHEIROS");
                copy("$dir/$nome_real","$dir_original/$nome_real");
                unlink("$dir/$nome_real");



            }

            $sql="update pastas_ficheiros set ativo=$ativo where id_ficheiro='$id_ficheiro'";
            $result=runQ($sql,$db,"RECICLAR");
            criarLog($db,"pastas_ficheiros","id_ficheiro",$id_ficheiro,$txt,null);
        }
    }

}
$db->close();
include('../_autoData.php');
print "<script>window.history.back();</script>";