<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 01/03/2018
 * Time: 11:06
 */
$add_sql="";
if($_SESSION['system']==0){
    $add_sql=" and ativo=1";
}
if(!isset($_SESSION['modulos'])){
// vamos buscar os parents que depois são usados para o menu
    $sql ="SELECT * FROM modulos WHERE 1 $add_sql order by nome_modulo asc";
    $result=runQ($sql,$db,"1");
    $modulos=[];
    $c=0;
    $addSql="";
    if($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key=>$value){
                if($key=="nome_modulo"){
                    $value=remover_order($value);
                }
                $modulos[$c][$key]=removerHTML($value);
            }
            $modulos[$c]['disponivel']=0;
            if($row['url']=="mod_perfil"){
                $modulos[$c]['disponivel']=1;
            }
            $c++;
            //$addSql.=" and id_modulo=".$row['id_modulo']." ";
        }
    }

    for($i=0;$i<count($modulos);$i++){
        $sql="SELECT 
          * 
          FROM modulos_funcionalidades WHERE 1 $add_sql and id_modulo='".$modulos[$i]['id_modulo']."' order by ordem,nome_funcionalidade asc";
        $result=runQ($sql,$db,"2");
        $funcionalidades=[];
        $c=0;
        if($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key=>$value){
                    if($key=="nome_funcionalidade"){
                        $value=remover_order($value);
                    }
                    $funcionalidades[$c][$key]=removerHTML($value);
                }
                $funcionalidades[$c]['disponivel']=0; // para ser testado mais tarde para ver se o utilizador tem acesso a esta funcionalidade
                if($row['url']=="index.php"){
                    //$funcionalidades[$c]['disponivel']=1;
                }
                $c++;
            }
        }
        $modulos[$i]['funcionalidades']=$funcionalidades;
    }
    foreach ($_SESSION['grupos'] as $grupo){
        $sql="select * from grupos_modulos_funcionalidades where id_grupo=$grupo";
        $result=runQ($sql,$db,"3");
        while ($row = $result->fetch_assoc()) {
            for($i=0;$i<count($modulos);$i++){
                if($row['id_modulo']==$modulos[$i]['id_modulo']){
                    $modulos[$i]['disponivel']=1;
                    for($j=0; $j<count($modulos[$i]['funcionalidades']);$j++){
                        if($row['id_funcionalidade']==$modulos[$i]['funcionalidades'][$j]['id_funcionalidade']){
                            $modulos[$i]['funcionalidades'][$j]['disponivel']=1;
                        }
                    }

                    if($modulos[$i]['principal']==1){
                        for($j=0; $j<count($modulos[$i]['funcionalidades']);$j++){
                                $_SESSION['indexUrl']=$modulos[$i]['url']."/".$modulos[$i]['funcionalidades'][$j]['url'];
                        }
                    }
                }

            }
        }
    }


    if(!isset($_SESSION['indexUrl'])){
        $_SESSION['indexUrl']="utilizadores/perfil.php";
    }
    $_SESSION['modulos']=$modulos;
}