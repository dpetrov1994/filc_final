<?php
//inserimos o menu de ações
$funcionalidades="";
$funcionalidadesMultiplos="";
if(!isset($pre_url)){
    $pre_url="";
}

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url_from = "https://";
else
    $url_from = "http://";
// Append the host(domain name, ip) to the URL.
$url_from.= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL

$url_from.= $_SERVER['REQUEST_URI'];

foreach ($_SESSION['modulos'] as $modulo) {
    if ($cfg_id_modulo == $modulo['id_modulo']) {
        $linkDasTabelas="#";
        foreach ($modulo['funcionalidades'] as $funcionalidade) {
            if ($funcionalidade['disponivel'] == 1 && removerHTML($funcionalidade['mostrar'])==0) {
                if($funcionalidade['mostrarDropdown']==1){
                    if($funcionalidade['url']=="abrir.php" && ($linkDasTabelas=="detalhes.php" || $linkDasTabelas=="#" || $linkDasTabelas=="editar.php" || $linkDasTabelas=="consultar.php")){
                        $linkDasTabelas="abrir.php";
                    }
                    if($funcionalidade['url']=="consultar.php" && $linkDasTabelas=="#"){
                        $linkDasTabelas="consultar.php";
                    }
                    if($funcionalidade['url']=="detalhes.php" && $linkDasTabelas=="#"){
                        $linkDasTabelas="detalhes.php";
                    }
                    if($funcionalidade['url']=="editar.php" && $linkDasTabelas=="#"){
                        $linkDasTabelas="editar.php";
                    }

                    $funcionalidade['url']=$pre_url.$funcionalidade['url'];

                    if(isset($no_from)){
                        $url_from="";
                    }

                    if(verificarAtivo($modulo['url']."/reciclagem.php")==1 && $funcionalidade['so_em_reciclagem']==1){
                        $funcionalidades.=str_replace("_nome_",removerHTML($funcionalidade['nome_funcionalidade']),$linhaFuncionalidade);
                        $funcionalidades=str_replace("_icon_",removerHTML($funcionalidade['icon']),$funcionalidades);
                        $funcionalidades=str_replace("_descricao_",removerHTML($funcionalidade['descricao']),$funcionalidades);
                        if($funcionalidade['confirmar']==1){
                            $funcionalidades=str_replace("_url_",'href="javascript:void(0)" onclick="confirmaModal(\''.removerHTML($funcionalidade['url']).'?id='."_idItem_".'&from='.urlencode($url_from).'\')"',$funcionalidades);
                        }else{
                            $funcionalidades=str_replace("_url_","href='".removerHTML($funcionalidade['url'])."?id="."_idItem_"."'",$funcionalidades);
                        }
                    }elseif($funcionalidade['so_em_reciclagem']==0){
                        if(verificarAtivo($modulo['url']."/reciclagem.php")==1 && $funcionalidade['nome_em_reciclagem']){
                            $funcionalidades.=str_replace("_nome_",removerHTML($funcionalidade['nome_em_reciclagem']),$linhaFuncionalidade);
                        }else{
                            $funcionalidades.=str_replace("_nome_",removerHTML($funcionalidade['nome_funcionalidade']),$linhaFuncionalidade);
                        }
                        $funcionalidades=str_replace("_icon_",removerHTML($funcionalidade['icon']),$funcionalidades);
                        $funcionalidades=str_replace("_descricao_",removerHTML($funcionalidade['descricao']),$funcionalidades);
                        if($funcionalidade['confirmar']==1){
                            $funcionalidades=str_replace("_url_",'href="javascript:void(0)" onclick="confirmaModal(\''.removerHTML($funcionalidade['url']).'?id='."_idItem_".'&from='.urlencode($url_from).'\')"',$funcionalidades);
                        }else{
                            $funcionalidades=str_replace("_url_","href='".removerHTML($funcionalidade['url'])."?id="."_idItem_"."'",$funcionalidades);
                        }
                    }
                }

                //multiplos
                if($funcionalidade['multiplos']==1){
                    if(verificarAtivo($modulo['url']."/reciclagem.php")==1 && $funcionalidade['so_em_reciclagem']==1){
                        $funcionalidadesMultiplos.=str_replace("_nome_",removerHTML($funcionalidade['nome_funcionalidade']),$linhaFuncionalidade);
                        $funcionalidadesMultiplos=str_replace("_icon_",removerHTML($funcionalidade['icon']),$funcionalidadesMultiplos);
                        $funcionalidadesMultiplos=str_replace("_descricao_",removerHTML($funcionalidade['descricao']),$funcionalidadesMultiplos);
                        $funcionalidade['url']=$pre_url.$funcionalidade['url'];
                        if($funcionalidade['confirmar']==1){
                            $funcionalidadesMultiplos=str_replace("_url_",'href="javascript:void(0)" onclick="confirmaAcaoVariosModal(\''.removerHTML($funcionalidade['url']).'\')"',$funcionalidadesMultiplos);
                        }else{
                            $funcionalidadesMultiplos=str_replace("_url_","href='".removerHTML($funcionalidade['url'])."?id="."_idItem_"."'",$funcionalidadesMultiplos);
                        }
                    }elseif($funcionalidade['so_em_reciclagem']==0){

                        if(verificarAtivo($modulo['url']."/reciclagem.php")==1 && $funcionalidade['nome_em_reciclagem']){

                            $funcionalidadesMultiplos.=str_replace("_nome_",removerHTML($funcionalidade['nome_em_reciclagem']),$linhaFuncionalidade);
                        }else{

                            $funcionalidadesMultiplos.=str_replace("_nome_",removerHTML($funcionalidade['nome_funcionalidade']),$linhaFuncionalidade);
                        }
                        $funcionalidadesMultiplos=str_replace("_icon_",removerHTML($funcionalidade['icon']),$funcionalidadesMultiplos);
                        $funcionalidadesMultiplos=str_replace("_descricao_",removerHTML($funcionalidade['descricao']),$funcionalidadesMultiplos);
                        $funcionalidade['url']=$pre_url.$funcionalidade['url'];
                        if($funcionalidade['confirmar']==1){

                            $funcionalidadesMultiplos=str_replace("_url_",'href="javascript:void(0)" onclick="confirmaAcaoVariosModal(\''.removerHTML($funcionalidade['url']).'\')"',$funcionalidadesMultiplos);
                        }else{

                            $funcionalidadesMultiplos=str_replace("_url_","href='".removerHTML($funcionalidade['url'])."?id="."_idItem_"."'",$funcionalidadesMultiplos);
                        }
                    }
                }
            }
        }
    }
}

$linkDasTabelas=$pre_url.$linkDasTabelas."?id=_idItem_";

if($funcionalidades!=""){
    $funcionalidades='<div class="btn-group">
                                <a href="javascript:void(0)" data-toggle="dropdown" class=" btn btn-primary btn-xs btn-effect-ripple dropdown-toggle" aria-expanded="false"> <span class="fa fa-bars"> <i class="caret"></i></span></a>
                                <ul class="dropdown-menu dropdown-menu-right text-left">
                                    '.$funcionalidades.'
                                </ul>
                            </div>';
}

if($funcionalidadesMultiplos!=""){
    $funcionalidadesMultiplos='
            <div class="">
                <div class="btn-group">
                    <a href="javascript:void(0)" data-toggle="dropdown" class="btn-sm btn btn-primary dropdown-toggle" aria-expanded="false"> Com os selecionados <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right text-left">
                        '.$funcionalidadesMultiplos.'
                    </ul>
                </div>
            </div>';
}

