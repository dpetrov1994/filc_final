<?php


$mod_mensagens=0;
$mod_notificacoes=1;
$mod_calendario=1;

$addons="";


//ADDON calendario
if($mod_calendario==1){
    if(is_dir("../mod_calendario")){
        $urlCalendario="../mod_calendario/index.php";
    }else{
        $urlCalendario="mod_calendario/index.php";
    }

    $addons .= '<li class=" ">
                        <a href="'.$urlCalendario.'" >
                            <i class="gi gi-calendar"></i>
                        </a>
                        
                    </li>';
}


//ADDON MENSAGENS
if($mod_mensagens==1){
    $sql="select count(id_mensagem) from utilizadores_mensagens where visto_em is NULL and id_utilizador=".$_SESSION['id_utilizador'];
    $result=runQ($sql,$db,"ADDON MENSAGENS");
    while ($row = $result->fetch_assoc()) {
        $total=0;
        if($row['count(id_mensagem)']>0){
            $total="data-badge=\"".$row['count(id_mensagem)']."\"";
        }
    }
    $addons .= '<li class="dropdown " >
                        <a href="javascript:void(0)" onclick="getItensAddon(\'getAddonsMensagens\',\'addonMensagens\')" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="gi gi-envelope addon-badge" '.$total.'></i>
                        </a>
                        <ul  id="addonMensagens" class="dropdown-menu dropdown-menu-right ">
                        </ul>
                    </li>';
}


//ADDON NOTIFICACOES
if($mod_notificacoes==1){
    $sql="select count(id_notificacao) from utilizadores_notificacoes where visto_em is NULL and utilizadores_notificacoes.id_utilizador=".$_SESSION['id_utilizador'];
    $result=runQ($sql,$db,"ADDON NOTS");
    while ($row = $result->fetch_assoc()) {
        $total=0;
        if($row['count(id_notificacao)']>0){
            $total="data-badge=\"".$row['count(id_notificacao)']."\"";
        }
    }
    $addons .= '<li class="dropdown " >
                        <a href="javascript:void(0)" onclick="getItensAddon(\'getAddonsNotificacoes\',\'addonNotificacoes\')" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="gi gi-bell addon-badge" '.$total.'></i>
                        </a>
                        <ul  id="addonNotificacoes" class="dropdown-menu dropdown-menu-right ">
                        </ul>
                    </li>';
}


$_SESSION['addons']=$addons;
