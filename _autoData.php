<?php

if(!isset($nomeTabela)){
    $nomeTabela="notset";
}
$layout=str_replace("_nomeTabela_",$nomeTabela,$layout);
if(isset($subModulo) && $subModulo==0){
    $content=str_replace("_id_",$id,$content);
}else{
    if(isset($idParent)){
        $content=str_replace("_id_",$idParent,$content);
    }
    $content=str_replace("_id_","",$content);
}

if(!isset($content)) {
    $content = "";
}if(!isset($opsPrs)) {
    $opsPrs = "";
}if(!isset($resultados)) {
    $resultados = "";
}if(!isset($paginacao)) {
    $paginacao = "";
}if(!isset($opsOrdenar)) {
    $opsOrdenar = "";
}

$content=str_replace("_prs_",$opsPrs,$content);
$content=str_replace("_ordenar_",$opsOrdenar,$content);
$content=str_replace("_resultados_",$resultados,$content);
$content=str_replace("_paginacao_",$paginacao,$content);

if(!isset($contentSidebar)) {
    $contentSidebar = "";
}if(!isset($menu)) {
    $menu = "";
}if(!isset($menuSecundario)) {
    $menuSecundario = "";
}if(!isset($menuSecundarioIndividual)) {
    $menuSecundarioIndividual = "";
}if(!isset($userDropdown)) {
    $userDropdown = "";
}
$addons="";
if(isset($_SESSION['addons'])){
    $addons=$_SESSION['addons'];
}

if(!isset($historicoPaginas)) {
    $historicoPaginas = "";
}if(!isset($footer)) {
    $footer = "";
}if(!isset($semResultados)) {
    $semResultados = "";
}if(!isset($posicaoAtual)) {
    $posicaoAtual = "";
}
$layout=str_replace("_contentSidebar_",$contentSidebar,$layout);
$layout=str_replace("_content_",$content,$layout);
$layout=str_replace("_menuPrincipal_",$menu,$layout);
$layout=str_replace("_menuSecundario_",$menuSecundario,$layout);
$layout=str_replace("_menuSecundarioIndividual_",$menuSecundarioIndividual,$layout);
$layout=str_replace("_userDropdown_",$userDropdown,$layout);
$layout=str_replace("_addons_",$addons,$layout);
$layout=str_replace("_historicoPaginas_",$historicoPaginas,$layout);
$layout=str_replace("_posicaoAtual_",$posicaoAtual,$layout);
$layout=str_replace("_footer_",$footer,$layout);
$layout=str_replace("_semResultados_",$semResultados,$layout);

if(!isset($status)) {
    $status = "";
}
$layout=str_replace("_status_",$status,$layout);

if(!isset($pageScript)){
    $pageScript="";
}if(!isset($scriptNotificar)){
    $scriptNotificar="";
}if(!isset($cfg_nomePlataforma)) {
    $cfg_nomePlataforma = "";
}if(!isset($cfg_temaPlataforma)) {
    $cfg_temaPlataforma = "";
}if(!isset($cfg_copyPlataforma)) {
    $cfg_copyPlataforma = "";
}if(!isset($cfg_nome_funcionalidade)) {
    $cfg_nome_funcionalidade = "";
}if(!isset($cfg_nome_modulo)) {
    $cfg_nome_modulo = "";
}if(!isset($cfg_nome_parent)) {
    $cfg_nome_parent = "";
}if(!isset($cfg_icon_modulo)) {
    $cfg_icon_modulo = "";
}if(!isset($cfg_icon_parent)) {
    $cfg_icon_parent = "";
}if(!isset($cfg_icon_funcionalidade)) {
    $cfg_icon_funcionalidade = "";
}if(!isset($cfg_metaDescricao)) {
    $cfg_metaDescricao = "";
}if(!isset($cfg_metaAutor)) {
    $cfg_metaAutor = "";
}if(!isset($cfg_metaKeywords)) {
    $cfg_metaKeywords = "";
}if(!isset($cfg_metaRobots)) {
    $cfg_metaRobots = "";
}if(!isset($cfg_copySite)) {
    $cfg_copySite = "";
}if(!isset($cfg_copySite)) {
    $cfg_copySite = "";
}if(!isset($cfg_espacoDisco)) {
    $cfg_espacoDisco = "";
}if(!isset($cfg_nomeEmpresa)) {
    $cfg_nomeEmpresa = "";
}if(!isset($cfg_siteEmpresa)) {
    $cfg_siteEmpresa = "";
}if(!isset($cfg_contactoEmpresa)) {
    $cfg_contactoEmpresa = "";
}if(!isset($cfg_dirSugestao)) {
    $cfg_dirSugestao = "";
}if(!isset($cfg_moeda)) {
    $cfg_moeda = "";
}

