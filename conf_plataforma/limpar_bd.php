<?php

include ('../_template.php');
include ".cfg.php";
$content=file_get_contents("limpar_bd.tpl");

if(isset($_POST['submit'])){
    if(isset($_POST['tabelas']) && is_array($_POST['tabelas']) && count($_POST['tabelas'])>0){
        foreach ($_POST['tabelas'] as $tabela){
            $sql="truncate $tabela";
            $result=runQ($sql,$db,1);
        }
    }
}

$sql="show tables";
$result=runQ($sql,$db,0);
$tabelas="";

$nao_selecionar=[
    '_conf_cliente',
    '_conf_escola',
    '_conf_ip_whitelist',
    '_conf_plataforma',
    '_conf_estado_plataforma',
    'grupos',
    'grupos_mensagens',
    'grupos_modulos_funcionalidades',
    'grupos_utilizadores',
    'modulos',
    'modulos_funcionalidades',
    'utilizadores',
    'utilizadores_conf',
    'utilizadores_recuperacao',
    ];

while($row = $result->fetch_assoc()){
    foreach ($row as $key=>$nome_tabela){
        $disabled="";
        $checked="checked";
        $cor="";
        foreach ($nao_selecionar as $tabela){
            if($tabela == $nome_tabela){
                $disabled="disabled";
                $checked="";
                $cor="text-warning";
            }
        }
        $tabelas.="
                <div class='col-xs-6'>
                    <div class=\"form-group\">
                        <label class=\"csscheckbox csscheckbox-primary $cor\"><input $checked $disabled name='tabelas[]' value='$nome_tabela' type=\"checkbox\"><span></span> <b>$nome_tabela</b></label>
                    </div>
                </div>";
    }
}

$content=str_replace("_tabelas_",$tabelas,$content);

include('../_autoData.php');

