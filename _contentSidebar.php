<?php

$timeouts=[
    "1"=>"1 minuto",
    "5"=>"5 minutos",
    "10"=>"10 minutos",
    "30"=>"30 minutos",
    "60"=>"1 hora",
    "120"=>"2 horas",
    "300"=>"5 horas"
];

$ops="";
$tempoLock=$_SESSION['cfg_tempo_lock']/1000/60;
foreach ($timeouts as $val=>$nome){
    $selected="";
    if($tempoLock==$val){
        $selected="selected";
    }
    $ops.="<option $selected value='$val'>$nome</option>";
}

$notEmail='';
if($_SESSION['receber_not_email']==1){
    $notEmail='checked=""';
}

$notSms='';
if($_SESSION['receber_not_sms']==1){
    $notSms='checked=""';
}

$mostrarEmail='';
if($_SESSION['mostrar_email']==1){
    $mostrarEmail='checked=""';
}

$mostrarContacto='';
if($_SESSION['mostrar_contacto']==1){
    $mostrarContacto='checked=""';
}

$mostrarMorada='';
if($_SESSION['mostrar_morada']==1){
    $mostrarMorada='checked=""';
}
$contentSidebar="
<div class=\"sidebar-section\">
    <h2 class=\"text-light\">Opções</h2>
    <label class='text-light-op'>Bloquear sessão após:</label>
    <select class='select-select2' style='width: 100%' id='alterarTempoLock'>
        $ops
    </select>
    <hr>
   
    <div class=\"form-group\">
          <label class=\"col-xs-7 control-label-fixed\">Receber notificações no email.</label>
          <div class=\"col-xs-5\">
              <label class=\"switch switch-primary\"><input onchange='cfguser(this)' id='receber_not_email' $notEmail type=\"checkbox\"><span></span></label>
          </div>
    </div>
    <!--
    <div class=\"form-group\">
          <label class=\"col-xs-7 control-label-fixed\">Receber notificações por sms.</label>
          <div class=\"col-xs-5\">
              <label class=\"switch switch-primary\"><input onchange='cfguser(this)' id='receber_not_sms' $notSms type=\"checkbox\"><span></span></label>
          </div>
    </div>
    <h2 class=\"text-light\">Perfil</h2>
         <div class=\"form-group\">
              <label class=\"col-xs-7 control-label-fixed\">Mostrar o meu email</label>
              <div class=\"col-xs-5\">
                 <label class=\"switch switch-primary\"><input onchange='cfguser(this)' id='mostrar_email' $mostrarEmail type=\"checkbox\"><span></span></label>
              </div>
         </div>
         <div class=\"form-group\">
              <label class=\"col-xs-7 control-label-fixed\">Mostrar o meu contacto</label>
              <div class=\"col-xs-5\">
                 <label class=\"switch switch-primary\"><input onchange='cfguser(this)' id='mostrar_contacto' $mostrarContacto type=\"checkbox\"><span></span></label>
              </div>
         </div>
         <div class=\"form-group\">
              <label class=\"col-xs-7 control-label-fixed\">Mostrar a minha morada</label>
              <div class=\"col-xs-5\">
                 <label class=\"switch switch-primary\"><input onchange='cfguser(this)' id='mostrar_morada' $mostrarMorada type=\"checkbox\"><span></span></label>
              </div>
         </div>
         -->
</div>
 ";

