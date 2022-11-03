<?php
include ('../_template.php');
$content=file_get_contents("index.tpl");
$layout=str_replace("sidebar-visible-lg-full","sidebar-visible-lg-mini",$layout);
$layout=str_replace("content-header","content-header hidden",$layout);

/**  FILTROS ADICIONAIS */

$formCriar='<div class="text-center"><h3 class="text-muted"> Não tem acesso a esta funcionalidade</h3></div>';
foreach ($_SESSION['modulos'] as $modulo){
    if($modulo['url']=='mod_assistencias'){
        foreach ($modulo['funcionalidades'] as $funcionalidade){
            if($funcionalidade['url']=="criar.php" and $funcionalidade['disponivel']==1){
                $formCriar='<form id="form-para-validar"  class="form-horizontal form-bordered" action="../mod_assistencias/criar.php" method="post" enctype="multipart/form-data">
                  <div class="form-group form-group-sm">
                    <div class="col-xs-6 col-md-6">
                        <label class="col-lg-12" >Nome do agendamento  </label>
                        <div class="col-lg-12 input-status">
                            <input id="nome_agenda" name="nome_agenda" maxlength="250"  class="form-control" placeholder=""  type="text">
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-6">
                        <label class="col-lg-12" >Cor (no calendário)</label>
                        <div class="col-lg-12 input-status">
                            <div class="input-group input-colorpicker colorpicker-element">
                                <input id="cor" name="cor" class="form-control" value="#5ccdde" type="text">
                                <span class="input-group-addon"><i style="background-color: #5ccdde;"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">


                    <div class="col-xs-12">
                        <label class="col-lg-12" >Data limite</label>
                        <div class="col-lg-12 input-status">
                            <input id="data_fim" name="data_fim" required type="date" class=" form-control">
                        </div>
                    </div>
                    
                    
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <label class="col-lg-12" >Descrição </label>
                        <div class="col-lg-12">
                            <textarea id="descricao" rows="10" name="descricao" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                    

                    <button type="submit" id="submeter_form" name="submit" class="btn btn-effect-ripple btn-primary pull-right hidden"></button>
                </form>';



            }
        }
    }
}
$content=str_replace("_formCriar_",$formCriar,$content);
include "../mod_assistencias/_criar_editar_detalhes.php";
/** fFIM FILTROS ADICIONAIS */


$script="<script>
var id_utilizador='".$_SESSION['id_utilizador']."';
</script>
";
$pageScript="<script src=\"$layoutDirectory/js/full-calendar-pt.js\"></script>".$script."<script src=\"index.js\"></script>";
include ('../_autoData.php');