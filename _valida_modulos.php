<?php

$itemMenu='
<li data-toggle="tooltip" data-placement="right" title="_descricao_" data-original-title="_descricao_">
    <a href="_url_" class="_active_"><i class="fa _icon_ sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">_nome_</span></a>
</li>';

$itemMultiplo='
<li data-toggle="tooltip" data-placement="right" title="_descricao_" data-original-title="_descricao_">
    <a href="#" class="sidebar-nav-menu _open_"><i class="fa _icon_ sidebar-nav-icon"></i> <i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><span class="sidebar-nav-mini-hide">_nome_</span> </a>
    <ul>
        _subModulos_
    </ul>
</li>
';
$linhaMultiplo='<li><a href="_url_">_nome_</a></li>';

$itemMenuSecundario='<li class="_active_" data-toggle="tooltip" data-placement="top" title="_descricao_" data-original-title="_descricao_">
                    <a href="_url__addUrl_">
                        <i class="fa fa-fw _icon_ icon-push"></i> 
                        <span class="nav-mini-hide">_nome_</span>
                        <span class="nav-big-hide">_nomeAbreviado_</span>
                    </a>
                </li>';
$menu=""; //menu principal
$menuSecundario='<li data-toggle="tooltip" data-placement="top" title="" data-original-title="Voltar" class=\'border-right\'>
                    <a href="'.$_SESSION['url_voltar'].'">
                        <i class="fa fa-angle-left "></i> 
                        <span class="nav-mini-hide">Voltar</span>
                    </a>
                </li>'; // funcionalidades para intens individuais

$menuSecundario='';

$menuSecundarioIndividual="<br>"; // funcionalidades para intens individuais
$menuSecundarioIndividual=""; // funcionalidades
$subMenu=""; //submodulos

//inserimos a página iício
//$menu.=str_replace("_url_","_indexUrl_",$itemMenu);
/*
$menu.=str_replace("_url_","/",$itemMenu);
$menu=str_replace("_icon_","fa-home",$menu);
$menu=str_replace("_nome_","Início",$menu);
$menu=str_replace("_descricao_","Página inicial",$menu);
*/

if(is_file("login/sair.php")){
    $logoutFile="login/sair.php";
}elseif(is_file("../login/sair.php")){
    $logoutFile="../login/sair.php";
}elseif(is_file("sair.php")){
    $logoutFile="sair.php";
}

$permitirLogin="nao entrar";