$indexUrl="";
if(isset($_SESSION['indexUrl'])){
    if(is_file( "../".$_SESSION['indexUrl'])){
        $indexUrl= "../".$_SESSION['indexUrl'];
    }else{
        $indexUrl=$_SESSION['indexUrl'];
    }
}

$layout=str_replace("_nomePlataforma_",$cfg_nomePlataforma,$layout);
$layout=str_replace("_nomeEmpresa_",$cfg_nomeEmpresa,$layout);
$layout=str_replace("_siteEmpresa_",$cfg_siteEmpresa,$layout);
$layout=str_replace("_contactoEmpresa_",$cfg_contactoEmpresa,$layout);
$layout=str_replace("_temaPlataforma_",$cfg_temaPlataforma,$layout);
$layout=str_replace("_copyPlataforma_",$cfg_copyPlataforma,$layout);
$layout=str_replace("_espacoDisco_",$cfg_espacoDisco,$layout);
$layout=str_replace("_nomeModuloTitle_",$cfg_nome_modulo,$layout);
$layout=str_replace("_nomePagina_",$cfg_nome_funcionalidade,$layout);
$layout=str_replace("_nomeModulo_",$cfg_nome_modulo,$layout);
$layout=str_replace("_iconModulo_",$cfg_icon_modulo,$layout);
$layout=str_replace("_nomeModuloParent_",$cfg_nome_parent,$layout);
$layout=str_replace("_iconModuloParent_",$cfg_icon_parent,$layout);
$layout=str_replace("_iconfuncionalidade_",$cfg_icon_funcionalidade,$layout);
$layout=str_replace("_metaDescricao_",$cfg_metaDescricao,$layout);
$layout=str_replace("_metaAutor_",$cfg_metaAutor,$layout);
$layout=str_replace("_metaKeywords_",$cfg_metaKeywords,$layout);
$layout=str_replace("_metaRobots_",$cfg_metaRobots,$layout);
$layout=str_replace("_dirSugestao_",$cfg_dirSugestao,$layout);
$layout=str_replace("_copySite_",$cfg_copySite,$layout);
$layout=str_replace("_copyAno_",date("Y"),$layout);
$layout=str_replace("_layoutDirectory_",$layoutDirectory,$layout);
$layout=str_replace("_indexUrl_",$indexUrl,$layout);

//bloquear o id empresa no editar
if (strpos(urlAtual, "editar.php") == true) {
    $pageScript.="<script>$('#id_empresa').prop(\"disabled\", true);</script>";
}

$layout=str_replace("_pageScript_",$pageScript,$layout);
//$layout=str_replace("_scriptBackgroudUpdate_","<script>backgroudUpdate('".actual_link."');</script>",$layout);
$layout=str_replace("_scriptBackgroudUpdate_","",$layout);
$layout=str_replace("_moneySign_",$cfg_moeda,$layout);

if(!isset($funcionalidadesMultiplos)){
    $funcionalidadesMultiplos="";
}


if(isset($ignorarFuncionalidadesMultiplos) && $ignorarFuncionalidadesMultiplos == 1){
    $layout=str_replace("_funcionalidadesMultiplos_","",$layout);
}

$layout=str_replace("_funcionalidadesMultiplos_",$funcionalidadesMultiplos,$layout);

if(!isset($addUrl)) {
    $addUrl = "";
}
$addUrl=str_replace("?&","?",$addUrl);
$layout=str_replace("_addUrl_",$addUrl,$layout);
if(!isset($logoutFile)){
    $logoutFile="";
}if(!isset($lockFile)){
    $lockFile="";
}if(!isset($alterarPass)){
    $alterarPass="";
}if(!isset($alterarFoto)){
    $alterarFoto="";
}if(!isset($alterarEmail)){
    $alterarEmail="";
}if(!isset($verServicos)){
    $verServicos="";
}if(!isset($verRecibos)){
    $verRecibos="";
}if(!isset($perfilUrl)){
    $perfilUrl="";
}if(!isset($actual_link)){
    $actual_link="";
}

