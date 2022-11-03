<?php

if(is_file("login/lock.php")){
    $lockFile="login/lock.php";
}elseif(is_file("../login/lock.php")){
    $lockFile="../login/lock.php";
}elseif(is_file("lock.php")){
    $lockFile="lock.php";
}

if(is_file("login/sair.php")){
    $logoutFile="login/sair.php";
}elseif(is_file("../login/sair.php")){
    $logoutFile="../login/sair.php";
}elseif(is_file("sair.php")){
    $logoutFile="sair.php";
}

//perfil
if(is_file("mod_perfil/alterar_pass.php")){
    $alterarPass="mod_perfil/alterar_pass.php";
}elseif(is_file("../mod_perfil/alterar_pass.php")){
    $alterarPass="../mod_perfil/alterar_pass.php";
}elseif(is_file("alterar_pass.php")){
    $alterarPass="alterar_pass.php";
}

if(is_file("mod_perfil/alterar_foto.php")){
    $alterarFoto="mod_perfil/alterar_foto.php";
}elseif(is_file("../mod_perfil/alterar_foto.php")){
    $alterarFoto="../mod_perfil/alterar_foto.php";
}elseif(is_file("alterar_foto.php")){
    $alterarFoto="alterar_foto.php";
}

if(is_file("mod_perfil/index.php")){
    $perfilUrl="mod_perfil/index.php";
}elseif(is_file("../mod_perfil/index.php")){
    $perfilUrl="../mod_perfil/index.php";
}elseif(is_file("index.php")){
    $perfilUrl="index.php";
}else{
    $perfilUrl="#";
}

if(is_file("mod_perfil/alterar_email.php")){
    $alterarEmail="mod_perfil/alterar_email.php";
}elseif(is_file("../mod_perfil/alterar_email.php")){
    $alterarEmail="../mod_perfil/alterar_email.php";
}elseif(is_file("index.php")){
    $alterarEmail="index.php";
}else{
    $alterarEmail="#";
}

if(is_file("mod_perfil/servicos.php")){
    $verServicos="mod_perfil/servicos.php";
}elseif(is_file("../mod_perfil/servicos.php")){
    $verServicos="../mod_perfil/servicos.php";
}elseif(is_file("index.php")){
    $verServicos="index.php";
}else{
    $verServicos="#";
}

if(is_file("mod_recibos/index.php")){
    $verRecibos="mod_recibos/index.php";
}elseif(is_file("../mod_recibos/index.php")){
    $verRecibos="../mod_recibos/index.php";
}elseif(is_file("index.php")){
    $verRecibos="index.php";
}else{
    $verRecibos="#";
}
    $userDropdown = '
<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
    <img id="profilePicURL" src="_fotoUtilizador_" alt="avatar">
</a>
<ul class="dropdown-menu dropdown-menu-right">
    <li class="dropdown-header">
        <strong>_nomeUtilizador_</strong>
    </li>
    <li>
        <a href="_alterarFotoUrl_">
            <i class="fa fa-picture-o fa-fw pull-right"></i>
            Alterar foto de perfil
        </a>
    </li>
    <li>
        <a href="_alterarPassUrl_">
            <i class="fa fa-lock fa-fw pull-right"></i>
            Alterar Palavra-passe
        </a>
    </li>
        <li>
        <a href="_alterarEmailUrl_">
            <i class="fa fa-envelope-o fa-fw pull-right"></i>
            Alterar email
        </a>
    </li>
    <li class="divider"><li>
    <li>
        <a href="_logoutFile_">
            <i class="gi gi-log_out fa-fw pull-right"></i>
            Sair
        </a>
    </li>
</ul>';