foreach ($_SESSION['modulos'] as $modulo){

    foreach ($modulo['funcionalidades'] as $funcionalidade){
        if($funcionalidade['url']=="index.php" && $funcionalidade['disponivel']==0){
            $modulo['disponivel']=0;
        }
    }

    if($modulo['disponivel']==1){
        $url=verificarUrl($modulo['url']."/index.php");

        if($modulo['mostrar']==1 && $modulo['id_parent']==0){

            /**
             * VERIFICAMOS SE TEM SUB MODULOS
             */
            $c=0;
            $subMenu="";
            $open="";
            $subMenu.=str_replace("_url_",$url,$itemMenu);
            $subMenu=str_replace("_icon_",$modulo['icon'],$subMenu);
            $subMenu=str_replace("_nome_",$modulo['nome_modulo'],$subMenu);
            $subMenu=str_replace("_descricao_",$modulo['descricao'],$subMenu);
            $subMenu=str_replace("_id_modulo_",$modulo['id_modulo'],$subMenu);

            foreach ($modulo['funcionalidades'] as $child_func){
                if (verificarAtivo($modulo['url'] . "/" . $child_func['url']) == 1) {
                    $subMenu = str_replace("_active_", "active", $subMenu);
                    $open = "open";
                }
            }
            $subMenu=str_replace("_active_","",$subMenu);

            foreach ($_SESSION['modulos'] as $child){
                if($child['disponivel']==1 && $child['mostrar']==1) {
                    $urlSubMenu = verificarUrl($child['url'] . "/index.php");
                    if ($child['id_parent'] == $modulo['id_modulo']) {
                        $subMenu .= str_replace("_url_", $urlSubMenu, $itemMenu);
                        $subMenu = str_replace("_icon_", $child['icon'], $subMenu);
                        $subMenu = str_replace("_nome_", $child['nome_modulo'], $subMenu);
                        $subMenu = str_replace("_descricao_", $child['descricao'], $subMenu);
                        $subMenu = str_replace("_id_modulo_", $child['id_modulo'], $subMenu);
                        $c++;

                        foreach ($child['funcionalidades'] as $child_func) {
                            if (verificarAtivo($child['url'] . "/" . $child_func['url']) == 1) {
                                $subMenu = str_replace("_active_", "active", $subMenu);
                                $open = "open";
                            }
                        }
                        $subMenu = str_replace("_active_", "", $subMenu);
                    }
                }
            }
            /**
             * itens multplos com sub módulos
             */
            if($c!=0){

                $menu.=str_replace("_url_",$url,$itemMultiplo);
                $menu=str_replace("_icon_",$modulo['icon'],$menu);
                $menu=str_replace("_nome_",$modulo['nome_modulo'],$menu);
                $menu=str_replace("_descricao_",$modulo['descricao'],$menu);

                $menu=str_replace("_subModulos_",$subMenu,$menu);
                $menu=str_replace("_open_",$open,$menu);
                $menu=str_replace("_id_modulo_",$modulo['id_modulo'],$menu);
            }
            /**
             * Itens únicos sem sub módulos
             */
            else{
                $menu.=str_replace("_url_",$url,$itemMenu);
                $menu=str_replace("_icon_",$modulo['icon'],$menu);
                $menu=str_replace("_nome_",$modulo['nome_modulo'],$menu);
                $menu=str_replace("_descricao_",$modulo['descricao'],$menu);
                $menu=str_replace("_id_modulo_",$modulo['id_modulo'],$menu);
            }

        }

        foreach ($modulo['funcionalidades'] as $funcionalidade){
            if($funcionalidade['disponivel']==1 and $funcionalidade['mostrar']==1 and verificarModulo($modulo['url'])==1){
                $menuSecundario.=str_replace("_url_",$funcionalidade['url'],$itemMenuSecundario);
                $menuSecundario=str_replace("_icon_",$funcionalidade['icon'],$menuSecundario);
                $menuSecundario=str_replace("_nome_",$funcionalidade['nome_funcionalidade'],$menuSecundario);
                $menuSecundario=str_replace("_nomeAbreviado_",str_replace('-',"",$funcionalidade['nome_funcionalidade']),$menuSecundario);
                $menuSecundario=str_replace("_descricao_",$funcionalidade['descricao'],$menuSecundario);
                if(verificarAtivo($modulo['url']."/".$funcionalidade['url'])==1){
                    $menuSecundario=str_replace("_active_","active",$menuSecundario);
                }
                $menuSecundario=str_replace("_active_","",$menuSecundario);
            }

            if(verificarAtivo($modulo['url']."/".$funcionalidade['url'])==1 && $permitirLogin=="nao entrar"){
                $menu=str_replace("_active_","active",$menu);
                if($funcionalidade['mostrar_subMenu']==1){
                    foreach ($modulo['funcionalidades'] as $funcionalidadeSubMenu) {
                        if ($funcionalidadeSubMenu['mostrarDropdown'] == 1 and $funcionalidadeSubMenu['confirmar'] == 0 and $funcionalidadeSubMenu['disponivel'] == 1 and verificarModulo($modulo['url']) == 1) {
                            $menuSecundarioIndividual .= str_replace("_url_", $funcionalidadeSubMenu['url'], $itemMenuSecundario);
                            $menuSecundarioIndividual = str_replace("_icon_", $funcionalidadeSubMenu['icon'], $menuSecundarioIndividual);
                            $menuSecundarioIndividual = str_replace("_nome_", $funcionalidadeSubMenu['nome_funcionalidade'], $menuSecundarioIndividual);
                            $menuSecundarioIndividual=str_replace("_nomeAbreviado_",str_replace('-',"",$funcionalidadeSubMenu['nome_funcionalidade']),$menuSecundarioIndividual);

                            $menuSecundarioIndividual = str_replace("_descricao_", $funcionalidadeSubMenu['descricao'], $menuSecundarioIndividual);
                            if (verificarAtivo($modulo['url'] . "/" . $funcionalidadeSubMenu['url']) == 1) {
                                $menuSecundarioIndividual = str_replace("_active_", "active", $menuSecundarioIndividual);
                            }
                            $menuSecundarioIndividual = str_replace("_active_", "", $menuSecundarioIndividual);
                        }
                    }
                }

                $cfg_icon_modulo=$modulo['icon'];
                $cfg_icon_funcionalidade=$funcionalidade['icon'];
                $cfg_nome_funcionalidade=$funcionalidade['nome_funcionalidade'];
                $cfg_url_funcionalidade=$funcionalidade['url'];

                $cfg_nome_modulo        =$modulo['nome_modulo'];
                $cfg_url_modulo         =$modulo['url'];
                $cfg_nomeTabela_modulo  =$modulo['nomeTabela'];
                $cfg_nomeColuna_modulo  =$modulo['nomeColuna'];
                $cfg_id_modulo          =$modulo['id_modulo'];

                $cfg_id_parent=$modulo['id_parent'];

                //VALIDACAO SE PODE OU NAO ENTRAR
                $permitirLogin="entrar";
                if($funcionalidade['disponivel']==0 || $modulo['disponivel']==0){
                    exit(erro($cfg_nomePlataforma,$layoutDirectory,"401","Lamentamos mas não tem acesso a esta página.","<br><a href='$logoutFile' class='btn btn-default'><i class='fa fa-sign-in'></i> Página de login</a><br>"));
                }
            }
        }
        $menu=str_replace("_active_","",$menu);
        $menu=str_replace("_open_","",$menu);
        $menu=str_replace("_id_modulo_",$modulo['id_modulo'],$menu);

        //ADDONS
        if($modulo['url']=='mod_mensagens'){
            foreach ($modulo['funcionalidades'] as $funcionalidade){
                if($funcionalidade['disponivel']==1 and $funcionalidade['url']=="index.php"){
                    $mod_mensagens=1;
                }
            }
        }

        if($modulo['url']=='mod_notificacoes'){
            foreach ($modulo['funcionalidades'] as $funcionalidade){
                if($funcionalidade['disponivel']==1 and $funcionalidade['url']=="index.php"){
                    $mod_notificacoes=1;
                }
            }
        }

        if($modulo['url']=='mod_pesquisa'){
            foreach ($modulo['funcionalidades'] as $funcionalidade){
                if($funcionalidade['disponivel']==1 and $funcionalidade['url']=="index.php"){
                    $mod_pesquisa=1;
                }
            }
        }

        if($modulo['url']=='mod_calendario'){
            foreach ($modulo['funcionalidades'] as $funcionalidade){
                if($funcionalidade['disponivel']==1 and $funcionalidade['url']=="index.php"){
                    $mod_calendario=1;
                }
            }
        }
    }
}


//if($permitirLogin=="nao entrar") {
//   exit(erro($cfg_nomePlataforma, $layoutDirectory, "401", "Lamentamos mas não tem acesso a esta página.", ""));
//}