$layout=str_replace("_logoutFile_",$logoutFile,$layout);
$layout=str_replace("_lockFile_",$lockFile,$layout);
$layout=str_replace("_alterarPassUrl_",$alterarPass,$layout);
$layout=str_replace("_alterarFotoUrl_",$alterarFoto,$layout);
$layout=str_replace("_verServicosUrl_",$verServicos,$layout);
$layout=str_replace("_verRecibosUrl_",$verRecibos,$layout);
$layout=str_replace("_alterarEmailUrl_",$alterarEmail,$layout);
$layout=str_replace("_perfilUrl_",$perfilUrl,$layout);
$layout=str_replace("_actualLink_",$actual_link,$layout);
if(isset($_SESSION['nome_utilizador'])){
    $layout=str_replace("_nomeUtilizador_",$_SESSION['nome_utilizador'],$layout);
}
if(isset($_SESSION['id_utilizador'])){
    $layout=str_replace("_idUtilizador_",$_SESSION['id_utilizador'],$layout);
}
if(isset($_SESSION['foto'])){
    $layout=str_replace("_fotoUtilizador_","../_contents/fotos_utilizadores/".$_SESSION['foto'],$layout);
}

//configurações
$layout=str_replace("_tempoLock_",@$_SESSION['cfg_tempo_lock'],$layout);
$layout=str_replace("_tamanhoSms_",$cfg_tamanhoSms,$layout);
//para evitar que vá para os detalhes de um utilizador eliminado
$layout=str_replace("_nomeCriou_","",$layout);


$layout=str_replace('value="_email_"','value="'.$_SESSION['email_sessao'].'"',$layout);

//eliminar a pasta com o backup da BD
if(is_dir("../_contents/_backup_bd")){
    $ficheiros=mostraFicheiros("../_contents/_backup_bd");
    foreach ($ficheiros as $ficheiro){
        unlink("../_contents/_backup_bd/$ficheiro");
    }
    rrmdir("../_contents/_backup_bd");
}

if(isset($db)){
    @$db->close();
}

if(isset($wp)){
    @$wp->close();
}


$rand=time();
$layout=str_replace(".css",".css?$rand",$layout);
$layout=str_replace("_current_timestamp_",current_timestamp,$layout);
$layout=str_replace(".js",".js?$rand",$layout);

if(!isset($btn_voltar)){
    $btn_voltar="";
}
$layout=str_replace("_voltarCliente_",$btn_voltar,$layout);
$layout=str_replace("","",$layout);
if(!isset($icon_modulo_ativo) || !isset($nome_modulo_ativo)){
    $icon_modulo_ativo="";
    $nome_modulo_ativo="";
}
$layout=str_replace("_icon_", $icon_modulo_ativo, $layout);
$layout=str_replace("_nome_modulo_", $nome_modulo_ativo, $layout);

if(isset($_GET['in_iframe']) && $_GET['in_iframe']==1){
    $layout=str_replace("_hideAdmin_","hidden",$layout);
    $layout=str_replace('id="headerPrincipal"','id="headerPrincipal" style="left: 0px;display:none"',$layout);
    $layout=str_replace('id="main-container"','id="main-container" style="margin-left: 0px"',$layout);
    $layout=str_replace('id="sidebar"','id="sidebar" style="display: none"',$layout);
    $layout=str_replace('id="page-content" class=""','id="page-content" class="sem_margens"',$layout);
    $layout=str_replace('class="content-header"','class="content-header hidden"',$layout);
    $layout=str_replace('_inIframe_','1',$layout);
}else{
    $layout=str_replace('_inIframe_','0',$layout);
}

if(isset($id)){
    $layout=str_replace('_idItem_',$id,$layout);
}

if(isset($admin)){
    if($admin==0){
        $layout=str_replace('_inputIDempresaParaUsers_',"<input id='id_empresa' type='hidden'>",$layout);
    }else{
        $layout=str_replace('_inputIDempresaParaUsers_',"",$layout);
    }
}

$admin=0;
if(isset($_SESSION['grupos'])){
    if(in_array(1,$_SESSION['grupos']) || in_array(2,$_SESSION['grupos'])){
        $admin=1;
    }
}


if($admin==0){
    $layout=str_replace("_esconderParaFuncionarios_","hidden",$layout);
}else{
    $layout=str_replace("_esconderParaAdmins_","hidden",$layout);
}

if($_SESSION['tecnico']==1){
    $layout=str_replace("[ESCONDER-PARA-TECNICOS]","hidden",$layout);
    $layout=str_replace("[ESCONDER-PARA-ADMINS]","",$layout);
}else{
    $layout=str_replace("[ESCONDER-PARA-TECNICOS]","",$layout);
    $layout=str_replace("[ESCONDER-PARA-ADMINS]","hidden",$layout);
}
if(isset($_SESSION['cfg']['dominio'])){
    $layout=str_replace("[URL-PLATAFORMA]",$_SESSION['cfg']['dominio'],$layout);
}

$layout=str_replace('??&',"&",$layout);
$layout=str_replace('?&',"?",$layout);
//$layout=str_replace('.php&',".php?",$layout);
$layout=str_replace("_nomeAtualizou_","-",$layout);

print $layout;


