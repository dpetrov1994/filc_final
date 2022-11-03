<?php
//inserimos o menu de ações
$funcionalidades="";
$funcionalidadesMultiplos="";

foreach ($_SESSION['modulos'] as $modulo) {
    if ($cfg_id_modulo == $modulo['id_modulo']) {
        $linkDasTabelas="#";
        foreach ($modulo['funcionalidades'] as $funcionalidade) {
            if ($funcionalidade['disponivel'] == 1 && removerHTML($funcionalidade['mostrar'])==0) {
                if($funcionalidade['mostrarDropdown']==1){
                    if($funcionalidade['url']=="abrir.php" && ($linkDasTabelas=="detalhes.php" || $linkDasTabelas=="#") && ($linkDasTabelas=="editar.php" || $linkDasTabelas=="#")){
                        $linkDasTabelas="abrir.php";
                    }elseif($funcionalidade['url']=="detalhes.php" && $linkDasTabelas=="#"){
                        $linkDasTabelas="detalhes.php";
                    }elseif($funcionalidade['url']=="editar.php" && $linkDasTabelas=="#"){
                        $linkDasTabelas="editar.php";
                    }

                    if(verificarAtivo($modulo['url']."/reciclagem.php")==1 && $funcionalidade['so_em_reciclagem']==1){
                        $funcionalidades.=str_replace("_nome_",removerHTML($funcionalidade['nome_funcionalidade']),$linhaFuncionalidade);
                        $funcionalidades=str_replace("_icon_",removerHTML($funcionalidade['icon']),$funcionalidades);
                        $funcionalidades=str_replace("_descricao_",removerHTML($funcionalidade['descricao']),$funcionalidades);
                        if($funcionalidade['confirmar']==1){
                            $funcionalidades=str_replace("_url_",'href="javascript:void(0)" onclick="confirmaModal(\''.removerHTML($funcionalidade['url']).'_addUrl_&subItemID=' . "_subItemID_".'\')"',$funcionalidades);
                        }else{
                            $funcionalidades=str_replace("_url_","href='".removerHTML($funcionalidade['url'])."_addUrl_&subItemID="."_subItemID_"."'",$funcionalidades);
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
                            $funcionalidades=str_replace("_url_",'href="javascript:void(0)" onclick="confirmaModal(\''.removerHTML($funcionalidade['url']).'_addUrl_&subItemID=' . "_subItemID_".'\')"',$funcionalidades);
                        }else{
                            $funcionalidades=str_replace("_url_","href='".removerHTML($funcionalidade['url'])."_addUrl_&subItemID="."_subItemID_"."'",$funcionalidades);
                        }
                    }
                }

                //multiplos

                if($funcionalidade['multiplos']==1){
                    if(verificarAtivo($modulo['url']."/reciclagem.php")==1 && $funcionalidade['so_em_reciclagem']==1){

                        $funcionalidadesMultiplos.=str_replace("_nome_",removerHTML($funcionalidade['nome_funcionalidade']),$linhaFuncionalidade);
                        $funcionalidadesMultiplos=str_replace("_icon_",removerHTML($funcionalidade['icon']),$funcionalidadesMultiplos);
                        $funcionalidadesMultiplos=str_replace("_descricao_",removerHTML($funcionalidade['descricao']),$funcionalidadesMultiplos);
                        if($funcionalidade['confirmar']==1){
                            $funcionalidadesMultiplos=str_replace("_url_",'href="javascript:void(0)" onclick="confirmaAcaoVariosModal(\''.removerHTML($funcionalidade['url']).'_addUrl_\')"',$funcionalidadesMultiplos);
                        }else{
                            $funcionalidadesMultiplos=str_replace("_url_","href='".removerHTML($funcionalidade['url'])."_addUrl_&subItemID="."_subItemID_"."'",$funcionalidadesMultiplos);
                        }
                    }elseif($funcionalidade['so_em_reciclagem']==0){

                        if(verificarAtivo($modulo['url']."/reciclagem.php")==1 && $funcionalidade['nome_em_reciclagem']){
                            $funcionalidadesMultiplos.=str_replace("_nome_",removerHTML($funcionalidade['nome_em_reciclagem']),$linhaFuncionalidade);
                        }else{
                            $funcionalidadesMultiplos.=str_replace("_nome_",removerHTML($funcionalidade['nome_funcionalidade']),$linhaFuncionalidade);
                        }
                        $funcionalidadesMultiplos=str_replace("_icon_",removerHTML($funcionalidade['icon']),$funcionalidadesMultiplos);
                        $funcionalidadesMultiplos=str_replace("_descricao_",removerHTML($funcionalidade['descricao']),$funcionalidadesMultiplos);
                        if($funcionalidade['confirmar']==1){
                            $funcionalidadesMultiplos=str_replace("_url_",'href="javascript:void(0)" onclick="confirmaAcaoVariosModal(\''.removerHTML($funcionalidade['url']).'_addUrl_\')"',$funcionalidadesMultiplos);
                        }else{
                            $funcionalidadesMultiplos=str_replace("_url_","href='".removerHTML($funcionalidade['url'])."_addUrl_&subItemID="."_subItemID_"."'",$funcionalidadesMultiplos);
                        }
                    }
                }
            }
        }
    }
}

$linkDasTabelas.="_addUrl_&subItemID=_subItemID_";

if($funcionalidades!=""){
    $funcionalidades='<div class="btn-group">
                                <a href="javascript:void(0)" data-toggle="dropdown" class=" btn btn-primary btn-sm btn-effect-ripple dropdown-toggle" aria-expanded="false"> <span class="fa fa-bars"> <i class="caret"></i></span></a>
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