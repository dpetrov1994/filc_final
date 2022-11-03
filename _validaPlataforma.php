<?php
/**
 * Se a plataforma estiver desativa redirecionamos para a página de erro

if($cfg_ativo==0){

    $lock=1;
    $sql="select * from _conf_ip_whitelist";
    $result=runQ($sql,$db,1);
    while($row = $result->fetch_assoc()){
        if($row['ip']==$_SERVER['REMOTE_ADDR']){
            $lock=0;
        }
    }
    if($lock==1){
        exit(erro($cfg_nomePlataforma,$layoutDirectory,":(","Lamentamos mas esta plataforma não se encontra ativa.",""));
    }
}

if($cfg_manutencao==1){

    $lock=1;
    $sql="select * from _conf_ip_whitelist";
    $result=runQ($sql,$db,1);
    while($row = $result->fetch_assoc()){
        if($row['ip']==$_SERVER['REMOTE_ADDR']){
            $lock=0;
        }
    }
    if($lock==1){
        exit(erro($cfg_nomePlataforma,$layoutDirectory,"","Estamos em manutenção.","<h2 class='text-light'>Por favor tente mais tarde.</h2>"));
    }
}
 */
